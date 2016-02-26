<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) {  
		header('Location: index.php');
	}
	$mensaje = "";
	$blnModOk = false;
	$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	$usrIntranet =isset($_GET['Usuario']) ? trim($_GET['Usuario']) : "" ;//usuario a modificar
	$btnActualizar =isset($_POST['btnActualizar']) ? trim($_POST['btnActualizar']) : "" ;//evento sobre boton
	
	If ( $btnActualizar == "Guardar") { 
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
		$respuesta = $objPerfil->setActualizaUsuario( $usrIntranet , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idPerfil , $idEstatus , $idSexo , $idCivil , $direccion , $fechaIngreso , $fechaSalida , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna );
		If(  $respuesta  ) {
			$blnModOk = true;
			$mensaje = "Se actualizó satisfactoriamente la información del perfil.";
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
  	<h3> Modifica Usuario&nbsp; </h3>
		<form name="frmModifUsr" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu ."&Usuario=". $usrIntranet ."";  ?>" enctype="multipart/form-data" >
		<div class="panel panel-primary">
      <div class="panel-heading">INFORMACI&Oacute;N B&Aacute;SICA</div>
      <div class="panel-body">
		<table class="table-responsive" >
          <tr>
            <td width="130"><label>Usuario Intranet</label></td>
            <td width="200"><input  align="left" class="textboxBlanco" name="usrIntranet" type="text" id="usrIntranet" size="30" maxlength="50"  value=" <?php echo trim($usr['usrIntranet'])  ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td width="130"><label>Nombre(s)</label></td>
            <td width="200"><input align="left"  class="textboxBlanco" name="nombre" type="text" id="nombre" size="30" maxlength="30"  value=" <?php echo trim($usr['nombre'])  ?>"   ></td>
            <td></td>
            <td width="130"><label>Apellido Paterno:</label></td>
            <td width="200"><input align="left"  class="textboxBlanco" name="paterno" type="text" id="paterno" size="30" maxlength="30" value=" <?php echo trim($usr['paterno'])  ?>"   ></td>
          </tr>
          <tr><td width="130">&nbsp;</td></tr>
          <tr>
            <td width="130" ><label>Apellido Materno:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="materno" type="text" id="materno" size="30" maxlength="30" value=" <?php echo trim($usr['materno'])  ?>"   >  </td>
            <td></td>
            <td width="130"><label>Fecha de Nacimiento:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="fechaNacimiento" type="date" id="fechaNacimiento" size="10" maxlength="10"  value=" <?php echo $usr['fechaNacimiento'];  ?>" ></td>
            <td></td>
          </tr>
          <tr><td width="130">&nbsp;</td></tr>
          <tr>
            <td width="130" ><label>Sexo:</label></td>
            <td width="200"><select name="idSexo" id="idSexo" class="form-control" >
              <option value="1" <?php echo ($usr['idSexo'] == "1") ?  "selected" : "";  ?> >MASCULINO</option>
              <option value="2" <?php echo ($usr['idSexo'] == "2") ?  "selected" : "" ; ?> >FEMENINO</option>
            </select></td>
            <td></td>
            <td width="130"><label>Estado Civil:</label> </td>
            <td width="200">
            <select name = "idCivil" id="idCivil"  tabindex = " <?php echo $usr['idCivil']; ?> " class="form-control"  > 
              <option value="1" <?php echo ($usr['idCivil'] == "1") ?  "selected" : "";  ?> >SOLTERO</option>
              <option value="2" <?php echo ($usr['idCivil'] == "2") ?  "selected" : "";  ?> >CASADO</option>
              <option value="3" <?php echo ($usr['idCivil'] == "3") ?  "selected" : "";  ?> >DIVORCIADO</option>
              <option value="4" <?php echo ($usr['idCivil'] == "4") ?  "selected" : "";  ?> >UNION LIBRE</option>
              </select></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          </tr>
          <tr><td width="130">&nbsp;</td></tr>
           <tr>
            <td width="130"><label>Tel&eacute;fono Personal:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="telPersonal" type="tel" id="telPersonal" size="30" maxlength="14" value=" <?php echo trim($usr['telPersonal'])  ?>" ></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
            <td width="130"><label>Celular Personal:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="celPersonal" type="tel" id="celPersonal" size="30" maxlength="14" value=" <?php echo $usr['celPersonal']  ?>" ></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          </tr>
          <tr><td width="130">&nbsp;</td></tr>
          <tr>
            <td width="130"><label>Email Personal:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="emailPersonal" type="email" id="emailPersonal" size="30" maxlength="80" value=" <?php echo trim($usr['emailPersonal'])  ?>" ></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
            <td width="130"><label>Direcci&oacute;n:</label>  </td>
            <td width="200"><textarea name="direccion" cols="33" class="textboxBlanco" id="direccion2" align="left"> <?php echo trim($usr['direccion']) ?></textarea></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading">INFORMACI&Oacute;N LABORAL</div>
      <div class="panel-body">
      <table>
        <tr>
            <td><label>Fecha Ingreso:</label></td>
            <td><input align="left"  class="textboxBlanco" name="fechaIngreso" type="date" id="fechaIngreso" size="10" maxlength="10"  value=" <?php echo $usr['fechaIngreso'];  ?>" ></td>
            <td></td>
            <td width="130"><label>Fecha Salida:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="fechaSalida" type="date" id="fechaSalida" size="10" maxlength="10"  value=" <?php echo $usr['fechaSalida'];  ?>" ></td>
            <td></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
            <td width="130"><label>Perfil del Usuario:</label> </td>
            <td width="200"><select name="idPerfil" id="idPerfil"    class="form-control" >
              <option value="1" <?php echo ($usr['idPerfil'] == "1") ?  "selected" : "";  ?> >ADMINISTRADOR</option>
              <option value="2" <?php echo ($usr['idPerfil'] == "2") ?  "selected" : "" ; ?> >NORMAL</option>
            </select></td>
            <td></td>
            <td><label>Estatus:</label></td>
            <td><select name="idEstatus" id="idEstatus"   class="form-control" >
              <option value="1" <?php echo ($usr['idEstatus'] == "1") ?  "selected" : "";  ?> >ACTIVO</option>
              <option value="2" <?php echo ($usr['idEstatus'] == "2") ?  "selected" : "" ; ?> >INACTIVO</option>
            </select></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
            <td width="130"><label>Tel&eacute;fono de Oficina:</label></td>
            <td width="200"><input align="left"  class="textboxBlanco" name="telOfna" type="tel" id="telOfna" size="30" maxlength="14" value=" <?php echo trim($usr['telOfna'])  ?>" ></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
            <td width="130"><label>Celular de Trabajo:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="celOfna" type="tel" id="celOfna" size="30" maxlength="14" value=" <?php echo trim($usr['celOfna'])  ?>" ></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>        
            <td width="130"><label>Email de Trabajo:</label> </td>
            <td width="200"><input align="left"  class="textboxBlanco" name="emailOfna" type="email" id="emailOfna" size="30" maxlength="80" value=" <?php echo trim($usr['emailOfna']);  ?>" ></td>
            <td></td>
            <td width="130"><label>Ubicaci&oacute;n de Oficina:</label></td>
            <td width="200"><textarea name="direccionOfna" cols="33" class="textboxBlanco" id="direccionOfna3" align="left"> <?php echo trim($usr['direccionOfna'])  ?></textarea></td>
            <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
          <td colspan="4"><span class="glyphicon glyphicon-asterisk" style="color:red"><label style="color:red;">Datos modificables.</label></span></td>
        </tr>
      </table>
      </div>
    </div>
    <div align="center"> 
              <input type="submit" class="btn btn-primary" name="btnActualizar" value="Guardar">
    </div>
    <div>&nbsp;</div>
	</form>
<?php
	
	} else {
		// Cuando la modificación es exitosa  se muestra el botón de continuar para regresar a la pantalla principal de modificación.
?>
		
		<table width="90%"  border="0" cellspacing="2" cellpadding="0" class="table-responsive">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="300">&nbsp;
				<form name="frmContinua" method="post" action="<?php echo "submenu_UsuariosModifica.php?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu ."&Usuario=". $usrIntranet ."";  ?>"  >
              <table   border="0" align="center" cellpadding="0" cellspacing="2" class="table-responsive">
                <tr>
                  <td>&nbsp;
				  	 <?php 
							echo "<div aling='center'  ><label>La actualizaci&oacute;n del usuario ". $usrIntranet ." fu&eacute; exitosa.</label></div>";
					?> 
				  </td>
                </tr>
                <tr>
                  <td><div align="center">
                    
                      <p>&nbsp;
                    </p>
                      <p>
                        <input type="submit" name="btnContinuar" value="Continuar" class="btn btn-primary" >
                       
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
