<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jefe_Departamento extends CI_Controller {

    public $STR_INDEX = "jefe_departamento/home";

    function __construct() {
        parent::__construct();
        if ($this->seguridad_model->es_jefe()) {
            $this->load->model('usuarios/docente_model', 'docente');
            $this->load->model('usuarios/jefe_departamento_model', 'jefe_departamento');
        } else {
            show_404();
            die();
        }
    }

    public function index() {
        $roles = $this->seguridad_model->roles();
        $vistas = array();
        foreach ($roles as $key => $value) {
            $vista = array(
                'view' => $roles[$key] . '/home',
                'vars' => ''
            );
            array_push($vistas, $vista);
        }
        $this->data['vistas'] = $vistas;
        $this->load->view('home', $this->data);
    }

}
