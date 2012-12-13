<?php

require('../fpdf/fpdf.php');
include_once '../Controladores/controladorReportes.php';

class PDF extends FPDF {
//    
    
    
// Cabecera de página
    function Header() {
        // Logo
        //$this->Image('grafico.png',50,30,100,75,'png','');
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(30);
        // Título
        $this->Cell(120, 10, 'UnivalleMusic: Canciones mas escuchadas', 1, 0, 'C');
        // Salto de línea
        $this->Ln(100);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina  ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function TablaColores($header, $data) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(205, 102,29);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        $this->Cell(20);
        // Cabecera
        $w = array(20, 80, 45, 40);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 13, $header[$i], 1, 0, 'C', true);
        $this->Ln();
//        176;196;222
        // Restauración de colores y fuentes
        $this->SetFillColor(176, 196, 222);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell(20);
            $this->Cell($w[0], 10, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 10, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 10, $row[2], 'LR', 0, 'L', $fill);


            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
//    $this->Cell(array_sum($w),0,'','T');
        $this->Cell(20);
        $this->Cell(145, 0, '', 'T');
    }

}

$controladorReportes=new controladorReportes();
$datos=$controladorReportes->obtenerCancionesMasEscuchadas();

$header = array('Identificador', 'Nombre de la cancion', 'Nro. Reproducciones');



 //Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('grafico.png', 50, 30, 100, 75, 'png', '');

$pdf->SetFont('Times', '', 10);

$pdf->TablaColores($header, $datos);

$pdf->Output();
?>
