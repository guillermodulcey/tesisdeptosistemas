<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produccion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('producciones/produccion_model', 'produccion');
    }

    public function index($criterio = 1) {
        $vista = $this->listar($criterio);
        $data['vistas'] = array($vista);
        $this->load->view('home', $data);
    }

    public function listar($criterio = 1) {
        $this->pagination->base_url = site_url("produccion/index/" . $criterio . "/");
        $this->pagination->per_page = 3;

        $this->pagination->uri_segment = 4;
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $start = ($page > 0) ? ($page - 1) * $this->pagination->per_page : 0;

        $items = $this->_listar_por_criterio($criterio);

        if (count($items) > 1) {
            $result = array_slice($items, $start, $this->pagination->per_page);
        } else {
            $result = $items;
        }

        $this->pagination->total_rows = count($items);
        $choice = $this->pagination->total_rows / $this->pagination->per_page;
        $this->pagination->num_links = round($choice);
        $this->pagination->initialize();

        $data["producciones"] = $result;
        $data["links"] = $this->pagination->create_links();
        if ($result) {
            $vista = array('view' => 'produccion/listar_items', 'vars' => $data);
        } else {
            $vista = array('view' => 'produccion/no_hay_producciones', 'vars' => '');
        }
        return $vista;
    }

    /**
     * Mostrar vista para ver en detalle la produccion
     * @param type $PROD_CODIGO
     */
    function ver_detalle($PROD_CODIGO) {
        $produccion = $this->produccion->obtener_produccion($PROD_CODIGO);
        $vista = array('view' => 'produccion/detallado',
            'vars' => array('produccion' => $produccion));
        $data['vistas'] = array($vista);
        $this->load->view('home', $data);
    }

    private function _listar_por_criterio($criterio = 1) {
        $vista = array();

        switch ($criterio) {
            case 1://obtener todas las producciones en orden de salida de base de datos
                $vista = $this->produccion->obtener_producciones();
                break;
            case 2://obtener producciones de docente actual
                $id = $this->session->userdata('user_id');
                $vista = $this->produccion->obtener_producciones_docente($id);
                break;
            case 3://obtener monografias unicamente
                $vista = $this->produccion->obtener_monografias();
                break;
            case 4://obtener articulos unicamente
                $vista = $this->produccion->obtener_articulos();
                break;
            case 5://obtener reportes unicamente
                $vista = $this->produccion->obtener_reportes();
                break;
            default:
                $vista = array('view' => 'produccion/no_hay_producciones', 'vars' => '');
                break;
        }
        return $vista;
    }

    public function contactar_autor($PROD_CODIGO, $ACCION = "") {
        if ($ACCION == 'enviar') {
            $nombre_usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
            $email_usuario = isset($_POST['email_usuario']) ? $_POST['email_usuario'] : '';
            $mensaje_usuario = isset($_POST['mensaje_usuario']) ? $_POST['mensaje_usuario'] : '';
            $email_autor = $this->produccion->email_docente($PROD_CODIGO);
            $enviado = $this->_enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario);
            if ($enviado) {
                $enviado = "Mensaje enviado al autor";
            } else {
                $enviado = "No se pudo enviar el mensaje.";
            }
        }
        $produccion = $this->produccion->obtener_produccion($PROD_CODIGO);
        $vista = array('view' => 'produccion/contactar_autor',
            'vars' => array('produccion' => $produccion, 'enviado' => (isset($enviado) ? $enviado : null)));
        $data['vistas'] = array($vista);
        $this->load->view('home', $data);
    }

    private function _enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario) {
        $this->load->model("sistema/clienteemail_model", "clienteemail");
        $result = $this->clienteemail->enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario);
        return $result;
    }

}
