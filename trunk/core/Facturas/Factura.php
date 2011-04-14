<?php
/**
 * Clase que gestiona las Facturas.
 */
include_once('../../html/Common/php/utils/utils.php');
class Factura{

	/**
	 * Identificador de la Factura. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;
	

	/**
	 * Estado de la Factura
	 * @var array indexado por id y numero_factura
	 */
	private $estado_factura;

	/**
	 * usuario que realiza la factura.
	 * @var string con el id del usuario
	 */
	private $usuario;

	/**
	 * venta asociado a la factura.
	 * @var integer id del venta
	 */
	private $venta;
	
	
	/**
	 * base_imponible asociado a la factura.
	 * @var integer id del base_imponible
	 */
	private $base_imponible;
	
	/**
	 * IVA asociado a la factura.
	 * @var integer id del IVA
	 */
	private $IVA;
	
	/**
	 * fecha_facturacion en formato timestamp.
	 * @var integer
	 */
	private $fecha_facturacion;

	/**
	 * fecha_facturacion de definicion en formato timestamp.
	 * @var integer
	 */
	private $fecha_pago;

	/**
	 * numero_factura de la factura.
	 * @var string
	 */
	private $numero_factura;

	/**
	 * cantidad_pagada de la factura
	 * @var integer
	 */
	private $cantidad_pagada;
	
	
	/**
	 * Año en que se genera la factura
	 * @var bool
	 */
	private $year;
	
	private $cliente;
	
	

	/*
	 * MÃ©todos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Factura.
	 *
	 * Si recibe un identificador vÃ¡lido, se carga la Factura de la BBDD mediante el mÃ©todo cargar(), en caso contrario crea un objeto
	 * vacÃ­o, permitiendo insertar una Factura nuevo mediante el mÃ©todo crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_factura Id de la Factura. Cuando estÃ¡ definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Factura en la BBDD.
	 *
	 * Este mÃ©todo es invocado cuando se le pasa un id de Factura vÃ¡lido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT facturas.*,
							 facturas_estados.id AS id_estado, facturas_estados.nombre AS nombre_estado
						FROM facturas
				    		INNER JOIN facturas_estados
								ON facturas.fk_estado_factura = facturas_estados.id
						WHERE facturas.id = '$this->id'";
			//FB::info($query,'Factura->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Factura de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Factura en la BBDD");

			$row = mysql_fetch_array($result);

			$this->numero = $row['numero'];
			$this->fecha_pago = $row['fecha_pago'];
			$this->fecha_facturacion = $row['fecha_facturacion'];
			$this->numero_factura = $row['numero_factura'];
			$this->estado_factura = array('id'=>$row['id_estado'], 'nombre'=>$row['nombre_estado']);
			$this->venta = $row['fk_venta'];
			$this->base_imponible = $row['base_imponible'];
			$this->IVA = $row['IVA'];
			$this->cantidad_pagada = $row['cantidad_pagada'];
			$this->year = $row['year'];
			
			$venta = new Venta($this->venta);
			$usuario = $venta->get_Oferta()->get_Usuario();
			$this->usuario = $usuario;
			
			$this->cliente = $row['fk_cliente'];

		}
	}

	/*
	 * MÃ©todos observadores.
	 ***********************/

	public function get_Usuario(){
		return $this->usuario;
	}
	/**
	 * Devuelve la fecha_facturacion 
	 * @return int $fecha_facturacion
	 */
	public function get_Fecha_Facturacion(){
		return $this->fecha_facturacion;
	}

