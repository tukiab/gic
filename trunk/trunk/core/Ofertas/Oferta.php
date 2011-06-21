<?php
/**
 * Clase que gestiona las Ofertas.
 */
include_once('../../html/Common/php/utils/utils.php');
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

	private $leida;
	
	

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
			$query = "SELECT ofertas.*
						FROM ofertas
						WHERE ofertas.id = '$this->id'";
			//FB::info($query,'Oferta->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Oferta de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Oferta en la BBDD");

			$row = mysql_fetch_array($result);

			$this->leida = $row['leida'];
			$this->codigo = $row['codigo'];
			$this->fecha_definicion = $row['fecha_definicion'];
			$this->fecha = $row['fecha'];
			$this->nombre_oferta = $row['nombre_oferta'];
			$this->estado_oferta = array('id'=>$row['fk_estado_oferta'], 'nombre'=>$row['nombre_estado_oferta']);
			$this->usuario =$row['fk_usuario'];
			$this->cliente = array( 'id' => $row['fk_cliente'], 'razon_social' => $row['razon_social_cliente']) ;
			$this->producto = array( 'id' => $row['fk_tipo_producto'], 'nombre' => $row['nombre_tipo_producto']);
			$this->proveedor = array( 'id' => $row['fk_proveedor'], 'razon_social' =>$row['razon_social_proveedor']);
			$this->colaborador = array( 'id' => $row['fk_colaborador'], 'nombre' =>$row['razon_social_colaborador']);
			$this->importe = $row['importe'];
			$this->probabilidad_contratacion = array( 'id' => $row['probabilidad_contratacion'], 'nombre' => $row['nombre_probabilidad']);
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

	public function get_Leida(){
		return $this->leida;
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
	 * @return array $cliente indexado por id y razon social
	 */
	public function get_Cliente(){
		return $this->cliente;
	}
	
	public function get_Producto(){
		return $this->producto;
	}
	
	public function get_Proveedor(){
		return $this->proveedor;
	}
	
	public function get_Colaborador(){
		return $this->colaborador;
	}
	
	public function get_Importe(){
		return $this->importe;
	}
	
	public function get_Probabilidad_Contratacion(){
		return $this->probabilidad_contratacion;
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
		//FB::info($datos,'Oferta crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear una oferta nuevo:
		 * 		nombre
		 * 		estado_oferta
		 * 		cliente
		 * 		id_usuario
		 * 		fecha
		 *
		 */

		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['nombre_oferta'] == '' || ! isset($datos['nombre_oferta']))
			$errores .= "<br/>El nombre es obligatorio.";
		if($datos['es_oportunidad_de_negocio'] == '' || ! isset($datos['es_oportunidad_de_negocio']))
			$errores .= "<br/>Indicar si es oferta u oportunidad";
		if($datos['fecha'] == '' || ! isset($datos['fecha']))
			$errores .= "<br/>La fecha es obligatoria.";
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

		//cliente
		$query = "SELECT id, razon_social FROM clientes WHERE id=".$datos['cliente']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Empresa no v&aacute;lida.";

		$this->cliente = mysql_fetch_array($result);
		//estado
		$query = "SELECT id, nombre FROM ofertas_estados WHERE id=".$datos['estado_oferta']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Estado no v&aacute;lido.";

		$this->estado_oferta = mysql_fetch_array($result);

		//tipo de producto
		$query = "SELECT id, nombre FROM productos_tipos WHERE id=".$datos['producto']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Producto no v&aacute;lido.";

		$this->producto = mysql_fetch_array($result);

		//proveedor
		$query = "SELECT id, razon_social FROM proveedores WHERE id=".$datos['proveedor']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Proveedor no v&aacute;lido.";

		$this->proveedor = mysql_fetch_array($result);

		//probabilidad de contratación
		$query = "SELECT id, nombre FROM ofertas_probabilidades WHERE id=".$datos['probabilidad_contratacion']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Probabilidad de contrataci&oacute;n no v&aacute;lida.";

		$this->probabilidad_contratacion = mysql_fetch_array($result);

		// colaborador
		$query = "SELECT id, razon_social as nombre FROM colaboradores WHERE id=".$datos['colaborador']." LIMIT 1";
		if(!$result = mysql_query($query))
			$errores .= "<br/>Colaborador no v&aacute;lido.";

		$this->colaborador = mysql_fetch_array($result);
			
		if($errores != '') throw new Exception($errores);

		$this->nombre_oferta = mysql_real_escape_string(trim($datos['nombre_oferta']));
		$this->usuario = trim($datos['usuario']);
		$this->fecha = trim($datos['fecha']);
		$this->importe = trim($datos['importe']);
		$this->fecha_definicion=trim($datos['fecha_definicion']);
		$this->es_oportunidad_de_negocio=trim($datos['es_oportunidad_de_negocio']);
		$aceptado = 0;if($datos['estado_oferta'] == 2) $aceptado=1;
		$this->aceptado=$aceptado;
		
		//Si todo ha ido bien:
		return $this->guardar();
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * oferta, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una oferta.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar(){
		//FB::info($datos, 'datos al crear O');
		
		$query = "
			INSERT INTO ofertas (   nombre_oferta,
									fk_usuario,
									fk_estado_oferta,
									nombre_estado_oferta,
									fk_tipo_producto,
									nombre_tipo_producto,
									fk_proveedor,
									razon_social_proveedor,
									fk_cliente,
									razon_social_cliente,
									fk_colaborador,
									razon_social_colaborador,
									fecha,
									importe,
									probabilidad_contratacion,
									nombre_probabilidad,
									fecha_definicion,
									es_oportunidad_de_negocio,
									aceptado
								)VALUES(
									'".$this->nombre_oferta."',
									'".$this->usuario."',
									'".$this->estado_oferta['id']."',
										'".$this->estado_oferta['nombre']."',
									'".$this->producto['id']."',
										'".$this->producto['nombre']."',
									'".$this->proveedor['id']."',
										'".$this->proveedor['razon_social']."',
									'".$this->cliente['id']."',
										'".$this->cliente['razon_social']."',
									'".$this->colaborador['id']."',
										'".$this->colaborador['nombre']."',
									'".$this->fecha."',
									'".$this->importe."',
									'".$this->probabilidad_contratacion['id']."',
										'".$this->probabilidad_contratacion['nombre']."',
									'".$this->fecha_definicion."',
									'".$this->es_oportunidad_de_negocio."',
									'".$this->aceptado."'
									
								);
		";		
				
		//FB::info($query,'Oferta crear: QUERY');
		if(!mysql_query($query))
			throw new Exception("Error al crear la Oferta. ");
		$this->id = mysql_insert_id();

		$array_fecha = explode('/', date("d/m/Y",time()));
		$year = $array_fecha[2];

		$this->crear_Codigo($datos['es_oportunidad_de_negocio'],$year);

		return $this->id;
	}

	/**
	 * Método que devuelve el próximo código a establecer en el año
	 * @param <type> $es_oportunidad
	 * @param <type> $year
	 */
	private function crear_Codigo($es_oportunidad,$year){
		$opor = 0;
		if($es_oportunidad == 1)
			$opor = 1;
			//FB::info($es_oportunidad." ".$year);
		$query = "SELECT * FROM ofertas_codigos_patch WHERE de_oportunidad = '$opor' ORDER BY id DESC limit 1;";
		//FB::info($query);
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);
		//FB::warn($row);
		if($year != $row['year'])//si el a�o no es el mismo,empezamos desde numero 100
			$num = 100;
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

	public function set_Leida($leida){
		if(is_numeric($leida)){
			$query = "UPDATE ofertas SET leida='$leida' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la lectura en la BBDD.");
			$this->leida = $leida;

		}else
		throw new Exception("No se ha podido cambiar la lectura de la oferta/oportunidad.");
	}

	public function leer(){
		$this->set_Leida(1);
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
		
		if(is_numeric($id_cliente)){

			$query = "SELECT id, razon_social FROM clientes WHERE id='$id_cliente' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('La empresa es incorrecta');
			$row = mysql_fetch_array($result);

			$query = "UPDATE ofertas 
						SET fk_cliente='$id_cliente',
						razon_social_cliente='".$row['razon_social']."'
						WHERE id='$this->id' ";
			
			if(!mysql_query($query))
				throw new Exception("Error al actualizar la empresa en la BBDD.");

			$this->cliente = array('id' => $id_cliente, 'razon_social' => $row['razon_social']);

		}else
			throw new Exception("Debe introducir una empresa v&aacute;lida.");
	}

	/**
	 * Modifica el estado de la oferta
	 * @param int $id_estado nuevo estado
	 */
	public function set_Estado($id_estado){
		$this->comprobacion_Editar();
		
		if(is_numeric($id_estado)){

			$query = "SELECT id, nombre FROM ofertas_estados WHERE id='$id_estado' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('El estado es incorrecto');
			$row = mysql_fetch_array($result);

			$query = "UPDATE ofertas 
						SET fk_estado_oferta='$id_estado',
						nombre_estado_oferta = '".$row['nopmbre']."'
						WHERE id='$this->id' ";
			
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el estado en la BBDD.");

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
	}
	
	public function set_Producto($id_producto){
		$this->comprobacion_Editar();

		if(is_numeric($id_producto)){

			$query = "SELECT id, nombre FROM productos_tipos WHERE id='$id_producto' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('El tipo de producto es incorrecto');
			$row = mysql_fetch_array($result);

			$query = "UPDATE ofertas SET fk_tipo_producto='$id_producto', nombre_tipo_producto='".$row['nombre']."' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el producto en la BBDD.");

			$this->producto = array('id'=>$id_producto, 'nombre'=>$row['nombre']);

		}else
			throw new Exception("Debe introducir un producto v&aacute;lido.");
	}
	
	public function set_Proveedor($id_proveedor){
		$this->comprobacion_Editar();

		if($id_proveedor){

			$query = "SELECT id, razon_social FROM proveedores WHERE id='$id_proveedor' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('El proveedor es incorrecto');
			$row = mysql_fetch_array($result);
			
			$query = "UPDATE ofertas SET fk_proveedor='$id_proveedor', razon_social_proveedor='".$row['razon_social']."' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el proveedor en la BBDD.");

			$this->proveedor = array('id'=>$id_producto, 'razon_social'=>$row['razon_social']);

		}else
		throw new Exception("Debe introducir un proveedor v&aacute;lido.");
	}
	
	public function set_Colaborador($id_colaborador){
		$this->comprobacion_Editar();

		if(is_numeric($id_colaborador)){

			$query = "SELECT id, razon_social FROM colaboradores WHERE id='$id_colaborador' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('El colaborador es incorrecto');
			$row = mysql_fetch_array($result);

			$query = "UPDATE ofertas SET fk_colaborador='$id_colaborador', razon_social_colaborador='".$row['razon_social']."' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el colaborador en la BBDD.");

			$this->colaborador = array('id'=>$id_producto, 'nombre'=>$row['razon_social']);

		}else
			throw new Exception("Debe introducir un colaborador v&aacute;lido.");
	}
	public function set_Importe($nombre){
		$this->comprobacion_Editar();

		if((is_numeric($nombre))){
			$query = "UPDATE ofertas SET importe='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el importe en la BBDD.");
			$this->importe = $nombre;

		}else
		throw new Exception("Valor incorrecto de importe.");
	}
	public function set_Probabilidad_Contratacion($nombre){
		$this->comprobacion_Editar();

		if((is_numeric($nombre))){

			$query = "SELECT id, nombre FROM ofertas_probabilidades WHERE id='$nombre' LIMIT 1";
			if(!$result=  mysql_query($query))
				throw new Exception('La probabilidad es incorrecta');
			$row = mysql_fetch_array($result);


			$query = "UPDATE ofertas SET probabilidad_contratacion='$nombre', nombre_probabilidad='".$row['nombre']."' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la probabilidad en la BBDD.");
			$this->probabilidad_contratacion = $row;

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
