<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrador extends CI_Controller {
    
    private $limit = 10;
    public $STR_INDEX = "administrador/home";

    function __construct() {
        parent::__construct();
        if ($this->seguridad_model->es_administrador()) {
            $this->load->library(array('table'));
            $this->load->helper('url');            
            $this->load->model('sistema/dao_model','dao');
            $this->load->model('usuarios/administrador_model', 'administrador');
        } else {
            show_404();
            die();
        }
    }

    public function index() {
        $vista = array(
            'view' => 'administrador/home',            
            'vars' => ''
        );
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
        $this->load->view('administrador/menu_admin');
    }

    public function validar_formulario_crear_usuario() {
        $this->load->view('administrador/crear_usuario');
    }
    
    public function docentes() {
        $this->load->model('usuarios/docente_model', 'docente');
        $output = $this->docente->gestion_docente();        
        $vista = array(
            'view' => 'administrador/docentes.php',
            'vars' => $output);
        $this->data['bandera'] = false;
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);         
        $this->load->view('administrador/menu_admin');
    }        
}
