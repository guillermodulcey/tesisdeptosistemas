<div id="formEstadistica">

    <h2>Consolidado de Producciones por docente</h2>
    <p>
        A continuación se presentan los totales de producciones que 
        ha subido al sistema los docentes. 
    </p>
    <br/><br/><p>Los resultados se resumen en la siguiente tabla: </p><br/><br/>

    <?php
    if ($tabla = !null) {
        $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
    }
    ?>


</div>
