<?php
include("intraHeader.php");
require_once("clases/class.phpmailer.php");
//require("class.phpmailer.php");

if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

date_default_timezone_set('AMERICA/Mexico_City');
setlocale (LC_TIME, 'spanish-mexican');
$objOperaciones = new ActionsDB();
//Variables
$ID_USR;
$AREAN;
$LIDER;
$NOMBRE;
$VisualizarR = false;
$TAMANO_PAGINA = 10;	
$fecha1 = date('Y-m-d', strtotime('+1 day')) ;
//$resultado =$objectAlta->insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,$diasRestantes,$LiderID,$directorID);
?>
<script type="text/javascript">
	var url = 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/empleados/';
	var id = "<?php echo $ID_USR; ?>";
	var lider = "<?php echo $LIDER; ?>";
	var vacaciones;
	$(document).ready(function(){

		consultarVacaciones();
		//Consultamos resultados con ajax
		paginacion(0);

		$('#btnSubmit').on('click',function(event){
			event.preventDefault();
			if ($('#fecha1').val() != "" && $('#fecha2').val() != "") {
				swal({   title: "SOLICITUD DE VACACIONES",
					   text: "<span style='color:#000099'>¿Desea solicitar un periodo vacacional?</span>",
					   html: true,
					   imageUrl: "intraImg/logoITWfinal.png",
					   showCancelButton: true,
					   confirmButtonColor: " #337ab7",
					   cancelButtonColor: "#ff3333",
					   confirmButtonText: "Si, Deseo solicitar",
					   cancelButtonText: "No, Deseo solicitar",
					   closeOnConfirm: false,
					   closeOnCancel: false
					}, 
					function(isConfirm){ 
					  if (isConfirm) {
					  	  
					  	swal({title:"PROCESANDO SOLICITUD",
					  		  text:"<span style='color:#000099'>Tú solicitud esta siendo enviada.</span>",
					  		  imageUrl: "intraImg/logoITWfinal.png",
					  		  confirmButtonColor: " #337ab7",
					  		  html: true,
					  		  showConfirmButton:false,
					  		  timer:2000
					  		}); 
					  	var data = {ID_USR:id,FECHAI:$('#fecha').val() ,FECHAF:$('#fecha2').val(),DIASC:$('#Vacaciones').val(),
							DIASSOC:$('#diasSolicitados').val(),DIASAD:$('#diasAdicionales').val(),DIASRES:$('#diasRestantes').val(),LIDER:lider}
						$.post('procesarVacaciones.php',data).done(function(data){
							var vacaciones = parseInt(data);
							console.log(data);
							if (vacaciones != 0 || vacaciones != "") {
									$.ajax({
										    method: "POST",
										    url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/vacaciones/",
										    dataType: "json",
										    timeout: 6000,
										    headers:{VACACIONES:vacaciones,ID:id} })
											.done(function(data, textStatus, jqXHR){
												console.log("datad"+ata);
												console.log("textStatus"+textStatus);
												console.log("jqXHR"+jqXHR);
										    });
									swal({title: "CONFIRMACIÓN",text: "<span style='color:#000099'>solicitud de vacaciones, registrada exitosamente.</span>",imageUrl: "intraImg/logoITWfinal.png",html: true,timer:4000,showConfirmButton:false});									
							}else{
								swal({title: "ERROR",text: "<span style='color:#F8BB86'>Hubo un error al registrar su solicitud. Favor de intentarlo más tarde.</span>",imageUrl: "intraImg/logoITWfinal.png",html: true,timer:4000,showConfirmButton:false});
							}

							consultarInfo();//consulta de vacaciones
						});
						document.getElementById('formulario').reset();

					  } else{
					  	swal({title:"SOLICITUD CANCELADA",
					  	text: "<span style='color:#F8BB86'>Tú solicitud ha sido cancelada.</span>",
					  	imageUrl: "intraImg/logoITWfinal.png",
					  	html: true,
					  	confirmButtonColor: " #337ab7",
					    confirmButtonText: "OK"
					  	});
					  	//Reseteo de los campos
					  	document.getElementById('formulario').reset();
					  	consultarVacaciones();
					  }
					});
			}else{
				swal({title:"Aviso",
					  		  text:"<span style='color:#F8BB86''>Los campos fecha Inicio y Fecha fin<br>No pueden ir vacios.</span>",
					  		  imageUrl: "intraImg/logoITWfinal.png",
					  		  confirmButtonColor: " #337ab7",
					  		  html: true,
					  		  showConfirmButton:false,
					  		  timer:2000
					  		}); 
			}
		});

	});

	function paginacion(pagina){
		var op = 2;
		var id = "<?php echo $ID_USR;?>";

			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				
			}else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("cuerpo").innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("pagina="+pagina+"&opcion="+op+"&id="+id);
	}

	//Funcion para hacer visible la caja de texto de carga de archivo;
	function cargarDocumento(fila){
			datos = fila.getAttribute("data-input");
			id = fila.getAttribute("data-id");
			if (datos == "cargar documento") {
				document.getElementById('cargaArchivo').style.display = "block";
				$('#idRegistro').val(id);
			}
	}

	//Consultar dias de vacaciones
	function consultarVacaciones(){
		$.ajax({
		        method: "GET",
		        url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/vacaciones/",
		        dataType: "json",
		        timeout: 6000,
		        headers:{ID : id},
			    beforeSend:function(){
			        var div = document.getElementById('mensaje');
			        var spinner = new Spinner(opts).spin(div);
			    },
			    success: function(data) {
			    	var vacaciones = parseInt(data['vacaciones']);
			    	if (vacaciones < 0) {
			    		$('#Vacaciones').val(0);
			    		$('#btnSubmit').attr('disabled','disabled');
			    	}else{
			    		$('#Vacaciones').val(vacaciones);
			    	}
				    
			        $( ".spinner" ).remove();
			    }
		    });
	}

	//Consultar dias de vacaciones
	function consultarInfo(){
		$.ajax({
		        method: "GET",
		        url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/vacaciones/",
		        dataType: "json",
		        timeout: 6000,
		        headers:{ID : id},
			    success: function(data) {
			    	var vacaciones = parseInt(data['vacaciones']);
			    	if (vacaciones < 0) {
			    		$('#Vacaciones').val(0);
			    		$('#btnSubmit').attr('disabled','disabled');
			    	}else{
			    		$('#Vacaciones').val(vacaciones);
			    	}
				    
			        $( ".spinner" ).remove();
			    }
		});
		var op = 2;
		var pagina=0;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				
			}else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("cuerpo").innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open("POST","acciones.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("pagina="+pagina+"&opcion="+op+"&id="+id);
	}
