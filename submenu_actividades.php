<?php
	include("intraHeader.php");   

	if ( $USUARIO == "" OR  $USUARIO == null ) {  
		header('Location: index.php');
	}
	
	$ID_USR;
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objOperaciones = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$usr = $objOperaciones->getDatosPerfil( $USUARIO );
    $a = $objOperaciones->verAreas($usr['area_ID']);
	if ($a) {
		foreach ($a as $value) {
			$area = utf8_encode($value['Descripcion']);
		}
	}

	//OBTENER INFO LIDER DE PROYECTO
	$lider = $objOperaciones->verLider($usr['Proyecto_id']);
	$LiderID = 0;
	if ($lider != 0 AND $lider != -1) {
		foreach ($lider as $key) {
			$LiderID = $key['usuario_ID'];
		}
	}
	
	date_default_timezone_set('AMERICA/Mexico_City');
	setlocale (LC_TIME, 'spanish-mexican');
	$anio = date('Y');
	$mes = date('m');
	$dia = date('d', mktime(0,0,0,$mes+1,$anio));

	$fecha1=date("Y-m-d",mktime(0,0,0,$mes,1,$anio));
	$fecha2=date('Y-m-d',(mktime(0,0,0,$mes+1,1,$anio)-1));
	$m=date('F',mktime(0,0,0,$mes,1,$anio));



 ?> 
 <!DOCTYPE>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		var respuesta = "";
		var id = "<?php echo $ID_USR;?>";
		var fecha1 = "<?php echo $fecha1;?>";
		var fecha2 = "<?php echo $fecha2;?>";
		var Mes = "<?php echo date('n'); ?>";
		var gerente = "<?php echo $LiderID; ?>";
		var solicitudID;
		
		function add(){
			var datos = Array();
			//Extraer elementos de la tabla
			for (var i = 2; i <=7; i++) {
				d = $('#actividades tr').eq(1).find('td').eq(i).text();
				datos.push(d);
			}

			//asignar valores de la tabla a variables
			datos.push($('#fecha').val());
			for (var i = 0; i <= datos.length - 1; i++) {
				actividad= datos[0];
				L=datos[1];
				Ma=datos[2];
				M=datos[3];
				J=datos[4];
				V=datos[5];
				fecha=datos[6];
			}
	 
			if(fecha == ""){
				swal({title: "Confirmacion",text:'Favor de ingresar la fecha',type: "warning",timer:2500,showConfirmButton:false});
			}else if (actividad == "") {
				swal({title: "Confirmacion",text:'Favor de llenar el campo "ACTIVIDAD"',type: "warning",timer:2500,showConfirmButton:false});
			}else if (L == "" && Ma == "" &&  M == "" && J == "" && V == ""){
				swal({title: "Confirmacion",text:'Favor de capturar el número de horas',type: "warning",timer:2500,showConfirmButton:false});
			}else{
				manejoDatos(id,actividad,gerente,L,Ma,M,J,V,fecha,Mes);
				limpiarTable();
				consultarActividades(id,fecha1,fecha2);
			}
		}

		function manejoDatos(id,actividad,gerente,L,Ma,M,J,V,fecha,Mes){
			var xmlhttp;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
					
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById('cuerpo').innerHTML=xmlhttp.responseText;
				}
			}
				
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id+"&opcion="+ 5+"&fecha="+fecha+"&actividad="+actividad+"&gerente="+gerente+"&lunes="+L+"&martes="+Ma+"&miercoles="+M+"&jueves="+J+"&viernes="+V+"&mes="+Mes+"&fecha1="+fecha1+"&fecha2="+fecha2);

			/*if (respuesta == "true") {
				swal({title: "Confirmacion",text:'Nueva acitividad añadida.',type: "success",timer:2000,showConfirmButton:false});
			}else{
				swal({title: "Confirmacion",text:"Favor de intentarlo más tarde",type: "error",timer:2000,showConfirmButton:false});
			
			}*/
		}

		function limpiarTable(){
			
			for (var i = 2; i <=7; i++) {
				$('#actividades tr').eq(1).find('td').eq(i).text("");
			}
			$('#fecha').val("");
		}

		function consultarActividades(id,fecha1,fecha2){
			var xmlhttp;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
					
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					//respuesta =xmlhttp.responseText;
					document.getElementById('cuerpo').innerHTML=xmlhttp.responseText;
				}
			}
				
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id+"&opcion="+ 6+"&fecha1="+fecha1+"&fecha2="+fecha2);
		}

		$(document).ready(function(){
			consultarActividades(id,fecha1,fecha2);
		});

		function modificar(id){
			var xmlhttp;
			var datos = Array();
			document.getElementById('update').style.visibility = "initial";

			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
					
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					//respuesta =xmlhttp.responseText;
					var datos= $.parseJSON(xmlhttp.responseText);
					$('#fecha').val(datos[0].fechaActividad);
					$('#actividad').html(datos[0].actividad)
					$('#lunes').html(datos[0].L);
					$('#martes').html(datos[0].Ma);
					$('#miercoles').html(datos[0].M);
					$('#jueves').html(datos[0].J);
					$('#viernes').html(datos[0].V);
					solicitudID = datos[0].actividad_ID;
				}
			}
				
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id+"&opcion="+ 7);
		}

		function update(){
			swal({   title: "ACTUALIZACIÓN DE ACTIVIDAD",
					   text: "¿Desea guardar cambios?",
					   type: "info",
					   showCancelButton: true,
					   confirmButtonColor: " #337ab7",
					   cancelButtonColor: "#ff3333",
					   confirmButtonText: "Si",
					   cancelButtonText: "No",
					   closeOnConfirm: false,
					   closeOnCancel: false
					}, 
					function(isConfirm){ 
					  if (isConfirm) {
					  	var xmlhttp;
					  	var datos =[];
						//Extraer elementos de la tabla
						for (var i = 2; i <=7; i++) {
							d = $('#actividades tr').eq(1).find('td').eq(i).text();
							datos.push(d);
						}

						//asignar valores de la tabla a variables
						datos.push($('#fecha').val());
						for (var i = 0; i <= datos.length - 1; i++) {
							actividad= datos[0];
							L=datos[1];
							Ma=datos[2];
							M=datos[3];
							J=datos[4];
							V=datos[5];
							fecha=datos[6];
						}

						if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						}else{// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
			
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								document.getElementById('cuerpo').innerHTML=xmlhttp.responseText;
								//console.log(xmlhttp.responseText);
							}
						}
						xmlhttp.open("POST","acciones.php",true);
						xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xmlhttp.send("id="+id+"&opcion="+ 8+"&fecha="+fecha+"&actividad="+actividad+"&lunes="+L+"&martes="+Ma+"&miercoles="+M+"&jueves="+J+"&viernes="+V+"&fecha1="+fecha1+"&fecha2="+fecha2+ "&solicitudID="+solicitudID);

						swal({title:"ACTIVIDAD GUARDADA",
					  		  text:"Cambios guardados correctamente.",
					  		  type:"info",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:false,
					  		  timer:2000
					  		});

						limpiarTable();
					  	document.getElementById('update').style.visibility = "hidden";

					  } else{
					  	swal({title:"SOLICITUD CANCELADA",
					  	type: "info",
					  	confirmButtonColor: " #337ab7",
					    confirmButtonText: "OK",
					    closeOnConfirm: false,
					  	});
					  	//Reseteo de los campos
					  	limpiarTable();
					  	document.getElementById('update').style.visibility = "hidden";
					  }
			});
		}

		function borrar(id){
			swal({   title: "BORRAR ACTIVIDAD",
					   text: "¿Desea borrar la actividad seleccionada?",
					   type: "info",
					   showCancelButton: true,
					   confirmButtonColor: " #337ab7",
					   cancelButtonColor: "#ff3333",
					   confirmButtonText: "Si",
					   cancelButtonText: "No",
					   closeOnConfirm: false,
					   closeOnCancel: false
					}, 
					function(isConfirm){ 
						if (isConfirm) {
						  	var xmlhttp;
						  	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp=new XMLHttpRequest();
							}else{// code for IE6, IE5
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							}
				
							xmlhttp.onreadystatechange=function(){
								if (xmlhttp.readyState==4 && xmlhttp.status==200){
									document.getElementById('cuerpo').innerHTML=xmlhttp.responseText;
									//console.log(xmlhttp.responseText);
								}
							}
							xmlhttp.open("POST","acciones.php",true);
							xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
							xmlhttp.send("solicitudID="+id+"&opcion="+ 9);

							swal({title:"ACTIVIDAD BORRADA",
						  		  text:"Cambios guardados correctamente.",
						  		  type:"info",
						  		  confirmButtonColor: " #337ab7",
						  		  showConfirmButton:false,
						  		  timer:2000
						  		});

						}else{
					  	swal({title:"SOLICITUD CANCELADA",
					  	type: "info",
					  	confirmButtonColor: " #337ab7",
					    confirmButtonText: "OK",
					    closeOnConfirm: false,
					  	});
					  }
			});
		}

		function validar(){
			L = $('#actividades tr').eq(1).find('td').eq(3).text();
			Ma = $('#actividades tr').eq(1).find('td').eq(4).text();
			M = $('#actividades tr').eq(1).find('td').eq(5).text();
			J = $('#actividades tr').eq(1).find('td').eq(6).text();
			V = $('#actividades tr').eq(1).find('td').eq(7).text();

			//console.log(typeof L === 'number'); 
			var ex = /[0-9]/g;
			var result;
			if (L != '') {
				result = L.match(ex);
				if (result == null) {
				swal({title:"VALIDACION DE CAMPO",
					  		  text:"Ingresa un dato de tipo numérico.",
					  		  type:"warning",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:true
					  		});
				}
			}

			if (Ma != '') {
				result = Ma.match(ex);
				if (result == null) {
				swal({title:"VALIDACION DE CAMPO",
					  		  text:"Ingresa un dato de tipo numérico.",
					  		  type:"warning",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:true
					  		});
				}
			}

			if (M != '') {
				result = M.match(ex);
				if (result == null) {
				swal({title:"VALIDACION DE CAMPO",
					  		  text:"Ingresa un dato de tipo numérico.",
					  		  type:"warning",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:true
					  		});
				}
			}

			if (J != '') {
				result = J.match(ex);
				if (result == null) {
					swal({title:"VALIDACION DE CAMPO",
					  		  text:"Ingresa un dato de tipo numérico.",
					  		  type:"warning",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:true
					  		});
				}
			}

			if (V != '') {
				result = V.match(ex);
				if (result == null) {
					swal({title:"VALIDACION DE CAMPO",
					  		  text:"Ingresa un dato de tipo numérico.",
					  		  type:"warning",
					  		  confirmButtonColor: " #337ab7",
					  		  showConfirmButton:true
					  		});
				}
			}
		}
		
	</script>
