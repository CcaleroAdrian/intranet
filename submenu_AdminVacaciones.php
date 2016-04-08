<?php
include("intraHeader.php");	

	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}
	//Realizamos la consulta para el llenado de la tabla
	$objeRestultado = new ActionsDB();
	$datos = $objeRestultado->verDetalle();
	//print_r($datos);
	$DESCPERFIL_USR;
	$mensaje = isset($_GET['mensaje']) ? trim($_GET['mensaje']) : "";
	$error = isset($_GET['error']) ? trim($_GET['error']) : "";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function(){
		$('#admin').on('click',function(e){
			e.preventDefault();
		});

		$('#link').on('click',function(e){
			e.preventDefault();
		});

		var mensaje = "<?php echo $mensaje; ?>";
		var error = "<?php echo $error; ?>";
		if (mensaje != "") {
			swal({title: "SOLICITUD DE VACACIONES",
				   text: "¿Desea solicitar días de vacaciones adicionales?",
				   type:  "success",
				   confirmButtonColor: " #337ab7",
				   confirmButtonText: "ACEPTAR",
				   closeOnConfirm: false,
				   closeOnCancel: false}, 
				function(isConfirm){ 
				  if (isConfirm) {
				  	window.close();
				 }
			});
		}
		if (error != "") {
			swal({title: "CONFIRMACIÓN",text: error,type: "error",timer:3000,showConfirmButton:false});
		}
	});
	function verDetalle(id){
		var url = "detalle.php?id="+id+"&opcion="+1+"";
		window.open(url,"_blank", 'width=700px,height=550px,resizable=yes,toolbar=no');
	}
	
	function editarSolicitu(id){
		var url ="detalle.php?id="+id+"&opcion="+2+"";
		window.open(url,"_blank",'width=700px,height=300px,resizable=yes,toolbar=no');
	}
</script>
	<h3 align="left">ADMINISTRACIÓN DE VACACIONES</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">CONCENTRADO DE SOLICITUDES <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
    <form style="z-index: 1;">
    		<div class="input-group col-sm-12">
    		<span class="glyphicon glyphicon-search input-group-addon"></span>
  			<input id="filtroTabla" onkeyup="busqueda({opcion:3,id:0})" class="form-control glyphicon glyphicon-search" size="35" align="center" autofocus>
  			</div>
	</form><br>
		<table id="form1" class="table-responsive table-bordered">
			<thead >
				<th width="30pt" style="text-align: center;">N</th>
				<th width="20%" style="text-align: center;">Nombre</th>
				<th width="10%"style="text-align: center;">Días Ley</th>
				<th width="10%" style="text-align: center;">Días Solicitados</th>
				<th style="text-align: center;">Fecha de Solicitud</th>
				<th style="text-align: center;">Estatus</th>
				<?php if($DESCPERFIL_USR == 'SuperUsuario'){
					echo '<th style="text-align: center;">Acción</th>';
					}?>
			</thead>
			<tbody id="cuerpo">
			<?php
				$n = 0;
				foreach ($datos as $key ) {
					$n +=1;
					$us = $objeRestultado->notificarUsuario($key["user_ID"]);
					//print_r($us);
					foreach ($us as $value) {
						$Nombre= utf8_encode($value['nombre'].' '.$value['paterno'].' '.$value['materno']);
					}

					//Determinar estutus solicitud
		      		if (($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 1) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 1)) {//pendientes
		      			$Estatus = "PENDIENTE";
		      		}else if (($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 2) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 2)) {//Aceptadas
		      			$Estatus = "APROBADA";
		      		}else if (($key["aprobacion_L"] == 3 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 2 AND $key["aprobacion_D"] == 3) OR ($key["aprobacion_L"] == 1 AND $key["aprobacion_D"] == 3)) {
		      			$Estatus = "RECHAZADA";
		      		}
		      	?>
					<tr style="text-align:center">
							<td><?php echo $n; ?></td>
							<td style="text-align:left;"><a id="link" href="" onclick="verDetalle(<?php echo $key["user_ID"]; ?>)"><?php echo $Nombre; ?></a></td>
							<td><?php echo $key['diasCorrespondientes']; ?></td>
							<td><?php echo $key['diasSolicitados']; ?></td>
							<td><?php echo $key['fechaSolicitud']; ?></td>
							<td><?php echo $Estatus; ?></td>
							<?php if($DESCPERFIL_USR == 'SuperUsuario'){?>
							<td id="editarReg" style="text-align: center;"><a id="admin" href="" onclick="editarSolicitu(<?php echo $key["user_ID"];?>)">Editar</a></td>
							<?php }?>
					</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
	<!--style="border: solid; z-index:4; position: fixed; display: block; border-collapse: collapse;"-->
</body>
</html>



<?php
include("intraFooter.php");
?>