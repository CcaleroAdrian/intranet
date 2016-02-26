<?php
include("intraHeader.php");
if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}
?>

 <?php
	include("intraFooter.php"); 
?> 