<?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

	//CARGA DE INFORMACION DE USUARIO
$objOperaciones = new ActionsDB();
// Obtenemos los campos de la tabla usuarios para presentarla en la solicitud
	$usr = $objOperaciones->getDatosPerfil($USUARIO);
	If ( $usr == -1  OR  $usr == 0 ) {
		$error1 = "No fué posible recuperar la informaci&oacute;n del usuario: ";
	} 

	$dat = $objOperaciones->verSolicitudes($ID_USR);

	//	print_r($dat);
	If ($dat == 0 ) {
		$VisualizarR = false;
		$error2 = "No fué posible recuperar las solicitudes realizadas anteriormente";
	}else{
		$VisualizarR = true;
	}
?>
<meta http-equiv=content-type content=text/html; charset=utf-8>
<script type="text/javascript" src="js/solicitud.js"></script>
	<h3 align="left">SOLICITUD DE PERMISOS</h3>

	<form  id="form" name="frmSolicitud" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";  ?>" enctype="multipart/form-data" method="post" height="350pt"  >

	<!--correo_notificacion.php?fecha=<?php echo $usr['fechaIngreso']; ?>-->
	<div class="panel panel-primary">
    <div class="panel-heading">CAPTURA <a href="" onclick=""><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
		<table id="form1" class="table-responsive">
			<tr >
				<td><label>Nombre del empleado:</label></td>
				<td colspan="3"><input id="nombreUser" name="nombreEmpleado" class="bloqueado" value="<?php echo utf8_encode($usr['nombre'].' '.$usr['paterno'].' '.$usr['materno']);?>" disabled></input></td>
			</tr>
			<tr>
				<td><label >&#193rea o departamento:</label></td>
				<td><input id="area" name="area" class="bloqueado" value="Desarrollo " disabled></input></td>
				<td>&#160;</td>
			</tr>
			<tr>
				<td><label>Categoría:</label></td>
				<td><select class="form-control">
					<option value="">--Seleccionar--</option>
					<option value="">Incapacidad</option>
					<option value="">Personal</option>
					<option value="">Enfermedad</option>
				</select></td>
				<td>&#160;</td>
				<td><label>D&iacuteas solicitados:</label></td>
				<td><input id="diasSolicitados" name="diasS" value="" class="bloqueado" disabled></input></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
			<td ><label>Fecha inicio:</label></td>
				<td ><input id="fecha1" size="10" type="date" name="fecha1" value="" class="form-control"/></td>
				<td>&#160;</td>
				<td ><label>Fecha fin:</label></td>
				<td><input type="date" name="fecha2" id="fecha2" onchange="fechas()" size="70px" class="form-control"/></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>&#160;</td>
				<td style="padding-left:25%"><button type =" submit " class ="btn btn-primary " name="btnSolicitar" onclick="solicitud()">&#160;Enviar&#160;</button></td>
				<td align="left"><!--<button class="btn btn-danger">Cancelar</button>--></td>
			</tr>
		</table>
		</div>
		</div>
	</form>	
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES ENVIADAS</div>
    <div class="panel-body">
    <?php
    if ($VisualizarR == false) {
    ?>
    	<div id="mensaje" align="center" height="30%"></div>
    	
    <?php
    }else{
    ?>
    
	<table class="table table-bordered"> 
			<thead>
			<tr>
				<th></th>
				<th class="invisible">ID</th>
				<th >Fecha de solicitud</th>
				<th >Fecha inicio</th>
				<th >Fecha fin</th>
				<th >D&iacuteas Solicitados</th>
				<th >D&iacuteas adicionales</th>
				<th >Estatus</th>
			</tr>
			</thead>
			<tr>
				<?php 
		      		foreach($dat as $row) {
		      		if ($row["aprobacion1"] == 0 || $row["aprobacion2"] == 0) {
		      			$Estatus = "PENDIENTE";
		      		}else{
		      			$Estatus = "APROBADA";
		      		}
				echo '<tr>
							<td>
								<a href="">Seleccionar</a></td>
							<td class="invisible">'.$row["solicitud_ID"].'</td>
							<td>'.$row["fecha"].'</td>
							<td>'.$row["fecha1"].'</td>
							<td>'.$row["fecha2"].'</td>
							<td>'.$row["dias"].'</td>
							<td>'.$row["adicionales"].'</td>
							<td>'.$Estatus.'</td>
						</tr>';
					}		
		      	?>
			</tr>
		</table><br><br/>
		<div class="col-sm-8">
			<label>Documento soporte:</label>
			<input id="document" class="form-control" name="documentos" type="file" accept=".pdf"></input></td>
		</div>
	 <?php }?>
		</div>
	</div>
<?php
	include("intraFooter.php"); 
?> 