<?php 
	require 'clases/actionsDB.php'; 

	$nombre = $_POST['q'];
	$opcion = $_POST['b'];
	$id = $_POST['id'];
	
	if ($opcion == 1) { 
			$objOperaciones = new ActionsDB();
			$resultado = $objOperaciones->busqueda($nombre,1);

			if ($resultado == 0 OR $resultado == -1) {
				echo "<tr><td colspan = '7'><p>No se encontraron resultados que coincidan</p></td><tr>";
			}else{
				foreach ($resultado as $row) {
				echo '<tr><td>'.$row["nombre"].' '.$row["paterno"].$row["materno"].'</td>
					<td>'.$row["usrIntranet"].'</td><td>'.$row["celOfna"].'</td>
					<td>'.$row["telOfna"].'</td><td>'.$row["celPersonal"].'</td>
					<td>'.$row["telPersonal"].'</td></tr>';
				}
			}
	} else if ($opcion == 2) {
			$objOperaciones = new ActionsDB();
			$resultado = $objOperaciones->verSolicitudesID($id,"","",$nombre);

			if ($resultado == 0 OR $resultado == -1) {
				echo "<tr><td colspan='7'><p>No se encontraron resultados que coincidan</p></td><tr>";
			}else{
				foreach ($resultado as $row) {
				$us = $objOperaciones-> notificarUsuario($row["user_ID"]);
					foreach ($us as $key) {
						$nombre = utf8_encode($key['nombre'].' '.$key['paterno'].' '.$key['materno']);
						echo '<tr><td>'.$nombre.'</td>
						<td>'.$row["fechaI"].'</td><td>'.$row["fechaF"].'</td>
						<td>'.$row["diasCorrespondientes"].'</td><td>'.$row["diasSolicitados"].'</td>
						<td><a href="#">Aceptar</a></td><td><a href="#">Rechazar</a></td></tr>';
					}
				}
			}
	}else if ($opcion == 3) {
			$objOperaciones = new ActionsDB();
			$resultado = $objOperaciones->verDetalle("","","",$nombre);

			if ($resultado == 0 OR $resultado == -1) {
				echo "<tr><td colspan='7'><p>No se encontraron resultados que coincidan</p></td><tr>";
			}else{
				$n=0;
				foreach ($resultado as $key) {
					
					//Determinar estutus solicitud
		      		if (($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 1)) {//pendientes
		      			$Estatus = "PENDIENTE";
		      		}else if (($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 2)) {//Aceptadas
		      			$Estatus = "APROBADA";
		      		}else if (($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 3)) {
		      			$Estatus = "RECHAZADA";
		      		}

						$nombre = utf8_encode($key['nombre'].' '.$key['paterno'].' '.$key['materno']);
						$n +=1;
						//echo "hola".print_r($resultado);
						echo '<tr style="text-align:center">
							<td>'.$n.'</td>
							<td><a href="" onclick="verDetalle('.$key["user_ID"].')"> VER </a></td>
							<td>'.$nombre.'</td>
							<td>'.$key['diasCorrespondientes'].'</td>
							<td>'.$key['diasSolicitados'].'</td>
							<td>'.$key['fechaSolicitud'].'</td>
							<td>'.$Estatus.'</td>
						</tr>';
				}
			}
	}
?>