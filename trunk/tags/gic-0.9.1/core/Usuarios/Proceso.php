<?php
/**
 * Clase que representa un Proceso de entre los que se encuentra dividida la aplicación
 * para la gestión de los permisos.
 * 
 * @package G.Configuracion
 * @version 0.1
 * @author 
 * Juan Ramón González Hidalgo
 */
 class Proceso{
 	
 	private $id;
 	
 	private $nombre;
 	
	private $nombre_corto;
 	
 	private $descripcion;
  	
 	private $scripts=array();
 	
 	public function __construct($id=null){
 		if($id && is_numeric($id)){
 			$this->id = $id;
 			$this->cargar();
 		}
 	}
 	
 	private function cargar(){
 		if($this->id){
 			$query = "SELECT *
						FROM procesos
						WHERE id = '$this->id'; ";
 			if(!($result = mysql_query($query)) || mysql_num_rows($result)!=1)
 				throw new Exception("Error al buscar el proceso en la BBDD.");
 			$row = mysql_fetch_array($result);

 			$this->nombre = $row['nombre'];
 			$this->descripcion = $row['descripcion'];
 			
 			$this->cargar_Scripts();
 		}
 	}
 	
 	private function cargar_Scripts(){
 		$query = "SELECT id 
					FROM scripts
					WHERE fk_procesos = '$this->id'; ";
 		if(!($result = mysql_query($query)))
 			throw new Exception("Error al cargar los scripts pertenecientes al proceso de la BBDD.");
 		
 		while($row = mysql_fetch_array($result))
 			array_push($this->scripts, $row['id']);
 	}
 	
 	/*
 	 * Métodos observadores
 	 ***********************/
 	
 	public function get_Id(){
 		return $this->id;
 	}
 	
 	public function get_Nombre(){
 		return $this->nombre;
 	}
 	
 	public function get_Descripcion(){
 		return $this->descripcion;
 	}
 	
 	public function get_Scripts(){
 		$Scripts = array();
 		
 		foreach($this->scripts as $id_Script)
 			array_push($Scripts, new Script($id_Script));
 			
 		return $Scripts;
 	}
 }
?>