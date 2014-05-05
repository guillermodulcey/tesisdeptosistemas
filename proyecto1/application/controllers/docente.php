<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente extends CI_Controller {

    public $STR_INDEX = "docente/home";

    function __construct() {
        parent::__construct();
        if ($this->seguridad_model->es_docente()) {
            $this->load->model('producciones/produccion_model', 'produccion');
            $this->load->model('usuarios/docente_model', 'docente');
            $this->load->model('sistema/dao_model', 'dao');
        } else {
            show_404();
            die();
        }
    }

    public function index() {
        $vista = array(
            'view' => 'docente/home',
            'vars' => ''
        );
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

    public function producciones() {
        $this->_producciones_output();
    }

    public function monografia() {
        //$email = $this->seguridad->get_email();
        //$codigo = $this->dao->get_codigo_usuario($email);
        $codigo = 3;
        $output = $this->produccion->gestion_monografia($codigo);
        $vista = array(
            'view' => 'docente/monografia.php',
            'vars' => $output
        );
        $this->data['vistas'] = array($vista); 
        $this->load->view('home', $this->data);  
    }

    public function _producciones_output() {
        $this->load->view('docente/producciones.php');
    }
}
