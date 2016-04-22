<?php
include("intraHeader.php");
require_once("clases/class.phpmailer.php");
//require("class.phpmailer.php");

if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');
$objOperaciones = new ActionsDB();
//Variables
$success = "";
$error1 = "";
$error2 = "";
$ID_USR;
$VisualizarR = false;
$TAMANO_PAGINA = 5;
$area="";

//OBTENER INFO DIRECTOR
$director = $objOperaciones->DatosDirector();
if ($director) {
	foreach ($director as $value) {
		$directorID = $value['idUsuario'];
	}
}
//CARGA DE INFORMACION DE USUARIO

// Obtenemos los campos de la tabla usuarios para presentarla en la solicitud
	$usr = $objOperaciones->getDatosPerfil($USUARIO); 
	$diasLey = $usr['DiasLey'];

	if ( $usr == -1  OR  $usr == 0 ) {
		$error1 = "No fué posible recuperar la informaci&oacute;n del usuario: ";
	}else{
		if ($usr['Proyecto_id'] == 0 OR $usr['Proyecto_id'] == "") {
			$error = "Debes seleccionar un Gerente de proyectos de tu Área o Departamento antes de realizar la captura de tu solicitud de lo contrario esta no será enviada.";
		}
	} 

	//Consultar Area o Departamento del usuario
	$a = $objOperaciones->verAreas($usr['area_ID']);
	if ($a) {
		foreach ($a as $value) {
			$area = utf8_encode($value['Descripcion']);
		}
	}

	//OBTENER INFO LIDER DE PROYECTO
	$lider = $objOperaciones->verLider($usr['Proyecto_id']);
	$LiderID = 0;
	if ($lider != 0 AND $lider != -1) {
		foreach ($lider as $key) {
			$LiderID = $key['usuario_ID'];
		}
	}

	

//********Enviar el correo de notificacion*********
//Recuperamos los datos a enviar por correo
$btn = isset($_POST['btnSolicitar']) ? trim($_POST['btnSolicitar']) : "";
//Evento guardar solicitud de vacaciones
if ($btn == "Enviar") {

	$nombre = isset($_POST['nombreEmpleado']) ? trim($_POST['nombreEmpleado']): "";//nombre del empleado
	$a =isset($_POST['area']) ? trim($_POST['area']): "";//are a la que pertenece
	$diasSoli =isset($_POST['diasSolicitados']) ? trim($_POST['diasSolicitados']) : "";//dias solicitados
	$diasVa =isset($_POST['Vaca']) ? trim($_POST['Vaca']) : "";//dias de vacaciones correspondientes
	$fechaI = isset($_POST['fecha1']) ? trim($_POST['fecha1']) : "";
	$fechaF = isset($_POST['fecha2']) ? trim($_POST['fecha2']) : "";
	$date = strtotime($_POST['fecha1']);//fecha Inicial
	$dates = strtotime($_POST['fecha2']);//fecha Final
	$fechaIn = strtotime($usr['fechaIngreso']);
	$diasAdi= isset($_POST['DiasAdicionales']) ? trim($_POST['DiasAdicionales']) : "";
	$diasRestantes =  isset($_POST['DiasRestantes']) ? trim($_POST['DiasRestantes']) : "";

	$otro = date("d-F-Y", $date);//fecha inicial de vacaciones
	$FechaFinal =date("d-F-Y", $dates);//fecha final de vacaciones
	$fechaIngreso = date("d-F-Y", $fechaIn);//fecha de ingreso

	
	$objectAlta = new ActionsDB();
	if ($usr['Proyecto_id'] != 0 OR $usr['Proyecto_id'] != "") {
		$resultado =$objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,$diasRestantes,$LiderID,$directorID);
		if( $resultado ) {

			//Actualizamos los dás ley del usuario;
			if ($diasVa < $diasSoli) {
				$dias = "-".$diasAdi;
				$objectAlta->editarDiasLey($dias,$ID_USR,1);
			}elseif ($diasVa > $diasSoli) {
				$objectAlta->editarDiasLey($diasRestantes,$ID_USR,1);
			}
			$success = "Se realiz&oacute; el registro de su solicitud " ;
			$usuarios = $objOperaciones->verSolicitudes($ID_USR,0,$TAMANO_PAGINA);
			//header("Refresh:0");
		} else { 
			$error1 = "Hubo un error al registrar su solicitud. Favor de intentarlo más tarde";
		}
	}else{$error = "Debes seleccionar un Gerente de proyectos de tu Área o Departamento antes de realizar la captura de tu solicitud de lo contrario esta no será enviada.";}
}

//Comparamos que el valor retorno no sea menor a 0
if ($usr['DiasLey'] < 0) {
	$vacaciones = 0;
	$error2 = "Debido a que has solicitado días por adelantado, no podras realizar nuevas solicitudes.";
}else{
	$vacaciones = $usr['DiasLey'];
}

