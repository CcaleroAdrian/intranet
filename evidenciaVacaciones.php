<?php
require('pdf/fpdf.php');//incluir libreria
require'clases/actionsDB.php'; 
//require('pdf/font/times.php');//incluir libreria
date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');
//Recuperar ID para consultar informacion del usuario

$id = $_GET['id'];//ID de la solicitud
$fechaDescarga=date('d/m/Y');
$RH = "Viviana Garcia Ramos";
$area = "";
$inicioLabores = "";
$nombreLider ="";

//Realizar consultas para generar documento
$objeResultado = new ActionsDB();
$solicitud = $objeResultado->verDetalle($id);
if ($solicitud) {
	foreach ($solicitud as $key) {
		$diasCorrespondientes = $key['diasCorrespondientes'];
		$diasSolicitados = $key['diasSolicitados'];
		$diasAdicionales = $key['diasAdicionales'];
		$fechaInicio = strftime('%A %d de %B del %Y',strtotime($key['fechaI']));
		$fechaFin = strftime('%A %d de %B del %Y',strtotime($key['fechaF']));
		$usuarioID = $key['user_ID'];
		$Date = $key['fechaF'];
		//Calcular dias restantes
		if ($diasCorrespondientes < $diasSolicitados) {
			$diasRestantes = 0;
		}else{
		$diasRestantes = $diasCorrespondientes - $diasSolicitados;
		}
	}
}


$usuario = $objeResultado->getDatosPerfilID($usuarioID);
if ($usuario) {
	foreach ($usuario as $key) {
		$Nombre=$key['nombre'].' '.$key['paterno'].' '.$key['materno'];
		$fechaIngreso = strftime('%d de %B del %Y',strtotime($key['fechaIngreso']));
		$fecha = $key['fechaIngreso'];
		$proyecto = $key['Proyecto_ID'];
		$idArea = $key['area_ID'];
	}
}

$lider = $objeResultado->mostrarResponzablesAsignacion($proyecto);
if ($lider) {
	foreach ($lider as $value) {
		$nombreLider = utf8_decode($value['nombre'].' '.$value['paterno'].' '.$value['materno']);
	}
}

$areasITW = $objeResultado->verAreas($idArea);
if ($areasITW) {
	foreach ($areasITW as $value) {
		$area = $value['Descripcion'];
	}
}

//Calcular años de antiguedad
$fecha1 = time()-strtotime($fecha);
$antiguedad =floor($fecha1 / 31536000);

//Calculamos el dia de inicio de labores
//1.Aumentamos 1 dia a la fecha final
$dia = strtotime ( '+1 day' , strtotime ($Date));//aumentamos un dia
$diaSemana = date ( 'l' , $dia );//Extraemos el dia de la semana al que corresponde la fecha
//2. Si esta es igual a sabado
if ($diaSemana == 'Saturday') {

	$dia = strtotime ( '+3 day' , strtotime ( $Date) ) ;//aumentamos un dia
	//$diaSemana = date ( 'l' , $dia );
	//if ($diaSemana != 'Saturday' AND $diaSemana != 'Sunday') {
		$dia = date('Y-m-j', $dia);
		$inicioLabores = strftime('%A %d de %B del %Y',strtotime($dia));//Damos formato a la fecha
	//}
}else{
	$d = strtotime ( '+1 day' , strtotime ($Date));//aumentamos un dia
	$d = date('Y-m-j', $d);
	$inicioLabores =strftime('%A %d de %B del %Y',strtotime($d));//Damos formato a la fecha
}





