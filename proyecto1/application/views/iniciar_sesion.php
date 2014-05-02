<div id="inicioSesion">
    <?php
    if ($this->tank_auth->is_logged_in()) {
        echo anchor(site_url('usuario/logout'), 'Cerrar Sesión');
    } else {
        echo anchor(site_url('usuario/login'), 'Iniciar Sesión');
    }
    ?> 
</div>


