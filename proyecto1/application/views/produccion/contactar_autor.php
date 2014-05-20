<?php

echo "Contacta con el autor de: " . $produccion->PROD_TITULO
 . br(3)
 . "Escribe un mensaje al autor de esta produccion bibliografica:"
 . br(2)
 . form_open("produccion/contactar_autor/$produccion->PROD_CODIGO/enviar")
 . form_label("Escribe tu Nombre: ", "nombre_usuario")
 . form_input(array('name' => 'nombre_usuario'))
 . br(2)
 . form_label("Escribe tu Correo:", "email_usuario")
 . form_input(array('name' => 'email_usuario'))
 . br(2)
 . form_label("Escribe tu Mensaje:", "mensaje_usuario")
 . form_textarea(array('name' => 'mensaje_usuario'))
 . br(3)
 . form_submit(array('name' => 'submit', 'value' => 'Enviar'))
 . form_close();

echo isset($enviado) ? $enviado : '';


