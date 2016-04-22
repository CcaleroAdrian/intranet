<?php
	include("intraHeader.php");   

	if ( $USUARIO == "" OR  $USUARIO == null ) {  
		header('Location: index.php');
	}
	
	$ID_USR;
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objOperaciones = new ActionsDB();

	$usuarios = $objOperaciones->verUsuariosActividades();

?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<script type="text/javascript">
			var meses = [];
			var user;

			function ver(){
				meses = $('#mes').val();
			}

			function previsualizacion(){
				var fecha = new Date();
				var anio = fecha.getFullYear();
				user = $('#usuario').val();
				meses = $('#mes').val();

				document.getElementById('descarga').style.display='inline';

				if(meses.length != null){
					for (var i =0; i<= meses.length- 1; i++) {
						var indice = meses[i];
						fecha1 = new Date(fecha.getFullYear(), indice-1, 1);
						fecha2 = new Date(fecha.getFullYear(), indice, 0);

						f1= ""+anio+"-"+indice+"-"+fecha1.getDate()+"";
						fe2= ""+anio+"-"+indice+"-"+fecha2.getDate()+"";

						switch(parseInt(indice)){
							case 1:
								document.getElementById('en').style.display = "inline";
								context(user,f1,fe2,enero);
								break;
							case 2:
								document.getElementById('feb').style.display = "inline";
								context(user,f1,fe2,febrero);
								break;
							case 3:
								document.getElementById('mar').style.display = "inline";
								context(user,f1,fe2,marzo);
								break;
							case 4:
								document.getElementById('abr').style.display = "inline";
								context(user,f1,fe2,abril);
								break;
							case 5:
								document.getElementById('may').style.display = "inline";
								context(user,f1,fe2,mayo);
								break;
							case 6:
								document.getElementById('jun').style.display = "inline";
								context(user,f1,fe2,junio);
								break;
							case 7:
								document.getElementById('jul').style.display = "inline";
								context(user,f1,fe2,julio);
								break;
							case 8:
								document.getElementById('agos').style.display = "inline";
								context(user,f1,fe2,agosto);
								break;
							case 9:
								document.getElementById('sep').style.display = "inline";
								context(user,f1,fe2,septiembre);
								break;
							case 10:
								document.getElementById('oct').style.display = "inline";
								context(user,f1,fe2,octubre);
								break;
							case 11:
								document.getElementById('nov').style.display = "inline";
								context(user,f1,fe2,noviembre);
								break;
							case 12:
								document.getElementById('dic').style.display = "inline";
								context(user,f1,fe2,diciembre);
								break;
						}
					}
				}
			}

			function context(id,fechaI,fechaF,div){
				var xmlhttp;
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
						
				}else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						//respuesta =xmlhttp.responseText;
						document.getElementById('enero').innerHTML= xmlhttp.responseText;
						//console.log(xmlhttp.responseText);
					}
				}
					
				xmlhttp.open("POST","acciones.php",true);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send("id="+id+"&opcion="+ 10 +"&fecha1="+fechaI+"&fecha2="+fechaF);
			}
			
			function descarga(){
				window.open('descargaExcel.php','_blank');
			}

		</script>

	</head>
	<style type="text/css">
	a{
		cursor: pointer;
	}
	</style>
	<body>
		<h3>GENERAR ENTREGABLES</h3>
	<div class="panel panel-primary">
    	<div class="panel-heading">OPCIONES DE REPORTE</div>
   		<div class="panel-body">
   			<table>
   				<tr>
   					<td>
   						<label>Empleado:</label>
   					</td>
   					<td><select id="usuario" class="selectpicker" title="Seleccionar empleado">
   						<?php
   							if ($usuarios != 0 OR $usuarios != -1) {
   								foreach ($usuarios as $value) {
   									echo "<option value='".$value['idUsuario']."'>".utf8_encode($value['nombre']." ".$value['paterno']." ".$value['materno'])."</option>";	
   								}	
   							}
   						?>
   					</select></td>
   					<td>&#160;&#160;&#160;&#160;</td>
   					<td><label>Mes:</label></td>
   					<td>
   						<select id="mes"  class="selectpicker" multiple title="Seleccionar mes" onchange="ver()">
		   					<option  value="1">ENERO</option>
		   					<option  value="2">FEBRERO</option>
		   					<option  value="3">MARZO</option>
		   					<option  value="4">ABRIL</option>
		   					<option  value="5">MAYO</option>
		   					<option  value="6">JUNIO</option>
		   					<option  value="7">JULIO</option>
		   					<option  value="8">AGOSTO</option>
		   					<option  value="9">SEPTIEMBRE</option>
		   					<option  value="10">OCTUBRE</option>
		   					<option  value="11">NOVIEMBRE</option>
		   					<option  value="12">DICIEMBRE</option>
   						</select>
   					</td>
   					<td>&#160;&#160;&#160;&#160;</td>
   					<td><input type="button" value="GENERAR" class="btn btn-primary" onclick="previsualizacion()"></input></td>
   				</tr>
   			</table>
   		</div>
   	</div>
   	<div class="panel panel-primary">
    	<div class="panel-heading">PREVISUALIZACIÓN DEL REPORTE</div>
   		<div class="panel-body">
   			<ul id="tabs" class="nav nav-tabs" role="tablist">
   				<li id="en" style="display: none;" role='presentation'>
   					<a aria-controls='enero' role='tab' data-toggle='tab'>ENERO</a>
   				</li>
   				<li id="feb" style="display: none;" role='presentation'>
   					<a aria-controls='febrero' role='tab' data-toggle='tab'>FEBRERO</a>
   				</li>
   				<li id="mar" style="display: none;" role='presentation'>
   					<a aria-controls='marzo' role='tab' data-toggle='tab'>MARZO</a>
   				</li>
   				<li id="abr" style="display: none;" role='presentation'>
   					<a aria-controls='abril' role='tab' data-toggle='tab'>ABRIL</a>
   				</li>
   				<li id="may" style="display: none;" role='presentation'>
   					<a aria-controls='mayo' role='tab' data-toggle='tab'>MAYO</a>
   				</li>
   				<li id="jun" style="display: none;" role='presentation'>
   					<a aria-controls='junio' role='tab' data-toggle='tab'>JUNIO</a>
   				</li>
   				<li id="jul" style="display: none;" role='presentation'>
   					<a aria-controls='julio' role='tab' data-toggle='tab'>JULIO</a>
   				</li>
   				<li id="agos" style="display: none;" role='presentation'>
   					<a aria-controls='agosto' role='tab' data-toggle='tab'>AGOSTO</a>
   				</li>
   				<li id="sep" style="display: none;" role='presentation'>
   					<a aria-controls='septiembre' role='tab' data-toggle='tab'>SEPTIEMBRE</a>
   				</li>
   				<li id="oct" style="display: none;" role='presentation'>
   					<a aria-controls='octubre' role='tab' data-toggle='tab'>OCTUBRE</a>
   				</li>
   				<li id="nov" style="display: none;" role='presentation'>
   					<a aria-controls='noviembre' role='tab' data-toggle='tab'>NOVIEMBRE</a>
   				</li>
   				<li id="dic" style="display: none;" role='presentation'>
   					<a aria-controls='diciembre' role='tab' data-toggle='tab'>DICIEMBRE</a>
   				</li>
   			</ul>
   			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane fade" id="enero"></div>
			    <div role="tabpanel" class="tab-pane fade" id="febrero"></div>
			    <div role="tabpanel" class="tab-pane fade" id="marzo"></div>
			    <div role="tabpanel" class="tab-pane fade" id="abril"></div>
			    <div role="tabpanel" class="tab-pane fade" id="mayo"></div>
			    <div role="tabpanel" class="tab-pane fade" id="junio"></div>
			    <div role="tabpanel" class="tab-pane fade" id="julio"></div>
			    <div role="tabpanel" class="tab-pane fade" id="agosto"></div>
			    <div role="tabpanel" class="tab-pane fade" id="septiembre"></div>
			    <div role="tabpanel" class="tab-pane fade" id="octubre"></div>
			    <div role="tabpanel" class="tab-pane fade" id="noviembre"></div>
			    <div role="tabpanel" class="tab-pane fade" id="diciembre"></div>
  			</div>
  			<button id="descarga" class="btn btn-link" style="margin-left: 80%; display:none;" onclick="descarga()"><span class="fa fa-arrow-down"></span></span> DESCARGAR</button>
   		</div>
   	</div>
	</body>
	</html>


<?php
	include("intraFooter.php"); 
?>