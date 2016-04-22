<?php
require 'clases/actionsDB.php';
$ID= isset($_POST['id']) ? trim($_POST['id']) : "";
$OPCION = isset($_POST['opcion'])  ? trim ($_POST['opcion']) : "";
$PAGINA =  isset($_POST['pagina']) ? trim ($_POST['pagina']) : "";
$AREA = isset($_POST['area']) ? trim($_POST['area']) : "";
$objectOperaciones = new actionsDB();

$FECHA =isset($_POST['fecha']) ?  trim($_POST['fecha']) : "";
$ACTIVIDAD =isset($_POST['actividad']) ? trim($_POST['actividad']) : "";
$GERENTE = isset($_POST['gerente']) ? trim($_POST['gerente']) : "";
$LUNES= isset($_POST['lunes']) ? trim($_POST['lunes']) : "";
$MARTES= isset($_POST['martes']) ? trim($_POST['martes']) : "";
$MIERCOLES= isset($_POST['miercoles']) ? trim($_POST['miercoles']) : "";
$JUEVES = isset($_POST['jueves']) ? trim($_POST['jueves']) : "";
$VIERNES = isset($_POST['viernes']) ? trim($_POST['viernes']) : "";
$MES= isset($_POST['mes']) ? trim($_POST['mes']) : "";

$FECHA1 =isset($_POST['fecha1']) ?  trim($_POST['fecha1']) : "";
$FECHA2 =isset($_POST['fecha2']) ?  trim($_POST['fecha2']) : "";

$SOLICITUD_ID = isset($_POST['solicitudID']) ? trim($_POST['solicitudID']) : "";
$F1 = date($FECHA1);
$F2 = date($FECHA2);

