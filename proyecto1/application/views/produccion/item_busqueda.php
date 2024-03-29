<div id="itemBusqueda">
    <?php
    if (isset($produccion)):
        echo anchor(site_url('produccion/ver_detalle/' . $produccion->PROD_CODIGO), $produccion->PROD_TITULO);
        ?>
        <br />
        <ul>
            <li>
                <?php
                if (isset($produccion->MONOGRAFIA_TIPO)) {
                    ?>
                    <span class="autores">
                        <?php
                        echo $produccion->MONOGRAFIA_AUTOR1 . " - " .
                        $produccion->MONOGRAFIA_AUTOR2
                        ?>
                    </span>
                    <br />
                    <?php
                } else if (isset($produccion->ART_ARCHIVO_ADJUNTO)) {
                    echo "esto es un articulo";
                    echo $produccion->ART_ARCHIVO_ADJUNTO;
                    echo $produccion->ART_FACTOR_IMPACTO;
                } else if (isset($produccion->RPT_DESCRIPCION)) {
                    echo "Esto es un reporte tecnico";
                    echo $produccion->RPT_DESCRIPCION;
                }
                ?>  
            </li> 
            <li>
                <span>Grupo de Investigacion: </span> <?php echo $produccion->PROD_GRUPO_INVESTIGACION; ?>
                <span class="fechaPubli">Fecha Publicación: </span> <?php echo $produccion->PROD_FECHA_PUBLICACION ?>
            </li>
            <li class="resumen"> <?php
                $resumenDetallado = $produccion->PROD_RESUMEN;
                $resumenBusqueda = substr($resumenDetallado, 0, 250) . "...";

                echo $resumenBusqueda;

                if ($produccion->PROD_PERMISO == 2) {
                    $md5_login = md5($produccion->USU_LOGIN);
                    $ruta_archivo_adjunto = base_url("stored/$md5_login/$produccion->PROD_ARCHIVO_ADJUNTO");
                    echo anchor($ruta_archivo_adjunto, 'Descargar PDF');
                } else {
                    ?><span class="sinArchivo"><?php echo "Sin archivo adjunto"?></span><?php
                }
                ?>
            </li>
        </ul>
        <?php
    endif;
    ?>
</div>


