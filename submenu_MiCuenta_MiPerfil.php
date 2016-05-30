<?php   
	include("intraHeader.php");   
		
	if ( $USUARIO == "" OR  $USUARIO == null ) { 
		header('Location: index.php');
	}

  $AREA;
  $ID_USR;

	$error = "";
	$blnOk = true;


 ?> 

<script type="text/javascript">
  function guia(){
   document.getElementById('tutotial').style.visibility= "initial";
  }

  function cerrar(){
   document.getElementById('tutorial').style.visibility= "hidden";
  }
</script>
<script type="text/javascript">
  var url = 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/empleados/';
  $(document).ready(function(){


    var id = "<?php echo $ID_USR; ?>";
    var data = {ID: id};
    cargarDatos(data);

    
    $('#form').on('submit',function(event){
      event.preventDefault();
    var header = {
        EMPLEADO_ID: id,
        ESTADO_CIVL_ID: $('#estado_civl_id').val(),
        TELEFONO:  $('#telefono').val(),
        CELULAR:$('#celular').val(),
        EMAIL_2: $('#email_2').val(),
        ESTADO_DOMICILIO_ID: $('#estado_domicilio_id').val(),
        CIUDAD_DOMICILIO_ID: $('#ciudad_domicilio_id').val(),
        DELEGACION_ID:  $('#delegacion_id').val(),
        COLONIA:  $('#colonia').val(),
        CALLE:  $('#calle').val(),
        CP:  $('#cp').val(),
        NUM_EXTERIOR:  $('#num_exterior').val(),
        NUM_INTERIOR: $('#num_interior').val()
    }  
    console.log(header);
    console.log('<br>EREALIZE ARRAY'+$(this).serializeArray());
      $.ajax({
          method:'POST',
          url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/empleados/',
          dataType: 'json',
          headers:$("#form").serialize(),
          beforeSend: function() {
            var div = document.getElementById('mensaje');
            var spinner = new Spinner(opts).spin(div);
            $('html, body').animate( {scrollTop : 0}, 800 );
          },
          success: function(data) {
            console.log(data);
            swal({
              title: "Confirmacion",
              text: "Información actualizada correctamente",
              type: "success",
              showConfirmButton:false,
              timer:3000
              });
            $( ".spinner" ).remove();
            cargarDatos(data);
          },
          error:function(jqXHR,textStatus,errorMessage){
            console.log(textStatus);
            console.log(errorMessage);
            console.log(jqXHR);
            $( ".spinner" ).remove();
          },
          timeout:6000
      });
    });

    /** CARGARDATOS
      *
      * @Descripcion: Funcion para realizar la consulta y carga de datos
      *                del perfil de usuario.
      * @Parametros: ID de usuario.
      * @Retur: Array con los datos del usuario
      **/
    function cargarDatos(data){
      
      /** DATOS USARIO
        * Realiza peticion a servicio RestFul para traer los datos del USUARIO
        *
        * @return: Retorna un array con los datos del usuario
        * 
      **/
      $.ajax({
        method: "GET",
        url: url,
        dataType: "json",
        headers:data,
        beforeSend:function(){
          var div = document.getElementById('mensaje');
          var spinner = new Spinner(opts).spin(div);
        },
        success: function(data) {
          $('#email_1').val(data['email_1']);
          $('#empleado_id').val(data['empleado_id']);
          $('#nombre').val(data['nombre']);
          $('#apellido_materno').val(data['apellido_materno']);
          $('#apellido_paterno').val(data['apellido_paterno']);
          $('#fecha_nacimiento').val(data['fecha_nacimiento']);
          $('#estado_civl_id').val(data['estado_civl_id']);
          $('#telefono').val(data['telefono']);
          $('#celular').val(data['celular']);
          $('#email_2').val(data['email_2']);
          $('#estado_domicilio_id').val(data['estado_domicilio_id']);
          $('#ciudad_domicilio_id').val(data['delegacion_id']);
          $('#delegacion_id').val(data['delegacion_id']);
          $('#colonia').val(data['colonia']);
          $('#calle').val(data['calle']);
          $('#cp').val(data['cp']);
          $('#num_exterior').val(data['num_exterior']);
          $('#num_interior').val(data['num_interior']);
          $('#fecha_antiguedad').val(data['fecha_antiguedad']);
          $('#area_id').val(data['area_id']);
          $('#email').val(data['email_1']);
          $('#LiderID').val(data['area_id']);
          $('#ubicacion').val(data['ubicacion']);

          var vacaciones = parseInt(data['vacaciones']);
          if (vacaciones < 1) {
            vacaciones = 0;
            $('#vacaciones').val(vacaciones);
          }else{
            $('#vacaciones').val(vacaciones);
          }
          $( ".spinner" ).remove();
        }
      }); 

      /** AREAS
        *
        *Realiza peticion a servicio RestFul para traer lista de AREAS 
        *
        *@return: Retorna un array con los datos(area_id,nombre)
        *          y los añade en un tag "SELECET"
      **/
      $.ajax({
        method: "GET",
        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/areas/',
        dataType: "json",
        success: function(data) {
          var areas = "";
          for (var i=0;  i<= data['items'].length-1; i++) {
              var opcion = '<option value="'+data["items"][i].area_id+'">'+data["items"][i].nombre_area+'</option>';
              areas += opcion;
          }
          $('#area_id').html(areas);
        }
      });

      /** ESTADOS
        *
        *Realiza peticion a servicio RestFul para traer lista de ESTADOS dadas de alta en el sistema
        *
        *@return: Retorna un array con los datos(estado_id,nombre)
        *          y los añade en un tag "SELECET"
      **/
      $.ajax({
        method: 'GET',
        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/estado/',
        dataType: 'json',
        success: function(data) {
          var estados = "";
          for (var i=0;  i<= data['items'].length-1; i++) {
              var opcion = '<option value="'+data["items"][i].estado_id+'">'+data["items"][i].nombre+'</option>';
              estados += opcion;
          }
          $('#estado_domicilio_id').html(estados);
        }
      });

      /** CIUDADES
        *
        *Realiza peticion a servicio RestFul para traer lista de Ciudades dadas de alta en el sistema
        *
        *@return: Retorna un array con los datos(ciudad_id,nombre)
        *          y los añade en un tag "SELECET"
      **/
      $.ajax({
        method: 'GET',
        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/ciudad/',
        dataType: 'json',
        success: function(data) {
          var ciudades = "";
          for (var i=0;  i<= data['items'].length-1; i++) {
              var opcion = '<option value="'+data["items"][i].ciudad_id+'">'+data["items"][i].nombre+'</option>';
              ciudades += opcion;
          }
        }
      });

      /** DELEGACIONES
        *
        *Realiza peticion a servicio RestFul para traer lista de Delegacion dadas de alta en el sistema
        *
        *@return: Retorna un array con los datos(delegacion_id,delegacion)
        *          y los añade en un tag "SELECET"
      **/
      $.ajax({
        method: 'GET',
        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/delegacion/',
        dataType: 'json',
        success: function(data) {
          var opciones = "";
          for (var i=0;  i<= data['items'].length-1; i++) {
              var opcion = '<option value="'+data["items"][i].delegacion_id+'">'+data["items"][i].delegacion+'</option>';
              opciones += opcion;
          }
          $('#delegacion_id').html(opciones);
          $('#ciudad_domicilio_id').html(opciones);
        }
      });

      /** RESPONSABLE DE AREA
        *
        *Realiza peticion a servicio RestFul para traer lista de coordinadores de area
        *
        *@return: Retorna un array con los datos(area_id,nombre)
        *          y los añade en un tag "SELECET"
      **/
      $.ajax({
        method: 'GET',
        url: 'https://apex-a261292.db.us2.oraclecloudapps.com/apex/itw/responsable/',
        dataType: 'json',
        success: function(data) {
          var ciudades = "";
          for (var i=0;  i<= data['items'].length-1; i++) {
              var opcion = '<option value="'+data["items"][i].area_id+'">'+data["items"][i].nombre+'</option>';
              ciudades += opcion;
          }
          $('#LiderID').html(ciudades);
        }
      });
    }
  });


    
