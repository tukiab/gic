<?php
/**
 * Clase que gestiona las Ofertas.
 */
include_once('../../html/Utils/utils.php');
class Oferta{

	/**
	 * Identificador de la Oferta. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;
	
	/**
	 * Código de la oferta
	 * @var string
	 */
	private $codigo;

	/**
	 * Estado de la Oferta
	 * @var array indexado por id y nombre
	 */
	private $estado_oferta;

	/**
	 * usuario que realiza la oferta.
	 * @var string con el id del usuario
	 */
	private $usuario;

	/**
	 * cliente asociado a la oferta.
	 * @var integer id del cliente
	 */
	private $cliente;
	
	/**
	 * producto asociado a la oferta.
	 * @var integer id del producto
	 */
	private $producto;
	
	/**
	 * proveedor asociado a la oferta.
	 * @var integer id del proveedor
	 */
	private $proveedor;
	
	/**
	 * colaborador asociado a la oferta.
	 * @var integer id del colaborador
	 */
	private $colaborador;
	
	/**
	 * Fecha en formato timestamp.
	 * @var integer
	 */
	private $fecha;

	/**
	 * Fecha de definicion en formato timestamp.
	 * @var integer
	 */
	private $fecha_definicion;

	/**
	 * Nombre de la oferta.
	 * @var string
	 */
	private $nombre_oferta;

	/**
	 * Importe de la oferta
	 * @var integer
	 */
	private $importe;
	
	/**
	 * Probabilidad de contratación.
	 * @var integer
	 */
	private $probabilidad_contratacion;
	
	/**
	 * Indica si la oferta es una oportunidad de negocio
	 * @var bool
	 */
	private $es_oportunidad_de_negocio;
	
	/**
	 * Indica si la oferta está aceptada
	 * @var bool
	 */
	private $aceptado;
	
	

	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Oferta.
	 *
	 * Si recibe un identificador válido, se carga la Oferta de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una Oferta nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_oferta Id de la Oferta. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Oferta en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Oferta válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT ofertas.*,
							 ofertas_estados.id AS id_estado, ofertas_estados.nombre AS nombre_estado
						FROM ofertas
				    		INNER JOIN ofertas_estados
								ON ofertas.fk_estado_oferta = ofertas_estados.id
						WHERE ofertas.id = '$this->id'";
			//FB::info($query,'Oferta->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Oferta de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Oferta en la BBDD");

			$row = mysql_fetch_array($result);

			$this->codigo = $row['codigo'];
			$this->fecha_definicion = $row['fecha_definicion'];
			$this->fecha = $row['fecha'];
			$this->nombre_oferta = $row['nombre_oferta'];
			$this->estado_oferta = array('id'=>$row['id_estado'], 'nombre'=>$row['nombre_estado']);
			$this->usuario =$row['fk_usuario'];
			$this->cliente = $row['fk_cliente'];
			$this->producto = $row['fk_tipo_producto'];
			$this->proveedor = $row['fk_proveedor'];
			$this->colaborador = $row['fk_colaborador'];
			$this->importe = $row['importe'];
			$this->probabilidad_contratacion = $row['probabilidad_contratacion'];
			$this->es_oportunidad_de_negocio = $row['es_oportunidad_de_negocio'];
			$this->aceptado = $row['aceptado'];

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
	 * Devuelve la fecha de definicion
	 * @return int $fecha
	 */
	public function get_Fecha_Definicion(){
		return $this->fecha_definicion;
	}

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
	public function get_Nombre_Oferta(){
		return $this->nombre_oferta;
	}
	
	/**
	 * Devuelve el codigo
	 * @return string $codigo
	 */
	public function get_Codigo(){
		return $this->codigo;
	}


	/**
	 * Devuelve el id de usuario
	 * @return int $usuario
	 */
	public function get_Usuario(){
		return $this->usuario;
	}

	/**
	 * Devuelve el estado de oferta
	 * @return array $estado_oferta indexado por id y nombre
	 */
	public function get_Estado_Oferta(){
		return $this->estado_oferta;
	}

	/**
	 * Devuelve el cliente
	 * @return Cliente $cliente 
	 */
	public function get_Cliente(){
		return new Cliente($this->cliente);
	}
	
