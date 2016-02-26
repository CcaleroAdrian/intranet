<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}
	$error = "";
  $success= ""; 
	$blnOk = true;
	$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	$btnActualizar =isset($_POST['btnActualizar']) ? trim($_POST['btnActualizar']) : "" ;
	
	If ( $btnActualizar == "Actualizar") {
		
		$idCivil =isset($_POST['idCivil']) ? $_POST['idCivil'] : "" ;
		$direccion =isset($_POST['direccion']) ? $_POST['direccion'] : "" ;
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
		$respuesta = $objPerfil->setActualizaPerfil( $USUARIO , $idCivil , $direccion , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna );
		If(  $respuesta  ) {
			$blnOk = true;
			$success = "La información de su perfil fué actualizada satisfactoriamente.";
		} else {
			$blnOk = false;
			$error = "No fu&eacute; posible realizar la actualizaci&oacute;n de la informaci&oacute;n de su usuario: " . $USUARIO . ".";
		} 
	}
	
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objOperaciones = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$usr = $objOperaciones->getDatosPerfil( $USUARIO );
	If ( $usr == -1  OR  $usr == 0 ) {
		$blnOk = false;
		$error = "No fu&eacute; posible realizar la actualizaci&oacute;n de la informaci&oacute;n de su usuario: " . $USUARIO . ".";
	} 
		//Calculo de vacaciones
$fecha=$usr['fechaIngreso'];;
$segundos=strtotime('now') - strtotime($fecha);
$antiguedad=intval($segundos/60/60/24);
$vacaciones = 0;
  if ($antiguedad == 365) { //1 años
    $vacaciones = 6;
  }elseif ($antiguedad == 730) {//2 años
    $vacaciones = 8;
  }elseif ($antiguedad == 1095) {//3 años
    $vacaciones = 10;
  }elseif ($antiguedad >= 1460 && $antiguedad <= 2920) {//4 años a 8 años
    $vacaciones = 12;
  }elseif ($antiguedad >= 3285 && $antiguedad <= 4745) {//9 años A 13 años
    $vacaciones = 14;
  }elseif ($antiguedad >= 5110) {//14 años o más
    $vacaciones = 16;
  }
		
 ?> 

	 <script type="text/javascript">
  $(window).load(function(){
    var error = "<?php echo $error; ?>";
    var mensaje = "<?php echo $success; ?>";

    /*if (error != "") {
    $("#mensaje").notify(error,"error",{position:"botton center"});
    }else{
    $("#mensaje").notify(mensaje,"success",{position:"botton center"});
    };*/
  });
 </script>
      <!--<h4> Mi Perfil &nbsp; </h4>-->
