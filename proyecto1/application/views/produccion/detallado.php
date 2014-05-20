<div id="detallado">
    <h2><?php echo $produccion->PROD_TITULO ?></h2>
    <ul>
        <li> <span>Fecha Publicación: </span> <?php echo $produccion->PROD_FECHA_PUBLICACION ?> </li>
        <li> <span>Grupo Investigación: </span> <?php echo $produccion->PROD_GRUPO_INVESTIGACION ?> </li>        
    </ul>
    <?php
    if (isset($produccion->MONOGRAFIA_TIPO)) {
        $this->load->view("produccion/detallado_monografia", $produccion);
    } else if (isset($produccion->ART_ARCHIVO_ADJUNTO)) {
        $this->load->view("produccion/detallado_articulo", $produccion);
    } else if (isset($produccion->RPT_DESCRIPCION)) {
        $this->load->view("produccion/detallado_reporte", $produccion);
    }
    ?>

    <ul>
        <li> <span>Resumen: </span> <p><?php echo $produccion->PROD_RESUMEN ?></p> </li>
        <li> <span>Archivo Adjunto: </span>
            <a href="#" id="archivoAdjunto">
                <?php
                echo substr($produccion->PROD_ARCHIVO_ADJUNTO, 0, strlen($produccion->PROD_ARCHIVO_ADJUNTO) - 4)
                ?>
            </a>
        </li>
    </ul>

    <?php
//$produccion->PROD_ARCHIVO_ADJUNTO = 'compressed.tracemonkey-pldi-09.pdf';
    $produccion->PROD_ARCHIVO_ADJUNTO = base_url('/stored/docente1/compressed.tracemonkey-pldi-09.pdf');
    ?>


    <center class="visualizar">
        <iframe src="<?php echo base_url("pdf/web/viewer.php?DEFAULT_URL=" . $produccion->PROD_ARCHIVO_ADJUNTO); ?>" width="80%" height="700"></iframe>
    </center>

    <a id="regresar" href="<?php echo base_url('index.php/produccion/index'); ?>">Regresar</a>

</div>


