//Calculo de vacaciones
$antiguedad = 0;
$fecha= $usr['fechaIngreso'];
if ($fecha != 0 OR $fecha !="" OR $fecha != null) {
	$fecha1 = time()-strtotime($fecha);
	$antiguedad =floor($fecha1 / 31536000);
}

if($antiguedad > 0){
  if ($antiguedad >= 4 OR $antiguedad <= 8) {
     $dias = $objOperaciones->verAntiguedad(4);
  }else if($antiguedad >=9 OR $antiguedad <= 13){
     $dias = $objOperaciones->verAntiguedad(9);
  }else if($antiguedad >=14 OR $antiguedad <= 18){
     $dias = $objOperaciones->verAntiguedad(14);
  }else if ($antiguedad >= 19 OR $antiguedad <= 23) {
    $dias = $objOperaciones->verAntiguedad(19);
  }else if ($antiguedad >= 24 OR $antiguedad <= 28){
    $dias = $objOperaciones->verAntiguedad(24);
  }else if ($antiguedad >= 29 OR $antiguedad <= 34) {
    $dias = $objOperaciones->verAntiguedad(29);
  }else{
    $dias = $objOperaciones->verAntiguedad($antiguedad);
  }
  foreach ($dias as $key ) {
    $vacaciones = $key['Dias'];
  }
}else{
  $vacaciones = 0;
}

$diasDescontar = 0;

//Consultamos la ultima solicitud exitosa
$ultimaSolicitud = $objOperaciones->verUltimSolicitudID($ID_USR);
	
	if ($ultimaSolicitud) {
		foreach ($ultimaSolicitud as $key) {
			$diasDescontar = $key['diasAdicionales'];
		}
		//Si hay dias a descontar
		if ($diasDescontar > 0) {
			//Consultar año de antiguedad cuando fué solicitado dias adicionales
			$año = $objOperaciones->verUltimSolicitudID($ID_USR);
			if ($antiguedad < ($antiguedad + 2)) {
				$vacaciones = $vacaciones - $diasDescontar;
			}else{

			}

		}else{
			$diasDescontar = 0;
		}
	}else{
		$diasDescontar = 0;
	}

	$vacaciones = $vacaciones - $diasDescontar;




$vacaciones = 0;
if ($usr['DiasLey'] <= 0) {
	$vacaciones = 0;
}else{
	$vacaciones = $usr['DiasLey'];
}