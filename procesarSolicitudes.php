<?php
	require 'clases/actionsDB.php'; 

	$opcion = $_GET['opcion'];
	$id= isset($_GET['id']) ? trim($_GET['id']) : "" ;

	if ($opcion == 1) {
		$objOperaciones = new ActionsDB();
		$resultado = $objOperaciones->procesarSolicitudes($id,$opcion);
		if ($resultado) {
			$mensaje ="La solicitud fué aceptada";
		}
	}elseif ($opcion == 2) {
		$objOperaciones = new ActionsDB();
		$resultado = $objOperaciones->procesarSolicitudes($id,$opcion);
		if ($resultado) {
			$mensaje ="La solicitud fué rechazada";
		}
	}elseif ($opcion == 3) {
		$objOperaciones = new ActionsDB();
		//Buscar usuarios con solicitudes aceptadas y que no hayan recibido correo de notificacion
		$resultado = $objOperaciones->buscarSolicitudesAceptadas();
		if ($resultado > 0 OR $resultado != -1 ) {
			foreach ($resultado as $key) {
				
				$usuario = $objOperaciones->notificarUsuario($key['idUsuario']);//obtenmos datos del usuario
				foreach ($usuario as $k) {
					$correo = $k['usrIntranet'];
					$nombre = utf8_encode($k["nombre"].' '.$k["paterno"].' '.$k["materno"]);
				
					//Envio de correo de notificación
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
					$mail->IsHTML(true); // El correo se envía como HTML
					$mail->Subject = "Solicitud de vacaciones" ; // Este es el titulo del email.
					$body ="";
					$mail->Body = $body; // Mensaje a enviar
					$exito = $mail->Send();

					if ($exito) {//Si se envia el correo actualizar usuario a correo enviado
						//realizar la actuzalizacion
						$envio = $objOperaciones->notificarEnvioCorreo($key['idUsuario']);
						if ($envio) {
							
						}
						//redireccionar
						$mensaje="";
					}
				}
			}
		}else{
		}
	}
	header("Location : intranet/submenu_SolicitudesVacaciones_Recibidas.php?mensaje=".$mensaje."");
?>