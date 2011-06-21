<?php
/**
 * Clase que gestiona los Clientes.
 */
include_once('../../html/Common/php/utils/utils.php');
class Cliente{

	/**
	 * Identificador del Cliente. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * Razón social del Cliente.
	 * @var string
	 */
	private $razon_social;

	/**
	 * Tipo del Cliente
	 * @var array indexado por id y nombre
	 */
	private $tipo_cliente;

	/**
	 * Grupo de empresas al que pertenece el cliente.
	 * @var array indexado por id y nombre
	 */
	private $grupo_empresas;

	/**
	 * NIF del Cliente.
	 * @var string
	 */
	private $NIF;

	/**
	 * Domicilio del Cliente.
	 * @var string
	 */
	private $domicilio;

	/**
	 * Localidad del Cliente.
	 * @var string
	 */
	private $localidad;

	/**
	 * Provincia del Cliente.
	 * @var string
	 */
	private $provincia;

	/**
	 * Web del Cliente.
	 * @var string
	 */
	private $web;

	/**
	 * Sector del Cliente.
	 * @var string
	 */
	private $sector;

	/**
	 * SPA_actual Cliente.
	 * @var string
	 */
	private $SPA_actual;

	/**
	 * Norma implantada del Cliente.
	 * @var string
	 */
	private $norma_implantada;

	/**
	 * Fecha de renovación en formato timestamp.
	 * @var integer
	 */
	private $fecha_renovacion;

	/**
	 * CP.
	 * @var integer
	 */
	private $CP;

	/**
	 * Créditos.
	 * @var integer
	 */
	private $creditos;

	private $FAX;
	private $telefono;

	/**
	 * Número de empleados del cliente.
	 * @var integer
	 */
	private $numero_empleados;

	/**
	 * Contactos del cliente.
	 * @var array de ids de contactos
	 */
	private $contactos=null;

	/**
	 * Gestor/Gestores asociados al cliente
	 * @var array con ids de usuarios
	 * El primero de la lista es el usuario que inserta al cliente
	 */
	private $gestores=null;

	/**
	 * Acciones asociadas al cliente
	 * @var array con ids de acciones
	 */
	private $acciones=null;

	/**
	 * Ofertas asociadas al cliente
	 * @var array con ids de ofertas
	 */
	private $ofertas=null;
	private $ventas=null;
	private $proyectos=null;

	private $observaciones;
	private $actividad;

	/**
	 * Ids de las sedes de la empresa
	 * @var <type>
	 */
	private $sedes=null;

	/**
	 * Indica si el cliente representa a la empresa usuaria de la aplicación
	 * @var <integer>
	 */
	private $cliente_principal;

	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Cliente.
	 *
	 * Si recibe un identificador válido, se carga el Cliente de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar un Cliente nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_cliente Id del Cliente. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el Cliente en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Cliente válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT clientes.*
						FROM clientes
						WHERE clientes.id = '$this->id'";
			//FB::info($query,'Cliente->cargar: QUERY');
			if(!($result = mysql_query($query)))
                            throw new Exception("Error al cargar la empresa de la BBDD");
			else if(mysql_num_rows($result) == 0)
                            throw new Exception("No se ha encontrado la empresa en la BBDD ".$query);

			$row = mysql_fetch_array($result);

			$this->CP = $row['CP'];
			$this->creditos = $row['creditos'];
			$this->FAX = $row['FAX'];
			$this->telefono = $row['telefono'];
			$this->domicilio = $row['domicilio'];
			$this->fecha_renovacion = $row['fecha_renovacion'];

			$this->localidad = $row['localidad'];
			$this->provincia = $row['provincia'];
			$this->NIF = $row['NIF'];
			$this->norma_implantada = $row['norma_implantada'];
			$this->numero_empleados = $row['numero_empleados'];

			$this->razon_social = $row['razon_social'];
			$this->sector = $row['sector'];
			$this->SPA_actual = $row['SPA_actual'];
			$this->web = $row['web'];

			$this->tipo_cliente = array('id'=>$row['fk_tipo_cliente'], 'nombre'=>$row['nombre_tipo_cliente']);
			$this->grupo_empresas = array('id'=>$row['fk_grupo_empresas'], 'nombre'=>$row['nombre_grupo_empresas']);

			$this_principal = $row['cliente_principal'];

			$this->observaciones = $row['observaciones'];
			$this->actividad = $row['actividad'];

