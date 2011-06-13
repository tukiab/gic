<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Proveedor.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Proveedor.
 */

class AddProveedor{
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
	 * Instancia de la clase Proveedor.
	 *
	 * @var object
	 */
	private $Proveedor;
	
	private $Contacto;

	/**
	 * Instancia de la clase de acceso a datos para las Proveedores.
	 *
	 * @var object
	 */
	private $DB_Proveedor;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
		////FB::info($opciones,'addProveedor: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		
		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Proveedor = new ListaProveedores();
		$this->obtenerDatos();
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		
		//Obteniendo las opciones pasadas
		@($opciones['razon_social'])?$this->opt['razon_social']=$opciones['razon_social']:null;	
		
		@($opciones['web'])?$this->opt['web']=$opciones['web']:null;
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['provincia'])?$this->opt['provincia']=$opciones['provincia']:null;
		@($opciones['CP'])?$this->opt['CP']=$opciones['CP']:null;
		
		@($opciones['gestor'])?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		$this->opt['gestor_obj'] = new Usuario($this->opt['gestor']);
		//Opciones del contacto
		@($opciones['contacto_nombre'])?$this->opt['contacto_nombre']=$opciones['contacto_nombre']:null;
		@($opciones['contacto_telefono'])?$this->opt['contacto_telefono']=$opciones['contacto_telefono']:null;
		@($opciones['contacto_email'])?$this->opt['contacto_email']=$opciones['contacto_email']:null;
		@($opciones['contacto_cargo'])?$this->opt['contacto_cargo']=$opciones['contacto_cargo']:null;
		
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
		($opciones['continuar'])?$this->opt['continuar']=$opciones['continuar']:null;
		
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		
	}
	
	/**
	 * Registra el nuevo Proveedor en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showProveedor.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $proveedor elevará excepciones ante errores en los datos
		try{
			$this->Proveedor = new Proveedor();
			$NIF_proveedor = $this->Proveedor->crear($this->opt);
			if($NIF_proveedor){
				$this->opt['NIF_proveedor'] = $NIF_proveedor;
				
				//Si todo ha ido bien, Redirigimos a "showProveedor.php":
				header("Location: showProveedor.php?NIF=$NIF_proveedor");
			}
			else{
				$this->opt['error_msg']="Se han encontrado coincidencias con este contacto. Pulse continuar para seguir con la operaci&oacute;n";
				$this->opt['encontrado'] = true;
			}
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}

?>