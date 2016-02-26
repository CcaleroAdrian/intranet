<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}
	
	//$idMenu =isset($_GET['idMenu']) ? trim($_GET['idMenu']) : "" ;
	//$idSubMenu =isset($_GET['idSubMenu']) ? trim($_GET['idSubMenu']) : "" ;
	$mensaje = "";
	$blnOk = true;

	//Instanciamos la clase que tiene las operaciones a la base de datos
	$objUsuarios = new ActionsDB();
	// Obtenemos los campos de la tabla usuarios para presentarla en el perfil
	$usuarios = $objUsuarios->getAllUsuarios( );
	
	If ( $usuarios == -1  OR $usuarios == 0 ) {
		$blnOk = false;
		$mensaje = "No se obtuvieron registros de usuarios en la base de datos.";
	}
	
	If ( $blnOk ) {
		
 ?>

  		<h3>ADMINISTRACI&Oacute;N DE USUARIOS &nbsp; </h3>
  		<div class="panel panel-primary">
    	<div class="panel-heading">USUARIOS</div>
    	<div class="panel-body">

		<table width="95%"  align="center" cellpadding="2" cellspacing="3"  class="table table-condensed table-responsive" border="0" bordercolor="#eeeeee">
          <tr class="active">
            <th height="14" scope="col"><span >Usuario</span></th>
            <th height="14" scope="col" ><span >Nombre(s)</span></th>
            <th height="14" scope="col"><span >Paterno</span></th>
            <th height="14" scope="col"><span >Materno</span></th>
            <th height="14" scope="col"><span >Perfil</span></th>
            <th height="14" scope="col"><span >Estado</span></th>
            <th height="14" scope="col"><span >Modificar</span></th>
            <th height="14" scope="col"><span >Eliminar</span></th>
          </tr>
		  <?php 
		  	foreach ( $usuarios as $reg  )  {
        		echo "<tr> <td>".$reg["usrIntranet"]."</td> <td>".$reg["nombre"]."</td> <td>".$reg["paterno"]."</td> <td>".$reg["materno"]."</td><td>".$reg["facultad"]."</td> <td>".$reg["estado"]."</td> <td> <a href='page_ModificaUsuario.php?Usuario=".$reg["usrIntranet"]."'> <div align='center'><span class='glyphicon glyphicon-pencil' style='color:black;'></span></div><a/></td><td> <a href='page_EliminaUsuario.php?Usuario=".$reg["usrIntranet"]."'> <div align='center'><span class='glyphicon glyphicon-remove' style='color:red;'></span></div> <a/>  </td> </tr>";
		  	}
		  ?> 
        </table>
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