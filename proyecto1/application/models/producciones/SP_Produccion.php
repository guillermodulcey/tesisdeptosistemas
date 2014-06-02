<?php

Class SP_Produccion extends CI_Model{
    private $tbl_produccion = 'produccion';

    
    function SP_Produccion(){
        parent::__construct();
    }
    function count_all(){
        return $this->db->count_all($this->tbl_produccion);
    }
    function get_paged_list($limit = 10, $offset = 0){
        $this->db->order_by('PROD_CODIGO','asc');
        return $this->db->get($this->tbl_produccion,$limit,$offset);
    }
    function get_by_id($id){
        $this->db->where('PROD_CODIGO',$id);
        return $this->db->get($this->produccion);
    }
    function save($produccion){
        $this->db->insert($this->tbl_produccion,$produccion);
        return $this->db->insert_id();
    }
    function update($id, $produccion){
        $this->db->where('PROD_CODIGO',$id);
        $this->db->update($this->tbl_produccion,$produccion);
    }
    function delete($id){
        $this->db->where('PROD_CODIGO',$id);
        $this->db->delete($this->tbl_produccion);
    }
}
