<div id="itemBusqueda">
    <?php
    echo anchor(site_url('produccion/ver_detalle/' . $PROD_CODIGO), $PROD_TITULO)
    ?>
    <br />
    <ul>
        <li> <span>Resumen: </span> <?php echo $PROD_RESUMEN ?> </li>
        <li> <span>Fecha Publicación: </span> <?php echo $PROD_FECHA_PUBLICACION ?> </li>
        <li> <span>Grupo Investigación: </span> <?php echo$PROD_GRUPO_INVESTIGACION ?> </li>
        <li> <span>Permiso: </span> <?php echo$PROD_PERMISO ?> </li>
        <li> <span>Estado: </span> <?php echo$PROD_ESTADO ?> </li>
        <li> <span>Archivo Adjunto: </span> <?php echo$PROD_ARCHIVO_ADJUNTO ?> </li>
    </ul>
</div>


