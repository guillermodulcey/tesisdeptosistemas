<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Monografia_model extends CI_Model { 

    function __construct() {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        /* ------------------ */

        $this->load->library('grocery_CRUD');
        $this->load->model('sistema/dao_model', 'dao');
    }
    
    public function gestion_monografia($codigo) {
        
        $crud = new grocery_CRUD();
        //$crud->set_theme('datatables');
        $query = $this->dao->get_monografias_docente($codigo);
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
        $crud->set_table('produccion')->set_subject('Monografia');
        //$crud->set_relation_n_n('Roles', 'usuario_rol', 'rol','USU_CODIGO','ROL_CODIGO','ROL_NOMBRE');      

        /* columnas a mostrar */
        $crud->columns('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'MONOGRAFIA_TIPO', 'PROD_ARCHIVO_ADJUNTO', 'MONOGRAFIA_AUTOR1', 'MONOGRAFIA_AUTOR2', 'MONOGRAFIA_CODIRECTOR');
        $crud->fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'MONOGRAFIA_TIPO', 'MONOGRAFIA_ARCHIVO_ADJUNTO', 'MONOGRAFIA_AUTOR1', 'MONOGRAFIA_AUTOR2', 'MONOGRAFIA_CODIRECTOR','docente');
        
        /* campos en add */
        $crud->add_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'MONOGRAFIA_TIPO', 'PROD_ARCHIVO_ADJUNTO', 'MONOGRAFIA_AUTOR1', 'MONOGRAFIA_AUTOR2', 'MONOGRAFIA_CODIRECTOR','docente');

        /* campos en edit */
        $crud->edit_fields('PROD_CODIGO', 'PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_GRUPO_INVESTIGACION', 'PROD_PERMISO', 'PROD_ESTADO', 'MONOGRAFIA_TIPO', 'PROD_ARCHIVO_ADJUNTO', 'MONOGRAFIA_AUTOR1', 'MONOGRAFIA_AUTOR2', 'MONOGRAFIA_CODIRECTOR','docente');

        /* Los nombres de los campos */
        $crud->display_as('PROD_TITULO', 'Titulo');
        $crud->display_as('PROD_RESUMEN', 'Resumen');
        $crud->display_as('PROD_FECHA_PUBLICACION', 'Fecha de Publicacion');
        $crud->display_as('PROD_GRUPO_INVESTIGACION', 'Grupo de Investigacion');
        $crud->display_as('PROD_PERMISO', 'Permiso');
        $crud->display_as('PROD_ESTADO', 'Estado');
        $crud->display_as('MONOGRAFIA_TIPO', 'Tipo');
        $crud->display_as('PROD_ARCHIVO_ADJUNTO', 'Archivo PDF');
        $crud->display_as('MONOGRAFIA_AUTOR1', 'Autor');
        $crud->display_as('MONOGRAFIA_AUTOR2', 'Autor 2');
        $crud->display_as('MONOGRAFIA_CODIRECTOR', 'Codirector');

        /* columnas que no pertenecen a la tabla */
        $crud->callback_column('MONOGRAFIA_TIPO', array($this, 'custom_tipo'));
        $crud->callback_column('MONOGRAFIA_AUTOR1', array($this, 'custom_autor1'));
        $crud->callback_column('MONOGRAFIA_AUTOR2', array($this, 'custom_autor2'));
        $crud->callback_column('MONOGRAFIA_CODIRECTOR', array($this, 'custom_codirector'));

        /* Campos requeridos */
        $crud->required_fields('PROD_TITULO', 'PROD_RESUMEN', 'PROD_FECHA_PUBLICACION', 'PROD_PERMISO', 'PROD_ARCHIVO_ADJUNTO', 'MONOGRAFIA_AUTOR1');

        /* Tipo de campo */
        $crud->field_type('PROD_PERMISO', 'dropdown', array('1' => 'Privada', '2' => 'Publico'));
        $crud->field_type('PROD_GRUPO_INVESTIGACION', 'enum', array('IDIS', 'GTI','GICO'));
        $crud->field_type('MONOGRAFIA_TIPO', 'enum', array('Pregrado', 'Postgrado','Doctorado'));
        
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
            $crud->callback_edit_field('MONOGRAFIA_TIPO', array($this, 'tipo_edit'));
            $crud->callback_edit_field('MONOGRAFIA_AUTOR1', array($this, 'autor1_edit'));
            $crud->callback_edit_field('MONOGRAFIA_AUTOR2', array($this, 'autor2_edit'));
            $crud->callback_edit_field('MONOGRAFIA_CODIRECTOR', array($this, 'codirector_edit'));
        } else {
            $crud->callback_field('MONOGRAFIA_TIPO', array($this, 'tipo_view'));
            $crud->callback_field('MONOGRAFIA_AUTOR1', array($this, 'autor1_view'));
            $crud->callback_field('MONOGRAFIA_AUTOR2', array($this, 'autor2_view'));
            $crud->callback_field('MONOGRAFIA_CODIRECTOR', array($this, 'codirector_view'));            
            $crud->callback_field('docente', array($this, 'docente_view'));
            $crud->callback_field('PROD_PERMISO', array($this, 'permiso_view'));
        }

        $crud->callback_before_insert(array($this, 'llenar_dos_tablas'));
        $crud->callback_before_update(array($this, 'actualizar_dos_tablas'));
        $crud->callback_before_delete(array($this, 'borrar_de_dos_tablas'));

        $output = $crud->render();
        return $output;
    }
    
    public function permiso_view($value = "", $primary_key) {
        if($value==1){
            $final = 'Privada';
        }
        else{
            $final = 'Publico';
        }
        return '<div id="field-Permiso" class="readonly_label">' . $final . '</div>';
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
        $consulta = 'select MONOGRAFIA_TIPO from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_TIPO'];
        }
        $value = $resultado;
        return '<div id="field-MONOGRAFIA_TIPO" class="readonly_label">' . $value . '</div>';
    }

    public function autor1_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_AUTOR1 from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_AUTOR1'];
        }
        $value = $resultado;
        return '<div id="field-MONOGRAFIA_AUTOR1" class="readonly_label">' . $value . '</div>';
    }

    public function autor2_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_AUTOR2 from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_AUTOR2'];
        }
        $value = $resultado;
        return '<div id="field-MONOGRAFIA_AUTOR2" class="readonly_label">' . $value . '</div>';
    }

    public function codirector_view($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_CODIRECTOR from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_CODIRECTOR'];
        }
        $value = $resultado;
        return '<div id="field-MONOGRAFIA_CODIRECTOR" class="readonly_label">' . $value . '</div>';
    }

    public function tipo_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_TIPO from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_TIPO'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="100" value="' . $value . '" name="MONOGRAFIA_TIPO">';
    }

    public function autor1_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_AUTOR1 from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_AUTOR1'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="50" value="' . $value . '" name="MONOGRAFIA_AUTOR1">';
    }

    public function autor2_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_AUTOR2 from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_AUTOR2'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="50" value="' . $value . '" name="MONOGRAFIA_AUTOR2">';
    }

    public function codirector_edit($value = "", $primary_key) {
        $resultado = '';
        $llave = $primary_key;
        $consulta = 'select MONOGRAFIA_CODIRECTOR from monografia where PROD_CODIGO="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $row) {
            $resultado = $row['MONOGRAFIA_CODIRECTOR'];
        }
        $value = $resultado;
        return '<input type="text" maxlenght="50" value="' . $value . '" name="MONOGRAFIA_CODIRECTOR">';
    }

    public function custom_tipo($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select MONOGRAFIA_TIPO from monografia where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['MONOGRAFIA_TIPO'];
        }
        return $resultado;
    }

    public function custom_autor1($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select MONOGRAFIA_AUTOR1 from monografia where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['MONOGRAFIA_AUTOR1'];
        }
        return $resultado;
    }

    public function custom_autor2($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select MONOGRAFIA_AUTOR2 from monografia where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['MONOGRAFIA_AUTOR2'];
        }
        return $resultado;
    }

    public function custom_codirector($value, $row) {
        $resultado = '';
        $llave = $row->PROD_CODIGO;
        $consulta = 'select MONOGRAFIA_CODIRECTOR from monografia where PROD_CODIGO ="' . $llave . '"';
        $query = $this->db->query($consulta);
        foreach ($query->result_array() as $rowi) {
            $resultado = $rowi['MONOGRAFIA_CODIRECTOR'];
        }
        return $resultado;
    }

    public function llenar_dos_tablas($post_array) {
        //'MONOGRAFIA_TIPO','MONOGRAFIA_ARCHIVO_ADJUNTO','MONOGRAFIA_AUTOR1','MONOGRAFIA_AUTOR2','MONOGRAFIA_CODIRECTOR'
        $monografia_tipo = $post_array['MONOGRAFIA_TIPO'];
        $monografia_autor1 = $post_array['MONOGRAFIA_AUTOR1'];
        $monografia_autor2 = $post_array['MONOGRAFIA_AUTOR2'];
        $monografia_codirector = $post_array['MONOGRAFIA_CODIRECTOR'];
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

        $monografia_insert = array(
            'PROD_CODIGO' => $i,
            'MONOGRAFIA_TIPO' => $monografia_tipo,
            'MONOGRAFIA_AUTOR1' => $monografia_autor1,
            'MONOGRAFIA_AUTOR2' => $monografia_autor2,
            'MONOGRAFIA_CODIRECTOR' => $monografia_codirector
        );
        $post_array['PROD_CODIGO'] = $i;

        $this->db->insert('monografia', $monografia_insert);
        
        
        $produccion_insert = array(
            'USU_CODIGO' => $codigo_autor,
            'PROD_CODIGO' => $i
        );
        
        $this->db->insert('usuario_produccion',$produccion_insert);
        
        unset($post_array['docente']);
        
        unset($post_array['MONOGRAFIA_TIPO']);
        unset($post_array['MONOGRAFIA_ARCHIVO_ADJUNTO']);
        unset($post_array['MONOGRAFIA_AUTOR1']);
        unset($post_array['MONOGRAFIA_AUTOR2']);
        unset($post_array['MONOGRAFIA_CODIRECTOR']);
        return $post_array;
    }

    public function actualizar_dos_tablas($post_array, $primary_key) {
        //'MONOGRAFIA_TIPO','MONOGRAFIA_ARCHIVO_ADJUNTO','MONOGRAFIA_AUTOR1','MONOGRAFIA_AUTOR2','MONOGRAFIA_CODIRECTOR'
        $monografia_tipo = $post_array['MONOGRAFIA_TIPO'];
        $monografia_autor1 = $post_array['MONOGRAFIA_AUTOR1'];
        $monografia_autor2 = $post_array['MONOGRAFIA_AUTOR2'];
        $monografia_codirector = $post_array['MONOGRAFIA_CODIRECTOR'];

        $monografia_update = array(
            'MONOGRAFIA_TIPO' => $monografia_tipo,
            'MONOGRAFIA_AUTOR1' => $monografia_autor1,
            'MONOGRAFIA_AUTOR2' => $monografia_autor2,
            'MONOGRAFIA_CODIRECTOR' => $monografia_codirector
        );
        $this->db->where('PROD_CODIGO', $primary_key);
        $this->db->update('monografia', $monografia_update);
        
        unset($post_array['docente']);
        unset($post_array['MONOGRAFIA_TIPO']);
        unset($post_array['MONOGRAFIA_ARCHIVO_ADJUNTO']);
        unset($post_array['MONOGRAFIA_AUTOR1']);
        unset($post_array['MONOGRAFIA_AUTOR2']);
        unset($post_array['MONOGRAFIA_CODIRECTOR']);
        return $post_array;
    }

    public function borrar_de_dos_tablas($primary_key) {
        $this->db->delete('monografia', array('PROD_CODIGO' => $primary_key));
        $this->db->where('PROD_CODIGO',$primary_key);
        $this->db->delete('usuario_produccion');
        return true;
    }
}

?>
