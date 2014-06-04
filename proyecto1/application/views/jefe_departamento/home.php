<?php //

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'Menu'.br();
//echo 'Estadisticas'.br();
//echo anchor(site_url('jefe_departamento/estadisticas'),'Estadisticas por Grupos').br();
//echo anchor(site_url('jefe_departamento/estadisticas'),'Estadisticas Docentes').br();
?>
<div id="menuJefe">
    <div class="menuProducciones">
        <h3>Menú Producciones</h3>
        <ul>        
            <li><?php echo anchor(site_url('docente/monografia'), 'Mis Monografias') ?></li>
            <li><?php echo anchor(site_url('docente/reporte'), 'Mis Reportes') ?></li>
            <li><?php echo anchor(site_url('docente/articulo'), 'Mis Articulos') ?></li>        
        </ul>
    </div>    
    <br />
    <div class="menuEstadisticas">
        <h3>Estadisticas de Publicaciones</h3>
        <ul>
            <li><?php echo anchor(site_url('jefe_departamento/estadisticas'), 'Estadisticas de Grupos') ?></li>
            <li><?php echo anchor(site_url('jefe_departamento/estadisticas'), 'Estadisticas Docentes') ?></li>
        </ul> 
    </div>   
</div>