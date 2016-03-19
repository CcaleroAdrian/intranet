function busqueda(opcion){ 
			var xmlhttp;
			var nombre = document.getElementById('filtroTabla').value;
			var op = opcion.opcion;
			var id = opcion.id; 

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
			xmlhttp.send("nombre="+nombre+"&opcion="+op+"&id="+id); 
}

function rechazar(id,perfil){
	var opcion = confirm('¿Desea rechazar la solicitud de vacaciones?');
	if (opcion) {
		var url = "procesarSolicitudes.php?id="+id+"&opcion=2&perfil="+perfil+"";
		window.open(url,"_blank");
	}
}

function aceptar(id,perfil){
	var opcion = confirm('¿Desea aceptar la solicitude de vacaciones?');
	if (opcion) {
		var url = "procesarSolicitudes.php?id="+id+"&opcion=1&perfil="+perfil+"";
		window.open(url,"_blank");
	}
}

function solicitud(id){
	var url = "evidenciaVacaciones.php?id="+id+"";
	window.open(url,"_blank");
}

function fechas(){
		var y = $('#fecha').val();
		var x = $('#fecha2').val();
		var fecha1 = new Date(x);
		var fecha2 = new Date(y);
		var ONE_DAY = 1000 * 60 * 60 * 24;
		var diffDays = Math.round(Math.abs((fecha1.getTime() - fecha2.getTime())/(ONE_DAY)));
		document.getElementById('diasSolicitados').value = diffDays +1;
    	//document.getElementById('diasSolicitados').val(diffDays +1);
		var acccion = "";
		var diasV = $('#Vacaciones').val();//Dias de vaciones disponibles
		var diasS = diffDays +1; 
		if (diasS > 0) {//comprobar que se han solicitado dias
		
			if (diasS > diasV) {//comprobar dias adicionales
				$("#diasAdicionales").val(diasS-diasV);
				$("#diasRestantes").val(0);

				swal({   title: "SOLICITUD DE VACACIONES",
				   text: "¿Desea solicitar días de vacaciones adicionales?",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: " #337ab7",
				   cancelButtonColor: "#ff3333",
				   confirmButtonText: "Si, Deseo solicitar",
				   cancelButtonText: "No, Deseo solicitar",
				   closeOnConfirm: false,
				   closeOnCancel: false
				}, 
				function(isConfirm){ 
				  if (isConfirm) {
				  	  
				  	swal({title:"GUARDANDO SOLICITUD",
				  		  text:"Tú solicitud esta siendo guardada.",
				  		  type:"info",
				  		  confirmButtonColor: " #337ab7",
				  		  showConfirmButton:false,
				  		  timer:2000
				  		}); 
				  	$('#btnSubmit').click();

				  } else{
				  	swal({title:"SOLICITUD CANCELADA",
				  	text: "Tú solicitud extraordinaria fué cancelada.",
				  	type: "info",
				  	confirmButtonColor: " #337ab7",
				    confirmButtonText: "OK"
				  	});
				  	//Reseteo de los campos
				  	document.getElementById('formulario').reset();
				  }
				});
			
			} else {
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

function descarga(id){
	var xmlhttp;
 	var idRegistro = id;
 	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
			
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("table_Solicitudes").innerHTML=xmlhttp.responseText;
			}
		}
	xmlhttp.open("POST","acciones.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id="+idRegistro+"&opcion=1"); 
}