<?php   
	include("intraHeader.php");  
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		exit();
	}
	
	$mensaje ="";
	$valok = true;
	$exito = false;
	$password;
	$pwd1 =isset($_POST['clave1']) ? trim($_POST['clave1']) : "" ;
	$pwd2 =isset($_POST['clave2']) ? trim($_POST['clave2']) : "" ;
	$btnCambiar = isset($_POST['update']) ? trim($_POST['update']) : "";

	if ( $btnCambiar == "Cambiar" ) {

		if ( $pwd1 <> ""  AND  $pwd2 <> "" ) {
			
			//Validar que las contraseña sean de 8 caracteres
			if ( (strlen($pwd1) <> 8 )  OR (strlen($pwd2) <> 8 ) ) {
				$valok = false;
				$mensaje = "<span style='color:#F8BB86'>La nueva contraseña debe ser de 8 caracteres.</span>";
			}elseif ( $valok  AND ( $pwd1 <> $pwd2 ) ) {
				$valok = false;
				$mensaje = "<span style='color:#F8BB86'>Las contraseñas deben ser iguales.</span>";
			}else{
				$password =isset($pwd1) ? trim(md5($pwd1)) : "";
				$valok = true;
			} 
		}else {
			$valok = false;
			$mensaje = "<span style='color:#F8BB86'>Debe capturar ambos campos.</span>";
		}
	} 
		
 ?> 
  <script type="text/javascript">
 	$(window).load(function(){
 		var error = "<?php echo $mensaje; ?>";
 		if (error != "") {
 			swal({
	        title: "Alerta",
	        text: error,
	        html:true,
	        imageUrl: "intraImg/logoITWfinal.png",
	        timer: 3000,
	        showConfirmButton:false
	        });
 		}
 	});

 	$(document).ready(function(){

 		$('#form1').on('submit',function(event){
 			var password = "<?php echo $password; ?>";
 			var id = "<?php echo $ID_USR; ?>";
 			var update = "<?php echo $valok; ?>";
 			console.log("passsowrd"+password);
 			console.log("<br>id:"+id);
 			console.log("<br>update:"+update);

 			event.preventDefault();
 			if (update == true) {
	 			$.ajax({
			        method:'POST',
			        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/password/',
			        headers:{PASSWORD: password, EMPLEADO_ID:id},
			        beforeSend: function() {
			            var div = document.getElementById('spinner');
			            var spinner = new Spinner(opts).spin(div);
			            $('html, body').animate( {scrollTop : 0}, 800 );
			          },
			          success: function(data) {
			            swal({
			              title: "Confirmacion",
			              text: "<span style='color:#000099'>Información actualizada correctamente cerrando sesión.</span>",
			              imageUrl: "intraImg/logoITWfinal.png",
			              html:true,
			              showConfirmButton:false,
			              timer:4000
			              });
			            $( ".spinner" ).remove();
			            window.location.href = "../intranet/page_CerrarSesion.php";
			          },
			          error:function(jqXHR,estado,error){
			            $( ".spinner" ).remove();
			            $("#pwd1").val();
			            $("#pwd2").val();
			          },
			          timeout:6000
			    });
	 		}
 		});
 	});

 	function myfuction(){
 		window.open("popup.php", "_blank", 'width=333px,height=273px,resizable=yes,toolbar=no'); return false;
 	}

 </script>
		<br>
		<div class="panel panel-primary">
    	<div id="spinner" class="panel-heading">Cambiar Contrase&ntilde;a &nbsp;</div>
    	<div class="panel-body">
    	<form id="form1" method="POST" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
		<table width="500" height="100" border="0" align="center" cellpadding="0" cellspacing="3"  class="tblfrm" > 
			<tr>
			  <td height="40" colspan="3" ></td>
		  	</tr>
				<tr>
				<td ><div align="right"> <label>Nueva Contrase&ntilde;a:</label></div></td>
				<td width="100" ><div class="input-group">
					<input id="pwd1" class="form-control glyphicon glyphicon-question-sign" type="password" size="20" maxlength="8" autofocus name="clave1">
				<span id="span" class="input-group-addon glyphicon glyphicon-question-sign" onclick="myfuction()"></span></div></td>
				</tr>
				<tr><td width="130">&nbsp;</td></tr>
				<tr>
				<td ><div align="right"><label>Confirmar Contrase&ntilde;a:</label></div></td>
				<td width="140" >
					<input id="pwd2" name="clave2" class="form-control" type="password" size="20" maxlength="8">
				</td>
				</tr>
				<tr  style="padding-botton:100%;"><td colspan="3" align="center" > 
                     <div align="center">&nbsp;</div></td>
	      		</tr>
	      		<tr  style="padding-botton:100%;"><td colspan="3" align="center" > 
                     <div align="center">&nbsp;</div></td>
	      		</tr>
	      		<tr style="padding-top:5%;"><td width="130">&nbsp;</td></tr>
				  <td colspan="2"><div align="center">
					<input type="submit"  class="btn btn-primary" name="update" value="Cambiar"> 
					</div>
					</td>
				</tr>
    	</table> 
		</form> 
<?php
		
	include("intraFooter.php"); 
?> 
