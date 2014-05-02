<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
);
if ($login_by_username AND $login_by_email) {
    $login_label = 'Usuario';
} else if ($login_by_username) {
    $login_label = 'Usuario';
} else {
    $login_label = 'Correo';
}
$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
    'style' => 'margin:0;padding:0',
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'maxlength' => 8,
);
?>
<div id="access" class="large-4 columns">

    <?php echo form_open($this->uri->uri_string()); ?>
    <fieldset>
        <p>Bienvenido</p>
        <div class="form login">
            <?php echo form_label($login_label, $login['id']); ?>
            <?php echo form_input($login); ?>
            <p>@unicauca.edu.co</p>
        </div>
        <div class="form">

            <?php echo form_label('Password', $password['id']); ?>
            <?php echo form_password($password); ?>

        </div>

        <?php echo form_checkbox($remember); ?>
        <?php echo form_label('Recordar Datos', $remember['id']); ?>
        <?php echo anchor('/usuario/forgot_password/', '¿Olvidó su password?'); ?>
        <?php
        if ($this->config->item('allow_registration', 'tank_auth'))
            echo anchor('/usuario/register/', 'Register');
        ?>

        <?php echo form_submit('submit', 'Ingresar'); ?>

        <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? '<br/>'.$errors[$login['name']] : ''; ?>
        <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? '<br/>'.$errors[$password['name']] : ''; ?>
        <?php echo form_close(); ?>
</div>