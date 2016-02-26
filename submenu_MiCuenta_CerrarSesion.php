<?php
include("intraHeader.php"); 

$objses = new Sesion();
$objses->init();
$objses->destroy();

?>
	<form name="frmContinua" method="post" action="index.php"  >
	<table width="90%"  border="0" cellspacing="2" cellpadding="0" class="tblFrm">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="300">
			  <div align="center">
			    <label>Ha finalizado la sesi&oacute;n en la Intranet de ITW.</label>
			    <p>
			      <input name="btnContinuar" type="submit" id="btnContinuar" value="Continuar" class="btn btn-primary" >
			    </p>
			  </div></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
	</table>	
	</form>  
	
	<?php   
	include("intraFooter.php"); 
	
	?>