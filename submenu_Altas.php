<?php   
	include("intraHeader.php");   
		
	if ( $usuario == "" OR  $usuario == null ) { 
		exit();
	}
	
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objOperaciones = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$usr = $objOperaciones->getDatosPerfil( $usuario );
		
 ?> 
		<form name="frmPerfil" method="post" action="actualizaPerfil.php" enctype="multipart/form-data" >
		<br>
		<div class="panel panel-primary">
    	<div class="panel-heading">ALTAS DE USUARIO</div>
   		<div class="panel-body">
		<table width="500"  border="0" align="center" cellpadding="0" cellspacing="2">
		  <tr>
			<td><div align="right"><label>Usuario Intranet :</label> </div></td>
			<td>
			  <input  align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#999999 " name="usrIntranet" type="text" id="usrIntranet" size="30" maxlength="50"  value=" <?php trim($usr['usrIntranet'])?>" > </td>
			</td>
		  </tr>
		  <tr>
			<td width="50%"><div align="right">Nombre:</div></td>
			<td width="50%"><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#999999 " name="nombre" type="text" id="nombre" size="30" maxlength="30"  value=" <?php trim($usr['nombre'])?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Apellido Paterno: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#999999 " name="paterno" type="text" id="paterno" size="30" maxlength="30" value=" <?php trim($usr['paterno'])?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Apellido Materno : </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#999999 " name="materno" type="text" id="materno" size="30" maxlength="30" value=" <?php trim($usr['materno'])?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Sexo:</div></td>
			<td><select name="idSexo" id="idSexo" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 "  > 
			  <option value="1" <?php  ($usr['idSexo'] == "1") ?  "selected" : "";  ?> >H</option>
			  <option value="2" <?php ($usr['idSexo'] == "2") ?  "selected" : "" ; ?> >M</option>
			</select></td>
		  </tr>
		  <tr>
			<td><div align="right">Estado Civil : </div></td>
			<td><select id="idSexo" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="idCivil" id="idCivil" tabindex="<?php $usr['idCivil']  ?>" > 
				  <option value="1" <?php ($usr['idCivil'] == "1") ?  "selected" : "";  ?> >Soltero</option>
				  <option value="2" <?php ($usr['idCivil'] == "2") ?  "selected" : "";  ?> >Casado</option>
				  <option value="3" <?php ($usr['idCivil'] == "3") ?  "selected" : "";  ?> >Divorciado</option>
				  <option value="4" <?php ($usr['idCivil'] == "4") ?  "selected" : "";  ?> >Union Libre</option>
				</select></td>
		  </tr>
		  <tr>
			<td><div align="right">Direcci&oacute;n:</div></td>
			<td> <input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="direccion" type="text" id="direccion" size="30" maxlength="200" value=" <?php trim($usr['direccion']) ?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Fecha Ingreso: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="fechaIngreso" type="text" id="fechaIngreso" size="30" maxlength="10" value=" <?php trim($usr['fechaIngreso']) ?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Tel&eacute;fono Personal: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="telPersonal" type="text" id="telPersonal" size="30" maxlength="14" value=" <?php trim($usr['telPersonal'])  ?>" ></td>
		  </tr>
		  <tr>
			<td><div align="right">Celular Personal: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="celPersonal" type="text" id="celPersonal" size="30" maxlength="14" value=" <?php $usr['celPersonal']  ?>" ></td>
		  </tr>
		  <tr>
			<td><div align="right">Email Personal : </div></td>
			<td><div align="left">
			  <input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="emailPersonal" type="text" id="emailPersonal" size="30" maxlength="80" value=" <?php trim($usr['emailPersonal'])  ?>" >
			  </div></td>
		  </tr>
		  <tr>
			<td><div align="right">Direcci&oacute;n de Oficina: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="direccionOfna" type="text" id="direccionOfna" size="30" maxlength="200" value=" <?php trim($usr['direccionOfna'])  ?>" > </td>
		  </tr>
		  <tr>
			<td><div align="right">Tel&eacute;fono de Oficina : </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="telOfna" type="text" id="txtTelPer3" size="30" maxlength="14" value=" <?php trim($usr['telOfna'])  ?>" ></td>
		  </tr>
		  <tr>
			<td><div align="right">Celular Asuntos de Trabajo: </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="celOfna" type="text" id="celOfna" size="30" maxlength="14" value=" <?php trim($usr['celOfna'])  ?>" ></td>
		  </tr>
		  <tr>
			<td><div align="right">Email de Oficina </div></td>
			<td><input align="left" style="background-color:#eeeeee; border: 1px solid #999999; font-size:8pt; color:#000033 " name="emailOfna" type="text" id="emailOfna" size="30" maxlength="80" value=" <?php trim($usr['emailOfna'])  ?>" ></td>
			  </div></td>
		  </tr>
		  <tr>
		    <td colspan="2"><div align="center">
		      <input name="btnAlta" type="submit" id="btnAlta" value="Alta Usuario" >
		    </div></td>
	      </tr>
		</table>
		</div></div>
		</form>
<?php
		
	include("intraFooter.php"); 
?> 