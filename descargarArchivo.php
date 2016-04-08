<?php
require 'clases/actionsDB.php';
//*******	PROCESO PARA DESCARGA DE ARCHIVO ***********
$documento = $_GET['id'];
$fechaDescarga=date('d/m/Y');
if ($documento != "") {
	$objOperaciones = new ActionsDB();
	$archivo = $objOperaciones ->verNombre($documento);//obtenemos el nombre del archivo cargado previamente
	
	//comprobamo que haya devuelto almenos un resultado
	if ($archivo != -1 || $archivo != 0) {
		foreach ($archivo as $key) {
		$doc = $key['documento'];//extraemos el nombre del archivo subido
		}

		$Ncaracteres = strlen($doc);//obtenemos la longitud de la cadena
		$posicion = $Ncaracteres - 4;//Longitud de cadena menos 4 caracteres que indican la extension del archivo
		$extensionArchivo = substr($doc,$posicion);
		$file = "../intranet/DocumentosSoporte/".$doc;//formamos la ruta completa del archivo
		header( "Content-Disposition: attachment; filename=DocumentoSoporte(".$fechaDescarga.")".$extensionArchivo."");//nombre del archivo al ser descargado
		header( "Content-Type: aplication/pdf");
  		header( "Content-Length: ".filesize($file));
  		readfile($file);
	}
}
?>