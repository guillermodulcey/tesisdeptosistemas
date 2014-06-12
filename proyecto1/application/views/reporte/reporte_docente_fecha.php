<div id="formEstadistica">
    <?php
    //verificar que sea una consulta o una respuesta
    if ($username) {
        ?>
        <h2 >Producciones por Docente (Rango Fecha)</h2>
        <p>
            A continuación se presentan los totales de producciones que 
            ha subido al sistema el docente: <?php echo $username; ?>, en el rango de 
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
            <img src="<?php echo base_url('img/grafica_de_barras_docente_fecha.png') ?>" alt="" border="0">
            <button class="regresar" onclick="goBack()">Regresar</button>
        </div>

        <?php
    } else {
        echo form_open('produccion/reporte_docente_fecha')
        . form_label("usuario:", "username")
        . form_input(array("id" => "login", "name" => "login"))
        . br()
        . "Escoja un rango de fechas: "
        . br()
        . form_label("Fecha Inicio:", "fini")
        . form_input(array("id" => "fini", "name" => "fini"))
        . br()
        . form_label("Fecha Fin:", "ffin")
        . form_input(array("id" => "ffin", "name" => "ffin"))
        . br()
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    ?>
</div>


<script>
    $(function() {
        $("#fini").datepicker();
        $("#ffin").datepicker();
    });
</script>