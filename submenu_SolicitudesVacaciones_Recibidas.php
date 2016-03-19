 <?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}
 
	$ID_USR;
	$VisualizarR = false;
	$DESCPERFIL_USR; //Descripcion de perfil;

	//*******PAGINACION DE RESULATADO********
	$url = "/intranet/submenu_SolicitudesVacaciones_Recibidas.php";
	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios
	$user = $objUsuarios->verSolicitudesIDB($ID_USR,$DESCPERFIL_USR);
	//print_r($user);
	if ( $user == -1  OR $user == 0 ) {
		$VisualizarR = false;
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
		$USR = $objUsuarios->verSolicitudesID($ID_USR,$DESCPERFIL_USR,$inicio,$TAMANO_PAGINA,"");
	}
?>
<html>
<head>
<script type="text/javascript" src="js/busqueda.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		var error =  "<?php echo $mensaje; ?>";
		
		if (error != "") {
			swal({title: "CONFIRMACIÓN",text: error,type: "info",timer:3000,showConfirmButton:false});
		}
	});
</script>
<body>
	<h3>SOLICITUDES DE VACACIONES</h3>
	<div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES RECIBIDAS <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
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
    		<table class="table table-responsive table-bordered" id="myTable" >
    			<thead>
		        <tr>
		          <th >Nombre</th>
		          <th >Fecha Inicio</th>
		          <th >Fecha Fin</th>
		          <th >Días Correspondientes</th>
		          <th >Días Solicitados</th>
		          <th >Días Adicionales</th>
		          <th>Documento Soporte</th>
		          <th  colspan="2" style="text-align: center;">Acción</th>
		        </tr>
		      	</thead>
		      	<tbody id="cuerpo">
		      		<?php 
		      			foreach($USR as $value){
		      				$user = $objUsuarios->notificarUsuario($value["user_ID"]);
		      				foreach ($user as $key){
		      					$nombre = utf8_encode($key['nombre'].' '.$key['paterno'].' '.$key['materno']);
		      				?>
		      						<tr><td><?php echo $nombre; ?></td>
									<td><?php echo $value["fechaI"]; ?></td><td><?php echo $value["fechaF"]; ?></td>
									<td><?php echo $value["diasCorrespondientes"]; ?></td>
									<td><?php echo $value["diasSolicitados"]; ?></td>
									<td><?php echo $value["diasAdicionales"]; ?></td>
									<td>
										<a <?php echo($value["documentoURL"] != "cargar documento") ? "href='' " : "";?> ><?php echo $value["documentoURL"]; ?></a>
									</td>
									<td><a onclick="aceptar({id:'.$value['user_ID'].', perfil: '.$DESCPERFIL_USR.'})"  href="">Aceptar</a></td>
									<td><a onclick="rechazar({id:'.$value['user_ID'].', perfil: '.$DESCPERFIL_USR.'})"  href="">Rechazar</a></td>
									</tr>';
						<?php
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