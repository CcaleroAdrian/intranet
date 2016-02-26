<?php   
	include("intraHeader.php");  
	require_once("clases/class.phpmailer.php");
	require_once"clases/class.smtp.php";
	require_once("procesaPwdAleatorio.php");
	
	$usrEmail = isset($_POST['emailusr']) ? trim( strtolower( $_POST['emailusr'] ) ) : "" ; 
	$btnOpcion = isset($_POST['btnAccion']) ? trim(  $_POST['btnAccion']  ) : "" ; 
	
	//Si el usuario da clic en el botón cancelar  regresa al index
	If ( $btnOpcion == "Cancelar"){
		header('Location: index.php');
	}
	$blnExito = false ;
	
	// Si el usuario da clic en el botón recuperar valida y procesa la recuperacion de la contraseña
	If ( $btnOpcion == "Recuperar" ) {
		if (  $usrEmail <> "" )  {
			//Instanciamos la clase que tiene las operaciones a la base de datos
			$objOperaciones = new ActionsDB();
			// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
			$objExisteUsr = $objOperaciones->getExisteUsuario( $usrEmail );
			if ( $objExisteUsr == -1 ) {
				$error = "Falló la conexión con la base de datos.";
				//header('Location: recuperaPwd.php?err=' . $error . ' ');
			} else if ( $objExisteUsr == 0 ) {
				$error = "El usuario ". $usrEmail  . " no existe en el sistema.";
				//header('Location: recuperaPwd.php?err=' . $error . ' ');
			} else {
				//echo $usrEmail ;
				// Generamos una contraseña temporal 
				$pwdTmp = trim( generaPass() ); 
				if ( $pwdTmp != "" ) { 
						//Enviar Contraseña temporal al correo del usuario.
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
						$mail->AddAddress( $usrEmail );
						$mail->IsHTML(true); // El correo se envía como HTML
						$mail->Subject = "Recuperación de Contrase&ntilde;" ; // Este es el titulo del email.
						$body = "Tu clave de acceso a nuestro sistema de intranet ITW es: " .$pwdTmp;
						//$body .= ""
						$mail->Body = $body; // Mensaje a enviar
						//$mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
						//$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
						$exito = $mail->Send(); // Envía el correo.
						echo $exito; 
						if (  $exito ){
							// Actualiza la contraseña en la BD
							$objCambiaPwd = $objOperaciones->setPwdUsuario( $usrEmail , $pwdTmp );
							if ($objCambiaPwd != 0) {
								$blnExito = true;
							}else {
								$error = "No se actualizó la contraseña , intentelo de nuevo más tarde."; 
							} 

						} else {
							$error = "Fall&oacute; el env&iacute;o del correo con la contrase&ntilde;a temporal, vuelva a intentarlo m&aacute;s tarde."; 
							//echo $mail->ErrorInfo;
						} 
					
				} else {
					$error = "Error al generar la contrase&ntilde;a temporal, intentelo de nuevo.";
					
				}
			} 
		} else {  
			$error = "Debe capturar un Usuario para recuperar su clave de acceso."; 
		}
	}
	
	if (  $blnExito == false ) { 

 ?> 
  		<h3>Recuperar Constrase&ntildea </h3>
		<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0"   >
			<tr>
			<td >  
				<form name="formRecuperar" method="post" action="page_RecuperaPwd.php">
				<div class="panel panel-primary">
				<div class="panel-heading">USUARIO A RECUPERAR</div>
				<div class="panel-body">
				<table width="320"  border="0" align="center" cellpadding="0" cellspacing="6" class="tblFrm" >
				  <tr>
					<td><div align="justify">
					  <LABEL align="center">Usuario de la cuenta para recuperar su contrase&ntilde;a:</LABEL> 
					  </div></td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
					<td><div align="center">
					  <input class="form-control"  name="emailusr" type="text" id="emailusr" size="50" maxlength="80" value="<?php echo trim($usrEmail) ?> ">
				    </div></td>
				  </tr> 
				  <tr>
                        <td height="25" colspan="2" align="center" > 
							<div align="center" class="txtErro1" > <?php echo $error ; ?></div>
						</td>
                  </tr>
				  <tr>
					<td><div align="center">
					    <input type="submit" class="btn btn-primary"   name="btnAccion" value="Cancelar">
					    <input type="submit" class="btn btn-danger"   name="btnAccion" value="Recuperar">
					</div></td>
				  </tr>
				</table>
				</div>
				</div>
				</form>
			</td>
			</tr> 
    	</table>  
						
<?php 

	} else {	 
			
?>

			<form name="form" method="post" action="index.php">
			<table width="100%"  border="0" cellspacing="2" cellpadding="0" class="tblInfo">
			  <tr>
			    <td height="100">&nbsp;</td>
		      </tr>
			  <tr>
				<td height="30">    
					  <table width="50%"  border="0" align="center" cellpadding="0" cellspacing="2" class="tblInfo" >
                        <tr> 
                          <td align="center" >
						  <?php  
						  	echo "<div > Se ha enviado una contrase&ntilde;a temporal al correo ( ". $usrEmail ." ) para tener acceso a la intranet. Favor de cambiar su clave de acceso una vez que acceda al sistema.  </div>";
						  ?> 
                          </td>
                        </tr>
                  </table>
					  <p>&nbsp;</p>
					</div>
				</td>
			  </tr>
			  <tr>
			    <td height="30"><div align="center">
			      <input type="submit" class="boton"  name="Submit2" value="Continuar">
		        </div></td>
		      </tr>
			  <tr>
			  <td height="100">  
			  	<div align="center">			      </div></td>
			  </tr>
			</table>		
			</form>
		
 <?php
			 

	}
		
  
	include("intraFooter.php"); 
?> 
