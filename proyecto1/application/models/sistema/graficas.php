<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Graficas extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('sistema/dao_model', 'dao');
    }

    public function graficar_barras_grupos() {
        // Standard inclusions   
        include("application/libraries/pChart.1.27d/pChart/pData.class");
        include("application/libraries/pChart.1.27d/pChart/pChart.class");

        $monografiasIDIS = $this->dao->get_count_producciones_grupo('IDIS', 'monografia');
        $articulosIDIS = $this->dao->get_count_producciones_grupo('IDIS', 'articulo');
        $reportesIDIS = $this->dao->get_count_producciones_grupo('IDIS', 'reporte_tecnico');

        $monografiasGTI = $this->dao->get_count_producciones_grupo('GTI', 'monografia');
        $articulosGTI = $this->dao->get_count_producciones_grupo('GTI', 'articulo');
        $reportesGTI = $this->dao->get_count_producciones_grupo('GTI', 'reporte_tecnico');

        $monografiasGICOM = $this->dao->get_count_producciones_grupo('GICO', 'monografia');
        $articulosGICOM = $this->dao->get_count_producciones_grupo('GICO', 'articulo');
        $reportesGICOM = $this->dao->get_count_producciones_grupo('GICO', 'reporte_tecnico');

        // Dataset definition 
        $DataSet = new pData;

        $DataSet->AddPoint(array($monografiasIDIS, $monografiasGTI, $monografiasGICOM), "SerieMonografias");
        $DataSet->AddPoint(array($articulosIDIS, $articulosGTI, $articulosGICOM), "SerieArticulos");
        $DataSet->AddPoint(array($reportesIDIS, $reportesGTI, $reportesGICOM), "SerieReportes");
        $DataSet->AddPoint(array('IDIS', 'GTI', 'GICO'), "XLabel");

        $DataSet->SetAbsciseLabelSerie("XLabel");
        //$DataSet->AddPoint(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");

        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("XLabel");
        //$DataSet->SetAbsciseLabelSerie();
        $DataSet->SetSerieName("Monografías", "SerieMonografias");
        $DataSet->SetSerieName("Articulos", "SerieArticulos");
        $DataSet->SetSerieName("Reportes", "SerieReportes");

        $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1";

        // Initialise the graph
        $Test = new pChart(700, 230);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 8);
        $Test->setGraphArea(50, 30, 680, 200);
        $Test->drawFilledRoundedRectangle(7, 7, 693, 223, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 695, 225, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2, TRUE);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);
        // Draw the 0 line
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);
        // Draw the bar graph
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE, 80);
        // Finish the graph
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 8);
        $Test->drawLegend(596, 150, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 10);
        $Test->drawTitle(50, 22, "Producciones por Grupos", 50, 50, 50, 585);

        $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1/img";
        //$email = $this->session->userdata('username');
        //$Test->Render($font_folder."/grafica_de_barras".$email.".png");            
        $Test->Render($font_folder . "/grafica_de_barras_grupos.png");
    }

    public function graficar_barras_persona($persona) {
        // Standard inclusions   
        include("application/libraries/pChart.1.27d/pChart/pData.class");
        include("application/libraries/pChart.1.27d/pChart/pChart.class");

        $codigo = $this->dao->get_codigo_usuario($persona . "@unicauca.edu.co");
        $nombre = $this->dao->get_nombre_usuario($codigo);
        $apellido = $this->dao->get_apellido_usuario($codigo);

        $monografiasPersona = $this->dao->get_count_producciones_persona($codigo, 'monografia');
        $articulosPersona = $this->dao->get_count_producciones_persona($codigo, 'articulo');
        $reportesPersona = $this->dao->get_count_producciones_persona($codigo, 'reporte_tecnico');

        // Dataset definition 
        $DataSet = new pData;

        $DataSet->AddPoint(array($monografiasPersona), "SerieMonografias");
        $DataSet->AddPoint(array($articulosPersona), "SerieArticulos");
        $DataSet->AddPoint(array($reportesPersona), "SerieReportes");
        $DataSet->AddPoint(array($nombre . ' ' . $apellido), "XLabel");

        $DataSet->SetAbsciseLabelSerie("XLabel");
        //$DataSet->AddPoint(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");

        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("XLabel");
        //$DataSet->SetAbsciseLabelSerie();
        $DataSet->SetSerieName("Monografías", "SerieMonografias");
        $DataSet->SetSerieName("Articulos", "SerieArticulos");
        $DataSet->SetSerieName("Reportes", "SerieReportes");

        if (strpos(base_url(), "localhost")) {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1";
        } else {
            $font_folder = $_SERVER['DOCUMENT_ROOT'];
        }



        // Initialise the graph
        $Test = new pChart(700, 230);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 8);
        $Test->setGraphArea(50, 30, 680, 200);
        $Test->drawFilledRoundedRectangle(7, 7, 693, 223, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 695, 225, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2, TRUE);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);
        // Draw the 0 line
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);
        // Draw the bar graph
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE, 80);
        // Finish the graph
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 8);
        $Test->drawLegend(596, 150, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 10);
        $Test->drawTitle(50, 22, "Producciones por Grupos", 50, 50, 50, 585);

        if (strpos(base_url(), "localhost")) {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1/img";
        } else {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/img";
        }
        $Test->Render($font_folder . "/grafica_de_barras_persona.png");
    }

    /**
     * Muestra la grafica de barras de producciones parra un docente especifico
     * @param type $username
     */
    public function prod_docente($username) {
        // Standard inclusions   
        include("application/libraries/pChart.1.27d/pChart/pData.class");
        include("application/libraries/pChart.1.27d/pChart/pChart.class");

        //obtener la consulta de ponderado de producciones por docente
        $query = $this->query_prod_docente($username);
        //convertir en array el resultado
        $resultado = $query->result_array();
        // Dataset definition
        $DataSet = new pData;
        //por cada uno de los resultados se realiza una especificacion del a tabla
        foreach ($resultado as $key => $value1) {
            foreach ($resultado[$key] as $nombreColumna => $contenido) {
                $DataSet->AddPoint(array($contenido), "Serie" . $nombreColumna);
                $DataSet->SetSerieName($nombreColumna, "Serie" . $nombreColumna);
            }
        }
        $DataSet->AddPoint(array("aqui iria el nombre del docente"), "XLabel");
        $DataSet->SetAbsciseLabelSerie("XLabel");
        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("XLabel");

        if (strpos(base_url(), "localhost")) {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1";
        } else {
            $font_folder = $_SERVER['DOCUMENT_ROOT'];
        }

        $ancho = 700;
        $alto = 500;
        // Initialise the graph
        $Test = new pChart($ancho, $alto);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 13);
        //dibujar el area del grafico centraal 
        $Test->setGraphArea(50, 30, $ancho - 40, $alto - 40);
        //dibujar el rectangulo ???
        $Test->drawFilledRoundedRectangle(7, 7, $ancho - 7, $alto - 7, 5, 240, 240, 240);
        //son las lineas del borde
        $Test->drawRoundedRectangle(5, 5, 695, 225, 5, 230, 230, 230);
        //
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2, TRUE);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);
        // Draw the 0 line
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);
        // Draw the bar graph
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE, 80);
        // Finish the graph
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 8);
        $Test->drawLegend(596, 150, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties($font_folder . "/application/libraries/pChart.1.27d/Fonts/tahoma.ttf", 10);
        $Test->drawTitle(50, 22, "Producciones publicadas", 50, 50, 50, 585);

        if (strpos(base_url(), "localhost")) {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/proyecto1/img";
        } else {
            $font_folder = $_SERVER['DOCUMENT_ROOT'] . "/img";
        }
        $Test->Render($font_folder . "/grafica_de_barras_docente.png");
    }

    /**
     * Graficar la cantidad de producciones que tiene un determinado docente
     * @param type $fini
     * @param type $ffin
     * return retorna la tabla generadad por una libreria del sistema para que pueda ser renderizada en la vista
     */
    public function query_prod_docente($login) {
        $sql = "
            SELECT COUNT( articulo.PROD_CODIGO ) AS Articulos,
            COUNT( monografia.PROD_CODIGO ) AS Monografias, 
            COUNT( reporte_tecnico.PROD_CODIGO ) AS Reportes_Tecnicos
            FROM produccion
            LEFT JOIN monografia ON produccion.PROD_CODIGO = monografia.PROD_CODIGO
            LEFT JOIN reporte_tecnico ON produccion.PROD_CODIGO = reporte_tecnico.PROD_CODIGO
            LEFT JOIN articulo ON produccion.PROD_CODIGO = articulo.PROD_CODIGO
            INNER JOIN usuario_produccion ON produccion.PROD_CODIGO = usuario_produccion.PROD_CODIGO
            INNER JOIN users on usuario_produccion.USU_CODIGO = users.id
            WHERE users.username = ?";
        return $this->db->query($sql, array($login));
    }

    /**
     * Graficar la cantidad de producciones que tiene un determinado docente
     * @param type $fini
     * @param type $ffin
     * return retorna la tabla generadad por una libreria del sistema para que pueda ser renderizada en la vista
     */
    public function query_graficar_docente_fecha($login, $fini, $ffin) {
        $sql = "
            SELECT COUNT( monografia.PROD_CODIGO ) AS contador, COUNT( reporte_tecnico.PROD_CODIGO ) AS contador1, COUNT( articulo.PROD_CODIGO ) AS contador2
            FROM produccion
            LEFT JOIN monografia ON produccion.PROD_CODIGO = monografia.PROD_CODIGO
            LEFT JOIN reporte_tecnico ON produccion.PROD_CODIGO = reporte_tecnico.PROD_CODIGO
            LEFT JOIN articulo ON produccion.PROD_CODIGO = articulo.PROD_CODIGO
            INNER JOIN usuario_produccion ON produccion.PROD_CODIGO = usuario_produccion.PROD_CODIGO
            INNER JOIN users on usuario_produccion.USU_CODIGO = users.id
            WHERE PROD_FECHA_PUBLICACION
            BETWEEN  ? AND  ? AND  users.username = ?";
        return $this->db->query($sql, array($fini, $ffin, $login));
    }

}
?> 
