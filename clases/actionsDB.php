<?php 
include('configDB.php');

class ActionsDB{
	public $objDb; 
	 
	
	// Clase que permite hacer las operaci�nes con la bd.
	public function __construct(){
			// Inicializa al instanciar la clase
			$this->objDb = new ConfigDB();
	}
	
	//Funci�n que permite obtener todos los usuarios de la base de datos .
	public function getMenus( $idPerfil ) {
		// Create connection
		$resultado = array();
		If ( $idPerfil == "1" ) { //ADMINISTRADOR
			$query =  " SELECT M.idMenu as idMenu , M.descripcion as descripcion , M.alias as alias, M.href as href, M.icono as icon
						FROM menu as M   
						WHERE  M.visible = true  ORDER BY posicion ASC " ;
		}else { //USUARIO ESTANDAR
			$query =  " SELECT M.idMenu as idMenu, M.descripcion as descripcion , M.alias as alias , M.href as href, M.icono as icon
						FROM menu as M   
						WHERE  M.visible = true AND  trim( M.idPerfilExclusivo) NOT IN ( 1 )   ORDER BY posicion ASC " ;
		}
		//echo $query;
		If ( $idPerfil == "1" ) {
			$mysqli = $this->objDb->getConnAdmin();
		}else{
			$mysqli = $this->objDb->getConnBasic();
		}
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
	
	//Funci�n que permite obtener todos los usuarios de la base de datos.
	public function getSubMenus( $idPerfil , $idMenu  ) {
		// Create connection
		$resultado = array();
		If ( $idPerfil == "1" ) { //ADMINISTRADOR
			$query =  " SELECT SM.idSubMenu AS idSubMenu , SM.idMenu AS idMenu ,   SM.descripcion AS descripcion , SM.alias AS alias, SM.href AS href
						FROM submenu as SM   
						WHERE  SM.visible = true AND SM.idMenu = '".$idMenu."' ORDER BY posicion ASC " ;
		}else { //USUARIO ESTANDAR
			$query =  " SELECT SM.idSubMenu AS idSubMenu , SM.idMenu AS idMenu ,   SM.descripcion AS descripcion , SM.alias AS alias, SM.href AS href
						FROM submenu as SM   
						WHERE  (SM.visible = true ) AND  ( SM.idPerfilExclusivo NOT IN ( 1 ) )   AND ( SM.idMenu = '".$idMenu."' )  ORDER BY posicion ASC " ;
		}
		//echo $query;
		If ( $idPerfil == "1" ) {
			$mysqli = $this->objDb->getConnAdmin();
		}else{
			$mysqli = $this->objDb->getConnBasic();
		}
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
	
	// Funci�n obtiene el usuario , idPerfil y descripci�n del perfil  de la tabla usuarios si es que existe en BD.
	public function getUsuarioSesion( $usuario , $pwd ){
	
		/*$query = "SELECT  lower( trim( usuarios.usrIntranet ) ) as usrIntranet, usuarios.idPerfil as idPerfil, usuarios.idUsuario, trim( perfil.desc ) as descPerfil FROM usuarios, perfil 
				  WHERE lower( trim( usuarios.usrIntranet ) ) = '". strtolower( trim( $usuario ) ) ."' 
				  AND trim(usuarios.pwdIntranet) ='". trim( $pwd ) ."'
				  AND usuarios.idPerfil = perfil.idPerfil  limit 1 ";*/ 
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

	//Funci�n que permite obtener todos los usuarios de la base de datos
	public function getAllUsuarios( ) {
		// Create connection
		$users = array();
		$query =  "SELECT DISTINCT
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
		
		
	//Funci�n que permite actualizar lo datos del usuario que est� en sesi�n.
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
	
	//Funci�n que permite obtener el identificador y descripci�n del Perfil que tiene un usuario.
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
	
	//Funci�n que permite obtener los datos del usuario que est� en sesi�n.
	public function getDatosPerfil( $usrIntranet ){
		// Create connection
		$query = "SELECT DISTINCT lower(usrIntranet) as usrIntranet , upper( nombre ) as nombre , upper( paterno ) as paterno , 
						upper( materno ) as materno, fechaNacimiento, idSexo , idCivil, direccion , 
						fechaIngreso, telPersonal, celPersonal, lower( emailPersonal ) as emailPersonal, telOfna, 
						celOfna, lower( emailOfna ) as emailOfna , direccionOfna,Proyecto_id  
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
	
	//Funci�n que permite actualizar lo datos del usuario que est� en sesi�n.
	public function setActualizaPerfil ( $usrIntranet , $idCivil , $direccion , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna ){
		// Create connection
		$resultado = false; 
		$query = "UPDATE usuarios 
				  SET  	idCivil = '".$idCivil."' , direccion = '".$direccion."' , telPersonal = '".$telPersonal."'  , 
				  		celPersonal = '".$celPersonal."'  , emailPersonal= '". strtolower($emailPersonal )."'  , telOfna = '".$telOfna."' , 
						celOfna = '".$celOfna."' , emailOfna='". strtolower( $emailOfna )."'  , direccionOfna= '".$direccionOfna."'    
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
	
	//Funci�n que permite obtener los datos del usuario deseado.
	public function getDatosUsuario( $usuario ){
		// Create connection
		$query =   "SELECT DISTINCT
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
	
	//Funci�n que permite actualizar lo datos del usuario que est� en sesi�n.
	public function setActualizaUsuario( $usrIntranet , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idPerfil , $idEstatus , $idSexo , $idCivil , $direccion , $fechaIngreso , $fechaSalida , $telPersonal , $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $direccionOfna ){
		// Create connection
		$resultado = false; 
		$query = "UPDATE usuarios 
				  SET  	nombre = '".strtoupper($usrnombre )."' , paterno = '". strtoupper( $usrpaterno )."' , materno = '". strtoupper( $usrmaterno )."' , 
				  		fechaNacimiento = '".$fechaNacimiento."' , idPerfil = '".$idPerfil."' , idEstatus = '".$idEstatus."' , 
						idCivil = '".$idCivil."' , direccion = '".$direccion."'  ,  fechaIngreso = '".$fechaIngreso."' , 
						fechaSalida = '".$fechaSalida."' , telPersonal = '".$telPersonal."'  , celPersonal = '".$celPersonal."'  , 
						emailPersonal= '".strtolower( $emailPersonal )."'  , telOfna = '".$telOfna."' , celOfna = '".$celOfna."' , 
						emailOfna='".strtolower( $emailOfna )."'  , direccionOfna= '".$direccionOfna."'    
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
	
	
	//Funci�n que permite dar del Alta un Usuario. 
	public function setAltaUsuario( $usrIntranet , $idTipoUsuario , $usrnombre , $usrpaterno , $usrmaterno , $fechaNacimiento , $idSexo , $idCivil , $direccion , $fechaIngreso ,  $telPersonal, $celPersonal , $emailPersonal , $telOfna , $celOfna , $emailOfna , $dirOfna ){
		// Create connection
		$resultado = false;
		$numAleatorio = rand(1, 90000); 
		$pwdIntranet = "itw".$numAleatorio ; // se genera un pwd temp
		$idUsuario = NULL;  // id del usuario es autoincremental
		$idEstatus = 1 ;  // Usuario ACTIVO
		$query = "INSERT INTO  `usuarios` ( `idUsuario` , `usrIntranet` , `pwdIntranet` , `idPerfil` , `nombre` , `paterno` , `materno` , `fechaNacimiento` , `Idsexo` , `IdCivil` , `direccion` , `fechaIngreso` , `idEstatus` , `telPersonal` , `celPersonal` , `emailPersonal` , `telOfna` , `celOfna` , `emailOfna` , `direccionOfna`  )  
				  VALUES ( '".$idUsuario."' , '".$usrIntranet."' , MD5('".$pwdIntranet."') , ".$idTipoUsuario." , '".$usrnombre."' , '".$usrpaterno."' , '".$usrmaterno."'  , '".$fechaNacimiento."' , ".$idSexo." , ".$idCivil." , '".$direccion."' , '".$fechaIngreso."' , '".$idEstatus."' , '".$telPersonal."' , '".$celPersonal."' , '".$emailPersonal."' , '".$telOfna."' , '".$celOfna."' , '".$emailOfna."' , '".$dirOfna."' )  ";
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
	
	
	//Funci�n que permite dar de baja un Usuario.
	public function setEliminaUsuario( $usrIntranet ){
		// Create connection
		$resultado = false; 
		$query = "DELETE FROM `usuarios` WHERE usrIntranet= '".$usrIntranet."'";
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
	
	//Funci�n que permite modificar lo datos del usuario que est� en sesi�n.
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
	 //Funci�n que valida si existe el usuario en el sistema Intranet .
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

		$query ="INSERT INTO `solicitudvaciones`(`user_ID`,`fechaI`,`fechaF`,`diasCorrespondientes`,`diasSolicitados`,`diasAdicionales`,`lider_ID`,`aprobacion_L`,`Director_ID`,`aprobacion_D`,`documentoURL`,`correoEnviado`) VALUES('".$ID_USR."' , '".$fechaI."' , '".$fechaF."' , '".$diasVa."' , '".$diasSoli."' , '".$diasAdi."' , '".$lider."' , '0' , '".$director."' , '0' , 'sin archivo','0')";
		
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
		$query = "Select usuario_ID from proyectos where proyecto_ID ='".$ID_proyecto."'";

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

		if($LiderId != 2 and $nombre == ""){

			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where lider_ID = '".$LiderId."' and aprobacion_L = 0 LIMIT ".$inicio.",".$TAMANO_PAGINA;
		}else if ($LiderId == 2 and $nombre == "") {

			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where Director_ID ='".$LiderId."' and aprobacion_D = 0 order by user_ID limit".$inicio.",".$TAMANO_PAGINA;
		}else if($LiderId != 2 and $nombre != ""){

			$query = "SELECT S.user_ID,S.fechaI,S.fechaF,S.diasCorrespondientes,S.diasSolicitados,S.diasAdicionales FROM solicitudvaciones as S left JOIN  usuarios as us on S.user_ID = us.idUsuario WHERE S.lider_ID ='".$LiderId."' AND S.aprobacion_L = 0 and us.nombre LIKE '%".$nombre."%'";
		}else if($LiderId = 2 and $nombre != ""){

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

		if($LiderId != 2){
			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where lider_ID = '".$LiderId."' and aprobacion_L = 0";
		} else{
			$query = "SELECT user_ID,fechaI,fechaF,diasCorrespondientes,diasSolicitados,diasAdicionales FROM solicitudvaciones  where Director_ID = 2 and aprobacion_D = 0 ";
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

}

?>