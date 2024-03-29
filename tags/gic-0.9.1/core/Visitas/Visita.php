<?php
/**
 * Clase que gestiona las Visitas.
 */
include_once('../../html/Utils/utils.php');
class Visita{

	/**
	 * Identificador de la Visita. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * usuario que realiza la visita.
	 * @var string con el id del usuario
	 */
	private $id_usuario;

	/**
	 * proyecto asociado a la visita.
	 * @var array indexado por id y nombre
	 */
	private $proyecto;
	
	/**
	 * Fecha en formato timestamp.
	 * @var integer
	 */
	private $fecha;
	
	private $hora;

	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Visita.
	 *
	 * Si recibe un identificador válido, se carga la Visita de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una Visita nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_visita Id de la Visita. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Visita en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Visita válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT visitas.*, proyectos.id as id_proyecto, proyectos.nombre as nombre_proyecto
						FROM visitas
						INNER JOIN proyectos ON visitas.fk_proyecto = proyectos.id
						WHERE visitas.id = '$this->id'";

			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Visita de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Visita en la BBDD");

			$row = mysql_fetch_array($result);

			$this->fecha = $row['fecha'];
			$this->hora = $row['hora'];$this->id_usuario =$row['fk_usuario'];
			$this->proyecto = array('id'=>$row['id_proyecto'], 'nombre'=>$row['nombre_proyecto']);

		}
	}


	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Devuelve la fecha 
	 * @return int $fecha
	 */
	public function get_Fecha(){
		return $this->fecha;
	}

	/**
	 *
	 * @return <integer> 0 no leída. 1 leída
	 */
	public function get_Hora(){
		return $this->hora;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve el id de id_usuario
	 * @return int $id_usuario
	 */
	public function get_Usuario(){
		return $this->id_usuario;
	}

	/**
	 * Devuelve el proyecto
	 * @return array $proyecto indexado por id y nombre
	 */
	public function get_Proyecto(){
		return $this->proyecto;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Visita en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Visita.
	 * @return integer $id_visita Id del nuevo Visita.
	 */
	public function crear($datos){

		$validar = new Validador();

		if(!$validar->hora($datos['hora']))
			throw new Exception("Visita: Ingrese una hora v&aacute;lida");
		if($datos['fecha'] == '' || ! isset($datos['fecha']))
			throw new Exception("Visita: La fecha es obligatoria.");
		if($datos['fecha'] < fechaActualTimeStamp())
			throw new Exception("La fecha ha de ser posterior a la actual");
		if($datos['id_proyecto'] == '' || ! isset($datos['id_proyecto']))
			throw new Exception("Visita: El proyecto de la visita es obligatorio .");
		if(!isset($datos['id_usuario']))
			throw new Exception("Visita: Usuario no v&aacute;lido.");

		$this->hora = trim($datos['hora']);
		$this->fecha = trim($datos['fecha']);
		$this->proyecto = trim($datos['id_proyecto']); //ojo, este atributo luego es un array
		$this->id_usuario = trim($datos['id_usuario']);

		//Si todo ha ido bien:
		return $this->guardar();
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * visita, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una visita.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		
		$query = "
			INSERT INTO visitas (   fecha,
									fk_proyecto,
									fk_usuario,
									hora
								)VALUES(
									'$this->fecha',
									'$this->proyecto',
									'$this->id_usuario',
									'$this->hora'
								);"; FB::info($query);

		if(!mysql_query($query))
			throw new Exception("Error al crear la Visita");
		$this->id = mysql_insert_id();

		$this->cargar();

		return $this->id;
	}

	/**
	 * Modifica la fecha  de la visita
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE visitas SET fecha='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	public function set_Hora($hora){
		$validar = new Validador();
		if($validar->hora($hora)){
			$query = "UPDATE visitas SET hora='$hora' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la hora en la BBDD.");
			$this->hora = $hora;

		}else
			throw new Exception("No se ha podido cambiar la hora de la visita.");
	}

	/**
	 * Modifica el id_usuario de la visita
	 * @param int $id_usuario nuevo id_usuario
	 */
	public function set_Id_Usuario($id_usuario){
		if($id_usuario){
			$query = "UPDATE visitas SET fk_usuario='$id_usuario' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el id_usuario en la BBDD.");
			$this->id_usuario = $id_usuario;

		}else
			throw new Exception("Debe introducir un id_usuario v&aacute;lido.");
	}

	public function del_Visita(){
		$query = "DELETE FROM visitas WHERE id='$this->id'";
			mysql_query($query);
	}
}
?>