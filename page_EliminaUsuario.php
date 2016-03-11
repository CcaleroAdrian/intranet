<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}
	$mensaje = "";
	$blnModOk = false;
	$idUsuario =isset($_GET['Usuario']) ? trim($_GET['Usuario']) : "" ;
	$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']): "";
	$btnEliminar =isset($_POST['btnEliminar']) ? trim($_POST['btnEliminar']) : "" ;
	$btnCancelar =isset($_POST['btnCancelar']) ? trim($_POST['btnCancelar']) : "" ;
	
	if ( $btnEliminar == "Eliminar") { 
		$usrID = isset($_POST['Usuario']) ? trim( $_POST['Usuario'] ) : "" ;
		//Instanciamos la clase que tiene las operaciones a la base de datos
		$objPerfil = new ActionsDB();
		// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
		$respuesta = $objPerfil->setEliminaUsuario($usrID);
		If($respuesta) {
			$blnModOk = true;
			$mensaje = "Se elimino satisfactoriamente la información del usuario:". $nombre ."";
		} else { 
			$mensaje = "No fué posible actualizar la información del perfil del usuario " . $nombre . "";
		} 
	}
	
	
	//Si no se ha realizado la modificacion se vuelve a mostrar el detalle del usuario
	If (!$blnModOk ) {
 ?> 
  		<h4> Eliminar Usuario&nbsp; </h4>
		<form name="frmModifUsr" method="post" action="<?php echo $_SERVER['PHP_SELF']. "?Usuario=".$idUsuario."";  ?>" enctype="multipart/form-data" >
		<div class="panel panel-primary">
      <div class="panel-heading">MENSAJE</div>
      <div class="panel-body">
      <div align="center">
        <label>Esta por eliminar al usuario:</label><br>
        <label><?php echo utf8_encode($nombre);?></label><br>
        <label>&iquest;Desea continuar?</label>
      </div>
      <br>
      <div align="center">
      	<input type="submit" class="btn btn-primary" name="btnEliminar" value="Eliminar">
  
	</div>
    </div>
		</form>
<?php
	
	} else {
		// Cuando la modificación es exitosa  se muestra el botón de continuar para regresar a la pantalla principal de modificación.
	echo "<script type='text/javascript'>
    var url= 'submenu_UsuariosModifica.php?usuario=".$mensaje."';
    window.open(url,'_parent');
    </script>";
	}
	
	include("intraFooter.php"); 
?> 
