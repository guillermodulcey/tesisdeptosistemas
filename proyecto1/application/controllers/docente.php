<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'produccion.php';

class Docente extends CI_Controller {

    public $STR_INDEX = "docente/home";

    function __construct() {
        parent::__construct();
      //  $this->load->library('jpgraph');
        if ($this->seguridad_model->es_docente()) {
            $this->load->model('producciones/produccion_model', 'produccion');
            $this->load->model('usuarios/docente_model', 'docente');
            $this->load->model('sistema/dao_model', 'dao');
            $this->load->model('usuarios/graficas', 'graficar');
        } else {
            show_404();
            die();
        }
    }

    public function index() {
        $vista_home = array(
            'view' => 'docente/home',
            'vars' => '');
        $prod = new Produccion();
        $vista_prod = $prod->listar(2);
        $this->data['vistas'] = array($vista_home, $vista_prod);
        $this->load->view('home', $this->data);
    }

    public function producciones() {
        $vista = array(
            'view' => 'docente/producciones',
            'vars' => '');
        $vista2 = array(
            'view' => 'docente/home',
            'vars' => ""
        );        
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    public function monografia() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_monografia($codigo);
        $vista = array(
            'view' => 'docente/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'docente/monografia',
            'vars' => $output
        );
        $this->data['bandera'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    public function articulo() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_articulo($codigo);        
        $vista = array(
            'view' => 'docente/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'docente/articulo',
            'vars' => $output
        );
        $this->data['bandera'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    public function reporte() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_reporte($codigo);        
        $vista = array(
            'view' => 'docente/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'docente/reporte',
            'vars' => $output
        );
        $this->data['bandera'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    public function _producciones_output() {
        $this->load->view('docente/producciones.php');
    }

    public function _monografia_output($output = null) {
        $this->load->view('docente/monografia.php', $output);
    }

    public function _articulo_output($output = null) {
        $this->load->view('docente/articulo.php', $output);
    }

    public function _reporte_output($output = null) {
        $this->load->view('docente/reporte.php', $output);
    }
    
    public function estadisticas(){
        $this->graficar->graficar_barras_grupos();
        $this->load->view('docente/grafica_grupos');
    }

}
