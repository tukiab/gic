<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Oferta.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Oferta.
 */

class AddOferta{
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
	 * Instancia de la clase Oferta.
	 *
	 * @var object
	 */
	private $Oferta;
	
	/**
	 * Instancia de la clase de acceso a datos para las Ofertas.
	 *
	 * @var object
	 */
	private $DB_Oferta;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
		////FB::info($opciones,'addOferta: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		
		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Oferta = new ListaOfertas();
		$this->obtenerDatos();
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		//FB::error($opciones);
		//Obteniendo las opciones pasadas
		
		@(isset($opciones['nombre_oferta']))?$this->opt['nombre_oferta']=$opciones['nombre_oferta']:null;
		@(isset($opciones['estado_oferta']))?$this->opt['estado_oferta']=$opciones['estado_oferta']:null;			
		@(isset($opciones['producto']))?$this->opt['producto']=$opciones['producto']:null;
		@(isset($opciones['proveedor']))?$this->opt['proveedor']=$opciones['proveedor']:null;
		@(isset($opciones['importe']))?$this->opt['importe']=$opciones['importe']:null;
		@(isset($opciones['probabilidad_contratacion']))?$this->opt['probabilidad_contratacion']=$opciones['probabilidad_contratacion']:null;
		@(isset($opciones['colaborador']))?$this->opt['colaborador']=$opciones['colaborador']:null;
		@(isset($opciones['es_oportunidad']))?$this->opt['es_oportunidad_de_negocio']=$opciones['es_oportunidad']:$this->opt['es_oportunidad_de_negocio']=0;
		@(isset($opciones['fecha']))?$this->opt['fecha']=date2timestamp($opciones['fecha']):$this->opt['fecha']=fechaActualTimeStamp();
		@(isset($opciones['fecha_definicion']))?$this->opt['fecha_definicion']=date2timestamp($opciones['fecha_definicion']):null;
		@(isset($opciones['aceptado']))?$this->opt['aceptado']=1:$this->opt['aceptado']=0;
		
		@(isset($opciones['usuario']))?$this->opt['usuario']=$opciones['usuario']:$this->opt['usuario']=$_SESSION['usuario_login'];
		$this->opt['usuario_obj'] = new Usuario($this->opt['usuario']);
		
		@(isset($opciones['id_cliente']))?$this->opt['cliente']=$opciones['id_cliente']:null;
		$this->opt['cliente_obj'] = new Cliente($this->opt['cliente']);
		
		
		
		isset($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_estados_ofertas'] = $this->DB_Oferta->lista_Estados();
		$this->datos['lista_tipos_productos'] = $this->DB_Oferta->lista_Tipos_Productos();
		$this->datos['lista_probabilidades'] = $this->DB_Oferta->lista_Probabilidades();
		$this->datos['lista_colaboradores'] = $this->DB_Oferta->lista_Colaboradores();
		$this->datos['lista_proveedores'] = $this->DB_Oferta->lista_Proveedores();
	}
	
	/**
	 * Registra el nuevo Oferta en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showCliente.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $Oferta elevará excepciones ante errores en los datos
		try{
			$this->opt['cliente_obj']->add_Oferta($this->opt);
			$this->opt['error_msg'] = "Operaci&oacute;n realizada con &eacute;xito";
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}

?>
