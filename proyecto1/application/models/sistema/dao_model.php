<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DAO_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function conectar() {
        $this->load->database();
        return true;
    }

    function registro_docente() {

        $sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";

        $this->db->query($sql, array(3, 'live', 'Rick'));
    }

    function get_contrasena_usuario($email) {
        if ($this->conectar()) {
            $query = $this->db->query('
                    SELECT USU_CONTRASENA AS password 
                    FROM usuario
                    WHERE USU_EMAIL = ?'
                    , array($email));
            if ($query->num_rows() > 0) {
                $row = $query->row(1);
                return $row->password;
            }
        }
        return NULL;
    }

    function get_tipo_usuario($login) {
        $result = NULL;
        if ($this->conectar()) {
            $sql = "SELECT rol.ROL_NOMBRE
                    FROM usuario
                    INNER JOIN usuario_rol ON usuario.USU_CODIGO = usuario_rol.USU_CODIGO
                    INNER JOIN rol ON usuario_rol.ROL_CODIGO = rol.ROL_CODIGO
                    WHERE usuario.USU_EMAIL = ? LIMIT 0 , 30";
            $query = $this->db->query($sql, array($login . "@unicauca.edu.co"));
            if ($query->num_rows() > 0) {
                $result = array();
                foreach ($query->result_array() as $row) {
                    array_push($result, $row['ROL_NOMBRE']);
                }
            }
        }
        return $result;
    }

    function get_codigo_usuario($email) {
        $valor = '';
        $consulta = 'select id from users where email="' . $email . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['id'];
        }
        return $valor;
    }

    function get_producciones_docente($codigo) {
        $consulta = 'select PROD_CODIGO from usuario_produccion where USU_CODIGO=' . $codigo;
        $query = $this->db->query($consulta);
        return $query;
    }
    
    function get_monografias_docente($codigo) {
        $consulta = 'select usuario_produccion.PROD_CODIGO from usuario_produccion inner join monografia on usuario_produccion.PROD_CODIGO = monografia.PROD_CODIGO where USU_CODIGO=' . $codigo;
        $query = $this->db->query($consulta);
        return $query;
    }
    
    function get_articulos_docente($codigo) {
        $consulta = 'select usuario_produccion.PROD_CODIGO from usuario_produccion inner join articulo on usuario_produccion.PROD_CODIGO = articulo.PROD_CODIGO where USU_CODIGO=' . $codigo;
        $query = $this->db->query($consulta);
        return $query;
    }
    
    function get_reportes_docente($codigo) {
        $consulta = 'select usuario_produccion.PROD_CODIGO from usuario_produccion inner join reporte_tecnico on usuario_produccion.PROD_CODIGO = reporte_tecnico.PROD_CODIGO where USU_CODIGO=' . $codigo;
        $query = $this->db->query($consulta);
        return $query;
    }
    
    function get_producciones_recientes(){
        $result = NULL;
        if ($this->conectar()) {
            $sql = "SELECT * 
                    FROM produccion
                    LIMIT 0 , 30";
            $query = $this->db->query($sql, array());
            if ($query->num_rows() > 0) {
                $result = array();
                foreach ($query->result_array() as $row) {
                    array_push($result, $row['ROL_NOMBRE']);
                }
            }
        }
        return $result;
    }
}

?>
