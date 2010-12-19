<?php
/**
 * Clase que representa un Script de la aplicación.
 * 
 * @package G.Configuracion
 * @version 0.1
 * @author 
 * Juan Ramón González Hidalgo
 */
 class Script{
 	
 	private $id;
 	
 	private $ruta;
 	
	private $menu;
 	
 	private $descripcion;
  	
 	private $proceso;
 	
 	public function __construct($id=null){
 		if($id && is_numeric($id)){
 			$this->id = $id;
 			$this->cargar();
 		}
 	}
 	
 	private function cargar(){
 		if($this->id){
 			$query = "SELECT *
						FROM scripts
						WHERE id = '$this->id'; ";
 			if(!($result = mysql_query($query)) || mysql_num_rows($result)!=1)
 				throw new Exception("Error al buscar el script en la BBDD.");
 			$row = mysql_fetch_array($result);

 			$this->ruta = $row['ruta'];
 			$this->menu = $row['menu'];
 			$this->descripcion = $row['descripcion'];
 			$this->proceso = $row['fk_procesos'];
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
 	
 	public function get_Ruta(){
 		return $this->ruta;
 	}
 	
 	public function get_Menu(){
 		return $this->menu;
 	}
 	
 	public function get_Descripcion(){
 		return $this->descripcion;
 	}
 	
 	public function get_Proceso(){
 		if($this->proceso)
	  		return new Proceso($this->proceso);
	  	else
	  		return null;
 	}
 }
?>