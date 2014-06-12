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
            $this->load->model('sistema/graficas', 'graficas');
            $this->load->library('table');
        } else {
            show_404();
            die();
        }
    }

    public function index() {
        $roles = $this->seguridad_model->roles();
        $vistas = array();
        $vista2 = array(
            'view' => 'jefe_departamento/home',
            'vars' => ''
        );
        $output = $this->docente->gestion_docente();
        $vista3 = array(
            'view' => 'administrador/docentes.php',
            'vars' => $output
        );
//        foreach ($roles as $key => $value) {
//            $vista = array(
//                'view' => $roles[$key] . '/home',
//                'vars' => ''
//            );
//            array_push($vistas, $vista);
//        }
//      $this->data['vistas'] = $vistas;
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista2, $vista3);
        $this->load->view('home', $this->data);
    }

    public function estadisticas_usuario() {
        $persona = $this->input->post('login');
        $this->graficas->graficar_barras_persona($persona);
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'jefe_departamento/grafica_persona',
            'vars' => ''
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
//        $this->load->view('jefe_departamento/grafica_persona');
        $this->load->view('home', $this->data);
    }

    public function estadisticas() {
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'jefe_departamento/form_estadisticas',
            'vars' => ''
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
//        $this->load->view('jefe_departamento/form_estadisticas');
        $this->load->view('home', $this->data);
    }

    public function docentes() {
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ''
        );
        $this->load->model('usuarios/docente_model', 'docente');
        $output = $this->docente->gestion_docente();
        $vista2 = array(
            'view' => 'administrador/docentes.php',
            'vars' => $output);
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
        $this->load->view('administrador/menu_admin');
    }

    /**
     * Reportes del jefe de departamento
     * Obtener la informacion relativa a produccione dado un docente.
     */
    public function reporte_docente() {
        $username = $this->input->post('login');
        $tabla = null;
        if ($username) {
            $this->graficas->graficar_prod_docente($username);
            $tabla = $this->graficas->query_prod_docente($username);
        }
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_docente',
            'vars' => array('username' => $username,
                'tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    /**
     * Obtener la informacion de producciones de docentes entre un rago de fechas especificos
     */
    public function reporte_docente_fecha() {
        $username = $this->input->post('login');
        $fini = $this->input->post('fini');
        $ffin = $this->input->post('ffin');

        $tabla = null;
        if ($username) {
            $this->graficas->graficar_prod_docente_fecha($username, $fini, $ffin);
            $tabla = $this->graficas->query_prod_docente($username, $fini, $ffin);
        }
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_docente_fecha',
            'vars' => array(
                'username' => $username,
                'fini' => $fini,
                'ffin' => $ffin,
                'tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    /**
     * obtener la informacion de todos los docentes listados en una tabla
     * con el consolicdado de producciones
     */
    public function reporte_docente_total() {
        $tabla = $this->graficas->query_prod_docente_total();
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_docente_total',
            'vars' => array('tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    /**
     * Reportes del jefe de departamento
     * Obtener la informacion relativa a produccione dado un grupo de investifacion.
     */
    public function reporte_grupo() {
        $grupo = $this->input->post('grupo');
        $tabla = null;
        if ($grupo) {
            $this->graficas->graficar_prod_grupo($grupo);
            $tabla = $this->graficas->query_prod_grupo($grupo);
        }
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_grupo',
            'vars' => array('grupo' => $grupo,
                'tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    /**
     * obtener informacion de un grupo de investigacion a partir de un rango de fechas
     */
    public function reporte_grupo_fecha() {
        $grupo = $this->input->post('grupo');
        $fini = $this->input->post('fini');
        $ffin = $this->input->post('ffin');

        $tabla = null;
        if ($grupo) {
            $this->graficas->graficar_prod_grupo_fecha($grupo, $fini, $ffin);
            $tabla = $this->graficas->query_prod_grupo($grupo, $fini, $ffin);
        }
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_grupo_fecha',
            'vars' => array(
                'grupo' => $grupo,
                'fini' => $fini,
                'ffin' => $ffin,
                'tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

    /**
     * obtener el consolidado de los grupos de investigacaion
     */
    public function reporte_grupo_total() {
        $tabla = $this->graficas->query_prod_grupo_total();
        $vista = array(
            'view' => 'jefe_departamento/home',
            'vars' => ""
        );
        $vista2 = array(
            'view' => 'reporte/reporte_grupo_total',
            'vars' => array('tabla' => $tabla)
        );
        $this->data['bandera'] = false;
        $this->data['bandera1'] = false;
        $this->data['vistas'] = array($vista, $vista2);
        $this->load->view('home', $this->data);
    }

}
