<?php
require 'clases/actionsDB.php';
$ID= $_POST['id'];
$OPCION = $_POST['opcion'];
$objectOperaciones = new actionsDB();

switch ($OPCION) {
	case 1:
		$nombre = $objectOperaciones->verNombre($ID);
		if ($nombre != -1 OR $nombre != 0) {
			foreach ($nombre as $key) {
				$documento = $key['documento'];
			}
			if ($documento == "cargar documento") {
				echo "<script>
					document.getElementById('cargaArchivo').style.visibility= 'initial';
					$('#idRegistro').val(".$ID.");
				</script>";
			}else{
				echo "<script>
					var url = 'descargarArchivo.php?id='+idRegistro+'';
					window.open(url,'_parent');
				 </script>";
			}
		}

		break;
	case 2:
		
		break;
	default:
		break;
}

?>