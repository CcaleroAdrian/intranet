<?php
include("intraHeader.php");
require_once("clases/class.phpmailer.php");
//require("class.phpmailer.php");

if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');
//Variables
$success = "";
$error1 = "";
$error2 = "";
$ID_USR;
$VisualizarR = false;




//CARGA DE INFORMACION DE USUARIO
$objOperaciones = new ActionsDB();
// Obtenemos los campos de la tabla usuarios para presentarla en la solicitud
	$usr = $objOperaciones->getDatosPerfil($USUARIO); 
	if ( $usr == -1  OR  $usr == 0 ) {
		$error1 = "No fué posible recuperar la informaci&oacute;n del usuario: ";
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
		//$url = "/intranet/sub_menuDirectorio.php";
		$url = "/intranet/sub_menu_Solicitud_Vacaciones.php";
		//Instanciamos la clase que tiene las operaciones a la base de datos
		$numRegi = count($dat);
		//Limito los resultados por pagina
		$TAMANO_PAGINA = 5; 
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

	$otro = date("d-F-Y", $date);//fecha inicial de vacaciones
	$FechaFinal =date("d-F-Y", $dates);//fecha final de vacaciones
	$fechaIngreso = date("d-F-Y", $fechaIn);//fecha de ingreso
	$director = 16;

	if ($diasSoli > $diasVa) {
		$diasAdi = $diasSoli - $diasVa;
	}else{ $diasAdi = 0;}
		$diasRestantes = $diasVa - $diasSoli;//Dias restantes al periodo vacacional acumulado
	if ($diasRestantes < 1) {
		$diasRestantes = 0;
	}
	$objectAlta = new ActionsDB();
		$resultado = $objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,14,$director);
			if( $resultado ) {
				$success = "Se realiz&oacute; el registro de su solicitud " ;
				echo"<script language='javascript'>window.location='/intranet/index.php?success=".$success."'</script>";
			} else { 
				$error1 = "Hubo un error al registrar su solicitud. Favor de intentarlo más tarde";
				echo $error1;
			}
}

//Calculo de vacaciones
//echo "fecha:".$usr['fechaIngreso'];
$fecha1 = time()-strtotime($usr['fechaIngreso']);
$antiguedad =floor($fecha1 / 31536000);
//echo $antiguedad;

if($antiguedad > 0){

  if ($antiguedad >= 4 OR $antiguedad <= 8) {
     $dias = $objOperaciones->verAntiguedad(4);
  }else if($antiguedad >=9 OR $antiguedad <= 13){
     $dias = $objOperaciones->verAntiguedad(9);
  }else if($antiguedad >=14 OR $antiguedad <= 18){
     $dias = $objOperaciones->verAntiguedad(14);
  }else if ($antiguedad >= 19 OR $antiguedad <= 23) {
    $dias = $objOperaciones->verAntiguedad(19);
  }else if ($antiguedad >= 24 OR $antiguedad <= 28){
    $dias = $objOperaciones->verAntiguedad(24);
  }else if ($antiguedad >= 29 OR $antiguedad <= 34) {
    $dias = $objOperaciones->verAntiguedad(29);
  }else{
    $dias = $objOperaciones->verAntiguedad($antiguedad);
  }
  foreach ($dias as $key ) {
    $vacaciones = $key['Dias'];
  }

}else{

  $vacaciones = 0;

}

?>
<script type="text/javascript" src="intraCss/bootstrap/js/notify.min.js"></script>
<script type="text/javascript" src="js/solicitud.js"></script>
	<h3 align="left">SOLICITUD DE VACACIONES</h3>

	<form  id="form" name="frmSolicitud" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
	<div class="panel panel-primary">
    <div class="panel-heading">CAPTURA</div>
    <div class="panel-body">
		<table id="form1" class="table-responsive">
			<tr >
				<td ><label>Nombre del empleado:</label></td>
				<td colspan="2"><input id="nombreUser" name="nombreEmpleado" class="bloqueado" value="<?php echo utf8_encode($usr['nombre'].' '.$usr['paterno'].' '.$usr['materno']);?>"></input></td>
				<td id="mensajes"></td>
			</tr>
			<tr>
				<td><label >&#193rea o departamento:</label></td>
				<td><input id="area1" name="area" class="bloqueado" value="Desarrollo "></input></td>
				<td>&#160;</td>
			</tr>
			<tr>
				<td><label>D&iacuteas ley:</label></td>
				<td><input id="Vacaciones" name="Vaca" value="<?php echo $vacaciones?>" class="bloqueado"></input></td>
				<td><label>D&iacuteas solicitados: </label></td>
				<td><input id="diasSolicitados" name="diasSolicitados" value="" class="bloqueado"></input></td>
			</tr>
			<tr>
				<td><label>D&iacuteas restantes:</label></td>
				<td><input id="diasRestantes" name="" value="" class="bloqueado"></input></td>
				<td><label>D&iacuteas adicionales: </label></td>
				<td><input id="diasAdicionales" name="" value="" class="bloqueado"></input></td>
			</tr>
			<tr>
			<td ><label>Fecha inicio:</label></td>
				<td ><input id="fecha" size="10" type="date" name="fecha1" onchange="fechas()" value="" class="form-control"/></td>
				<td ><label>Fecha fin:</label></td>
				<td colspan="2"><input type="date" name="fecha2" id="fecha2" onchange="fechas()" class="form-control"/></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>&#160;</td>
				<td style="padding-left:25%"><button type ="submit" class ="btn btn-primary " name="btnSolicitar" value="Enviar">&#160;Enviar&#160;</button></td>
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
				<th style="display: none">ID</th>
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
		      		foreach($usuarios as $row) {
		      		$nume +=1;
		      		//Determinar estutus solicitud
		      		if (($row["aprobacion1"] == 1 AND $row["aprobacion2"] == 1) OR ($row["aprobacion1"] == 2 AND $row["aprobacion2"] == 1) OR ($row["aprobacion1"] == 3 AND $row["aprobacion2"] == 1)) {//pendientes
		      			$Estatus = "PENDIENTE";
		      		}else if (($row["aprobacion1"] == 2 AND $row["aprobacion2"] == 2) OR ($row["aprobacion1"] == 3 AND $row["aprobacion2"] == 2) OR ($row["aprobacion1"] == 1 AND $row["aprobacion2"] == 2)) {//Aceptadas
		      			$Estatus = "APROBADA";
		      		}else if (($row["aprobacion1"] == 3 AND $row["aprobacion2"] == 3) OR ($row["aprobacion1"] == 2 AND $row["aprobacion2"] == 3) OR ($row["aprobacion1"] == 1 AND $row["aprobacion2"] == 3)) {
		      			$Estatus = "RECHAZADA";
		      		}
				echo '<tr id="celda" onclick="solicitud(this)">
							<td>'.$nume.'</td>
							<td style="display:none;">'.$row["solicitud_ID"].'</td>
							<td>'.$row["fecha"].'</td>
							<td>'.$row["fecha1"].'</td>
							<td>'.$row["fecha2"].'</td>
							<td>'.$row["dias"].'</td>
							<td>'.$row["adicionales"].'</td>
							<td>'.$row["documento"].'</td>
							<td>'.$Estatus.'</td>
						</tr>';
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
			<input id="document" class="form-control" name="documentos" type="file" accept=".pdf"></input>
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