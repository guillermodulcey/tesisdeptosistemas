<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include 'administrador.php';
include 'docente.php';
include 'jefe_departamento.php';

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model', 'usuario');
        $this->load->model('dao_model', 'dao');
    }

    public function index() {
        $data['iniciar_sesion'] = (true ? 'iniciar_sesion' : 'perfil');
        $this->load->view('home', $data);
    }

    public function vista_login() {
        $data['vistas'] = array('login');
        $this->load->view('home', $data);
    }

    /*     * *
     * Recibe email y password, verifica con la seguridad y crea una cookie
     * para establecer comunicacion cliente servidor.
     */

    public function login() {
        $this->usuario->email = isset($_POST['email']) ? $_POST['email'] : '';
        $this->usuario->password = isset($_POST['password']) ? $_POST['password'] : '';
        $datos_validos = $this->seguridad->datos_validos($this->usuario->email, $this->usuario->password);
        $controller = NULL;
        if ($datos_validos) {
            $this->usuario->tipo_usuario = $this->dao->get_tipo_usuario();
            $this->seguridad->nueva_session($this->usuario);
            switch ($this->usuario->tipo_usuario[0]) {
                case "administrador":
                    $controller = new Administrador();
                    break;
                case "docente":
                    $controller = new Docente();
                    break;
                case "jefe_departamento":
                    $controller = new Jefe_departamento();
                    break;
            }
            $controller->tmp('redirect');
        } else {
            $this->data['summary'] = 'Usuario o contraseña incorrectos';
            $this->data['vistas'] = array('login');
        }
        $this->load->view("home", $this->data);
    }

    public function vista_restablecer_contrasena() {
        $this->data['vistas'] = array('vista_restablecer_contrasena');
        $this->load->view('home', $this->data);
    }

    public function restablecer_contrasena() {
        $email = $this->usuario->email;
        echo $email;
        $password = $this->dao->get_contrasena_usuario();
        if ($password) {
            $this->load->model('clienteemail_model', 'email');
            $this->email->enviar_contrasena($email, $password);
            $this->data['email'] = $email;
            echo 'contrasena enviada';
        } else {
            echo 'email no valido, contrasena no enviada';
        }
    }

    public function logout() {
        $this->seguridad->logout();
        $this->data['iniciar_sesion'] = array('iniciar_sesion');
        $this->load->view('home', $this->data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */