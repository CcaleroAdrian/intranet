<?php
function generaPass(){
    //Definimos una linea con los caracteres que se usaran para formar la contrase�a temporal.
    $cadena = "ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz1234567890.*$";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena); 
     
    //Se define la variable que va a contener la contrase�a
    $pass = "";
    //Se define la longitud de la contrase�a, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=8;
     
    //Creamos la contrase�a
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contrase�a en cada iteraccion del bucle, a�adiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}


