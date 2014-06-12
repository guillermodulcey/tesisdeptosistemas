<div id="formEstadistica">
    <?php
    //verificar que sea una consulta o una respuesta
    if ($username) {
        ?>
        <div id="grafsJefe">
            <img src="<?php echo base_url('img/grafica_de_barras_docente.png') ?>" alt="" border="0">
            <button class="regresar" onclick="goBack()">Regresar</button>
        </div>
        <?php
    } else {
        echo form_open('jefe_departamento/reporte_docente')
        . form_label("usuario:", "username")
        . form_input(array("id" => "login", "name" => "login"))
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    if ($tabla = !null) {
        $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
    }
    ?>
</div>
