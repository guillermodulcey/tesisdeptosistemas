<!DOCTYPE html>
<html>
    <head>
        <title>Tesis del Departamento de Sistemas</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width-device-width, initial-scale=1" />	        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/genericos.css'); ?>" media="all"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/estilos.css'); ?>" media="all"/>
        
        <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('js/proyecto.js'); ?>"></script>
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
                        <a href="#">Reportes Técnicos</a>
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
                <div class="clearfix"></div>
            </div>		
            <div id="footer"></div>
        </div>

    </body>
</html>
