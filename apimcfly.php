

<?php
require_once "dbmcfly.php";
class flyAPI {
//La accion que se quiere realizar en la api tiene que venir como variable en $_GET
	 public function API(){
		header('Content-Type: application/JSON');                
		if($this-> compruebaUsuario()){
			
			if(isset($_GET['accion'])){
				$accion=$_GET['accion'];
				if($accion=='InsertarNotas'){
					$this->insertarNota();
				}
				elseif($accion=='ConsultaUnaNota'){
					$this->consultaUnaNota();
				}
				elseif($accion=='MarcasNotas'){
					$this->marcasNotas();
				}
				elseif($accion=='listadoNotas'){
					$this->listadoNotas();
				}
				elseif($accion=='ConsultaNotaFavorita'){
					$this->consultaNotaFavorita();
				}
				elseif($accion=='Help'){
					$this->help();
				}else{
					//No se ha indicado ninguna accion disponible
					echo json_encode( 'No se ha seleccionado ninguna acción disponible',JSON_PRETTY_PRINT);
				}
				}else{
						echo json_encode( 'No se ha seleccionado ninguna acción disponible',JSON_PRETTY_PRINT);
				}
		}else{
			echo json_encode('Usuario no registrado o no loggeado.',JSON_PRETTY_PRINT);
		}
	}
	/*
	*Pide a la bbdd todas las notas publicadas y las envia
	*/
	private function listadoNotas (){ 
		$db = new dbMcfly(); 
             $response = $db->listadoNotas();                
             echo json_encode($response,JSON_PRETTY_PRINT);
	}
	/**
	*Llama a la bbdd  para inserta un nota
	*
	*/
	private function insertarNota (){
		if(isset($_GET['titulo']) and isset($_GET['cuerpo'])){
			if($_GET['titulo']!=null and $_GET['cuerpo']!=null){
				$db = new dbmcfly(); 
				$response = $db->insertaNota($_GET['titulo'],$_GET['cuerpo'],$_SESSION['usuario']);                
				if($response){
					echo json_encode('Nota insertada.',JSON_PRETTY_PRINT);
				}else{
					echo json_encode('Nota no insertada.',JSON_PRETTY_PRINT);
				}
			}else{
				echo json_encode('Nota no insertada.',JSON_PRETTY_PRINT); 
			}
		}
	}
	/**
	* Llama a dbmcfly para recuperar todas las notas existentes
	*/
	private function consultaUnaNota(){
		if(isset($_GET['id'])){
			$db = new dbMcfly(); 
			$response = $db->consultaNota($_GET['id']);                
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
	}
	/*
	*Llama a l bbdd para marcar una nota como favorita
	*/	
	private function marcasNotas(){
		if(isset($_GET['id']) and  $_GET['id']!=null){
			$db = new dbMcfly(); 
			$response = $db->notaFavorita($_GET['id'],$_SESSION['usuario']);         
				if($response){
					echo json_encode('Nota marcada como favorita.',JSON_PRETTY_PRINT);
				}else{
					echo json_encode('La nota no se ha podido marcar como favorita.',JSON_PRETTY_PRINT);
				}
		}
	}
	/*
	*Devuelve las notas marcadas como favoritas del usuario
	*/
	private function consultaNotaFavorita(){
		$db = new dbMcfly(); 
		$response = $db->consultaNotaFavorita($_SESSION['usuario']);                
		echo json_encode($response,JSON_PRETTY_PRINT); 
	}
	/**
	* Comprueba que la conexion esta en funcionamiento
	*/
	private function help(){
		$cabecera=['Acciones disponibles','InsertarNotas','ConsultaUnaNota','MarcasNotas','listadoNotas','ConsultaNotaFavorita','Help'];
		echo json_encode($cabecera,JSON_PRETTY_PRINT);
	}
	/*
	*Comprueba si el usuario estaz conectado
	*@return TRUE|FALSE
	*/
	private function compruebaUsuario(){
		if(isset($_SESSION['usuario'])and isset($_SESSION['pass'])){
			$db = new dbMcfly(); 
			return $db->compruebaUsuario($_SESSION['usuario'], $_SESSION['pass']);
		}else{
			
			return false;
		}
	}
}
?>