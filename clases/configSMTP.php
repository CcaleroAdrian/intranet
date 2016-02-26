<?php

class ConnectionSMTP{
	
	//variables para los datos de la base de datos
	public $hostSMTP;
	public $usrSMTP;
	public $pwdSMTP;
	public $portSMTP;
	
	public function __construct(){
		
		//Iniciar las variables con los datos de la base de datos
		$this->hostSMTP = 'server70.neubox.net';
		$this->usrSMTP = 'jesus.calero@itw.mx';
		$this->pwdSMTP = 'Itw201510';
		$this->portSMTP = '465';
				
	}
	
	public function getHost(){
		return $this->hostSMTP
	}
	public function getUsr(){
		return $this->usrSMTP
	}
	public function getPwd(){
		return $this->pwdSMTP
	}
	public function getPort(){
		return $this->portSMTP
	}
	
	
}

?>