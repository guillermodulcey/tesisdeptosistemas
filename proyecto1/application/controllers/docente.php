<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente extends CI_Controller {

    public $STR_INDEX = "docente/home";

    function __construct() {
        parent::__construct();
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('produccion_model');


        $this->load->model('docente_model', 'docente');
        $this->load->model('seguridad_model', 'seguridad');
        $this->load->model('dao_model', 'dao');
    }

    public function tmp($func = 'index') {
        if ($this->seguridad->es_docente()) {
            $this->$func();
        } else {
            show_404();
        }
    }

    private function index() {
        $this->data['vistas'] = array('docente/home');
        $this->load->view('home', $this->data);
    }

    private function redirect() {
        redirect('/docente/tmp/index');
    }

    private function producciones() {
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

    private function _producciones_output() {
        $this->load->view('docente/producciones.php');
    }

    private function _monografia_output($output = null) {
        $this->load->view('docente/monografia.php', $output);
    }

}
