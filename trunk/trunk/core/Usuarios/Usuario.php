<?php
/**
 * Clase que representa un Usuario.
 * 
 */
 class Usuario{
 	
 	/**
 	 * Identificador del usuario. Coincide con el id de usuario en la BBDD.
 	 *
 	 * @var string
 	 */
 	private $id;
 	
 	/**
 	 * Nombr del usuario.
 	 *
 	 * @var unknown_type
 	 */
 	private $nombre;
	private $email;
 	
 	/**
 	 * Apellidos del usuario.
 	 *
 	 * @var apellidos
 	 */
 	private $apellidos;
 	
 	/**
 	 * Perfil al que pertenece el usuario.
 	 *
 	 * @var array indexado por id, nombre
 	 */
 	private $perfil;
	/**
	 * departamento asociado al perfil
	 * @var <type> array indexado por id y nombre
	 */
	private $departamento;
 	
 	/**
 	 * Password del Usuario
 	 * 
 	 * @var string
 	 */
 	private $password;
 	
 	/**
 	 * Objetivos del usuario
 	 *
 	 * @var array indexado por los id de los 12 meses, y contiene cada posición un array indexado por id, mes y comisión
 	 */
 	private $objetivos = array();
	private $objetivos_departamento = array();

	private $penalizaciones = array();
	private $penalizaciones_departamento = array();

	private $comisiones = array();
	private $comisiones_departamento = array();
 	/**
 	 * Constructor de la clase.
 	 * 
 	 * Recibe el identificador como parámetro.
 	 *
 	 * @param integer $id
 	 */
 	public function __construct($id=null){
 		if($id){
 			$this->id = $id;
 			$this->cargar();
 		}
 	}
 	
 	/**
 	 * Carga los datos del usuario de la BBDD.
 	 * Se invoca desde el constructor cuando éste recibe un identificador válido.
 	 *
 	 */
 	private function cargar(){
 		if($this->id){
 			$query = "SELECT usuarios.*, usuarios_perfiles.nombre as nombre_perfil, usuarios_departamentos.nombre as nombre_departamento, usuarios_departamentos.id as id_departamento
						FROM usuarios
						JOIN usuarios_perfiles
							ON usuarios.fk_perfil = usuarios_perfiles.id
						JOIN usuarios_departamentos on usuarios_perfiles.fk_departamento = usuarios_departamentos.id
						WHERE usuarios.id = '$this->id'; ";
 			if(!($result = mysql_query($query)) || mysql_num_rows($result)!=1)
 				throw new Exception("Error al cargar el usuario.");
 			$row = mysql_fetch_array($result);
 			
 			$this->nombre = $row['nombre'];
                        $this->email = $row['email'];
 			$this->password = $row['password'];
 			$this->nombre = $row['nombre'];
 			$this->apellidos = $row['apellidos']; 			
 			$this->perfil = array('id'=>$row['fk_perfil'], 'nombre'=>$row['nombre_perfil']);
			if($row['id_departamento'])
				$this->departamento = array('id' => $row['id_departamento'], 'nombre' => $row['nombre_departamento']);
			else
				$this->departamento = null;
 			
 			$this->cargar_Objetivos();
			$this->cargar_Penalizaciones();
			$this->cargar_Comisiones();
 		}
 	}
 	
 	/**
 	 * Método auxiliar para cargar la lista de objetivos asignados al usuario.
 	 * Se invoca desde el método {@link cargar()}
 	 *
 	 */
 	private function cargar_Objetivos(){
 		if($this->id){
 			$query = "SELECT usuarios_objetivos_mensuales.mes as mes, usuarios_rel_objetivos_mensuales.comision as comision, usuarios_objetivos_mensuales.id as id_mes
						FROM usuarios_rel_objetivos_mensuales
						INNER JOIN usuarios_objetivos_mensuales ON usuarios_rel_objetivos_mensuales.fk_objetivo = usuarios_objetivos_mensuales.id
						WHERE usuarios_rel_objetivos_mensuales.fk_usuario = '$this->id'; ";
 			if(!($result = mysql_query($query)))
 				throw new Exception("Error al cargar los objetivos del usuario.");
 			while($row = mysql_fetch_array($result))
 				$this->objetivos[$row['id_mes']] = $row;

			//Y ahora los objetivos del departamento (en caso de tenerlos)
			if($this->departamento){
				$query = "SELECT usuarios_objetivos_mensuales.mes as mes, usuarios_departamentos_rel_objetivos_mensuales.comision as comision,
								usuarios_objetivos_mensuales.id as id_mes
							FROM usuarios_objetivos_mensuales
							INNER JOIN usuarios_departamentos_rel_objetivos_mensuales
								ON usuarios_departamentos_rel_objetivos_mensuales.fk_objetivo = usuarios_objetivos_mensuales.id
							WHERE usuarios_departamentos_rel_objetivos_mensuales.fk_departamento = '".$this->departamento['id']."'; ";
				if(!($result = mysql_query($query)))
					throw new Exception("Error al cargar los objetivos del departamento del usuario.");
				while($row = mysql_fetch_array($result))
					$this->objetivos_departamento[$row['id_mes']] = $row;
			}
 		}
 	}

	private function cargar_Penalizaciones(){
 		if($this->id){
 			$query = "SELECT usuarios_penalizaciones.nombre as nombre,
							usuarios_rel_penalizaciones.penalizacion as penalizacion, usuarios_penalizaciones.id as id_penalizacion
						FROM usuarios_rel_penalizaciones
						INNER JOIN usuarios_penalizaciones ON usuarios_rel_penalizaciones.fk_penalizacion = usuarios_penalizaciones.id
						WHERE usuarios_rel_penalizaciones.fk_usuario = '$this->id'; ";
 			if(!($result = mysql_query($query)))
 				throw new Exception("Error al cargar las penalizaciones del usuario.");
 			while($row = mysql_fetch_array($result))
 				$this->penalizaciones[$row['id_penalizacion']] = $row;

			//Y ahora las del departamento (en caso de tenerlos)
			if($this->departamento){
				$query = "SELECT usuarios_penalizaciones.nombre as nombre,
								usuarios_departamentos_rel_penalizaciones.penalizacion as penalizacion, usuarios_penalizaciones.id as id_penalizacion
							FROM usuarios_penalizaciones
							INNER JOIN usuarios_departamentos_rel_penalizaciones
								ON usuarios_departamentos_rel_penalizaciones.fk_penalizacion = usuarios_penalizaciones.id
							WHERE usuarios_departamentos_rel_penalizaciones.fk_departamento = '".$this->departamento['id']."'; ";
				if(!($result = mysql_query($query)))
					throw new Exception("Error al cargar las penalizaciones del departamento del usuario.");
				while($row = mysql_fetch_array($result))
					$this->penalizaciones_departamento[$row['id_penalizacion']] = $row;
			}
 		}
 	}

	private function cargar_Comisiones(){
 		if($this->id){
 			$query = "SELECT tipos_comision.nombre as nombre, usuarios_rel_tipos_comision.comision as comision, tipos_comision.id as id_comision
						FROM usuarios_rel_tipos_comision
						INNER JOIN tipos_comision ON usuarios_rel_tipos_comision.fk_tipo_comision = tipos_comision.id
						WHERE usuarios_rel_tipos_comision.fk_usuario = '$this->id'; ";
 			if(!($result = mysql_query($query)))
 				throw new Exception("Error al cargar las comisiones del usuario.");
 			while($row = mysql_fetch_array($result))
 				$this->comisiones[$row['id_comision']] = $row;

			//Y ahora los objetivos del departamento (en caso de tenerlos)
			if($this->departamento){
				$query = "SELECT tipos_comision.nombre as nombre, usuarios_departamentos_rel_tipos_comision.comision as comision,
								tipos_comision.id as id_comision
							FROM tipos_comision
							INNER JOIN usuarios_departamentos_rel_tipos_comision
								ON usuarios_departamentos_rel_tipos_comision.fk_tipo_comision = tipos_comision.id
							WHERE usuarios_departamentos_rel_tipos_comision.fk_departamento = '".$this->departamento['id']."'; ";
				if(!($result = mysql_query($query)))
					throw new Exception("Error al cargar las comisiones del departamento del usuario.");
				while($row = mysql_fetch_array($result))
					$this->comisiones_departamento[$row['id_comision']] = $row;
			}
 		}
 	}
 	
 	/*
 	 * Métodos observadores
 	 ***********************/
 	
 	/**
 	 * Devuelve el identificador del usuario.
 	 * 
 	 * @return integer $id Identificador del usuario.
 	 */
 	public function get_Id(){
 		return $this->id;
 	}
 	
 	/**
 	 * Devuelve el nombre completo del usuario.
 	 *
 	 * @return string $nombre Nombre completo del usuario.
 	 */
 	public function get_Nombre(){
 		return $this->nombre;
 	}

        public function get_Email(){
		return $this->email;
	}
 	/**
 	 * Devuelve el apellidos del usuario.
 	 *
 	 * @return string $apellidos Apellidos del usuario.
 	 */
 	public function get_Apellidos(){
 		return $this->apellidos;
 	}
 	
 	public function get_Nombre_Y_Apellidos(){
 		return $this->nombre." ".$this->apellidos;
 	}
 	/**
 	 * Devuelve el password del usuario.
 	 *
 	 * @return string $password Password del usuario.
 	 */
 	public function get_Password(){
 		return $this->password;
 	}
 	
 	/**
 	 * Devuelve el perfil al que pertenece el usuario.
 	 *
 	 * @return Perfil $perfil array indexado por id y nombre
 	 */
 	public function get_Perfil(){
 		return $this->perfil;
 	}

	public function get_Departamento(){
		return $this->departamento;
	}
 	/**
 	 * Devuelve un array con los objetivos que tiene asignado el usuario.
 	 *
 	 * @return array $objetivos Array con los objetivos.
 	 */
 	public function get_Objetivos(){
 		return $this->objetivos;
 	}
	public function get_Objetivo($id_mes){
		//parche por si viene el mes con dos cifras empezando por 0
		$id_mes = (int)$id_mes;
		return $this->objetivos[$id_mes];
	}
	public function get_Objetivo_Acumulado($id_mes){
		$objetivo_acumulado = 0;
		for($m=1;$m<=$id_mes;$m++){ 
			$obj = $this->get_Objetivo($m);
			$objetivo_acumulado = $objetivo_acumulado + $obj['comision'];
		}

		return $objetivo_acumulado;
	}
	public function get_Objetivos_Departamento(){
 		return $this->objetivos_departamento;
 	}

	public function get_Penalizaciones(){
 		return $this->penalizaciones;
 	}
	public function get_Penalizacion($id_pen){
		return $this->penalizaciones[$id_pen];
	}
	public function get_Penalizaciones_Departamento(){
 		return $this->penalizaciones_departamento;
 	}

	public function get_Comisiones(){
 		return $this->comisiones;
 	}
	public function get_Comision($id){
		return $this->comisiones[$id];
	}
	public function get_Comisiones_Departamento(){
 		return $this->comisiones_departamento;
 	}
 	
	/**
	* Devuelve un objeto ListaAcciones con la búsqueda dada para el usuario al que hace referencia el objeto
	*
	* @return ListaAcciones $listaAcciones;
	*/
	public function get_Acciones($filtros=null){
		$filtros['id_usuario'] = $this->id;
		$listaAcciones = new ListaAcciones();
		$listaAcciones->buscar($filtros);
		return $listaAcciones;
	}
 	/*
	 * Métodos Modificadores. 
	 * 
	 ************************/
 	
 /**
	 * Crea un nuevo Usuario en la BBDD a partir de un array indexado con todos los campos.
	 * 
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 * 
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para un nuevo Cliente.
	 * @return integer $id_cliente Id del nuevo Cliente.
	 */
	public function crear($datos){
		////FB::info($datos,'datos para crear usuario');
		/*
		 * Datos imprescindibles para crear un cliente nuevo:
		 * 		id
		 * 		nombre
		 * 		password
		 * 		perfil
		 * 
		 */
		$validar = new Validador();
		$ListaUsuarios = new ListaUsuarios();
		
		$array_perfiles = $ListaUsuarios->lista_Perfiles();
					
		//Comprobando los datos "imprescindibles":
		if($datos['id'] == '' || ! isset($datos['id']))
			throw new Exception("Usuario: El nombre de usuario es obligatorio.");
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			throw new Exception("Usuario: El nombre es obligatorio.");
		if($datos['password'] == '' || ! isset($datos['password']))
			throw new Exception("Usuario: La contrase&ntilde; es obligatoria.");
		if(!is_numeric($datos['perfil']) || !in_array($datos['perfil'], array_keys($array_perfiles)))
			throw new Exception("Usuario: Perfil de usuario no válido.");
			
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}
	
	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * usuario, una vez filtrados y validados.
	 * 
	 * @param array $datos Array indexado por nombre con los datos de un usuario.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		////FB::info($datos,'datos para guardar usuario');
		$s_into.="";
		$s_values.="";
		if(isset($datos['apellidos'])){
			$s_into.=",apellidos";
			$s_values.=",'".mysql_real_escape_string(trim($datos['apellidos']))."'";
		}
                if(isset($datos['email']) && $datos['email']!=''){
			$s_into.= ",email";
			$s_values.= ",'".mysql_real_escape_string(trim($datos['email']))."'";
		}
		if($this->existe($datos['id']))
			throw new Exception('ERROR: Ya existe el id de usuario');
		
		$query = "
			INSERT INTO usuarios (  id,
									nombre,
									password,
									fk_perfil	
									$s_into								
								)VALUES(
									'".mysql_real_escape_string(trim($datos['id']))."',
									'".mysql_real_escape_string(trim($datos['nombre']))."',
									'".mysql_real_escape_string(trim($datos['password']))."',
									'".trim($datos['perfil'])."'
									$s_values
								);
		";
		//FB::info($query,'query guardar Usuario');
		if(!mysql_query($query))
			throw new Exception("Error al crear el Usuario.");
		$this->id = trim($datos['id']);

		//creamos los proyectos asociado al Usuario si es técnico o director técnico
		if($datos['perfil'] == 3 || $datos['perfil'] == 6){
			$proyecto = new Proyecto();
			$datos['nombre'] = 'Horas no remuneradas '.$this->id;
			$datos['fecha_inicio'] = time();
			$datos['id_usuario'] = $this->id;
			$datos['cerrar'] = 0;
			$proyecto->crear($datos);

			$proyecto_remuneradas = new Proyecto();
			$datos['nombre'] = 'Horas remuneradas '.$this->id;
			$proyecto_remuneradas->crear($datos);
		}
		
		return $this->id;
	}
	
	private function existe($id_usuario){
		$query = "SELECT id FROM usuarios WHERE id='$id_usuario' LIMIT 1;";
		$rs = mysql_query($query);
		if(mysql_num_rows($rs)>0)
			return true;
			
		return false;
	}
 	
 	public function eliminar(){
		$query = "DELETE FROM usuarios WHERE id='$this->id';";
		if(!mysql_query($query))
			throw new Exception("Error al borrar el Usuario.");
	}	

	public function actualizar($datos){

		$this->set_Apellidos($datos['apellidos']);
		$this->set_Password($datos['password']);
		$this->set_Perfil($datos['perfil']);
		$this->set_Nombre($datos['nombre']);
        $this->set_Email($datos['email']);
	
	}

	public function set_Id($id){
		$Validar = new Validador();
		if($this->id && strcmp($this->id, $id) != 0){
			if($Validar->cadena($id)){
				$query = "UPDATE usuarios SET id='".mysql_real_escape_string($id)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el id del usuario en la BBDD.");
					
				$this->id = $id;
			}else
			throw new Exception("id de usuario incorrecto.");
		}	
	}
	public function set_Nombre($nombre){
		$Validar = new Validador();
		if($this->id && strcmp($this->nombre, $nombre) != 0){
			if($Validar->cadena($nombre)){
				$query = "UPDATE usuarios SET nombre='".mysql_real_escape_string($nombre)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el nombre del usuario en la BBDD.");
					
				$this->nombre = $nombre;
			}else
			throw new Exception("nombre de usuario incorrecto.");
		}	
	}
        public function set_Email($email){
		$Validar = new Validador();
		if($this->id && strcmp($this->email, $email) != 0){
			if($Validar->email($email)){
				$query = "UPDATE usuarios SET email='".mysql_real_escape_string($email)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el email del usuario en la BBDD.");
					
				$this->email = $email;
			}else
			throw new Exception("email de usuario incorrecto.");
		}
	}
	public function set_Apellidos($apellidos){
		$Validar = new Validador();
		if($this->id && strcmp($this->apellidos, $apellidos) != 0){
			if($Validar->cadena($apellidos)){
				$query = "UPDATE usuarios SET apellidos='".mysql_real_escape_string($apellidos)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el apellidos del usuario en la BBDD.");
					
				$this->apellidos = $apellidos;
			}else
			throw new Exception("apellidos de usuario incorrecto.");
		}	
	}
	public function set_Password($password){
		$Validar = new Validador();
		if($this->id && strcmp($this->password, $password) != 0){
			if($Validar->cadena($password)){
				$query = "UPDATE usuarios SET password='".mysql_real_escape_string($password)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el password del usuario en la BBDD.");
					
				$this->password = $password;
			}else
			throw new Exception("password de usuario incorrecto.");
		}	
	}
	public function set_Perfil($id_perfil){
		$ListaUsuarios = new ListaUsuarios();
		$array_perfiles = $ListaUsuarios->lista_Perfiles();

		if(is_numeric($id_perfil) && in_array($id_perfil, array_keys($array_perfiles))){
			$query = "UPDATE usuarios SET fk_perfil='$id_perfil' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el perfil en la BBDD.");

			$query = "SELECT id, nombre FROM usuarios_perfiles WHERE id= '$id_perfil' limit 1;";
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);

			$this->perfil = array('id'=>$row['id'], 'nombre'=>$row['nombre']);

		}else
		throw new Exception("Debe introducir un perfil v&aacute;lido.");
	}

	/**
	 * Establece los objetivos mensuales del usuario
	 * Borra los objetivos actuales e ingresa los que se les pasa en el array
	 * @param <array> $objetivos, cada posición indexado por id y comision
	 */
	public function set_Objetivos($objetivos){ 
		$query = "DELETE FROM usuarios_rel_objetivos_mensuales WHERE fk_usuario = '$this->id';";
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al resetear los objetivos");
		foreach($objetivos as $obj){			
			$this->set_Objetivo($obj['id'], $obj['comision'], true);
		}
	}
	public function set_Objetivo($id, $comision, $objetivos_borrados=false){
		if(!$objetivos_borrados){
			$query = "DELETE FROM usuarios_rel_objetivos_mensuales WHERE fk_usuario = '$this->id' AND fk_objetivo = '$id';";
			if(!mysql_query($query))
				throw new Exception("Error cr&iacute;tico al resetear los objetivos");
		}

		$query = "INSERT INTO usuarios_rel_objetivos_mensuales
							(fk_usuario, fk_objetivo, comision)
							VALUES ('$this->id', '$id', '$comision');";//FB::error($query);
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al establecer los objetivos");
	}

	public function set_Penalizaciones($penalizaciones){
		$query = "DELETE FROM usuarios_rel_penalizaciones WHERE fk_usuario = '$this->id';";
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al resetear las penalizaciones");
		foreach($penalizaciones as $obj){
			$this->set_Penalizacion($obj['id'], $obj['penalizacion'], true);
		}
	}
	public function set_Penalizacion($id, $penalizacion, $penalizaciones_borradas=false){
		if(!$penalizaciones_borradas){
			$query = "DELETE FROM usuarios_rel_penalizaciones WHERE fk_usuario = '$this->id' AND fk_penalizacion = '$id';";
			if(!mysql_query($query))
				throw new Exception("Error cr&iacute;tico al resetear las penalizaciones");
		}

		$query = "INSERT INTO usuarios_rel_penalizaciones
							(fk_usuario, fk_penalizacion, penalizacion)
							VALUES ('$this->id', '$id', '$penalizacion');";//FB::warn($query);
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al establecer las penalizaciones");
	}

	public function set_Comisiones($comisiones){
		$query = "DELETE FROM usuarios_rel_tipos_comision WHERE fk_usuario = '$this->id';";
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al resetear las comisiones");
		foreach($comisiones as $obj){
			$this->set_Comision($obj['id'], $obj['comision'], true);
		}
	}
	public function set_Comision($id, $comision, $comisiones_borrados=false){
		if(!$comisiones_borrados){
			$query = "DELETE FROM usuarios_rel_tipos_comision WHERE fk_usuario = '$this->id' AND fk_tipo_comision = '$id';";
			if(!mysql_query($query))
				throw new Exception("Error cr&iacute;tico al resetear las comisiones");
		}

		$query = "INSERT INTO usuarios_rel_tipos_comision
							(fk_usuario, fk_tipo_comision, comision)
							VALUES ('$this->id', '$id', '$comision');";//FB::info($query);
		if(!mysql_query($query))
			throw new Exception("Error cr&iacute;tico al establecer las comisiones");
	}
 	
	public function esAdministrador(){
		return $this->perfil['id'] == 4 || $this->perfil['id'] == 5;  
	}
	
 	public function esAdministradorTotal(){
		return $this->perfil['id'] == 5;  
	}
	
 }
?>
