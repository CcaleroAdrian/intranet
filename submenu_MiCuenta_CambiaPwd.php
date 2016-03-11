<?php   
	include("intraHeader.php");  
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}
	
	$mensaje ="";
	$valok = true;
	$exito = false;
	$btnCambiar =isset($_POST['btnCambiar']) ? trim($_POST['btnCambiar'] ) : "" ;
	$pwd1 =isset($_POST['clave1']) ? trim($_POST['clave1']) : "" ;
	$pwd2 =isset($_POST['clave2']) ? trim($_POST['clave2']) : "" ;
	$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	//echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . "";
	If ( $btnCambiar == "Cambiar" ) {

		If ( $pwd1 <> ""  AND  $pwd2 <> "" ) {
			
			//Validar que las contraseña sean de 8 caracteres
			If ( (strlen($pwd1) <> 8 )  OR (strlen($pwd2) <> 8 ) ) {
				$valok = false;
				$mensaje = "La nueva contraseña debe ser de 8 caracteres.";
			}
			
			// Validar que sean iguales 
			
			If ( $valok  AND ( $pwd1 <> $pwd2 ) ) {
				$valok = false;
				$mensaje = "Las contraseñas deben ser iguales.";
			} 
			
		} else {
			$valok = false;
			$mensaje = "Debe capturar ambos campos.";
		}
		
		//Valida que se hayan validado correctamente las contrañas
		if ( $valok ) { 
			// Realizar el update a la base de datos.
			//Instanciamos la clase que tiene las operaciones a la base de datos
			$objOperaciones = new ActionsDB();
			// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
			$respuesta = $objOperaciones->setPwdUsuario( $USUARIO ,  $pwd1 );
			
			If ( $respuesta ) {
				$mensaje = "El cambio de contrase&ntilde;a fu&eacute; exitoso. <br> Cerraremos tu sesi&oacute;n para que accesar nuevamente.";
				$exito = true;
			}else {
				$mensaje = "No fue posible ";
			}
		}
		
	} 

		
 ?> 
  <script type="text/javascript">
 	$(window).load(function(){
 		var error = "<?php echo $mensaje; ?>";
 		if (error != "") {
 			swal({
	        title: "Alerta",
	        text: error,
	        type: "error",
	        timer: 3000,
	        showConfirmButton:false
	        });
 		}
 	});

 	function myfuction(){
 		window.open("popup.php", "_blank", 'width=333px,height=273px,resizable=yes,toolbar=no'); return false;
 	}

 </script>
		<form name="form1" method="post"   action="
		<?php 
			if ( $exito) { 
				echo "cerrarSesion.php";
			} else {
				echo $_SERVER['PHP_SELF'] . "?idMenu=". $idMenu ."&idSubMenu=". $idSubMenu . ""; 
			}
		?>
		" >
		<br>
		<div class="panel panel-primary">
    	<div class="panel-heading">Cambiar Contrase&ntilde;a &nbsp;</div>
    	<div class="panel-body">
		<table width="500" height="100" border="0" align="center" cellpadding="0" cellspacing="3"  class="tblfrm" > 
			<tr>
			  <td height="40" colspan="3" ></td>
		  	</tr>
			<?php
			If ( ! $exito ) {
			?>
				<tr>
				<td ><div align="right"> <label>Nueva Contrase&ntilde;a:</label></div></td>
				<td width="100" ><div class="input-group">
					<input  class="form-control glyphicon glyphicon-question-sign" name="clave1" type="password" size="20" maxlength="8" autofocus>
				<span id="span" class="input-group-addon glyphicon glyphicon-question-sign" onclick="myfuction()"></span></div></td>
				</tr>
				<tr><td width="130">&nbsp;</td></tr>
				<tr>
				<td ><div align="right"><label>Confirmar Contrase&ntilde;a:</label></div></td>
				<td width="140" >
					<input id="imputpwd" class="form-control"  name="clave2" type="password" size="20" maxlength="8">
				</td>
				</tr>
				<tr  style="padding-botton:100%;"><td colspan="3" align="center" > 
                     <div align="center">&nbsp;</div></td>
	      		</tr>
	      		<tr  style="padding-botton:100%;"><td colspan="3" align="center" > 
                     <div align="center">&nbsp;</div></td>
	      		</tr>
	      		<tr style="padding-top:5%;"><td width="130">&nbsp;</td></tr>
				  <td colspan="2"><div align="center">
					<input type="submit"  class="btn btn-primary" name="btnCambiar"   value="Cambiar"> 
					</div>
					</td>
				</tr>
				<tr>
				<td colspan="3" >&nbsp;				</td>
				</tr>
			<?php
			}
			?>
			
			<?php 
			if ( $exito ) {
			?> 
				<tr>
				  <td colspan="3" ><label>Su contrase&ntilde;a fu&eacute; actualizada satisfactoriamente, haga clic en continuar para terminar la sesi&oacute;n actual y reingresar a nuestro sistema nuevamente. </label></td>
		  		</tr>
				<tr>
				<td colspan="3" ><div align="center"><input type="submit" class="btn btn-primary" name="btnContinuar" value="Continuar">
				</div></td>
				</tr>
			<?php 
			}
			?>
			<tr>
			  <td height="60" colspan="3" ><div align="center"></div></td>
	  	  </tr>
    	</table> 
		</form> 
<?php
		
	include("intraFooter.php"); 
?> 
