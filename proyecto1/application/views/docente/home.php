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
        <h3>Estadisticas de Publicaciones</h3>
        <ul>
            <li><?php echo anchor(site_url('docente/estadisticas'), 'Estadisticas de Grupos') ?></li>
        </ul> 
    </div>   
</div>