//**Iniciamos la creacion del documento
$pdf=new FPDF('P','cm','A4');//crear objeto PDF (indicando orientacion, unidad de medida, tamaño de hoja)
//$pdf->SetMargins(2,2,1);
$pdf->AddPage();//añadir una nueva hoja$pdf->Image('intraImg/Footer.png',1,27,19,2);
$pdf->SetMargins(1, 1,1);
$pdf->SetFont('Arial','B',12);//indicar tipo de letra, negrita y tamaño
$pdf->Cell(19.3,13.2,"",1);
$pdf->Image('intraImg/Header.png',1.2,1.04,19,2);
$pdf->Ln(1.5);
$pdf->Cell(6);
$pdf->Cell(9,0.6,"ACUSE DE VACACIONES AUTORIZADAS",0,'C');//9,0.6,,0,'C'
$pdf->Ln(1);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,"Nombre del empleado:",0,'R');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(7.5,0.6,$Nombre,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,utf8_decode("Área o Departamento:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(4.7,0.6,$area,0,'L');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,"Fecha ingreso:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(7.5,0.6,$fechaIngreso,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,utf8_decode("Años de servicio:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(0.4,0.6,$antiguedad,0,'C');
$pdf->Cell(1.5,0.6,utf8_decode("Año(s)"),0,'L');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,utf8_decode("Días que corresponden:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasCorrespondientes,0,'C');
$pdf->Cell(1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.3,0.6,utf8_decode("Días a disfrutar:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasSolicitados,0,'C');
$pdf->Cell(2.2);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.3,0.6,utf8_decode("Días pendientes:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasRestantes,0,'L');
$pdf->Cell(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.4,0.6,utf8_decode("Días adicionales:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasAdicionales,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(6,1,"PERIODO VACACIONAL",0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1,0.6,"Del:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(4,0.6,$fechaInicio,0,'C');
$pdf->Cell(0.6);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.6,0.6,"AL:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(6,0.6,$fechaFin,0,'C');
$pdf->Ln();
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,"Inicio de labores:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(6,0.6,$inicioLabores,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.7,0.5,"OBSERVACIONES:",0,'L');
$pdf->Cell(15.2,0.5,"",'B');
$pdf->Ln();
$pdf->Cell(0.5);
$pdf->Cell(17.6,0.5,"",'B');
$pdf->Ln();
$pdf->Cell(0.5);
$pdf->Cell(17.7,0.5,"",'B');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','I',6);
$pdf->Cell(6,0.3,"POR EL PRESENTE EXPRESO MI CONFORMIDAD DE SOLICITAR Y GOZAR MIS VACACIONES DE ACUERDO A LO QUE ESTABLECE EL ARTICULO 76 DE LA LEY FEDERAL DEL",0,'C');
$pdf->Ln();
$pdf->Cell(0.3);
$pdf->SetFont('Arial','I',6);
$pdf->Cell(6,0.3," TRABAJO, CONSIDERANDO LOS SIGUIENTES DATOS:",0,'C');
$pdf->Ln();
$pdf->Cell(12);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(2);
$pdf->Cell(1.6,0.6,utf8_decode("México, DF a:"),0,'L');
$pdf->Cell(6,0.6,strftime("%d de %B del %Y"),0,'R');//Fecha actual
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(0.5);
$pdf->Cell(5,0.5,$Nombre,'B',0,'C');
$pdf->Cell(0.8);
$pdf->Cell(6.2,0.5,$nombreLider,'B',0,'C');
$pdf->Cell(0.8);
$pdf->Cell(5,0.5,$RH,'B',1,'C');
$pdf->Ln(0);
$pdf->Cell(1.4);
$pdf->Cell(2,0.6,"Firma de Conformidad del emplado",0,'C');
$pdf->Cell(3.1);
$pdf->Cell(2,0.6,utf8_decode("Firma de Autorización del Líder de proyecto y/o Director"),0,'L');
$pdf->Cell(6);
$pdf->Cell(4,0.6,"Vo. Bo. Recursos Humanos",0,'C');
$pdf->Ln(0.3);
//$pdf->Cell(2,0.6,utf8_decode("Líder de proyecto y/o Director"),0,'L');
$pdf->Image('intraImg/Footer.png',1.1,12.88,19.1,1.3);
$pdf->Ln(2.2);

//GENERACION DEL SEGUNDO DOCUMENTO
$pdf->Cell(19.3,13.2,"",1);
$pdf->Image('intraImg/Header.png',1.2,14.5,19,2);
$pdf->Ln(1.5);
$pdf->Cell(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(9,0.6,"ACUSE DE VACACIONES AUTORIZADAS",0,'C');//9,0.6,,0,'C'
$pdf->Ln(1);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,"Nombre del empleado:",0,'R');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(7.5,0.6,$Nombre,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,utf8_decode("Área o Departamento:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(4.7,0.6,$area,0,'L');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,"Fecha ingreso:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(7.5,0.6,$fechaIngreso,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,utf8_decode("Años de servicio:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(0.4,0.6,$antiguedad,0,'C');
$pdf->Cell(1.5,0.6,utf8_decode("Año(s)"),0,'L');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3.7,0.6,utf8_decode("Días que corresponden:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasCorrespondientes,0,'C');
$pdf->Cell(1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.3,0.6,utf8_decode("Días a disfrutar:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasSolicitados,0,'C');
$pdf->Cell(2.2);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.3,0.6,utf8_decode("Días pendientes:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasRestantes,0,'L');
$pdf->Cell(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.4,0.6,utf8_decode("Días adicionales:"),0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(1,0.6,$diasAdicionales,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(6,1,"PERIODO VACACIONAL",0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1,0.6,"Del:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(4,0.6,$fechaInicio,0,'C');
$pdf->Cell(0.6);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0.6,0.6,"AL:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(6,0.6,$fechaFin,0,'C');
$pdf->Ln();
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(3,0.6,"Inicio de labores:",0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(6,0.6,$inicioLabores,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(2.7,0.5,"OBSERVACIONES:",0,'L');
$pdf->Cell(15.2,0.5,"",'B');
$pdf->Ln();
$pdf->Cell(0.5);
$pdf->Cell(17.6,0.5,"",'B');
$pdf->Ln();
$pdf->Cell(0.5);
$pdf->Cell(17.7,0.5,"",'B');
$pdf->Ln(0.6);
$pdf->Cell(0.3);
$pdf->SetFont('Arial','I',6);
$pdf->Cell(6,0.3,"POR EL PRESENTE EXPRESO MI CONFORMIDAD DE SOLICITAR Y GOZAR MIS VACACIONES DE ACUERDO A LO QUE ESTABLECE EL ARTICULO 76 DE LA LEY FEDERAL DEL",0,'C');
$pdf->Ln();
$pdf->Cell(0.3);
$pdf->SetFont('Arial','I',6);
$pdf->Cell(6,0.3," TRABAJO, CONSIDERANDO LOS SIGUIENTES DATOS:",0,'C');
$pdf->Ln();
$pdf->Cell(12);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(2);
$pdf->Cell(1.6,0.6,utf8_decode("México, DF a:"),0,'L');
$pdf->Cell(6,0.6,strftime("%d de %B del %Y"),0,'R');//Fecha actual
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(0.5);
$pdf->Cell(5,0.5,$Nombre,'B',0,'C');
$pdf->Cell(0.8);
$pdf->Cell(6.2,0.5,$nombreLider,'B',0,'C');
$pdf->Cell(0.8);
$pdf->Cell(5,0.5,$RH,'B',1,'C');
$pdf->Ln(0);
$pdf->Cell(1.4);
$pdf->Cell(2,0.6,"Firma de Conformidad del emplado",0,'C');
$pdf->Cell(3.1);
$pdf->Cell(2,0.6,utf8_decode("Firma de Autorización del Líder de proyecto y/o Director"),0,'L');
$pdf->Cell(6);
$pdf->Cell(4,0.6,"Vo. Bo. Recursos Humanos",0,'C');
$pdf->Ln(0.3);
$pdf->Image('intraImg/Footer.png',1.2,26.28,19,1.3);
$pdf->Output('AcuseDeVaciones('.$fechaDescarga.').pdf','I');//cerramos el documento
?>