<?php
/**
 * Clase que gestiona las Tareas.
 */
include_once('../../html/Common/php/utils/utils.php');
class Tarea{

	/**
	 * Identificador de la Tarea. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * Tipo de la Tarea
	 * @var array indexado por id y nombre
	 */
	private $tipo;
	private $id_tipo;
	/**
	 * usuario que realiza la tarea.
	 * @var string con el id del usuario
	 */
	private $id_usuario;
	
	/**
	 * Fecha en formato timestamp.
	 * @var integer
	 */
	private $fecha;

	/**
	 * observaciones de la tarea.
	 * @var string
	 */
	private $observaciones;
	
	private $incentivable;

	private $horas_desplazamiento ;
	private $horas_visita ;
	private $horas_despacho ;
	private $horas_auditoria_interna ;
	private $id_proyecto ;
	private $proyecto;
	private $id_sede ;
	private $sede;

	private $cliente=null;


	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Tarea.
	 *
	 * Si recibe un identificador válido, se carga la Tarea de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una Tarea nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_tarea Id de la Tarea. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Tarea en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Tarea válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT tareas_tecnicas.*
						FROM tareas_tecnicas
						WHERE tareas_tecnicas.id = '$this->id'";
			//FB::info($query,'Tarea->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Tarea de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Tarea en la BBDD");

			$row = mysql_fetch_array($result);

