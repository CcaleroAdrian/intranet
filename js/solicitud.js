//$(document).ready(function(){
	$(window).load(function(){
 		var error = "No hay solicitudes registradas anteriormente";
 		var success = "<?php echo $success; ?>";

 		
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
    	//var mensaje = urlObj.toString();
		/*function getGET(){
		   var loc = document.location.href;
		   var getString = loc.split('?')[1];
		   var GET = getString.split('&');
		   var get = {};//this object will be filled with the key-value pairs and returned.

		   for(var i = 0, l = GET.length; i < l; i++){
		      var tmp = GET[i].split('=');
		      get[tmp[0]] = unescape(decodeURI(tmp[1]));
		   }
		   return get;
		}*/

		var mensaje = getGET();
 		if (mensaje != "") {
 			$("#form").notify(mensaje,'success',{position:"right top"});
 		}
 		

 		if (error != "") {
 		$("#mensaje").notify(error,"info",{position:"right middle"});
		};

		//Ajustar el tamaño de la caja de texto a la longitud del nombre
		var texto=document.getElementById("nombreUser");
    	var txt = texto.value;
   		var tamano= txt.length;
    	tamano *=12; //el valor multiplicativo debe cambiarse dependiendo del tamaño de la fuente
    	texto.style.width=tamano+"px";
 	});

 	function fechas(){
		var y = $('#fecha').val();
		var x = $('#fecha2').val();
		var fecha1 = new Date(x);
		var fecha2 = new Date(y);
		var ONE_DAY = 1000 * 60 * 60 * 24;
		var diffDays = Math.round(Math.abs((fecha1.getTime() - fecha2.getTime())/(ONE_DAY)));
		document.getElementById('diasSolicitados').value = diffDays +1;
    	//document.getElementById('diasSolicitados').val(diffDays +1);
	
		var diasV = $('#Vacaciones').val();//Dias de vaciones disponibles
		var diasS = diffDays +1; 
		if (diasS > 0) {//comprobar que se han solicitado dias
		
			if (diasS > diasV) {//comprobar dias adicionales
			$("#diasAdicionales").val(diasS-diasV);
			$("#diasRestantes").val(0);
			var notificacion = confirm("El número de días solicitados es mayor a los días correspondientes, ¿Desea realizar su solicitud?");
				if(notificacion){
					alert("Se enviara una solicitud de vacaciones extraordinaria");
					//window.location="generarReportePDF.php";
				}
			}else{
			$("#diasAdicionales").val(0);
			$("#diasRestantes").val(diasV-diasS);
			}
		}
}

function ajustar(){
	var texto=document.getElementById("nombreUser");
    var txt = texto.value;
    var tamano= txt.length;
    tamano *=12; //el valor multiplicativo debe cambiarse dependiendo del tamaño de la fuente
    texto.style.width=tamano+"px";
}

function solicitud(ObjetoTR){
		
		var documento = ObjetoTR.cells[7].childNodes[0].nodeValue;
		var opcion="";
		if (documento != "sin archivo") {
			opcion = prompt("SELECIONE LA OPCIÓN A REALIZAR\n1) Descargar documento soporte para usuarios asinados a cliente \n2) Cargar archivo soporte de solicitud \n3) Descargar archivo soporte de la solicitud");
		}else{
			opcion = prompt("SELECIONE LA OPCIÓN A REALIZAR \n1) Descargar documento soporte para usuarios asinados a cliente \n2) Cargar archivo soporte de solicitud");
		}

		
		if (opcion == 1) {//validamos la opcion del usuario (Descargar platilla)
			var cliente =  prompt("Ingresa el nombre o razon social del cliente al cual estas asignado");//solicitamos cliente
			//recabamos la info de la tabla de solicitudes realizadas
			var fecha = ObjetoTR.cells[3].childNodes[0].nodeValue;
			var fecha2 = ObjetoTR.cells[4].childNodes[0].nodeValue;
			var dia = ObjetoTR.cells[5].childNodes[0].nodeValue;
			var nombre = $('#nombreUser').val();
			var url = "generarReportePDF.php?nombre="+nombre+"&dias="+dia+"&fecha1="+fecha+"&fecha2="+fecha2+"&cliente="+cliente+"";
			window.open(url,"_blank");
		}else if (opcion == 2) {
			
			document.getElementById('cargaArchivo').style.visibility= "initial";
			var ID = ObjetoTR.cells[1].childNodes[0].nodeValue;
			$("#idRegistro").val(ID);
		}else if (opcion == 3) {
			var documentoID = ObjetoTR.cells[1].childNodes[0].nodeValue;
			var url = "descargarArchivo.php?id="+documentoID+"";
			window.open(url,"_parent");
			//window.open(url,"_black");
		}else{
			document.getElementById('cargaArchivo').style.visibility= "hidden";
		}
}
//});