<form name="frmPerfil" method="post" ction="<?php echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";  ?>" enctype="multipart/form-data" >
  <h3>Mi perfil</h3>
  <div class="panel panel-primary">
    <div id="mensaje" class="panel-heading">INFORMACIÓN BÁSICA</div>
    <div class="panel-body">
      <table class="table-responsive">
        <tr>
          <td><label>Usuario intranet:</label></td>
          <td><input  align="left" class="textboxBloqueado" name="usrIntranet" type="text" id="usrIntranet" size="30" maxlength="50"  value=" <?php echo trim($usr['usrIntranet'])  ?>"   disabled="true" ></td>
        </tr>
        <tr>
          <td><label>Nombres(s):</label></td>
          <td><input align="left"  class="textboxBloqueado" name="nombre" type="text" id="nombre2" size="30" maxlength="30"  value=" <?php echo trim($usr['nombre'])  ?>" disabled="true"  ></td>
          <td></td>
          <td><label>Apellido Paterno:</label></td>
          <td><input align="left"  class="textboxBloqueado" name="paterno" type="text" id="paterno2" size="30" maxlength="30" value=" <?php echo trim($usr['paterno'])  ?>" disabled="true"  ></td>
          <td></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
          <td><label>Apellido Materno:</label></td>
          <td><input align="left"  class="textboxBloqueado" name="materno" style="width:119px" type="text" id="materno2" size="30" maxlength="30" value=" <?php echo trim($usr['materno'])  ?>" disabled="true"  ></td>
          <td></td>
          <td><label>Fecha de nacimiento:</label></td>
          <td><input align="left"  class="textboxBloqueado" name="fechaNacimiento" type="text" id="fechaNacimiento" size="10" maxlength="10"  value=" <?php echo $usr['fechaNacimiento'];  ?>" disabled="true"  ></td>
          <td></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
          <td><label>Sexo:</label></td>
          <td><select name="idSexo" id="select" disabled="true"  class="selectBloqueado form-control" >
              <option value="1" <?php echo ($usr['idSexo'] == "1") ?  "selected" : "";  ?> >MASCULINO</option>
              <option value="2" <?php echo ($usr['idSexo'] == "2") ?  "selected" : "" ; ?> >FEMENINO</option>
              </select>
          </td>
          <td></td>
          <td><label>Estado civil:</label></td>
          <td><Select  id="idCivil" name = "idCivil" tabindex = " <?php echo $usr['idCivil']; ?> " class="form-control" style="wight:110px" > 
          <option value="1" <?php echo ($usr['idCivil'] == "1") ?  "selected" : "";  ?> >SOLTERO</option>
          <option value="2" <?php echo ($usr['idCivil'] == "2") ?  "selected" : "";  ?> >CASADO</option>
          <option value="3" <?php echo ($usr['idCivil'] == "3") ?  "selected" : "";  ?> >DIVORCIADO</option>
          <option value="4" <?php echo ($usr['idCivil'] == "4") ?  "selected" : "";  ?> >UNION LIBRE</option>
          </select></td><td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
          <td><label>Tel&eacute;fono personal:</label></td>
          <td><input align="left"  class="textboxBlanco" name="telPersonal" type="tel" id="telPersonal2" size="10" maxlength="12" value=" <?php echo trim($usr['telPersonal'])  ?>" ></td>
          <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Celular personal:</label></td>
          <td><input align="left"  class="textboxBlanco" name="celPersonal" type="tel" id="celPersonal" size="10" maxlength="12" value=" <?php echo $usr['celPersonal']  ?>" ></td>
          <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td></td>
        </tr>
        <tr><td width="130">&nbsp;</td></tr>
        <tr>
          <td><label>Email personal:</label></td>
          <td style="width:10px"><input align="left"  class="textboxBlanco" name="emailPersonal" type="email" id="emailPersonal" size="20" maxlength="50" value=" <?php echo trim($usr['emailPersonal'])  ?>" ></td>
          <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Direcci&oacute;n</label>
          <td><textarea name="direccion" cols="33" class="textboxBlanco" id="direccion2" align="left" style="height:60px"> <?php echo trim($usr['direccion']) ?></textarea></td>
          <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
      </table>     

    </div>
  </div>
 <div class="panel panel-primary">
  <div class="panel-heading">INFORMACIÓN LABORAL</div>
    <div class="panel-body">
    <table class="table-responsive">
      <tr>
        <td><label>Fecha de ingreso</label></td>
        <td><input align="left"  class="textboxBloqueado" name="fechaNacimiento" type="text" id="fechaNacimiento" size="10" maxlength="10"  value="<?php echo $usr['fechaIngreso'];  ?>" disabled="true"  ></td>
        <td></td>
        <td><label>Días de vacaciones</label></td>
        <td><input align="left"  class="textboxBloqueado" name="nombre" type="text" id="nombre2" size="2" maxlength="3"  value="<?php echo $vacaciones ?> " disabled="true"  ></td>
        <td></td>
      </tr>
      <tr><td width="130">&nbsp;</td></tr>
      <tr>
        <td><label>Tel&eacute;fono de Oficina</label></td>
        <td><input align="left"  class="textboxBlanco" name="telOfna" type="tel" id="telOfna" size="10" maxlength="12" value=" <?php echo trim($usr['telOfna'])  ?>" ></td>
        <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
        <td><label>Celular de trabajo</label></td>
        <td><input align="left"  class="textboxBlanco" name="celOfna" type="tel" id="celOfna" size="10" maxlength="12" value=" <?php echo trim($usr['celOfna'])  ?>" ></td>
        <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
      </tr>
      <tr><td width="130">&nbsp;</td></tr>
      <tr>
      <td><label>Email de oficina</label></td>
      <td><input align="left"  class="textboxBlanco" name="emailOfna" type="text" id="emailOfna" size="20" maxlength="60" value=" <?php echo trim($usr['emailOfna']);  ?>" ></td>
      <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
      <td><label>Ubicaci&oacute;n de Oficina</label></td>
      <td><textarea name="direccionOfna" cols="33" class="textboxBlanco" id="direccionOfna3" align="left"> <?php echo trim($usr['direccionOfna'])  ?></textarea></td>
      <td><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
      </tr>
      <tr>
        <td colspan="4"><span class="glyphicon glyphicon-asterisk" style="color:red"><label style="color:red;">Datos modificables.</label></span></td>
        <td height="20" colspan=""></td>
        <td>&nbsp;</td><td colspan="">&nbsp;</td>
        <td colspan="2"></td>
        <td></td>
      </tr>
    </table>
    </div>
 </div>
  <div align="center"><input type="submit" align="center" class="btn btn-primary" name="btnActualizar" value="Actualizar"></div>
  <div>&nbsp;</div>
</form>
<?php
	include("intraFooter.php"); 
?> 
