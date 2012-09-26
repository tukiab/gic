<?php
/**
 * Clase que gestiona las Acciones.
 */
include_once('../../html/Common/php/utils/utils.php');
class Accion{

	/**
	 * Identificador de la Accion. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * Tipo de la Accion
	 * @var array indexado por id y nombre
	 */
	private $tipo_accion;

	/**
	 * usuario que realiza la accion.
	 * @var string con el id del usuario
	 */
	private $usuario;

	/**
	 * cliente asociado a la accion.
	 * @var array indexado por id y razon_social
	 */
	private $cliente;
	
	/**
	 * Fecha en formato timestamp.
	 * @var integer
	 */
	private $fecha;

	/**
	 * Fecha de la siguiente accion en formato timestamp.
	 * @var integer
	 */
	private $fecha_siguiente_accion;

	/**
	 * Descripcion de la accion.
	 * @var string
	 */
	private $descripcion;

	/**
	 * Indica si la acción está leída o no
	 * @var <type>
	 */
	private $leida;


	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Accion.
	 *
	 * Si recibe un identificador válido, se carga la Accion de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una Accion nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_accion Id de la Accion. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Accion en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Accion válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT acciones_de_trabajo.*
						FROM acciones_de_trabajo
						WHERE acciones_de_trabajo.id = '$this->id'";
			//FB::info($query,'Accion->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Accion de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Accion en la BBDD");

			$row = mysql_fetch_array($result);

			$this->fecha_siguiente_accion = $row['fecha_siguiente_accion'];
			$this->fecha = $row['fecha'];
			$this->leida = $row['leida'];
			$this->descripcion = $row['descripcion'];
			$this->tipo_accion = array('id'=>$row['fk_tipo_accion'], 'nombre'=>$row['nombre_tipo_accion']);
			$this->usuario =$row['fk_usuario'];
			$this->cliente = array('id'=>$row['fk_cliente'], 'razon_social'=>$row['razon_social_cliente']);

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
	public function get_Leida(){
		return $this->leida;
	}

