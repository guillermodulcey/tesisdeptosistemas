<div id="itemBusqueda">
    <?php
    if (isset($produccion)):
        echo anchor(site_url('produccion/ver_detalle/' . $produccion->PROD_CODIGO), $produccion->PROD_TITULO);
        ?>
        <br />

        <ul>
            <li> <span>Fecha Publicación: </span> <?php echo $produccion->PROD_FECHA_PUBLICACION ?> </li>
            <li class="resumen"> <?php
                $resumenDetallado = $produccion->PROD_RESUMEN;
                $resumenBusqueda = substr($resumenDetallado, 0, 250) . "...";

                echo $resumenBusqueda;

                echo $produccion->PROD_GRUPO_INVESTIGACION;
                
                if($produccion->PROD_PERMISO==2){
                    echo anchor($produccion->PROD_ARCHIVO_ADJUNTO,'descargar PDF');
                }
                else{
                    echo "sin archivo adjunto";
                }

                if (isset($produccion->MONOGRAFIA_TIPO)) {
                    echo "Esto es una monografia.";
                    echo $produccion->MONOGRAFIA_TIPO;
                    echo $produccion->MONOGRAFIA_AUTOR1 . " - " . $produccion->MONOGRAFIA_AUTOR2;
                    echo $produccion->MONOGRAFIA_CODIRECTOR;
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
        </ul>
        <?php
    endif;
    ?>
</div>