switch ($OPCION) {
	case 1:
			$nombre = $objectOperaciones->verNombre($ID);
			if ($nombre != -1 OR $nombre != 0) {
				foreach ($nombre as $key) {
					$documento = $key['documento'];
				}
				if ($documento == "cargar documento") {
					echo "<script>
						document.getElementById('cargaArchivo').style.visibility= 'initial';
						$('#idRegistro').val(".$ID.");
					</script>";
				}else{
					echo "<script>
						var url = 'descargarArchivo.php?id='+idRegistro+'';
						window.open(url,'_parent');
					 </script>";
				}
			}
			break;
	case 2:
			echo '<table class="table table-bordered" id="table_Solicitudes"> 
				<thead>
				<tr>
					<th >Fecha de solicitud</th>
					<th >Fecha inicio</th>
					<th >Fecha fin</th>
					<th >D&iacuteas Solicitados</th>
					<th >D&iacuteas adicionales</th>
					<th>Documento soporte</th>
					<th>Estatus</th>
				</tr>
				</thead>
				<tbody id="jod">';
			$nume = 0;
			$total_paginas=0;
			$numRegi = 0;
			$usuarios = array();
			$dat = $objectOperaciones->verSolicitudes($ID);
			if ($dat == 0 OR $dat == -1) {
			
				$error2 = "No fué posible recuperar las solicitudes realizadas anteriormente";
			}else{
				
				$numRegi = count($dat);
				$TAMANO_PAGINA = 5;
				
				//examino la pagina a mostrar y el inicio del registro a mostrar
			    if ($PAGINA == 0){
			    	$inicio = 0;
			    	$paginaAct = 1; 
			    }else{
			    	$inicio = ($PAGINA - 1) * $TAMANO_PAGINA; 
			    	$paginaAct = $PAGINA;
			    }
				//calculo el total de páginas 
				$total_paginas = ceil($numRegi / $TAMANO_PAGINA); 
				$usuarios = $objectOperaciones->verSolicitudes($ID,$inicio,$TAMANO_PAGINA);
			}

			/*$numeros = array();
			if ($numRegi != 0 or $numRegi != -1) {
				//Llenamos un array con los numeros de registros
				for ($i=1;$i<=$numRegi;$i++) {
					array_push($numeros,$i);
				}
			}*/
			
			if ($usuarios != 0 OR $usuarios!= -1) {
				foreach($usuarios as $row) {
				//Determinar estutus solicitud
			    if ($row["adicionales"] != 0) {
			    	
			    	if ($row["aprobacion1"] == 1) {//Estatus pendiente
			      		$Estatus = "PENDIENTE";
			      	}else if ($row["aprobacion1"] == 2) {
			      		$Estatus = "APROBADA";
			      	}else{
			      		$Estatus = "RECHAZADA";
			      	}

			    }else{
			      	
			      	if ($row["aprobacion1"] == 1) {
			      		$Estatus = "PENDIENTE";
			      	}elseif ($row["aprobacion1"] == 2) {
			      		$Estatus = "APROBADA";
			      	}else{
			      		$Estatus = "RECHAZADA";
			      	}
			    } 
			     
			    if ($row["documento"] != "cargar documento") {
			     	$accion = "href='descargarArchivo.php?id=".$row["solicitud_ID"]."'";
			    }else{
			    	$accion ="";
			    }
				echo "<tr>
						<td>".$row["fecha"]."</td>
						<td>".$row["fecha1"]."</td>
						<td>".$row["fecha2"]."</td>
						<td style='text-align: center;'>".$row["dias"]."</td>
						<td style='text-align: center;'>".$row["adicionales"]."</td>
						<td><a ".$accion." data-input='".$row["documento"]."' data-id=".$row['solicitud_ID']." onclick='cargarDocumento(this)'>".$row["documento"]."</a></td>
						<td>".$Estatus."</td>
					</tr>";
				//array_shift($numeros);
				//echo $numeros[0];
			}	
			}
			

			echo "</tbody></table>";
			echo "<p>";
				if ($total_paginas > 1) {

					if ($paginaAct > 1) {
							echo '<a id="uno" onclick="paginacion('.($paginaAct - 1).')"><span class="glyphicon glyphicon-chevron-left"></span></a>';
					}
					for ($i=1;$i<=$total_paginas;$i++) {
						if ($paginaAct == $i) {
							echo $i;
						}else{
							echo '  <a id="dos" onclick="paginacion('.$i.')">'.$i.'</a>  ';
						}
					}
					if ($paginaAct < $total_paginas) {
							echo '<a id="tres" onclick="paginacion('.($paginaAct +1) .')" ><span  class="glyphicon glyphicon-chevron-right"></span></a>';
					}
				}

				echo "</p>";
				echo '<div class="col-sm-10" id="cargaArchivo" style="display:none;" ><!---->
				<form class="form-inline" action="cargaArchivo.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<input type="text" value="" style="display: none" id="idRegistro" name="idArchivo"></input>
				<label>Documento soporte:</label>
				<input id="document" class="form-control" name="documentos" type="file" accept="*"></input>
				<button type="sumit" class="btn btn-primary">CARGAR</button>
				</div>
				</form>
				</div>
				</div>';  	
			break;
	case 3:
				$usuario = $objectOperaciones->asignarGerente($ID,$AREA);
				echo $usuario;
		break;
	case 4:
				$usuario = $objectOperaciones->eliminarGerente($ID,$AREA);
				echo $usuario;
		break;
	case 5:
				$respuesta = $objectOperaciones->guardadActividad($ID,$FECHA,$ACTIVIDAD,$GERENTE,$LUNES,$MARTES,$MIERCOLES,$JUEVES,$VIERNES,$MES);
				if ($respuesta == true) {
					
					//Retornamos la consulta$actividades = $objectOperaciones->actividadesMesUsuario($ID,$FECHA1,$FECHA2);
					consultarDatos($ID,$FECHA1,$FECHA2);
				}else{
					echo 'false';
				}
		break;
	case 6:
			consultarDatos($ID,$FECHA1,$FECHA2);
		break;
	case  7:
				$actividad = $objectOperaciones->consultarActividadID($ID);
				if ($actividad != 0 OR $actividad != -1) {
					echo json_encode($actividad);
				}
		break;
	case 8:
				   $actidadUpdate = $objectOperaciones->updateActividad($SOLICITUD_ID,$FECHA,$ACTIVIDAD,$LUNES,$MARTES,$MIERCOLES,$JUEVES,$VIERNES);

					if ($actidadUpdate != 0 OR $actidadUpdate != -1) {
						consultarDatos($ID,$FECHA1,$FECHA2);
					}
		break;
	case 9:
			$actividadDelete = $objectOperaciones->deleteActividad($SOLICITUD_ID);
			try {
				consultarDatos($ID,$FECHA1,$FECHA2);
			} catch (Exception $e) {
				echo 'Message: ' .$e->getMessage();
			}
		break;
	case 10:
		visualizaReport($ID,$F1,$F2);
		break;
	default:
		break;
}

