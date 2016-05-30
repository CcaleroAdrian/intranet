<?php
require_once("clases/class.phpmailer.php");
$objOperaciones = new ActionsDB();


	$nombre = isset($_POST['nombreEmpleado']) ? trim($_POST['nombreEmpleado']): "";//nombre del empleado
	$diasSoli =isset($_POST['diasSolicitados']) ? trim($_POST['diasSolicitados']) : "";//dias solicitados
	$diasVa =isset($_POST['Vaca']) ? trim($_POST['Vaca']) : "";//dias de vacaciones correspondientes
	$fechaI = isset($_POST['fecha1']) ? trim($_POST['fecha1']) : "";//fecha inicio
	$fechaF = isset($_POST['fecha2']) ? trim($_POST['fecha2']) : "";//fecha fin
	$diasAdi= isset($_POST['DiasAdicionales']) ? trim($_POST['DiasAdicionales']) : "";//dias adicioneles
	$diasRestantes =  isset($_POST['DiasRestantes']) ? trim($_POST['DiasRestantes']) : "";//dias restantes
	$LiderID = isset($_POST['LiderID']) ? trim($_POST['LiderID']) : "";//Lider de area
	$directorID = 1;//Id del director
	$ID_USR = isset($_POST['ID_USR']) ? trim($_POST['ID_USR']) : "";//ID del usuario que solicita

	/*$otro = date("d-F-Y", $date);//fecha inicial de vacaciones
	$FechaFinal =date("d-F-Y", $dates);//fecha final de vacaciones
	$fechaIngreso = date("d-F-Y", $fechaIn);//fecha de ingreso
	$date = strtotime($_POST['fecha1']);//fecha Inicial
	$dates = strtotime($_POST['fecha2']);//fecha Final
	*/
	$objectAlta = new ActionsDB();
	$resultado =$objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,$diasRestantes,$LiderID,$directorID);

		if( $resultado ) {

		} else {
			$error = "Hubo un error al registrar su solicitud. Favor de intentarlo más tarde";
		}
}

/*//Actualizamos los dás ley del usuario;
			if ($diasVa < $diasSoli) {
				$dias = "-".$diasAdi;
				$objectAlta->editarDiasLey($dias,$ID_USR,1);
			}elseif ($diasVa > $diasSoli) {
				$objectAlta->editarDiasLey($diasRestantes,$ID_USR,1);
			}
			$success = "Se realiz&oacute; el registro de su solicitud " ;
			$usuarios = $objOperaciones->verSolicitudes($ID_USR,0,$TAMANO_PAGINA);
			//header("Refresh:0");
			*/

?>
