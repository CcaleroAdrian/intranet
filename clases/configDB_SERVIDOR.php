<?php
class ConfigDB{

	//variables para los datos de la base de datos
	public $serverIntranet;  
	public $dbIntranet; 
	
	public function __construct(){
		// Inicializa al instanciar la clase
		$this->serverIntranet = 'localhost';  //Servidor de la intranet
		$this->dbIntranet = 'u212370_intranet';	//Nombre de la Base de Datos de Intranet
	}
	
	public function getConnBasic(){
		
		// Create connection
		return new mysqli( $this->serverIntranet , 'u212370_intBasic' , 'i2t0w15Basic' , $this->dbIntranet );
		
	}
	
	public function getConnAdmin(){
		
		// Create connection
		return  new mysqli( $this->serverIntranet , 'u212370_intAdmin' , 'i2t0w15Admin' , $this->dbIntranet );
		
	}
	
}

?>