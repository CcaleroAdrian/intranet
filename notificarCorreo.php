<?php
	require_once("clases/class.phpmailer.php");
	require 'clases/actionsDB.php'; 
	date_default_timezone_set('AMERICA/Mexico_City');
	setlocale (LC_TIME, 'spanish-mexican');
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
				$nombre = utf8_decode($value['nombre'].' '.$value['paterno'].' '.$value['materno']);
				$correo = $value['usrIntranet'];
				$mensaje = "Solicitud de vaciones aceptadas";
				$mensajeAcetados ='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 100%;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><br><br><br><div class="col-md-12"><p style="font-size:14px; text-align:justify;">Buen d&iacute;a: <strong>'.$nombre.'</strong> <br><br>Te notificamos que tus vacaciones fueron aprobadas, concluye tu proceso acudiendo a las oficinas centrales de <strong>ITWorkers</strong>, para firmar el &#34;Acuse de vacaciones autorizadas&#34; y atiendas cualquier aspecto que derive de este proceso.</p></div><div align="justifi"><br><br><br><p style="font-size:9px; text-align:justify;">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';

				$mensaj = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 100%;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><br><br><br><div class="col-md-12"><p style="font-size:14px; text-align:justify;">La solicitud de <strong>'.$nombre.'</strong> <br><br>fu&eacute; aceptada para mayor informaci&oacute;n consultar el panel de Administraci&oacute;n de vacaciones en el Sitio de <a href="http://www.intranet.itw.mx/"> Intranet</a></div><div align="justifi"><br><br><br><p style="font-size:9px; text-align:justify;">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';

				//echo "Llegamos al proceso de envio de correos";
				$correos = envioCorreos($correo,$nombre,$mensaje,$mensajeAcetados);
				//echo $correos;
				if ($correos == 'Enviado') {
					correoSeguimiento($mensaje,$mensaj);
					$actuaizacion= $objectConsultas->notificarEnvioCorreo($id,2);
					if ($actuaizacion) {
					 	echo "Envio de correos, con solicitudes aceptadas";
					}
				}else{
					echo $correos;
				}
			}
		}
	}
	//Enviar correso de solicitudes rechazadas*/
	$objectConsultas = new actionsDB();
	$SolicitudesRechazadas = $objectConsultas->buscarSolicitudesRechazadas();
	if ($SolicitudesRechazadas) {
		foreach ($SolicitudesRechazadas as $key) {
			$id = $key['user_ID'];
			$usuarioNotificar= $objectConsultas->notificarUsuario($id);
			//print_r($usuarioNotificar);
			foreach ($usuarioNotificar as $value) {
				$nombre = utf8_encode($value['nombre'].' '.$value['paterno'].' '.$value['materno']);
				$correo = $value['usrIntranet'];
				$mensaje = "Solicitud de vaciones rechazadas";
				$mensajeRechazados = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 100%;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><br><br><br><div class="col-md-12"><p style="font-size:14px; text-align:justify;">Buen d&iacute;a: <strong>'.$nombre.'</strong> <br><br>Te notificamos que tus vacaciones fueron rechazas, ocasionado por las siguientes circustancias</p><ul><li>Solicitades d&iacute;as adicionales a los disponibles por tu antiguedad</li><li>El periodo vacional interfiere con la entrega en tiempo y forma de un proyecto</li><li>Etc</li></ul><p>Para mayor informacion, comunicate al departamento de Recursos Humanos de <strong>ITWorkers</strong></div><div align="justifi"><br><br><br><p style="font-size:9px; text-align:justify;">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';

				$mensaj = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 100%;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><br><br><br><div class="col-md-12"><p style="font-size:14px; text-align:justify;">La solicitud de <strong>'.$nombre.'</strong> <br><br>fu&eacute; rechazada para mayor informaci&oacute;n consultar el panel de Administraci&oacute;n de vacaciones en el Sitio de <a href="http://www.intranet.itw.mx/"> Intranet</a>, lo cual pudo ser ocasionado por las siguientes circustancias:</p><ul><li>Solicito d&iacute;as adicionales a los disponibles a su antiguedad</li><li>El periodo vacional interfiere con la entrega en tiempo y forma de un proyecto</li><li>Etc</li></ul></div><div align="justifi"><br><br><br><p style="font-size:9px; text-align:justify;">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';

					$correos = envioCorreos($correo,$nombre,$mensaje,$mensajeRechazados);
			
					if ($correos == 'Enviado') {
						correoSeguimiento($mensaje,$mensaj);
						$actuaizacion= $objectConsultas->notificarEnvioCorreo($id,3);
						if ($actuaizacion) {
						 	echo "Envio de correos, con solicitudes rechazadas";
						}
					}
			}
		}
	}

	//Notificar correos de solicitudes con documento cargado
	$Director_correo = "calero.adrian93@gmail.com";
	$Director_nombre = "Roberto Carlos Galicia";
	$asunt = "Solicitud de vacaciones";
	$objectConsul = new actionsDB();
	$solicitudesCompletas = $objectConsul->verSolicitudesCompletas();
	//print_r($solicitudesCompletas);
	foreach ($solicitudesCompletas as $value) {
		//user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales
		$usuario = $value['user_ID'];
		$diasVa = $value['diasCorrespondientes'];
		$diasSoli = $value['diasSolicitados'];
		$diasAdi = $value['diasAdicionales'];
		$otro = strftime('%A %d de %B ', strtotime($value['fechaI']));//fecha inicial de vacaciones
		$FechaFinal = strftime('%A %d de %B', strtotime($value['fechaF']));
		//$fechaIngreso = date("d-F-Y", strtotime($value['fechaF']));

			if ($diasSoli > $diasVa) {
			$diasAdi = $diasSoli - $diasVa;
			}else{ $diasAdi = 0;}
			$diasRestantes = $diasVa - $diasSoli;//Dias restantes al periodo vacacional acumulado
			if ($diasRestantes < 1) {
			$diasRestantes = 0;
			}
		$object = $objectConsul->getDatosPerfilID($usuario);
		//print_r($object);
		foreach ($object as $key) {
			$nombre = $key['nombre'].' '.$key['paterno'].' '.$key['materno'];
			$idArea = $key['area_ID'];
			$idProyecto = $key['Proyecto_ID'];
			$fechaIngreso =strftime('%d de %B del %Y', strtotime($key['fechaIngreso']));
			$lider= $objectConsul->mostrarResponzablesAsignacion($idProyecto);
			//print_r($lider);
			if ($lider) {
				foreach ($lider as $k) {
				$correo2 = $k['usrIntranet'];
				$nombre2 = utf8_encode($k['nombre'].' '.$k['paterno'].' '.$k['materno']);
				$area = $objectConsultas->verAreas($idArea);
				//print_r($area);
					foreach ($area as $v) {
						$a= $v['Descripcion'];
						//Envio de correo;
						$msg = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 150px;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><div class="col-md-12"><p>El usuario: <strong>'.utf8_decode($nombre).'</strong> <br><br>Desea solicitar <strong>'.$diasSoli.'</strong> d&iacute;as de vacaciones correspondientes al a&ntilde;o en curso, haciendo constar por escrito, su deseo de hacer validos los d&iacute;as de vacaciones que le corresponden.<br><br>No habiendo ning&uacute;n inconveniente de su parte, hace de su conocimiento para disfrutar un plazo vacacional del d&iacute;a <strong>'.$otro.'</strong> al <strong>'.$FechaFinal.'</strong> del presente a&ntilde;o.</p></div><br><br><hr><div class="col-md-8"></div><br><br/><div align="center"><form method="post" action="http://www.intranet.itw.mx/index.php"><table class="table"><tr><br><td><label style="font-size:11px;">&Aacute;rea:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$a.'" disabled/></td><td><label style="font-size:11px;">Fecha de ingreso:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="30" type="text" value="'.$fechaIngreso.'" disabled/></td></tr><tr><td><label style="font-size:11px;">Del:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$otro.'" disabled></td><td><label style="font-size:11px;">Al:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="30" type="text" value="'.$FechaFinal.'" disabled></td></tr><tr><td><label style="font-size:11px;">D&iacute;as a disfrutar:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasVa.'" disabled></td><td><label style="font-size:11px;">D&iacute;as Solicitados</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasSoli.'" disabled></td></tr><tr><td><label style="font-size:11px;">D&iacute;as pendientes:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasRestantes.'" disabled></td><td><label style="font-size:11px;" >D&iacute;as adicionales</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasAdi.'" disabled></td></tr><tr></tr></table><div align="center"><input type="submit" class="btn btn-primary" name="btnAprobar" value="Aprobar"></div></form></div><br><hr><div align="justifi"><p style="font-size:11px">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';
						//Correos
						$correo1 = envioCorreos($correo2,$nombre2,$asunt,$msg);//Lider
						$correo2 = envioCorreos($Director_correo,$Director_nombre,$asunt,$msg);//Director
						correoSeguimiento($asunt,$msg);//Seguimiento
						if ($correo1 == "Enviado" AND $correo2 == "Enviado") {
							$actuaizacion= $objectConsul->notificarEnvioCorreo($usuario,1);
							$actuaizacion= $objectConsul->notificarEnvioCorreo($usuario,4);
							if ($actuaizacion) {
								echo "Correos de solicitudes nuevas enviados";
							}
						}

					}
				}
			}else{
				$area = $objectConsul->verAreas($idArea);
				foreach ($area as $v) {
					$a= $v['Descripcion'];
					//Envio de correo;
					$msg = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><div style="width: 100%; height: 150px;"><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Header.png"></td></table><div class="col-md-12"><p>El usuario: <strong>'.utf8_decode($nombre).'</strong> <br><br>Desea solicitar <strong>'.$diasSoli.'</strong> d&iacute;as de vacaciones correspondientes al a&ntilde;o en curso, haciendo constar por escrito, su deseo de hacer validos los d&iacute;as de vacaciones que le corresponden.<br><br>No habiendo ning&uacute;n inconveniente de su parte, hace de su conocimiento para disfrutar un plazo vacacional del d&iacute;a <strong>'.$otro.'</strong> al <strong>'.$FechaFinal.'</strong> del presente a&ntilde;o.</p></div><br><br><hr><div class="col-md-8"></div><br><br/><div align="center"><form method="post" action="http://www.intranet.itw.mx/index.php"><table class="table"><tr><br><br><td><label style="font-size:11px;">&Aacute;rea:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$a.'" disabled/></td><td><label style="font-size:11px;">Fecha de ingreso:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$fechaIngreso.'" disabled/></td></tr><tr><td><label style="font-size:11px;">Del:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$otro.'" disabled></td><td><label style="font-size:11px;">Al:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="'.$FechaFinal.'" disabled></td></tr><tr><td><label style="font-size:11px;">D&iacute;as a disfrutar:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasVa.'" disabled></td><td><label style="font-size:11px;">D&iacute;as Solicitados</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasSoli.'" disabled></td></tr><tr><td><label style="font-size:11px;">D&iacute;as pendientes:</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="'.$diasRestantes.'" disabled></td><td><label style="font-size:11px;" >D&iacute;as adicionales</label></td><td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="'.$diasAdi.'" disabled></td></tr><tr></tr></table><div align="center"><input type="submit" class="btn btn-primary" name="btnAprobar" value="Aprobar"></div></form></div><br><hr><div align="justifi"><p style="font-size:11px">&#8220;Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podr&iacute;a contener informaci&oacute;n privada y privilegiada para uso exclusivo del destinatario. Si usted ha recibido esta comunicaci&oacute;n por error, no est&aacute; autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los archivos adjuntos. Gracias.&#8221;</p></div><br><br><table><td><img  width="100%" src="http://www.intranet.itw.mx/intraImg/Footer.png"></td></table> </div></body>';
					//Correos
					$correo =envioCorreos($Director_correo,$Director_nombre,$asunt,$msg);//Director
					correoSeguimiento($asunt,$msg);//Seguimiento
					if ($correo == "Enviado") {
						$actuaizacion= $objectConsul->notificarEnvioCorreo($usuario,4);
						if ($actuaizacion) {
							echo "Correos de solicitudes nuevas enviados";
						}
					}
				}
			}
		}
	}

	function envioCorreos($destinatario,$nombreDestinatario,$asunto,$body){
		$enviado = "";

		$mail = new PHPMailer();
		$mail->IsSMTP();//indicamos el uso de SMTP
		$mail->debug = 1;
		$mail->SMTPAuth = true;//Especificamos la seguridad de la conexion
		$mail->SMTPSecure = "ssl";
		$mail->Host = "server70.neubox.net"; // host del servidor SMTP
		$mail->Username = "intranet@itw.mx";  //usuario de la cuenta SMTP 
		$mail->Password = "Itworkers2016";  //PASWORD del user SMTP
		$mail->Port = 465;  //puerto de salida
		$mail->From = "IntraneITW@itw.mx";  	
		$mail->FromName = "ITWORKERS";
		$mail->AddAddress($destinatario , $nombreDestinatario);
		//$mail->addCC('cc@example.com');
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

	function correoSeguimiento($asunto,$body){
		$enviado = "";
		$mail = new PHPMailer();
		$mail->IsSMTP();//indicamos el uso de SMTP
		$mail->debug = 1;
		$mail->SMTPAuth = true;//Especificamos la seguridad de la conexion
		$mail->SMTPSecure = "ssl";
		$mail->Host = "server70.neubox.net"; // host del servidor SMTP
		$mail->Username = "intranet@itw.mx";  //usuario de la cuenta SMTP 
		$mail->Password = "Itworkers2016";  //PASWORD del user SMTP
		$mail->Port = 465;  //puerto de salida
		$mail->From = "IntraneITW@itw.mx";  	
		$mail->FromName = "ITWORKERS";
		$mail->AddAddress("jesus.calero@itw.mx","Calero Jesus");
		//$mail->AddAddress("Viviana.Garcia@itworkers.com.mx" , "Viviana Garcia Ramos");
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
