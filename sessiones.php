<?php
  $USR = isset($_POST['USR']) ? trim(json_decode($_POST['USR'])) : null ;
  $ID = isset($_POST['ID']) ? trim(json_decode($_POST['ID'])) : null ;
  $AR = isset($_POST['AREA']) ? trim(json_decode($_POST['AREA'])) : null ;

  $objsesion = new Sesion();
  $objsesion->init();
  $objsesion->set('USUARIO',$USR);
  $objsesion->set('IDUSUARIO',$ID);
  $objsesion->set('AREAID',$AR); 

?>