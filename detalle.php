<?php
require 'clases/actionsDB.php'; 
$id = isset($_GET['id']) ? trim($_GET['id']) : "";
$opcion = isset($_GET['opcion']) ? trim($_GET['opcion']) : "";
$objOperaciones = new ActionsDB();
$diasLey = 0;
	
//COnsultamos la informacion del usuario
$usr = $objOperaciones->getDatosPerfilID($id); 
if ($usr != 0 || $usr != -1)   {
  foreach ($usr as $key) {
  $fechaIngreso = $key['fechaIngreso'];
  $diasLey = $key['DiasLey'];
  }

  if ($diasLey < 0) {
    $diasLey = 0;
  }
}


//Consultamos la ultima solicitud realizada
$registro = $objOperaciones->verUltimSolicitudID($id);

//Consultamos todas las solicitudes realizadas por este usuario
$dat = $objOperaciones->verSolicitudes($id);
if ($dat != 0 OR $dat != -1) {
   foreach ($dat as$val) {
    $fechaSoli =$val['fecha'];
    $dias =$val['dias'];
    $adicionales =$val['adicionales'];
    $diasRestantes =$val['diasRestantes'];
    $diasCorrespondientes =$val['diasCorrespondientes'];
    $fechaInicio =$val['fecha1'];
    $fechaFinal =$val['fecha2'];
    $aprobacionA =$val['aprobacion1'];
    $aprobacionB =$val['aprobacion2'];
    }
}


	$fecha1 = date('Y-m-d',strtotime($fechaInicio));
	$fecha2 = date('Y-m-d',strtotime($fechaFinal));
 
?>
 
<!DOCTYPE html>
<html style="height: 100%; width: 100%;">
<head>
	<title>Detalle</title>
	<link rel="shortcut icon" type="image/gif" href="intraImg/animated_favicon1.gif" >
	<link href="intraCss/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href="intraCss/intraItw.min.css" rel="stylesheet" type="text/css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="intraCss/bootstrap/js/jquery.js"></script>
  <script type="text/javascript" src="intraCss/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/busqueda.js"></script>
  <script type="text/javascript" src="js/spin.min.js"></script>
</head>
<style type="text/css">
	.disabled:hover{ 
		color:grey;
	}
  body{
    background-color:transparent;
    margin: 0;
    padding: 0;
  }
</style>
<script type="text/javascript">
var opts = {
        lines: 13, // The number of lines to draw
      length: 23, // The length of each line
      width: 15, // The line thickness
      radius: 46, // The radius of the inner circle
      scale: 2.5, // Scales overall size of the spinner
      corners: 0.7, // Corner roundness (0..1)
      color: '#e60000', // #rgb or #rrggbb or array of colors
      opacity: 0.20, // Opacity of the lines
      rotate: 85, // The rotation offset
      direction: -1, // 1: clockwise-1: counterclockwise
      speed: 0.5, // Rounds per second
      trail: 85, // Afterglow percentage
      fps: 20, // Frames per second when using setTimeout() as a fallback for CSS
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      className: 'spinner', // The CSS class to assign to the spinner
      top: '65%', // Top position relative to parent
      left: '50%', // Left position relative to parent
      shadow: true, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      position: 'absolute' // Element positioning
};
var user = "<?php echo $id; ?>";
  $(document).load(function(){
    window.close();
  });
  $(document).ready(function(){
    $.ajax({
            method: "GET",
            url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/nombres/",
            dataType: "json",
            timeout: 6000,
            headers:{ID :user},
          beforeSend:function(){
              var div = document.getElementById('mensaje');
              var spinner = new Spinner(opts).spin(div);
          },
          succes:function(data) {
            document.getElementById('nombre').value(data['nombre']);
          }
      });
  });
