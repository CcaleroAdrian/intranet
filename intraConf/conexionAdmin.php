<?php 


//Configuración para Servidor Local y Remoto


$bd_host = "localhost"; //localhost XD 
$bd_usuario = "root"; //usuario 
$bd_password = ""; //contraseña  
$bd_base = "u212370_intranet"; //Nombre de la db 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 

?> 

