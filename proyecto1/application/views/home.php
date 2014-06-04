<!DOCTYPE html>
<html>
    <head>
        <title>Tesis del Departamento de Sistemas</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width-device-width, initial-scale=1" />	        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/genericos.css'); ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/estilos.css'); ?>" media="all"/>
        <link rel="shortcut icon" href="http://www.unicauca.edu.co/sistemas/sites/default/files/favicon.ico" type="image/vnd.microsoft.icon" />

        <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('js/proyecto.js'); ?>"></script>


        <!--librerias y estilos para el autocompletado-->
        <link rel="stylesheet" href="<? echo base_url('js/jquery-ui.css'); ?>" />
        <script type="text/javascript" src="<? echo base_url('js/jquery-ui.js'); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //ubicacion de controlador que atiende la solicitud ajax
                var url = "<?php echo site_url('produccion/get_data'); ?>";
                $('#buscarProduccion').autocomplete({
                    source: url
                });
            });
        </script>

    </head>
    <body>
        <div id="pagina">
            <?php $this->load->view('iniciar_sesion'); ?>

            <div id="header">
                <h1>Sistema de Gestión de Producción Intelectual del Departamento de Sistemas de la Universidad del Cauca</h1>
            </div>

            <div id="logo">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>" >Universidad del Cauca</a>
                </div>
            </div>		
            <div id="conSuperior">

                <ul id="menuPrincipal">
                    <li class="inicio">
                        <a href="<?php echo site_url("usuario/get_home"); ?>">Inicio</a>
                    </li>
                    <li class="monografias">
                        <a href="<?php echo site_url("produccion/index/3") ?>">Monografias</a>
                    </li>
                    <li class="articulos">
                        <a href="<?php echo site_url("produccion/index/4") ?>">Artículos</a>
                    </li>
                    <li class="reportes">
                        <a href="<?php echo site_url("produccion/index/5") ?>">Reportes Técnicos</a>
                    </li>
                </ul> 

            </div> 

            <div class="clearfix"></div>
            <div id="conInferior">
                <div id="barra_busqueda" style="">
                    <?php
                    $textoBusqueda = "Consulte Producciones Aqui...";
                    echo form_open("produccion/busqueda_simple")
                    . form_label("Producción", "buscarProduccion")
                    . form_input(array("id" => "buscarProduccion",
                        "value" => $textoBusqueda,
                        "id" => "buscarProduccion",
                        "name" => "buscarProduccion",
                        "onclick" => "this.value='';",
                        "onfocus" => "this.select()",
                        "onblur" => "this.value=!this.value?'$textoBusqueda':this.value;"))
                    . form_submit(array("id" => "btnBuscar", "value" => "Buscar"))
                    . form_close();
                    ?>
                </div> 
                <?php
                $flag = true;
                if (isset($bandera)) {
                    $flag = $bandera;
                }
                if ($flag) {
                    $this->load->view('enlaces');
                }
                if (isset($vistas)) {
                    foreach ($vistas as $value) {
                        $view = $value['view'];
                        $vars = $value['vars'];
                        $this->load->view($view, $vars);
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>		
            <div id="footer"></div>
        </div>

    </body>
</html>
