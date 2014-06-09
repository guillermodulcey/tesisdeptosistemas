<div id="menuJefe">
    <div class="menuProducciones">
        <h3>Menú Usuarios</h3>
        <ul>        
            <li><?php echo anchor(site_url('jefe_departamento/docentes'), 'Administrar Usuarios') ?></li>
            <li><?php echo anchor(site_url('jefe_departamento/docentes/add'), 'Crear Usuario') ?></li>        
        </ul> 
    </div>
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