</script>

<form id="form" enctype="multipart/form-data">
  <h3>Mi perfil</h3>
  <div class="panel panel-primary">
    <div id="mensaje" class="panel-heading">INFORMACIÓN BÁSICA <a id="tutorial" href="" onclick="mostrarTuto()"><i class="fa fa-info-circle fa-lg" style="color: white;"></i></a></div>
    <div class="panel-body">
      <table class="table-resposive">
        <tr>
          <td width="5"></td>
          <td><label for="usrIntranet">Usuario intranet:</label></td>
          <td><input  align="left" class="textboxBloqueado" type="text" id="email_1" size="30" maxlength="50" readonly ></td>
          <td>&nbsp;</td>
          <td width="5">
            <label>ID:</label>
          </td>
          <td>  
            <input class="textboxBloqueado" id="empleado_id" name="EMPLEADO_ID" type="text" size="30" readonly></input>
          </td>
        </tr>
        <tr>
          <td width="5"></td>
          <td><label>Nombres(s):</label></td>
          <td><input align="left"  class="textboxBloqueado" type="text" id="nombre" size="30" maxlength="30" readonly  ></td>
          <td width="5"></td>
          <td><label>Apellido Paterno:</label></td>
          <td><input align="left"  class="textboxBloqueado" type="text" id="apellido_paterno" size="30" maxlength="30" readonly ></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"></td>
          <td><label>Apellido Materno:</label></td>
          <td><input align="left"  class="textboxBloqueado" style="width:119px" type="text" id="apellido_materno" size="30" maxlength="30" readonly  ></td>
          <td width="5"></td>
          <td><label>Fecha de nacimiento:</label></td>
          <td><input align="left"  class="textboxBloqueado" type="text" id="fecha_nacimiento" size="10" maxlength="10" readonly></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Estado civil:</label></td>
          <td><Select  id="estado_civl_id" name="ESTATO_CIVL_ID"  class="form-control" > 
          <option value="1" >CASADO</option>
          <option value="2" >DIVORCIADO</option>
          <option value="3" >SOLTERO</option>
          <option value="4" >UNION LIBRE</option>
          <option value="5" >VIUDO</option>
          </select></td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Tel&eacute;fono personal:</label></td>
          <td><input align="left"  class="textboxBlanco" name="TELEFONO" type="tel" id="telefono" size="10" maxlength="12"  ></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Celular personal:</label></td>
          <td><input class="textboxBlanco" name="CELULAR" type="tel" id="celular" size="10" maxlength="12" ></td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
           <td><label>Email personal:</label></td>
          <td style="width:10px"><input align="left"  class="textboxBlanco" name="EMAIL_2" type="email" id="email_2" size="20" maxlength="50" ></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Estado:</label></td>
          <td> 
            <select id="estado_domicilio_id" name="ESTADO_DOMICILIO_ID" class="form-control"></select>
          </td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Ciudad:</label></td>
          <td><select id="ciudad_domicilio_id" class="form-control" name="CIUDAD_DOMICILIO_ID"></select></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Delegaci&oacute;:</label></td>
          <td> 
            <select id="delegacion_id" name="DELEGACION_ID" class="form-control"></select>
          </td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Colonia:</label></td>
          <td><input class="textboxBlanco" type="text" id="colonia" name="COLONIA"></input></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Calle:</label></td>
          <td> 
            <input class="textboxBlanco" type="text" id="calle" name="CALLE"></input>
          </td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>CP:</label></td>
          <td><input class="textboxBlanco" type="text"  id="cp" name="CP"></input></td>
          <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>N&uacute;mero Exterior:</label></td>
          <td> 
            <input class="textboxBlanco" type="text" id="num_exterior" name="NUM_EXTERIOR"></input>
          </td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>N&uacute;mero Interior:</label></td>
          <td><input class="textboxBlanco" type="text" name="NUM_INTERIOR" id="num_interior"></input></td>
          <td></td>
        </tr>
      </table>     

    </div>
  </div>
 <div class="panel panel-primary">
  <div class="panel-heading">INFORMACIÓN LABORAL</div>
    <div class="panel-body">
    <table class="table-responsive">
      <tr>
        <td width="5"></td>
        <td><label>Fecha de ingreso</label></td>
        <td><input class="textboxBloqueado" type="text" id="fecha_antiguedad" size="10" maxlength="10" readonly></td>
        <td width="5"></td>
         <td>&nbsp;</td>
        <td><label>Días de vacaciones</label></td>
        <td><input align="left"  class="textboxBloqueado" type="text" id="vacaciones" size="2" maxlength="3" readonly></td>
        <td></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
        <td><label>Email de oficina</label></td>
        <td><input align="left"  class="textboxBlanco" type="text" id="email" size="20" maxlength="60" readonly></td>
         <td>&nbsp;</td>
        <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
        <td><label>Ubicaci&oacute;n de Oficina</label></td>
        <td><textarea cols="33" class="textboxBlanco" id="ubicacion" name="UBICACION" align="left"></textarea></td>
        <td></td>
      </tr>
      <tr>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Responzable de asignación:</label></td>
          <td><Select  id="LiderID" class="form-control" style=" width:200px" disabled>
          </select></td>
          <td width="25">&nbsp;</td>
          <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red;"></span></td>
          <td><label>Área o Departamento:</label></td>
          <td><Select  id="area_id" class="form-control" style="width:100px" disabled></select>
          </td>
      </tr>
      <tr>
        <td width="5"><span class="glyphicon glyphicon-asterisk" style="color:red"></span></td>
        <td colspan="4"><label style="color:red;">Datos modificables.</label></td>
        <td height="20" colspan=""></td>
         <td>&nbsp;</td>
        <td>&nbsp;</td><td colspan="">&nbsp;</td>
        <td colspan="2"></td>
        <td></td>
      </tr>
    </table>
    </div>
 </div>
  <div align="center"><input type="submit" align="center" class="btn btn-primary" value="Actualizar"/></div>
  <div>&nbsp;</div>
</form>
<?php
	include("intraFooter.php"); 
?> 
