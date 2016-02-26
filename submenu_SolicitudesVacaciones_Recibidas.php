 <?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

	$ID_USR;
	$VisualizarR = false;


	//*******PAGINACION DE RESULATADO********
	$url = "/intranet/submenu_SolicitudesVacaciones_Recibidas.php";
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios
	$user = $objUsuarios->verSolicitudesIDB($ID_USR);
	If ( $user == -1  OR $user == 0 ) {
		$VisualizarR = false;
		$mensaje = "No se han recibido solicitudes de vaciones recientemente.";
	}else{
		$VisualizarR = true;
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

	$usuarios = $objUsuarios->verSolicitudesID($ID_USR,$inicio,$TAMANO_PAGINA);
	//print_r($usuarios)
?>
<html>
<head>
<script type="text/javascript" src="intraCss/bootstrap/js/notify.min.js"></script>
<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<body>
	<h3>SOLICITUDES DE VACACIONES</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES RECIBIDAS</div>
    	<div class="panel-body">
    	<?php
    	if ($VisualizarR == true) {
    	?>
    	<form >
  			<div class="input-group col-sm-12">
    		<span class="glyphicon glyphicon-search input-group-addon"></span>
  			<input id="filtroTabla" onkeyup="busqueda({opcion : 2,id : <?php echo $ID_USR;?>})" class="form-control glyphicon glyphicon-search" size="35" align="center" autofocus>
  			</div>
		</form><br>
    		<table class="table table-responsive table-bordered" id="myTable">
    			<thead>
		        <tr>
		          <th data-priority="7">Nombre</th>
		          <th data-priority="1">Fecha Inicio</th>
		          <th data-priority="2">Fecha Fin</th>
		          <th data-priority="3">Dias Correspondientes</th>
		          <th data-priority="4">Dias Solicitados</th>
		          <th data-priority="5">Dias Adicionales</th>
		          <th data-priority="6" colspan="2">Acción</th>
		        </tr>
		      	</thead>
		      	<tbody id="cuerpo">
		      		<?php 
		      			foreach($usuarios as $fil) {
		      				
		      				$us = $objUsuarios-> notificarUsuario($fil["user_ID"]);
		      				
		      				foreach ($us as $key) {
		      					$nombre = utf8_encode($key['nombre'].' '.$key['paterno'].' '.$key['materno']);
		      					echo '<tr><td>'.$nombre.'</td>
									<td>'.$fil["fechaI"].'</td><td>'.$fil["fechaF"].'</td>
									<td>'.$fil["diasCorrespondientes"].'</td><td>'.$fil["diasSolicitados"].'</td>
									<td>'.$fil["diasAdicionales"].'</td><td><a href="#">Aceptar</a></td><td><a href="#">Rechazar</a></td></tr>';
		      				}
							
						}		
		      		?>
		      	</tbody>
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
						}else{
							echo "<div class='col-sm-12'><p>".$mensaje."</p></di>";
						}
				      	?>
    	</div>
    </div>
</body>
</html>

 <?php
	include("intraFooter.php"); 
?> 