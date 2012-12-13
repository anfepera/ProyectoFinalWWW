<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controladorReportes
 *
 * @author anfepera
 */
include_once('../Clases/Conexion.php');
include_once("../jpgraph/jpgraph.php");
include_once("../jpgraph/jpgraph_pie.php");
include_once("../jpgraph/jpgraph_pie3d.php");


$conexionBD = new Conexion();
$conexionBD->conectar();

class controladorReportes {

    var $cantidad;
    var $canciones;
    var $numeroReproducciones;
    var $tituloCanciones;

    function __construct($cantidad) {
        $this->cantidad = $cantidad;
    }

    function creaReporte() {
//        echo 'creaReporte controlador reprote';
        $this->obtenerArrays();
        $this->obtenerGrafico();
        include_once("../Clases/generadorPDF.php");

    }

    //put your code here
    //funcion usada para llenar la tabla
    function obtenerCancionesMasEscuchadas() {

        $datosCanciones = array();
        $consulta = mysql_query("select id,titulo,no_reproducciones from Cancion ORDER BY no_reproducciones DESC");
        $cont = 0;
        while ($fila = mysql_fetch_array($consulta)) {
            $datosCanciones[$cont][0] = $fila['id'];
            $datosCanciones[$cont][1] = $fila['titulo'];
            $datosCanciones[$cont][2] = $fila['no_reproducciones'];
//            echo $datosCancion[$cont][0] .$datosCancion[$cont][1] . $datosCancion[$cont][2] ;
            $cont++;
        }
        return $datosCanciones;
    }

    function obtenerGrafico() {
//        echo 'obtener grafico';


        $graph = new PieGraph(550, 300, "auto");
        $graph->img->SetAntiAliasing();
        $graph->SetMarginColor('gray');
//$graph->SetShadow();
// Setup margin and titles
        $graph->title->Set("Reporte : Canciones Mas Escuchadas");

        $p1 = new PiePlot3D($this->numeroReproducciones);
        $p1->SetSize(0.45);
        $p1->SetCenter(0.4);

// Setup slice labels and move them into the plot
        $p1->value->SetFont(FF_FONT1, FS_BOLD);
        $p1->value->SetColor("black");
        $p1->SetLabelPos(0.5);

        $p1->SetLegends($this->tituloCanciones);
        $p1->ExplodeAll();

        $graph->Add($p1);
        //$graph->Stroke(); 
        //$img = $graph->Stroke(_IMG_HANDLER);
        //$nombre = "grafico.jpg";
        $im = $graph->Stroke("grafico.png");
    }

    //funcion usuada para generar los arrays que necesita el grafico
    function obtenerArrays() {
        $consulta = "SELECT no_reproducciones,titulo FROM Cancion order by no_reproducciones DESC LIMIT $this->cantidad";
        $query = mysql_query($consulta);

        
        while ($row = mysql_fetch_array($query)) {
           
            $this->numeroReproducciones[] = $row[0];
            $this->tituloCanciones[] = $row[1];

        }
       
    }

    
}

?>
