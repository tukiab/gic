<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Factura.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Factura.
 */

class AddFactura{
	/**
	 * Array que contendrá las opciones pasadas al constructor para que sean
	 * accesibles desde fuera de la clase.
	 *
	 * @var mixed
	 */
	public $opt = array();

	/**
	 * Array que contendrá los datos de la BBDD necesarios para mostrar opciones
	 * en la interfaz.
	 *
	 * @var mixed
	 */
	public $datos = array();

	/**
	 * Instancia de la clase Factura.
	 *
	 * @var object
	 */
	private $Factura;
	
	/**
	 * Instancia de la clase de acceso a datos para las Facturas.
	 *
	 * @var object
	 */
	private $DB_Factura;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
	
	try{
		//FB::info($opciones,'addFactura: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		if(!$this->opt['id_venta']) throw new Exception("No se ha definido un id de venta v&aacute;lido");
		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Factura = new ListaFacturas();
		$this->obtenerDatos();
	}catch(Exception $e){
		$this->opt['error_msg'] = $e->getMessage();
	}
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		//FB::error($opciones,'opciones pasadas');
		//Obteniendo las opciones pasadas
		@(isset($opciones['id_venta']))?$this->opt['id_venta']=$opciones['id_venta']:null;
                    $this->opt['Venta'] = new Venta($this->opt['id_venta']);

		@(isset($opciones['base_imponible']))?$this->opt['base_imponible']=$opciones['base_imponible']:$this->opt['base_imponible']=$this->opt['Venta']->get_Importe();
		@(isset($opciones['IVA']))?$this->opt['IVA']=$opciones['IVA']:null;			
		@(isset($opciones['estado_factura']))?$this->opt['estado_factura']=$opciones['estado_factura']:null;
		@(isset($opciones['formacion_bonificada']))?$this->opt['formacion_bonificada']=$opciones['formacion_bonificada']:null;
		@(isset($opciones['cantidad_pagada']))?$this->opt['cantidad_pagada']=$opciones['cantidad_pagada']:null;
		@(isset($opciones['fecha_pago']))?$this->opt['fecha_pago']=date2timestamp($opciones['fecha_pago']):$this->opt['fecha_pago']=fechaActualTimeStamp();
		@(isset($opciones['fecha_facturacion']))?$this->opt['fecha_facturacion']=date2timestamp($opciones['fecha_facturacion']):null;
		
		@(isset($opciones['usuario']))?$this->opt['usuario']=$opciones['usuario']:$this->opt['usuario']=$_SESSION['usuario_login'];
		$this->opt['usuario_obj'] = new Usuario($this->opt['usuario']);
		
		
		isset($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_estados_facturas'] = $this->DB_Factura->lista_Estados();
	}
	
	/**
	 * Registra el nuevo Factura en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showCliente.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $Factura elevará excepciones ante errores en los datos
		try{
			$factura = new Factura();
			$id=$factura->crear($this->opt);
			header("Location: showFactura.php?id=$id");
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}
?>