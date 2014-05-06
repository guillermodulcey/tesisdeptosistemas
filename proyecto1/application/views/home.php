<!DOCTYPE html>
<html>
    <head>
        <title>Tesis del Departamento de Sistemas</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width-device-width, initial-scale=1" />	        
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/themes/flexigrid/css/flexigrid.css'); ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'); ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css'); ?>" />
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery-1.10.2.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.noty.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.noty.config.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/common/lazyload-min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/common/list.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/js/cookies.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/js/flexigrid.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/js/jquery.form.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/js/jquery.printElement.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.easing-1.3.pack.js'); ?>"></script>
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js'); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/genericos.css'); ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/estilos.css'); ?>" media="all"/>
        <script src="js/jquery.js"></script>
    </head>

    <body>
        <div id="pagina">
            <?php
            $this->load->view('iniciar_sesion');
            ?>

            <div id="header">
                <h1>Sistema Intelectual del Departamento De Sistemas</h1>
            </div>
            <div id="logo">
                <div class="logo">
                    <img src="<?php echo base_url('img/logo-unicauca.png'); ?>" alt="Logo Unicauca" />
                </div>
            </div>		
            <div id="conSuperior">

                <ul id="menuPrincipal">
                    <li class="inicio">
                        <a href="#">Inicio</a>
                    </li>
                    <li class="monografias">
                        <a href="#">Monografias</a>
                    </li>
                    <li class="articulos">
                        <a href="#">Artículos</a>
                    </li>
                    <li class="reportes">
                        <a href="#">Reportes Ténicos</a>
                    </li>
                </ul>      
            </div>
            <div class="clearfix"></div>
            <div id="conInferior">
                <?php
                if (isset($vistas)) {
                    foreach ($vistas as $value) {
                        $view = $value['view'];
                        $vars = $value['vars'];
                        $this->load->view($view, $vars);
                    }
                }
                ?>
            </div>		
            <div id="footer"></div>
        </div>

    </body>
</html>
