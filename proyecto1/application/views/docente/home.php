<div id="menuDocente">
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
        <h3>Reportes Docentes </h3>
        <ul>
            <li><?php echo anchor(site_url('produccion/reporte_docente'), 'Reporte por Docente') ?></li>
            <li><?php echo anchor(site_url('produccion/reporte_docente_fecha'), 'Rango de Fechas') ?></li>
        </ul>
        <h3>Reportes Grupos</h3>
        <ul>
            <li><?php echo anchor(site_url('produccion/reporte_grupo'), 'Reporte por Grupo') ?></li>
            <li><?php echo anchor(site_url('produccion/reporte_grupo_fecha'), 'Rango de Fechas') ?></li>
            <li><?php echo anchor(site_url('produccion/reporte_grupo_total'), 'Consolidado Grupo') ?></li>
        </ul>
    </div>  


</div>
