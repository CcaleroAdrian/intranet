<?php

require 'clases/sesion.php';
$objses = new Sesion();
$objses->init();
$objses->destroy();

header('Location: index.php');

?>