</script>
<?php   //Codigo para realizar l
  if ($opcion == 1) { ?>
<body style="padding-left: 20px;">

	<div class="panel panel-primary">
    <div class="panel-heading">DATOS GENERALES</div>
    <div class="panel-body">
    	<table>
    		<tr >
    			<td rowspan="8" style="text-align: left;"><i class="fa fa-user fa-5x"></i>&#160;&#160;&#160;</td>
    		</tr>
    		<tr>
    			<td><strong>NOMBRE:</strong></td>
    			<td colspan="4"><input id="nombre" type="text" disabled class="textboxBloqueado"></input></td>
    		</tr>
    		<tr>
    			<td><strong>FECHA INGRESO:</strong></td>
    			<td><input type="text" class="textboxBloqueado" disabled value="<?php echo $fechaIngreso ;?>"></input></td>
    			<td><strong>D&iacute;as Ley</strong></td>
    			<td><input type="text" class="textboxBloqueado" disabled value="<?php echo $diasLey;?>"></input></td>
    		</tr>
    		<tr><td colspan="4">&#160;</td></tr>
    		<tr>
    			<td colspan="4" style="text-align: center;"><strong>ULTIMO PERIODO VACACIONAL</stron></td>
    		</tr>
    		<tr>
    			<td style="text-align: center;">Fecha</td>
    			<td style="text-align: center;">D&iacute;as Solictados</td>
    			<td style="text-align: center;">D&iacute;as Restantes</td>
    			<td style="text-align: center;">D&iacute;as Adicionales</td>
    		</tr> 
    		<tr>
    			<td><input type="text" style="text-align: center;" class="textboxBloqueado" disabled value="<?php echo $fechaSoli ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $dias; ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $diasRestantes; ?>"></input></td>
    			<td><input type="text" style="text-align: center;" size="15" class="textboxBloqueado" disabled value="<?php echo $adicionales; ?>"></input></td>
    		</tr> 			
    	</table>
    	</strong>
    	</div>
    </div>
    <div class="panel panel-primary">
    <div class="panel-heading">SOLICITUDES REALIZADAS POR USUARIO</div>
    <div class="panel-body">
    	<table class="table table-bordered" id="table_Solicitudes" style="position: inherit;"> 
			<thead>
			<tr>
				<th>N</th>
				<th>Acci&oacute;n</th>
				<th >Fecha de solicitud</th>
				<th >Fecha inicio</th>
				<th >Fecha fin</th>
				<th >D&iacuteas Solicitados</th>
				<th >D&iacuteas adicionales</th>
				<th>Documento soporte</th>
				<th >Estatus</th>
			</tr>
			</thead>
			<tbody id="jod">
				<?php 
					$nume = 0;
		      		foreach($dat as $row) {
		      			$nume +=1;
			      		//Determinar estutus solicitud
			      		if (($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 1) OR ($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 1) OR ($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 1)) {//pendientes
			      			$Estatus = "PENDIENTE";
			      		}else if (($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 2) OR ($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 2) OR ($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 2)) {//Aceptadas
			      			$Estatus = "APROBADA";
			      		}else if (($row["aprobacion1"] == 3 AND $row["aprobacion1"] == 3) OR ($row["aprobacion1"] == 2 AND $row["aprobacion1"] == 3) OR ($row["aprobacion1"] == 1 AND $row["aprobacion1"] == 3)) {
			      			$Estatus = "RECHAZADA";
			      		}?>
							<tr id="celda">
									<td><?php echo$nume;?></td>
									<td><a href="" onclick="solicitud(<?php echo $row["solicitud_ID"];?>)">Generar reporte</a></td>
									<td><?php echo $row["fecha"]; ?></td>
									<td><?php echo $row["fecha1"]; ?></td>
									<td><?php echo $row["fecha2"]; ?></td>
									<td><?php echo $row["dias"]; ?></td>
									<td><?php echo $row["adicionales"]; ?></td>
									<td><a id="documento" <?php echo($row["documento"] == "cargar documento") ? "class='disabled'" : "href='descargarArchivo.php?id=".$row["solicitud_ID"]."'"; ?> ><?php echo $row["documento"]; ?> </a></td>
									<td><?php echo $Estatus; ?></td>
							</tr>
							<?php
					}		
		      	?>
			</tbody>
		</table>
		</div>
    </div>
    <?php }else{

       //Proceso de actualizacion de datos
      $btn = isset($_POST['guardar']) ? trim($_POST['guardar']) : "";
      $mensaje = "";
      if ($btn == "GUARDAR") {
        $fecha1 = isset($_POST['date1']) ? trim($_POST['date1']) : "";
        $fecha2 = isset($_POST['date2']) ? trim($_POST['date2']) : "";
        $diasC = isset($_POST['diasCorresp']) ? trim($_POST['diasCorresp']) : "";
        $diasS = isset($_POST['diasSolicitados']) ? trim($_POST['diasSolicitados']) : "";
        $diasA = isset($_POST['diasAdicionales']) ? trim($_POST['diasAdicionales']) : "";
        $diasR = isset($_POST['diasRestantes']) ? trim($_POST['diasRestantes']) : "";
        $aprobacionG = isset($_POST['AprobacionGerente']) ? trim($_POST['AprobacionGerente']) : "";
        $aprobacionD = isset($_POST['AprobacionDirector']) ? trim($_POST['AprobacionDirector']) : "";
        //actualizarSolicitudVacaciones($fechaInicial,$fechaFinal,$diasCorrespondientes,$diasSolicitados, $diasAdiconales, $diasRestantes,$aporbacionLider, $aporbacionDirector, $user_ID)
        $actualizacion = $objOperaciones->actualizarSolicitudVacaciones($fecha1,$fecha2,$diasC,$diasS,$diasA,$diasR,$aprobacionG,$aprobacionD,$id);
        if ($actualizacion == true) {
          $mensaje="solicitud actualizada";
          header("Location:submenu_AdminVacaciones.php?mensaje=".$mensaje."");
        }else{
          $mensaje="error al actualizar la modificación de la solicitud, favor de intentarlo mas tarde.";
          header("Location:submenu_AdminVacaciones.php?error=".$mensaje."");
        }
      }


      ?>
  	<script type="text/javascript">
  		var diasAdicionales= "<?php echo $adicionales;?>";
      var user = "<?php echo $id; ?>";
  		if(diasAdicionales == 0) {
  			$('#directorLabel').attr("display","none");
  			$('#directorSelect').attr("display","none");
  		}

      function fechas(){
        var y = $('#date1').val();
        var x = $('#date2').val();
        var fecha1 = new Date(x);
        var fecha2 = new Date(y);
        var ONE_DAY = 1000 * 60 * 60 * 24;
        var diffDays = Math.round(Math.abs((fecha1.getTime() - fecha2.getTime())/(ONE_DAY)));
        document.getElementById('diasSolici').value = diffDays +1;

        var diasV = $('#Vacaciones').val();
        var diasS = diffDays +1; 
        if (diasS > diasV) {//comprobar dias adicionales
          $("#diasAdicionales").val(diasS-diasV);
          $("#diasRestantes").val(0);
        } else {
          $("#diasAdicionales").val(0);
          $("#diasRestantes").val(diasV-diasS);
        }
      }
      $(document).ready(function(){
        $.ajax({
                method: "GET",
                url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/nombres/",
                dataType: "json",
                timeout: 6000,
                headers:{ID :user},
              beforeSend:function(){
                  var div = document.getElementById('mensaje');
                  var spinner = new Spinner(opts).spin(div);
              },
              succes:function(data) {
                $('#nombre').val(data['nombre']);
              }
          });
      });

  	</script>
    <style type="text/css">
      body{
        background-color: transparent;
        /*background-color:rgba(29, 30, 33, 0.95);*/
      }
    </style>
    <div class="panel panel-primary">
   <div class="panel-heading">DATOS GENERALES</div>
   <div class="panel-body">
   		<form name="frmSolicitud" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
   			<table>
   			<tr>
   			<td><label>Nombre:</label></td>
   			<td><input id="nombre" type="text" name="nombre" readonly class="textboxBloqueado" ></input></td>
   			</tr>
   			<tr><td>&#32;</td></tr>
   			<tr>
   			<td><label>Fecha inicial:</label></td>
   			<td><input id="date1" name="date1" type="date" class="textboxBloqueado" name="fechaInicio" value="<?php echo $fecha1; ?>" onchange="fechas()"></input></td>
   			<td><label>Fecha final:</label></td>
   			<td><input id="date2" name="date1" type="date" class="textboxBloqueado" name="fechaFinal" value="<?php echo $fecha2; ?>" onchange="fechas()"></input></td>
   			</tr>
   			<tr><td>&#32;</td></tr>
   			<tr>
   			<td><label>D&iacute;as Correspondientes:</label></td>
   			<td><input id="Vacaciones" type="text" name="diasCorresp"  class="textboxBloqueado" value="<?php echo $diasCorrespondientes; ?>" size="2"  readonly></input></td>
   			<td><label>D&iacute;as Solicitados:</label></td>
   			<td><input id="diasSolici" type="text"  class="textboxBloqueado" name="diasSolicitados" value="<?php echo $dias; ?>" size="2" readonly></input></td>
   			</tr>
   			<tr><td>&#32;</td></tr>
   			<tr>
   			<td><label>D&iacute;as Adicionales:</label></td>
   			<td><input id="diasAdicionales" type="text" name="diasAdicionales" class="textboxBloqueado" value="<?php echo $adicionales; ?>" size="2" readonly></input></td>
   			<td><label>D&iacute;as Restantes:</label></td>
   			<td><input id="diasRestantes" type="text" name="diasRestantes" class="textboxBloqueado" value="<?php echo $diasRestantes; ?>" size="2" readonly></input></td>
   			</tr>
   			<tr><td>&#32;</td></tr>
   			<tr>
   			<td><label>Aprobaci&oacute;n del Gerente:</label></td>
   			<td><select name="AprobacionGerente">
   				<option value="1" <?php echo ($aprobacionA == "1") ?  "selected" : "";  ?>>PENDIENTE</option>
   				<OPTION value="2" <?php echo ($aprobacionA == "2") ?  "selected" : "";  ?>>APROVADA</OPTION>
   				<option value="3" <?php echo ($aprobacionA == "3") ?  "selected" : "";  ?>>RECHAZADA</option>
   			</select></td>
   			<td><label id="directorLabel">Aprobaci&oacute;n del Director:</label></td>
   			<td><select id="directorSelect" name="AprobacionDirector">
   				<option value="1" <?php echo ($aprobacionB == "1") ?  "selected" : "";  ?>>PENDIENTE</option>
   				<OPTION value="2" <?php echo ($aprobacionB == "2") ?  "selected" : "";  ?>>APROVADA</OPTION>
   				<option value="3" <?php echo ($aprobacionB == "3") ?  "selected" : "";  ?>>RECHAZADA</option>
   			</select></td>
   			</tr>
   			<tr><td>&#32;</td></tr>
   		</table>
   		<div style="margin-left: 45%; margin-top: 10px;"><input class="btn btn-primary" type="submit" name="guardar" value="GUARDAR"></input></div>
   		</form>
   		
   </div>
 </div>

    <?php }?>
</body>
</html>