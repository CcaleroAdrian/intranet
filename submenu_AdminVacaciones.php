<?php
include("intraHeader.php");	

	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}
	//Realizamos la consulta para el llenado de la tabla
	$objeRestultado = new ActionsDB();
	$datos = $objeRestultado->verDetalle();
	//print_r($datos);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript">
	function verDetalle(id){
		var url = "detalle.php?id="+id+"";
		window.open(url,"_blank", 'width=650px,height=550px,resizable=yes,toolbar=no');
	}
</script>
	<h3 align="left">ADMINISTRACIÓN DE VACACIONES</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">CONCENTRADO DE SOLICITUDES</div>
    <div class="panel-body">
		<table id="form1" class="table-responsive table-bordered">
			<thead >
				<th width="30pt" style="text-align: center;">N</th>
				<th width="13%" style="text-align: center;">Ver detalle</th>
				<th width="20%" style="text-align: center;">Nombre</th>
				<th width="10%"style="text-align: center;">Días Ley</th>
				<th width="10%" style="text-align: center;">Días Solicitados</th>
				<th style="text-align: center;">Fecha de Solicitud</th>
				<th style="text-align: center;">Estatus</th>
			</thead>
			<tbody>
			<?php
				$n = 0;
				foreach ($datos as $key ) {
					$n +=1;
					$us = $objeRestultado->notificarUsuario($key["user_ID"]);
					//print_r($us);
					foreach ($us as $value) {
						utf8_encode(($Nombre= $value['nombre'].' '.$value['paterno'].' '.$value['materno']));
					}

					//Determinar estutus solicitud
		      		if (($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 1)) {//pendientes
		      			$Estatus = "PENDIENTE";
		      		}else if (($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 2)) {//Aceptadas
		      			$Estatus = "APROBADA";
		      		}else if (($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 3)) {
		      			$Estatus = "RECHAZADA";
		      		}

		      		//imprimimos resultados
					echo '<tr style="text-align:center">
							<td>'.$n.'</td>
							<td><a href="" onclick="verDetalle('.$key["user_ID"].')"> VER </a></td>
							<td>'.$Nombre.'</td>
							<td>'.$key['diasCorrespondientes'].'</td>
							<td>'.$key['diasSolicitados'].'</td>
							<td>'.$key['fechaSolicitud'].'</td>
							<td>'.$Estatus.'</td>
						</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</body>
</html>



<?php
include("intraFooter.php");
?>