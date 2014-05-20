<div id="inicioSesion">
    <?php
    if ($this->tank_auth->is_logged_in()) {
        ?>
        <span class="bienvenido">Bienvenido</span>
        <?php
        $nombre = $this->session->userdata("nombre");
        echo anchor(site_url('usuario/logout'), 'Cerrar Sesión') . anchor(site_url('usuario/editar_datos'), $nombre);
    } else {
        echo anchor(site_url('usuario/login'), 'Iniciar Sesión');
    }
    ?> 
</div>


