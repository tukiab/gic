<?php
/**
 * Clase que gestiona los Contactos.
 */
class Contacto{
	
	/**
	 * Identificador del Contacto. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;
	
	/**
	 * Nombre del contacto
	 * @var string
	 */
	private $nombre;
	
	/**
	 * Teléfono del Contacto.
	 * @var string
	 */
	private $telefono;
	
	/**
	 * email del Contacto.
	 * @var string
	 */
	private $email;
	
	/**
	 * cargo del Contacto.
	 * @var string
	 */
	private $cargo;
	
	/**
	 * fax 
	 * @var integer
	 */
	private $fax;
	
	/**
	 * CP.
	 * @var integer
	 */
	private $movil;
	
	/**
	 * comisión.
	 * @var integer
	 */
	private $comision;
	
	/**
	 * comisión por renovación del contacto.
	 * @var integer
	 */
	private $comision_por_renovacion;
	
	/*
	 * Métodos de la Clase.
	 ***********************/	

	/**
	 * Constructor de la clase Contacto.
	 * 
	 * Si recibe un identificador válido, se carga el Contacto de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar un Contacto nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 * 
	 * @param integer $id_contacto Id del Contacto. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el Contacto en la BBDD.
	 * 
	 * Este método es invocado cuando se le pasa un id de Contacto válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT contactos.*
						FROM contactos
						WHERE contactos.id = '$this->id'";

			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar el Contacto de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado el Contacto en la BBDD");
				
			$row = mysql_fetch_array($result);

			$this->movil = $row['movil'];
			$this->comision = $row['comision'];
			$this->cargo = $row['cargo'];
			$this->nombre = $row['nombre'];
			$this->fax = $row['fax'];			
			$this->email = $row['email'];
			$this->comision_por_renovacion = $row['comision_por_renovacion'];
			$this->telefono = $row['telefono'];
		}
	}
	/*
	 * Métodos observadores.
	 ***********************/
	
	/**
	 * Devuelve el nombre
	 * @return string $nombre
	 */
	public function get_Nombre(){
		return $this->nombre;
	}
	/**
	 * Devuelve el movil
	 * @return int $movil
	 */
	public function get_Movil(){
		return $this->movil;
	}
	
	/**
	 * Devuelve los comision
	 * @return int $comision
	 */
	public function get_Comision(){
		return $this->comision;
	}
	
	/**
	 * Devuelve el cargo
	 * @return string $cargo
	 */
	public function get_Cargo(){
		return $this->cargo;
	}
	
	/**
	 * Devuelve la fax de renovacion
	 * @return int $fax
	 */
	public function get_Fax(){
		return $this->fax;
	}
	
	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve el email
	 * @return string $email
	 */
	public function get_Email(){
		return $this->email;
	}	
	/**
	 * Devuelve la comisión por renovación
	 * @return int $comision_por_renovacion
	 */
	public function get_Comision_Por_Renovacion(){
		return $this->comision_por_renovacion;
	}
	

	/**
	 * Devuelve el Teléfono
	 * @return string $telefono
	 */
	public function get_Telefono(){
		return $this->telefono;
	}
	

	
	/*
	 * Métodos Modificadores. 
	 * 
	 ************************/
	
	/**
	 * Crea un nuevo Contacto en la BBDD a partir de un array indexado con todos los campos.
	 * 
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los emails de los atributos de la clase.
	 * 
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para un nuevo Contacto.
	 * @return integer $id_contacto Id del nuevo Contacto.
	 */
	public function crear($datos){
		/*
		 * Datos imprescindibles para crear un contacto nuevo:
		 * 		nombre
		 * 		teléfono
		 * 
		 * Datos a los que hay que asignarle un valor por defecto:
		 * 		grupo empresas -> id=0
		 * 
		 */
		$validar = new Validador();
			
		//Comprobando los datos "imprescindibles":
		//if($datos['telefono'] == '' || ! isset($datos['telefono']))
			//throw new Exception("Contacto: El tel&eacute;fono es obligatorio.");
		/*if(!$validar->telefono($datos['telefono']))
			throw new Exception("Contacto: El formato del tel&eacute;fono no es correcto.");
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			throw new Exception("Contacto: El nombre es obligatorio.");
		*/
		$existe = $this->existe($datos['nombre']);
		
			
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}
	
