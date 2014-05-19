<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_edit extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->lang->load('tank_auth');
        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
        
        $this->load->config('tank_auth', TRUE);
    }
    public function editar_docente($codigo) {        
        $crud = new grocery_CRUD();
        $crud->set_table("usuario");
        
        $crud->fields('USU_CODIGO','USU_NOMBRE', 'USU_APELLIDO', /*'email',*/ 'contrasena','verify_password');
        
        $crud->display_as('USU_NOMBRE', 'Nombre');
        $crud->display_as('USU_APELLIDO', 'Apellido');
        $crud->display_as('email', 'Email');
        $crud->display_as('contrasena', 'Contraseña');
        $crud->display_as('verify_password', 'Confirme Contraseña');
        
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_list();
        $crud->unset_back_to_list();
        
        $crud->field_type('contrasena', 'password');
        $crud->field_type('verify_password', 'password');
        
        $crud->set_rules('verify_password', 'Verify Password', 'required|matches[contrasena]');
        
        $crud->field_type('USU_CODIGO', 'hidden', $codigo);        
        
        $state_code = $crud->getState();
        if($state_code == 'unknown' || $state_code == 'list'){
            redirect("usuario/editar_datos/edit/".$codigo);
        }
        
        $segment_object = $crud->getStateInfo();
        $primary_key = $segment_object->primary_key;
        if($primary_key != $codigo) {
            show_error("Lo sentimos no esta autorizado a entrar a esta página.");
        }
        $crud->callback_before_update(array($this, 'editar_2_tablas'));
        $output = $crud->render();
        return $output;
    }
    function editar_2_tablas($post_array, $primary_key){
        require_once('/application/libraries/phpass-0.1/PasswordHash.php');
        
        $hasher = new PasswordHash(
            $this->config->item('phpass_hash_strength', 'tank_auth'),
            $this->config->item('phpass_hash_portable', 'tank_auth'));
        $hashed_password = $hasher->HashPassword($post_array['contrasena']);
        
        $this->db->where('id',$primary_key);
        
        $user = $this->db->get('users')->row();
        $user->password = $hashed_password;
        //$user->username = $post_array['email'];        
        //$user->email = $user->username.'@unicauca.edu.co';
        
        $this->db->where('id',$primary_key);
        $this->db->update('users',$user);
        
        unset($post_array['contrasena']);
        unset($post_array['verify_password']);
        //unset($post_array['email']);
        return $post_array;
    }
}        
?>
