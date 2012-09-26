<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Accion.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Accion.
 */

class AddAccion{
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
	 * Instancia de la clase Accion.
	 *
	 * @var object
	 */
	private $Accion;
	
	/**
	 * Instancia de la clase de acceso a datos para las Acciones.
	 *
	 * @var object
	 */
	private $DB_Accion;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
		//FB::info($opciones,'addAccion: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		
		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Accion = new ListaAcciones();
		$this->obtenerDatos();
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		
		//Obteniendo las opciones pasadas
		
		@($opciones['descripcion'])?$this->opt['descripcion']=$opciones['descripcion']:$this->opt['descripcion']=utf8_encode(" - Acci�n realizada:



- Siguiente acci�n a realizar:

");
		@($opciones['tipo_accion'])?$this->opt['tipo_accion']=$opciones['tipo_accion']:null;			
		@($opciones['fecha'])?$this->opt['fecha']=date2timestamp($opciones['fecha']):$this->opt['fecha']=fechaActualTimeStamp();
		@($opciones['fecha_siguiente_accion'])?$this->opt['fecha_siguiente_accion']=date2timestamp($opciones['fecha_siguiente_accion']):null;
		
		@($opciones['usuario'])?$this->opt['usuario']=$opciones['usuario']:$this->opt['usuario']=$_SESSION['usuario_login'];
		$this->opt['usuario_obj'] = new Usuario($this->opt['usuario']);
		
		@($opciones['id_cliente'])?$this->opt['cliente']=$opciones['id_cliente']:null;
		$this->opt['cliente_obj'] = new Cliente($this->opt['cliente']);
		
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_tipos_acciones'] = $this->DB_Accion->lista_Tipos();
	}
	
	/**
	 * Registra el nuevo Accion en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showCliente.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $accion elevará excepciones ante errores en los datos
		try{
			$this->opt['cliente_obj']->add_Accion($this->opt);
			$this->opt['error_msg'] = "Acci&oacute;n creada con &eacute;xito";
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}

?>