			$this->fecha = $row['fecha'];
			$this->incentivable = $row['incentivable'];
			$this->observaciones = $row['observaciones'];
			$this->id_usuario =$row['fk_usuario'];
			$this->horas_desplazamiento =$row['horas_desplazamiento'];
			$this->horas_visita =$row['horas_visita'];
			$this->horas_despacho =$row['horas_despacho'];
			$this->horas_auditoria_interna =$row['horas_auditoria_interna'];
			$this->id_tipo = $row['fk_tipo'];
			$this->tipo = array('id'=>$row['fk_tipo'], 'nombre'=>$row['nombre_tipo']);
			$this->id_proyecto =$row['fk_proyecto'];
			$this->proyecto = array('id'=>$row['fk_proyecto'], 'nombre'=>$row['nombre_proyecto']);
			$this->id_sede =$row['fk_sede'];
			$this->sede = array('id'=>$row['fk_sede'], 'localidad'=>$row['localidad_sede']);
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
	 * Indica si la tarea es incentivable o no
	 * @return <integer> 0 no leída. 1 leída
	 */
	public function get_Incentivable(){
		return $this->incentivable;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la observaciones
	 * @return string $observaciones
	 */
	public function get_Observaciones(){
		return $this->observaciones;
	}

	/**
	 * Devuelve el id de usuario
	 * @return int $usuario
	 */
	public function get_Id_Usuario(){
		return $this->id_usuario;
	}

	public function get_Usuario(){
		return new Usuario($this->id_usuario);
	}

	/**
	 * Devuelve el tipo de tarea
	 * @return array $tipo indexado por id y nombre
	 */
	public function get_tipo(){
		return $this->tipo;
	}

	/**
	 * Devuelve las horas de desplazamiento
	 * @return <integer>
	 */
	public function get_Horas_Desplazamiento(){
		return $this->horas_desplazamiento;
	}
	/**
	 * Devuelve las horas de visita
	 * @return <integer>
	 */
	public function get_Horas_Visita(){
		return $this->horas_visita;
	}
	/**
	 * Devuelve las horas de dewspacho
	 * @return <integer>
	 */
	public function get_Horas_Despacho (){
		return $this->horas_despacho;
	}
	/**
	 * Devuelve las horas de auditoría interna
	 * @return <integer>
	 */
	public function get_Horas_Auditoria_Interna(){
		return $this->horas_auditoria_interna;
	}
	/**
	 * Devuelve el id del proyecto asociado
	 * @return <integer>
	 */
	public function get_Id_Proyecto(){
		return $this->id_proyecto;
	}
	/**
	 * Devuelve el objeto proyecto asociado
	 * @return Proyecto
	 */
	public function get_Proyecto(){
		return $this->proyecto;
	}
	/**
	 * Devuelve el id de la sede a la que se realiza la tarea
	 * @return <integer>
	 */
	public function get_Id_Sede() {
		return $this->id_sede;
	}
	/**
	 * Devuelve el objeto Sede sobre el que se realiza la tarea
	 * @return Sede
	 */
	public function get_Sede(){
		return $this->sede;
	}

	public function get_Cliente(){
		if(!$this->cliente){
			$query = "SELECT fk_cliente as id, razon_social_cliente as razon_social FROM proyectos WHERE id = '$this->id_proyecto' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('Error al recuperar la empresa de la tarea');
			$this->cliente = mysql_fetch_array($result);
		}

		return $this->cliente;
	}
	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Tarea en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Tarea.
	 * @return integer $id_tarea Id del nuevo Tarea.
	 */
	public function crear($datos){
		
		$validar = new Validador();
		$ListaTareas = new ListaTareas();

		$array_tipos = $ListaTareas->lista_Tipos();
					
		//Comprobando los datos "imprescindibles":
		if($datos['fecha'] == '' || ! isset($datos['fecha']))
			throw new Exception("Tarea: La fecha es obligatoria.");
		if(!is_numeric($datos['tipo']) || !in_array($datos['tipo'], array_keys($array_tipos)))
			throw new Exception("Tarea: Tipo de tarea no válido.");
		if(!isset($datos['id_proyecto']))
			throw new Exception("Tarea: Proyecto no v&aacute;lido.");
		if(!isset($datos['id_sede']))
			throw new Exception("Tarea: Sede no v&aacute;lida.");

		$this->fecha		= trim($datos['fecha']);
		$this->id_tipo		= trim($datos['tipo']);
		$this->id_proyecto	= trim($datos['id_proyecto']);
		$proyecto = new Proyecto($this->id_proyecto);
		$this->proyecto		= array('id' => $this->id_proyecto, 'nombre' => $proyecto->get_Nombre()	);
		$this->id_sede		= trim($datos['id_sede']);
		
		$query = "SELECT id,localidad FROM clientes_sedes WHERE id='".$this->id_sede."' LIMIT 1";
		if(!$result=  mysql_query($query))
			throw new Exception('No existe la sede');
		$this->sede			= mysql_fetch_array($result);


		//El usuario es el técnico asignado del proyecto
		if($proyecto->get_Id_Usuario())
			$this->id_usuario	= $proyecto->get_Id_Usuario();
		else
			throw new Exception('No se puede crear una tarea a un proyecto sin t&eacute;cnico asignado');


		// Ahora vemos de qué tipo es la tarea, y en función del tipo que sea vemos sus datos obligatorios.
		if($this->id_tipo == 2){//Documentación: los datos obligatorios son horas_despacho
			if(!isset($datos['horas_despacho'])
					|| !is_numeric($datos['horas_despacho']))
				throw new Exception('Las horas de despacho no son v&aacute;lidas.');

			$this->horas_despacho = trim($datos['horas_despacho']);
			$this->horas_auditoria_interna = 0;
			$this->horas_visita = 0;
			$this->horas_desplazamiento = 0;
		}
		else{//Visita de auditoría interna o externa, o visita de seguimiento: los datos obligatorios son horas_desplazamiento y horas_visita
			if(!isset($datos['horas_visita']) && !isset($datos['horas_desplazamiento'])
					|| !is_numeric($datos['horas_visita']) && !is_numeric($datos['horas_desplazamiento']))
				throw new Exception('Las horas de desplazamiento y/o de visita no son v&aacute;lidas.');

			$this->horas_visita = trim($datos['horas_visita']);
			$this->horas_desplazamiento = trim($datos['horas_desplazamiento']);
			$this->horas_auditoria_interna = 0;
			$this->horas_despacho = 0;
		}

		//Falta por ver si las horas son o no incentivables:
		//$proyecto = new Proyecto($this->id_proyecto);
		$this->incentivable = 0;
		if($this->fecha < $proyecto->get_Fecha_Fin())
			$this->incentivable = 1;

		$this->observaciones = mysql_real_escape_string($datos['observaciones']);

		//Por último comprobamos que el usuario que crea la tarea es el asignado al proyecto
		//$proyecto = new Proyecto($this->id_proyecto);
		if($this->id_usuario != $proyecto->get_Id_Usuario())
			throw new Exception('Tarea: no puede crear una tarea en un proyecto al que no est&aacute; asignado');

		//Si todo ha ido bien:
		return $this->guardar();
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * tarea, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una tarea.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar(){
		
		$query = "
			INSERT INTO tareas_tecnicas (  observaciones,
									fecha,
									fk_tipo,
									fk_usuario,
									fk_proyecto,
									horas_desplazamiento,
									horas_visita,
									horas_despacho,
									horas_auditoria_interna,
									incentivable,
									fk_sede
								)
						VALUES(
									'$this->observaciones',
									'$this->fecha',
									'$this->id_tipo',
									'$this->id_usuario',
									'$this->id_proyecto',
									'$this->horas_desplazamiento',
									'$this->horas_visita',
									'$this->horas_despacho',
									'$this->horas_auditoria_interna',
									'$this->incentivable',
									'$this->id_sede'
									
								);
		";
		
		if(!mysql_query($query))
			throw new Exception("Error al crear la Tarea.".$query);
		$this->id = mysql_insert_id();

		return $this->id;
	}

	/**
	 * Modifica la observaciones  de la tarea
	 * @param int $observaciones nueva observaciones
	 */
	public function set_Observaciones($observaciones){

		if($observaciones){
			$query = "UPDATE tareas_tecnicas SET observaciones='$observaciones' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->observaciones = $observaciones;

		}else
		throw new Exception("Debe introducir una descripci&oacute;n v&aacute;lida.");
	}

	/**
	 * Modifica la fecha  de la tarea
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha($fecha){
 
		if(is_numeric($fecha)){
			$query = "UPDATE tareas_tecnicas SET fecha='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha = $fecha;

			$proyecto = new Proyecto($this->id_proyecto);

			if($this->fecha < $proyecto->get_Fecha_Fin())
				$this->set_Incentivable(1);
			else
				$this->set_Incentivable(0);

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}
	public function set_Horas_Desplazamiento($horas){

		if(is_numeric($horas) || $horas==0 || $horas==0){
			$query = "UPDATE tareas_tecnicas SET horas_desplazamiento='$horas' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar las horas de desplazamiento en la BBDD.");
			$this->horas_desplazamiento = $horas;

		}else
		throw new Exception("Debe introducir un valor v&aacute;lido.");
	}
	public function set_Horas_Visita($horas){

		if(is_numeric($horas) || $horas==0){
			$query = "UPDATE tareas_tecnicas SET horas_visita='$horas' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar las horas de visita en la BBDD.");
			$this->horas_visita = $horas;

		}else
		throw new Exception("Debe introducir un valor v&aacute;lido.");
	}
	public function set_Horas_Despacho($horas){

		if(is_numeric($horas) || $horas==0){
			$query = "UPDATE tareas_tecnicas SET horas_despacho='$horas' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar las horas de despacho en la BBDD.");
			$this->horas_despacho = $horas;

		}else
		throw new Exception("Debe introducir un valor v&aacute;lido.");
	}
	public function set_Horas_Auditoria_Interna($horas){

		if(is_numeric($horas) || $horas==0){
			$query = "UPDATE tareas_tecnicas SET horas_auditoria_interna='$horas' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar las horas de auditor&iacute;a interna en la BBDD.");
			$this->horas_auditoria_interna = $horas;

		}else
		throw new Exception("Debe introducir un valor v&aacute;lido.");
	}

	public function del_Tarea(){
		$query = "DELETE FROM tareas_tecnicas WHERE id='$this->id'";
		mysql_query($query);
	}

	private function set_Incentivable($value){
		$query = "UPDATE tareas_tecnicas set incentivable='$value' WHERE id='$this->id'";
		if(!mysql_query($query))
			throw new Exception ('Error al establecer el incetivable de la tarea');
	}
}
?>
