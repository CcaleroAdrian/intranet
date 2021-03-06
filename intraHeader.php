<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
	
	require 'clases/sesion.php';
	//require 'clases/configCon.php';
	require 'clases/actionsDB.php';   
	
	$objsesion = new Sesion();
	$objsesion->init();
	$USUARIO = isset($_SESSION['USUARIO']) ? trim( $_SESSION['USUARIO']) : null ;
	$PERFIL_USR = isset($_SESSION['ID_PERFIL']) ? $_SESSION['ID_PERFIL'] : null ;
	$DESCPERFIL_USR = isset($_SESSION['DESC_PERFIL']) ? trim($_SESSION['DESC_PERFIL']) : null ;
	$ID_USR = isset($_SESSION['IDUSUARIO'])? trim($_SESSION['IDUSUARIO']) : null;
	$HoraIngreso = isset($_SESSION['HoraIngreso']) ? trim($_SESSION['HoraIngreso']) : null;
	
	// Evitar los warnings the variables no definidas!!!
	$error = isset($_GET['err']) ? $_GET['err'] : "" ;
	//Proceso de caducidad de sesión por inactividad
	$ahora = date("Y-n-j H:i:s"); 


    $tiempo_transcurrido = (strtotime($ahora)-strtotime($HoraIngreso)); 
     //comparamos el tiempo transcurrido 
    if($tiempo_transcurrido >= 600) { 
     //si pasaron 10 minutos o más 
      header('cerrarSesion.php'); //envío al usuario a la pag. de autenticación 
      //sino, actualizo la fecha de la sesión 
    }else { 
    	$_SESSION["HoraIngreso"] = $ahora; 
   } 
	
	$NumBanner = rand( 1 , 5 )
?> 
<html lang=''>
<head>

   <!--<link rel="shortcut icon" href="intraImg/favicon.ico type="x-icon" " >-->
   <link rel="shortcut icon" type="image/gif" href="intraImg/animated_favicon1.gif" >
   <link href="intraCss/intraItw.min.css" rel="stylesheet" type="text/css">
   <link href="intraCss/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   
   <title>ITWorkers</title> 
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <script type="text/javascript" src="js/funciones.js" ></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" async></script>
  <script type="text/javascript" src="intraCss/bootstrap/js/jquery.js"></script>
  <script type="text/javascript" src="intraCss/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="intraCss/bootstrap/js/notify.min.js"></script>
</head>
<body>
	
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
		<!-- Renglón con imágen TOP de Intranet -->
		<tr bgcolor="#000033">
    		<td height="10" ><img src="intraImg/intraHeader.jpg" width="800pc" height="20pc"></td>
  		</tr>
		
		<!-- Renglón con  Bienvenida a usuario en Sesión  y   botones de menú  -->
		<tr bgcolor="#000033">
			<td>
				<table width="100%"  bgcolor="#000033">
					<tr>
						<td width="100%" >
							<?php 
								if($USUARIO <> ''){
									echo "<span class='txtBienvenido' > Bienvenido, </span >  <span class='txtUsuario'>" . $_SESSION['USUARIO']. "</span>" ;
								}
							?>  
						</td> 
						<td>&nbsp;</td>
						<td width="40">
							  <a href="http://www.itw.mx/"   onmouseover="MM_swapImage('ImageWeb','','intraImg/Menu/imgIcoIntranet2.png',1)" onmouseout="MM_swapImgRestore()"><img src="intraImg/Menu/imgIcoIntranet.png" name="ImageWeb"  id="ImageWeb"  align="center"  alt="Sitio Oficial"/></a>
						</td>
						<td>&nbsp;</td>
						<?php
							if($USUARIO <> ''){
						?> 
							<td width="40">
							  <a href="http://itworkers.sharepoint.com/" target="_blank" onmouseover="MM_swapImage('ImageShare','','intraImg/Menu/imgIcoShare2.png',1)" onmouseout="MM_swapImgRestore()"><img src="intraImg/Menu/imgIcoShare.png" name="ImageShare"  id="ImageShare"  align="center"  alt="SharePoint"/></a>
							</td>
							
						<?php
						}
						?>
						
						<td>&nbsp;</td>
						<td width="40">
						  <a href="http://www.intranet.itw.mx/"   onmouseover="MM_swapImage('ImageHome','','intraImg/Menu/imgIcoHome2.png',1)" onmouseout="MM_swapImgRestore()"><img src="intraImg/Menu/imgIcoHome.png" name="ImageHome"  id="ImageHome"  align="center"  alt="Home Intranet"/></a>
						</td>
						<td>&nbsp;</td>
						
						<?php
							if($USUARIO <> ''){
						?>
							<td>
							</td>
							<td>
							  <a href="cerrarSesion.php"   onmouseover="MM_swapImage('ImageCierraSesion','','intraImg/btnCerrarSesion2.png',1)" onmouseout="MM_swapImgRestore()"><img src="intraImg/btnCerrarSesion.png" name="ImageCierraSesion"  id="ImageCierraSesion"  align="center"  alt="Cerrar Sesión"/></a>
							</td>
						<?php
							}
						?>
						&nbsp;
					</tr>
				</table>
			</td>
		</tr>
		
		<!-- Renglón  para mostrar la imágen del Header  y hora. -->
		<tr>
          <td> 
            <table width="100%" height="131px"  border="0" cellspacing="0" cellpadding="0" background="intraImg/itw2_03.png" >
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td width="50%" > 
				 
				</td>
				<td width="50%" valign="center" > 
				
				<div align="right">
				<p align="right"  class="dateHeader" style="color:black;" >
								<script>
								document.write(" "+ getFechaHoy() + " " );
								</script>
								&nbsp;  &nbsp;
				  </p>	
				
				</div></td>
              </tr>
          	</table> 
		  </td>
        </tr>
		
        <?php  
		
		if($USUARIO <> ''){
			include("intraMenu.php");
		}
		
		?>
  <!-- A partir de aqui se agrega el rengl�n  y columna que  contendr�  el Cuerpo de cada p�gina -->
<tr bgcolor="#ffffff" >
  			<td id="bodyShow" > 
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="intraCss/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>-->

