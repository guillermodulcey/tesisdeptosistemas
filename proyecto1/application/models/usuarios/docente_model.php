<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente_model extends CI_Model {
    
    var $codigo;
    
    function __construct() {
        parent::__construct();
    }

    public function gestion_docente() {
        $this->lang->load('form_validation','spanish');
        $this->load->library('grocery_CRUD');
        $this->load->database();
        $crud = new grocery_CRUD();
        $crud->set_table('usuario')->set_subject('Docente');
        $crud->set_relation_n_n('Roles', 'usuario_rol', 'rol', 'USU_CODIGO', 'ROL_CODIGO', 'ROL_NOMBRE');

        /* columnas a mostrar */
        $crud->columns('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_ESTADO','Roles');
        $crud->fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_CONTRASENA', 'USU_ESTADO','Roles');

        /* campos en add */
        $crud->add_fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_CONTRASENA', 'USU_ESTADO');

        /* campos en edit */
        $crud->edit_fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_ESTADO','Roles');

        /* Los nombres de los campos */
        $crud->display_as('USU_NOMBRE', 'Nombre');
        $crud->display_as('USU_APELLIDO', 'Apellido');
        $crud->display_as('USU_EMAIL', 'Email');
        $crud->display_as('USU_CONTRASENA', 'Contraseña');
        $crud->display_as('USU_ESTADO', 'Estado');
        //$crud->display_as('USU_ROL', 'Rol');

        /* Campos requeridos */
        $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_CONTRASENA');
        $crud->set_rules('USU_EMAIL','Email','required|valid_email');
        $crud->set_rules('Roles','Roles','required');
        $crud->set_rules('USU_ESTADO','Estado','required');
        
        /* Campos unicos */
        $crud->unique_fields('USU_EMAIL');

        /* Tipo de campo */
        $crud->field_type('USU_CONTRASENA', 'password');
        $crud->field_type('USU_ESTADO', 'enum', array('activo', 'inactivo'));
        //$crud->field_type('USU_ROL', 'enum', array('jefe de departamento', 'docente', 'administrador'));

        /* Edit vs Add */
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();

        if ($state == 'add') {
            $crud->field_type('USU_ESTADO', 'hidden', 'activo');
            $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_CONTRASENA');
        } elseif ($state == 'edit') {
            $primary_key = $state_info->primary_key;
            $crud->field_type('USU_CONTRASENA', 'invisible');
            $crud->required_fields('USU_NOMBRE', 'USU_APELLIDO', 'USU_EMAIL', 'USU_CONTRASENA', 'USU_ESTADO', 'Roles');
        }
        else{
            
        }
        
        $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
        
        $crud->callback_after_insert(array($this, 'docente_rol_predeterminado'));

        $output = $crud->render();
        return $output;
    }

    function encrypt_password_callback($post_array, $primary_key = null) {        
        $key = 'super-secret-key';

        $hash = hash_init('md5', HASH_HMAC, $key);
        hash_update($hash, $post_array['USU_CONTRASENA']);
        $hash = hash_final($hash);

        $post_array['USU_CONTRASENA'] = $hash;        
        return $post_array;
    }
    
    function docente_rol_predeterminado($post_array, $primary_key){
        $usuario_rol_insert = array(
            "USU_CODIGO" => $primary_key,
            "ROL_CODIGO" => 3
        );
        $this->db->insert("usuario_rol",$usuario_rol_insert);
        return true;
    }

}