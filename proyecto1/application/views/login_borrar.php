<div id="access" class="large-4 columns">

    <?php
    echo form_open('usuario/login')
    ?>
    <fieldset>
        <p>Bienvenido</p>
        <div class="form login">
            <label for="email">Usuario:</label>
            <input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
            <p>@unicauca.edu.co</p>
        </div>
        <div class="form">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>"/>
        </div>
        <?php
        echo (isset($summary) ? $summary . br() : '');
        echo validation_errors();
        ?>
        <a href="<?php echo site_url('usuario/vista_restablecer_contrasena'); ?>">
            ¿Olvidó su password?
        </a>
        <br />
        <input id="sendLogin" type="submit" name="enviar_login" value="Ingresar" />
    </fieldset>
</form>
</div>

