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
	swal({   title: "SOLICITUD DE VACACIONES",
				   text: "<span style='color:#000099'>¿Desea rechazar la solicitud de vacaciones?</span>",
				   imageUrl: "intraImg/logoITWfinal.png",
				   html:true,
				   showCancelButton: true,
				   confirmButtonColor: " #337ab7",
				   cancelButtonColor: "#ff3333",
				   confirmButtonText: "Rechazar vacaciones",
				   cancelButtonText: "Cancelar",
				   closeOnConfirm: false,
				   closeOnCancel: false
				}, 
				function(isConfirm){ 
				  	if (isConfirm) {
				  	  var opcion = 2;
				  		swal({title:"SOLICITUD RECHAZADA",
				  		  text:"<span style='color:#000099'>El estatus de la solicitud esta siendo guardada.</span>",
				  		  imageUrl: "intraImg/logoITWfinal.png",
				  		  html:true,
				  		  confirmButtonColor: " #337ab7",
				  		  showConfirmButton:false,
				  		  timer:3000
				  		}); 

						$.post("procesarSolicitudes.php",{ID:id,OPCION:opcion,PERFIL:perfil})
							.done(function(data){ 
								if (data != "") {
									swal({title: "CONFIRMACIÓN",
										text: "<span style='color:#000099'>El estatus de la solicitud se guardo con exito.<br>En breve el usuario sera notificado</span>",
										imageUrl: "intraImg/logoITWfinal.png",
										html:true,
										timer:5000,
										showConfirmButton:false
										});	
									//mostrarSolicitud();	
									//console.log(data);							
								}else{
									swal({title: "ERROR",
										text: "<span style='color:#F8BB86'>Hubo un error al guardar el estatus de la solicitud. Favor de intentarlo más tarde.</span>",
										imageUrl: "intraImg/logoITWfinal.png",
										html:true,
										timer:4000,
										showConfirmButton:false
									});
								}
							});

				  	}else{
				  		swal.close();
				  	}
				});
}

function aceptar(id,perfil){
	swal({   title: "SOLICITUD DE VACACIONES",
				   text: "<span style='color:#000099'>¿Desea aceptar la solicitud de vacaciones?</span>",
				   imageUrl: "intraImg/logoITWfinal.png",
				   html:true,
				   showCancelButton: true,
				   confirmButtonColor: " #337ab7",
				   cancelButtonColor: "#ff3333",
				   confirmButtonText: "Aprovar vacaciones",
				   cancelButtonText: "Cancelar",
				   closeOnConfirm: false,
				   closeOnCancel: false
				}, 
				function(isConfirm){ 
				  	if (isConfirm) {
				  	var opcion = 1;
				  		swal({title:"SOLICITUD APROBADA",
				  		  text:"<span style='color:#000099'>El estatus de la solicitud esta siendo guardada.</span>",
				  		  imageUrl: "intraImg/logoITWfinal.png",
				  		  html:true,
				  		  confirmButtonColor: " #337ab7",
				  		  showConfirmButton:false,
				  		  timer:3000
				  		}); 

						$.post("procesarSolicitudes.php",{ID:id,OPCION:opcion,PERFIL:perfil})
							.done(function(data){
								if (data != "") {
									swal({title: "CONFIRMACIÓN",
										text: "<span style='color:#000099'>El estatus de la solicitud se guardo con exito.<br>En breve el usuario sera notificado</span>",
										imageUrl: "intraImg/logoITWfinal.png",
										html:true,
										timer:5000,
										showConfirmButton:false
									});	
									//$.get('submen_SolicitudesVacaciones_Recibidas.php',{pagina:0});								
								}else{
									swal({title: "ERROR",
										text: "<span style='color:#F8BB86'>Hubo un error al guardar el estatus de la solicitud. Favor de intentarlo más tarde.</span>",
										imageUrl: "intraImg/logoITWfinal.png",
										html:true,
										timer:4000,
										showConfirmButton:false
									});
								}
						});
				  	}else{
				  		swal.close();
				  	}
				  	mostrarSolicitud();
				});
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
				   text: "<span style='color:#000099'>¿Desea solicitar días de vacaciones adicionales?</span>",
				   imageUrl: "intraImg/logoITWfinal.png",
				   html:true,
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
				  		  text:"<span style='color:#000099'>Tú solicitud esta siendo guardada.</span>",
				  		  imageUrl: "intraImg/logoITWfinal.png",
				  		  html:true,
				  		  confirmButtonColor: " #337ab7",
				  		  showConfirmButton:false,
				  		  timer:2000
				  		}); 
				  	var data = {ID_USR:id,FECHAI:$('#fecha').val() ,FECHAF:$('#fecha2').val(),DIASC:$('#Vacaciones').val(),
						DIASSOC:$('#diasSolicitados').val(),DIASAD:$('#diasAdicionales').val(),DIASRES:$('#diasRestantes').val(),LIDER:lider}
					$.post('procesarVacaciones.php',data);
						var vacaciones = parseInt(data);
						document.getElementById('formulario').reset();
						if (vacaciones != 0 || vacaciones != "") {
								$.ajax({
									    method: "POST",
									    url: "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/vacaciones/",
									    dataType: "json",
									    timeout: 6000,
									    headers:{VACACIONES:vacaciones,ID:id} })
										.done(function(data, textStatus, jqXHR){
											console.log("datad"+ata);
											console.log("textStatus"+textStatus);
											console.log("jqXHR"+jqXHR);
									    });
								swal({title: "CONFIRMACIÓN",text: "<span style='color:#000099'>solicitud de vacaciones, registrada exitosamente.</span>",imageUrl: "intraImg/logoITWfinal.png",html:true,timer:4000,showConfirmButton:false});									
						}else{
							swal({title: "ERROR",text: "<span style='color:#F8BB86'>Hubo un error al registrar su solicitud. Favor de intentarlo más tarde.</span>",imageUrl: "intraImg/logoITWfinal.png",html:true,timer:4000,showConfirmButton:false});
						}

						consultarInfo();//consulta de vacaciones

				  } else{
				  	swal({title:"SOLICITUD CANCELADA",
				  	text: "<span style='color:#F8BB86'>Tú solicitud extraordinaria fué cancelada.<span style='color:#F8BB86'>",
				  	imageUrl: "intraImg/logoITWfinal.png",
				  	html:true,
				  	confirmButtonColor: " #337ab7",
				    confirmButtonText: "OK"
				  	});
				  	//Reseteo de los campos
				  	document.getElementById('formulario').reset();
				  	consultarVacaciones();
				  	//document.getElementById('diasSolicitados').value="";
				  	//document.getElementById('diasRestantes').value= "";
				  	//document.getElementById('diasAdicionales').value= "";
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