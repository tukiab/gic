<?php
/**
 * Clase que gestiona los GruposEmpresas.
 */
include_once('../../html/Common/php/utils/utils.php');
class TipoDeAccion{

	/**
	 * Identificador de el TipoDeAccion. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	
	/**
	 * nombre de el grupoEmpresas.
	 * @var string
	 */
	private $nombre;


	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase TipoDeAccion.
	 *
	 * Si recibe un identificador válido, se carga el TipoDeAccion de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una TipoDeAccion nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_grupoEmpresas Id de el TipoDeAccion. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el TipoDeAccion en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de TipoDeAccion válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT acciones_tipos.*
					FROM acciones_tipos
					WHERE id = '$this->id'";
			////FB::info($query,'TipoDeAccion->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar el Tipo de acci�n de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado el Tipo de acci�n en la BBDD");

			$row = mysql_fetch_array($result);

			$this->nombre = $row['nombre'];
		}
	}


	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la nombre
	 * @return string $nombre
	 */
	public function get_nombre(){
		return $this->nombre;
	}

	
	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva TipoDeAccion en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva TipoDeAccion.
	 * @return integer $id_grupoEmpresas Id del nuevo TipoDeAccion.
	 */
	public function crear($datos){
		////FB::info($datos,'TipoDeAccion crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear una grupoEmpresas nuevo:
		 * 		nombre
		 *
		 */
		$validar = new Validador();
					
		//Comprobando los datos "imprescindibles":
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			throw new Exception("TipoDeAccion: El nombre es obligatorio.");
			
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * grupoEmpresas, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una grupoEmpresas.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){

		$query = "
			INSERT INTO acciones_tipos (nombre) VALUES('".mysql_real_escape_string(trim($datos['nombre']))."');";
									////FB::info($query,'TipoDeAccion crear: QUERY');
									if(!mysql_query($query))
										throw new Exception("Error al crear el tipo de accion.");
									$this->id = mysql_insert_id();

									return $this->id;
	}

	/**
	 * Modifica la nombre  de el grupoEmpresas
	 * @param int $nombre nueva nombre 
	 */
	public function set_nombre($nombre){
		$validar = new Validador();
		if($validar->cadena($nombre)){
			$query = "UPDATE acciones_tipos SET nombre='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el nombre en la BBDD.");
			$this->nombre = $nombre;

		}else
		throw new Exception("Debe introducir un nombre v&aacute;lido.");
	}

	public function eliminar(){
		$query = "DELETE FROM acciones_tipos WHERE id = '$this->id';";
		mysql_query($query);
	}	
}
?>