$mensaje = isset($_GET['mensaje']) ? trim($_GET['mensaje']) : "";

?>
<script type="text/javascript">
	$(document).ready(function(){

		var xmlhttp;
		var success = "<?php echo utf8_encode($success); ?>";
		var error =  "<?php echo $error1; ?>";
		var err = "<?php echo $error2; ?>";
		var otro = "<?php echo $error; ?>";
		var mensaje = "<?php echo $mensaje; ?>";
		
		if (error != "") {
			swal({title: "CONFIRMACIÓN",text: error,type: "error",timer:3000,showConfirmButton:false});
		}else if (success != "") {
			swal({title: "CONFIRMACIÓN",text: success, type:"success", timer:3000, showConfirmButton:false});
		}else if (err != "") {
			swal({title: "CONFIRMACIÓN",text: err,type: "info",showConfirmButton:true});
		}else if(otro != ""){
			swal({title: "CONFIRMACIÓN",text: otro,type: "info",timer:8000,showConfirmButton:false});
		}else if(mensaje != ""){
			swal({title: "CONFIRMACIÓN",text: mensaje,type: "info",timer:3000,showConfirmButton:false});
		}


		//Desactivar boton de enviar en caso de no seleccionar Gerente o No disponer de días
		var Gerente = "<?php echo $LiderID; ?>";
		var vacaciones = "<?php echo $diasLey; ?>";
		if (Gerente == 0) {
			$("#btnSubmit").attr("disabled","disabled");
		}else if(vacaciones < 0){
			$("#btnSubmit").attr("disabled","disabled");
		}


		//Consultamos resultados con ajax
		paginacion(0);

	});

	function paginacion(pagina){
		var op = 2;
		var id = "<?php echo $ID_USR;?>";

			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				
			}else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("cuerpo").innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("pagina="+pagina+"&opcion="+op+"&id="+id);
	}

	//Funcion para hacer visible la caja de texto de carga de archivo;
	function cargarDocumento(fila){
			datos = fila.getAttribute("data-input");
			id = fila.getAttribute("data-id");
			if (datos == "cargar documento") {
				document.getElementById('cargaArchivo').style.display = "block";
				$('#idRegistro').val(id);
			}
	}


</script>
<style type="text/css">
	a{
		text-decoration: none;
	}
</style>
<!--<script type="text/javascript" src="js/solicitud.js"></script>-->
<script type="text/javascript" src="js/busqueda.js"></script>
	<h3 align="left">SOLICITUD DE VACACIONES</h3>

	<form  id="formulario" name="frmSolicitud" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
	<div class="panel panel-primary">
    <div class="panel-heading">CAPTURA<a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
		<table id="form1" class="table-responsive">
			<tr >
				<td ><label>Nombre del empleado:</label></td>
				<td colspan="2"><input id="nombreUser" name="nombreEmpleado" class="bloqueado" value="<?php echo utf8_encode($usr['nombre'].' '.$usr['paterno'].' '.$usr['materno']);?>"></input></td>
				<td id="mensajes"></td>
			</tr>
			<tr>
				<td><label >&#193rea o departamento:</label></td>
				<td><input id="area1" name="area" class="bloqueado" value="<?php echo $area; ?>" readonly="readonly"></input></td>
				<td>&#160;</td>
			</tr>
			<tr>
				<td><label>D&iacuteas ley:</label></td>
				<td><input id="Vacaciones" name="Vaca" value="<?php echo $vacaciones;?>" class="bloqueado" readonly></input></td>
				<td><label>D&iacuteas solicitados: </label></td>
				<td><input id="diasSolicitados" name="diasSolicitados" value="" class="bloqueado" readonly></input></td>
			</tr>
			<tr>
				<td><label>D&iacuteas restantes:</label></td>
				<td><input id="diasRestantes" name="DiasRestantes" value="" class="bloqueado" readonly></input></td>
				<td><label>D&iacuteas adicionales: </label></td>
				<td><input id="diasAdicionales" name="DiasAdicionales" value="" class="bloqueado" readonly></input></td>
			</tr>
			<tr>
			<td ><label>Fecha inicio:</label></td>
				<td ><input id="fecha" size="10" type="date" name="fecha1" onchange="fechas()" value="" class="form-control" required=”required”/></td>
				<td ><label>Fecha fin:</label></td>
				<td colspan="2"><input type="date" name="fecha2" id="fecha2" onchange="fechas()" class="form-control" required=”required”/></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>&#160;</td>
				<td style="padding-left:25%"><button id="btnSubmit" type ="submit" class ="btn btn-primary " name="btnSolicitar" value="Enviar">&#160;Enviar&#160;</button></td>
				<td align="left"><!--<button class="btn btn-danger">Cancelar</button>--></td>
			</tr>
		</table>
		</div>
		</div>
	</form>	
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES ENVIADAS</div>
    <div class="panel-body" id="cuerpo">
	</div>
<?php
	include("intraFooter.php"); 
?> 