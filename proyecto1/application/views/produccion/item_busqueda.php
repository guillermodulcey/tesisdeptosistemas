<div>
    <?php
    echo anchor(site_url('produccion/ver_detalle/'.$PROD_CODIGO),
            $PROD_TITULO) .
    $PROD_RESUMEN .
    $PROD_FECHA_PUBLICACION .
    $PROD_GRUPO_INVESTIGACION .
    $PROD_PERMISO .
    $PROD_ESTADO .
    $PROD_ARCHIVO_ADJUNTO;
    ?>
</div>

