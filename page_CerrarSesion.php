
<?php

require 'clases/sesion.php';
$objses = new Sesion();
$objses->init();
$objses->destroy();

?> 
 <link rel="stylesheet" type="text/css" href="intraCss/sweetalert.css"/>
 <link rel="shortcut icon" type="image/gif" href="intraImg/animated_favicon1.gif" />
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
 <script type="text/javascript" src="js/sweetalert.min.js"></script>
 
<script type="text/javascript">
	$(document).ready(function(){
		swal({
			title: "Confirmacion",
			text: "<span style='color:#000099'>Ha finalizado la sesion en la Intranet de ITW.</span>",
			imageUrl: "intraImg/logoITWfinal.png",
			html:true,
			showCancelButton: false,
			confirmButtonText: "Continuar",
			confirmButtonColor: " #337ab7",
			closeOnConfirm: false,
			timer:4000
			},
			function(isConfirm){ 
				  if (isConfirm) {
				  	window.location.href = "../intranet/";	  
				  }
			});
	});
</script>