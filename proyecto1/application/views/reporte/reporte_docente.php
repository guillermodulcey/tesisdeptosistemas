<div id="formEstadistica">
    <?php
    //verificar que sea una consulta o una respuesta
    if ($username) {
        ?>
        <h2 >Producciones por Docente</h2>
        <p>
            A continuación se presentan los totales de producciones que 
            ha subido al sistema el docente: <?php echo $username; ?>   
        </p>
        <br/><br/><p>Los resultados se resumen en la siguiente tabla: </p><br/><br/>

        <?php
        if ($tabla = !null) {
            $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
        }
        ?>

        <div id="grafsJefe">
            <img src="<?php echo base_url('img/grafica_de_barras_docente.png') ?>" alt="" border="0">
            <button class="regresar" onclick="goBack()">Regresar</button>
        </div>

        <?php
    } else {
        echo form_open('produccion/reporte_docente')
        . form_label("usuario:", "username")
        . form_input(array("id" => "login", "name" => "login"))
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    ?>
</div>