	/**
	 * Devuelve la fecha de la siguiente accion
	 * @return int $fecha
	 */
	public function get_Fecha_Siguiente_Accion(){
		return $this->fecha_siguiente_accion;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la descripcion
	 * @return string $descripcion
	 */
	public function get_Descripcion(){
		return $this->descripcion;
	}

	/**
	 * Devuelve el id de usuario
	 * @return int $usuario
	 */
	public function get_Usuario(){
		return $this->usuario;
	}

	/**
	 * Devuelve el tipo de accion
	 * @return array $tipo_accion indexado por id y nombre
	 */
	public function get_Tipo_Accion(){
		return $this->tipo_accion;
	}

	/**
	 * Devuelve el cliente
	 * @return array $cliente indexado por id y razon_social
	 */
	public function get_Cliente(){
		return $this->cliente;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Accion en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Accion.
	 * @return integer $id_accion Id del nuevo Accion.
	 */
	public function crear($datos){
		//FB::info($datos,'Accion crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear una accion nuevo:
		 * 		descripcion
		 * 		tipo_accion
		 * 		cliente
		 * 		id_usuario
		 * 		fecha
		 *
		 */
		$validar = new Validador();
		$ListaAcciones = new ListaAcciones();
		$ListaUsuarios = new ListaUsuarios();

		$array_tipos = $ListaAcciones->lista_Tipos();
		$array_usuarios = $ListaUsuarios->lista_Usuarios();
					
		//Comprobando los datos "imprescindibles":
		if($datos['descripcion'] == '' || ! isset($datos['descripcion']))
			throw new Exception("Accion: La descripci&oacute;n es obligatoria.");
		if($datos['fecha'] == '' || ! isset($datos['fecha']))
			throw new Exception("Accion: La fecha es obligatoria.");
		if($datos['cliente'] == '' || ! isset($datos['cliente']))
			throw new Exception("Accion: La empresa de la acci&oacute;n es obligatorio .");
		if(!is_numeric($datos['tipo_accion']) || !in_array($datos['tipo_accion'], array_keys($array_tipos)))
			throw new Exception("Accion: Tipo de accion no válido.");
		if(!isset($datos['usuario']))
			throw new Exception("Accion: Usuario no v&aacute;lido.");

		if(isset($datos['fecha_siguiente_accion']) && $datos['fecha_siguiente_accion']!=''){
			$this->fecha_siguiente_accion = trim($datos['fecha_siguiente_accion']);
		}

		$this->descripcion = mysql_real_escape_string(trim($datos['descripcion']));
		$this->fecha = trim($datos['fecha']);

		//tipo de acción
		$query = "SELECT id,nombre FROM acciones_tipos WHERE id = '".trim($datos['tipo_accion'])."'";
		if(!$result = mysql_query($query))
			throw new Exception("Accion: Tipo de accion no válido.");
		$row=mysql_fetch_array($result);
		$this->tipo_accion = array('id'=>$row['id'], 'nombre'=>$row['nombre']);

		$this->usuario = trim($datos['usuario']);

		//cliente
		$query = "SELECT id,razon_social FROM clientes WHERE id = '".trim($datos['cliente'])."'";
		if(!$result = mysql_query($query))
			throw new Exception("Accion: Empresa no válido.");
		$row=mysql_fetch_array($result);
		$this->cliente = array('id'=>$row['id'], 'razon_social'=>$row['razon_social']);


		//Si todo ha ido bien:
		return $this->guardar();
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * accion, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una accion.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar(){
		
		$s_into.="";
		$s_values.="";

		if($this->fecha_siguiente_accion){
			$s_into.=",fecha_siguiente_accion";
			$s_values.=",'".$this->fecha_siguiente_accion."'";
		}

		$query = "
			INSERT INTO acciones_de_trabajo (  descripcion,
									fecha,
									fk_tipo_accion,
									nombre_tipo_accion,
									fk_usuario,
									fk_cliente,
									razon_social_cliente
									$s_into
								)VALUES(
									'".$this->descripcion."',
									'".$this->fecha."',
									'".$this->tipo_accion['id']."',
									'".$this->tipo_accion['nombre']."',
									'".$this->usuario."',
									'".$this->cliente['id']."',
									'".$this->cliente['razon_social']."'
									$s_values
								);
		";
									//FB::info(timestamp2date($datos['fecha'])." hoy, siguiente: ".timestamp2date($datos['fecha_siguiente_accion']),'fechas de b�squeda');
									//FB::info($query,'Accion crear: QUERY');
									if(!mysql_query($query))
										throw new Exception("Error al crear la Accion.".$query);
									$this->id = mysql_insert_id();

									return $this->id;
	}

	/**
	 * Modifica la descripcion  de la accion
	 * @param int $descripcion nueva descripcion 
	 */
	public function set_Descripcion($descripcion){

		if($descripcion){
			$query = "UPDATE acciones_de_trabajo SET descripcion='$descripcion' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->descripcion = $descripcion;

		}else
		throw new Exception("Debe introducir una descripci&oacute;n v&aacute;lida.");
	}

	/**
	 * Modifica la fecha  de la accion
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE acciones_de_trabajo SET fecha='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	public function set_Leida($leida){
		if(is_numeric($leida)){
			$query = "UPDATE acciones_de_trabajo SET leida='$leida' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la lectura en la BBDD.");
			$this->leida = $leida;

		}else
		throw new Exception("No se ha podido cambiar la lectura de la accion.");
	}

	public function leer(){
		$this->set_Leida(1);
	}

	/**
	 * Modifica la fecha de la siguiente accion
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha_Siguiente_Accion($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE acciones_de_trabajo SET fecha_siguiente_accion='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de la siguiente acci&oacute;n en la BBDD.");
			$this->fecha = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica el usuario de la accion
	 * @param int $id_usuario nuevo usuario
	 */
	public function set_Usuario($id_usuario){
		$ListaUsuarios = new ListaUsuarios();
		$array_usuarios = $ListaUsuarios->lista_Usuarios();

		if(is_numeric($id_usuario) && in_array($id_usuario, array_keys($array_usuarios))){
			$query = "UPDATE acciones_de_trabajo SET fk_usuario='$id_usuario' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el usuario en la BBDD.");

			$this->usuario = $id_usuario;

		}else
		throw new Exception("Debe introducir un usuario v&aacute;lido.");
	}

	/**
	 * Modifica el cliente de la accion
	 * @param int $id_cliente nuevo cliente
	 */
	public function set_Cliente($id_cliente){
		if(is_numeric($id_cliente)){			
			$query = "SELECT id, nombre FROM clientes WHERE id= '$id_cliente' limit 1;";
			if(!$rs = mysql_query($query))
				throw new Exception ('Empresa no válida');
			$row = mysql_fetch_array($rs);

			$query = "UPDATE acciones_de_trabajo 
						SET fk_cliente='$id_cliente',
							razon_social_cliente='".$row['razon_social']."'
						WHERE id='$this->id'";
			
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el cliente en la BBDD.");			

			$this->cliente = array('id'=>$row['id'], 'razon_social'=>$row['razon_social']);

		}else
			throw new Exception("Debe introducir una empresa v&aacute;lido.");
	}

	/**
	 * Modifica el tipo de la accion
	 * @param int $id_tipo nuevo tipo
	 */
	public function set_Tipo($id_tipo){

		if(is_numeric($id_tipo)){
			$query = "SELECT id, nombre FROM acciones_tipos WHERE id= '$id_tipo' limit 1;";
			if(!$rs = mysql_query($query))
				throw new Exception('Tipo de acci&oacute; no v&aacute;lido');
			$row = mysql_fetch_array($rs);

			$query = "UPDATE acciones_de_trabajo 
						SET fk_tipo_accion='$id_tipo',
						nombre_tipo_accion='".$row['nombre']."'
						WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el tipo en la BBDD.");

			$this->usuario = array('id'=>$row['id'], 'nombre'=>$row['nombre']);

		}else
			throw new Exception("Debe introducir un tipo v&aacute;lido.");
	}

	public function del_Accion(){
		$query = "DELETE FROM acciones_de_trabajo WHERE id='$this->id'";
		mysql_query($query);
	}
}
?>
