<?php

	require'clases/actionsDB.php'; 
	require'clases/sesion.php';

	$usr =isset($_POST['usuarioitw']) ? trim( strtolower($_POST['usuarioitw']) ) : "" ;
	$pwd =isset($_POST['pwditw']) ? trim ( $_POST['pwditw'] ) : "" ;
	$blnOk = true;
	if ( $usr <> "" AND $pwd <> "" ) {
		 
		if ( !filter_var( $usr , FILTER_VALIDATE_EMAIL)   ) {
			$blnOk= false;
			$error = "El Usuario ". $usr. " no tiene formato de email valido.";
			header('Location: index.php?usuarioitw='.$usr.' & err=' . $error . ' ');  
		}
		
		If ( $blnOk ) {
			//Instanciamos la clase que tiene las operaciones a la base de datos
			$objOperaciones = new ActionsDB();
			// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
			$objRegistro = $objOperaciones->getUsuarioSesion( $usr , $pwd );
			if ( $objRegistro == -1 ) {
				$error = "Falló la conexión con la base de datos.";
				header('Location: index.php?err=' . $error . ' ');
			} else if ( $objRegistro == 0 ) {
				$error = "El usuario o contraseña no son válidos.";
				header('Location: index.php?usuarioitw='.$usr.' & err=' . $error . ' ');
			} else {
				//Instanciamos la clase sesión
				$objSesion = new Sesion();

				//Iniciamos la sesion
				$objSesion->init();
				session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0);
				//Guardamos en sesión el usuario, el idPerfil, la desc. del perfil y su ID
				$objSesion->set('USUARIO', $objRegistro["usrIntranet"] );
				$objSesion->set('ID_PERFIL', $objRegistro["idPerfil"]);
				$objSesion->set('DESC_PERFIL', $objRegistro["descPerfil"]);//descripcion del perfil
				$objSesion->set('IDUSUARIO',$objRegistro["idUsuario"]);
				//Guardar hora de inicio de sesion
				$objSesion->set('HoraIngreso', date("Y-n-j H:i:s"));
				
				//Redirigir a la página index
				header('Location: index.php');
			}
		}
	} else {  
		If ( $usr == ""  AND  $pwd == "" ) {
			$error = "Los campos Usuario y Contraseña son obligatorios.";
			header('Location: index.php?err=' . $error . ' ');
		} else If ( $usr == "" ) {
			$error = "El campo Usuario no puede estar vacio.";
			header('Location: index.php?err=' . $error . ' ');
		} else {
			$error = "El campo Contraseña es obligatorio.";
			header('Location: index.php?usuarioitw='.$usr.' & err=' . $error . ' ');
		}
		
	}

	
	
?>