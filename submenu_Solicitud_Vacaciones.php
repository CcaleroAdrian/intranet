<?php
include("intraHeader.php");
require_once("clases/class.phpmailer.php");
//require("class.phpmailer.php");

if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

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
	If ( $usr == -1  OR  $usr == 0 ) {
		$error1 = "No fué posible recuperar la informaci&oacute;n del usuario: ";
	} 

	$dat = $objOperaciones->verSolicitudes($ID_USR);
	//print_r($dat);
	If ($dat == 0 OR $dat == -1) {
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
	/*$lider = $objectAlta->verLider($usr["Proyecto_id"]);
	
	foreach ($lider as $key) {
		$lide= $key['usuario_ID'];
	}*/

	if ($diasSoli == 0) {
		echo "no hay dias solicitados";
	}else{

		//envio de correo
		//Consultar usuarios a quien enviar correos

		//SELECT usrIntranet, nombre, paterno, materno from usuarios where idUsuario ='".$usuario.
		$DIRECTOR = $objectAlta->notificarUsuario($director);
		foreach ($DIRECTOR as $key) {
			$correo = $key['usrIntranet'];
			$nombre = utf8_encode($key["nombre"].' '.$key["paterno"].' '.$key["materno"]);	
		}

		
		//$LIDER = $$objectAlta-> notificarUsuario($lide);
		//print_r($LIDER);
		/*foreach ($LIDER as $k) {
			$correo2 = $k['usrIntranet'];
			$nombre2 = utf8_encode($k['nombre'].' '.$k['paterno'].' '.$k['materno']);
		}*/
		
		$mail = new PHPMailer();
		$mail->IsSMTP();//indicamos el uso de SMTP
		$mail->SMTPAuth = true;//Especificamos la seguridad de la conexion
		$mail->SMTPSecure = "ssl";
		$mail->Host = "server70.neubox.net"; // host del servidor SMTP
		$mail->Username = "intranet@itw.mx";  //usuario de la cuenta SMTP 
		$mail->Password = "XlKp}MuyDh]c";  //PASWORD del user SMTP
		$mail->Port = 465;  //puerto de salida
		$mail->From = "webmaster@itw.mx";  	
		$mail->FromName = "ITWORKERS";
		$mail->AddAddress($correo , $nombre);
		//$mail->AddAddress($correo2 ,$nombre2);
		$mail->IsHTML(true); // El correo se envía como HTML
		$mail->Subject = "Solicitud de vacaciones" ; // Este es el titulo del email.
		$body ='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
				<!-- Latest compiled and minified JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
				<div style="width: 50%; height: 150px;">
					<table>
						<td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td>
					</table>
				<div class="col-md-12">
				<p>El usuario: <strong>'.utf8_decode($nombre).'</strong> <br><br>
				Desea solicitar los <strong>'.$diasSoli.'</strong> d&iacute;as de vacaciones correspondientes al a&ntilde;o en curso, haciendo constar por escrito, su deseo de hacer validos los d&iacute;as de vacaciones que le corresponden.<br><br>No habiendo ning&uacute;n inconveniente de su parte, hace de su conocimiento para disfrutar un plazo vacacional del d&iacute;a <strong>'.$otro.'</strong> al <strong>'.$FechaFinal.'</strong> del presente a&ntilde;o.</p>
				</div><br><br><hr>
				<div class="col-md-8"></div><br><br/>
				<div align="center"><form method="post" action="http://www.intranet.itw.mx/index.php"><table class="table"><tr><br><br>
				<td><label style="font-size:11px;">&Aacute;rea:</label></td>
				<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$a.'" disabled/></td>
				<td><label style="font-size:11px;">Fecha de ingreso:</label></td>
				<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$fechaIngreso.'" disabled/></td></tr><tr>
				<td><label style="font-size:11px;">Del:</label></td>
				<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$otro.'" disabled></td>
				<td><label style="font-size:11px;">Al:</label></td>
				<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$FechaFinal.'" disabled></td></tr><tr>
			<td><label style="font-size:11px;">D&iacute;as a disfrutar:</label></td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasVa.'" disabled></td>
			<td><label style="font-size:11px;">D&iacute;as Solicitados</label></td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasSoli.'" disabled></td></tr><tr>
			<td><label style="font-size:11px;">D&iacute;as pendientes:</label></td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasRestantes.'" disabled></td>
			<td><label style="font-size:11px;" >D&iacute;as adicionales</label></td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasAdi.'" disabled></td></tr><tr></tr></table><div align="center"><input type="submit" class="btn btn-primary" name="btnAprobar" value="Aprobar">
			</div></form></div><br><hr>
			<div align="justifi"><p style="font-size:11px">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p>
			</div><br><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';
		
		$mail->Body = $body; // Mensaje a enviar
		$exito = $mail->Send();
		//echo $exito;
		if ($exito) {
		
			$resultado = $objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,14,$director);
			
			if( $resultado ) {
				$success = "Se realiz&oacute; el registro de su solicitud " ;
				echo"<script language='javascript'>window.location='/intranet/index.php'</script>";
			} else { 
				$error1 = "Hubo un error al registrar su solicitud. Favor de intentarlo más tarde";
				echo $error1;
			}

		}else {
			$error = "Fall&oacute; el env&iacute;o del correo con la solicitud de vacaciones, vuelva a intentarlo m&aacute;s tarde."; 
			echo $error;
			echo "ERRO: ".$mail->ErrorInfo;
		}
	}
}

$fech = $usr['fechaIngreso'];//Parametro fecha de ingreso enviado por urldecode(str)
//Calculo de vacaciones
$fecha=$usr['fechaIngreso'];;
$segundos=strtotime('now') - strtotime($fecha);
$antiguedad=intval($segundos/60/60/24);
$vacaciones = 0;
  if ($antiguedad == 365) { //1 años
    $vacaciones = 6;
  }elseif ($antiguedad == 730) {//2 años
    $vacaciones = 8;
  }elseif ($antiguedad == 1095) {//3 años
    $vacaciones = 10;
  }elseif ($antiguedad >= 1460 && $antiguedad <= 2920) {//4 años a 8 años
    $vacaciones = 12;
  }elseif ($antiguedad >= 3285 && $antiguedad <= 4745) {//9 años A 13 años
    $vacaciones = 14;
  }elseif ($antiguedad >= 5110) {//14 años o más
    $vacaciones = 16;
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
		      		if ($row["aprobacion1"] == 0 OR $row["aprobacion2"] == 0) {
		      			$Estatus = "PENDIENTE";
		      		}else{
		      			$Estatus = "APROBADA";
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