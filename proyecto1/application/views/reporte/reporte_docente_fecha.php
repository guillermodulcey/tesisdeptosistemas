<div id="formEstadistica">
    <?php
    if ($tabla) {
        $this->load->library('table');
        $tmpl = array(
            'table_open' => '<table border="0" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        echo $this->table->generate($tabla);
    } else {
        echo form_open('jefe_departamento/reporte_docente')
        . form_label("usuario:", "login")
        . form_input(array("id" => "login", "name" => "login"))
        . form_submit(array("id" => "btnConsultar", "value" => "Consultar"))
        . form_close();
    }
    ?>
</div>
