<?php
include("intraHeader.php");

if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

	//*******PAGINACION DE RESULATADO********
	$url = "/intranet/sub_menuDirectorio.php"; 
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios
	$user = $objUsuarios->getDirectorio();
	If ( $user == -1  OR $user == 0 ) {
		echo "No se obtuvieron registros de usuarios en la base de datos.";
	}
	
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

	$usuarios = $objUsuarios->getDirectorioB($inicio,$TAMANO_PAGINA);

?>
<script type="text/javascript">
	$(document).ready(function(){
		verContactos();
	});

	function verContactos(){
			$.ajax({
		        method: "GET",
		        url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/empleado/",
		        dataType: "json",
		        timeout: 6000,
			    beforeSend:function(){
			        var div = document.getElementById('mensaje');
			        var spinner = new Spinner(opts).spin(div);
			    },
			    succes:function(data) {
			    	console.log(data);
			    	for (var i =0 ; i<data.length;i++) {
			    		$('#cuerpo').html("<tr><td>"+data['items'][i].nombres+"</td><td>"+data['items'][i].email_1+"</td><td>"+data['items'][i].email_2+"</td><td>"+data['items'][i].celular+"</td><td>"+data['items'][i].telefono+"</td></tr>");
			    	}
			    }
			});	    
		$( ".spinner" ).remove();
	}	
</script>
<!DOCTYPE html>
<meta http-equiv=content-type content=text/html; charset=utf-8>
<html>
<head>
<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<body>
	<h3>DIRECTORIO DE CONTACTOS ITW</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">CONTACTOS ITW <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    	<div class="panel-body">
    	<form>
    		<div class="input-group col-sm-12">
    		<span class="glyphicon glyphicon-search input-group-addon"></span>
  			<input id="filtroTabla" onkeyup="busqueda({opcion:1,id:0})" class="form-control glyphicon glyphicon-search" size="35" align="center" autofocus> 
  			</div>
		</form><br>
    		<table class="table table-bordered" id="myTable">
    			<thead>
		        <tr>
		          <th data-priority="6">Nombre</th>
		          <th data-priority="1">Email ITW</th>
		          <th data-priority="1">Email P.</th>
		          <th data-priority="2">Celular</th>
		          <th data-priority="3">Telefono</th>
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
								echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
							}
							if ($pagina != $total_paginas)
							echo '<a href="'.$url.'?pagina='.($pagina+1).'"><span  class="glyphicon glyphicon-chevron-right"></span></a>';
							}
							echo '</p>';
				      	?>
    	</div>
    </div>
</body>
</html>
<?php
	include("intraFooter.php"); 
?> 