<div id="formEstadistica">

    <h2>Consolidado de Producciones por Grupo de Investigación</h2>
    <p>
        A continuación se presentan los totales de producciones 
        que se han subido al sistema según el grupo de investigación al que pertenece.
    </p>
    <br/><br/><p>Los resultados se resumen en la siguiente tabla: </p><br/><br/>

    <?php
    if ($tabla = !null) {
        $this->load->view("reporte/dibujar_tabla", array('tabla', $tabla));
    }
    ?>


</div>
