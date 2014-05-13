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
            'vars' => '');
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

    public function producciones() {
        $vista = array(
            'view' => 'docente/producciones',
            'vars' => '');
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

    public function monografia() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_monografia($codigo);
        $vista = array(
            'view' => 'docente/monografia',
            'vars' => $output);
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

    public function articulo() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_articulo($codigo);
        $vista = array(
            'view' => 'docente/articulo',
            'vars' => $output);
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

    public function reporte() {
        $email = $this->session->userdata('username');
        $email = $email . "@unicauca.edu.co";
        $codigo = $this->dao->get_codigo_usuario($email);
        $output = $this->produccion->gestion_reporte($codigo);
        $vista = array(
            'view' => 'docente/reporte',
            'vars' => $output);
        $this->data['vistas'] = array($vista);
        $this->load->view('home', $this->data);
    }

}
