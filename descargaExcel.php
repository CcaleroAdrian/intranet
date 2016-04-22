<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php 
require 'Classes/PHPExcel.php';
require 'Classes/PHPExcel/Writer/Excel2007.php';
include 'Classes/PHPExcel/IOFactory.php';
//require 'Classes/PHPExcel/Writer/Excel2007.php';

error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);
date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

$objPHPExcel = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Reporte de Actividades ITW")
->setDescription("Reporte de actividades para proyectos de testing")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Pruebas de Excel");

// Agregar Informacion
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:C1');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1','Reporte de Actividades')
->setCellValue('B3', 'Nombre:')
->setCellValue('B4', 'Área:')
->setCellValue('B5', 'Período del Reporte:')
->setCellValue('B9', 'Fecha')
->setCellValue('C9', 'Hora de Entrada')
->setCellValue('D9', 'Actividades realizadas')
->setCellValue('E9', 'Problemas presentados')
->setCellValue('F9', 'Hora de Salida')
->setCellValue('G9', 'Total de Hrs al día');

$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="ReportedeActividadesITW.xlsx"');
//header('Cache-Control: max-age=0');
//En el navegador 
   header("Content-Type: application/force-download"); 
   header("Content-Type: application/octet-stream"); 
   header("Content-Type: application/download"); 
   header('Content-Disposition:inline;filename="ReportedeActividadesITW.xlsx"'); 
   header("Content-Transfer-Encoding: binary"); 
   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
   header("Pragma: no-cache"); 
   //$objWriter->save('php://output'); 
//$callStartTime = microtime(true);

$objWriter->save('php://output');
exit();
//$objWriter->save('ReportedeActividadesITW.xlsx');
//$callEndTime = microtime(true);
//$callTime = $callEndTime - $callStartTime;
?>