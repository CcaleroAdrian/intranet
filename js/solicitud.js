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
		var texto=document.getElementById("nombreUser");
    	var txt = texto.value;
   		var tamano= txt.length;
    	tamano *=12; //el valor multiplicativo debe cambiarse dependiendo del tamaño de la fuente
    	texto.style.width=tamano+"px";
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