	private function existe($nombre_contacto){
		$query = "SELECT id FROM contactos WHERE nombre = '$nombre_contacto' LIMIT 1;";
		$rs = mysql_query($query);
		
		if(mysql_num_rows($rs) > 0)
			return true;
		
		return false;
	}
	
	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * contacto, una vez filtrados y validados.
	 * 
	 * @param array $datos Array indexado por email con los datos de un contacto.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		$s_into = array();
		$s_values = array();
		
		if(isset($datos['email']) && $datos['email']!=''){
			$s_into[] = "email";
			$s_values[] = "'".mysql_real_escape_string(trim($datos['email']))."'";
		}
		if(isset($datos['nombre']) && $datos['nombre']!=''){
			$s_into[] = "nombre";
			$s_values[] = "'".mysql_real_escape_string(trim($datos['nombre']))."'";
		}
		if(isset($datos['comision_por_renovacion']) && $datos['comision_por_renovacion']!=''){
			$s_into[] = "comision_por_renovacion";
			$s_values[]="'".trim($datos['comision_por_renovacion'])."'";
		}
		if(isset($datos['comision']) && $datos['comision']!=''){
			$s_into[] = "comision"
			;$s_values[]	="'".trim($datos['comision'])."'";
		}
		if(isset($datos['fax']) && $datos['fax']!=''){
			$s_into[]="fax";
			$s_values[] ="'".trim($datos['fax'])."'";
		}
		if(isset($datos['movil']) && $datos['movil']!=''){
			$s_into[]="movil";
			$s_values[]="'".trim($datos['movil'])."'";
		}
		if(isset($datos['telefono']) && $datos['telefono']!=''){
			$s_into[]="telefono";
			$s_values[]="'".trim($datos['telefono'])."'";
		}
		if(isset($datos['cargo']) && $datos['cargo']!=''){
			$s_into[]="cargo";
			$s_values[]="'".mysql_real_escape_string(trim($datos['cargo']))."'";
		}
		
		$campos = implode(",",$s_into);
		$valores = implode(",",$s_values);
		
