<?php
$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
?>

<div id="access" class="large-4 columns">
    <?php echo form_open($this->uri->uri_string()); ?>
    <div class="form">
        <?php echo form_label('Nueva Contraseña', $new_password['id']); ?>
        <?php echo form_password($new_password); ?>
    </div>
    <div class="form">
        <?php echo form_label('Confirmar Nueva Contraseña', $confirm_new_password['id']); ?>
        <?php echo form_password($confirm_new_password); ?>
    </div>


    <?php echo form_submit('change', 'Cambiar Contraseña'); ?>
    <?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']]) ? '<br/>' . $errors[$new_password['name']] : ''; ?>
    <?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']]) ? '<br/>' . $errors[$confirm_new_password['name']] : ''; ?>
    <?php echo form_close(); ?>
</div>