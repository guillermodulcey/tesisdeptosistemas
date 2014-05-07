<?php

class Produccion_model extends CI_Model {

    function __construct() {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
        $this->load->model('producciones/monografia_model','monografia');
        $this->load->model('producciones/articulo_model','articulo');
        $this->load->model('producciones/reporte_model','reporte');
    }

    public function gestion_monografia($codigo) {
        $output = $this->monografia->gestion_monografia($codigo);
        return $output;
    }
    
    public function gestion_articulo($codigo) {
        $output = $this->articulo->gestion_articulo($codigo);
        return $output;
    }
    
    public function gestion_reporte($codigo) {
        $output = $this->reporte->gestion_reporte($codigo);
        return $output;
    }
    function get_last_ten_entries() {
        $query = $this->db->get('produccion', 10);
        return $query->result();
    }

    public function producciones_count() {
        return $this->db->count_all("produccion");
    }

    public function obtener_producciones($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get("produccion");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }    
}
