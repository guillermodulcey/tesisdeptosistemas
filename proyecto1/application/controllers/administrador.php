<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrador extends CI_Controller {
    
    public $STR_INDEX = "administrador/home";

    function __construct() {
        parent::__construct();
        $this->load->model('administrador_model', 'administrador');
        $this->load->model('seguridad_model', 'seguridad');
    }

    public function tmp($func = 'index') {
        if ($this->seguridad->es_administrador()) {
            $this->$func();
        } else {
            show_404();
        }
    }

    private function index() {
        $this->data['vistas'] = array('administrador/home');
        $this->load->view('home', $this->data);
    }

    private function redirect() {
        redirect('/administrador/tmp/index');
    }

    private function crear_usuario() {
        $this->load->database();
        $this->load->model('administrador_model', 'administrador');
        $this->load->view('administrador/');
    }

    private function validar_formulario_crear_usuario() {
        $this->load->view('administrador/crear_usuario');
    }

    private function docentes() {
        $this->load->model('docente_model', 'docente');
        $output = $this->docente->gestion_docente();
        $this->_docentes_output($output);
        $this->data['vistas'] = array('administrador/docentes');
        $this->load->view('home', $this->data);
    }

    private function _docentes_output($output = null) {
        $this->load->view('administrador/docentes.php', $output);
    }
}
