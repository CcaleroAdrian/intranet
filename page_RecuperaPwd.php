<?php   
	include("intraHeader.php");  
	require_once("procesaPwdAleatorio.php");

	$btnOpcion = isset($_POST['btnAccion']) ? trim(  $_POST['btnAccion']  ) : "" ; 
	$envioCorreo = false;
	
	//Si el usuario da clic en el botón cancelar  regresa al index
	if ( $btnOpcion == "Cancelar"){
		header('Location: index.php');
	}
	
	// Si el usuario da clic en el botón recuperar valida y procesa la recuperacion de la contraseña
	if ( $btnOpcion == "Recuperar" ) 
	   		// Generamos una contraseña temporal 
			$pwdTmp = trim( generaPass() ); 
			if ( $pwdTmp != "" ) { 
				$envioCorreo = true;
			} else {
				$error = "Error al generar la contrase&ntilde;a temporal, intentelo de nuevo.";		
			}
	}
?>
	<script type="text/javascript">
		var error = "<?php echo $error; ?>";
	</script>
  		<h3>Recuperar Constrase&ntildea </h3>
		<table width="100%" height="300" border="0" cellspacing="0" cellpadding="0"   >
			<tr>
			<td >  
				<form name="formRecuperar" method="POST" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
				<div class="panel panel-primary">
				<div class="panel-heading">USUARIO A RECUPERAR</div>
				<div class="panel-body">
				<table width="320"  border="0" align="center" cellpadding="0" cellspacing="6" class="tblFrm" >
				  <tr>
					<td><div align="justify">
					  <LABEL align="center">Usuario de la cuenta para recuperar su contrase&ntilde;a:</LABEL> 
					  </div></td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
				  <tr>
					<td><div align="center">
					  <input class="form-control"  name="EMAIL" type="text" id="emailusr" size="50" maxlength="80" required>
				    </div></td>
				  </tr> 
				  <tr>
					<td><div align="center">
					    <input type="submit" class="btn btn-primary"   name="btnAccion" value="Cancelar">
					    <input type="submit" class="btn btn-danger"   name="btnAccion" value="Recuperar">
					</div></td>
				  </tr>
				</table>
				</div>
				</div>
				</form>
			</td>
			</tr> 
    	</table>  						
 <?php
	include("intraFooter.php"); 
?> 
