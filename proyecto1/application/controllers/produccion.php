<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produccion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('producciones/produccion_model', 'produccion');
        $this->load->model('sistema/graficas', 'graficas');
        $this->load->library('table');
    }

    public function index($criterio = 1) {
        $vista = $this->listar($criterio);
        $data['vistas'] = array($vista);
        $this->data['bandera1'] = false;
        $this->load->view('home', $data);
    }

    public function listar($criterio = 1) {
        $this->pagination->base_url = site_url("produccion/index/" . $criterio . "/");
        $this->pagination->per_page = 15;

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
        $this->data['bandera1'] = false;
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
        $this->data['bandera1'] = false;
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
            case 6://busqueda simple
                //obtener datos de input
                $busqueda = $this->input->post('buscarProduccion', TRUE);  // TRUE para hacer un filtrado XSS  
                $vista = $this->produccion->busqueda_simple($busqueda);
                break;
            default:
                $vista = array('view' => 'produccion/no_hay_producciones', 'vars' => '');
                break;
        }
        $this->data['bandera1'] = false;
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
        $this->data['bandera1'] = false;
        $this->load->view('home', $data);
    }

    private function _enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario) {
        $this->load->model("sistema/clienteemail_model", "clienteemail");
        $result = $this->clienteemail->enviar_contactar_autor($email_autor, $nombre_usuario, $email_usuario, $mensaje_usuario);
        return $result;
    }

    /**
     * obtener producciones sobre autocompletado.
     */
    function get_data() {
        $match = $this->input->get('term', TRUE);  // TRUE para hacer un filtrado XSS  
        $data['results'] = $this->produccion->get_data($match);
        $this->load->view('produccion/buscar_data', $data);
        $this->data['bandera1'] = false;
    }

    /**
     * Funcion que se llama para la busqueda simple.
     * toma la cadena obtiene los datos de la base de datos y los muestra
     * en pantalla con listar items busqueda
     */
    public function busqueda_simple() {
        $vista = $this->listar(6);
        $data['vistas'] = array($vista);
        $this->data['bandera1'] = false;
        $this->load->view('home', $data);
    }

    /**
     * 
     * 
     * Estadisticas 
     * 
     * 
     * 
     */

    /**
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
            'view' => $this->get_home(),
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
        $dateFini = new DateTime($this->input->post('fini'));
        $dateFfin = new DateTime($this->input->post('ffin'));
        $fini = $dateFini->format('Y-m-d');
        $ffin = $dateFfin->format('Y-m-d');

        $tabla = null;
        if ($username) {
            $this->graficas->graficar_prod_docente_fecha($username, $fini, $ffin);
            $tabla = $this->graficas->query_prod_docente($username, $fini, $ffin);
        }
        $vista = array(
            'view' => $this->get_home(),
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
            'view' => $this->get_home(),
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
            'view' => $this->get_home(),
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
        $dateFini = new DateTime($this->input->post('fini'));
        $dateFfin = new DateTime($this->input->post('ffin'));
        $fini = $dateFini->format('Y-m-d');
        $ffin = $dateFfin->format('Y-m-d');


        $tabla = null;
        if ($grupo) {
            $this->graficas->graficar_prod_grupo_fecha($grupo, $fini, $ffin);
            $tabla = $this->graficas->query_prod_grupo($grupo, $fini, $ffin);
        }
        $vista = array(
            'view' => $this->get_home(),
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
            'view' => $this->get_home(),
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

    //obtener el tipo de usuario y su controlador para saber donde renderizar
    public function get_home() {
        $tipo = $this->session->userdata("tipo");
        $home = "";
        foreach ($tipo as $value) {
            switch ($value) {
                case "docente":
                    $home = "docente/home";
                    break;
                case "jefe_departamento":
                    $home = "jefe_departamento/home";
                    return $home;
                case "administrador":
                    $home = "administrador/home";
                    break;
            }
        }
        return $home;
    }

}
