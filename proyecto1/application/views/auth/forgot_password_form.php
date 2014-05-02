<?php
$login = array(
    'name' => 'login',
    'id' => 'email',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
);
$submit = array(
    'name' => 'reset',
    'id' => 'sendContrasena',
    'value' => 'Restablecer',
    'type' => 'submit',
    'restablecer' => '',
);
if ($this->config->item('use_username', 'tank_auth')) {
    $login_label = 'Escriba Usuario o correo: ';
} else {
    $login_label = 'Email';
}
?>
<div id="restablecer_contrasena" class="large-4 column">
    <?php echo form_open($this->uri->uri_string()); ?>
    <p>Para restablecer tu contraseña, introduce una dirección de correo electrónico</p>
    <?php echo form_label($login_label, $login['id']); ?>
    <?php echo form_input($login); ?>
    <?php echo form_error($login['name']); ?>
    <?php echo isset($errors[$login['name']]) ? '<br/>' . $errors[$login['name']] : ''; ?>

    <?php echo form_submit($submit); ?>
    <?php echo form_close(); ?>
</div>