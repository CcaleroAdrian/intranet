$(window).load(function(){
 		var error = "No hay solicitudes registradas anteriormente";
 		
		function getGET(){ 
	 		var url= location.search.replace("?", "");
	    	var arrUrl = url.split("&");
	    	var urlObj={};   
	    	for(var i=0; i<arrUrl.length; i++){
	        	var x= arrUrl[i].split("=");
	        	urlObj[x[0]]=x[1]
	    	}
	    return urlObj;
    	}
		//Ajustar el tamaño de la caja de texto a la longitud del nombre
		/*var texto=document.getElementById("nombre");
    	var txt = texto.value;
   		var tamano= txt.length;
    	tamano *=12; //el valor multiplicativo debe cambiarse dependiendo del tamaño de la fuente
    	texto.style.width=tamano+"px";*/
});

 	

function descarga(object){
	var nombreDoc = object.nombre;
	var idRegistro = object.id;

	if (nombreDoc == 'cargar documento') {
		document.getElementById('cargaArchivo').style.visibility= "initial";
		$("#idRegistro").val(idRegistro);
	}else{
		var url = "descargarArchivo.php?id="+idRegistro+"";
		window.open(url,"_parent");
	}
}

function comentariosPermiso(){
	var opcion = document.getElementById('categoria').selectedIndex;
	var eleccion = opcion
	if (true) {}
}

function fechas(){
	var y = $('#fecha1').val();
	var x = $('#fecha2').val();
	
	var fecha1 = new Date(x);
	var fecha2 = new Date(y);
	var ONE_DAY = 1000 * 60 * 60 * 24;
	var diffDays = Math.round(Math.abs((fecha1.getTime() - fecha2.getTime())/(ONE_DAY)));
	document.getElementById('diasSolicitados').value = diffDays +1;
}

function motivos(){
	var opcion = document.getElementById('categoria').value;
	if (opcion == 'PERSONAL') {
		document.getElementById("etiqueta").style.display = "block";
		document.getElementById("motivo").style.display = "block";
	}else{
		document.getElementById("etiqueta").style.display = "none";
		document.getElementById("motivo").style.display = "none";
	}
}
