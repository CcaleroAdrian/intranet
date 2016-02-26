<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}
	$mensaje = "";
	$blnModOk = false;
	$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	$usrIntranet =isset($_GET['Usuario']) ? trim($_GET['Usuario']) : "" ;
	$btnEliminar =isset($_POST['btnEliminar']) ? trim($_POST['btnEliminar']) : "" ;
	$btnCancelar =isset($_POST['btnCancelar']) ? trim($_POST['btnCancelar']) : "" ;
	
	if ( $btnEliminar == "Eliminar") { 
		$usrnombre = isset($_POST['nombre']) ? trim( $_POST['nombre'] ) : "" ;
		$usrpaterno = isset($_POST['paterno']) ? trim( $_POST['paterno'] ) : "" ;
		$usrmaterno = isset($_POST['materno']) ? trim( $_POST['materno'] ) : "" ;
		$fechaNacimiento =isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : "" ;
		$idPerfil =isset($_POST['idPerfil']) ? $_POST['idPerfil'] : "" ;
		$idEstatus =isset($_POST['idEstatus']) ? $_POST['idEstatus'] : "" ;
		$idSexo =isset($_POST['idSexo']) ? $_POST['idSexo'] : "" ;
		$idCivil =isset($_POST['idCivil']) ? $_POST['idCivil'] : "" ; 
		$direccion =isset($_POST['direccion']) ? $_POST['direccion'] : "" ;
		$fechaIngreso =isset($_POST['fechaIngreso']) ? $_POST['fechaIngreso'] : "" ;
		$fechaSalida =isset($_POST['fechaSalida']) ? $_POST['fechaSalida'] : "" ;
		$telPersonal =isset($_POST['telPersonal']) ? $_POST['telPersonal'] : "" ;
		$celPersonal =isset($_POST['celPersonal']) ? $_POST['celPersonal'] : "" ;
		$emailPersonal =isset($_POST['emailPersonal']) ? $_POST['emailPersonal'] : "" ;
		$telOfna =isset($_POST['telOfna']) ? $_POST['telOfna'] : "" ;
		$celOfna =isset($_POST['celOfna']) ? $_POST['celOfna'] : "" ;
		$emailOfna =isset($_POST['emailOfna']) ? $_POST['emailOfna'] : "" ;
		$direccionOfna =isset($_POST['direccionOfna']) ? $_POST['direccionOfna'] : "" ;
		
		//Instanciamos la clase que tiene las operaciones a la base de datos
		$objPerfil = new ActionsDB();
		// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
		$respuesta = $objPerfil->setEliminaUsuario( $usrIntranet );
		If(  $respuesta  ) {
			$blnModOk = true;
			$mensaje = "Se elimino satisfactoriamente la información del perfil.";
		} else { 
			$mensaje = "No fué posible actualizar la información del perfil del usuario " . $usrIntranet . ".";
		} 
	}
	
	
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objOperaciones = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$usr = $objOperaciones->getDatosUsuario( $usrIntranet );
	If ( $usr == -1  OR  $usr == 0 ) { 
		$mensaje = "No fué posible obtener la información del usuario " . $usrIntranet . ".";
	} 
	
	//Si no se ha realizado la modificacion se vuelve a mostrar el detalle del usuario
	If (!$blnModOk ) {
 ?> 
  		<h4> Eliminar Usuario&nbsp; </h4>
		<form name="frmModifUsr" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu ."&Usuario=". $usrIntranet ."";  ?>" enctype="multipart/form-data" >
		<div class="panel panel-primary">
      <div class="panel-heading">MENSAJE</div>
      <div class="panel-body">
      <div align="center">
        <label>Esta por eliminar al usuario:</label><br>
        <label><?php echo $usr['nombre'].' '.$usr['paterno'].' '.$usr['materno'];
                  ?></label><br>
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
?>
		
		<table width="90%"  border="0" cellspacing="2" cellpadding="0" class="tblFrm">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="300">&nbsp;
				<form name="frmContinua" method="post" action="<?php echo "submenu_UsuariosModifica.php?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu ."&Usuario=". $usrIntranet ."";  ?>"  >
              <table width="90%"   border="0" align="center" cellpadding="0" cellspacing="2" class="tblFrm">
                <tr>
                  <td align="center">
				  	 <?php 
							echo "<div aling='center'  > La eliminaci&oacute;n del usuario ". $usrIntranet ." fu&eacute; exitosa. </div>";
					?> 
				     <div align="center"></div></td>
                </tr>
                <tr>
                  <td><div align="center">
                    
                      <p>&nbsp;
                    </p>
                      <p>
                        <input type="submit" name="btnContinuar" value="Continuar" class="btn btn-primary">
                       
                    </p>
                  </div>
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>			
			  </form>  
              <div align="center">
			  
			  </div></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table> 	
			 
<?php
	
	}
	
	include("intraFooter.php"); 
?> 