</script>
<style type="text/css">
	a{
		text-decoration: none;
	}
</style>
<!--<script type="text/javascript" src="js/solicitud.js"></script>-->
<script type="text/javascript" src="js/busqueda.js"></script>
	<h3 align="left">SOLICITUD DE VACACIONES</h3>
	<form  id="formulario" name="frmSolicitud" enctype="multipart/form-data">
	<div class="panel panel-primary">
    <div class="panel-heading">CAPTURA<a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    <div class="panel-body">
		<table id="form1" class="table-responsive">
			<tr >
				<td ><label>Nombre del empleado:</label></td>
				<td colspan="3"><input id="nombreUser" size="30" value="<?php echo $NOMBRE ?>" name="nombreEmpleado" class="bloqueado" readonly></input></td>
				<td id="mensaje"></td>
			</tr>
			<tr>
				<td><label >&#193rea o departamento:</label></td>
				<td><input id="area1" name="area" value="<?php echo $AREAN ?>" class="bloqueado" readonly="readonly"></input></td>
				<td>&#160;</td>
			</tr>
			<tr>
				<td><label>D&iacuteas ley:</label></td>
				<td><input id="Vacaciones" name="Vaca" class="bloqueado" readonly></input></td>
				<td><label>D&iacuteas solicitados: </label></td>
				<td><input id="diasSolicitados" name="diasSolicitados" value="" class="bloqueado" readonly></input></td>
			</tr>
			<tr>
				<td><label>D&iacuteas restantes:</label></td>
				<td><input id="diasRestantes" name="DiasRestantes" value="" class="bloqueado" readonly></input></td>
				<td><label>D&iacuteas adicionales: </label></td>
				<td><input id="diasAdicionales" name="DiasAdicionales" value="" class="bloqueado" readonly></input></td>
			</tr>
			<tr>
			<td ><label>Fecha inicio:</label></td>
				<td ><input id="fecha" size="10" type="date" name="fecha1" onchange="fechas()" min="<?php echo $fecha1; ?>"  class="form-control" required=”required”/></td>
				<td ><label>Fecha fin:</label></td>
				<td colspan="2"><input type="date" name="fecha2" id="fecha2" min="<?php echo $fecha1; ?>" onchange="fechas()" class="form-control" required=”required”/></td>
			</tr>
			<tr><td>&#160;</td></tr>
			<tr>
				<td>&#160;</td>
				<td style="padding-left:25%"><button id="btnSubmit" type ="submit" class ="btn btn-primary ">&#160;Enviar&#160;</button></td>
				<td align="left"><!--<button class="btn btn-danger">Cancelar</button>--></td>
			</tr>
		</table>
		</div>
		</div>
	</form>	
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES ENVIADAS</div>
    <div class="panel-body" id="cuerpo">
	</div>
<?php
	include("intraFooter.php"); 
?> 