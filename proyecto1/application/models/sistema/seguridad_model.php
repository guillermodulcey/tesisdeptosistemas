<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Aqui se debe implementar todo lo relacionado a verificacion de datos, 
 * formularios, todo lo relacionado con la seguridad
 * descrito en:
 * http://escodeigniter.com/guia_usuario/general/security.html
 * http://uno-de-piera.com/buenas-practicas-y-consejos-en-codeigniter/
 * http://www.websec.mx/blog/ver/inseguridad-datos-sesion-codeigniter
 * 
 */
class Seguridad_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('sistema/gestorsesiones_model', 'sesion');
    }

    public function nueva_session($usuario) {
        $this->sesion->crear_session($usuario);
    }

    public function datos_validos($email, $password) {
        $this->lang->load('form_validation', 'spanish');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run()) {
            return $this->validar_usuario($email, $password);
        }
        return FALSE;
    }

    public function validar_usuario($email, $password) {
        $contra = $this->dao->get_contrasena_usuario($email);
        if ($contra == $password) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Verifica que el administrador que existe en la base de datos concuerda 
     * validar acceso seguro.
     * con el acceso
     */
    public function es_administrador() {
        return $this->sesion->es_tipo_usuario('administrador') ? TRUE : FALSE;
    }

    public function es_docente() {
        return $this->sesion->es_tipo_usuario('docente') ? TRUE : FALSE;
    }

    public function es_jefe() {
        return $this->sesion->es_tipo_usuario('jefe_departamento') && $this->sesion->es_tipo_usuario('docente') ? TRUE : FALSE;
    }

    public function logout() {
        $this->sesion->logout();
    }

    public function roles() {
        return $this->sesion->roles();
    }
    
    public function get_email(){
        return $this->sesion->get_email();
    }
}

?>
