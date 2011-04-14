<?php
/**
 * Clase que gestiona los Proveedores.
 */
include_once('../../html/Common/php/utils/utils.php');
class Proveedor{

	/**
	 * Razón social del Proveedor.
	 * @var string
	 */
	private $razon_social;

	/**
	 * NIF del Proveedor.
	 * @var string
	 */
	private $NIF;

	/**
	 * Domicilio del Proveedor.
	 * @var string
	 */
	private $domicilio;

	/**
	 * Localidad del Proveedor.
	 * @var string
	 */
	private $localidad;

	/**
	 * Provincia del Proveedor.
	 * @var string
	 */
	private $provincia;

	/**
	 * Web del Proveedor.
	 * @var string
	 */
	private $web;

	private $CP;
	/**
	 * Contactos del proveedor.
	 * @var array de ids de contactos
	 */
	private $contactos;
	private $ofertas;

	private $validar;
	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Proveedor.
	 *
	 * Si recibe un NIF válido, se carga el Proveedor de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar un Proveedor nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $NIF NIF del Proveedor. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($NIF=null){
		$this->validar = new Validador();
		if($NIF && $this->validar->nif_cif($NIF)){
			$this->NIF = $NIF;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el Proveedor en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un NIF de Proveedor válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->NIF){
			$query = "SELECT proveedores.*
						FROM proveedores
				    		WHERE proveedores.NIF = '$this->NIF'";
			//FB::info($query,'Proveedor->cargar: QUERY');
			if(!($result = mysql_query($query)))
			throw new Exception("Error al cargar el Proveedor de la BBDD");
			else if(mysql_num_rows($result) == 0)
			throw new Exception("No se ha encontrado el Proveedor en la BBDD");

			$row = mysql_fetch_array($result);

			
			$this->domicilio = $row['domicilio'];
			$this->localidad = $row['localidad'];
			$this->provincia = $row['provincia'];
			$this->NIF = $row['NIF'];
			$this->razon_social = $row['razon_social'];
			$this->web = $row['web'];
			$this->CP = $row['CP'];
			
			$this->cargar_Contactos();
			$this->cargar_Ofertas();
		}
	}


	/**
	 * Carga la lista de contactos asociados al proveedor.
	 */
	private function cargar_Contactos(){
		$query = "SELECT fk_contacto
					FROM proveedores_rel_contactos
					WHERE fk_proveedor = '$this->NIF' AND fk_contacto <> '0'";

		$result = mysql_query($query);

		$this->contactos = array();
		while($row = mysql_fetch_array($result))
		$this->contactos[] = $row['fk_contacto'];
	}

	/**
	 * Carga la lista de ofertas asociadas al proveedor.
	 */
	private function cargar_Ofertas(){
		$query = "SELECT id
					FROM ofertas
					WHERE fk_proveedor = '$this->NIF' 
					; ";

		$result = mysql_query($query);

		$this->ofertas = array();
		while($row = mysql_fetch_array($result))
		$this->ofertas[] = $row['id'];
	}

	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Devuelve la lista de contactos
	 * @return array $contactos
	 */
	public function get_Contactos(){
		return $this->contactos;
	}

	/**
	 * Devuelve el domicilio
	 * @return string $domicilio
	 */
	public function get_Domicilio(){
		return $this->domicilio;
	}

	/**
	 * Devuelve las ofertas
	 * @return array $ofertas
	 */
	public function get_Ofertas(){
		return $this->ofertas;
	}

	/**
	 * Devuelve el NIF
	 * @return int $NIF
	 */
	public function get_NIF(){
		return $this->NIF;
	}

