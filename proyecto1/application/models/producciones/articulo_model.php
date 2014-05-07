<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Articulo_model extends CI_Model { 

    function __construct() {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
    }
    
    public function gestion_articulo($codigo) {
        
        $crud = new grocery_CRUD();
        //$crud->set_theme('datatables');
        $query = $this->dao->get_articulos_docente($codigo);
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
        $crud->set_table('produccion')->set_subject('Articulo');
        //$crud->set_relation_n_n('Roles', 'usuario_rol', 'rol','USU_CODIGO','ROL_CODIGO','ROL_NOMBRE');      

        /* columnas a mostrar */
        $crud->columns('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'ART_FACTOR_IMPACTO');
        $crud->fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO','ART_FACTOR_IMPACTO','docente');
        
        /* campos en add */
        $crud->add_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'ART_FACTOR_IMPACTO','docente');

        /* campos en edit */
        $crud->edit_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'PROD_ARCHIVO_ADJUNTO', 'ART_FACTOR_IMPACTO','docente');

        /* Los nombres de los campos */
        $crud->display_as('PROD_TITULO', 'Titulo');
        $crud->display_as('PROD_RESUMEN', 'Resumen');
        $crud->display_as('PROD_FECHA_PUBLICACION', 'Fecha de Publicacion');
        $crud->display_as('PROD_GRUPO_INVESTIGACION', 'Grupo de Investigacion');
        $crud->display_as('PROD_PERMISO', 'Permiso');
        $crud->display_as('PROD_ESTADO', 'Estado');       
        $crud->display_as('PROD_ARCHIVO_ADJUNTO', 'Archivo PDF');       
        $crud->display_as('ART_FACTOR_IMPACTO', 'Factor de Impacto');

        /* columnas que no pertenecen a la tabla */
        $crud->callback_column('ART_FACTOR_IMPACTO', array($this, 'custom_tipo'));        

        /* Campos requeridos */
        $crud->required_fields('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_PERMISO', 'PROD_ARCHIVO_ADJUNTO', 'ART_FACTOR_IMPACTO');

        /* Tipo de campo */
        $crud->field_type('PROD_PERMISO', 'dropdown', array('1' => 'Privada', '2' => 'Publico'));
        $crud->field_type('PROD_GRUPO_INVESTIGACION', 'enum', array('IDIS', 'GIT'));
        $crud->set_field_upload('PROD_ARCHIVO_ADJUNTO', 'assets/uploads/articulos');

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
            $crud->callback_edit_field('ART_FACTOR_IMPACTO', array($this, 'tipo_edit'));            
        } else {
            $crud->callback_field('ART_FACTOR_IMPACTO', array($this, 'tipo_view'));            
        }

        $crud->callback_before_insert(array($this, 'llenar_dos_tablas'));
        $crud->callback_before_update(array($this, 'actualizar_dos_tablas'));
        $crud->callback_before_delete(array($this, 'borrar_de_dos_tablas'));

        $output = $crud->render();
        return $output;
    }

    public function tipo_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select ART_FACTOR_IMPACTO from articulo where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['ART_FACTOR_IMPACTO'];
        }
        $value = $resultado;
        return '<div id="field-ART_FACTOR_IMPACTO" class="readonly_label">' . $value . '</div>';
    }

    public function tipo_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select ART_FACTOR_IMPACTO from articulo where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['ART_FACTOR_IMPACTO'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="100" value="' . $value . '" name="ART_FACTOR_IMPACTO">';
    }

    public function custom_tipo($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select ART_FACTOR_IMPACTO from articulo where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['ART_FACTOR_IMPACTO'];
        }
        return $resultado;
    }

    public function llenar_dos_tablas($post_array) {
        //'ART_FACTOR_IMPACTO'
        $art_factor_impacto = $post_array['ART_FACTOR_IMPACTO'];
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

        $articulo_insert = array(
            'PROD_CODIGO' => $i,
            'ART_FACTOR_IMPACTO' => $art_factor_impacto
        );
        $post_array['PROD_CODIGO'] = $i;

        $this->db->insert('articulo', $articulo_insert);
        
        
        $produccion_insert = array(
            'USU_CODIGO' => $codigo_autor,
            'PROD_CODIGO' => $i
        );
        
        $this->db->insert('usuario_produccion',$produccion_insert);
        
        unset($post_array['docente']);
        
        unset($post_array['ART_FACTOR_IMPACTO']);
        return $post_array;
    }

    public function actualizar_dos_tablas($post_array, $primary_key) {
        //'ART_FACTOR_IMPACTO'
        $art_factor_impacto = $post_array['ART_FACTOR_IMPACTO'];

        $articulo_update = array(
            'ART_FACTOR_IMPACTO' => $art_factor_impacto
        );
        $this->db->where('PROD_CODIGO', $primary_key);
        $this->db->update('articulo', $articulo_update);
        
        unset($post_array['docente']);
        unset($post_array['ART_FACTOR_IMPACTO']);
        return $post_array;
    }

    public function borrar_de_dos_tablas($primary_key) {
        $this->db->delete('articulo', array('PROD_CODIGO' => $primary_key));
        $this->db->where('PROD_CODIGO',$primary_key);
        $this->db->delete('usuario_produccion');
        return true;
    }
}
?>
