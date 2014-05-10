<?php

echo $produccion->PROD_CODIGO . br() .
 $produccion->PROD_TITULO . br() .
 $produccion->PROD_RESUMEN . br() .
 $produccion->PROD_FECHA_PUBLICACION . br() .
 $produccion->PROD_GRUPO_INVESTIGACION . br() .
 $produccion->PROD_PERMISO . br() .
 $produccion->PROD_ESTADO . br() .
 $produccion->PROD_ARCHIVO_ADJUNTO . br();

if (isset($produccion->MONOGRAFIA_TIPO)) {
    $this->load->view("produccion/detallado_monografia", $produccion);
} else if (isset($produccion->ART_ARCHIVO_ADJUNTO)) {
    $this->load->view("produccion/detallado_articulo", $produccion);
} else if (isset($produccion->RPT_DESCRIPCION)) {
    $this->load->view("produccion/detallado_reporte", $produccion);
}



