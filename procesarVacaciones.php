<?php
require 'clases/actionsDB.php'; 
require_once("clases/class.phpmailer.php");

$DIRECTOR = 1;
$objOperaciones = new ActionsDB();
$mensaje= "";
$error = "";
$diaSVacaciones= 0;
	
	$LIDER =isset($_POST['LIDER']) ? trim($_POST['LIDER']) : "";
	$ID_USR = isset($_POST['ID_USR']) ? trim($_POST['ID_USR']) : "";
	$diasSoli =isset($_POST['DIASSOC']) ? trim($_POST['DIASSOC']) : "";//dias solicitados
	$diasVa =isset($_POST['DIASC']) ? trim($_POST['DIASC']) : "";//dias de vacaciones correspondientes
	$fechaI = isset($_POST['FECHAI']) ? trim($_POST['FECHAI']) : "";//fecha inicio
	$fechaF = isset($_POST['FECHAF']) ? trim($_POST['FECHAF']) : "";//fecha fin
	$diasAdi= isset($_POST['DIASAD']) ? trim($_POST['DIASAD']) : "";//dias adicioneles
	$diasRestantes =  isset($_POST['DIASRES']) ? trim($_POST['DIASRES']) : "";//dias restantes

	if ($diasAdi > 0) {
		$diaSVacaciones = -$diasAdia;
	}else{
		$diaSVacaciones = $diasRestantes;
	}
	
	
	$objectAlta = new ActionsDB(); 
	$resultado =$objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,$diasRestantes,$LIDER,$DIRECTOR);
		
		if( $resultado ) {
			echo $diaSVacaciones;
		} 
?>


