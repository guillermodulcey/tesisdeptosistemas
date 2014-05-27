<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Reporte_model extends CI_Model { 

    function __construct() {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
    }
    
    public function gestion_reporte($codigo) {
        
        $crud = new grocery_CRUD();
        //$crud->set_theme('datatables');
        $query = $this->dao->get_reportes_docente($codigo);
        if ($query->num_rows() == 0) {
            $crud->where('PROD_CODIGO', '');
        }
        $contador = 1;
        foreach ($query->result_array() as $row) {
            $valor = $row['PROD_CODIGO'];
            if ($contador == 1) {
                $crud->where('PROD_CODIGO', $valor);
            } else {
                $crud->or_where('PROD_CODIGO', $valor);
            }
            $contador++;
        }
        $crud->set_table('produccion')->set_subject('Reporte Tecnico');
        //$crud->set_relation_n_n('Roles', 'usuario_rol', 'rol','USU_CODIGO','ROL_CODIGO','ROL_NOMBRE');      

        /* columnas a mostrar */
        $crud->columns('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'RPT_DESCRIPCION');
        $crud->fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO','RPT_DESCRIPCION','docente');
        
        /* campos en add */
        $crud->add_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'RPT_DESCRIPCION','docente');

        /* campos en edit */
        $crud->edit_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'RPT_DESCRIPCION','docente');

        /* Los nombres de los campos */
        $crud->display_as('PROD_TITULO', 'Título');
        $crud->display_as('PROD_RESUMEN', 'Resumen');
        $crud->display_as('PROD_FECHA_PUBLICACION', 'Fecha de Publicación');
        $crud->display_as('PROD_GRUPO_INVESTIGACION', 'Grupo de Investigación');
        $crud->display_as('PROD_PERMISO', 'Permiso');
        $crud->display_as('PROD_ESTADO', 'Estado');       
        $crud->display_as('PROD_ARCHIVO_ADJUNTO', 'Archivo PDF');       
        $crud->display_as('RPT_DESCRIPCION', 'Descripción');

        /* columnas que no pertenecen a la tabla */
        $crud->callback_column('RPT_DESCRIPCION', array($this, 'custom_tipo'));        

        /* Campos requeridos */
        $crud->required_fields('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_PERMISO', 'PROD_ARCHIVO_ADJUNTO', 'RPT_DESCRIPCION');

        /* Tipo de campo */
        $crud->field_type('PROD_PERMISO', 'dropdown', array('1' => 'Privada', '2' => 'Publico'));
        $crud->field_type('PROD_GRUPO_INVESTIGACION', 'enum', array('IDIS', 'GIT'));
        
        $md5_login = md5($this->dao->get_login_usuario($codigo));
        if(!is_dir('stored/'.$md5_login)){
            mkdir('stored/'.$md5_login,0777,TRUE);
        }
        $crud->set_field_upload('PROD_ARCHIVO_ADJUNTO', 'stored/'.$md5_login);

        /* Edit vs Add */
        $state = $crud->getState();
        $state_info = $crud->getStateInfo();

        if ($state == 'add') {
            $crud->field_type('PROD_ESTADO', 'hidden', 'Sin Aprobar');
            $crud->field_type('PROD_CODIGO', 'invisible');
            $crud->field_type('docente', 'hidden', $codigo);
        } elseif ($state == 'edit') {
            $primary_key = $state_info->primary_key;
            $crud->field_type('PROD_ESTADO', 'invisible');
            $crud->field_type('PROD_CODIGO', 'invisible');
            $crud->field_type('docente', 'hidden', $codigo);
            $crud->callback_edit_field('RPT_DESCRIPCION', array($this, 'tipo_edit'));            
        } else {
            $crud->callback_field('RPT_DESCRIPCION', array($this, 'tipo_view'));            
            $crud->callback_field('docente', array($this, 'docente_view'));
        }

        $crud->callback_before_insert(array($this, 'llenar_dos_tablas'));
        $crud->callback_before_update(array($this, 'actualizar_dos_tablas'));
        $crud->callback_before_delete(array($this, 'borrar_de_dos_tablas'));

        $output = $crud->render();
        return $output;
    }

    public function docente_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $value = $this->dao->get_codigo_usuario_p($llave);
        $nombre = $this->dao->get_nombre_usuario($value);
        $apellido = $this->dao->get_apellido_usuario($value);
        $final = $nombre." ".$apellido;
        return '<div id="field-Docente" class="readonly_label">' . $final . '</div>';
    }
    
    public function tipo_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select RPT_DESCRIPCION from reporte_tecnico where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['RPT_DESCRIPCION'];
        }
        $value = $resultado;
        return '<div id="field-RPT_DESCRIPCION" class="readonly_label">' . $value . '</div>';
    }

    public function tipo_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select RPT_DESCRIPCION from reporte_tecnico where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['RPT_DESCRIPCION'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="100" value="' . $value . '" name="RPT_DESCRIPCION">';
    }

    public function custom_tipo($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select RPT_DESCRIPCION from reporte_tecnico where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['RPT_DESCRIPCION'];
        }
        return $resultado;
    }

    public function llenar_dos_tablas($post_array) {
        //'RPT_DESCRIPCION'
        $rpt_descripcion = $post_array['RPT_DESCRIPCION'];
        $codigo_autor = $post_array['docente'];

        $i = 0;

        do {
            $i++;
            $consulta = 'select count(*) as contador from produccion where PROD_CODIGO = "' . $i . '"';
            $query = $this->db->query($consulta);
            foreach ($query->result_array() as $row) {
                $resultado = $row['contador'];
            }
        } while ($resultado != 0);

        $reporte_insert = array(
            'PROD_CODIGO' => $i,
            'RPT_DESCRIPCION' => $rpt_descripcion
        );
        $post_array['PROD_CODIGO'] = $i;

        $this->db->insert('reporte_tecnico', $reporte_insert);
        
        
        $produccion_insert = array(
            'USU_CODIGO' => $codigo_autor,
            'PROD_CODIGO' => $i
        );
        
        $this->db->insert('usuario_produccion',$produccion_insert);
        
        unset($post_array['docente']);
        
        unset($post_array['RPT_DESCRIPCION']);
        return $post_array;
    }

    public function actualizar_dos_tablas($post_array, $primary_key) {
        //'RPT_DESCRIPCION'
        $rpt_descripcion = $post_array['RPT_DESCRIPCION'];

        $reporte_update = array(
            'RPT_DESCRIPCION' => $rpt_descripcion
        );
        $this->db->where('PROD_CODIGO', $primary_key);
        $this->db->update('reporte_tecnico', $reporte_update);
        
        unset($post_array['docente']);
        unset($post_array['RPT_DESCRIPCION']);
        return $post_array;
    }

    public function borrar_de_dos_tablas($primary_key) {
        $this->db->delete('reporte_tecnico', array('PROD_CODIGO' => $primary_key));
        $this->db->where('PROD_CODIGO',$primary_key);
        $this->db->delete('usuario_produccion');
        return true;
    }
}
?>
