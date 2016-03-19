<?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

/*$objOperaciones = new ActionsDB();
// Obtenemos los campos de la tabla usuarios para presentarla en la solicitud
	$usr = $objOperaciones->getDatosPerfil( $USUARIO );
	If ( $usr == -1  OR  $usr == 0 ) {
		$blnOk = false;
		$error = "No fu&eacute; posible recuperar la informaci&oacute;n del usuario: ";*/

?>
<!DOCTYPE html>
<html>
<body>
	<br/>
	<h3>CARGA DE ARCHIVOS</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">CARGAR INFORMACIÓN DE USUARIOS <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
    	<table align="center">
    		<tr >
    			<td>
    				<label class="control-label">Archivo:</label>
    			</td>
    			<td>
    				<input id="cvs" type="file" class="form-control" size="15"></input>
    			</td>
    			<td>&#160;</td>
    			<td>
    				<button class="btn btn-primary" onclick="">CARGAR DATOS</button>
    			</td>
    		</tr>
    	</table>
    </div>
    </div><br/>
    <div class="panel panel-primary">
    <div class="panel-heading">CARGAR INFORMACIÓN DE PROYECTOS <a href="" onclick=""><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
    	<table align="center">
    		<tr >
    			<td>
    				<label>Archivo:</label>
    			</td>
    			<td>
    				<input id="cvs1" type="file" class="form-control" size="5" onclick="" value=""></input>
    			</td>
    			<td>&#160;</td>
    			<td>
    				<button class="btn btn-primary" onclick="">CARGAR DATOS</button>
    			</td>
    		</tr>
    	</table>
    </div>
</body>
</html>
<?php
	include("intraFooter.php"); 
?> 