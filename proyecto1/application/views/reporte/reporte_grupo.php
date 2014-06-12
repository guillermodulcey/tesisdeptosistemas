<div id="formEstadistica">
    <?php
    //verificar que sea una consulta o una respuesta
    if ($grupo) {
        ?>
        <h2 >Producciones por Grupo de Investigación</h2>
        <p>
            A continuación se presentan los totales de producciones que 
            ha subido al sistema los docentes que pertenecen al grupo de investigación <?php echo $grupo; ?>   
        </p>
        <br/><br/><p>Los resultados se resumen en la siguiente tabla: </p><br/><br/>

        <?php
        if ($tabla = !null) {
            $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
        }
        ?>

        <div id="grafsJefe">
            <img src="<?php echo base_url('img/grafica_de_barras_grupo.png') ?>" alt="" border="0">
            <button class="regresar" onclick="goBack()">Regresar</button>
        </div>

        <?php
    } else {
        echo form_open('produccion/reporte_grupo')
        . form_label("Nombre Grupo:", "grupo")
        . form_input(array("id" => "grupo", "name" => "grupo"))
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    ?>
</div>
