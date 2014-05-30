<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Grafica_torta_idis extends CI_Model {
        function __construct() {
            parent::__construct();
            
        
            
        }
        function dibujar(){            
            require_once("/application/libraries/jpgraph/src/jpgraph.php");
            require_once("/application/libraries/jpgraph/src/jpgraph_pie.php");
            require_once("/application/libraries/jpgraph/src/jpgraph_pie3d.php");
            $monografias = 3;
            $articulo = 2;
            $reporte_tecnico = 2;
            //$monografias= "SELECT count(pro_codigo) FROM monografia WHERE pro_grupo_investigacion='IDIS'";
            //$articulo="SELECT count(pro_codigo) FROM articulo WHERE pro_grupo_investigacion='IDIS'";
            //$reporte_tecnico="SELECT count(pro_codigo) FROM reporte_tecnico WHERE pro_grupo_investigacion='IDIS'";
           $data= array ($monografias, $articulo,$reporte_tecnico);

            //$data = array(40,60,21);

            $graph = new PieGraph(450,250,"auto");
            $graph->img->SetAntiAliasing();
            // $graph->SetAntiAliasing();
            $graph->SetMarginColor('gray');
            //$graph->SetShadow();

            // Setup margin and titles
            $graph->title->Set("ESTADISTICAS DEL GRUPO IDIS");

            $p1 = new PiePlot3D($data);
            $p1->SetSize(0.35);
            $p1->SetCenter(0.5);

            // Setup slice labels and move them into the plot
            $p1->value->SetFont(FF_FONT1,FS_BOLD);
            $p1->value->SetColor("black");
            $p1->SetLabelPos(0.2);

            $nombres=array("Monografias","Articulos","ReportesTecnico");
            $p1->SetLegends($nombres);

            // Explode all slices
            $p1->ExplodeAll();

            $graph->Add($p1);
            //$graph->Stroke();
            return $graph;
        }
}
?> 
