<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo 'Menu'.br();
echo 'Estadisticas'.br();
echo anchor(site_url('jefe_departamento/estadisticas'),'Estadisticas por Grupos').br();
echo anchor(site_url('jefe_departamento/estadisticas'),'Estadisticas Docentes').br();
echo 'Producciones'.br();
echo anchor(site_url('docente/monografia'),'Mis Monografias').br();
echo anchor(site_url('docente/reporte'),'Mis Reportes').br();
echo anchor(site_url('docente/articulo'),'Mis Articulos').br();
?>
