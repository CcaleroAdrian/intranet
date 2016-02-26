<?php
$area =isset($_POST['area'])? $_POST['area'] : "";//Area del usuario
$nomb = isset($_POST['nombreEmpleado'])? $_POST['nombreEmpleado'] : "";//Nombre del usuario
$diasSolicitados = isset($_POST['diasS'])? $_POST['diasS'] : "" ;//Dias solicitados por el usuario
$diasLey = isset($_POST['diasvacaciones']) ? $_POST['diasvacaciones'] : "";//Dias de vacacion correspondientes

//Damos formato a las fechas
$date = strtotime($_POST['fecha1']);
$dates = strtotime($_POST['fecha2']);
$date1 = strtotime($_GET['fecha']); 
$otro = date("d-F-Y", $date);
$FechaFinal =date("d-F-Y", $dates);
$fechaIngreso = date("d-F-Y", $date1);

if ($diasSolicitados > $diasLey) {//Dias adicionales solicitados
	$diasAdicionales = $diasSolicitados - $diasLey;
}else{
	$diasAdicionales = 0;
}

$diasRestantes = $diasLey - $diasSolicitados;//Dias restantes al periodo vacacional acumulado
if ($diasRestantes < 1) {
	$diasRestantes = 0;
}

?> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script type="text/javascript">
	function documents(){
		window.location="submenu_SolicitudesVacaciones_Recibidas.php";
	}
</script>

<div style="width: 50%; height: 150px;">
<table>
	<td>
		<img  width="100%" src="intraImg/Header.png">
	</td>
</table>
<div class="col-md-12">
	<p>El usuario: <strong><?php echo $nomb; ?></strong> <br><br>
	Desea solicitar los <strong><?php echo $diasSolicitados; ?></strong> días de vacaciones correspondientes al año en curso, haciendo constar por escrito, su deseo de hacer validos los días de vacaciones que le corresponden.<br><br>
	No habiendo ningún inconveniente de su parte, hace de su conocimiento para disfrutar un plazo vacacional del día <strong><?php echo $otro;?></strong> al <strong><?php echo $FechaFinal;?></strong> del presente año.
	</p>
</div><br>

<br>
<hr>
<div class="col-md-8">
</div>
<br><br/>
<div align="center"><form>
	<table class="table">
		<tr>
			<td>
				<label style="font-size:11px;">Área:</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="<?php echo $area ;?>" disabled/>
			</td>
			<td>
				<label style="font-size:11px;">Fecha de ingreso:</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="<?php echo $fechaIngreso;?>" disabled/>
			</td>
		</tr>
		<tr></tr>
		<tr>
			<td>
				<label style="font-size:11px;">Del:</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="<?php echo $otro;?>" disabled>
			</td>
			<td>
				<label style="font-size:11px;">Al:</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" size="15" type="text" value="<?php echo $FechaFinal;?>" disabled>
			</td>
		</tr>
		<tr>
			<td>
				<label style="font-size:11px;">Días a disfrutar:</label>
			</td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="<?php echo $diasLey;?>" disabled></td>
			<td>
				<label style="font-size:11px;">Días Solicitados</label>
			</td>
			<td><input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="<?php echo $diasSolicitados;?>" disabled></td>
		</tr>
		<tr>
			<td>
				<label style="font-size:11px;">Días pendientes:</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" type="text" size="5" value="<?php echo $diasRestantes;?>" disabled>
			</td>
			<td>
				<label style="font-size:11px;" >Días adicionales</label>
			</td>
			<td>
				<input style="background: #ffffff; border: 1px solid #ffffff;" size="5" type="text" value="<?php echo $diasAdicionales; ?>" disabled>
			</td>
		</tr>
	</table>
	<div align="center">
	<input type="submit" class="btn btn-primary" name="btnAprobar" value="Aprobar" onclick="documents()">
</form></div> 
</div><br>

<hr>
<div align="justifi">
	<p style="font-size:11px">
		“Este mensaje y cualquier archivo que se adjunte al mismo es propiedad de <strong>ITWorkers</strong> y podría contener información privada y privilegiada 
		para uso exclusivo del destinatario. Si usted ha recibido esta comunicación por error, 
		no está autorizado para copiar, retransmitir, utilizar o divulgar este mensaje ni los 
		archivos adjuntos. Gracias.”
	</p>
</div>
<br><br>
<table>
<td>
	<img  width="100%" src="intraImg/Footer.png">
</td>
	<!--<td  style="padding-left:30%">
		<label>Dirección:</label><br>
		<p style="font-size:10px;"><strong>
		Corporativo Punta Insurgentes<br>
		Av. Insurgentes Sur 1524, Oficina L06, Col. Crédito Constructor, <br>
		Del. Benito Juárez, C.P. 03940, México, D.F.<br></strong></p>
	</td>
	<td>
		<label>Teléfonos:</label><br>
		<p style="font-size:10px;"><strong>
		(55) 56611262<br>
		(55) 56611026<br>
		<a href="contacto@itworkers.com.mx" style="font-size:10px">contacto@itworkers.com.mx</a></strong></p>
	</td>-->
</table> 
</div>
</body>
</html>