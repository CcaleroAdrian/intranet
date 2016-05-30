<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');

$user = isset($_GET['id']) ? trim($_GET['id']) : "";
$mes = json_decode($_GET['meses'], true);
$anio = isset($_GET['anio']) ? trim($_GET['anio']) : "";

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

/** Include PHPExcel */
require dirname(__FILE__).'/Classes/PHPExcel.php';
require 'clases/actionsDB.php'; 
$objOperaciones = new ActionsDB();

//Extraer datos del usuario seleccionado
$usr = $objOperaciones->getDatosPerfilID($user); 
if ($usr != 0 || $usr != -1)   {
  foreach ($usr as $key) {
  $nombre = utf8_encode($key["nombre"].' '.$key['paterno'].' '.$key['materno']);
  $areaID = $key['area_ID'];
  }
}

$area = $objOperaciones->verAreas($areaID);
if ($area != 0 || $area != -1) {
	foreach ($area as $value) {
		$DescripcionA = $value['Descripcion'];
	}
}

// Instancia de la clase PHPExcel
$objPHPExcel = new PHPExcel();

// Propiedaes del documento
$objPHPExcel->getProperties()->setCreator("ITWORKERS")
							 ->setLastModifiedBy("ITWORKERS")
							 ->setTitle("REPORTE DE ACTIVIDADES")
							 ->setSubject("ENTREGABLA PARA PROYECTOS DE TESTING")
							 ->setDescription("DOCUMENTO DE EXCEL CON EL DETALLE DE ACTIVIDADES POR USUARIO.")
							 ->setKeywords("REPORTE ACTIVIDADES TESTING")
							 ->setCategory("REPORTE");

//Estilos para la hojas de excel
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Calibri',
        'bold'  => true,
        'size' => 12,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  		'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '005696'
        ),
        'endcolor' => array(
            'argb' => '005696'
        )
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array(
                'rgb' => 'FAFAFA'
            )
        ),
        'vertical' =>array(
        	'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        	'color' => array(
        		'rgb' => 'FAFAFA'
        	)
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
    )
);

$estiloT = array(
    'font' => array(
        'name'  => 'Calibri',
        'bold'  => false,
        'size' => 12,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  		'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '005696'
        ),
        'endcolor' => array(
            'argb' => '005696'
        )
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
            'color' => array(
                'rgb' => '0A0371'
            )
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'wrap'      => TRUE
    )
);

$estiloCeldasEditables = array(
	 'font' => array(
        'name'  => 'Calibri',
        'bold'  => false,
        'size' => 12,
        'color' => array(
            'rgb' => '030303'
        )
    )
);

$estilo = array(
	'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  		'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'D70206'
        ),
        'endcolor' => array(
            'argb' => 'F60509'
        )
    )
);

$estiloTitulos = array(
	'font' => array(
		'name' => 'Segoe UI Light',
		'bold' => true,
		'size' => 16,
		'color' => array(
			'rgb' => '#000000'
			)
		)
);

$estiloBodyTable = array(
		'borders' => array(
	        'bottom' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
	            'color' => array(
	                'rgb' => 'BDBDBD'
	            )
	        ),
	        'vertical' => array(
	        	'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
	        	'color' => array(
	        		'rgb' => 'BDBDBD' 
	        		)
	        )
    	),
    	'fill' => array(
    		'type'       => PHPExcel_Style_Fill::FILL_SOLID,
  			'rotation'   => 90,
       		'startcolor' => array(
            	'rgb' => 'E6E6E6'
       		),
	        'endcolor' => array(
	            'argb' => '6E6E6E'
	        )

    	)
);

$estiloSumatoria = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'rotation' => 90,
		'startcolor' => array(
			'rgb' =>'8DB4E2'
		)
	)
);

//Array con los meses del año
$mesAnio = array('ENERO'=>1 , 'FEBRERO'=>2, 'MARZO'=>3, 'ABRIL'=>4, 'MAYO'=>5, 'JUNIO'=>6, 'JULIO'=>7, 'AGOSTO'=>8, 'SEPTIEMBRE'=>9, 'OCTUBRE' =>10, 'NOVIEMBRE'=>11, 'DICIEMBRE'=>12);


$numeroDeHojas = sizeof($mes);

