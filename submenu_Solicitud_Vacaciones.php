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

	$dat = $objOperaciones->verSolicitudes($ID_USR);
	//print_r($dat);
	if ($dat == 0 OR $dat == -1) {
		$VisualizarR = false;
		$error2 = "No fué posible recuperar las solicitudes realizadas anteriormente";
	}else{
		$VisualizarR = true;

		//REALIZAMOS PAGINACION
		//*******PAGINACION DE RESULTADO********
		$url = "/intranet/sub_menu_Solicitud_Vacaciones.php";
		//Instanciamos la clase que tiene las operaciones a la base de datos
		$numRegi = count($dat);
		//Limito los resultados por pagina
		 
		$pagina = false;
		//examino la pagina a mostrar y el inicio del registro a mostrar
	    if (isset($_GET["pagina"]))
	        $pagina = $_GET["pagina"];

			if (!$pagina) { 
			   	$inicio = 0; 
			   	$pagina = 1; 
			} 
			else { 
			   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
			}
			//calculo el total de páginas 
			$total_paginas = ceil($numRegi / $TAMANO_PAGINA); 

			$usuarios = $objOperaciones->verSolicitudes($ID_USR,$inicio,$TAMANO_PAGINA);
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
			header("Refresh:0");
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
		}else if(vacaciones == -1){
			$("#btnSubmit").attr("disabled","disabled");
		}
	});

	//Funcion para hacer visible la caja de texto de carga de archivo;
	function cargarDocumento(Objecto){
			var datos = Array();
			datos[0] = Objecto.id;
			datos[1] = Objecto.documento;
			if (datos[1] == "cargar documento") {
				document.getElementById('cargaArchivo').style.visibility= 'initial';
				$('#idRegistro').val(datos[0]);
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
    <div class="panel-body">
    <?php
    if ($VisualizarR == false) {
    ?>
    	<div id="mensaje" align="center" height="30%"></div>
    	
    <?php
    }else{
    ?>
	<table class="table table-bordered" id="table_Solicitudes"> 
			<thead>
			<tr>
				<th>N</th>
				<th >Fecha de solicitud</th>
				<th >Fecha inicio</th>
				<th >Fecha fin</th>
				<th >D&iacuteas Solicitados</th>
				<th >D&iacuteas adicionales</th>
				<th>Documento soporte</th>
				<th>Estatus</th>
			</tr>
			</thead>
			<tbody id="jod">
				<?php 
					$nume = 0;
		      		foreach($usuarios as $row) {
		      		$nume +=1;
		      		//Determinar estutus solicitud
		      		if ($row["adicionales"] != 0) {
		      			if (($row["aprobacion1"] == 1 AND $row["aprobacion2"] == 1) OR ($row["aprobacion1"] == 2 AND $row["aprobacion2"] == 1)) {//Estatus pendiente
		      				$Estatus = "PENDIENTE";
		      			}else if ($row["aprobacion1"] == 2 AND $row["aprobacion2"] == 2) {
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
		      		} ?>
		      	
						<tr id="celda">
							<td><?php echo $nume; ?></td>
							<td><?php echo$row["fecha"]; ?></td>
							<td><?php echo$row["fecha1"]; ?></td>
							<td><?php echo$row["fecha2"]; ?></td>
							<td style="text-align: center;"><?php echo$row["dias"]; ?></td>
							<td style="text-align: center;"><?php echo$row["adicionales"]; ?></td>
							<td><a <?php echo($row["documento"] == "cargar documento") ? "" : "href='descargarArchivo.php?id=".$row["solicitud_ID"]."'"; ?> onclick="cargarDocumento({id:<?php echo $row['solicitud_ID']?>,documento:'<?php echo $row['documento'] ?>'})" ><?php echo $row["documento"]; ?></a></td>
							<td><?php echo$Estatus; ?></td>
						</tr>
				<?php
					}		
		      	?>
			</tbody>
		</table>
		<?php 
							if ($total_paginas > 1) {
								if ($pagina != 1)
								echo '<a href="'.$url.'?pagina='.($pagina-1).'"><span class="glyphicon glyphicon-chevron-left"></span></a>';
							for ($i=1;$i<=$total_paginas;$i++) {
								if ($pagina == $i)
								//si muestro el �ndice de la p�gina actual, no coloco enlace
								echo $pagina;
								else
								//si el �ndice no corresponde con la p�gina mostrada actualmente,
								//coloco el enlace para ir a esa p�gina
								echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
							}
							if ($pagina != $total_paginas)
							echo '<a href="'.$url.'?pagina='.($pagina+1).'"><span  class="glyphicon glyphicon-chevron-right"></span></a>';
							}
							echo '</p>';
				      	?>
		<br>
		<div class="col-sm-10" id="cargaArchivo" style="visibility: hidden;" ><!---->
			<form class="form-inline" action="cargaArchivo.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
			<input type="text" value="" style="display: none" id="idRegistro" name="idArchivo"></input>
			<label>Documento soporte:</label>
			<input id="document" class="form-control" name="documentos" type="file" accept="*"></input>
			<button type="sumit" class="btn btn-primary">CARGAR</button>
			</div>
			</form>
		</div>
	 <?php }?>
		</div>
	</div>
<?php
	include("intraFooter.php"); 
?> 