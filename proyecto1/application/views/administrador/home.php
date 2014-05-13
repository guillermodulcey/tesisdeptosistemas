<?php

echo "MENU ADMINISTRADO:" . br();

echo form_open('administrador/docentes')
 . form_submit('crud_docentes', 'CRUD DOCENTES')
 . form_close();

echo anchor('/usuario/logout', 'Cerrar Sesion');
?>

