<div id="restablecer_contrasena" class="large-4 column">
    <p>Para restablecer tu contraseña, introduce una dirección de correo electrónico</p>
    <?php
    echo form_open('usuario/restablecer_contrasena') .
    form_fieldset('') .
    form_label('Correo electrónico:', 'email') .
    '<input type="email" name="email" id="email" value="" />' . br() .
    '<input type="submit" restablecer="" id="sendContrasena" value="Restablecer" name="sendContrasena">' .
    form_fieldset_close() .
    form_close();
    ?>
</div>
