<?php

	require'clases/actionsDB.php';  
	require'clases/sesion.php';
	$objsesion = new Sesion();

	$usr = isset($_POST['EMAIL']) ? trim($_POST['EMAIL']) : "" ;
	$pwd = md5(isset($_POST['PWD']) ? trim ( $_POST['PWD'] ) : "");

	$USR = isset($_GET['USR']) ? trim($_GET['USR']) : null ;
  	$ID = isset($_GET['ID']) ? trim($_GET['ID']) : null ;
    $AR = isset($_GET['AREA']) ? trim($_GET['AREA']) : null ;
    $PERFIL = isset($_GET['PERFIL']) ? trim($_GET['PERFIL']) : null ;
    $LIDER = isset($_GET['LIDERAREA']) ? trim($_GET['LIDERAREA']) : null ;
    $NOMBRE = isset($_GET['NOMBRE']) ? trim($_GET['NOMBRE']) : null ;
    $AREAN = isset($_GET['NOMBRE_AREA']) ? trim($_GET['NOMBRE_AREA']) : null ;

    if ($USR != null and $ID != null and $AR != null and $PERFIL != null) {
      	$objsesion->init();
  		$objsesion->set('USUARIO',$USR);
  		$objsesion->set('IDUSUARIO',$ID);
  		$objsesion->set('AREAID',$AR);
  		$objsesion->set('PERFIL_ID',$PERFIL);
  		$objsesion->set('NOMBRE',$NOMBRE);
  		$objsesion->set('AREA',$AREAN);
  		$objsesion->set('LIDER',$LIDER);
    }
 
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="js/spin.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<script type="text/javascript">
	var email = "<?php echo $usr; ?>";
	var pwd ="<?php echo $pwd; ?>";
	var USR;
	var ID;
	var AREA;
	var Headers = {EMAIL: email, PWD:pwd};

	var opts = {
  		lines: 13, // The number of lines to draw
		length: 46, // The length of each line
		width: 20, // The line thickness
		radius: 100, // The radius of the inner circle
		scale: 1.5, // Scales overall size of the spinner
		corners: 0.6, // Corner roundness (0..1)
		color: '#e60000', // #rgb or #rrggbb or array of colors
		opacity: 0.8, // Opacity of the lines
		rotate: 85, // The rotation offset
		direction: -1, // 1: clockwise-1: counterclockwise
		speed: 0.6, // Rounds per second
		trail: 85, // Afterglow percentage
		fps: 20, // Frames per second when using setTimeout() as a fallback for CSS
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		className: 'spinner', // The CSS class to assign to the spinner
		top: '40%', // Top position relative to parent
		left: '45%', // Left position relative to parent
		shadow: true, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		position: 'absolute' // Element positioning
	}


	$(document).ready(function(){
		peticionGetData(Headers);
	});

	function peticionGetData(Headers){
		try{
			$.ajax({
				  method: "GET",
				  url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/login/',
				  dataType: "json",
				  headers: Headers,
				  timeout:6000,
				beforeSend: function( xhr ) {
					var div = document.getElementById('spinner')
					var spinner = new Spinner(opts).spin(div);
				},
				success: function(data) {
				    $.get('procesa_IniciarSesion.php', {USR : data['email_1'], ID : data['empleado_id'], AREA : data['area_id'],PERFIL:data['perfil_id'],NOMBRE_AREA:data['nombre_area'], LIDERAREA:data['lider_area'], NOMBRE:data['nombre']});
				    //console.log(data);
				    //window.location.href = "intranet.itw.mx"; //
				   	window.history.go(-1);
				},
				error: function(jqXHR,estado){
					//console.log(estado);
					window.location.href="?ERROR=Usuario o contraseña incorrecta, favor de verificar credenciales.";
				}
			});
			
		}catch(err){
			window.location.href = "?ERROR=Usuario o contraseña incorrecta, favor de verificar credenciales.";
		}
	}
</script>
<link rel="shortcut icon" type="image/gif" href="intraImg/animated_favicon1.gif" >
<style type="text/css">
	#body{
		background-image: url('../intranet/intraImg/logoITWfinal.jpg');
		width: 100%;
		height: 70%;
		background-repeat: no-repeat;
		margin-left: 20%;
	}
	#spinner{
		margin-top:5%;
		margin-left: 35%;
		font-size: 30px;
		font-family: TIMES ROWMAN;
	}
	#span2{
		margin-left: 20%;
	}
</style>
<body>

	<div id="body"></div>
	<div id="spinner">
		<span>Validando credenciales...</span>
		<br><span id="span2">Por favor espere.</span>
	</div>
</body>
