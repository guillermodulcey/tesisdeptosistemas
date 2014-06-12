<div id="formEstadistica">
    <?php
    //verificar que sea una consulta o una respuesta
    if ($grupo) {
        ?>
        <h2 >Producciones por Grupo de Investigación (Rango Fecha)</h2>
        <p>
            A continuación se presentan los totales de producciones que 
            ha subido al sistema los docentes que pertenecen al grupo de investigación
            <?php echo $grupo; ?>, en el rango de 
            fechas desde el: <?php echo "$fini y $ffin"; ?>
        </p>
        <br/><br/>

        <?php if ($tabla = !null) { ?>
            <p>Los resultados se resumen en la siguiente tabla: </p>
            <br/><br/>
            <?php
            $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
        }
        ?>

        <div id="grafsJefe">
            <img src="<?php echo base_url('img/grafica_de_barras_grupo_fecha.png') ?>" alt="" border="0">
            <button class="regresar" onclick="goBack()">Regresar</button>
        </div>

        <?php
    } else {
        echo form_open('jefe_departamento/reporte_grupo_fecha')
        . form_label("Grupo de Investigación:", "grupo")
        . form_input(array("id" => "grupo", "name" => "grupo"))
        . br()
        . "Escoja un rango de fechas: "
        . br()
        . form_label("Fecha Inicio (YYYY-MM-DD):", "fini")
        . form_input(array("id" => "fini", "name" => "fini"))
        . br()
        . form_label("Fecha Fin (YYYY-MM-DD):", "ffin")
        . form_input(array("id" => "ffin", "name" => "ffin"))
        . br()
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    ?>
</div>