	public function get_Producto(){
		$query = "SELECT id, nombre FROM productos_tipos where id = '$this->producto'";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		return $row;
	}
	
	public function get_Proveedor(){
		$query = "SELECT NIF, razon_social FROM proveedores where NIF = '$this->proveedor'";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		return $row;
	}
	
	public function get_Colaborador(){
		$query = "SELECT id, razon_social as nombre FROM colaboradores where id = '$this->colaborador'";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		return $row;
	}
	
	public function get_Importe(){
		return $this->importe;
	}
	
	public function get_Probabilidad_Contratacion(){
		$query = "SELECT * FROM ofertas_probabilidades WHERE id = '$this->probabilidad_contratacion';";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		return $row;
	}
	
	public function get_Es_Oportunidad_De_Negocio(){
		return $this->es_oportunidad_de_negocio;
	}
	
	public function get_Aceptado(){
		return $this->aceptado;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Oferta en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Oferta.
	 * @return integer $id_oferta Id del nuevo Oferta.
	 */
	public function crear($datos){
		FB::info($datos,'Oferta crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear una oferta nuevo:
		 * 		nombre
		 * 		estado_oferta
		 * 		cliente
		 * 		id_usuario
		 * 		fecha
		 *
		 */
		$validar = new Validador();
		$ListaOfertas = new ListaOfertas();
		$ListaUsuarios = new ListaUsuarios();

		$array_estados = $ListaOfertas->lista_Estados();
		$array_usuarios = $ListaUsuarios->lista_Usuarios();
		$array_productos = $ListaOfertas->lista_Tipos_Productos();		
		$array_proveedores = $ListaOfertas->lista_Tipos_Proveedores();
		$array_probabilidades = $ListaOfertas->lista_Probabilidades();
		$array_colaboradores = $ListaOfertas->lista_Colaboradores();
		
		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['nombre_oferta'] == '' || ! isset($datos['nombre_oferta']))
			$errores .= "<br/>El nombre es obligatorio.";
		if($datos['es_oportunidad_de_negocio'] == '' || ! isset($datos['es_oportunidad_de_negocio']))
			$errores .= "<br/>Indicar si es oferta u oportunidad";
		if($datos['fecha'] == '' || ! isset($datos['fecha']))
			$errores .= "<br/>La fecha es obligatoria.";
		if($datos['cliente'] == '' || ! isset($datos['cliente']))
			$errores .= "<br/>El cliente es obligatorio.";			
		if($datos['usuario'] == '' || ! isset($datos['usuario']))
			$errores .= "<br/>El usuario es obligatorio.";
		if($datos['importe'] == '' || ! isset($datos['importe']))
			$errores .= "<br/>El importe es obligatorio.";
		else if(!is_numeric($datos['importe']))
			$errores .= "<br/>valor incorrecto de importe.";
		if($datos['fecha_definicion'] == '' || ! isset($datos['fecha_definicion']))
			$errores .= "<br/>La fecha de definici&oacute;n es obligatoria.";
		else if(!is_numeric($datos['fecha_definicion']))
			$errores .= "<br/>valor incorrecto de fecha de definicion.";
		
		if(!in_array($datos['estado_oferta'], array_keys($array_estados)))
			$errores .= "<br/>Estado no válido.";
		if(!in_array($datos['producto'], array_keys($array_productos)))
			$errores .= "<br/>Producto no válido.";		
		if(!in_array($datos['proveedor'], array_keys($array_proveedores)) && $datos['proveedor']!=0)
			$errores .= "<br/>Proveedor no válido.";
		if(!in_array($datos['probabilidad_contratacion'], array_keys($array_probabilidades)))
			$errores .= "<br/>Probabilidad de contrataci&oacute;n no válida.";
		if(!in_array($datos['colaborador'], array_keys($array_colaboradores)))
			$errores .= "<br/>Colaborador no válido.";
			
			
		if($errores != '') throw new Exception($errores);
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * oferta, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una oferta.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		FB::info($datos, 'datos al crear O');
		$aceptado = 0;if($datos['estado_oferta'] == 2) $aceptado=1;
		$query = "
			INSERT INTO ofertas (   nombre_oferta,
									fk_usuario,
									fk_estado_oferta,
									fk_tipo_producto,
									fk_proveedor,
									fk_cliente,
									fk_colaborador,
									fecha,
									importe,
									probabilidad_contratacion,
									fecha_definicion,
									es_oportunidad_de_negocio,
									aceptado
								)VALUES(
									'".mysql_real_escape_string(trim($datos['nombre_oferta']))."',
									'".trim($datos['usuario'])."',
									'".trim($datos['estado_oferta'])."',
									'".trim($datos['producto'])."',
									'".trim($datos['proveedor'])."',
									'".trim($datos['cliente'])."',
									'".trim($datos['colaborador'])."',
									'".trim($datos['fecha'])."',
									'".trim($datos['importe'])."',
									'".trim($datos['probabilidad_contratacion'])."',
									'".trim($datos['fecha_definicion'])."',
									'".trim($datos['es_oportunidad_de_negocio'])."',
									'".$aceptado."'									
									
								);
		";
			FB::info($query,'Oferta crear: QUERY');
			if(!mysql_query($query))
				throw new Exception("Error al crear la Oferta. ".$query);
			$this->id = mysql_insert_id();
									
			$array_fecha = explode('/', date("d/m/Y",time()));
			$year = $array_fecha[2];
			
			$this->crear_Codigo($datos['es_oportunidad_de_negocio'],$year);

			return $this->id;
	}
	private function crear_Codigo($es_oportunidad,$year){
		$opor = 0;
		if($es_oportunidad == 1)
			$opor = 1;
			FB::info($es_oportunidad." ".$year);
		$query = "SELECT * FROM ofertas_codigos_patch WHERE de_oportunidad = '$opor' ORDER BY id DESC limit 1;";
		FB::info($query);
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		FB::warn($row);
		if($year != $row['year'])//si el a�o no es el mismo,empezamos desde numero 1
			$num = 1;		
		else//si el a�o es el mismo aumentamos el numero en 1
			$num = $row['numero']+1;	
			
		$this->codigo = $num."/".$year;
		if($es_oportunidad == 1)
			$this->codigo = "ON".$this->codigo;
			
		//Actualizamos la tabla de parche:
		$query = "INSERT INTO ofertas_codigos_patch (year, numero, de_oportunidad) VALUES ('$year','$num','$opor')";
		mysql_query($query);						
			
		//por �ltimo insertamos el c�digo en la tabla
		$query = "UPDATE ofertas SET codigo='$this->codigo' WHERE id='$this->id'";
		mysql_query($query);
	}

	private function comprobacion_Editar(){
		if($this->aceptado)
			throw new Exception("La oferta/oportunidad ".$this->nombre_oferta." no se puede editar, est&aacute; aceptada.");
	}

	/**
	 * Modifica la nombre  de la oferta
	 * @param int $nombre nueva nombre 
	 */
	public function set_Nombre_Oferta($nombre){
		
		$this->comprobacion_Editar();
		$validar = new Validador();
		if(($validar->cadena($nombre))){
			$query = "UPDATE ofertas SET nombre_oferta='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->nombre_oferta = $nombre;

		}else
		throw new Exception("Debe introducir un nombre v&aacute;lido.");
	}

	/**
	 * Modifica la fecha  de la oferta
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha($fecha){
		$this->comprobacion_Editar();
			
		if(is_numeric($fecha)){
			$query = "UPDATE ofertas SET fecha='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica la fecha de definicion
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha_Definicion($fecha){

		$this->comprobacion_Editar();


		if(is_numeric($fecha)){
			$query = "UPDATE ofertas SET fecha_definicion='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de la siguiente acci&oacute;n en la BBDD.");
			$this->fecha_definicion = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica el usuario de la oferta
	 * @param int $id_usuario nuevo usuario
	 */
	public function set_Usuario($id_usuario){
		$this->comprobacion_Editar();

		$ListaUsuarios = new ListaUsuarios();
		$array_usuarios = $ListaUsuarios->lista_Usuarios();

		if(is_numeric($id_usuario) && in_array($id_usuario, array_keys($array_usuarios))){
			$query = "UPDATE ofertas SET fk_usuario='$id_usuario' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el usuario en la BBDD.");

			$this->usuario = $id_usuario;

		}else
		throw new Exception("Debe introducir un usuario v&aacute;lido.");
	}

