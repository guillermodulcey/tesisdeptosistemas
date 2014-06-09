<?php

class Clienteemail_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
    }

    public function enviar_contrasena($email, $password) {
        $this->email->from('test_webmaster@wfpc92.tk', 'Sistema de Producciones Depto Sistemas');
        $this->email->to($email);
        $this->email->subject('recordatorio contraseña');
        $this->email->message(
                'tu contraseña es: <b>' . $password . '</b>'
        );
        if ($this->email->send())
            return TRUE;
        return FALSE;
    }

    public function enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario) {
        $this->email->from('test_webmaster@wfpc92.tk', 'Sistema de Producciones Depto Sistemas');
        $this->email->to($email_autor);
        $this->email->subject("$nombre_usuario te envio un mensaje Sistema Producciones Depto Sistemas");
        $this->email->message(
                "<h2>Te han contactado desde el Sistema de Producciones Depto Sistemas Unicauca</h2>
                    <br/><br/><br/>
                    $nombre_usuario te ha enviado el siguiente mensaje:
                        <br/><br/><br/>
                        $mensaje_usuario
                            <br/><br/><br/>
                            Puedes responderle su mensaje en esta direccion de correo: $email_usuario
                                <br/><br/><br/>
                                <center>Este mensaje fue enviado desde proyecto1.wfpc92.tk.</center>");
        if ($this->email->send())
            return TRUE;
        return FALSE;
    }

}
