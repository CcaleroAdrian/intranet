<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}

	$nombre = "";
	$inicio = "";
	$TAMANO_PAGINA="";
	$mostrar ="";

	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$user = $objUsuarios->getAllUsuarios($nombre,$inicio,$TAMANO_PAGINA);
	
	If ( $user == -1  OR $user == 0 ) {
		$blnOk = false;
		$mensaje = "No se obtuvieron registros de usuarios en la base de datos.";
	}
	
	//Paginacion de resultados
	$numRegi = count($user);
	$url = "/intranet/submenu_UsuariosModifica.php";
	//Limito los resultados por pagina
	$TAMANO_PAGINA = 10; 
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
	$usuarios = $objUsuarios->getAllUsuarios($nombre,$inicio,$TAMANO_PAGINA);

	$mensaje = "";
	$blnOk = true;

	//Instanciamos la clase que tiene las operaciones a la base de datos
	
	If ( $blnOk ) {
		
 ?>
 <script type="text/javascript">
 	
	function convierteAlias (nuevoAlias) {
 		var especiales = new Array('á','é','í','ó','ú','ñ','?');
 		var normales = new Array('a','e','i','o','u','n','ó');
 
 		var nuevoAlias = nuevoAlias.toLowerCase();
 
 		var i=0;
		 while (i<especiales.length) {
		  //nuevoAlias = nuevoAlias.replace(especiales[i], normales[i]);
		  nuevoAlias = nuevoAlias.split(especiales[i]).join(normales[i]);
		  i++
		 }
 		return nuevoAlias;
	}

	function verOpcion(fila){
		area = fila.getAttribute("data-area");
		id = fila.getAttribute("data-id");

		swal({   title: "ASIGNACIÓN DE GERENTES",
				   text: "Seleccione la opción a realizar",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: " #337ab7",
				   cancelButtonColor: "#ff3333",
				   confirmButtonText: "Asignar",
				   cancelButtonText: "Deshasignar",
				   closeOnConfirm: false,
				   closeOnCancel: false
				}, 
				function(isConfirm){ 
				  if (isConfirm) {
				  	swal({title:"ASIGNACIÓN DE GERENTE",
				  		  text:"El usuario ha sido asignado como gerente.",
				  		  type:"info",
				  		  confirmButtonColor: " #337ab7",
				  		  showConfirmButton:false,
				  		  timer:2000
				  		}); 
				  	guardarDatos(id,area,3);
				  } else{
				  	swal({title:"DESHASIGNACIÓN DE GERENTE",
				  	text: "El usuario ha sido deshasignado como gerente.",
				  	type: "info",
				  	confirmButtonColor: " #337ab7",
				    confirmButtonText: "OK"
				  	});
				  	guardarDatos(id,area,4);
				  }
				});
		

	}
 	
 	function guardarDatos(id,area,opcion){
 		var xmlhttp;
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				
		}else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var resultado =xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","acciones.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("opcion="+opcion+"&id="+id+"&area="+area);
 	}

    $(window).load(function(){
    	var otro = "<?php echo isset($_GET['mensaje']) ? trim(utf8_decode($_GET['mensaje'])) : ""; ?>";
    	var usuario = "<?php echo isset($_GET['usuario']) ? trim(utf8_decode($_GET['usuario'])) : "";?>";

        if (otro != "" && usuario =="") {
        	otro = convierteAlias(otro);
        	swal({title: "Confirmacion", text: otro, type:"success", timer:3000, showConfirmButton:false});
        }else if (otro == "" && usuario !=""){
        	usuario = convierteAlias(usuario);
        	swal({title: "Confirmacion", text: usuario, type:"success", timer:3000, showConfirmButton:false});
        }
    });

 </script>
 <script type="text/javascript" src="js/busqueda.js"></script>
  		<h3>ADMINISTRACI&Oacute;N DE USUARIOS &nbsp; </h3>
  		<div class="panel panel-primary">
    	<div class="panel-heading">USUARIOS<a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg"style="padding-left: 10px; color: white;"></i></a></div>
    	<div class="panel-body">
    	<form>
    		<div class="input-group col-sm-12">
    		<span class="glyphicon glyphicon-search input-group-addon"></span>
  			<input id="filtroTabla" onkeyup="busqueda({opcion:4,id:0})" class="form-control glyphicon glyphicon-search" size="35" align="center" autofocus>
  			</div>
		</form><br>
		<table width="95%"  align="center" cellpadding="2" cellspacing="3"  class="table table-responsive" border="0" bordercolor="#eeeeee">
          <thead class="active">
            <th height="14" scope="col" style="display:none;"><span >Usuario</span></th>
            <th height="14" scope="col" ><span >Nombre(s)</span></th>
            <th height="14" scope="col"><span >Paterno</span></th>
            <th height="14" scope="col"><span >Materno</span></th>
            <th height="14" scope="col"><span >Perfil</span></th>
            <th height="14" scope="col"><span >Estado</span></th>
            <th height="14" scope="col" style="text-align: center;" colspan="3"><span >Acción</span></th>
          </thead>
          <tbody id="cuerpo">
		  <?php 
		  	foreach ( $usuarios as $reg  )  {
		  		$dato = $objUsuarios->verGerente($reg["idUsuario"]);
		  		$numRegi = count($dato);
	
		  		if ($numRegi != 0) {
		  			$mostrar = "GERENTE";
		  		}else{
		  			$mostrar="";
		  		}
        		echo "<tr>
        			<td style='display:none;''>".$reg["usrIntranet"]."</td>
        			<td>".utf8_encode($reg["nombre"])."</td> 
        			<td>".utf8_encode($reg["paterno"])."</td> 
        			<td>".utf8_encode($reg["materno"])."</td>
        			<td>".$reg["facultad"]."</td> 
        			<td>".$mostrar."</td> 
        			<td style='text-align: center;'><a href='page_ModificaUsuario.php?Usuario=".$reg["usrIntranet"]."'><i class='fa fa-pencil'></i>
        			</td>
        			<td style='text-align: center;'><a href='page_EliminaUsuario.php?Usuario=".$reg["usrIntranet"]."'><i class='fa fa-trash' style='color:red;'></i></a>
        			</td>
        			<td style='text-align: center;'><a onclick='verOpcion(this)' data-id='".$reg["idUsuario"]."' data-area='".$reg['area_ID']."'><i class='fa fa-street-view'></i></a>
        			</td>
        			
        			</tr>";
		  	}
		  ?> 
		  </tbody>
        </table>
        <?php 
							if ($total_paginas > 1) {
								if ($pagina != 1)
								echo '<a href="'.$url.'?pagina='.($pagina-1).'"><i class="fa fa-chevron-left fa-lg"></i></a>';
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
							echo '<a href="'.$url.'?pagina='.($pagina+1).'"><i class="fa fa-chevron-right fa-lg"></i></a>';
							}
							echo '</p>';
				      	?>
		<p align="center">&nbsp;</p>

<?php
	
	} else {
?>
	
		<table width="90%"  border="0" cellspacing="2" cellpadding="0" class="table-responsive">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td height="300">&nbsp;
				<form name="frmContinua" method="post" action="<?php echo "menu_Usuarios.php?idMenu=". $idMenu ."";  ?>"  >
              <table width="50%"  border="0" align="center" cellpadding="0" cellspacing="2" class="table-responsive">
                <tr>
                  <td>&nbsp;
				  	 <?php 
						if( $mensaje <> "" ){
							echo "<div aling='center'  class='txtErro1'  > ". $mensaje ."   </div>";
						}
					?> 
				  </td>
                </tr>
                <tr>
                  <td><div align="center">
                    
                  </div>
				  </td>
                </tr>
              </table>			
			  </form>  
              <div align="center">
			  
			  </div></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>	
	
<?php	

	}
	
	include("intraFooter.php"); 
?> 