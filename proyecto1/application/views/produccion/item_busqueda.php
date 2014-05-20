<div id="itemBusqueda">
    <?php
    echo anchor(site_url('produccion/ver_detalle/' . $PROD_CODIGO), $PROD_TITULO)
    ?>
    <br />

    <ul>
        <li> <span>Fecha Publicación: </span> <?php echo $PROD_FECHA_PUBLICACION ?> </li>
        <li class="resumen"> <?php
            $resumenDetallado = $PROD_RESUMEN;
            $resumenBusqueda = substr($resumenDetallado, 0, 250) . "...";

            echo $resumenBusqueda;?>
        </li>
    </ul>
</div>