//ITERAMOS BASADOS EN EL NUMERO DE MESES SELECCIONADOS
for ($i=0; $i <=$numeroDeHojas-1 ; $i++) { 

	//buscamos el mes para colocarlo como nombre de la hoja
	$m = array_search($mes[$i], $mesAnio);
	setlocale (LC_TIME, 'spanish-mexican');

	//SE CALCULA EL PRIMER Y ULTIMO DIA DEL MES SELECCIONADO
	
	$month = date('m');
	$dia = date('d', mktime(0,0,0,$mes[$i]+1,$anio));

	$fecha1=date("d/F",mktime(0,0,0,$mes[$i],1,$anio));
	$fecha2=date('d/F',(mktime(0,0,0,$mes[$i]+1,1,$anio)-1));

	//Datos del documento
	$objPHPExcel->createSheet($i);
	$objPHPExcel->getSheet($i);
	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('B1:C1');	
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);	

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$objDrawing->setPath('../intranet/intraImg/itw.png');
	$objDrawing->setCoordinates('C3');
	$objDrawing->setOffsetX(380);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	$objDrawing->getShadow()->setVisible(true);
	$objDrawing->setHeight(72);



	$objPHPExcel->setActiveSheetIndex($i) 
				->setCellValue('B1', 'REPORTE DE ACTIVIDADES')
	            ->setCellValue('B3', 'Nombre:')
	            ->setCellValue('B5', 'Área:')
	            ->setCellValue('B7', 'Período del reporte:');

	$objPHPExcel->setActiveSheetIndex($i)
				->setCellValue('C3',$nombre)
				->setCellValue('C5',$DescripcionA)
				->setCellValue('C7', $fecha1.' al '.$fecha2.','.$anio);

	// Miscellaneous glyphs, UTF-8
	$objPHPExcel->setActiveSheetIndex($i)
	            ->setCellValue('B9', 'Fecha')
	            ->setCellValue('C9', 'Actividades realizadas')
	            ->setCellValue('D9','Total de HRS.');

	//Consulta de actividades por mes
	$fechaI=date("Y-m-d",mktime(0,0,0,$mes[$i],1,$anio));
	$fechaF=date('Y-m-d',(mktime(0,0,0,$mes[$i]+1,1,$anio)-1));

	$actividades = $objOperaciones->actividadesMesUsuario($user,$fechaI,$fechaF);

	$fila = 10;
	$horasTotales = 0;
	$fecha='';
	$actividad="";

	if ($actividades != 0 OR $actividades != -1) {
		foreach ($actividades as $value) {
			$horasTotales = ($horasTotales+$value['L']+ $value['Ma'] + $value['M'] + $value['J'] + $value['V']);
			$objPHPExcel->setActiveSheetIndex($i)
	            ->setCellValue('B'.$fila, $value['fechaActividad'])
	            ->setCellValue('C'.$fila, $value['actividad'])
	            ->setCellValue('D'.$fila, $horasTotales);
	        $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloBodyTable);
			
			$fila++;
		}
		
	}else{
		$objPHPExcel->setActiveSheetIndex($i)
			->setCellValue('C','No se encontraron actividades del usuario: '.$nombre. '\n en el mes de: '.$m);
	}
	
	$filaSum = $fila-1;
	//$objPHPExcel->setActiveSheetIndex($i)->mergeCells('B'.$columTotal.':C'.$columTotal.'');
	$objPHPExcel->getActiveSheet()->setAutoFilter('B9:D'.$filaSum);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':D'.$fila)->applyFromArray($estiloSumatoria);
	$objPHPExcel->setActiveSheetIndex($i)
			->setCellValue('C'.$fila,'Total de HRS.')
	        ->setCellValue('D'.$fila,"=SUM(D9:D".$filaSum.")");


	// RENOMBRAR LA HOJA DE EXCEL SOBRE, LA CUAL SE ESTA TRABAJANDO
	$objPHPExcel->getActiveSheet()->setTitle($m);//nombre del mes

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(66);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);

	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(13);
	$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(5);
	$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(5);
	$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(16);

	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setWrapText(true);

	$objPHPExcel->getActiveSheet()->getStyle('B9:D9')->applyFromArray($estiloTituloColumnas);

	$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($estiloT);
	$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($estiloT);
	$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($estiloT);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estilo);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);
	$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($estiloCeldasEditables);
	$objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($estiloCeldasEditables);
	$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($estiloCeldasEditables);
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte de Actividades ITW.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>