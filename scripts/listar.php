<?php
$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
require $raiz . "/Proyecto/lib/functions.php";
require $raiz . "/Proyecto/lib/varios.php";
require $raiz . "/Proyecto/clases/pdf/fpdf.php";

class PDF extends FPDF {
    // Cabecera de página
    public function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(50, 10, utf8_decode('Herbario on-line de la Sierra de Crevillent'), 0, 0, 'L');
        $this->Ln(20);
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(92, 184, 92);  //mismo color que success de Bootstrap 
$pdf->cell(0, 16, utf8_decode("COLECCIÓN DE PLANTAS"), 0, 1, "C");
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetDrawColor(92, 184, 92);
$pdf->SetLineWidth(0.5);


$planta = new Planta();
$planta->get();   //búsqueda de todas las plantas de la base de datos
if (count($planta->get_rows()) > 0) {
    $datos = $planta->get_rows();

    $pdf->SetTextColor(255, 255, 255); 
    $pdf->SetFillColor(92, 184, 92);
    $pdf->cell(8, 8, "id", 0, 0, "L", true);
    $pdf->cell(2, 8);
    $pdf->cell(38, 8, utf8_decode('Nombre Científico'), 0, 0, "C", true);
    $pdf->cell(2, 8);
    $pdf->cell(38, 8, "Nombre Castellano", 0, 0, "C", true);
    $pdf->cell(2, 8);
    $pdf->cell(38, 8, "Nombre Valenciano", 0, 0, "C", true);
    $pdf->cell(2, 8);
    $pdf->cell(28, 8, "Familia", 0, 0, "C", true);
    $pdf->cell(2, 8);
    $pdf->cell(20, 8, "Imagen", 0, 1, "C", true);
    $pdf->SetTextColor(0, 0, 0);
    
    $y = $pdf->y;
    $desplazamientoY = 0;
    foreach ($datos as $indice => $fila) {
        $x = $pdf->x;
        $desplazamientoX = 0;

        $pdf->SetXY($x + $desplazamientoX, $y);
        $pdf->cell($w = 10, 8, $fila['id_planta'], 0, 0, "L");
        $desplazamientoX += $w;
        $pdf->SetXY($x + $desplazamientoX, $y);
        $pdf->multiCell($w = 40, 8, $fila['nombre_cientifico'], 0, "L");
        $desplazamientoX += $w;
        $yAux = $pdf->y;
        if ($yAux > $desplazamientoY) {
            $desplazamientoY = $yAux;
        }
        $pdf->SetXY($x + $desplazamientoX, $y);
        $pdf->multiCell($w = 40, 8, $fila['nombre_castellano'], 0, "L");
        $desplazamientoX += $w;
        $yAux = $pdf->y;
        if ($yAux > $desplazamientoY) {
            $desplazamientoY = $yAux;
        }
        $pdf->SetXY($x + $desplazamientoX, $y);
        $pdf->multiCell($w = 40, 8, $fila['nombre_valenciano'], 0, "L");
        $desplazamientoX += $w;
        $yAux = $pdf->y;
        if ($yAux > $desplazamientoY) {
            $desplazamientoY = $yAux;
        }
        $pdf->SetXY($x + $desplazamientoX,  $y);
        $pdf->multiCell($w = 40, 8, $fila['familia'], 0, "L");
        $yAux = $pdf->y;
        if ($yAux > $desplazamientoY) {
            $desplazamientoY = $yAux;
        }

        $desplazamientoX += $w;
        if ($fila['foto_general'] != "") :
            $pdf->Image($raiz."/Proyecto".$fila['foto_general'], $desplazamientoX, $y +1 , $wi=20);
        else :
            $pdf->Image($raiz."/Proyecto/img/plantas/planta_default.jpg", $desplazamientoX, $y + 1, $wi=20);
        endif;
        $yAux = $pdf->y  + $wi*0.5;
        if ($yAux > $desplazamientoY) {
            $desplazamientoY = $yAux;
        }

        $y = $desplazamientoY + 2;
        $pdf->Line($x, $y, $desplazamientoX +$wi , $y);
    }
}else{
	$pdf->cell(0,10,"NO HAY PLANTAS GUARDADAS",0,"C");
}


$pdf->Output();
