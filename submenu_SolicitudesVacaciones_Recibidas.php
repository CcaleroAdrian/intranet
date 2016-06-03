 <?php
include("intraHeader.php"); 
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	} 
 
	$ID_USR;
	$VisualizarR = false;
	$PERFIL_USR; //Descripcion de perfil;
	$mensaje="";
	//*******PAGINACION DE RESULATADO********
	$url = "/intranet/submenu_SolicitudesVacaciones_Recibidas.php";
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios
	$user = $objUsuarios->verSolicitudesIDB($ID_USR);
	//print_r($user);
	if ( $user == -1  OR $user == 0 ) {
		$VisualizarR = false;
		$mensaje = "<span style='color:#F8BB86'>No hay solicitudes disponibles por el momento.</span>";
	}else{
		$VisualizarR = true;

		$numRegi = count($user);
		//Limito los resultados por pagina
		$TAMANO_PAGINA = 5; 
		$pagina = false;
		//examino la pagina a mostrar y el inicio del registro a mostrar
	    if (isset($_GET["pagina"]))
	        $pagina = $_GET["pagina"];

		if (!$pagina) { 
		   	$inicio = 0; 
		   	$pagina = 1; 
		} 
		else { 
		   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
		}

		//calculo el total de páginas 
		$total_paginas = ceil($numRegi / $TAMANO_PAGINA); 
		$USR = $objUsuarios->verSolicitudesID($ID_USR,$inicio,$TAMANO_PAGINA,"");
		//print_r($USR);
	}
?>
<html>
<head>
<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<script type="text/javascript">
	
	var usuario = "<?php echo $ID_USR; ?>";
	
	function mostrarSolicitud(){
		var nombre=[];
		var n;
		var jsonObject =eval('<?php echo json_encode($USR); ?>');
		for (var i = 0; i <=jsonObject.length-1; i++) {
			var empleado_id =jsonObject[i].user_ID;
			$.ajax({
		        method: "GET",
		        url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/nombres/",
		        dataType: "json",
		        timeout: 6000,
		        headers:{ID :empleado_id},
			    beforeSend:function(){
			        var div = document.getElementById('mensaje');
			        var spinner = new Spinner(opts).spin(div);
			    },
			    succes:function(data) {
			    	n=data['nombre'];
			    }
			});	    
		    $('#cuerpo').append("<tr><td>"+n+"</td><td>"+jsonObject[i].fechaI+"</td><td>"+jsonObject[i].fechaF+"</td><td>"+jsonObject[i].diasCorrespondientes+"</td><td>"+jsonObject[i].diasSolicitados+"</td><td>"+jsonObject[i].diasAdicionales+"</td><td><a href='descargarArchivo.php?id="+jsonObject[i].solicitud_ID+"'>"+jsonObject[i].documentoURL+"</a></td><td><a id='aceptar' onclick='aceptar("+jsonObject[i].solicitud_ID+","+usuario+")'>Aceptar</a></td><td><a id='rechazar' onclick='rechazar("+jsonObject[i].solicitud_ID+","+usuario+")'>Rechazar</a></td></tr>");
		}
		$( ".spinner" ).remove();
	}
	

	$(document).ready(function(){
		var error =  "<?php echo $mensaje; ?>";
		if (error != "") {
			swal({title: "CONFIRMACIÓN",imageUrl: "intraImg/logoITWfinal.png",text: error,html: true,timer:3000,showConfirmButton:false});
		}
		//mostrar solicitudes recibidas
		mostrarSolicitud();

		//Evitar eventos default
		$('#aceptar').on('click',function(event){
			event.preventDefault();
		});
		$('#rechazar').on('click',function(event){
			event.preventDefault();
		});
	});
</script>
<style type="text/css">
	a{
		cursor: pointer;
	}
</style>

<body>
	<h3>SOLICITUDES DE VACACIONES</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES RECIBIDAS <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    	<div class="panel-body">
    	<?php
    	if ($VisualizarR == true) {
    	?>
    	<form id="mensaje">
  			<div class="input-group col-sm-12">
    		<span class="glyphicon glyphicon-search input-group-addon"></span>
  			<input id="filtroTabla" onkeyup="busqueda({opcion : 2,id : <?php echo $ID_USR;?>})" class="form-control glyphicon glyphicon-search" size="35" align="center" autofocus>
  			</div>
		</form><br>
    		<table class="table table-bordered" id="myTable" >
    			<thead>
		        <tr>
		          <th >Nombre</th>
		          <th >Fecha Inicio</th>
		          <th >Fecha Fin</th>
		          <th >Días Ley</th>
		          <th >Días Solicitados</th>
		          <th >Días Adicionales</th>
		          <th>Documento Soporte</th>
		          <th  colspan="2" style="text-align: center;">Acción</th>
		        </tr>
		      	</thead>
		      	<tbody id="cuerpo"></tbody>
    		</table>
		      			<?php 
							if ($total_paginas > 1) {
								if ($pagina != 1)
								echo '<a href="'.$url.'?pagina='.($pagina-1).'"><span class="glyphicon glyphicon-chevron-left"></span></a>';
							for ($i=1;$i<=$total_paginas;$i++) {
								if ($pagina == $i)
								//si muestro el �ndice de la p�gina actual, no coloco enlace
								echo $pagina;
								else
								//si el �ndice no corresponde con la p�gina mostrada actualmente,
								//coloco el enlace para ir a esa p�gina
								echo '<a href="'.$url.'?pagina='.$i.'">'.$i.'</a>';
							}
							if ($pagina != $total_paginas)
							echo '<a href="'.$url.'?pagina='.($pagina+1).'"><span  class="glyphicon glyphicon-chevron-right"></span></a>';
							}
							echo '</p>';
						}
				      	?>
    	</div>
    </div>
</body>
</html>

 <?php
	include("intraFooter.php"); 
?> 