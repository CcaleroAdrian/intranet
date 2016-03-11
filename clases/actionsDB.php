<?php 
include('configDB.php');

class ActionsDB{
	public $objDb; 
	 
	
	// Clase que permite hacer las operaciónes con la bd.
	public function __construct(){
			// Inicializa al instanciar la clase
			$this->objDb = new ConfigDB();
	}
	
	//Función que permite obtener todos los usuarios de la base de datos .
	public function getMenus( $idPerfil ) {
		// Create connection
		$resultado = array();
		$query="SELECT RL.`menuID`,M.icono,M.descripcion from relacionmenuperfil as RL INNER JOIN menu as M on RL.menuID = M.idMenu where RL.`perfilID` ='".$idPerfil."' and M.visible = true";

		$mysqli = $this->objDb->getConnBasic();
		
		if ($mysqli->connect_errno) {
			return -1;  
		}else{
			if (!$consulta = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($consulta->num_rows == 0) { 
					return 0 ; 
				} else {   
					$resultado= array();
					while( $reg = $consulta->fetch_assoc()) {
						$resultado[]= $reg;
					}
					$consulta->free();
					return $resultado ;
				} 
			} 
			$mysqli->close();
		} 
	}

	//Función que permite obtener todos los usuarios de la base de datos.
	public function getSubMenus( $idPerfil , $idMenu) {
		// Create connection
		$resultado = array();
		$query =  "SELECT SM.href,SM.descripcion from relacionperfilsubmenu as RSM INNER JOIN submenu as SM on RSM.submenuID = SM.idSubMenu WHERE RSM.perfilID='".$idPerfil."' AND SM.idMenu ='".$idMenu."' AND SM.visible = true ORDER by SM.posicion ASC" ;
		
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			return -1;  
		}else{
			if (!$consulta = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($consulta->num_rows == 0) { 
					return 0 ; 
				} else {   
					$resultado= array();
					while( $reg = $consulta->fetch_assoc()) {
						$resultado[]= $reg;
					}
					$consulta->free();
					return $resultado ;
				} 
			} 
			$mysqli->close();
		} 
	}
	
	// Función obtiene el usuario , idPerfil y descripción del perfil  de la tabla usuarios si es que existe en BD.
	public function getUsuarioSesion( $usuario , $pwd ){
		$query = "SELECT  lower( trim( usuarios.usrIntranet ) ) as usrIntranet, usuarios.idPerfil as idPerfil , usuarios.idUsuario, trim( perfil.desc ) as descPerfil FROM usuarios, perfil 
				  WHERE lower( trim( usuarios.usrIntranet ) ) = '". strtolower( trim( $usuario ) ) ."' 
				  AND trim(usuarios.pwdIntranet) = trim( MD5('". trim( $pwd ) ."' ) )
				  AND usuarios.idPerfil = perfil.idPerfil  limit 1 ";
		//echo $query;
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) { 
			$res = -1;
		}else{
			if (!$resultado = $mysqli->query($query)) { 
				$res = -1;
			}else {
				if ($resultado->num_rows == 0) {   
					$res = 0;
				} else {  
					$res = $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
				} 
			} 
			$mysqli->close();
		}  
		
		return $res ;
	}
	//funcion para contar registros del directorio
	//Funcion para llenar el directorio de contactos
	public function getDirectorio(){
		$query = "SELECT upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, lower( usuarios.usrIntranet ) as usrIntranet,usuarios.celOfna as celOfna, usuarios.telOfna as telOfna,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal from usuarios";

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {//verificamos conexion a la BD
			return -1; //marcar error en la conexion
		}else{//conexion exitosa
			if (!$resultado = $mysqli->query($query)) {//ejecutamos el query
				return -1; //reporta problemas con el query
			}else {//en caso de obtener resultado
				if ($resultado->num_rows == 0) { //contamos resultados mayores a cero
					return 0 ;//si numero de registros es igual a 0
				} else {//en otro caso lllena el arreglo
					$datos=$resultado->num_rows;
					$users= array();//arreglo a llenar
					while( $usr = $resultado->fetch_assoc()) {//iteramos cada resultado
						$users[]= $usr;//agregamos los resultados al array
					}
					//$resultado->free();
					return $users;
				} 
			} 
			$mysqli->close();
		} 
	}
	
	//Funcion para llenar el directorio de contactos
	public function getDirectorioB($inicio, $TAMANO_PAGINA){
		$query = "SELECT upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, lower( usuarios.usrIntranet ) as usrIntranet,usuarios.celOfna as celOfna, usuarios.telOfna as telOfna,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal from usuarios ORDER BY usuarios.nombre LIMIT ".$inicio.",".$TAMANO_PAGINA;

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {//verificamos conexion a la BD
			return -1; //marcar error en la conexion
		}else{//conexion exitosa
			if (!$resultado = $mysqli->query($query)) {//ejecutamos el query
				return -1; //reporta problemas con el query
			}else {//en caso de obtener resultado
				if ($resultado->num_rows == 0) { //contamos resultados mayores a cero
					return 0 ;//si numero de registros es igual a 0
				} else {//en otro caso lllena el arreglo
					$datos=$resultado->num_rows;
					$users= array();//arreglo a llenar
					while( $usr = $resultado->fetch_assoc()) {//iteramos cada resultado
						$users[]= $usr;//agregamos los resultados al array
					}
					//$resultado->free();
					return $users;
				} 
			} 
			$mysqli->close();
		} 
	}

	//Función que permite obtener todos los usuarios de la base de datos
	public function getAllUsuarios($nombre ="", $INICIO, $TAMANO_PAGINA = 0 ) {
		// Create connection
		$users = array();
		$query = "";
		if ($nombre == "" AND $TAMANO_PAGINA == 0 ) {
			$query =  "SELECT DISTINCT idUsuario,
					lower( usuarios.usrIntranet ) as usrIntranet, upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, usuarios.fechaNacimiento as fechaNacimiento, usuarios.idPerfil as idPerfil, 
					perfil.desc AS facultad , usuarios.idEstatus as idEstatus, estatus.desc AS estado ,  usuarios.idSexo as idSexo , 
					sexo.desc AS genero , usuarios.idCivil as idCivil, estado_civil.desc AS civil , usuarios.direccion as direccion, 
					usuarios.fechaIngreso as fechaIngreso, usuarios.fechaSalida as fechaSalida ,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal, lower( usuarios.emailPersonal ) as emailPersonal, usuarios.telOfna as telOfna, 
					usuarios.celOfna as celOfna, lower( usuarios.emailOfna ) as emailOfna, usuarios.direccionOfna as direccionOfna  
					FROM   usuarios 
					LEFT JOIN perfil ON perfil.idPerfil = usuarios.idPerfil
					LEFT JOIN estatus ON estatus.idEstatus = usuarios.idEstatus
					LEFT JOIN sexo ON sexo.idSexo = usuarios.idSexo 
					LEFT JOIN estado_civil ON estado_civil.idCivil = usuarios.idCivil " ;
		
		}else if($nombre == "" AND $TAMANO_PAGINA != 0) {
			$query =  "SELECT DISTINCT idUsuario,
					lower( usuarios.usrIntranet ) as usrIntranet, upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, usuarios.fechaNacimiento as fechaNacimiento, usuarios.idPerfil as idPerfil, 
					perfil.desc AS facultad , usuarios.idEstatus as idEstatus, estatus.desc AS estado ,  usuarios.idSexo as idSexo , 
					sexo.desc AS genero , usuarios.idCivil as idCivil, estado_civil.desc AS civil , usuarios.direccion as direccion, 
					usuarios.fechaIngreso as fechaIngreso, usuarios.fechaSalida as fechaSalida ,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal, lower( usuarios.emailPersonal ) as emailPersonal, usuarios.telOfna as telOfna, 
					usuarios.celOfna as celOfna, lower( usuarios.emailOfna ) as emailOfna, usuarios.direccionOfna as direccionOfna  
					FROM   usuarios 
					LEFT JOIN perfil ON perfil.idPerfil = usuarios.idPerfil
					LEFT JOIN estatus ON estatus.idEstatus = usuarios.idEstatus
					LEFT JOIN sexo ON sexo.idSexo = usuarios.idSexo 
					LEFT JOIN estado_civil ON estado_civil.idCivil = usuarios.idCivil LIMIT ".$INICIO.",".$TAMANO_PAGINA."" ;
		
		}else if ($nombre != "" AND $TAMANO_PAGINA == 0) {
			$query =  "SELECT idUsuario,
					lower( usuarios.usrIntranet ) as usrIntranet, upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, usuarios.fechaNacimiento as fechaNacimiento, usuarios.idPerfil as idPerfil, 
					perfil.desc AS facultad , usuarios.idEstatus as idEstatus, estatus.desc AS estado ,  usuarios.idSexo as idSexo , 
					sexo.desc AS genero , usuarios.idCivil as idCivil, estado_civil.desc AS civil , usuarios.direccion as direccion, 
					usuarios.fechaIngreso as fechaIngreso, usuarios.fechaSalida as fechaSalida ,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal, lower( usuarios.emailPersonal ) as emailPersonal, usuarios.telOfna as telOfna, 
					usuarios.celOfna as celOfna, lower( usuarios.emailOfna ) as emailOfna, usuarios.direccionOfna as direccionOfna  
					FROM   usuarios 
					LEFT JOIN perfil ON perfil.idPerfil = usuarios.idPerfil
					LEFT JOIN estatus ON estatus.idEstatus = usuarios.idEstatus
					LEFT JOIN sexo ON sexo.idSexo = usuarios.idSexo 
					LEFT JOIN estado_civil ON estado_civil.idCivil = usuarios.idCivil  
					WHERE usuario.nombre LIKE '%".$nombre."%'";
		}
		

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			return -1; 
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($resultado->num_rows == 0) { 
					return 0 ; 
				} else {   
					$users= array();
					while( $usr = $resultado->fetch_assoc()) {
						$users[]= $usr;
					}
					$resultado->free();
					return $users ;
				} 
			} 
			$mysqli->close();
		} 
	}
		
		
	//Función que permite actualizar lo datos del usuario que está en sesión.
	public function setPwdUsuario( $emailusr ,  $pwd ){
		// Create connection
		$resultado = false; 
		$query = "	UPDATE usuarios  
					SET pwdIntranet = MD5('". trim ( $pwd ) ."') 
					WHERE lower( trim( usrIntranet ) ) = '". strtolower (trim( $emailusr )) ."' "; 
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	
	//Función que permite obtener el identificador y descripción del Perfil que tiene un usuario.
	public function getPerfilUsuario( $usuario ){
		// Create connection
		$query = "	SELECT b.idPerfil, b.desc FROM a usuarios, b perfil  
					WHERE  usrIntranet = a.idPerfil = b.idPerfil AND  trim( a.usrIntranet ) = trim( '".$usuario."' )" ;
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			header ( 'Location: pageError.php?error=1'); 
		}else{
			if (!$resultado = $mysqli->query($query)) {
				header ( 'Location: pageError.php?error=1'); 
			}else {
				if ($resultado->num_rows === 0) { 
					header ( 'Location: pageError.php?error=1'); 
				} else { 
					//echo "Mensaje";
					return $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
				} 
			} 
			$mysqli->close();
		} 
	}
	
	//Función que permite obtener los datos del usuario que está en sesión.
	public function getDatosPerfil( $usrIntranet ){
		// Create connection
		$query = "SELECT DISTINCT lower(usrIntranet) as usrIntranet , upper( nombre ) as nombre , upper( paterno ) as paterno , 
						upper( materno ) as materno, fechaNacimiento, idSexo , idCivil, direccion , 
						fechaIngreso, telPersonal, celPersonal, lower( emailPersonal ) as emailPersonal, telOfna, 
						celOfna, lower( emailOfna ) as emailOfna , direccionOfna,Proyecto_id,area_ID,DiasLey  
				  FROM usuarios  
				  WHERE  lower( usrIntranet ) =  '".strtolower( $usrIntranet )."' " ;
				  
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			return -1; 
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($resultado->num_rows > 0 ) { 
					//echo "REGISTROS: ". $resultado->num_rows."" ;
					$result =  $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
					return $result;
				} else { 
					return 0 ; 
				} 
			} 
			$mysqli->close();
		} 
	}
	
	//Función que permite actualizar lo datos del usuario que está en sesión.
	public function setActualizaPerfil ( $usrIntranet , $idCivil , $direccion , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna, $proyectoID , $areaID){
		// Create connection
		$resultado = false; 
		$query = "UPDATE usuarios 
				  SET  	idCivil = '".$idCivil."' , direccion = '".$direccion."' , telPersonal = '".$telPersonal."'  , 
				  		celPersonal = '".$celPersonal."'  , emailPersonal= '". strtolower($emailPersonal )."'  , telOfna = '".$telOfna."' , 
						celOfna = '".$celOfna."' , emailOfna='". strtolower( $emailOfna )."'  , direccionOfna= '".$direccionOfna."' ,Proyecto_ID='".$proyectoID."', area_ID='".$areaID."'    
				  WHERE  usrIntranet =  '".$usrIntranet."' " ;
				  
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false;  
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	
	//Función que permite obtener los datos del usuario deseado.
	public function getDatosUsuario( $usuario ){
		// Create connection
		$query =   "SELECT DISTINCT
						lower( usuarios.usrIntranet ) as usrIntranet, upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
						upper( usuarios.materno ) as materno, usuarios.fechaNacimiento as fechaNacimiento, usuarios.idPerfil as idPerfil, 
						perfil.desc AS facultad , usuarios.idEstatus as idEstatus, estatus.desc AS estado ,  usuarios.idSexo as idSexo , 
						sexo.desc AS genero , usuarios.idCivil as idCivil, estado_civil.desc AS civil , usuarios.direccion as direccion, 
						usuarios.fechaIngreso as fechaIngreso, usuarios.fechaSalida as fechaSalida ,usuarios.telPersonal as telPersonal, 
						usuarios.celPersonal as celPersonal, lower( usuarios.emailPersonal ) as emailPersonal, usuarios.telOfna as telOfna, 
						usuarios.celOfna as celOfna, lower( usuarios.emailOfna ) as emailOfna, usuarios.direccionOfna as direccionOfna, usuarios.area_ID
					FROM   usuarios 
						LEFT JOIN perfil ON perfil.idPerfil = usuarios.idPerfil
						LEFT JOIN estatus ON estatus.idEstatus = usuarios.idEstatus
						LEFT JOIN sexo ON sexo.idSexo = usuarios.idSexo 
						LEFT JOIN estado_civil ON estado_civil.idCivil = usuarios.idCivil 
					WHERE
						usuarios.usrIntranet =  '".$usuario."' " ;

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			return -1; 
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($resultado->num_rows > 0 ) {  
					$result =  $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
					return $result;
				} else { 
					return 0 ; 
				} 
			} 
			$mysqli->close();
		} 
	}
	
	//Función que permite actualizar lo datos del usuario que está en sesión.
	public function setActualizaUsuario( $usrIntranet , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idPerfil , $idEstatus , $idSexo , $idCivil , $direccion , $fechaIngreso , $fechaSalida , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna ,$areaID){
		// Create connection
		$resultado = false; 
		$query = "UPDATE usuarios 
				  SET  	nombre = '".strtoupper($usrnombre )."' , paterno = '". strtoupper( $usrpaterno )."' , materno = '". strtoupper( $usrmaterno )."' , 
				  		fechaNacimiento = '".$fechaNacimiento."' , idPerfil = '".$idPerfil."' , idEstatus = '".$idEstatus."' , 
						idCivil = '".$idCivil."' , direccion = '".$direccion."'  ,  fechaIngreso = '".$fechaIngreso."' , 
						fechaSalida = '".$fechaSalida."' , telPersonal = '".$telPersonal."'  , celPersonal = '".$celPersonal."'  , 
						emailPersonal= '".strtolower( $emailPersonal )."'  , telOfna = '".$telOfna."' , celOfna = '".$celOfna."' , 
						emailOfna='".strtolower( $emailOfna )."'  , direccionOfna= '".$direccionOfna."', area_ID='".$areaID."'    
				  WHERE  usrIntranet =  '".$usrIntranet."' " ;

		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false;  
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	
	
	//Función que permite dar del Alta un Usuario. 
	public function setAltaUsuario( $usrIntranet , $idTipoUsuario , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idSexo , $idCivil , $direccion , $fechaIngreso ,  $telPersonal, $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $dirOfna, $areaUsuario ){
		// Create connection
		$resultado = false;
		$numAleatorio = rand(1, 90000); 
		$pwdIntranet = "itw".$numAleatorio ; // se genera un pwd temp
		$idUsuario = NULL;  // id del usuario es autoincremental
		$idEstatus = 1 ;  // Usuario ACTIVO
		$query = "INSERT INTO  `usuarios` ( `idUsuario` , `usrIntranet` , `pwdIntranet` , `idPerfil` , `nombre` , `paterno` , `materno` , `fechaNacimiento` , `Idsexo` , `IdCivil` , `direccion` , `fechaIngreso` , `idEstatus` , `telPersonal` , `celPersonal` , `emailPersonal` , `telOfna` , `celOfna` , `emailOfna` , `direccionOfna`, area_ID )  
				  VALUES ( '".$idUsuario."' , '".$usrIntranet."' , MD5('".$pwdIntranet."') , ".$idTipoUsuario." , '".$usrnombre."' , '".$usrpaterno."' , '".$usrmaterno."'  , '".$fechaNacimiento."' , ".$idSexo." , ".$idCivil." , '".$direccion."' , '".$fechaIngreso."' , '".$idEstatus."' , '".$telPersonal."' , '".$celPersonal."' , '".$emailPersonal."' , '".$telOfna."' , '".$celOfna."' , '".$emailOfna."' , '".$dirOfna."' , '".$areaUsuario."')  ";
		//echo $query; 
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false;
		}else{
			if ( $mysqli->query( $query ) ) {
				$resultado = true; 
			} else {
				$resultado = false; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	
	
	//Función que permite dar de baja un Usuario.
	public function setEliminaUsuario( $usrIntranet ){
		// Create connection
		$resultado = false; 
		$query = "DELETE FROM `usuarios` WHERE idUsuario= '".$usrIntranet."'";
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			//header ( 'Location: pageError.php?error=1'); 
			die("Connection failed: " . $conn->connect_error);
		}else{
			if ( $mysqli->query( $query ) ) {
				$resultado = true; 
			} else {
				$resultado = false; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}	
	
	//Función que permite modificar lo datos del usuario que está en sesión.
	public function setDatosModifica( $usrNuevo , $pwd , $idTipoUsuario , $usrnombre , $usrpaterno , $usrmaterno , $idSexo , $idCivil , $direccion , $fechaIngreso , $fechaSalida , $idEstatus , $telPersonal, $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna){
		// Create connection
		$resultado = false; 
		$query = "UPDATE usuarios  SET Usuario = MD5('".$pwd."') WHERE lower( usrIntranet ) = '". $emailusr ."' "; 
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	 //Función que valida si existe el usuario en el sistema Intranet .
	public function getExisteUsuario( $emailusr ){
	
		$query = "SELECT lower( usrIntranet ) FROM usuarios WHERE lower(usrIntranet) = '". $emailusr ."' ";  
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) { 
			$res = -1;
		}else{
			if (!$resultado = $mysqli->query($query)) { 
				$res = -1;
			}else {
				if ($resultado->num_rows > 0) {  
					$res = $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
				} else {  
					$res = 0;
				} 
			} 
			$mysqli->close();
		}   
		return $res ; 
	}
	
	//funcion para insertar solicitudes
	public function insertSolicitud($ID_USR,$fechaI,$fechaF,$diasVa,$diasSoli,$diasAdi,$lider,$director){

		$query ="INSERT INTO `solicitudvaciones`(`user_ID`,`fechaI`,`fechaF`,`diasCorrespondientes`,`diasSolicitados`,`diasAdicionales`,`lider_ID`,`aprobacion_L`,`Director_ID`,`aprobacion_D`,`documentoURL`,`correoEnviado`) VALUES('".$ID_USR."' , '".$fechaI."' , '".$fechaF."' , '".$diasVa."' , '".$diasSoli."' , '".$diasAdi."' , '".$lider."' , '1' , '".$director."' , '1' , 'sin archivo','0')";
		
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false;
		}else{
			if ( $mysqli->query( $query ) ) {
				$resultado = true; 
			} else {
				$resultado = false; 
				//header('Location: intranet/submenu_Solicitud_Vacaciones?resultado='.$resultado.'&caso=query_defectuoso'); 
			}
			$mysqli->close();
		} 
		return $resultado;
	}
	
	//funcion para visualizar solicitudes realizadas
	public function verSolicitudes($idUsuario, $Inicio = "", $TAMANO_PAGINA=""){
		$query = "";
		if ($Inicio == "" and $TAMANO_PAGINA == "") {
			$query = "SELECT solicitudvaciones.solicitud_ID, solicitudvaciones.fechaSolicitud as fecha, solicitudvaciones.fechaI as fecha1, solicitudvaciones.fechaF as fecha2, solicitudvaciones.diasSolicitados as dias, solicitudvaciones.diasAdicionales as adicionales, solicitudvaciones.aprobacion_L as aprobacion1, solicitudvaciones.aprobacion_D as aprobacion2 , solicitudvaciones.documentoURL as documento from solicitudvaciones where user_ID ='".$idUsuario."'";
		}else{
			$query = "SELECT solicitudvaciones.solicitud_ID, solicitudvaciones.fechaSolicitud as fecha, solicitudvaciones.fechaI as fecha1, solicitudvaciones.fechaF as fecha2, solicitudvaciones.diasSolicitados as dias, solicitudvaciones.diasAdicionales as adicionales, solicitudvaciones.aprobacion_L as aprobacion1, solicitudvaciones.aprobacion_D as aprobacion2 , solicitudvaciones.documentoURL as documento from solicitudvaciones where user_ID ='".$idUsuario."' ORDER BY solicitudvaciones.solicitud_ID LIMIT ".$Inicio.",".$TAMANO_PAGINA;
		}
		

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {//verificamos conexion a la BD
			return -1; //marcar error en la conexion
		}else{//conexion exitosa
			if (!$resultado = $mysqli->query($query)) {//ejecutamos el query
				return -1; //reporta problemas con el query
			}else {//en caso de obtener resultado
				if ($resultado->num_rows == 0) { //contamos resultados mayores a cero
					return 0 ;//si numero de registros es igual a 0
				} else {//en otro caso lllena el arreglo
					$datos=$resultado->num_rows;
					$users= array();//arreglo a llenar
					while( $usr = $resultado->fetch_assoc()) {//iteramos cada resultado
						$users[]= $usr;//agregamos los resultados al array
					}
					//$resultado->free();
					return $users;
				} 
			} 
			$mysqli->close();
		} 
	}

	//funcion para visualizar lider de proyecto
	public function verLider($ID_proyecto){
		$query = " SELECT P.`usuario_ID`,u.usrIntranet,u.nombre,u.paterno,u.materno FROM `proyectos` as P INNER JOIN usuarios as u on P.`usuario_ID` = u.idUsuario WHERE P.`proyecto_ID` ='".$ID_proyecto."'";
		
		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			return -1; 
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1; 
			}else {
				if ($resultado->num_rows > 0 ) {  
					$result =  $resultado->fetch_assoc(); // regresamos los campos
					$resultado->free();
					return $result;
				} else { 
					return 0 ; 
				} 
			} 
			$mysqli->close();
		} 
	}

	//Funcion para visualizar solicitudes por ID usuario
	public function verSolicitudesID($LiderId,$inicio = "" ,$TAMANO_PAGINA = "", $nombre = ""){
		$query = "";

		if($LiderId != 16 and $nombre == ""){//visualizar solicitudes recibidas

			$query = "SELECT solicitud_ID,user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales,documentoURL FROM solicitudvaciones  where lider_ID = '".$LiderId."' and aprobacion_L = 1 and documentoURL != 'sin archivo' LIMIT ".$inicio.",".$TAMANO_PAGINA;
		}else if ($LiderId == 16 and $nombre == "") {//visualizar solicitudes recibidas

			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales,documentoURL FROM solicitudvaciones  where Director_ID ='".$LiderId."' and aprobacion_D = 1 and documentoURL != 'sin archivo' order by user_ID limit".$inicio.",".$TAMANO_PAGINA;
		
		}else if($LiderId != 16 and $nombre != ""){//busqueda desde la caja de texto

			$query = "SELECT S.user_ID,S.fechaI,S.fechaF,S.diasCorrespondientes,S.diasSolicitados,S.diasAdicionales FROM solicitudvaciones as S left JOIN  usuarios as us on S.user_ID = us.idUsuario WHERE S.lider_ID ='".$LiderId."' AND S.aprobacion_L = 0 and us.nombre LIKE '%".$nombre."%'";
		
		}else if($LiderId == 16 and $nombre != ""){//busqueda desde la caja de texto

			$query = "SELECT S.user_ID,S.fechaI,S.fechaF,S.diasCorrespondientes,S.diasSolicitados,S.diasAdicionales FROM solicitudvaciones as S left JOIN  usuarios as us on S.user_ID = us.idUsuario WHERE S.Director_ID ='".$LiderId."' AND S.aprobacion_D = 0 and us.nombre LIKE '%".$nombre."%'";
		}

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {//verificamos conexion a la BD
			return -1; //marcar error en la conexion
		}else{//conexion exitosa
			if (!$resultado = $mysqli->query($query)) {//ejecutamos el query
				return -1; //reporta problemas con el query
			}else {//en caso de obtener resultado
				if ($resultado->num_rows == 0) { //contamos resultados mayores a cero
					return 0 ;//si numero de registros es igual a 0
				} else {//en otro caso lllena el arreglo
					$datos=$resultado->num_rows;
					$users= array();//arreglo a llenar
					while( $usr = $resultado->fetch_assoc()) {//iteramos cada resultado
						$users[]= $usr;//agregamos los resultados al array
					}
					//$resultado->free();
					return $users;
				} 
			} 
			$mysqli->close();
		} 
	}

	//Function para contar registros encontrados
	public function verSolicitudesIDB($LiderId){
		$query = "";

		if($LiderId != 16){
			$query = "SELECT solicitud_ID,user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where lider_ID = '".$LiderId."' and aprobacion_L = 1 and documentoURL != 'sin archivo'";
		} else{
			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where Director_ID ='".$LiderId."' and aprobacion_D = 1  and documentoURL != 'sin archivo'";
		}

		$mysqli = $this->objDb->getConnBasic();
		if ($mysqli->connect_errno) {//verificamos conexion a la BD
			return -1; //marcar error en la conexion
		}else{//conexion exitosa
			if (!$resultado = $mysqli->query($query)) {//ejecutamos el query
				return -1; //reporta problemas con el query
			}else {//en caso de obtener resultado
				if ($resultado->num_rows == 0) { //contamos resultados mayores a cero
					return 0 ;//si numero de registros es igual a 0
				} else {//en otro caso lllena el arreglo
					$datos=$resultado->num_rows;
					$users= array();//arreglo a llenar
					while( $usr = $resultado->fetch_assoc()) {//iteramos cada resultado
						$users[]= $usr;//agregamos los resultados al array
					}
					//$resultado->free();
					return $users;
				} 
			} 
			$mysqli->close();
		} 
	}


	//funciona para obtener los datos del usuario que notificar de su solicitud
	public function notificarUsuario($usuario){

		$query = "SELECT usrIntranet, nombre, paterno, materno from usuarios where idUsuario ='".$usuario."'";

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Funcion para guardar el nombre del archivo subido
	public function updateArchivo($Archivo, $nombre){
		$query = "UPDATE `solicitudvaciones` SET `documentoURL`='".$nombre."'  WHERE solicitud_ID ='".$Archivo."'";

		$resultado = false;
		
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}

	//funcion para recuperar el nombre del archivo subido
	public function verNombre($idArchivo){
		$query = "SELECT documentoURL as documento from solicitudvaciones where solicitud_ID='".$idArchivo."'";

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	public function busqueda($nombre, $opcion){
		$query = "";

		if ($opcion == 1) {
			$query = "SELECT upper( usuarios.nombre )  as nombre , upper( usuarios.paterno ) as paterno, 
					upper( usuarios.materno ) as materno, lower( usuarios.usrIntranet ) as usrIntranet,usuarios.celOfna as celOfna, usuarios.telOfna as telOfna,usuarios.telPersonal as telPersonal, 
					usuarios.celPersonal as celPersonal from usuarios where usuarios.nombre like '%".$nombre."%'";
		}else if ($opcion == 2) {
			# code...
		}

		
		

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	public function procesarSolicitudes($id,$opcion = null){

		if ($opcion == 1) {
			if ($id == 16) {
				$query = "UPDATE `solicitudvaciones` SET `aprobacion_D`= 2 WHERE `user_ID` ='".$id."'";
			}else{
			$query = "UPDATE `solicitudvaciones` SET `aprobacion_L`= 2 WHERE `user_ID` ='".$id."'";
			}
		} else if ($opcion ==2 ) {
			if ($id == 16 ) {
				$query = "UPDATE `solicitudvaciones` SET `aprobacion_D`= 3 WHERE `user_ID` ='".$id."'";
			}else{
			$query = "UPDATE `solicitudvaciones` SET `aprobacion_L`= 3 WHERE `user_ID` ='".$id."'";
			}
		}
		$resultado = false;
		
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}

	//funcion que devuelve las solicitudes aceptadas para ser notificadas al usuario
	public function buscarSolicitudesAceptadas(){
		$query = "SELECT `user_ID` FROM solicitudvaciones WHERE `aprobacion_L` = 2 AND `aprobacion_D` = 2 AND `correoDEA` = 0";
		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//funcion que devuelve las solicitudes rechazadas para ser notificadas al usuario
	public function buscarSolicitudesRechazadas(){
		$query = "SELECT `user_ID` FROM solicitudvaciones WHERE ((`aprobacion_L` = 3 AND `aprobacion_D` = 3)OR(`aprobacion_L` = 1 AND `aprobacion_D` = 3)) AND `correoEnviado` = 0";
		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	public function notificarEnvioCorreo( $id , $opcion){
		$query="";

		if($opcion == 1){//correo enviado a lider
			$query = "UPDATE solicitudvaciones SET correoEnviado = 1 where user_ID ='".$id."'";
		
		}else if ($opcion == 2 ) {//correo enviado de aceptado
			$query = "UPDATE solicitudvaciones SET correoDEA = 1 where user_ID ='".$id."'";
		
		}else if($opcion == 3){//correo enviado de rechazo
			$query = "UPDATE solicitudvaciones SET correoDeR = 1 where user_ID ='".$id."'";
		
		}else{//correo envia a Director
			$query = "UPDATE solicitudvaciones SET correoEnviadoD = 1 where user_ID ='".$id."'";
		}

		$resultado = false;
		
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
			 $resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}


	//funcion para visualizar el detalle de las solicitudes realizadas
	public function verDetalle($id = "", $INICIO = "", $TAMANO_PAGINA="", $objectBusqueda = ""){
		
		$query="";
		
		if( $id==""  AND ($INICIO=="") AND ($TAMANO_PAGINA =="") AND ($objectBusqueda == "") ) {
			$query = " SELECT * FROM `solicitudvaciones` ORDER BY fechaSolicitud";
		}else if ( $id != "" AND $INICIO == "" AND $TAMANO_PAGINA == "" AND $objectBusqueda == "" ) {
			
			$query = "SELECT * from solicitudvaciones WHERE solicitud_ID='".$id."'";

		}else if ($id == "" AND $INICIO != "" AND $TAMANO_PAGINA !="" AND $objectBusqueda == "") {

			$query = "SELECT * from solicitudvaciones ORDER BY fechaSolicitud LIMIT ".$INICIO.",".$TAMANO_PAGINA."";
		}else{
			$query = "SELECT U.nombre, U.paterno, U.materno, S.solicitud_ID, S.user_ID, S.diasCorrespondientes, S.diasSolicitados, S.diasAdicionales, S.fechaSolicitud, S.aprobacion_L, S.aprobacion_D FROM solicitudvaciones AS S INNER JOIN  usuarios AS U ON S.user_ID = U.idUsuario WHERE U.idUsuario = S.user_ID and U.nombre LIKE '%".$objectBusqueda."%'";
		}

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Función que permite obtener los datos del usuario 
	public function getDatosPerfilID( $id ){
		// Create connection
		$query = "SELECT idUsuario,nombre,paterno,materno,fechaIngreso,Proyecto_ID,area_ID
				  FROM usuarios  
				  WHERE   idUsuario =  '".$id."' " ;
				  
		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Funcion para devolver el ultimo registro realizado por un usario
	public function verUltimSolicitudID($id){
		$query = "SELECT * FROM solicitudvaciones WHERE solicitud_ID =(SELECT MAX(solicitud_ID) FROM solicitudvaciones where user_ID ='".$id."' AND aprobacion_D = '2' AND  aprobacion_L = '2') ";

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Función para devolver los responzables de asignación
	public function mostrarResponzablesAsignacion($id = ""){
		$query = "";
		if ($id == "") {
		 	$query = "SELECT ' ' as nombre ,'Seleccionar' as paterno,' ' as materno ,'0' as proyecto_ID UNION SELECT U.nombre, U.paterno, U.materno, P.proyecto_ID FROM proyectos AS P INNER JOIN usuarios AS U ON P.usuario_ID = U.idUsuario WHERE usuario_ID = U.idUsuario";
		 }else{
		 	$query = "SELECT U.nombre, U.paterno, U.materno, P.proyecto_ID, U.usrIntranet FROM proyectos AS P INNER JOIN usuarios AS U ON P.usuario_ID = U.idUsuario WHERE P.proyecto_ID ='".$id."'";
		 } 
		
		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Funcion para consultar cuantos días de cacaciones corresponden en relación ha antiguedad
	public function verAntiguedad($anios){
		$query = "SELECT Dias from diasvacaciones where Anios ='".$anios."' ";
		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	public function verAreas($id = ""){
		if ($id == "") {
			$query = "SELECT '0' as area_ID,'Seleccionar' as Descripcion UNION SELECT area_ID, Descripcion from areasitw";
		}else{
			$query = " SELECT area_ID, Descripcion from areasitw where area_ID ='".$id."'";
		}
		

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Funcion para consultar solicitudes completas
	public function verSolicitudesCompletas(){
		$query="SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where aprobacion_L = 1 and aprobacion_D = 1 and documentoURL != 'sin archivo' and (correoEnviado = 0 AND correoEnviadoD = 0)";

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	//Funcion para consultar el año de antiguedad basado en los dias correspondientes
	public function verAñoDias($diasCorrespondientes){
		$query ="SELECT Anios FROM diasvacaciones where Dias ='".$diasCorrespondientes."'";

		$mysqli = $this-> objDb->getConnBasic();
		if ($mysqli->connect_errno) {
			$return -1;
		}else{
			if (!$resultado = $mysqli->query($query)) {
				return -1;
			}else{
				$datos = $resultado->num_rows;
				$users = array();
				while ($usr = $resultado->fetch_assoc()) {
					$users[]=$usr;
				}
				return $users;
			}
			$mysqli->close();
		}
	}

	public function actualizarDiasDisponibles($dias,$id){
		$query = "UPDATE usuarios  set DiasLey = '".$dias."' WHERE idUsuario ='".$id."'";

		$resultado = false;
		
		$mysqli = $this->objDb->getConnAdmin();
		if ($mysqli->connect_errno) {
			$resultado = false; 
		}else{
			if ( $mysqli->query($query) ) {
				$resultado = true; 
			}
			$mysqli->close();
		} 
		return $resultado;
	}

	public function verPerfiles($id = ""){
		$query = "";
		if ($id != "") {
			$query = "SELECT * FROM perfil WHERE idPerfil ='".$id."'";
		}else{
			//SELECT '0' as area_ID,'Seleccionar' as Descripcion UNION SELECT area_ID, Descripcion from areasitw"
			$query = "SELECT '0' as `idPerfil`,'SELECIONAR' as `desc` UNION SELECT * FROM perfil";
		}

		$mysqli = $this-> objDb->getConnBasic();
			if ($mysqli->connect_errno) {
				$return -1;
			}else{
				if (!$resultado = $mysqli->query($query)) {
					return -1;
				}else{
					$datos = $resultado->num_rows;
					$users = array();
					while ($usr = $resultado->fetch_assoc()) {
						$users[]=$usr;
					}
					return $users;
				}
				$mysqli->close();
			}
	}

	public function DatosDirector(){
		$query="SELECT U.`idUsuario`, U.`usrIntranet`,U.`nombre`, U.`paterno`, U.`materno` FROM `usuarios`as U INNER JOIN perfil as P on U.`idPerfil` = P.idPerfil WHERE U.`idPerfil` = 1;";

		$mysqli = $this-> objDb->getConnBasic();
			if ($mysqli->connect_errno) {
				$return -1;
			}else{
				if (!$resultado = $mysqli->query($query)) {
					return -1;
				}else{
					$datos = $resultado->num_rows;
					$users = array();
					while ($usr = $resultado->fetch_assoc()) {
						$users[]=$usr;
					}
					return $users;
				}
				$mysqli->close();
			}
	}
}


?>