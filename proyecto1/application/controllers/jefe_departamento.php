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
            $this->load->model('usuarios/graficas', 'graficar');
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
        $this->load->view('jefe_departamento/menu_jefe');
    }
    
    public function estadisticas_usuario(){
        $persona = $this->input->post('login');
        $this->graficar->graficar_barras_persona($persona);
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'jefe_departamento/grafica_persona',
            'vars' => ''
        );
        $this->data['vistas'] = array($vista, $vista2);
//        $this->load->view('jefe_departamento/grafica_persona');
        $this->load->view('home', $this->data);
    }
    
    public function estadisticas(){    
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'jefe_departamento/form_estadisticas',
            'vars' => ''
        );
        $this->data['vistas'] = array($vista, $vista2);
//        $this->load->view('jefe_departamento/form_estadisticas');
        $this->load->view('home', $this->data);
    }

}
