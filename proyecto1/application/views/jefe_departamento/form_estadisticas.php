<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo form_open('jefe_departamento/estadisticas_usuario');
echo 'usuario (login): ';
echo form_input('login');
echo form_submit('submit','Consultar');
echo form_close();
?>
