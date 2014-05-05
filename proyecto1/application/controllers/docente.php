<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente extends CI_Controller {

    public $STR_INDEX = "docente/home";

    function __construct() {
        parent::__construct();
        if ($this->seguridad_model->es_docente()) {
            $this->load->model('producciones/produccion_model');
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

        $produccion = new Produccion_model();

        $output = $produccion->gestion_monografia($codigo);

        $this->_monografia_output($output);
    }

    public function _producciones_output() {
        $this->load->view('docente/producciones.php');
    }

    public function _monografia_output($output = null) {
        $this->load->view('docente/monografia.php', $output);
    }

}