			$this->cliente_principal = $row['cliente_principal'];

		}
	}


	/**
	 * Carga la lista de contactos asociados al cliente.
	 */
	private function cargar_Contactos(){
		$query = "SELECT fk_contacto
					FROM clientes_rel_contactos
					WHERE fk_cliente = '$this->id' AND fk_contacto <> '0'";

		$result = mysql_query($query);

		$this->contactos = array();
		while($row = mysql_fetch_array($result))
		$this->contactos[] = $row['fk_contacto'];
	}

	/**
	 * Carga la lista de sedes asociados al cliente.
	 */
	private function cargar_Sedes(){
		$query = "SELECT id
					FROM clientes_sedes
					WHERE fk_cliente = '$this->id'";

		$result = mysql_query($query);

		$this->sedes = array();
		while($row = mysql_fetch_array($result))
		$this->sedes[] = $row['id'];
	}
	/**
	 * Carga la lista de usuarios (gestores) asociados al cliente.
	 */
	private function cargar_Gestores(){
		$query = "SELECT fk_usuario
					FROM clientes_rel_usuarios
					WHERE fk_cliente = '$this->id'
					ORDER BY ha_insertado; ";

		$result = mysql_query($query);

		$this->gestores = array();
		while($row = mysql_fetch_array($result))
		$this->gestores[] = $row['fk_usuario'];
	}

	/**
	 * Carga la lista de acciones asociadas al cliente.
	 */
	private function cargar_Acciones(){
		$query = "SELECT id
					FROM acciones_de_trabajo
					WHERE fk_cliente = '$this->id'
					; ";

		$result = mysql_query($query);

		$this->acciones = array();
		while($row = mysql_fetch_array($result))
		$this->acciones[] = $row['id'];
	}

	/**
	 * Carga la lista de ofertas asociadas al cliente.
	 */
	private function cargar_Ofertas(){
		$query = "SELECT id
					FROM ofertas
					WHERE fk_cliente = '$this->id'
					; ";

		$result = mysql_query($query);

		$this->ofertas = array();
		while($row = mysql_fetch_array($result))
		$this->ofertas[] = $row['id'];
	}

	private function cargar_Ventas(){
		$query = "SELECT ventas.id
					FROM ventas
					INNER JOIN ofertas ON ofertas.id = ventas.fk_oferta
					WHERE ofertas.fk_cliente = '$this->id'
					; ";

		$result = mysql_query($query);

		$this->ventas = array();
		while($row = mysql_fetch_array($result))
		$this->ventas[] = $row['id'];
	}

	private function cargar_Proyectos(){
		$query = "SELECT proyectos.id
					FROM proyectos
					WHERE proyectos.fk_cliente = '$this->id'
					; ";

		if(!$result = mysql_query($query))
			throw new Exception('Error al cargar los proyectos de la empresa');

		$this->proyectos = array();
		while($row = mysql_fetch_array($result))
		$this->proyectos[] = $row['id'];
	}

	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Devuelve la lista de contactos
	 * @return array $contactos
	 */
	public function get_Contactos(){
		if(!$this->contactos)
			$this->cargar_Contactos();

		return $this->contactos;
	}

	/**
	 * Devuelve el array con los ids de las sedes de la empresa
	 * @return <type>
	 */
	public function get_Sedes(){
		if(!$this->sedes)
			$this->cargar_Sedes();

		return $this->sedes;
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
	 * Devuelve los creditos
	 * @return int $creditos
	 */
	public function get_Creditos(){
		return $this->creditos;
	}

	public function get_FAX(){
		return $this->FAX;
	}
	public function get_Telefono(){
		return $this->telefono;
	}

	/**
	 * Devuelve el domicilio
	 * @return string $domicilio
	 */
	public function get_Domicilio(){
		return $this->domicilio;
	}

	/**
	 * Devuelve la fecha de renovacion
	 * @return int $fecha_renovacion
	 */
	public function get_Fecha_Renovacion(){
		return $this->fecha_renovacion;
	}

	/**
	 * Devuelve el Grupo de empresas
	 * @return array $grupo_empresas
	 */
	public function get_Grupo_Empresas(){
		return $this->grupo_empresas;
	}

	/**
	 * Devuelve las acciones
	 * @return array $acciones
	 */
	public function get_Acciones(){
		if(!$this->acciones)
			$this->cargar_Acciones();

		return $this->acciones;
	}

	/**
	 * Devuelve los ids de las ofertas
	 * @return array $ofertas
	 */
	public function get_Ofertas(){
		if(!$this->ofertas)
			$this->cargar_Ofertas();

		return $this->ofertas;
	}

	/**
	 * Devuelve un array de ids de ventas
	 * @return <type>
	 */
	public function get_Ventas(){
		if(!$this->ventas)
			$this->cargar_Ventas();
		return $this->ventas;
	}

	/**
	 * Devuelve un array de ids de proyectos
	 * @return <type>
	 */
	public function get_Proyectos(){
		if(!$this->proyectos)
			$this->cargar_Proyectos();

		return $this->proyectos;
	}
	/**
	 * Devuelve los Gestores
	 * @return array $gestores
	 */
	public function get_Gestores(){
		if(!$this->gestores)
			$this->cargar_Gestores();

		return $this->gestores;
	}

	public function get_Gestor_Inserta(){
		return array_shift(array_values($this->get_Gestores()));
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
	 * Devuelve el NIF/CIF
	 * @return string $NIF
	 */
	public function get_NIF(){
		return $this->NIF;
	}


	/**
	 * Devuelve la norma implantada
	 * @return string $norma_implantada
	 */
	public function get_Norma_Implantada(){
		return $this->norma_implantada;
	}


	/**
	 * Devuelve el número de empleado
	 * @return int $numero_empleados
	 */
	public function get_Numero_Empleados(){
		return $this->numero_empleados;
	}


	/**
	 * Devuelve la razón social
	 * @return string $razon_social
	 */
	public function get_Razon_Social(){
		return $this->razon_social;
	}


	/**
	 * Devuelve el sector
	 * @return string $sector
	 */
	public function get_Sector(){
		return $this->sector;
	}


	/**
	 * Devuelve el spa actual
	 * @return string $SPA_actual
	 */
	public function get_SPA_Actual(){
		return $this->SPA_actual;
	}


	/**
	 * Devuelve el tipo de cliente
	 * @return array $tipo_cliente indexado por id y nombre
	 */
	public function get_Tipo_Cliente(){
		return $this->tipo_cliente;
	}


	/**
	 * Devuelve la web
	 * @return string $web
	 */
	public function get_Web(){
		return $this->web;
	}

	public function get_Observaciones(){
		return $this->observaciones;
	}

	public function get_Actividad(){
		return $this->actividad;
	}

	public function get_Cliente_Principal(){
		return $this->cliente_principal;
	}


	/**
	 * Devuelve la lista de contactos asociados al cliente.
	 *
	 * A partir del array de ids de Contactos almacenado en la variable local $contactos, crea un nuevo array
	 * de objetos Contacto, que será el devuelto por el método.
	 *
	 * @return array $array_Contactos Cada elemento es una instancia de la clase Contacto;
	 */
	public function get_Lista_Contactos(){
		$array_Contactos = array();
		if($this->get_Contactos())
			foreach($this->contactos as $id_Contacto)
				array_push($array_Contactos, new Contacto($id_Contacto));

		return $array_Contactos;
	}

	/**
	 * Devuelve un array con instancias Sede de las sedes de la empresa
	 * @return array
	 */
	public function get_Lista_Sedes(){
		$array = array();
		foreach($this->get_Sedes() as $id)
			array_push($array, new Sede ($id));

		return $array;
	}

	/**
	 * Devuelve la lista de usuarios-gestores- asociados al cliente.
	 *
	 * A partir del array de ids de gestores almacenado en la variable local $gestores, crea un nuevo array
	 * de objetos usuario, que será el devuelto por el método.
	 *
	 * @return array $array_usuarios Cada elemento es una instancia de la clase usuario;
	 */
	public function get_Lista_Gestores(){
		$array_gestores = array();
		foreach($this->get_Gestores() as $id_usuario)
			array_push($array_gestores, new Usuario($id_usuario));

		return $array_gestores;
	}

	/**
	 * Devuelve la lista de acciones asociadas al cliente.
	 *
	 * A partir del array de ids de acciones almacenado en la variable local $acciones, crea un nuevo array
	 * de objetos Accion, que será el devuelto por el método.
	 *
	 * @return array $array_acciones Cada elemento es una instancia de la clase Accion;
	 */
	public function get_Lista_Acciones(){
		$array_acciones = array();
		foreach($this->get_Acciones() as $id_accion)
			array_push($array_acciones, new Accion($id_accion));

		return $array_acciones;
	}

	/**
	 * Devuelve la lista de ofertas asociadas al cliente.
	 *
	 * A partir del array de ids de ofertas almacenado en la variable local $ofertas, crea un nuevo array
	 * de objetos Oferta, que será el devuelto por el método.
	 *
	 * @return array $array_ofertas Cada elemento es una instancia de la clase Oferta;
	 */
	public function get_Lista_Ofertas(){
		$array_ofertas = array();
		foreach($this->get_Ofertas() as $id_oferta)
			array_push($array_ofertas, new Oferta($id_oferta));

		return $array_ofertas;
	}

	public function get_Lista_Ventas(){
		$arra= array();
		foreach($this->get_Ventas() as $id)
			array_push($arra, new Venta($id));

		return $arra;
	}
	public function get_Lista_Proyectos(){
		$arra= array();
		foreach($this->get_Proyectos() as $id)
			array_push($arra, new Proyecto($id));

		return $arra;
	}
	public function get_Fecha_Ultima_Accion($usr_id){
		$query = "SELECT MAX(fecha) as ultima_fecha FROM acciones_de_trabajo WHERE fk_cliente='$this->id' AND fk_usuario='$usr_id';";
		if(!$rs=mysql_query($query))
			throw new Exception("Error al obtener la fecha de la &uacute;ltima acci&oacute;n del gestor");
		$row = mysql_fetch_array($rs);
		return $row['ultima_fecha'];
	}

	/*
	 * Métodos Modificadores.
	 *
	 ************************/

	/**
	 * Crea un nuevo Cliente en la BBDD a partir de un array indexado con todos los campos.
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
		//FB::info($datos,'Cliente crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear un cliente nuevo:
		 * 		razon social
		 * 		tipo
		 * 		domicilio
		 * 		localidad
		 * 		provincia
		 * 		cp
		 * 		sector
		 * 		gestor
		 * 		telefono
		 *
		 * Datos a los que hay que asignarle un valor por defecto:
		 * 		grupo empresas -> id=0
		 *
		 */
		$validar = new Validador();
		$ListaClientes = new ListaClientes();

		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['razon_social'] == '' || ! isset($datos['razon_social']))
			$errores .= "<br/>Empresa: La raz&oacute;n social es obligatoria.";
		if($datos['localidad'] == '' || ! isset($datos['localidad']))
			$errores .= "<br/>Empresa: La localidad es obligatoria.";
		if($datos['CP'] == '' || ! isset($datos['CP']))
			$errores .= "<br/>Empresa: El CP es obligatorio.";
		if($datos['sector'] == '' || ! isset($datos['localidad']))
			$errores .= "<br/>Empresa: El sector es obligatorio.";
		if($datos['provincia'] == '' || ! isset($datos['provincia']))
			$errores .= "<br/>Empresa: La provincia es obligatoria.";

		if(isset($datos['NIF']) && !$validar->nif_cif($datos['NIF']))
			$errores .= "<br/>Empresa: El CIF/NIF es incorrecto.";

		if(!isset($datos['gestor']))
			$errores .= "<br/>Empresa: Gestor no v&aacute;lido.";
		if(isset($datos['telefono'])){
			if($datos['telefono'] == '')
				$errores .= "<br/>Empresa: El tel&eacute;fono es obligatorio.";
			if(!$validar->telefono($datos['telefono']))
				$errores .= "<br/>El n&uacute;mero de tel&eacute;fono no es v&aacute;lido";
		}else $errores .= "<br/>Empresa: El tel&eacute;fono es obligatorio.";

		$query = "SELECT id,nombre FROM clientes_tipos WHERE id='".trim($datos['tipo_cliente'])."' LIMIT 1";
		if(!$result=  mysql_query($query))
			$errores .= "<br/>Empresa: Tipo de empresa no valido";
		$row=mysql_fetch_array($result);
		$this->tipo_cliente = array('id' => $row['id'], 'nombre' => $row['nombre']);

		$query = "SELECT id,nombre FROM grupos_empresas WHERE id='".trim($datos['grupo_empresas'])."' LIMIT 1";
		if(!$result=  mysql_query($query))
			$errores .= "<br/>Empresa: Grupo de empresa no valido";
		$row=mysql_fetch_array($result);
		$this->grupo_empresas = array('id' => $row['id'], 'nombre' => $row['nombre']);

		if($errores != '') throw new Exception($errores);

		//Si todo ha ido bien:
		return $this->guardar($datos);
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un
	 * cliente, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de un cliente.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){//FB::info($datos);

		if(!$datos['cliente_principal']){
			$coincidencias = $this->buscar_coincidencias($datos['telefono'], $datos['razon_social']);
			if($coincidencias != '' && ! $datos['continuar'])
				return($coincidencias);
			$cliente_principal = 0;
		}
		else{
			$cliente_principal = 1;
			$query = "UPDATE clientes SET cliente_principal = '0' WHERE cliente_principal='1';";
			if(!mysql_query($query))
				throw new Excepcion("Error cr&iacute;tico al deshacer la empresa propietaria anterior");
		}

		$s_into.="";
		$s_values.="";
		$validar = new Validador();
		if(isset($datos['NIF']) && $datos['NIF'] != ''){
			$s_into.=",NIF";
			$s_values.=",'".mysql_real_escape_string(trim($datos['NIF']))."'";
		}
		if(isset($datos['web']) && $datos['web'] != ''){
			$s_into.=",web";
			$s_values.=",'".mysql_real_escape_string(trim($datos['web']))."'";
		}
		if(isset($datos['numero_empleados']) && $datos['numero_empleados'] != ''){
			$s_into.=",numero_empleados";
			$s_values.=",'".trim($datos['numero_empleados'])."'";
		}
		if(isset($datos['fecha_renovacion']) && $datos['fecha_renovacion'] != ''){
			$s_into.=",fecha_renovacion";
			$s_values.=",'".trim($datos['fecha_renovacion'])."'";
		}
		if(isset($datos['creditos']) && $datos['creditos'] != ''){
			$s_into.=",creditos";
			$s_values.=",'".trim($datos['creditos'])."'";
		}
		if(isset($datos['FAX']) && $datos['FAX'] != ''){
			$s_into.=",FAX";
			$s_values.=",'".trim($datos['FAX'])."'";
		}
			if(isset($datos['norma_implantada']) && $datos['norma_implantada'] != ''){
			$s_into.=",norma_implantada";
			$s_values.=",'".mysql_real_escape_string(trim($datos['norma_implantada']))."'";
		}
		if(isset($datos['SPA_actual']) && $datos['SPA_actual'] != ''){
			$s_into.=",SPA_actual";
			$s_values.=",'".mysql_real_escape_string(trim($datos['SPA_actual']))."'";
		}
		if(isset($datos['sector']) && $datos['sector'] != ''){
			$s_into.=",sector";
			$s_values.=",'".mysql_real_escape_string(trim($datos['sector']))."'";
		}
		if(isset($datos['localidad']) && $datos['localidad'] != ''){
			$s_into.=",localidad";
			$s_values.=",'".mysql_real_escape_string(trim($datos['localidad']))."'";
		}
		if(isset($datos['domicilio']) && $datos['domicilio'] != ''){
			$s_into.=",domicilio";
			$s_values.=",'".mysql_real_escape_string(trim($datos['domicilio']))."'";
		}

		if(isset($datos['telefono']) && $datos['telefono'] != ''){
			$s_into.=",telefono";
			$s_values.=",'".trim($datos['telefono'])."'";
		}
		if(isset($datos['CP']) && $datos['CP'] != ''){
			$s_into.=",CP";
			$s_values.=",'".trim($datos['CP'])."'";
		}
		$query = "
			INSERT INTO clientes (  razon_social,
									provincia,
									fk_tipo_cliente,
									nombre_tipo_cliente,
									fk_grupo_empresas,
									nombre_grupo_empresas,
									cliente_principal
									$s_into
								)VALUES(
									'".mysql_real_escape_string(trim($datos['razon_social']))."',
									'".mysql_real_escape_string(trim($datos['provincia']))."',
									'".$this->tipo_cliente['id']."',
									'".$this->tipo_cliente['nombre']."',
									'".$this->grupo_empresas['id']."',
									'".$this->grupo_empresas['nombre']."',
									'$cliente_principal'
									$s_values
								);";
									if(!mysql_query($query))
										throw new Exception("Error al crear la empresa. ".$query);
									$this->id = mysql_insert_id();

									//Insertamos el gestor
									$query = "INSERT INTO clientes_rel_usuarios (
									fk_cliente,
									fk_usuario,
									ha_insertado
								) VALUES (
									'$this->id',
									'".trim($datos['gestor'])."',
									'1'
								);";	//FB::info($query);
		if(!mysql_query($query)){
			$this->del_Cliente();
			throw new Exception("Error al crear el Empresa: No se pudo establecer el gestor.");
		 }

		 //Los datos de localidad, provincia etc son los datos de la sede principal del cliente/empresa.
		 //Lo metemos directamente, en lugar de llamar al método crear_Sede
		 $query = "INSERT INTO clientes_sedes (localidad, CP, provincia, direccion, fk_cliente, es_sede_principal)
						VALUES ('".mysql_real_escape_string(trim($datos['localidad']))."',
								'".mysql_real_escape_string(trim($datos['CP']))."',
								'".mysql_real_escape_string(trim($datos['provincia']))."',
								'".mysql_real_escape_string(trim($datos['domicilio']))."',
								'$this->id',
								'1');";
		 if(!mysql_query($query)){
			$this->del_Cliente();
			throw new Exception("Error al crear el Empresa: No se pudo establecer la sede principal.");
		 }

		if(isset($datos['contactos'])){
			$this->add_Contactos($datos['contactos']);
		}
		if(isset($datos['contacto_nombre'])){
			$id_contacto = $this->crear_Contacto($datos);
			//Lo relacionamos y salimos
			$this->relacionar_Contacto($id_contacto);
		}
		return $this->id;
	}

	/**
	 * Devuelve un STRING con coincidencias encontradas
	 * @param unknown_type $telefono
	 * @param unknown_type $razon_social
	 */
	private function buscar_coincidencias($telefono, $razon_social){
		$coincidencias = '';

		$coincidencias_telefono = $this->coincidencias_Telefono($telefono);
		if(!empty($coincidencias_telefono))
			$coincidencias .= '<br/>Coincidencias por tel&eacute;fono: ';
		foreach($coincidencias_telefono as $cliente)
			$coincidencias .= '<br/>'.$cliente['razon_social'].' del gestor '.$cliente['gestor'];

		$coincidencias_razon_social = $this->coincidencias_Razon_social($razon_social);
		if(!empty($coincidencias_razon_social))
			$coincidencias .= '<br/>Coincidencias por raz&oacute;n social:';
		foreach($coincidencias_razon_social as $cliente)
			$coincidencias .= '<br/>'.$cliente['razon_social'].' del gestor '.$cliente['gestor'];

		return $coincidencias;
	}

	/**
	 * Devuelve un ARRAY con las razones sociales de los clientes que tienen el tel�fono
	 * @param unknown_type $telefono
	 */
	private function coincidencias_Telefono($telefono){
		$coincidencias = array();
		$query = "SELECT razon_social, fk_usuario as gestor
					FROM clientes
						INNER JOIN clientes_rel_usuarios ON clientes.id = clientes_rel_usuarios.fk_cliente AND clientes_rel_usuarios.ha_insertado = '1'
					WHERE telefono = '$telefono';";
		$rs = mysql_query($query);
		if(mysql_num_rows($rs) > 0){
			while($row = mysql_fetch_array($rs))
				$coincidencias[] = $row;
		}
		return $coincidencias;
	}
	/**
	 * Devuelve un ARRAY con las razones sociales de los clientes que tienen alguna coincidencia con la razon social pasada
	 * @param unknown_type $razon_social
	 */
	private function coincidencias_Razon_Social($razon_social){

		$filtro = '';
		$esp_duplicados = eregi_replace("[[:space:]]+"," ",$razon_social);
			$tmp = explode(" ", $esp_duplicados);
			$filtro.= " AND ( 0 ";
			foreach($tmp as $palabro){
					$filtro.= " OR razon_social LIKE '%$palabro%' ";
			}
			$filtro.= " )";


		$coincidencias = array();
		$query = "SELECT razon_social, fk_usuario as gestor
					FROM clientes
						INNER JOIN clientes_rel_usuarios ON clientes.id = clientes_rel_usuarios.fk_cliente AND clientes_rel_usuarios.ha_insertado = '1'
					WHERE 1 $filtro";
		//FB::error($query);
		$rs = mysql_query($query);
		if(mysql_num_rows($rs) > 0){
			while($row = mysql_fetch_array($rs))
				$coincidencias[] = $row;
		}
		return $coincidencias;
	}

	public function get_DisableEdit(){
		$disable = array();
		$usuario = new Usuario($_SESSION['usuario_login']);
		if(!$usuario->esAdministrador()){
			//FB::error($this,'entro');
			if($this->razon_social != '')
				$disable['razon_social'] = 'readonly="readonly"';
		/*	if($this->tipo_cliente != '')
				$disable['tipo_cliente'] = 'disabled';
			if($this->grupo_empresas != '')
				$disable['grupo_empresas'] = 'disabled';
			*/if($this->NIF != '')
				$disable['NIF'] = 'readonly="readonly"';
			if($this->domicilio != '')
				$disable['domicilio'] = 'readonly="readonly"';
			if($this->localidad != '')
				$disable['localidad'] = 'readonly="readonly"';
			if($this->provincia != '')
				$disable['provincia'] = 'readonly="readonly"';
			if($this->web != '')
				$disable['web'] = 'readonly="readonly"';
			if($this->sector != '')
				$disable['sector'] = 'readonly="readonly"';
			if($this->SPA_actual != '')
				$disable['SPA_actual'] = 'readonly="readonly"';
			if($this->norma_implantada != '')
				$disable['norma_implantada'] = 'readonly="readonly"';
			if($this->fecha_renovacion != '')
				$disable['fecha_renovacion'] = 'readonly="readonly"';
			if($this->CP != '')
				$disable['CP'] = 'readonly="readonly"';
			if($this->creditos != '')
				$disable['creditos'] = 'readonly="readonly"';
			if($this->FAX != '')
				$disable['FAX'] = 'readonly="readonly"';
			if($this->telefono != '')
				$disable['telefono'] = 'readonly="readonly"';
			if($this->numero_empleados != '')
				$disable['numero_empleados'] = 'readonly="readonly"';
			if($this->observaciones != '')
				$disable['observaciones'] = 'readonly="readonly"';
			if($this->actividad != '')
				$disable['actividad'] = 'readonly="readonly"';

		}
		//FB::error($disable);
		return $disable;
	}
	/**
	 * Crea un contacto nuevo indicado en la creación del Cliente
	 * @param $datos
	 * @return unknown_type
	 */
	public function crear_Contacto($datos){
		$Contacto = new Contacto();
		$datos_contacto = array('nombre'=>$datos['contacto_nombre'],'telefono'=>$datos['contacto_telefono'],'email'=>$datos['contacto_email'],'cargo'=>$datos['contacto_cargo']);
		$id_contacto = $Contacto->crear($datos_contacto);

		return $id_contacto;

	}

	public function crear_Sede($datos){
		$sede = new Sede();
		$datos['id_cliente'] = $this->id;
		$sede->crear($datos);
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
		$query = "DELETE FROM clientes_rel_contactos WHERE fk_contacto = '$id_contacto'; ";
		mysql_query($query);

		$query = "DELETE FROM clientes_sedes_rel_contactos WHERE fk_contacto = '$id_contacto'; ";
		mysql_query($query);

		$query = "DELETE FROM contactos WHERE id = '$id_contacto'; ";
		mysql_query($query);
	}

	public function tiene_Contacto($id){
		if($this->get_Contactos())
			return in_array($id, $this->contactos);

		return false;
	}

	public function del_Cliente($borrado_total = 0){

		if(!$borrado_total)
			if(count($this->acciones) > 0 || count($this->ofertas) > 0)
				throw new Exception ("La empresa ".$this->razon_social." tiene acciones u ofertas.");


		$query = "DELETE FROM clientes WHERE id = '$this->id'; ";
		mysql_query($query);


		$query = "DELETE FROM acciones_de_trabajo WHERE fk_cliente = '$this->id'; ";
		mysql_query($query);
		$query = "DELETE FROM ofertas WHERE fk_cliente = '$this->id'; ";
		mysql_query($query);

		/*foreach($this->get_Acciones() as $idaccion){
			$accion = new Accion($idaccion);
			$accion->del_Accion();
		}

		foreach($this->get_Ofertas() as $id){
			$oferta = new Oferta($id);
			$oferta->del_Oferta();
		}*/

		$query = "DELETE FROM clientes_rel_usuarios WHERE fk_cliente = '$this->id'; ";
		mysql_query($query);

		$query = "DELETE FROM clientes_rel_contactos WHERE fk_cliente = '$this->id'; ";
		mysql_query($query);


	}
	public function relacionar_Contacto($id_contacto){
		$query = "INSERT INTO clientes_rel_contactos (fk_cliente, fk_contacto) VALUES ('$this->id','$id_contacto')";
		$rs = mysql_query($query);
	}

	/**
	* Gestores
	*/
	public function add_Gestor($id_gestor){
		if($this->existe_Gestor($id_gestor)){
			$this->relacionar_Gestor($id_gestor);
		}
		else
			throw new Exception('Cliente - add_Gestor: El gestor no existe');

	}
	public function del_Gestor($idGestor){
		if($this->existe_Gestor($idGestor)){
			$query = "DELETE FROM clientes_rel_usuarios WHERE fk_cliente='$this->id' AND fk_usuario = '$idGestor'";
			mysql_query($query);
			$this->cargar_Gestores();
		}
	}

	private function existe_Gestor($id_gestor){
		$query = "SELECT * FROM usuarios WHERE id = '".$id_gestor."'; ";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);

		if(mysql_num_rows($rs) > 0)
		return $row['id'];
		return false;
	}

	public function relacionar_Gestor($id_gestor){
		if(!in_array($id_gestor,$this->gestores)){

			$query = "INSERT INTO clientes_rel_usuarios (fk_cliente, fk_usuario) VALUES ('$this->id','$id_gestor')";
			//FB::info($query,'query relacionar gestor');
			$rs = mysql_query($query);
		}
	}

	/**
	* Acciones
	*/
	public function add_Accion($datos){
		$datos['cliente'] = $this->id;
		$accion = new Accion();
		$accion->crear($datos);
		$this->acciones[] = $accion->get_Id();
	}
	public function del_Accion($idAccion){
		$accion = new Accion($idAccion);
		$accion->del_Accion();
		$this->cargar_Acciones();
	}

	/**
	* Ofertas
	*/
	public function add_Oferta($datos){
		$datos['cliente'] = $this->id;
		$oferta = new Oferta();
		$oferta->crear($datos);
		$this->ofertas[] = $oferta->get_Id();
	}

	/**
	 * Modifica el nombre del Cliente.
	 *
	 * @param int $CP nuevo CP
	 */
	public function set_CP($CP){
		$Validar = new Validador();

		if($this->id && $Validar->CP($CP)){

			$query = "UPDATE clientes SET CP='".trim($CP)."' WHERE id='$this->id' ";//FB::info($query);
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el CP en la BBDD.");

			$this->CP = $CP;
		}else
		throw new Exception("CP incorrecto.");
	}

	/**
	 * Modifica los creditos
	 *
	 * @param int $creditos
	 */
	public function set_Creditos($creditos){

		if($this->id && (is_numeric($creditos) || $creditos=='' )){
			if($creditos!='')
				$query = "UPDATE clientes SET creditos='".trim($creditos)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE clientes SET creditos=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar los cr&eacute;ditos en la BBDD.");

			$this->creditos = $creditos;
		}else
		throw new Exception("Cr&eacute;ditos incorrecto.");
	}

	public function set_FAX($FAX){
		$Validar = new Validador();

		if($this->id && $Validar->telefono($FAX)){
			if($FAX != '')
				$query = "UPDATE clientes SET FAX='".trim($FAX)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE clientes SET FAX=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el FAX en la BBDD.".$query);

			$this->FAX = $FAX;
		}else
		throw new Exception("FAX incorrecto.");
	}

	public function set_Telefono($telefono){
		$Validar = new Validador();

		if($this->id && ($Validar->telefono($telefono) || $Validar->movil($telefono))){
			if($telefono != '')
				$query = "UPDATE clientes SET telefono='".trim($telefono)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE clientes SET telefono=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el tel&eacute;fono en la BBDD.");

			$this->telefono = $telefono;
		}else
		throw new Exception("Tel&eacute;fono incorrecto.");
	}
	/**
	 * Modifica el domicilio del Cliente.
	 *
	 * Si el domicilio es igual que el actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $domicilio Nuevo domicilio.
	 */
	public function set_Domicilio($domicilio){
		$Validar = new Validador();
		if($this->id && strcmp($this->domicilio, $domicilio) != 0){
			if($Validar->cadena($domicilio)){
				$query = "UPDATE clientes SET domicilio='".mysql_real_escape_string($domicilio)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el domicilio en la BBDD.");

				$this->domicilio = $domicilio;
			}else
			throw new Exception("Domicilio incorrecto.");
		}
	}

	/**
	 * Modifica la localidad del Cliente.
	 *
	 * Si la localidad es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $localidad Nueva localidad.
	 */
	public function set_Localidad($localidad){
		$Validar = new Validador();
		if($this->id && strcmp($this->localidad, $localidad) != 0){
			if($Validar->cadena($localidad)){
				$query = "UPDATE clientes SET localidad='".mysql_real_escape_string($localidad)."' WHERE id='$this->id' ";
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
				$query = "UPDATE clientes SET provincia='".mysql_real_escape_string($provincia)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la provincia en la BBDD.");

				$this->provincia = $provincia;
			}else
			throw new Exception("Provincia incorrecta.");
		}
	}


	public function set_Actividad($texto){
		$Validar = new Validador();
		if($this->id && strcmp($this->actividad, $texto) != 0){
			if($Validar->cadena($texto)){
				$query = "UPDATE clientes SET actividad='".mysql_real_escape_string($texto)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar las actividad en la BBDD.");

				$this->actividad = $texto;
			}else
			throw new Exception("Campo actividad incorrecto.");
		}
	}

	public function set_Observaciones($texto){
		$Validar = new Validador();
		if($this->id && strcmp($this->observaciones, $texto) != 0){
			if($Validar->cadena($texto)){
				$query = "UPDATE clientes SET observaciones='".mysql_real_escape_string($texto)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar las observaciones en la BBDD.");

				$this->observaciones = $texto;
			}else
			throw new Exception("Campo observaciones incorrecto.");
		}
	}

	/**
	 * Modifica la norma implantada del Cliente.
	 *
	 * Si la norma implantada es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $norma_implantada Nueva norma implantada.
	 */
	public function set_Norma_Implantada($norma_implantada){
		$Validar = new Validador();
		if($this->id && strcmp($this->norma_implantada, $norma_implantada) != 0){
			if($Validar->cadena($norma_implantada)){
				$query = "UPDATE clientes SET norma_implantada='".mysql_real_escape_string($norma_implantada)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la norma implantada en la BBDD.");

				$this->norma_implantada = $norma_implantada;
			}else
			throw new Exception("DNorma implantada incorrecta.");
		}
	}

	/**
	 * Modifica la razon social del Cliente.
	 *
	 * Si la razon social es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $razon_social Nueva razon social.
	 */
	public function set_Razon_Social($razon_social){
		$Validar = new Validador();
		if($this->id && strcmp($this->razon_social, $razon_social) != 0){
			if($Validar->cadena($razon_social)){
				$query = "UPDATE clientes SET razon_social='".mysql_real_escape_string($razon_social)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la raz&oacute;n social en la BBDD.");

				$this->razon_social = $razon_social;
			}else
			throw new Exception("Raz&oacute;n social incorrecta.");
		}
	}

	/**
	 * Modifica el sector del Cliente.
	 *
	 * Si el sector es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $sector Nuevo sector.
	 */
	public function set_Sector($sector){
		$Validar = new Validador();
		if($this->id && strcmp($this->sector, $sector) != 0){
			if($Validar->cadena($sector)){
				$query = "UPDATE clientes SET sector='".mysql_real_escape_string($sector)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el sector en la BBDD.");

				$this->sector = $sector;
			}else
			throw new Exception("Ssector incorrecto.");
		}
	}

	/**
	 * Modifica la SPA actual del Cliente.
	 *
	 * Si la SPA actual es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $SPA_actual Nueva SPA actual.
	 */
	public function set_SPA_Actual($SPA_actual){
		$Validar = new Validador();
		if($this->id && strcmp($this->SPA_actual, $SPA_actual) != 0){
			if($Validar->cadena($SPA_actual)){
				$query = "UPDATE clientes SET SPA_actual='".mysql_real_escape_string($SPA_actual)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la SPA en la BBDD.");

				$this->SPA_actual = $SPA_actual;
			}else
			throw new Exception("SPA incorrecto.");
		}
	}

	/**
	 * Modifica la web del Cliente.
	 *
	 * Si la web es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $web Nueva web.
	 */
	public function set_Web($web){
		$Validar = new Validador();
		if($this->id && strcmp($this->web, $web) != 0){
			if($Validar->cadena($web)){
				$query = "UPDATE clientes SET web='".mysql_real_escape_string($web)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la web en la BBDD.");

				$this->web = $web;
			}else
			throw new Exception("Web incorrecta");
		}
	}

	/**
	 * Modifica la NIF del Cliente.
	 *
	 * Si la NIF es igual que la actual, no lanza la consulta, y si viene vacía se eleva una excepción.
	 *
	 * @param string $NIF Nueva NIF.
	 */
	public function set_NIF($NIF){
		$Validar = new Validador();
		if($this->id && strcmp($this->NIF, $NIF) != 0){
			if($Validar->nif_cif($NIF)){
				$query = "UPDATE clientes SET NIF='".mysql_real_escape_string($NIF)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el NIF/CIF en la BBDD.");

				$this->NIF = $NIF;
			}else
			throw new Exception("NIF/CIF incorrecto.");
		}
	}

	/**
	 * Modifica la fecha de renovación del cliente
	 * @param int $fecha nueva fecha de renovación
	 */
	public function set_Fecha_Renovacion($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE clientes SET fecha_renovacion='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de renovaci&oacute;n en la BBDD.");
			$this->fecha_renovacion = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica el grupo de empresas del cliente
	 * @param int $id_grupo nuevo grupo de empresas
	 */
	public function set_Grupo_Empresas($id_grupo){
		if(is_numeric($id_grupo)){
			$query = "SELECT id, nombre FROM grupos_empresas WHERE id= '$id_grupo' limit 1;";
			if(!$rs = mysql_query($query))
				throw new Exception('Grupo no valido');
			$row = mysql_fetch_array($rs);

			$query = "UPDATE clientes 
						SET fk_grupo_empresas='$id_grupo',
						nombre_grupo_empresas = '".$row['nombre']."'
						WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el grupo en la BBDD.");

			$this->grupo_empresas = array('id'=>$row['id'], 'nombre'=>$row['nombre']);

		}else
		throw new Exception("Debe introducir un grupo v&aacute;lido.");
	}

	/**
	 * Modifica el tipo del cliente
	 * @param int $id_tipo nuevo tipo
	 */
	public function set_Tipo($id_tipo){
		if(is_numeric($id_tipo)){
			$query = "SELECT id, nombre FROM clientes_tipos WHERE id= '$id_tipo' limit 1;";
			if(!$rs = mysql_query($query))
				throw new Exception('Tipo incorrecto');
			$row = mysql_fetch_array($rs);

			$query = "UPDATE clientes 
						SET fk_tipo_cliente='$id_tipo',
							nombre_tipo_cliente = '".$row['nombre']."'
						WHERE id='$this->id'";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el tipo en la BBDD.");

			$this->tipo_cliente = array('id'=>$row['id'], 'nombre'=>$row['nombre']);

		}else
			throw new Exception("Debe introducir un tipo v&aacute;lido.");
	}

	/**
	 * Establece el número de empleados del Cliente.
	 *
	 * @param integer $numero_empleados Número de empleados del cliente.
	 */
	public function set_Numero_Empleados($numero_empleados){
		if(is_numeric($numero_empleados) || $numero_empleados == ''){
			if($numero_empleados != '')
				$query = "UPDATE clientes SET numero_empleados = '$numero_empleados' WHERE id='$this->id';";
			else
				$query = "UPDATE clientes SET numero_empleados = null WHERE id='$this->id';";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el n&uacute;mero de empleados.");

			$this->numero_empleados = $numero_empleados;
		}
	}

	public function editar($datos){
		if($this->get_Razon_Social() != $datos['razon_social'])
			$this->set_Razon_Social($datos['razon_social']);

		$tipo_cliente = $this->get_Tipo_Cliente();
		if($tipo_cliente['id'] != $datos['tipo_cliente'])
			$this->set_Tipo($datos['tipo_cliente']);

		if($this->get_Localidad() != $datos['localidad'])
			$this->set_Localidad($datos['localidad']);

		if($this->get_Domicilio() != $datos['domicilio'])
			$this->set_Domicilio($datos['domicilio']);

		if($this->get_Provincia() != $datos['provincia'])
			$this->set_Provincia($datos['provincia']);

		$grupo_cliente = $this->get_Grupo_Empresas();
		if($grupo_cliente['id'] != $datos['grupo_empresas'])
			$this->set_Grupo_Empresas($datos['grupo_empresas']);

		if($this->get_NIF() != $datos['NIF'])
			$this->set_NIF($datos['NIF']);

		if($this->get_CP() != $datos['CP'])
			$this->set_CP($datos['CP']);

		if($this->get_Numero_Empleados() != $datos['numero_empleados'] || $datos['numero_empleados'] == '')
			$this->set_Numero_Empleados($datos['numero_empleados']);

		if($this->get_Web() != $datos['web'])
			$this->set_Web($datos['web']);

		if($this->get_Telefono() != $datos['telefono'])
			$this->set_Telefono($datos['telefono']);

		if($this->get_FAX() != $datos['FAX'])
			$this->set_FAX($datos['FAX']);
		if($this->get_Sector() != $datos['sector'])
			$this->set_Sector($datos['sector']);

		if($this->get_SPA_Actual() != $datos['SPA_actual'])
			$this->set_SPA_Actual($datos['SPA_actual']);

		if($this->get_Fecha_Renovacion() != $datos['fecha_renovacion'])
			$this->set_Fecha_Renovacion($datos['fecha_renovacion']);

		if($this->get_Norma_Implantada() != $datos['norma_implantada'])
			$this->set_Norma_Implantada($datos['norma_implantada']);

		if($this->get_Creditos() != $datos['creditos'])
			$this->set_Creditos($datos['creditos']);
	}

}
?>