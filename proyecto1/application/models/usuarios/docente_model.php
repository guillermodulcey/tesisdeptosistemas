<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
    }

    public function gestion_docente() {
        $crud = new grocery_CRUD();
        $crud->set_table('usuario')->set_subject('Docente');
        $crud->set_relation_n_n('Roles', 'usuario_rol', 'rol', 'USU_CODIGO', 'ROL_CODIGO', 'ROL_NOMBRE');

        /* columnas a mostrar */
        $crud->columns('USU_NOMBRE', 'USU_APELLIDO', 'email', 'USU_ESTADO', 'Roles');
        $crud->fields('USU_CODIGO', 'USU_NOMBRE', 'USU_APELLIDO', 'email', 'contrasena', 'USU_ESTADO', 'Roles');

        /* campos en add */
        $crud->add_fields('USU_CODIGO', 'USU_NOMBRE', 'USU_APELLIDO', 'email', 'contrasena', 'USU_ESTADO');

        /* campos en edit */
        $crud->edit_fields('USU_CODIGO', 'USU_NOMBRE', 'USU_APELLIDO', 'email', 'USU_ESTADO', 'Roles');

        /* Los nombres de los campos */
        $crud->display_as('USU_NOMBRE', 'Nombre');
        $crud->display_as('USU_APELLIDO', 'Apellido');
        $crud->display_as('email', 'Email');
        $crud->display_as('contrasena', 'Contraseña');
        $crud->display_as('USU_ESTADO', 'Estado');
        //$crud->display_as('USU_ROL', 'Rol');

        /* Campos requeridos */
        $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'email', 'contrasena');
        //$crud->set_rules('Roles','Roles','required');
        //$crud->set_rules('USU_ESTADO','Estado','required');

        /* Campos unicos */
        //$crud->unique_fields('email');

        /* Tipo de campo */
        $crud->field_type('contrasena', 'password');
        $crud->field_type('USU_ESTADO', 'enum', array('activo', 'inactivo'));
        //$crud->field_type('USU_ROL', 'enum', array('jefe de departamento', 'docente', 'administrador'));
        $crud->field_type('USU_CODIGO', 'hidden', '');
        $crud->callback_column('email', array($this, 'custom_email'));

        /* Edit vs Add */
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();

        if ($state == 'add') {
            $crud->field_type('USU_ESTADO', 'hidden', 'activo');
            $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'email', 'contrasena');
            $crud->callback_add_field('email', array($this, 'email_add'));
        } elseif ($state == 'edit') {
            $primary_key = $state_info->primary_key;
            $crud->field_type('contrasena', 'invisible');
            $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'email', 'contrasena', 'USU_ESTADO', 'Roles');
            $crud->callback_edit_field('email', array($this, 'email_edit'));
        }
        else{
            $crud->callback_field('email', array($this, 'email_view'));
        }

        $crud->callback_before_insert(array($this, 'llenar_2_tablas'));
        $crud->callback_before_update(array($this, 'editar_2_tablas'));

        $output = $crud->render();
        return $output;
    }

    function llenar_2_tablas($post_array) {
        $user_name = $post_array['email'];
        $email = $user_name . "@unicauca.edu.co";
        $contrasena = $post_array['contrasena'];
        $email_activation = false;

        $this->tank_auth->create_user($user_name, $email, $contrasena, $email_activation);

        $codigo = $this->dao->get_codigo_usuario($email);

        $usuario_rol_insert = array(
            "USU_CODIGO" => $codigo,
            "ROL_CODIGO" => 3
        );
        $this->db->insert("usuario_rol", $usuario_rol_insert);

        $post_array['USU_CODIGO'] = $codigo;

        unset($post_array['email']);
        unset($post_array['contrasena']);
        return $post_array;
    }

    function editar_2_tablas($post_array, $primary_key) {
        $user_name = $post_array['email'];
        $email = $user_name . "@unicauca.edu.co";        
        
        $this->db->where('id',$primary_key);
        $users_info = $this->db->get('users')->row();
        
        $users_info->email = $email;
        $users_info->username = $user_name;
        
        $codigo = $this->dao->get_codigo_usuario($email);
        $this->db->where('id', $codigo);
        $this->db->update('users', $users_info);                

        unset($post_array['email']);
        unset($post_array['contrasena']);
        return $post_array;
    }
    
    public function email_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = $this->dao->get_email_usuario($llave);        
        $value = $consulta;
        return '<div id="field-Email" class="readonly_label">' . $value . '</div>';
    }
    
    public function custom_email($value, $row) {
        $resultado = '';
        $llave = $row->USU_CODIGO;
        $consulta = $this->dao->get_email_usuario($llave);
        $resultado = $consulta;
        return $resultado;
    }
    
    public function email_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = $this->dao->get_login_usuario($llave);        
        $value = $consulta;
        return '<input type="text" maxlenght="100" value="' . $value . '" name="email">'."@unicauca.edu.co";
    }
    
    public function email_add($value = "", $primary_key) {        
        return '<input type="text" maxlenght="100" value="" name="email">'."@unicauca.edu.co";
    }
}
