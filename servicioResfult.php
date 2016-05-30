<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<!--<script type="text/javascript">

		  var url = "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/areas/",

		  function getDatosUser(url){
		  	var datos = Array();
		  	$.ajax({
			  method: "GET",
			  url: url,
	  		  dataType: "json"
		 // data: { name: "John", location: "Boston" }
			})
			  .done(function( msg ) {
			    $.each(msg.items,function(i,item){
			    	datos=item;
			    });
		 	});
			  return datos;
		  }

		  document.ready()
</script>-->
<script type="text/javascript">
	//var url = "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/login/";
	$(document).ready(function(){
		//var url = "https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/areas/";
		$.ajax({
				method: "GET",
				url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/areas/',
				dataType: "json",
				success: function(data) {
				    ///console.log(data);
				    var opciones = "";
				    for (var i=0;  i<= data['items'].length-1; i++) {
					 		var opcion = '<option value="'+data["items"][i].area_id+'">'+data["items"][i].nombre_area+'</option>';
				 		opciones += opcion;
				    }
				    $('#combo').html(opciones);
				}
		});

	});
	try{
		/*$.ajax({
				  method: "GET",
				  url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/login/',
				  dataType: "json",
				  headers:{EMAIL: 'jesus.calero@it.mx', PWD:'969f90547a6d95ffece31490fde53918'},
				success: function(data) {
				    console.log(data);
				},
				error: function(jqXHR,estado){
					console.log(estado);
				}
			});	*/

		function peticionGetData(url,objectData){
			var datos = {};
		  	$.ajax({
				method: "GET",
				url: url,
				dataType: "json",
				success: function(data) {
					//var parsed = data.toArray();
					datos=data;
				},
				error: function(jqXHR,estado){
				}
			});
			return datos;
		}

	}catch(error){
		console.log(error.messages);
	}
</script>
</head>
<body>
<select id="combo"></select>
</body>
</html>
