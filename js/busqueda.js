function busqueda(opcion){
		/*$("#filtroTabla").keypress(function(event){
			event.preventDefault();
		});*/
			var xmlhttp;
			var nombre = document.getElementById('filtroTabla').value;
			var op = opcion.opcion;
			var id = opcion.id;

			if(nombre == ''){
			return;
			}

			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){

				document.getElementById("cuerpo").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","procesarBusqueda.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("q="+nombre+"&b="+op+"&id="+id); 
}

function rechazar(id){
	var opcion = confirm('¿Desea rechazar la solicitud de vacaciones?');
	if (opcion) {
		var url = "procesarSolicitudes.php?id="+id+"&opcion=2";
		window.open(url,"_blank");
	}
}

function aceptar(id){
	var opcion = confirm('¿Desea aceptar la solicitude de vacaciones?');
	if (opcion) {
		var url = "procesarSolicitudes.php?id="+id+"&opcion=1";
		window.open(url,"_blank");
	}
}

function solicitud(id){
	var url = "evidenciaVacaciones.php?id="+id+"";
	window.open(url,"_blank");
}

