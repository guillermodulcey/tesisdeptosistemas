<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">
        Cambiar Contraseña
    </h2>
    ¿Ha Olvidado su contraseña?
    <br/>
    Para cambiar su contraseña, por favor haga clic en el siguiente link:
    <br/>
    <br/>

    <a href="<?php echo site_url('/usuario/reset_password/' . $user_id . '/' . $new_pass_key); ?>" >
        Cambiar su contraseña
    </a>
    <br/>
    <br/>
    ¿No funciona el link?, por favor copia el siguiente link en la barra de tu navegador: 
    <a href="<?php echo site_url('/usuario/reset_password/' . $user_id . '/' . $new_pass_key); ?>" >
        <?php echo site_url('/usuario/reset_password/' . $user_id . '/' . $new_pass_key); ?>
    </a>
    <br/>
    <br/>
    <br/>
    Tu has recibido este mail, de un usuario de
    <a href="<?php echo site_url(''); ?>" >
        <?php echo $site_name; ?>
    </a>. 
    Esto hace parte del procedimiento de cambio de contraseña en el sistema.
    Si tu no hiciste esta peticion entonces por favor ignora este mensaje de correo y tu contraseña 
    continuará siendo la misma.<br />
    <br/>
    <br/>
    Muchas Gracias,<br />
    El equipo de <?php echo $site_name; ?>.
</div>