		if($campos){
		$query = "
			INSERT INTO contactos ($campos								
								)VALUES( $valores
								);
		";
		FB::info($query,'crear contacto');
		if(!mysql_query($query))
			throw new Exception("Error al crear el Contacto.".$query);
		$this->id = mysql_insert_id();
		
		return $this->id;
		}
	}
		
	/**
	 * Modifica el movil del Contacto.
	 * 
	 * @param int $movil nuevo movil
	 */
	public function set_Movil($movil){
		$Validar = new Validador();
		
		if($this->id && $Validar->movil($movil)){
						
			$query = "UPDATE contactos SET movil='".trim($movil)."' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el movil en la BBDD.");
				
			$this->movil = $movil;
		}else
			throw new Exception("Movil incorrecto.");
	}
	
	/**
	 * Modifica la comision
	 * 
	 * @param int $comision
	 */
	public function set_Comision($comision){
		
		if($this->id && is_numeric($comision)){
						
			$query = "UPDATE contactos SET comision='".trim($comision)."' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar la comision en la BBDD.");
				
			$this->comision = $comision;
		}else
			throw new Exception("Comision incorrecta.");
	}
	
	/**
	 * Modifica el cargo del Contacto.
	 * 
	 * Si el cargo es igual que el actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 * 
	 * @param string $cargo Nuevo cargo.
	 */
	public function set_Cargo($cargo){
		$Validar = new Validador();
		if($this->id && strcmp($this->cargo, $cargo) != 0){
			if($Validar->cadena($cargo)){
				$query = "UPDATE contactos SET cargo='".mysql_real_escape_string($cargo)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
					throw new Exception("Error al actualizar el cargo en la BBDD.");
					
				$this->cargo = $cargo;
			}else
				throw new Exception("Cargo incorrecto.");
		}
	}
	
	/**
	 * Modifica el teléfono del Contacto.
	 * 
	 * Si la razon social es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 * 
	 * @param string $telefono Nueva razon social.
	 */
	public function set_Telefono($telefono){
		$Validar = new Validador();
		
		if($this->id && ($Validar->telefono($telefono) || $Validar->movil($telefono))){
			if($telefono != '')
				$query = "UPDATE contactos SET telefono='".trim($telefono)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE contactos SET telefono=null WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el telefono en la BBDD.");
				
			$this->telefono = $telefono;
		}else
			throw new Exception("Telefono incorrecto.");
	}
	
	public function get_DisableEdit(){
		$disable = array();
		$usuario = new Usuario($_SESSION['usuario_login']);
		if(!$usuario->esAdministrador()){ 
			if($this->cargo != '')
				$disable['cargo'] = 'readonly="readonly"'; 
			if($this->comision != '')
				$disable['comision'] = 'readonly="readonly"';
			if($this->comision_por_renovacion != '')
				$disable['comision_por_renovacion'] = 'readonly="readonly"';
			if($this->email != '')
				$disable['email'] = 'readonly="readonly"';
			if($this->fax != '')
				$disable['fax'] = 'readonly="readonly"';
			if($this->movil != '')
				$disable['movil'] = 'readonly="readonly"';
			if($this->sector != '')
				$disable['sector'] = 'readonly="readonly"';			
			if($this->telefono != '')
				$disable['telefono'] = 'readonly="readonly"';
			if($this->nombre != '')
				$disable['nombre'] = 'readonly="readonly"';
		}
		FB::error($disable);
		return $disable;
	}
	
	/**
	 * Modifica el email del Contacto.
	 * 
	 * Si el email es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 * 
	 * @param string $email Nuevo email.
	 */
	public function set_Email($email){
		$Validar = new Validador();
		if($this->id && strcmp($this->email, $email) != 0){
			if($Validar->email($email)){
				$query = "UPDATE contactos SET email='".mysql_real_escape_string($email)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
					throw new Exception("Error al actualizar el email en la BBDD.");
					
				$this->email = $email;
			}else
				throw new Exception("Email incorrecto.");
		}
	}
	
/**
	 * Modifica el nombre del Contacto.
	 * 
	 * Si el nombre es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 * 
	 * @param string $nombre Nuevo nombre.
	 */
	public function set_Nombre($nombre){
		$Validar = new Validador();
		if($this->id && strcmp($this->nombre, $nombre) != 0){
			if($Validar->cadena($nombre)){
				$query = "UPDATE contactos SET nombre='".mysql_real_escape_string($nombre)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
					throw new Exception("Error al actualizar el nombre en la BBDD.");
					
				$this->nombre = $nombre;
			}else
				throw new Exception("nombre incorrecto.");
		}
	}
		
	/**
	 * Modifica el fax  del contacto
	 * @param int $fax nueva fax 
	 */
	public function set_Fax($fax){
		$Validar = new Validador();
		if($Validar->telefono($fax)){
			$query = "UPDATE contactos SET fax='$fax' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el fax en la BBDD.");
			$this->fax = $fax;

		}else
			throw new Exception("Fax incorrecto.");
	}
	
	/**
	 * Establece el comisión por renovación del Contacto.
	 * 
	 * @param integer $comision_por_renovacion comisión por renovación del contacto.
	 */
	public function set_Comision_Por_Renovacion($comision_por_renovacion){
		if(is_numeric($comision_por_renovacion)){
			$query = "UPDATE contactos SET comision_por_renovacion = '$comision_por_renovacion' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el n&uacute;mero de empleados.");
				
			$this->comision_por_renovacion = $comision_por_renovacion;
		}
	}

	
	
}
?>