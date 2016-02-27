<?php
	require 'clases/actionsDB.php'; 

	$opcion = $_GET['opcion'];
	$id= $_GET['id'];

	if ($opcion == 1) {
		$objOperaciones = new ActionsDB();
		$resultado = $objOperaciones->procesarSolicitudes($id,$opcion);
		if ($resultado) {
			$mensaje ="Solicitud aceptada";
			header("Location : /intranet/submenu_SolicitudesVacaciones_Recibidas.php?mensaje=".$mensaje."");
		}
	}
?>