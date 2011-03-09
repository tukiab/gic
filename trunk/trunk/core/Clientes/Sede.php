<?php
/**
 * Clase que gestiona los clientes_sedes.
 */
include_once('../../html/Utils/utils.php');
class Sede{

	/**
	 * Identificador dla sede. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * Domicilio dla sede.
	 * @var string
	 */
	private $direccion;

	/**
	 * Localidad dla sede.
	 * @var string
	 */
	private $localidad;

	/**
	 * Provincia dla sede.
	 * @var string
	 */
	private $provincia;

	/**
	 * CP.
	 * @var integer
	 */
	private $CP;

	/**
	 * id cliente.
	 * @var integer
	 */
	private $id_cliente;

	/**
	 * Contactos dla sede.
	 * @var array de ids de contactos
	 */
	private $contactos;

	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Sede.
	 *
	 * Si recibe un identificador válido, se carga la sede de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar un Sede nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_sede Id dla sede. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la sede en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Sede válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT *
						FROM clientes_sedes
						WHERE id = '$this->id'";
			//FB::info($query,'Sede->cargar: QUERY');
			if(!($result = mysql_query($query)))
                            throw new Exception("Error al cargar la sede de la BBDD");
			else if(mysql_num_rows($result) == 0)
                            throw new Exception("No se ha encontrado la sede en la BBDD ".$this->id);

			$row = mysql_fetch_array($result);

			$this->CP = $row['CP'];
			$this->id_cliente = $row['fk_cliente'];
			$this->direccion = $row['direccion'];				
			$this->localidad = $row['localidad'];
			$this->provincia = $row['provincia'];			

