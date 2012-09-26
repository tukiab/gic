<?php
/**
 * Clase que representa un Grupo de usuarios.
 * 
 * @package G.Configuracion
 * @version 0.1
 * @author 
 * Juan Ramón González Hidalgo
 */
 class Grupo{
 	
 	/**
 	 * Identificador del grupo.
 	 *
 	 * @var integer
 	 */
 	private $id;
 	
 	/**
 	 * Nombre del grupo
 	 *
 	 * @var string
 	 */
 	private $nombre;
 	
 	/**
 	 * Nombre corto del grupo (abreviatura)
 	 *
 	 * @var string
 	 */
	private $nombre_corto;
 	
	/**
	 * Descripción del grupo.
	 *
	 * @var string
	 */
 	private $descripcion;
  	
 	/**
 	 * Constructor de la clase.
 	 *
 	 * @param integer $id
 	 */
 	public function __construct($id=null){
 		if($id && is_numeric($id)){
 			$this->id = $id;
 			$this->cargar();
 		}
 	}
 	
 	/**
 	 * Carga los datos de un grupo de la BBDD.
 	 * Es invocado por el método {@link __construct()} cuando éste recibe un identificador válido.
 	 *
 	 */
 	private function cargar(){
 		if($this->id){
 			$query = "SELECT *
						FROM grupos_empresas
						WHERE id = '$this->id'; ";
 			if(!($result = mysql_query($query)) || mysql_num_rows($result)!=1)
 				throw new Exception("Error al buscar el grupo en la BBDD.");
 			$row = mysql_fetch_array($result);
 			
 			$this->nombre_corto = $row['nombre_corto'];
 			$this->nombre = $row['nombre'];
 			$this->descripcion = $row['descripcion'];
 		}
 	}
 	
 	/*
 	 * Métodos observadores
 	 ***********************/
 	
 	/**
 	 * Devuelve el identificador del grupo.
 	 * 
 	 * @return integer $id Identificador del grupo.
 	 */
 	public function get_Id(){
 		return $this->id;
 	}
 	
 	/**
 	 * Devuelve el nombre del grupo.
 	 *
 	 * @return string $Nombre Nombre del grupo.
 	 */
 	public function get_Nombre(){
 		return $this->nombre;
 	}
 	
 	/**
 	 * Devuelve el nombre corto (abreviatura) del grupo.
 	 *
 	 * @return string $nombre_corto Nombre corto del grupo.
 	 */
 	public function get_Nombre_Corto(){
 		return $this->nombre_corto;
 	}
 	
 	/**
 	 * Devuelve la descripción del grupo.
 	 *
 	 * @return string $descripcion Descripción del grupo.
 	 */
 	public function get_Descripcion(){
 		return $this->descripcion;
 	}
 	
 	/**
 	 * Devuelve un objeto "Iterable" con la lista de Operadores pertenecientes al grupo.
 	 *
 	 * @return ListaOperadores $ListaOperadores Lista de operadores pertenecientes al grupo.
 	 */
 	public function get_Miembros(){
 		$ListaOperadores = new ListaOperadores();
 		
 		$ListaOperadores->buscar(array('grupos'=>"$this->id"));
	 	return $ListaOperadores;
 	}
 
 
 	public function crear($datos){
		//FB::info($datos,'Grupo crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear un gruponuevo:
		 *	nombre
		 *
		 */
			
		//Comprobando los datos "imprescindibles":
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			throw new Exception("Proveedor: El nombre es obligatorio.");
			
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * proveedor, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de un proveedor.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		if($this->existe($datos[nombre]))
			throw new Exception("Ya exite un grupo de empresas con el mismo nombre");
		$query = "
			INSERT INTO grupos_empresas (nombre)
							VALUES('".mysql_real_escape_string(trim($datos['nombre']))."');";
									//FB::info($query,'Grupo crear: QUERY');
									if(!mysql_query($query))
									throw new Exception("Error al crear el Grupo.");
									$this->id = mysql_insert_id();

									return $this->id;
	}
	
	private function existe($nombre){
		$query = "SELECT id FROM grupos_empresas WHERE nombre='$nombre'";
		$rs = mysql_query($query);
		if(mysql_num_rows($rs)>0)
			return true;
		return false;
	}
	
	public function set_Nombre($nombre){
		//FB::info($nombre,'guardar el nombre del gurpo:');
	if($this->id && strcmp($this->nombre, $nombre) != 0){
			
				$query = "UPDATE grupos_empresas SET nombre='".mysql_real_escape_string($nombre)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el nombre en la BBDD.");
					
				$this->nombre = $nombre;
			
		}
	}
	
	public function eliminar(){
		$query = "DELETE FROM grupos_empresas WHERE id = '$this->id';";
		$rs = mysql_query($query);
	}
 }
?>