  <?php   
	include("intraHeader.php"); 
	$NumImgIndex = rand( 1 , 4 );  

	if($USUARIO == '' or $USUARIO==null ){
?> 
 
 <script type="text/javascript">
 	$(window).load(function(){
 		var error = "<?php echo isset($_GET['ERROR']) ? trim($_GET['ERROR']) : ''; ?>";
 		if (error != "") {
 		 swal({title: "Confirmacion", text: error, type: "error",timer:3500,showConfirmButton:false});
		};
 	});
 </script>
 
  	<!--Interfaz de login-->	
  		<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
			<tr>
        <td>

		<form id="form1" name="usuario" action="procesa_IniciarSesion.php" method="POST" style="padding:6% 0% 10% 0%;">
         <div class="form-group">
           <span style="color:#4d94ff; padding:0% 0% 0% 40%; font-size:150%;"><b>LOGIN INTRANET<b></span>       
         </div>
          <div class="form-group" align="justify" style="padding:2% 0% 0% 15%;">
            <label  class="col-sm-2 control-label "style="padding-right:17%; color:#4d94ff" align="center">Usuario:</label>
            <div class="col-sm-5 input-group">
            	<span class="input-group-addon">@</span>
            	<input type="email" name="EMAIL" id="usuarioitw" maxlength="80" placeholder="usuario@itw.mx" class="form-control" value="" autofocus autocomplete="off" required/>
            </div>
          </div>
          <div class="form-group" align="justify" style="padding-left:14%;">
            <label class="col-sm-2 control-label" style="padding-right:18%; color:#4d94ff">Contrase&ntilde;a:</label>
            <div class="col-sm-5 input-group" style="padding-left:0%; " >
            	<span class="input-group-addon glyphicon glyphicon-user"></span>
   				<input  class="form-control glyphicon glyphicon-user" name="PWD" type="password" id="pwditw"  maxlength="8" placeholder="Contrase&ntilde;a" required />
            </div>
          </div>
          <div class='col-sm-8'>&nbsp;</div><div class='col-sm-4'>&nbsp;</div>
          <div class="col-sm-5">&nbsp;</div>
          <div class="col-sm-6"> <input type="submit"  class="btn btn-primary" name="enter" id="enter2" value="Iniciar Sesion"/></div>
          <div class="col-sm-7" style="padding:2% 0% 5% 0%;" align="right"><span class="txtRojoPeque"><a href="page_RecuperaPwd.php">&#8226; &iquest;No recuerda su contrase&ntilde;a? </a></span></div>
        </form>
        <td>		
			</tr> 
    	</table>  
		
<?php
	} Else {
?>
	<!--Interfaz despues de hacer login-->
		<div>&nbsp;</div>
		<div style="position:relative; z-index:1;">
			<?php 
			 	include("slider-itw.php"); 
			?>
		</div>

<?php
	}
?>
		
<?php   
	include("intraFooter.php"); 
?> 