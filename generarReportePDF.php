<?php
//Recuperamos los datos del usuario para incluirlos en el documento
$cliente = utf8_encode($_GET['cliente']);
$usuario = $_GET['nombre'];
$vacaciones = $_GET['dias'];


$date2 = strtotime($_GET['fecha2']);
$date1 = strtotime($_GET['fecha1']);
$fecha1 = date("d-F-Y", $date1);
$fecha2 = date("d-F-Y",$date2);

require('pdf/fpdf.php');//incluir libreria

$pdf=new FPDF('P','cm','A4');//crear objeto PDF (indicando orientacion, unidad de medida, tamaño de hoja)
$pdf->SetMargins(2,2,1);
$pdf->AddPage();//añadir una nueva hoja
$pdf->SetFont('Arial','I',12);//indicar tipo de letra, negrita y tamaño

//Diseño de cabecera
$pdf->Image('intraImg/Header.png',1,1,19,2);
$dia = strftime("%d de %B del %Y");//obtenemos la fecha
$pdf->Ln(2.8);//salto de linea tipo float
$pdf->Cell(8,3,utf8_decode("México, D.F.,").$dia,0,1,'L');//Cell(ancho,alto,cadena,border,posicion,align)
$pdf->Cell(8,2,$cliente,0,0,'J');
$pdf->Ln(3.5);

//Cuerpo de documento
$mensaje = "Por medio de la presente desearía solicitar los ".$vacaciones." días de vacaciones correspondientes al año en curso. Cumpliendo con lo establecido en el reglamento interno de la empresa, hago constar por escrito, mi deseo por hacer validos los días de vacaciones que me corresponden. ";
$mensaje1 = "No habiendo ningún inconveniente de su parte, hago de su conocimiento que pretendo disfrutar mi plazo vacacional del día ".$fecha1." al ".$fecha2." del presente año.";
$mensaje2 = "Sin otro particular por el momento, reciba un cordial saludo.";

$pdf->Multicell(17,0.5,utf8_decode($mensaje),0,'J');//Multicell(ancho,alto,cadena,border,align)6
$pdf->Ln(0.5);
$pdf->Multicell(17,0.5,utf8_decode($mensaje1),0,'J');
$pdf->Ln(1.5);
$pdf->Cell(3,1,"",0,'L');
$pdf->Cell(13,1,$mensaje2,0,'C');//indicar tamaño de celda ancho, alto y contenidos
$pdf->Ln(1.5);
$pdf->Cell(7,1,"",0,'L');
$pdf->Cell(3,1,"Atentamente.",0,'J');
$pdf->Cell(7,1,"",0,'R');
$pdf->Ln(0.5);
$pdf->Cell(5,1,"",0,'L');
$pdf->Cell(6,1,utf8_decode($usuario),0,'C');

//Firma
$pdf->Ln(1);
$pdf->Line(7,23,13.8,23);
$pdf->Ln(3);
$pdf->Cell(5.2,1,"",0,'L');
$pdf->Cell(5,1,"Firma y nombre de quien autoriza");

//Pie de pagina
$pdf->Image('intraImg/Footer.png',1,27,19,2);

//$pdf->Cell(17,3,$pdf->Image('intraImg/Footer.png',1,1,19,2),0,1,'C');
$pdf->Output('Documento soporte','I');//cerramos el documento
?>