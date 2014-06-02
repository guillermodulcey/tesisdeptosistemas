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
        public function graficar_barras_idis(){        
            // Standard inclusions   
            include("/application/libraries/pChart.1.27d/pChart/pData.class");
            include("/application/libraries/pChart.1.27d/pChart/pChart.class");

            $monografias = $this->dao->get_count_producciones_grupo('IDIS','monografia');
            $articulos = $this->dao->get_count_producciones_grupo('IDIS','articulo');
            $reportes = $this->dao->get_count_producciones_grupo('IDIS','reporte_tecnico');

            // Dataset definition 
            $DataSet = new pData;

            $DataSet->AddPoint(array($monografias),"SerieMonografias");
            $DataSet->AddPoint(array($articulos),"SerieArticulos");
            $DataSet->AddPoint(array($reportes),"SerieReportes");
            $DataSet->AddPoint(array('Producciones'),"XLabel");        

            $DataSet->SetAbsciseLabelSerie("XLabel");
            //$DataSet->AddPoint(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");

            $DataSet->AddAllSeries();
            $DataSet->RemoveSerie("XLabel"); 
            //$DataSet->SetAbsciseLabelSerie();
            $DataSet->SetSerieName("Monografías","SerieMonografias");
            $DataSet->SetSerieName("Articulos","SerieArticulos");
            $DataSet->SetSerieName("Reportes","SerieReportes");

            $font_folder = $_SERVER['DOCUMENT_ROOT']."/proyecto1";

            // Initialise the graph
            $Test = new pChart(700,230);
            $Test->setFontProperties($font_folder."/application/libraries/pChart.1.27d/Fonts/tahoma.ttf",8);
            $Test->setGraphArea(50,30,680,200);
            $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
            $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
            $Test->drawGraphArea(255,255,255,TRUE);
            $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
            $Test->drawGrid(4,TRUE,230,230,230,50);
            // Draw the 0 line
            $Test->setFontProperties($font_folder."/application/libraries/pChart.1.27d/Fonts/tahoma.ttf",6);
            $Test->drawTreshold(0,143,55,72,TRUE,TRUE);
            // Draw the bar graph
            $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,80);
            // Finish the graph
            $Test->setFontProperties($font_folder."/application/libraries/pChart.1.27d/Fonts/tahoma.ttf",8);
            $Test->drawLegend(596,150,$DataSet->GetDataDescription(),255,255,255);
            $Test->setFontProperties($font_folder."/application/libraries/pChart.1.27d/Fonts/tahoma.ttf",10);
            $Test->drawTitle(50,22,"Producciones Grupo IDIS",50,50,50,585);

            $font_folder = $_SERVER['DOCUMENT_ROOT']."/proyecto1/img";
            $email = $this->session->userdata('username');
            $Test->Render($font_folder."/grafica_de_barras".$email.".png");            
    }
}
?> 
