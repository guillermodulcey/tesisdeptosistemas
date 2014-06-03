<?php

class Produccion_model extends CI_Model {

    function __construct() {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
        $this->load->model('producciones/monografia_model', 'monografia');
        $this->load->model('producciones/articulo_model', 'articulo');
        $this->load->model('producciones/reporte_model', 'reporte');
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

    public function producciones_count() {
        return $this->db->count_all("produccion");
    }

    /**
     * Listar todas las producciones que estan en la base de datos 
     * @return boolean
     */
    public function obtener_producciones() {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    m.MONOGRAFIA_TIPO, m.MONOGRAFIA_AUTOR1, m.MONOGRAFIA_AUTOR2,
                    m.MONOGRAFIA_CODIRECTOR, r.RPT_DESCRIPCION,
                    a.ART_FACTOR_IMPACTO,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    LEFT JOIN monografia as m on p.PROD_CODIGO = m.PROD_CODIGO
                    LEFT JOIN reporte_tecnico as r on p.PROD_CODIGO = r.PROD_CODIGO
                    LEFT JOIN articulo as a on p.PROD_CODIGO = a.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    ');
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * listar todas las monografias 
     * @return boolean
     */
    public function obtener_monografias() {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    m.MONOGRAFIA_TIPO, m.MONOGRAFIA_AUTOR1, m.MONOGRAFIA_AUTOR2,
                    m.MONOGRAFIA_CODIRECTOR,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    INNER JOIN monografia as m on p.PROD_CODIGO = m.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    ');
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * Listar todos los articulos
     * @return boolean
     */
    public function obtener_articulos() {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    a.ART_FACTOR_IMPACTO,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    INNER JOIN articulo as a on p.PROD_CODIGO = a.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    ');
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * Listar todos los reportes
     * @return boolean
     */
    public function obtener_reportes() {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    r.RPT_DESCRIPCION,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    INNER JOIN reporte_tecnico as r on p.PROD_CODIGO = r.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    ');
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function obtener_produccion($PROD_CODIGO) {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    m.MONOGRAFIA_TIPO, m.MONOGRAFIA_AUTOR1, m.MONOGRAFIA_AUTOR2,
                    m.MONOGRAFIA_CODIRECTOR, r.RPT_DESCRIPCION,
                    a.ART_FACTOR_IMPACTO,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    LEFT JOIN monografia as m on p.PROD_CODIGO = m.PROD_CODIGO
                    LEFT JOIN reporte_tecnico as r on p.PROD_CODIGO = r.PROD_CODIGO
                    LEFT JOIN articulo as a on p.PROD_CODIGO = a.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    where p.PROD_CODIGO = ?'
                , array($PROD_CODIGO));
        if ($query->num_rows() == 1) {
            include_once('SP_Produccion.php');
            $produccion = $query->result("SP_Produccion");
            return $produccion[0];
        }
        return NULL;
    }

    public function obtener_producciones_docente($id_docente) {
        $query = $this->db->query('
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    m.MONOGRAFIA_TIPO, m.MONOGRAFIA_AUTOR1, m.MONOGRAFIA_AUTOR2,
                    m.MONOGRAFIA_CODIRECTOR, r.RPT_DESCRIPCION,
                    a.ART_FACTOR_IMPACTO,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    LEFT JOIN monografia as m on p.PROD_CODIGO = m.PROD_CODIGO
                    LEFT JOIN reporte_tecnico as r on p.PROD_CODIGO = r.PROD_CODIGO
                    LEFT JOIN articulo as a on p.PROD_CODIGO = a.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    where up.USU_CODIGO = ?'
                , array($id_docente));
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function email_docente($PROD_CODIGO) {
        $query = $this->db->query("
                    SELECT u.email
                    FROM usuario_produccion as up
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    where up.PROD_CODIGO = $PROD_CODIGO"
                , array($PROD_CODIGO));
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0]->email;
        }
        return NULL;
    }

    /**
     * Buscar en la tabla produccion producciones que contengan "$item" 
     * en su contenido.
     * @param type $item
     */
    public function busqueda_simple($item) {
        $item = strtoupper($item);
        $query = $this->db->query("
                    SELECT p.PROD_CODIGO, p.PROD_TITULO, p.PROD_RESUMEN, 
                    p.PROD_FECHA_PUBLICACION, p.PROD_GRUPO_INVESTIGACION, 
                    p.PROD_PERMISO, p.PROD_ESTADO, p.PROD_ARCHIVO_ADJUNTO,
                    m.MONOGRAFIA_TIPO, m.MONOGRAFIA_AUTOR1, m.MONOGRAFIA_AUTOR2,
                    m.MONOGRAFIA_CODIRECTOR, r.RPT_DESCRIPCION,
                    a.ART_FACTOR_IMPACTO,
                    u.username as USU_LOGIN
                    FROM produccion as p
                    LEFT JOIN monografia as m on p.PROD_CODIGO = m.PROD_CODIGO
                    LEFT JOIN reporte_tecnico as r on p.PROD_CODIGO = r.PROD_CODIGO
                    LEFT JOIN articulo as a on p.PROD_CODIGO = a.PROD_CODIGO
                    LEFT JOIN usuario_produccion as up on p.PROD_CODIGO = up.PROD_CODIGO
                    LEFT JOIN users as u on u.id = up.USU_CODIGO
                    LEFT JOIN usuario as us on us.USU_CODIGO = u.id
                    where upper(p.PROD_TITULO) like  '%$item%'
                    or upper(p.PROD_RESUMEN) like  '%$item%' 
                    or upper(p.PROD_GRUPO_INVESTIGACION) like  '%$item%' 
                    or upper(u.username) like  '%$item%' 
                    or upper(us.USU_NOMBRE) like  '%$item%'
                    or upper(us.USU_APELLIDO) like  '%$item%' ");
        if ($query->num_rows() > 0) {
            include_once('SP_Produccion.php');
            foreach ($query->result("SP_Produccion") as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * Funcion llamada para autocompletado, obtiene datos desde la tabla de produccion
     * @param type $valor
     * @return boolean
     */
    function get_data($valor) {
        $this->db->like("PROD_TITULO", $valor);
        $query = $this->db->get('produccion');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

}
