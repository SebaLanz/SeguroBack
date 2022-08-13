<?php 
require_once 'config/constantes.php'; // me garantizo acceso a las constantes con la data de conección a db
class Dao{

	private $connHandler = null;
	
	public function __construct($paramDBhost,$paramDBuser,$paramDBpass,$paramDBbase,$paramDBpuerto){
		try{

			$this->connHandler=$this->conectarDb($paramDBhost,$paramDBuser,$paramDBpass,$paramDBbase,$paramDBpuerto);

		}catch (Exception $e) {
			throw new Exception(" Error de instanciando objeto dao : ".$e->getMessage());
			
		}
		
		
	}

	private function conectarDb($paramDBhost,$paramDBuser,$paramDBpass,$paramDBbase,$paramDBpuerto){
		try {
				
				$mysqli = new mysqli($paramDBhost,$paramDBuser,$paramDBpass,$paramDBbase,$paramDBpuerto);
							
				
				if ($mysqli->connect_errno) {
				    
				    throw new Exception(" Error de conexión : ".$mysqli->connect_error);
				}
				return $mysqli;
			
		} catch (Exception $e) {
			throw new Exception(" Error de creación objeto mysql : ".$e->getMessage());
			
		}
		
	}

	public function resultQuery($queryString){
		try{			
			$registros = array();//genera un arrayy vacio

			$resultado = $this->connHandler->query($queryString);
			if ($resultado){
				while($fila=$resultado->fetch_assoc()){
					$registros[]=$fila;
				}
			}else{
				throw new Exception(" Error ejecutando query : ".$queryString);
			}		
			return $registros;
		}catch (Exception $e) {
			throw new Exception(" Error query : ".$e->getMessage());	
		}
	}

	public function noResultQuery($queryString){
		try{	
			$resultado = $this->connHandler->query($queryString);
			if (!$resultado){
					throw new Exception(" Error ejecutando query : ".$queryString);
			}				
		}catch (Exception $e) {
			throw new Exception(" Error query : ".$e->getMessage());	
		}
	}


	public function __destruct(){
		$this->connHandler->close();
	}
}

	
?>