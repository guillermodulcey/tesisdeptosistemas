<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gestorsesiones_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function crear_session($usuario) {
        $newdata = array(
            'email' => $usuario->email,
            'tipo' => $usuario->tipo_usuario
        );
        $this->session->set_userdata($newdata);
    }

    public function logout() {
        $this->session->sess_destroy();
    }

    public function es_tipo_usuario($usuario) {
        $tipo = $this->session->userdata('tipo');
        if ($tipo) {
            foreach ($tipo as $t) {
                if ($t === $usuario) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
    
    public function get_email(){
        return $this->session->userdata('email');
    }

    public function esta_conectado($email) {
        $email_cookie = $this->session->userdata('email');
        return $email == $email_cookie ? TRUE : FALSE;
    }
    
    public function roles(){
        return $this->session->userdata('tipo');
    }
}
