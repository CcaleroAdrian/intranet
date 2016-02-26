<?php

class Usuario{
	
	public $objDb;
	public $objSe;
	public $result;
	public $rows;
	public $useropc;
	
	public function __construct(){
		
		$this->objDb = new Database();
		$this->objSe = new Sesion();
		
	}
	
	
	public function loginIntranet(){
	
		$query = "SELECT usuarios.idUsuario , usuarios.usrIntranet , usuarios.idPerfil , perfil.desc FROM usuarios, perfil 
				  WHERE usuarios.usrIntranet = '".$_POST["usuarioitw"]."' 
				  AND usuarios.pwdIntranet = MD5('".$_POST["pwditw"]."' )
				  AND usuarios.idPerfil = perfil.idPerfil ";
		$this->result = $this->objDb->select($query);
		$this->rows = mysql_num_rows($this->result);
		if($this->rows > 0){
			
			if($row=mysql_fetch_array($this->result)){
				
				$this->objSe->init();
				$this->objSe->set('usuarioItw', $row["usrIntranet"]);
				$this->objSe->set('idUsuario', $row["idUsuario"]);
				$this->objSe->set('idPerfil', $row["idPerfil"]);
				
				$this->useropc = $row["desc"];
				
				
				mysql_free_result( $this->result ); //Libera memoria
				mysql_close(); //Cerrar conexion  
							
							
				switch($this->useropc){
					
					case 'ADMINISTRADOR':
						header('Location: index.php');
						break;
						
					case 'NORMAL':
						header('Location: index.php');
						break;

				}
				
			}
			
		}else{
			
			header('Location: index.php?error=1');
			
		}
		
	}
	
	
	public function existeUsuario(){
	
	
	}
	
	
	
}

?>