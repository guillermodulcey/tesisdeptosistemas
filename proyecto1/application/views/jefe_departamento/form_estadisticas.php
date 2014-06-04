<div id="formEstadistica">
    <?php
    echo form_open('jefe_departamento/estadisticas_usuario')
    . form_label("usuario (login):", "login")
    . form_input(array("id" => "login", "name"=> "login"))
    . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
    . form_close();
    ?>
</div>
