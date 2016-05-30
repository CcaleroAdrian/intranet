function peticionGet(url){
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

function peticionGetData(url,objectData){
	var datos = {};
	  	$.ajax({
			method: "GET",
			url: url,
			dataType: "json",
		  	headers:objectData,
			success: function(data) {
				datos = data;
			},
			error: function(jqXHR,estado){
			 	datos={};
			}
		});	
	return datos;
}

function postUpdate(url,data){
	var datos = Array();
	  	$.ajax({
		  method: "POST",
		  url: url,
		  dataType: "json",
		  data: data
		})
		  .done(function( msg ) {
		    $.each(msg.items,function(i,item){
		    	datos=item;
		   });
		});
	return datos;
}