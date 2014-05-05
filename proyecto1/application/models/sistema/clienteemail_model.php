<?php

class Clienteemail_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function enviar_contrasena($email, $password) {
        $this->load->library('email');
        $this->email->from('test_webmaster@wfpc92.tk', 'Sitio web de Tesis Depto Sistemas');
        $this->email->to($email);
        $this->email->subject('recordatorio contraseña');
        $this->email->message(
                'tu contraseña es: <b>' . $password . '</b>'
        );
        if($this->email->send())
            return TRUE;
        return FALSE;
        
    }

}


?>