	/**
	 * Modifica el cliente de la oferta
	 * @param int $id_cliente nuevo cliente
	 */
	public function set_Cliente($id_cliente){
		$this->comprobacion_Editar();


		$ListaClientes = new ListaClientes();
		$array_clientes = $ListaClientes->lista_Clientes();

		if(is_numeric($id_cliente) && in_array($id_cliente, array_keys($array_clientes))){
			$query = "UPDATE ofertas SET fk_cliente='$id_cliente' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el cliente en la BBDD.");

			$this->cliente = $id_cliente;

		}else
		throw new Exception("Debe introducir un cliente v&aacute;lido.");
	}

	/**
	 * Modifica el estado de la oferta
	 * @param int $id_estado nuevo estado
	 */
	public function set_Estado($id_estado){
		$this->comprobacion_Editar();
		
		if(is_numeric($id_estado)){
			$query = "UPDATE ofertas SET fk_estado_oferta='$id_estado' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el estado en la BBDD.");

			$query = "SELECT id, nombre FROM ofertas_estados WHERE id= '$id_estado' limit 1;";
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);

			$this->estado_oferta = array('id'=>$row['id'], 'nombre'=>$row['nombre']);
			if($id_estado == 2)//Aceptado
				$this->aceptar();

		}else
		throw new Exception("Debe introducir un estado v&aacute;lido.");
	}

	private function aceptar(){
		$query = "UPDATE ofertas SET aceptado='1' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el estado en la BBDD.");
		$this->aceptado = true;
		//TODO: proceso de ventas incompleto..
	}
	
	public function set_Producto($id_producto){
		$this->comprobacion_Editar();

			if(is_numeric($id_producto)){
			$query = "UPDATE ofertas SET fk_tipo_producto='$id_producto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el producto en la BBDD.");

			$this->producto = $id_producto;

		}else
		throw new Exception("Debe introducir un producto v&aacute;lido.");
	}
	
	public function set_Proveedor($id_proveedor){
		$this->comprobacion_Editar();


		if($id_proveedor){
			$query = "UPDATE ofertas SET fk_proveedor='$id_proveedor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el proveedor en la BBDD.");

			$this->proveedor = $id_proveedor;

		}else
		throw new Exception("Debe introducir un proveedor v&aacute;lido.");
	}
	
	public function set_Colaborador($id_colaborador){
		$this->comprobacion_Editar();


		if(is_numeric($id_colaborador)){
			$query = "UPDATE ofertas SET fk_colaborador='$id_colaborador' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el colaborador en la BBDD.");

			$this->colaborador = $id_colaborador;

		}else
		throw new Exception("Debe introducir un colaborador v&aacute;lido.");
	}
	public function set_Importe($nombre){
		$this->comprobacion_Editar();

		$validar = new Validador();
		if((is_numeric($nombre))){
			$query = "UPDATE ofertas SET importe='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->importe = $nombre;

		}else
		throw new Exception("Valor incorrecto de importe.");
	}
	public function set_Probabilidad_Contratacion($nombre){
		$this->comprobacion_Editar();

		$validar = new Validador();
		if((is_numeric($nombre))){
			$query = "UPDATE ofertas SET probabilidad_contratacion='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->probabilidad_contratacion = $nombre;

		}else
		throw new Exception("Debe introducir un nombre v&aacute;lido.");
	}
	public function set_Aceptado($nombre){
		$this->comprobacion_Editar();

		
			$query = "UPDATE ofertas SET aceptado='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->aceptado = $nombre;

		
	}
	public function set_Es_Oportunidad_De_Negocio($nombre){
		$this->comprobacion_Editar();

		
			$query = "UPDATE ofertas SET es_oportunidad_de_negocio='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->es_oportunidad_de_negocio = $nombre;

	}
	
	public function del_Oferta(){
		if($this->aceptado)
			throw new Exception('No se puede borrar la oferta/oportunidad '.$this->nombre_oferta.' al estar aceptada');
		$query = "DELETE FROM ofertas WHERE id='$this->id';";
		mysql_query($query);
	}
	
}
?>
