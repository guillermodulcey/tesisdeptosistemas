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
        $this->load->model('seguridad_model', 'seguridad');
        $this->load->model('dao_model', 'dao');
        $this->data['title'] = 'homepage';
        $this->data['header'] = 'user/header';
        $this->data['content'] = 'content';
        $this->data['footer'] = 'footer';
    }

    public function index() {
        $data['iniciar_sesion'] = (true ? 'iniciar_sesion' : 'perfil');
        $this->load->view('home', $data);
    }

    
    public function vista_login(){
        $data['login'] = 'login';                
        $this->load->view('home',$data);
    }
    
    
    /*     * *
     * Recibe email y password, verifica con la seguridad y crea una cookie
     * para establecer comunicacion cliente servidor.
     */

    public function login() {
        $this->usuario->email = isset($_POST['email']) ? $_POST['email'] : '';
        $this->usuario->password = isset($_POST['password']) ? $_POST['password'] : '';
        $datos_validos = $this->seguridad->datos_validos();
        $controller = NULL;
        if ($datos_validos) {
            $this->usuario->tipo_usuario = $this->dao->get_tipo_usuario();
            $controller = array();
            foreach ($this->usuario->tipo_usuario as $key => $value) {
                switch ($value) {
                    case "administrador":
                        $controller[$key] = new Administrador();
                        break;
                    case "docente":
                        $controller[$key] = new Docente();
                        break;
                    case "jefe_departamento":
                        $controller[$key] = new Jefe_departamento();
                        break;
                }
            }
        }
        if ($controller != NULL) {
            $this->seguridad->nueva_session($this->usuario);
            $controller[0]->tmp('redirect');
            foreach ($controller as $key => $value) {
                $controller[$key]->tmp('index');
            }
            return;
        }

        if (!$datos_validos || !$controller) {
            $this->data['summary'] = "Email o Contraseña incorrectos.";
        }
        $this->load->view("home", $this->data);
    }

    public function vista_restablecer_contrasena() {
        $this->load->view('vista_restablecer_contrasena');
    }

    public function restablecer_contrasena() {
        $this->load->model('dao_model', 'dao');
        $email = $this->usuario->email;
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
        $this->load->view('home');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */