<?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php'); 
}
	$ID_USR;
	//CARGA DE INFORMACION DE USUARIO
	$VisualizarR = false;
	$objOperaciones = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en la solicitud

	$btn = isset($_POST['btnSolicitar']) ? trim($_POST['btnSolicitar']) : "";
	if ($btn == "Solicitar") {

		$proyecto = $usr['Proyecto_id'];
		$categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : "";
		$fechaInicio = isset($_POST['fecha1']) ? trim($_POST['fecha1']) : "";
		$fechaFin = isset($_POST['fecha2']) ? trim($_POST['fecha2']) : "";
		$dias = isset($_POST['diasS']) ? trim($_POST['diasS']) : "";

		if ($dias != 0) {
			//$resultado = $objOperaciones->inserSolicitudPermiso
		}
		
	}
?>
<meta http-equiv=content-type content=text/html; charset=utf-8>
<script type="text/javascript" src="js/solicitud.js"></script>
<script type="text/javascript">
	var id = "<?php echo $ID_USR; ?>";
	var Gerente;
	$(document).ready(function(){
		var data = {ID: id};
		caragarInforUser(data);
	});

	function caragarInforUser(data){
		$.ajax({
	        method: "GET",
	        url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/empleados/",
	        dataType: "json",
	        headers:data,
		    beforeSend:function(){
		        var div = document.getElementById('mensaje');
		        var spinner = new Spinner(opts).spin(div);
		    },
		    success: function(data) {
			    var nombre = data['apellido_paterno']+' '+data['apellido_materno']+ ' '+ data['nombre'];
			    $('#nombre').val(nombre);
			    //console.log(nombre);
		        $.ajax({
				    method: "GET",
				    url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/liderArea/',
				    dataType: "json",
				    headers: {AREA_ID:data['area_id']},
				    success: function(data) {
				     //responsableArea= data['nombre'];
				     //correoArea = data['email_1'];
				     nombreArea = data['nombre_area'];
				     	Gerente = data['empleado_id'];
				     	$('#area').val(nombreArea);
					}
		   		});

		        $( ".spinner" ).remove();
		    }
	    });
	}
</script>

	<h3 align="left">SOLICITUD DE PERMISOS</h3>

	<form  id="form" name="frmSolicitud" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";  ?>" enctype="multipart/form-data" method="post" height="350pt"  >

	<!--correo_notificacion.php?fecha=<?php echo $usr['fechaIngreso']; ?>-->
	<div class="panel panel-primary">
    <div class="panel-heading">CAPTURA <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body" id="mensaje">
		<table id="form1" class="table-responsive">
			<tr >
				<td><label>Nombre del empleado:</label></td>
				<td colspan="3"><input id="nombre" name="nombreEmpleado" class="bloqueado" size="30" readonly></input></td>
			</tr>
			<tr>
				<td><label >&#193rea o departamento:</label></td>
				<td><input id="area" name="area" class="bloqueado" readonly></input></td>
				<td>&#160;</td>
			</tr>
			<tr>
				<td><label>Categoría:</label></td>
				<td><select class="form-control" id="categoria" name="categoria" onchange="motivos()">
					<option value="SELECCIONAR">--Seleccionar--</option>
					<option value="INCAPACIDAD">INCAPACIDAD</option>
					<option value="PERSONAL">PERSONAL</option>
					<option value="ENFERMEDAD">ENFERMEDAD</option>
				</select></td>
				<td>&#160;</td>
				<td><label>D&iacuteas solicitados:</label></td>
				<td><input id="diasSolicitados" name="diasS" value="" class="bloqueado" disabled></input></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
			<td ><label>Fecha inicio:</label></td>
				<td ><input id="fecha1" size="10" type="date" name="fecha1" value="" onchange="fechas()" class="form-control"/></td>
				<td>&#160;</td>
				<td ><label>Fecha fin:</label></td>
				<td><input type="date" name="fecha2" id="fecha2" onchange="fechas()" size="70px" class="form-control"/></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>
					<label id="etiqueta" style="display: none;">Motivo:</label>
				</td>
				<td colspan="4"><textarea id="motivo" name="comentarios" placeholder="Escribe el motivo de tu solicitud." rows="3" cols="70" style="display: none;"></textarea></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>&#160;</td>
				<td style="padding-left:25%"><button type =" submit " class ="btn btn-primary " name="btnSolicitar" name="Solicitar">&#160;Enviar&#160;</button></td>
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
				<th >Fecha inicio</th>
				<th >Fecha fin</th>
				<th >D&iacuteas Solicitados</th>
				<th >Motivo</th>
				<th> Documento</th>
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
		      	?>
				<tr>
					<td>
						<a href="">Seleccionar</a></td>
					<td style="display:none;"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php	}		
		      	?>
			</tr>
		</table><br><br/>
		<div class="col-sm-8" style="display: none;">
			<label>Documento soporte:</label>
			<input id="document" class="form-control" name="documentos" type="file" accept=".pdf"></input></td>
		</div>
	 <?php }?>
		</div>
	</div>
<?php
	include("intraFooter.php"); 
?> 