	public function get_CP(){
		return $this->CP;
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
	 * Devuelve la razón social
	 * @return string $razon_social
	 */
	public function get_Razon_Social(){
		return $this->razon_social;
	}
	/**
	 * Devuelve la web
	 * @return string $web
	 */
	public function get_Web(){
		return $this->web;
	}

	/**
	 * Devuelve la lista de contactos asociados al proveedor.
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
	/**
	 * Devuelve la lista de ofertas asociadas al proveedor.
	 *
	 * A partir del array de ids de ofertas almacenado en la variable local $ofertas, crea un nuevo array
	 * de objetos Oferta, que será el devuelto por el método.
	 *
	 * @return array $array_ofertas Cada elemento es una instancia de la clase Oferta;
	 */
	public function get_Lista_Ofertas(){
		$array_ofertas = array();
		foreach($this->ofertas as $id_oferta)
		array_push($array_ofertas, new Oferta($id_oferta));

		return $array_ofertas;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea un nuevo Proveedor en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el NIF asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para un nuevo Proveedor.
	 * @return integer $NIF NIF del nuevo Proveedor.
	 */
	public function crear($datos){
		FB::info($datos,'Proveedor crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear un proveedor nuevo:
		 * 		razon social
		 * 		NIF
		 * 		provincia
		 *
		 *
		 */
			
		//Comprobando los datos "imprescindibles":
		if($datos['razon_social'] == '' || ! isset($datos['razon_social']))
			throw new Exception("Proveedor: La raz&oacute;n social es obligatoria.");
		if($datos['NIF'] == '' || ! isset($datos['NIF']))
			throw new Exception("Proveedor: El CIF/NIF es obligatorio.");
		if(!$this->validar->nif_cif($datos['NIF']))
			throw new Exception("Proveedor: CIF/NIF no v&aacute;lido");
		if($datos['provincia'] == '' || ! isset($datos['provincia']))
			throw new Exception("Proveedor: La provincia es obligatoria.");
		if($datos['CP'] == '' || ! isset($datos['CP']))
			throw new Exception("Proveedor: El CP es obligatorio.");

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
		if(isset($datos['contacto_nombre']))
			$id_contacto = $this->crear_Contacto($datos);
		
		$s_into.="";
		$s_values.="";
		
		if(isset($datos['web'])){
			$s_into.=",web";
			$s_values.=",'".mysql_real_escape_string(trim($datos['web']))."'";
		}
		
		if(isset($datos['localidad'])){
			$s_into.=",localidad";
			$s_values.=",'".mysql_real_escape_string(trim($datos['localidad']))."'";
		}
		if(isset($datos['domicilio'])){
			$s_into.=",domicilio";
			$s_values.=",'".mysql_real_escape_string(trim($datos['domicilio']))."'";
		}
		
		$query = "
			INSERT INTO proveedores (NIF,razon_social,provincia,CP
									$s_into
								)VALUES(
									'".mysql_real_escape_string(trim($datos['NIF']))."',									
									'".mysql_real_escape_string(trim($datos['razon_social']))."',									
									'".mysql_real_escape_string(trim($datos['provincia']))."',
									'".trim($datos['CP'])."'
									$s_values
								);
		";
									FB::info($query,'Proveedor crear: QUERY');
									if(!mysql_query($query))
									throw new Exception("Error al crear el Proveedor.");
									$this->NIF = mysql_real_escape_string(trim($datos['NIF']));

									if(isset($datos['contactos'])){
										$this->add_Contactos($datos['contactos']);
									}

									//Lo relacionamos y salimos
									$this->relacionar_Contacto($id_contacto);

									return $this->NIF;
	}

	/**
	 * Crea un contacto nuevo indicado en la creación del Proveedor
	 * @param $datos
	 * @return unknown_type
	 */
	public function crear_Contacto($datos){
		$Contacto = new Contacto();
		$datos_contacto = array('nombre'=>$datos['contacto_nombre'],'telefono'=>$datos['contacto_telefono'],'email'=>$datos['contacto_email'],'cargo'=>$datos['contacto_cargo']);
		$id_contacto = $Contacto->crear($datos_contacto);

		return $id_contacto;

	}

	public function add_Contactos($array_datos_contactos){
		foreach($array_datos_contactos as $datos_contacto){
			$this->add_Contacto($datos_contacto);
		}
	}

	public function add_Contacto($datos){
		$id_contacto = $this->existe_Contacto($datos);
		if(!$id_contacto){
			$contacto = new Contacto();
			$contacto->crear($datos);
			$id_contacto = $contacto->get_Id();
		}
		$this->relacionar_Contacto($id_contacto);
	}

	private function existe_Contacto($datos){
		$query = "SELECT id FROM contactos WHERE nombre = '".$datos['nombre']."' AND telefono = '".$datos['telefono']."'; ";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);

		if(mysql_num_rows($rs) > 0)
		return $row['id'];
		return false;
	}
	
	public function del_Contacto($id_contacto){
		$query = "DELETE FROM proveedores_rel_contactos WHERE fk_contacto = '$id_contacto' AND fk_proveedor = '$this->NIF'; ";
		mysql_query($query);
		
		$query = "DELETE FROM contactos WHERE id = '$id_contacto'; ";
		mysql_query($query);
	}

	public function relacionar_Contacto($id_contacto){
		$query = "INSERT INTO proveedores_rel_contactos (fk_proveedor, fk_contacto) VALUES ('$this->NIF','$id_contacto')";
		$rs = mysql_query($query);
	}

	
	/**
	 * Modifica el domicilio del Proveedor.
	 *
	 * Si el domicilio es igual que el actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $domicilio Nuevo domicilio.
	 */
	public function set_Domicilio($domicilio){
		
		if($this->NIF && strcmp($this->domicilio, $domicilio) != 0){
			if($this->validar->cadena($domicilio)){
				$query = "UPDATE proveedores SET domicilio='".mysql_real_escape_string($domicilio)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el domicilio en la BBDD.");
					
				$this->domicilio = $domicilio;
			}else
			throw new Exception("Domicilio incorrecto.");
		}
	}

	/**
	 * Modifica la localidad del Proveedor.
	 *
	 * Si la localidad es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $localidad Nueva localidad.
	 */
	public function set_Localidad($localidad){
		
		if($this->NIF && strcmp($this->localidad, $localidad) != 0){
			if($this->validar->cadena($localidad)){
				$query = "UPDATE proveedores SET localidad='".mysql_real_escape_string($localidad)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la localidad en la BBDD.");
					
				$this->localidad = $localidad;
			}else
			throw new Exception("Localidad incorrecta.");
		}
	}
	
	public function set_CP($CP){
		
		if($this->NIF && $thiz-> CP !=$CP){
			if($this->validar->CP($CP)){
				$query = "UPDATE proveedores SET CP='".trim($CP)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el CP en la BBDD.");
					
				$this->CP = $CP;
			}else
			throw new Exception("CP incorrecto.");
		}
	}
	public function set_Provincia($provincia){
		
		if($this->NIF && strcmp($this->provincia, $provincia) != 0){
			if($this->validar->cadena($provincia)){
				$query = "UPDATE proveedores SET provincia='".mysql_real_escape_string($provincia)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la provincia en la BBDD.");
					
				$this->provincia = $provincia;
			}else
			throw new Exception("Provincia incorrecta.");
		}
	}
	/**
	 * Modifica la razon social del Proveedor.
	 *
	 * Si la razon social es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $razon_social Nueva razon social.
	 */
	public function set_Razon_Social($razon_social){
		
		if($this->NIF && strcmp($this->razon_social, $razon_social) != 0){
			if($this->validar->cadena($razon_social)){
				$query = "UPDATE proveedores SET razon_social='".mysql_real_escape_string($razon_social)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la raz&oacute;n social en la BBDD.");
					
				$this->razon_social = $razon_social;
			}else
			throw new Exception("Raz&oacute;n social incorrecta.");
		}
	}
	/**
	 * Modifica la web del Proveedor.
	 *
	 * Si la web es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $web Nueva web.
	 */
	public function set_Web($web){
		
		if($this->NIF && strcmp($this->web, $web) != 0){
			if($this->validar->cadena($web)){
				$query = "UPDATE proveedores SET web='".mysql_real_escape_string($web)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la web en la BBDD.");
					
				$this->web = $web;
			}else
			throw new Exception("Web incorrecta");
		}
	}

	/**
	 * Modifica la NIF del Proveedor.
	 *
	 * Si la NIF es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $NIF Nueva NIF.
	 */
	public function set_NIF($NIF){
		
		if($this->NIF && strcmp($this->NIF, $NIF) != 0){
			if($this->validar->nif_cif_cif($NIF)){
				$query = "UPDATE proveedores SET NIF='".mysql_real_escape_string($NIF)."' WHERE NIF='$this->NIF' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el NIF/CIF en la BBDD.");
					
				$this->NIF = $NIF;
			}else
			throw new Exception("NIF/CIF incorrecto.");
		}
	}
	
	public function del_Proveedor(){
		$query = "DELETE FROM proveedores WHERE NIF='$this->NIF';";
		mysql_query($query);
	}

}
?>
