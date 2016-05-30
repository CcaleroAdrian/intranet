<?php
	include("intraHeader.php");

	if ( $USUARIO == "" OR  $USUARIO == null ) {
		//exit();
		header('Location: index.php');
	}

 ?>
  <script type="text/javascript">
 	$(window).load(function(){
/*
 		if (error != "") {
 			swal({title: "Confirmacion",text: error,type: "error",timer:3000,showConfirmButton:false});
		}else if(usuario != ""){
			swal({title: "Confirmacion",text: usuario,type: "error",timer:3000,showConfirmButton:false});
		}else if (nombre != "") {
			swal({title: "Confirmacion",text: nombre,type: "error",timer:3000,showConfirmButton:false});
		}else if (apellido != "") {
			swal({title: "Confirmacion",text: apellido,type: "error",timer:3000,showConfirmButton:false});
		}else if (a != "") {
			swal({title: "Confirmacion",text: a,type: "error",timer:3000,showConfirmButton:false});
		}else if (tipoUser != "") {
			swal({title: "Confirmacion",text: tipoUser,type: "error",timer:3000,showConfirmButton:false});
		}

		if (success != "") {
			swal({title: "Confirmacion",text: success, type:"success", timer:3000, showConfirmButton:false});
		}*/
 	});

 	$(window).ready(function(){
 		$('#PERFILES').on('click',function(event){
 			event.preventDefault();
			console.log($('#PERFILES').serealize());
		/*	$.ajax({
					method: "POST",
					url: 'guardarrPerfiles.php',
					dataType: "json",
					data:$('#PERFILES').serealize();
					success: function(data) {
							///console.log(data);
							var opciones = "";
							for (var i=0;  i<= data['items'].length-1; i++) {
								var opcion = '<option value="'+data["items"][i].area_id+'">'+data["items"][i].nombre_area+'</option>';
							opciones += opcion;
							}
							$('#combo').html(opciones);
					}
*/
 		});
 	});

 	function myfuction(){
 		window.open("popup.php", "_blank", 'width=333px,height=273px,resizable=yes,toolbar=no'); return false;
 	}

 </script>

	<h3>ACCESOS AL SISTEMA</h3>
	<div class="panel panel-primary">
    	<div class="panel-heading">ALTA DE PERFILES
    		<a id="tutorial" href="" onclick="mostrarTuto()">
    		<i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a>
    	</div>
	   	<div class="panel-body" enctype="multipart/form-data">
	   		<form id="PERFILES">
			    <table width="90%" border="0" cellspacing="1" align="center" class="table-bordered" >
		        	<tr>
		        		<td>
		        			<label>Perfil:</label>
		        		</td>
		        		<td>
		        			<input type="text" size="10" name="perfil" class="form-control" required="require">
		        		</td>
		        		<td>
		        			<input type="submit" align="center" class="btn btn-primary" value="GUARDAR"/>
		        		</td>
		        	</tr>
		        </table>
	        </form>
	    </div>
    </div>
    <div class="panel panel-primary">
    	<div class="panel-heading">ADMINISTRACI&Oacute;N DE ACCESOS
    		<a id="tutorial" href="" onclick="mostrarTuto()">
    		<i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a>
    	</div>
	   	<div class="panel-body">
		    <table width="90%" border="0" cellspacing="1" align="center" class="table-bordered" >
		    	<tr>
		    		<td>
		    			<label>Perfil:</label>
		    		</td>
		    		<td>
		    			<select id="Perfiles" name="ID_Perfil" class="form-control"></select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label>Men&uacute;s</label>
		    		</td>
		    		<td>&#160;</td>
		    		<td>
		    			<label>SubMen&uacute;s</label>
		    		</td>
		    		<td>&#160;</td>
		    	</tr>
		    	<tr>
		    		<td id="menus"></td>
		    		<td>&#160;</td>
		    		<td id="submenus"></td>
		    		<td>&#160;</td>
		    	</tr>
		    	<tr>
		    		<td></td><td></td>
		    		<td><input type="submit" align="center" class="btn btn-primary" value="GUARDAR"/></td>
		    	</tr>
	        </table>
	    </div>
    </div>
    <div class="panel panel-primary">
    	<div class="panel-heading">ASIGNACI&Oacute;N DE PERFILES
    		<a id="tutorial" href="" onclick="mostrarTuto()">
    		<i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a>
    	</div>
	   	<div class="panel-body">
		    <table width="90%" border="0" cellspacing="1" align="center" class="table-bordered" >
			    <tr>
			    	<td>
			    		<label>Usuario:</label>
			    	</td>
			    	<td>
			    		<input type="text" name="usuario">
			    	</td>
			    	<td>
			    		<label>Perfil:</label>
			    	</td>
			    	<td>
			    		<select id="Perfiles" name="ID_Perfil" class="form-control"></select>
			    	</td>
			    </tr>
			    <tr>
			    	<td></td>
			    	<td>
			    		<input type="submit" align="center" class="btn btn-primary" value="GUARDAR"/>
			    	</td>
			    </tr>
	        </table>
	    </div>
    </div>


<?php
	include("intraFooter.php");
?>
