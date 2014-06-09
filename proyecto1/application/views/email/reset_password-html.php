<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Nueva Contraseña en: <?php echo $site_name; ?></h2>
    Has Cambiado tu Contraseña.<br />
    Por favor, almacene este correo en caso que olvide su contraseña.<br />
    <br />
    <?php
    if (strlen($username) > 0) {
        ?>
        Tu usuario: 
        <?php echo $username; ?>
        <br />
    <?php } ?>
    Tu direccion de Correo: <?php echo $email; ?>
    <br />
    <?php /* Your new password: <?php echo $new_password; ?><br /> */ ?>
    <br />
    <br />
    Muchas gracias,<br />
    El Equipo de <?php echo $site_name; ?>.
</div>