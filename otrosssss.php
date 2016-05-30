 
	/*$blnOk = true;
	
	if ( $usr <> "" AND $pwd <> "" ) { 
		 
		if ( !filter_var( $usr , FILTER_VALIDATE_EMAIL)   ) {
			$blnOk= false;
			$error = "El Usuario ". $usr. " no tiene formato de email valido.";
			header('Location: index.php?usuarioitw='.$usr.' & error=' . $error . ' ');  
		}
		
		If ( $blnOk ) {
			try {
				$datos = array();//instanciamos un array
				$response = \Httpful\Request::get($url)//realizamos la peticion a nuestro Web Services RestFul
 					->addHeaders(array(
					        'EMAIL' => $usr,              // Or add multiple headers at once
					        'PWD' => md5($pwd)   // in the form of an assoc array
					    ))->send();

   				if ($response->code != 200) {
   					$error = "El usuario o contraseña no son válidos.";
					header('Location: index.php?usuarioitw='.$usr.'&error='.$error.' ');
   				}else{
	   				//Instanciamos la clase sesión
	   				$datos = json_decode($response);
					$objSesion = new Sesion();
					//Iniciamos la sesion
					$objSesion->init();
					//Guardamos en sesión el usuario, el idPerfil, la desc. del perfil y su ID
					$objSesion->set('USUARIO', $datos->email_1);
					$objSesion->set('IDUSUARIO',$datos->empleado_id);
					$objSesion->('AREAID',$datos->area_id);
					//Guardar hora de inicio de sesion
					$objSesion->set('HoraIngreso', date("Y-n-j H:i:s"));
					
					//Redirigir a la página index
					header('Location: index.php');
   				}
			} catch (Exception $e) {
				header("Location:error.php");
			}
		}
	} else {  
		If ( $usr == ""  AND  $pwd == "" ) {
			$error = "Los campos Usuario y Contraseña son obligatorios.";
			header('Location: index.php?error=' . $error . ' ');
		} else If ( $usr == "" ) {
			$error = "El campo Usuario no puede estar vacio.";
			header('Location: index.php?error=' . $error . ' ');
		} else {
			$error = "El campo Contraseña es obligatorio.";
			header('Location: index.php?usuarioitw='.$usr.' &error=' . $error . ' ');
		}
		
	}

	
	*/