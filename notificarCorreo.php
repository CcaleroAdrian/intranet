<?php
	require_once("clases/class.phpmailer.php");
	require 'clases/actionsDB.php'; 
	

	/*$mensajeRechazados = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
				<!-- Latest compiled and minified JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
				<div style="width: 50%; height: 150px;">
					<table>
						<td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td>
					</table>
				<div class="col-md-12">
				<p>Buen d&iacute;a: <strong>'.$nombre.'</strong> <br><br>
				Te notificamos que tus vacaciones fueron rechazas, ocasionado por las siguientes circustancias</p>
				<ul><li>Solicitades d&iacute;as adicionales a los disponibles por tu antiguedad</li><li>El periodo vacional interfiere con la entrega en tiempo y forma de un proyecto</li><li>Etc</li></ul>
				<p>Para mayor informacion, comunicate al departamento de Recursos Humanos de <strong>ITWorkers</strong>
				</div>
			<div align="justifi"><p style="font-size:11px">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p>
			</div><br><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';*/

	//Enviar correos de solicitudes aceptadas
	$objectConsultas = new actionsDB();
	$solicitudesAceptas = $objectConsultas->buscarSolicitudesAceptadas();
	//print_r($solicitudesAceptas);
	if ($solicitudesAceptas) {
		foreach ($solicitudesAceptas as $key) {
			$id=$key['user_ID'];
			$usuarioNotificar= $objectConsultas->notificarUsuario($id);
			//print_r($usuarioNotificar);
			foreach ($usuarioNotificar as $value) {
				$nombre = utf8_encode($value['nombre'].' '.$value['paterno'].' '.$value['materno']);
				$correo = $value['usrIntranet'];
				$mensaje = "Solicitud de vaciones aceptadas";
				$mensajeAcetados ='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 100%;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><br><br><br><div class="col-md-12"><p style="font-size:14px; text-align:justify;">Buen d&iacute;a: <strong>'.$nombre.'</strong> <br><br>Te notificamos que tus vacaciones fueron aprobadas, concluye tu proceso acudiendo a las oficinas centrales de <strong>ITWorkers</strong>, para firmar el &#34;Acuse de vacaciones autorizadas&#34; y atiendas cualquier aspecto que derive de este proceso.</p></div><div align="justifi"><br><br><br><p style="font-size:9px; text-align:justify;">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';

				//echo "Llegamos al proceso de envio de correos";
				$correos = envioCorreos($correo,$nombre,$mensaje,$mensajeAcetados);
				//echo $correos;
				if ($correos == 'Enviado') {
					$actuaizacion= $objectConsultas->notificarEnvioCorreo(11,2);
					if ($actuaizacion) {
					 	echo "Notificación de correos aceptados";
					}
				}
			}
		}
	}
	//Enviar correso de solicitudes rechazadas*/






	function envioCorreos($destinatario,$nombreDestinatario,$asunto,$body){
		$enviado = "";

		$mail = new PHPMailer();
		$mail->IsSMTP();//indicamos el uso de SMTP
		$mail->debug = 1;
		$mail->SMTPAuth = true;//Especificamos la seguridad de la conexion
		$mail->SMTPSecure = "ssl";
		$mail->Host = "server70.neubox.net"; // host del servidor SMTP
		$mail->Username = "intranet@itw.mx";  //usuario de la cuenta SMTP 
		$mail->Password = "XlKp}MuyDh]c";  //PASWORD del user SMTP
		$mail->Port = 465;  //puerto de salida
		$mail->From = "IntraneITW@itw.mx";  	
		$mail->FromName = "ITWORKERS";
		$mail->AddAddress($destinatario , $nombreDestinatario);
		$mail->IsHTML(true); // El correo se envía como HTML
		$mail->Subject = $asunto ; // Este es el titulo del email.
		$mail->Body = $body; // Mensaje a enviar
		$exito = $mail->Send();

		if ($exito) {
			$enviado = "Enviado";
		}else{
			$enviado = $mail->ErrorInfo;
		}

		return $enviado;
	}

?>
