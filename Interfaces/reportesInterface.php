<?php


include('../Controladores/controladorReportes.php');
$reportesInterface = new reportesInterface();
$reportesInterface->realizarOperacion($_POST['opcion']);

class reportesInterface {

    var $cantidad;
    var $usuario;

    function __construct() {
        $this->cantidad=$_POST['variable'];
        
    }

    function realizarOperacion($opcion) {

        $controlReporte = new controladorReportes($this->cantidad);
        if ($opcion =='ver_Reporte')
            $controlReporte->creaReporte();
    }

}

?>
