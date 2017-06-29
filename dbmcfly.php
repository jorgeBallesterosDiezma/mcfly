<?php

class dbMcfly {
    
	protected $mysqli;
	const LOCALHOST = '127.0.0.1';
	const USER = 'root';
	const PASSWORD = '';
	const DATABASE = 'mcfly';
    
	/*
	* Constructor de clase
     */
	public function __construct() {           
		//conexión a base de datos
		$this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
	} 
	/**
	* Obtiene una  nota dado su ID
	* @param int $id identificador de la nota a buscar 
	* @return Array Con la nota seleccionada
	*/
	public function consultaNota($id=0){      
		$query = $this->mysqli->prepare("SELECT * FROM notas WHERE id=? ; ");
		$query->bind_param('i', $id);
		$query->execute();
		$result = $query->get_result();        
		$listado = $result->fetch_all(MYSQLI_ASSOC); 
		$query->close();
		return $listado;              
	}
	/**
	* Recupera todas las notas existentes
	* @return Array con todas las notas existentes
	*/
	public function listadoNotas(){        
		$result = $this->mysqli->query("SELECT * FROM notas");          
		$listado = $result->fetch_all(MYSQLI_ASSOC);          
		$result->close();
		return $listado; 
	}
	/**
	* añade una nueva nota a la tabla de notas
	* @param String $titulo titulo de la nota
	* @param String $cuerpo cuerpo de la nota
	*@param String $usuario Usuario que inserta la nota
	* @return bool TRUE|FALSE 
	*/
	public function insertaNota($titulo='',$cuerpo='',$usuario=''){
		$query = $this->mysqli->prepare("INSERT INTO notas(titulo,cuerpo,usuario) VALUES (?,?,?); ");
		$query->bind_param('sss', $titulo,$cuerpo,$usuario);
		$r = $query->execute(); 
		$query->close();
		return $r;        
	}

	/**
	* Devuelve todas las notas del usuario marcadas como favoritas
	* @param  $usuario  nombre del usuario
	* @return Array array con los registros obtenidos de la base de datos
	*/
	public function consultaNotaFavorita($usuario=''){
		$query = $this->mysqli->prepare("SELECT * FROM  notas where id in(Select idNotas from notasfavoritas where usuario=? and favorita=1);");
		$query->bind_param("s", $usuario); 
		$query->execute();
		$result=$query->get_result();
		$listado = $result->fetch_all(MYSQLI_ASSOC);  
		$query->close();
		return $listado; 
		//
	}
	/*
	*Marco una nota como favorita
	*@param $id id de la nota
	*@param $usuario usuario que marca la nota como favorita
	*@return TRUE|FALSE
	*/
	public function notaFavorita($id=0,$usuario='') {
		if(($this->compruebaNotasfavoritas($id,$usuario))){
			$query = $this->mysqli->prepare("INSERT INTO notasfavoritas(idNotas,usuario,favorita) VALUES (?,?,1); ");
			$query->bind_param('is', $id,$usuario);
			$r = $query->execute(); 		
			$query->close();
			return $r;        
		}else{
			return true;
		}
	}
	/*
	*Comprueba si una nota esta marcada como favorita
	*@param $id id de la nota
	*@param $usuario usuario que marca la nota como favorita
	*@return TRUE|FALSE
	*/
	public function compruebaNotasfavoritas($id=0,$usuario=''){
		$query = $this->mysqli->prepare("SELECT  idNotas FROM notasfavoritas WHERE usuario=? and idNotas=?");
		$query->bind_param('si', $usuario,$id);
		
		if($query->execute());{
			
			$d=$query->store_result();
			if($query->num_rows==1){
				$query->close();
				return false;
			}
		}
		$query->close();
		return true;
	}

	/*
	*Comprueba si el usuario esta registrado 
	*@param $pass password
	*@param $usuario usuario que marca la nota como favorita
	*@return TRUE|FALSE
	*/
	public function compruebaUsuario($usuario='',$pass=''){
		$query = $this->mysqli->prepare("SELECT  usuario FROM usuarios WHERE usuario=? and pass=?");
		$query->bind_param('ss', $usuario,$pass);
		if($query->execute());{
			$query->store_result();
			if($query->num_rows==1){
				$query->close();
				
				return true;
				
			}
		}
		$query->close();
		return false;
	}
}
?>