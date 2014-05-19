<div id="inicioSesion">
    <?php
    $this->load->model('sistema/dao_model','dao');
    $email = $this->session->userdata('username');
    $codigo = $this->dao->get_codigo_usuario($email.'@unicauca.edu.co');
    $nombre = $this->dao->get_nombre_usuario($codigo);
    $apellido = $this->dao->get_apellido_usuario($codigo);
    if ($this->tank_auth->is_logged_in()) {        
        echo 'Bienvenido '.anchor(site_url('usuario/logout'),'Cerrar Sesión').anchor(site_url('usuario/editar_datos'),$nombre);
    } else {
        echo anchor(site_url('usuario/login'), 'Iniciar Sesión');
    }
    ?> 
</div>


