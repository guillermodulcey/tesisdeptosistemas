<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SP_usuario extends CI_Model{
    private $tbl_usuario = 'usuario';
    
    function SP_usuario(){
        parent::__construct();
    }
    function count_all(){
        return $this->db->count_all($this->tbl_usuario);
    }
    function get_paged_list($limit = 10, $offset = 0){
        $this->db->order_by('USU_CODIGO','asc');
        return $this->db->get($this->tbl_usuario,$limit,$offset);
    }
    function get_by_id($id){
        $this->db->where('USU_CODIGO',$id);
        return $this->db->get($this->tbl_usuario);
    }
    function save($usuario){
        $this->db->insert($this->tbl_usuario,$usuario);
        return $this->db->insert_id();
    }
    function update($id, $usuario){
        $this->db->where('USU_CODIGO',$id);
        $this->db->update($this->tbl_usuario,$usuario);
    }
    function delete($id){
        $this->db->where('USU_CODIGO',$id);
        $this->db->delete($this->tbl_usuario);
    }
}
?>