<style type="text/css">
	.hide{
		display: none;
	}
	.table-remove {
	  color: #700;
	  cursor: pointer;
	}
	.table-remove:hover {
	  color: #f00;
	}

	#horas{
		font-weight: bold;
		font-family: arial;
		font-size: 14px;
		color: black;
		padding-left:87%;
	}

	#btn{
		margin-left: 50%;
	}

	#title{
		text-align: center;
	}

	.otro{
	  color: green;
	  cursor: pointer;
	}

	.edit{
		cursor: pointer;
	}
</style>
<body>
	<h3>CAPTURA DE ACTIVIDADES</h3>
	<div class="panel panel-primary">
    	<div class="panel-heading">ACTIVIDADES SEMANALES</div>
   		<div class="panel-body">
   			<table>
   				<tr>
	   				<td><label>Usuario: </label></td>
	   				<td><label><?php echo utf8_encode($usr['nombre'].' '.$usr['paterno'].' '.$usr['materno']);?></label></td>
   				</tr>
   				<tr>
   					<td><label>Área: </label></td>
	   				<td><label><?php echo $area;?></label></td>
   				</tr>
   			</table>
   			<br>
   			<table class="table table-striped" id="actividades">
   				<thead class="title">
   					<th width="1" ></th>
   					<th >FECHA:</th>
   					<th colspan="2" >ACTIVIDAD</th>
   					<th width="1">L</th>
   					<th width="1">M</th>
   					<th width="1">M</th>
   					<th width="1">J</th>
   					<th width="1">V</th>
   				</thead>
   				<tbody "formulario"><tr>
   					<td class="active" width="45px"><a id="add" class="edit fa fa-plus" onclick="add()"></a><a class="otro fa fa-floppy-o" id="update" onclick="update()" style="margin-left: 5px; visibility: hidden;"></a></td>
   					<td contenteditable="false" width="125" class="info"><input type="date" style="width: 130px; border:none; background-color: transparent;" id="fecha"></input></td>
   						<td contenteditable="true" colspan="2" class="active" id="actividad"></td>
   						<td contenteditable="true" style="width: 1px;" class="info" id="lunes" onfocusout="validar()"></td>
   						<td contenteditable="true" style="width: 1px;" class="active" id="martes" onfocusout="validar()"></td>
   						<td contenteditable="true" style="width: 1px;" class="info" id="miercoles" onfocusout="validar()"></td>
   						<td contenteditable="true" style="width: 1px;" class="active" id="jueves" onfocusout="validar()"></td>
   						<td contenteditable="true" style="width: 1px;" class="info" id="viernes" onfocusout="validar()"></td>
   						</tr>
   				</tbody>
   			</table>
   		</div>
   	</div>
   	<div class="panel panel-primary">
    	<div class="panel-heading">ACTIVIDADES DE: <?php echo strtoupper($m);?></div>
   		<div class="panel-body">
   				<table id="datos" class="table table-bordered" >
   				<thead>
   						<th width="2"><label>ACCIÓN</label></th>
   						<th width="125"><label>FECHA:</label></th>
   						<th><label>ACTIVIDAD:</label></th>
   						<th width="1"><label>L</label></th>
   						<th width="1"><label>M</label></th>
   						<th width="1"><label>M</label></th>
   						<th width="1"><label>J</label></th>
   						<th width="1"><label>V</label></th>
   				</thead>
   				<tbody id="cuerpo" style="text-align: center;">
   				</tbody>
   			</table>
   			<!--<input id="btn" type="button" value="GUARDAR" class="hide btn btn-primary" ></input>-->
   		</div>
   	</div>
</body>
</html>

<?php
	include("intraFooter.php"); 
?>