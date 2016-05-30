<?php
	require_once("clases/class.phpmailer.php");

	$usrEmail = isset($_POST['']) ? trim($_POST['']) : "";
	$pwdTmp = isset($_POST['']) ? trim($_POST['']) : "";

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
	$mail->AddAddress($usrEmail);
	$mail->IsHTML(true); // El correo se envía como HTML
	$mail->Subject = "Recuperación de Contrase&ntilde;" ; // Este es el titulo del email.
	$body = "Tu clave de acceso a nuestro sistema de intranet ITW es: " .$pwdTmp;
	//$body .= ""
	$mail->Body = $body; // Mensaje a enviar
	$exito = $mail->Send(); // Envía el correo.

	if (  $exito ){
		
	} else {
		$error = "Fall&oacute; el env&iacute;o del correo con la contrase&ntilde;a temporal, vuelva a intentarlo m&aacute;s tarde."; 
	}
?>