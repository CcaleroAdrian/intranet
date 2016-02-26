<?php

class Conexion{
	
	//variables para los datos de la base de datos
	public $server; 
	public $dbname;
	public $userBasicdb;
	public $passBasicdb;
	public $userAdmindb;
	public $passAdmindb;
	
	public function __construct(){
		
		//Iniciar las variables con los datos de la base de datos 
		$this->server = 'localhost'; 
		$this->dbname = 'u212370_intranet';
		
		//Servidor LOCAL
		/*
		$this->userBasicdb = 'u212370_admint'; 
		$this->passBasicdb = '';		
		$this->userAdmindb = 'u212370_admint'; 
		$this->passAdmindb = '';	
		*/
		//Servido REMOTO
		
		$this->userBasicdb = 'u212370_intBasic'; 
		$this->passBasicdb = 'i2t0w15Basic';		
		$this->userAdmindb = 'u212370_intAdmin'; 
		$this->passAdmindb = 'i2t0w15Admin';	
	}
	
	public function getConexionBasic(){
		
		//Para conectarnos a MySQL
		$con = mysql_connect($this->server, $this->userBasicdb, $this->passBasicdb);
		//Nos conectamos a la base de datos que vamos a usar
		mysql_select_db($this->dbname, $con);
		
	}
	
	public function getConexionAdmin(){
		
		//Para conectarnos a MySQL
		$con = mysql_connect($this->server, $this->userAdmindb, $this->passAdmindb);
		//Nos conectamos a la base de datos que vamos a usar
		mysql_select_db($this->dbname, $con);
		
	}
	
	public function liberaConexion( $consulta ){
		
		mysql_free_result( $consulta ); //Libera memoria
			mysql_close(); //Cerrar conexion
		
	}
	
}

?>