function consultarDatos($id,$fecha1,$fecha2){
	
	try {
	$objectOperaciones = new actionsDB();
	$actividades = $objectOperaciones->actividadesMesUsuario($id,$fecha1,$fecha2);
				$horasTotales = 0;
				if ($actividades != 0 OR $actividades != -1) {
					foreach ($actividades as $v) {
						$horasTotales= ($horasTotales + ($v["L"] + $v["Ma"] +$v["M"] +$v["J"] + $v["V"]));
						echo '<tr id="fila">
   						<td style="width:2px;">
   						<a class="fa fa-pencil" onclick="modificar('.$v["actividad_ID"].')"></a>&#32;<a  class="table-remove fa fa-times" onclick="borrar('.$v["actividad_ID"].')"></a></td>
   						<td contenteditable="false" style="width:110px;"><input type="date" style="width: 130px; border:none;" readonly="true" value="'.$v["fechaActividad"].'"></input></td>
   						<td contenteditable="false">'.$v["actividad"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["L"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["Ma"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["M"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["J"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["V"].'</td>
   						</tr>';
					}
					if ($horasTotales>= 40 OR $horasTotales<= 79) {
						echo "<tr><td colspan='8' class='active'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
					}else if ($horasTotales>= 80 OR $horasTotales<= 119) {
						echo "<tr><td colspan='8'  class='warning'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
					}else if ($horasTotales>= 120 OR $horasTotales<= 159) {
						echo "<tr><td colspan='8'  class='info'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
					}else if ($horasTotales>= 160) {
						echo "<tr><td colspan='8' class='success'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
					}else{
						echo "<tr><td colspan='8' class='danger'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
					}
				}
	} catch (Exception $e) {
		//echo 'Message: ' .$e->getMessage();
	}
}

function visualizaReport($id,$fecha1,$fecha2){
	try {
	$objectOperaciones = new actionsDB();

	$actividades = $objectOperaciones->actividadesMesUsuario($id,$fecha1,$fecha2);
				$horasTotales = 0;
				if ($actividades != -1 OR $actividades != null) {
					foreach ($actividades as $v) {
						$horasTotales= ($horasTotales + ($v["L"] + $v["Ma"] +$v["M"] +$v["J"] + $v["V"]));
						echo '<tr id="fila">
   						<td contenteditable="false" style="width:110px;"><input type="date" style="width: 130px; border:none;" readonly="true" value="'.$v["fechaActividad"].'"></input></td>
   						<td contenteditable="false">'.$v["actividad"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["L"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["Ma"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["M"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["J"].'</td>
   						<td contenteditable="false" style="width: 1px;">'.$v["V"].'</td>
   						</tr>';
					}
						echo "<tr><td colspan='8' class='danger'><label style='margin-left:85%;'>TOTAL HRS: ".$horasTotales."</label></td></tr>";
				}else{
					echo "No se encontrarón actividades del usuario en este mes.";
				}
	} catch (Exception $e) {
		echo 'Message: ' .$e->getMessage();
	}
}

?>