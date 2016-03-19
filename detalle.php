<?php
require 'clases/actionsDB.php'; 
$id = $_GET['id'];

$objOperaciones = new ActionsDB();

//COnsultamos la informacion del usuario
$usr = $objOperaciones->getDatosPerfilID($id); 
foreach ($usr as $key) {
	$nombre = utf8_encode($key["nombre"].' '.$key['paterno'].' '.$key['materno']);
	$fechaIngreso = $key['fechaIngreso'];
}
//Consultamos la ultima solicitud realizada
$registro = $objOperaciones->verUltimSolicitudID($id);

//Consultamos todas las solicitudes realizadas por este usuario
$dat = $objOperaciones->verSolicitudes($id);
//print_r($dat);
foreach ($dat as $key) {
	$fechaSoli = $key['fecha'];
	$dias = $key['dias'];
	$adicionales = $key['adicionales'];
	$diasRestantes = $key['diasRestantes'];
}
?>
 
<!DOCTYPE html>
<html style="height: 100%; width: 100%;">
<head>
	<title>Detalle</title>
	<link rel="shortcut icon" type="image/gif" href="intraImg/animated_favicon1.gif" >
	<link href="intraCss/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href="intraCss/intraItw.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="intraCss/bootstrap/js/jquery.js"></script>
  	<script type="text/javascript" src="intraCss/bootstrap/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<style type="text/css">
	.disabled:hover{ 
		color:grey;
	}
</style>
<body style="padding-left: 20px">

	<div class="panel panel-primary">
    <div class="panel-heading">DATOS GENERALES</div>
    <div class="panel-body">
    	<table>
    		<tr >
    			<td rowspan="8" style="text-align: left;"><i class="fa fa-user fa-5x"></i>&#160;&#160;&#160;</td>
    		</tr>
    		<tr>
    			<td colspan="4"><strong>NOMBRE:</strong></thead>
    		</tr>
    		<tr>
    			<td colspan="4"><input type="text" value="<?php echo $nombre; ?>" disabled class="textboxBloqueado"></input></td>
    		</tr>
    		<tr>
    			<td colspan="2"><strong>FECHA INGRESO:</strong></td>
    			<td colspan="2"><strong>D&iacute;as Ley</strong></td>
    		</tr>
    		<tr>
    		 	<td colspan='2'><input type="text" class="textboxBloqueado" disabled value="<?php echo $fechaIngreso ;?>"></input></td>
    			<td colspan="2"><input type="text" class="textboxBloqueado" disabled value=""></input></td>
    		</tr>
    		<tr>
    			<td colspan="4" style="text-align: center;"><strong>ULTIMO PERIODO VACACIONAL</stron></td>
    		</tr>
    		<tr>
    			<td style="text-align: center;">Fecha</td>
    			<td style="text-align: center;">D&iacute;as Solictados</td>
    			<td style="text-align: center;">D&iacute;as Restantes</td>
    			<td style="text-align: center;">D&iacute;as Adicionales</td>
    		</tr> 
    		<tr>
    			<td><input type="text" style="text-align: center;" class="textboxBloqueado" disabled value="<?php echo $fechaSoli ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $dias; ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $diasRestantes; ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $adicionales; ?>"></input></td>
    		</tr> 			
    	</table>
    	</strong>
    	</div>
    </div>
    <div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES REALIZADAS POR USUARIO</div>
    <div class="panel-body">
    	<table class="table table-bordered" id="table_Solicitudes" style="position: inherit;"> 
			<thead>
			<tr>
				<th>N</th>
				<th>Acci&oacute;n</th>
				<th >Fecha de solicitud</th>
				<th >Fecha inicio</th>
				<th >Fecha fin</th>
				<th >D&iacuteas Solicitados</th>
				<th >D&iacuteas adicionales</th>
				<th>Documento soporte</th>
				<th >Estatus</th>
			</tr>
			</thead>
			<tbody id="jod">
				<?php 
					$nume = 0;
		      		foreach($dat as $row) {
		      			$nume +=1;
			      		//Determinar estutus solicitud
			      		if (($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 1) OR ($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 1) OR ($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 1)) {//pendientes
			      			$Estatus = "PENDIENTE";
			      		}else if (($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 2) OR ($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 2) OR ($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 2)) {//Aceptadas
			      			$Estatus = "APROBADA";
			      		}else if (($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 3) OR ($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 3) OR ($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 3)) {
			      			$Estatus = "RECHAZADA";
			      		}?>
							<tr id="celda">
									<td><?php echo$nume;?></td>
									<td><a href="" onclick="solicitud(<?php echo $row["solicitud_ID"];?>)">Generar reporte</a></td>
									<td><?php echo $row["fecha"]; ?></td>
									<td><?php echo $row["fecha1"]; ?></td>
									<td><?php echo $row["fecha2"]; ?></td>
									<td><?php echo $row["dias"]; ?></td>
									<td><?php echo $row["adicionales"]; ?></td>
									<td><a id="documento" <?php echo($row["documento"] == "cargar documento") ? "class='disabled'" : "href='descargarArchivo.php?id=".$row["solicitud_ID"]."'"; ?> ><?php echo $row["documento"]; ?> </a></td>
									<td><?php echo $Estatus; ?></td>
							</tr>
							<?php
					}		
		      	?>
			</tbody>
		</table>
		</div>
    </div>
</body>
</html>