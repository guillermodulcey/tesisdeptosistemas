<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produccion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('producciones/produccion_model', 'produccion');
    }

    function listar() {
        $this->pagination->base_url = site_url("produccion/listar");
        $this->pagination->total_rows = $this->produccion->producciones_count();
        $this->pagination->per_page = 3;
        $this->pagination->uri_segment = 3;
        $choice = $this->pagination->total_rows / $this->pagination->per_page;
        $this->pagination->num_links = round($choice);
        $this->pagination->initialize();

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $start = ($page > 0) ? ($page - 1) * $this->pagination->per_page : 0;

        $data["results"] = $this->produccion->obtener_producciones($this->pagination->per_page, $start);
        $data["links"] = $this->pagination->create_links();
        $vista = array('view' => 'produccion/listar_items', 'vars' => $data);
        return $vista;
    }

    function ver_detalle($PROD_CODIGO) {
        $produccion = $this->produccion->obtener_produccion($PROD_CODIGO);
        $vista = array('view' => 'produccion/detallado',
            'vars' => array('produccion' => $produccion));
        $data['vistas'] = array($vista);
        $this->load->view('home', $data);
    }

}
