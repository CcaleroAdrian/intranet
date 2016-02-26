<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) {  
		//exit();
		header('Location: index.php');
	}
	$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	$strBtnAceptar = isset($_POST['btnAlta']) ? trim( $_POST['btnAlta'] ) : "" ;
	
	$usrIntranet = isset($_POST['usuarioNuevo']) ? trim( $_POST['usuarioNuevo'] ) : "" ;
	$idTipoUsuario = isset($_POST['idTipoUsuario']) ? $_POST['idTipoUsuario'] : "" ;
	$usrnombre = isset($_POST['nombre']) ? trim( $_POST['nombre'] ) : "" ;
	$usrpaterno = isset($_POST['paterno']) ? trim( $_POST['paterno'] ) : "" ;
	$usrmaterno = isset($_POST['materno']) ? trim( $_POST['materno'] ) : "" ;
	$fechaNacimiento =isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : "" ;
	$idSexo =isset($_POST['idSexo']) ? $_POST['idSexo'] : "" ;
	$idCivil =isset($_POST['idCivil']) ? $_POST['idCivil'] : "" ;
	$direccion =isset($_POST['direccion']) ? trim( $_POST['direccion'] ) : "" ;
	$fechaIngreso =isset($_POST['Ingreso']) ? $_POST['Ingreso'] : "" ; 
	$telPersonal =isset($_POST['telPersonal']) ? trim( $_POST['telPersonal'] ) : "" ;
	$celPersonal =isset($_POST['celPersonal']) ? trim( $_POST['celPersonal'] ) : "" ;
	$emailPersonal =isset($_POST['emailPersonal']) ? trim( $_POST['emailPersonal'] ) : "" ;
	$telOfna =isset($_POST['telOfna']) ? trim( $_POST['telOfna'] ) : "" ;
	$celOfna =isset($_POST['celOfna']) ? trim( $_POST['celOfna'] ) : "" ;
	$emailOfna =isset($_POST['emailOfna']) ? trim( $_POST['emailOfna'] ) : "" ;
	$dirOfna =isset($_POST['dirOfna']) ? trim( $_POST['dirOfna'] ) : "" ;
		
	$blnOk = true; 
	$blnAltaOk = false;
	$usuario = "";
	$nombre = ""; 
	$apellido = "";
	$error = "";
	$success = "";
	
	If ( $strBtnAceptar == "Guardar" ) {
		
		If ( $usrIntranet == "" ) { 
			$blnOk = false;
			$usuario = "El campo Usuario es obligatorio."; 
		} else {
			if ( !filter_var( $usrIntranet , FILTER_VALIDATE_EMAIL)   ) { 
				$blnOk = false;
				$error = "El Usuario ". $usrIntranet . " no tiene formato de email v&aacute;lido.";
			}
		}
		
		If ( $blnOk  AND ($usrnombre == "" ) ) { 
			$blnOk = false;
			$nombre = "El campo Nombre es obligatorio."; 
		} else {
			if ( !preg_match("/^[a-zA-Z ]*$/" ,  $usrnombre )  ) { 
				$blnOk = false;
				$error = "El campo Nombre solo acepta letras.";
			}
		}
		
		If ( $blnOk  AND ($usrpaterno == "" ) ) { 
			$blnOk = false;
			$apellido = "El campo Apellido Paterno es obligatorio."; 
		}
		
		// Dar de alta el usuario
		If ( $blnOk ) {
			//Instanciamos la clase que tiene las operaciones a la base de datos
	  		$objAlta = new ActionsDB();
			// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
			$respuesta = $objAlta->setAltaUsuario( $usrIntranet , $idTipoUsuario , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idSexo , $idCivil , $direccion  , $fechaIngreso , $telPersonal, $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $dirOfna  );
			
			If( $respuesta ) {
				$blnAltaOk = true;
				$success = "Se realiz&oacute; el alta del usuario ".  $usrIntranet ." satisfactoriamente." ;
			} else { 
				$error = "Hubo un error al hacer el Alta del Usuario. Favor de intentarlo m&aacute;s tarde";
			}
			 
		}
		
	}
		
	//Si no se ha realizado el alta del usuario satisfcatoriamente
	If( $blnAltaOk == false ) {	
 ?> 
  <script type="text/javascript">
 	$(window).load(function(){
 		var usuario = "<?php echo $usuario; ?>";
 		var nombre = "<?php echo $nombre; ?>";
 		var apellido = "<?php echo $apellido; ?>";
 		var error = "<?php echo $error; ?>";

 		if (error != "") {
 		$("#mensajes").notify(error,"error",{position:"botton center"});
		}else if(usuario != ""){
		$("#user").notify(usuario,"warn",{position:"botton center"});
		}else if (nombre != "") {
		$("#nombre").notify(nombre,"warn",{position:"botton center"});
		}else if (apellido != "") {
		$("#apellido").notify(apellido,"warn",{position:"botton center"});
		};
 	});

 	function myfuction(){
 		window.open("popup.php", "_blank", 'width=333px,height=273px,resizable=yes,toolbar=no'); return false;
 	}

 </script>
 
		<form name="frmAlta" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";  ?>" enctype="multipart/form-data" >
		<h3>ALTA DE USUARIO</h3>
		<div class="panel panel-primary">
    	<div class="panel-heading">INFORMACI&Oacute;N B&Aacute;SICA</div>
   		<div class="panel-body">
		
		  <table width="90%" border="0" cellspacing="1" align="center" class="table-responsive" >
            <tr>
              <td id="mensajes" colspan="4" align="center" >
			  </td>
            </tr>
            <tr>
              <td width="150"><label>Usuario(email): </label></td>
              <td><input id="user"  align="left"  class="textboxBlanco" name="usuarioNuevo" type="email" id="usrIntranet" size="30" maxlength="50"  value= "<?php echo $usrIntranet; ?>" ></td>
              <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
            </tr>
            <tr><td width="130">&nbsp;</td></tr>
            <tr>
              <td width="150"><label>Nombre(s): </label></td>
              <td><input id="nombre" align="left"  class="textboxBlanco" name="nombre" type="text" id="nombre2" size="30" maxlength="30"   value= "<?php echo $usrnombre; ?>"  > 
              </td>
              <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
              <td width="150"><label>Apellido Paterno: </label></td>
              <td><input id="apellido" align="left"  class="textboxBlanco" name="paterno" type="text" id="paterno2" size="30" maxlength="30"  value= "<?php echo $usrpaterno; ?>"  > </td>
              <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
            </tr>
            <tr><td width="130">&nbsp;</td></tr>
            <tr>
              <td width="150"><label>Apellido Materno</label></td>
              <td><input align="left"  class="textboxBlanco" name="materno" type="text" id="materno2" size="30" maxlength="30"  value= "<?php echo $usrmaterno; ?>"  ></td>
              <td></td>
              <td width="150"><label>Fecha de Nacimiento</label></td>
              <td><input align="left"  class="textboxBlanco" name="fechaNacimiento" type="date" id="fechaNacimiento" size="10" maxlength="10"  value= "<?php echo $fechaNacimiento ; ?>" ></td>
              <td></td>
            </tr>
            <tr><td width="130">&nbsp;</td></tr>
            <tr>
              <td width="150"><label>Sexo:</label></td>
              <td><select name="idSexo" id="select2" class="form-control"   >
           	    <option value="1" <?php echo ( $idSexo == "1") ?  "selected" : "";  ?> >MASCULINO</option>
	  		    <option value="2" <?php echo ( $idSexo == "2") ?  "selected" : "" ; ?> >FEMENINO</option>
              </select></td>
              <td></td>
              <td width="150"><label>Estado Civil :</label> </td>
              <td><select id="select3"   name="idCivil"  class="form-control"  >
                  <option value="1" <?php echo ( $idCivil == "1") ?  "selected" : "";  ?> >SOLTERO</option>
			    <option value="2" <?php echo ( $idCivil == "2") ?  "selected" : "";  ?> >CASADO</option>
			    <option value="3" <?php echo ( $idCivil == "3") ?  "selected" : "";  ?> >DIVORCIADO</option>
			    <option value="4" <?php echo ( $idCivil == "4") ?  "selected" : "";  ?> >UNION LIBRE</option>
              	</select></td>
              	<td></td>
            </tr>
            <tr><td width="130">&nbsp;</td></tr>
            <tr>
            	<td width="150"><label>Tel&eacute;fono Personal:</label> </td>
              	<td><input align="left"  class="textboxBlanco" name="telPersonal" type="tel" id="telPersonal" size="30" maxlength="14" value= "<?php echo $telPersonal ; ?>"  ></td>
              	<td></td>
            	<td width="150"><label>Celular Personal:</label> </td>
              	<td><input align="left"  class="textboxBlanco" name="celPersonal" type="tel" id="celPersonal" size="30" maxlength="14"  value= "<?php echo $celPersonal ; ?>" ></td>
              	<td></td>
            </tr>
            <tr><td width="130">&nbsp;</td></tr>
            <tr>
              <td width="150"><label>Email Personal:</label></td>
              <td><input align="left"  class="textboxBlanco" name="emailPersonal" type="email" id="emailPersonal" size="30" maxlength="80" value= "<?php echo $emailPersonal ; ?>"  ></td>
              <td></td>
              <td width="150"><label>Direcci&oacute;n:</label></td>
              <td><textarea name="direccion" cols="35" class="textboxBlanco" id="direccion" align="left"><?php echo $direccion ; ?></textarea> </td>
              <td></td>
            </tr>
          </table>
            </div>
   		</div>
		  <div class="panel panel-primary">
    		<div class="panel-heading">INFORMACI&Oacute;N LABORAL</div>
   			<div class="panel-body">
   			<table class="table-responsive">
   				<tr>
   					<td width="150"><label>Fecha Ingreso:</label></td>
            		<td><input align="left"  class="textboxBlanco" name="fechaIngreso" type="date" id="fechaIngreso" size="10" maxlength="10" value= "<?php echo $fechaIngreso; ?>"   ></td>
            		<td></td>
            		<td width="150"><label>Tipo de Usuario:</label></td>
              		<td><select name="idTipoUsuario" size="" id="select" class="form-control" >
                  		<option value="1" <?php echo ( $idTipoUsuario == "1") ?  "selected" : "";  ?> >ADMINISTRADOR</option>
                  		<option value="2" <?php echo ( $idTipoUsuario == "2") ?  "selected" : "";  ?>  >NORMAL</option>
              			</select>
              		</td>
              		<td></td>
   				</tr>
   				<tr><td width="130">&nbsp;</td></tr>
   				<tr>
   					<td width="150"><label>Tel&eacute;fono Oficina:</label></td>
              		<td><input align="left"  class="textboxBlanco" name="telOfna" type="tel" id="telOfna" size="30" maxlength="14" value= "<?php echo $telOfna ; ?>"  ></td>
              		<td></td>
   					<td width="150" ><label>Celular Trabajo:</label></td>
              		<td><input align="left"  class="textboxBlanco" name="celOfna" type="tel" id="celOfna" size="30" maxlength="14" value= "<?php echo $celOfna ; ?>"  ></td>
              		<td></td>
   				</tr>
   				<tr><td width="130">&nbsp;</td></tr>
   				<tr>
   					<td width="150"><label>Email Oficina:</label></td>
              		<td><input align="left"  class="textboxBlanco" name="emailOfna" type="email" id="emailOfna" size="30" maxlength="80"  value= "<?php echo $emailOfna ; ?>" ></td>
              		<td></td>
              		<td width="150"><label>Direcci&oacute;n Oficina:</label></td>
              		<td><textarea name="dirOfna" cols="40" class="textboxBlanco" id="dirOfna" align="left"><?php echo $dirOfna ; ?></textarea></td>
              		<td></td>
   				</tr>
   				<tr><td width="130">&nbsp;</td></tr>
   				<tr>
   					<td colspan="4"><span class="glyphicon glyphicon-asterisk" style="color:red"><label style="color:red;">Campos obligatorios </label></div></td>
   				</tr>
   			</table>
   			</div>
   		</div>
   		<div align="center">
                <input class="btn btn-primary"  name="btnAlta" type="submit" id="btnAlta" value="Guardar" >
        </div>
        <div>&nbsp;</div>
</form>
<?php
		
	} else {
		//Cuando se hace el alta del usuario aparece la confirmación
?>
		<table width="90%"  border="0" cellspacing="2" cellpadding="0" class="table table-responsive">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="300">&nbsp;
				<form name="frmContinua" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";  ?>"  >
              <table    border="0" align="center" cellpadding="0" cellspacing="2" class="table-responsive">
                <tr>
                  <td>&nbsp;
				  	 <?php 
						if( $success <> "" ){
							echo "<div aling='center'   > ". $success ."   </div>";
						}
					?> 
				  </td>
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