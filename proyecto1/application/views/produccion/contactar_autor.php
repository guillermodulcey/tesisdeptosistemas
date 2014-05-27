<div id="contactarAutor">
    <p> Contacta con el autor de
        <span>
            <?php
            echo anchor(site_url('produccion/ver_detalle/' . $produccion->PROD_CODIGO), $produccion->PROD_TITULO)
            . br(3)
            ?>
        </span>
    </p>
    <p>Escribe un mensaje al autor de esta produccion bibliografica</p>
    <br />
    <?php
    echo ""
    . form_open("produccion/contactar_autor/$produccion->PROD_CODIGO/enviar")
    . form_label("Escribe tu Nombre: ", "nombre_usuario")
    . form_input(array('name' => 'nombre_usuario', 'id' => 'nombre_usuario'))
    . br(2)
    . form_label("Escribe tu Correo:", "email_usuario")
    . form_input(array('name' => 'email_usuario', 'id' => 'email_usuario'))
    . br(2)
    . form_label("Escribe tu Mensaje:", "mensaje_usuario")
    . form_textarea(array('name' => 'mensaje_usuario', 'id' => 'mensaje_usuario'))
    . br(3)
    . form_submit(array('name' => 'submit', 'value' => 'Enviar', 'id' => 'sendContactar'))
    . form_close();

    echo isset($enviado) ? $enviado : '';
    ?>
</div>

