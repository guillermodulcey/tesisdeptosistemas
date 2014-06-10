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
                    FROM users
                    INNER JOIN usuario_rol ON users.id = usuario_rol.USU_CODIGO
                    INNER JOIN rol ON usuario_rol.ROL_CODIGO = rol.ROL_CODIGO
                    WHERE users.email = ? LIMIT 0 , 30";
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
    
    function get_codigo_usuario_prod($cod_produccion){
        $valor = '';
        $consulta = 'select id from users inner join usuario_produccion on id=USU_CODIGO where PROD_CODIGO="' . $cod_produccion . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['id'];
        }
        return $valor;
    }
            
    function get_email_usuario($id) {
        $valor = '';
        $consulta = 'select email from users where id="' . $id . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['email'];
        }
        return $valor;
    }
    
    function get_codigo_usuario_p($produccion_codigo){
        $valor = '';
        $consulta = 'SELECT usuario_produccion.USU_CODIGO AS codigo
                        FROM usuario_produccion
                        INNER JOIN usuario_rol ON usuario_produccion.USU_CODIGO = usuario_rol.USU_CODIGO
                        WHERE usuario_produccion.USU_CODIGO =3
                        LIMIT 1';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['codigo'];
        }
        return $valor;
    }
            
    function get_nombre_usuario($id) {
        $valor = '';
        $consulta = 'select USU_NOMBRE from usuario where USU_CODIGO="' . $id . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['USU_NOMBRE'];
        }
        return $valor;
    }
    
    function get_apellido_usuario($id) {
        $valor = '';
        $consulta = 'select USU_APELLIDO from usuario where USU_CODIGO="' . $id . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['USU_APELLIDO'];
        }
        return $valor;
    }
    
    function get_login_usuario($id) {
        $valor = '';
        $consulta = 'select username from users where id="' . $id . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['username'];
        }
        return $valor;
    }
    
    function get_roles_usuario($id) {
        $valor = '';
        $i = 0;
        $consulta = 'select ROL_NOMBRE from rol inner join usuario_rol on rol.ROL_CODIGO = usuario_rol.ROL_CODIGO where USU_CODIGO="' . $id . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor[$i] = $row['ROL_NOMBRE'];
            $i++;
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
    
    function get_count_producciones_grupo($grupo,$tipo){
        $valor = '';
        $consulta = 'select count(produccion.PROD_CODIGO) as contador from produccion 
            inner join ' . $tipo . ' on produccion.PROD_CODIGO = ' . $tipo . '.PROD_CODIGO 
            where produccion.PROD_GRUPO_INVESTIGACION ="' . $grupo . '"';        
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['contador'];
        }
        return $valor;
    }  
    
    function get_count_producciones_persona($codigo,$tipo){
        $valor = '';
        $consulta = 'select count(produccion.PROD_CODIGO) as contador
                    from produccion
                    inner join ' . $tipo . ' on produccion.PROD_CODIGO = ' . $tipo . '.PROD_CODIGO
                    inner join usuario_produccion on produccion.PROD_CODIGO = usuario_produccion.PROD_CODIGO
                    where USU_CODIGO = "' . $codigo . '"';        
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $valor = $row['contador'];
        }
        return $valor;
    }
}

?>
