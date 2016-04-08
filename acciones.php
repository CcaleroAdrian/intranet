<?php
require 'clases/actionsDB.php';
$ID= isset($_POST['id']) ? trim($_POST['id']) : "";
$OPCION = isset($_POST['opcion'])  ? trim ($_POST['opcion']) : "";
$PAGINA =  isset($_POST['pagina']) ? trim ($_POST['pagina']) : "";
$AREA = isset($_POST['area']) ? trim($_POST['area']) : "";
$objectOperaciones = new actionsDB();

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
	default:
		break;
}

?>