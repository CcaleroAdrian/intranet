<?php
require 'clases/actionsDB.php';  

$id = $_POST['idArchivo'];
//********	DATOS DEL ARCHIVO 	***************************
//El nombre original del fichero en la máquina cliente. 
$fechaCarga=date('d/m/Y');
$nombreArchivo = $_FILES['documentos']['name'];
$nombreArchivo= $nombreArchivo.$fechaCarga;
//$nombreArchivo ="DocumentoSoporte(".$fechaCarga.").pdf";

//El tipo mime del fichero (si el navegador lo proporciona). Un ejemplo podría ser "image/gif". 
$typeArchivo = $_FILES['documentos']['type'];

//El tamaño en bytes del fichero recibido. 
$sizeArchivo = $_FILES['documentos']['size'];

//Destino donde se guardaran los archivos
$carpeta = "../intranet/DocumentosSoporte/".$nombreArchivo;

//**** 	VALIDACIONES DE CARGA Y TAMAÑO DE ARCHIVO 	**********
	if ($sizeArchivo < 10485760) {
		
		if (copy($_FILES['documentos']['tmp_name'], $carpeta)){
			$mensaje = "El archivo ha sido cargado correctamente.";
			$objOperaciones = new ActionsDB();
			$objOperaciones->updateArchivo($id,$nombreArchivo);
			header("Location: ../intranet/submenu_Solicitud_Vacaciones.php?mensaje='".$mensaje."'");
		}else{
			$mensaje = "Error al cargar el archivo.";
			header("Location: ../intranet/submenu_Solicitud_Vacaciones.php?mensaje='".$mensaje."'");
		}
		 
	}else{
		$mensaje = "El tamaño del archivo supera los 10 MB permitidos";
		header("Location: ../intranet/submenu_Solicitud_Vacaciones.php?mensaje='".$mensaje."'"); 
	}


?>