	/**
	 * Devuelve la fecha_facturacion de definicion
	 * @return int $fecha_facturacion
	 */
	public function get_Fecha_Pago(){
		return $this->fecha_pago;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la numero_factura
	 * @return string $numero_factura
	 */
	public function get_Numero_Factura(){
		return $this->numero_factura;
	}
	
	/**
	 * Devuelve el numero
	 * @return string $numero
	 */
	public function get_Numero(){
		return $this->numero;
	}


	/**
	 * Devuelve el estado de factura
	 * @return array $estado_factura indexado por id y numero_factura
	 */
	public function get_Estado_Factura(){
		return $this->estado_factura;
	}

	/**
	 * Devuelve el venta
	 * @return venta $venta 
	 */
	public function get_Venta(){
		return new venta($this->venta);
	}
	
	public function get_Base_Imponible(){
		return $this->base_imponible;
	}
	
	public function get_IVA(){
		return $this->IVA;
	}
	
	public function get_Cantidad_Pagada(){
		return $this->cantidad_pagada;
	}
	
	public function get_Year(){
		return $this->year;
	}

	public function get_Cliente(){
		return new Cliente($this->cliente);
	}
	
	public function get_Total(){
		return $this->base_imponible + $this->base_imponible * $this->IVA / 100;
	}
	/*
	 * MÃ©todos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Factura en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al mÃ©todo privado guardar(), que devolverÃ¡ el id asignado por el gestor de BBDD,
	 * que a su vez serÃ¡ el devuelto por Ã©ste mÃ©todo.
	 * El array pasado debe ser un array indexado con los numero_facturas de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Factura.
	 * @return integer $id_factura Id del nuevo Factura.
	 */
	public function crear($datos){
		FB::info($datos,'Factura crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear una factura nuevo:
		 * 		numero_factura
		 * 		estado_factura
		 * 		venta
		 * 		id_usuario
		 * 		fecha_facturacion
		 *
		 */
		$validar = new Validador();
		
		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['fecha_facturacion'] == '' || ! isset($datos['fecha_facturacion']))
			$errores .= "<br/>La fecha_facturacion es obligatoria.";
		if($datos['id_venta'] == '' || ! isset($datos['id_venta']))
			$errores .= "<br/>La venta es obligatoria.";			
		if($datos['cantidad_pagada'] == '' || ! isset($datos['cantidad_pagada']))
			$datos['cantidad_pagada'] = 0;
		if($datos['fecha_pago'] == '' || ! isset($datos['fecha_pago']))
			$errores .= "<br/>La fecha de pago es obligatoria.";
		else if(!is_numeric($datos['fecha_pago']))
			$errores .= "<br/>valor incorrecto de fecha de pago.";
			
		if($datos['base_imponible'] == '' || ! isset($datos['base_imponible']))
			$errores .= "<br/>La base imponible es obligatoria.";			
		if($datos['IVA'] == '' || ! isset($datos['IVA']))
			$errores .= "<br/>El IVA es obligatorio.";
		if($errores != '') throw new Exception($errores);
		
		
		//Si todo ha ido bien:		
		$this->fecha_facturacion = trim($datos['fecha_facturacion']);
		$this->venta = trim($datos['id_venta']);
		$this->estado_factura = trim($datos['estado_factura']);
		$this->base_imponible = trim($datos['base_imponible']);
		$this->IVA = trim($datos['IVA']);
		$this->fecha_pago = trim($datos['fecha_pago']);
		$this->cantidad_pagada = trim($datos['cantidad_pagada']);
		
		$this->crear_numero_factura();
		
			$venta = new Venta($this->venta);
			$cliente = $venta->get_Cliente();
		$this->cliente = $cliente->get_Id();
		
		return $this->guardar($datos);
	}

	/**
	 * MÃ©todo privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * factura, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por numero_factura con los datos de una factura.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){

		$query = "
			INSERT INTO facturas (  fecha_facturacion, fk_venta, fk_cliente, fk_estado_factura, base_imponible, IVA, fecha_pago, cantidad_pagada, numero, year, numero_factura
						)VALUES(
						'".$this->fecha_facturacion."',
						'".$this->venta."',
						'".$this->cliente."',						
						'".$this->estado_factura."',
						'".$this->base_imponible."',
						'".$this->IVA."',
						'".$this->fecha_pago."',
						'".$this->cantidad_pagada."',
						'".$this->numero."',
						'".$this->year."',
						'".$this->numero_factura."'								
					);
		";
			FB::info($query,'Factura crear: QUERY');
			if(!mysql_query($query))
				throw new Exception("Error al crear la Factura. ");
			$this->id = mysql_insert_id();
							
			return $this->id;
	}
	private function crear_numero_factura(){
		
		$query = "SELECT year, numero FROM facturas order by id desc limit 1;";
		$rs = mysql_query($query);
		
		$row = mysql_fetch_array($rs);
		
		$year = $row['year'];
		$numero = $row['numero'];
		
		$year_actual = date("Y");		
		
		if($year == $year_actual)
			$this->numero = $numero+1;
		else
			$this->numero = 1;
		
		$this->year = $year_actual;
		$this->numero_factura = $this->year."/".$this->numero;
	}

	/**
	 * Modifica la fecha_facturacion  de la factura
	 * @param int $fecha_facturacion nueva fecha_facturacion 
	 */
	public function set_Fecha_Facturacion($fecha_facturacion){
		if(is_numeric($fecha_facturacion)){
			$query = "UPDATE facturas SET fecha_facturacion='".trim($fecha_facturacion)."' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de facturacion en la BBDD.");
			$this->fecha_facturacion = trim($fecha_facturacion);

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	public function set_Fecha_Pago($fecha_pago){
		if(is_numeric($fecha_pago)){
			$query = "UPDATE facturas SET fecha_pago='".trim($fecha_pago)."' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de pago en la BBDD.");
			$this->fecha_pago = trim($fecha_pago);

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica el venta de la factura
	 * @param int $id_venta nuevo venta
	 */
	public function set_Venta($id_venta){
		
		if(is_numeric($id_venta)){
			$query = "UPDATE facturas SET fk_venta='$id_venta' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la venta en la BBDD.");

			$this->venta = $id_venta;

		}else
		throw new Exception("Debe introducir una venta v&aacute;lida.");
	}

	/**
	 * Modifica el estado de la factura
	 * @param int $id_estado nuevo estado
	 */
	public function set_Estado($id_estado){		
		
		if(is_numeric($id_estado)){
		$query = "UPDATE facturas SET fk_estado_factura='$id_estado' WHERE id='$this->id' ";
		if(!mysql_query($query))
			throw new Exception("Error al actualizar el estado en la BBDD.");

			$query = "SELECT id, nombre FROM facturas_estados WHERE id= '$id_estado' limit 1;";
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);

			$this->estado_factura = array('id'=>$row['id'], 'nombre'=>$row['nombre']);
		}else
		throw new Exception("Debe introducir un estado v&aacute;lido.");
	}
	
	public function set_Base_Imponible($id_base_imponible){
		if(is_numeric($id_base_imponible)){
			$query = "UPDATE facturas SET base_imponible='$id_base_imponible' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error al actualizar el base_imponible en la BBDD.");

				$this->base_imponible = $id_base_imponible;

		}else
		throw new Exception("Debe introducir una base imponible v&aacute;lida.");
	}
	
	public function set_IVA($id_IVA){
		if(is_numeric($id_IVA)){
			$query = "UPDATE facturas SET IVA='$id_IVA' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el IVA en la BBDD.");

			$this->IVA = $id_IVA;

		}else
		throw new Exception("Debe introducir un IVA v&aacute;lido.");
	}
	
	public function set_Cantidad_Pagada($cantidad){	
FB::info($cantidad);
		$validar = new Validador();
		if((is_numeric($cantidad))){
			$query = "UPDATE facturas SET cantidad_pagada='$cantidad' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la cantidad pagada en la BBDD.");
			$this->cantidad_pagada = $cantidad;

		}else
		throw new Exception("Debe introducir una cantidad v&aacute;lida.");
	}
	
	public function del_Factura(){
		$query = "DELETE FROM facturas WHERE id='$this->id';";
		mysql_query($query);
	}
	
}
?>
