<div id="detallado">
    <?php
    if (isset($produccion)):
        ?>

        <h2><?php echo $produccion->PROD_TITULO ?></h2>
        <a id="contactar" href="<?php echo site_url("produccion/contactar_autor/$produccion->PROD_CODIGO"); ?>">Contactar Autor</a>

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
            <li> <span>Fecha Publicación: </span> <?php echo $produccion->PROD_FECHA_PUBLICACION ?> </li>
            <li> <span>Grupo Investigación: </span> <?php echo $produccion->PROD_GRUPO_INVESTIGACION ?> </li>        
        </ul>
        <ul class="resumen">
            <li> <p><?php echo $produccion->PROD_RESUMEN ?></p> </li>

            <?php
            if ($produccion->PROD_PERMISO == 2) {
                $md5_login = md5($produccion->USU_LOGIN);
                $ruta_archivo_adjunto = base_url("stored/$md5_login/$produccion->PROD_ARCHIVO_ADJUNTO");
                ?>
                <li> <a href="#" id="archivoAdjunto">
                        <?php
                        echo "Visualizar en PDF";
                        //echo substr($produccion->PROD_ARCHIVO_ADJUNTO, 0, strlen($produccion->PROD_ARCHIVO_ADJUNTO) - 4);
                        ?>
                    </a>

                <center class = "visualizar">
                    <iframe src = "<?php echo base_url("pdf/web/viewer.php?DEFAULT_URL=$ruta_archivo_adjunto"); ?>" width = "80%" height = "700"></iframe>
                </center>
                </li>
                <?php
            } else {
                echo "sin archivo adjunto";
            }
            ?>
        </ul>
        <?php
    endif;
    ?>
    <button class="regresar" onclick="goBack()">Regresar</button>
        
<!--    <a id="regresar" href="<?php echo base_url('index.php/produccion/index'); ?>">Regresar</a>-->

</div>