			$this->cargar_Contactos();
		}
	}

	/**
	 * Carga la lista de contactos asociados a la sede.
	 */
	private function cargar_Contactos(){
		$query = "SELECT fk_contacto
					FROM clientes_sedes_rel_contactos
					WHERE fk_clientes_sede = '$this->id' AND fk_contacto <> '0'";

		$result = mysql_query($query);

		$this->contactos = array();
		while($row = mysql_fetch_array($result))
		$this->contactos[] = $row['fk_contacto'];
	}

	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Devuelve la lista de contactos
	 * @return array $contactos de ids de contactos
	 */
	public function get_Contactos(){
		return $this->contactos;
	}

	/**
	 * Devuelve el CP
	 * @return int $CP
	 */
	public function get_CP(){
		if($this->CP != '')
			return str_pad($this->CP,5,0,STR_PAD_LEFT);
		return '';
	}

	/**
	 * Devuelve los id_cliente
	 * @return int $id_cliente
	 */
	public function get_Id_Cliente(){
		return $this->id_cliente;
	}

	/**
	 * Devuelve el Obajeto Cliente asociado
	 * @return Cliente
	 */
	public function get_Cliente(){
		return new Cliente($this->id_cliente);
	}

	/**
	 * Devuelve el direccion
	 * @return string $direccion
	 */
	public function get_Direccion(){
		return $this->direccion;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la localidad
	 * @return string $localidad
	 */
	public function get_Localidad(){
		return $this->localidad;
	}

	public function get_Provincia(){
		return $this->provincia;
	}


	
	/**
	 * Devuelve la lista de contactos asociados a la sede.
	 *
	 * A partir del array de ids de Contactos almacenado en la variable local $contactos, crea un nuevo array
	 * de objetos Contacto, que será el devuelto por el método.
	 *
	 * @return array $array_Contactos Cada elemento es una instancia de la clase Contacto;
	 */
	public function get_Lista_Contactos(){
		$array_Contactos = array();
		foreach($this->contactos as $id_Contacto)
		array_push($array_Contactos, new Contacto($id_Contacto));

		return $array_Contactos;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea un nuevo Sede en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para un nuevo Sede.
	 * @return integer $id_sede Id del nuevo Sede.
	 */
	public function crear($datos){
		//FB::info($datos,'Sede crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear un sede nuevo:
		 * 		id_cliente
		 * 		localidad
		 */

			
		//Comprobando los datos "imprescindibles":
		$errores = '';
		if(!is_numeric($datos['id_cliente']) || ! isset($datos['id_cliente']))
			$errores .= "<br/>Sede: La empresa es obligatoria.";
		if($datos['localidad'] == '' || ! isset($datos['localidad']))
			$errores .= "<br/>Sede: La localidad es obligatoria.";
		
		if($errores != '') throw new Exception($errores);

		//Si todo ha ido bien:
		return $this->guardar($datos);
	}
	
	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * sede, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de un sede.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
	
		$s_into.="";
		$s_values.="";
		$validar = new Validador();
		
		if(isset($datos['direccion']) && $datos['direccion'] != ''){
			$s_into.=",direccion";
			$s_values.=",'".mysql_real_escape_string(trim($datos['direccion']))."'";
		}
		if(isset($datos['provincia']) && $datos['provincia'] != ''){
			$s_into.=",provincia";
			$s_values.=",'".mysql_real_escape_string(trim($datos['provincia']))."'";
		}
		if(isset($datos['CP']) && $datos['CP'] != ''){
			$s_into.=",CP";
			$s_values.=",'".trim($datos['CP'])."'";
		}
		if(isset($datos['es_sede_principal']) && $datos['es_sede_principal'] != ''){
			$s_into.=",es_sede_principal";
			$s_values.=",'".trim($datos['es_sede_principal'])."'";
		}

		$query = "
			INSERT INTO clientes_sedes (  fk_cliente,
									localidad
									$s_into
								)VALUES(
									'".trim($datos['id_cliente'])."',
									'".mysql_real_escape_string(trim($datos['localidad']))."'
									$s_values
								);
		";									
		if(!mysql_query($query))
			throw new Exception("Error al crear la sede.  ");
		$this->id = mysql_insert_id();
										
		if(isset($datos['ids_contactos'])){
			$this->add_Contactos($datos['ids_contactos']);
		}
		return $this->id;
	}
	
	public function get_DisableEdit(){
		$disable = array();
		$usuario = new Usuario($_SESSION['usuario_login']);
		if(!$usuario->esAdministrador()){ 
			
			
			if($this->localidad != '')
				$disable['localidad'] = 'readonly="readonly"';
			if($this->provincia != '')
				$disable['provincia'] = 'readonly="readonly"';
			if($this->CP != '')
				$disable['CP'] = 'readonly="readonly"';
			$disable['id_cliente'] = 'readonly="readonly"';
			if($this->direccion != '')
				$disable['direccion'] = 'readonly="readonly"';			
		}
		//FB::error($disable);
		return $disable;
	}

	public function set_Contactos($ids_contactos){
		$query = "DELETE FROM clientes_sedes_rel_contactos WHERE fk_clientes_sede = '$this->id'";
		mysql_query($query);

		$this->add_Contactos($ids_contactos);
	}

	public function add_Contactos($array_ids_contactos){
		foreach($array_ids_contactos as $id){
			$this->add_Contacto($id);
		}
	}

	public function add_Contacto($id_contacto){
		$Cliente = $this->get_Cliente();
		if(!$Cliente->tiene_Contacto($id_contacto))
			throw new Exception("No se puede agregar a la sede un contacto que no sea de su empresa");
		
		if(is_numeric($id_contacto)){
			$query = "INSERT INTO clientes_sedes_rel_contactos (fk_clientes_sede, fk_contacto) VALUES ('$this->id','$id_contacto')";
			if(!$rs = mysql_query($query))
				throw new Exception('Error al agregar el contacto a la sede');
		}

		$this->cargar_Contactos();
	}
	
	public function del_Contacto($id_contacto){
		$query = "DELETE FROM clientes_sedes_rel_contactos WHERE fk_contacto = '$id_contacto' AND fk_clientes_sede = '$this->id'; ";
		mysql_query($query);
	}

	public function tiene_Contacto($id){
		if($this->contactos)
		return in_array($id, $this->contactos);

		return false;
	}
	
	public function del_Sede(){
				
		$query = "DELETE FROM clientes_sedes WHERE id = '$this->id'; ";
		mysql_query($query);

		//Contactos
        $query = "DELETE FROM clientes_sedes_rel_contactos WHERE fk_clientes_sede = '$this->id'; ";
		mysql_query($query);
		
	}

	/**
	 * Modifica el nombre dla sede.
	 *
	 * @param int $CP nuevo CP
	 */
	public function set_CP($CP){
		$Validar = new Validador();

		if($this->id && $Validar->CP($CP)){

			$query = "UPDATE clientes_sedes SET CP='".trim($CP)."' WHERE id='$this->id' ";//FB::info($query);
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el CP en la BBDD.");

			$this->CP = $CP;
		}else
		throw new Exception("CP incorrecto.");
	}

	/**
	 * Modifica los id_cliente
	 *
	 * @param int $id_cliente
	 */
	public function set_Id_Cliente($id_cliente){

		if($this->id && (is_numeric($id_cliente) || $id_cliente=='' )){
			if($id_cliente!='')
				$query = "UPDATE clientes_sedes SET id_cliente='".trim($id_cliente)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE clientes_sedes SET id_cliente=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar los cr&eacute;ditos en la BBDD.");

			$this->id_cliente = $id_cliente;
		}else
		throw new Exception("Cr&eacute;ditos incorrecto.");
	}
	/**
	 * Modifica la localidad dla sede.
	 *
	 * Si la localidad es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $localidad Nueva localidad.
	 */
	public function set_Localidad($localidad){
		$Validar = new Validador();
		if($this->id && strcmp($this->localidad, $localidad) != 0){
			if($Validar->cadena($localidad)){
				$query = "UPDATE clientes_sedes SET localidad='".mysql_real_escape_string($localidad)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la localidad en la BBDD.");
					
				$this->localidad = $localidad;
			}else
			throw new Exception("Localidad incorrecta.");
		}
	}

	public function set_Provincia($provincia){
		$Validar = new Validador();
		if($this->id && strcmp($this->provincia, $provincia) != 0){
			if($Validar->cadena($provincia)){
				$query = "UPDATE clientes_sedes SET provincia='".mysql_real_escape_string($provincia)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la provincia en la BBDD.");
					
				$this->provincia = $provincia;
			}else
			throw new Exception("Provincia incorrecta.");
		}
	}

	/**
	 * Modifica la razon social dla sede.
	 *
	 * Si la razon social es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $direccion Nueva razon social.
	 */
	public function set_Direccion($direccion){
		$Validar = new Validador();
		if($this->id && strcmp($this->direccion, $direccion) != 0){
			if($Validar->cadena($direccion)){
				$query = "UPDATE clientes_sedes SET direccion='".mysql_real_escape_string($direccion)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la raz&oacute;n social en la BBDD.");
					
				$this->direccion = $direccion;
			}else
			throw new Exception("Direcci&oacute;n incorrecta.");
		}
	}
}
?>
