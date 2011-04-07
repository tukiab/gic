<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Cliente.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Cliente.
 */

class AddCliente{
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
	 * Instancia de la clase Cliente.
	 *
	 * @var object
	 */
	private $Cliente;
	
	private $Contacto;

	/**
	 * Instancia de la clase de acceso a datos para las Clientes.
	 *
	 * @var object
	 */
	private $DB_Cliente;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
		FB::info($opciones,'addCliente: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		
		if($this->opt['guardar'] || $this->opt['continuar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Cliente = new ListaClientes();
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
		@($opciones['sector'])?$this->opt['sector']=$opciones['sector']:null;
		@($opciones['web'])?$this->opt['web']=$opciones['web']:null;
		@($opciones['tipo_cliente'])?$this->opt['tipo_cliente']=$opciones['tipo_cliente']:null;			
		@($opciones['grupo_empresas'])?$this->opt['grupo_empresas']=$opciones['grupo_empresas']:null;
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['FAX'])?$this->opt['FAX']=$opciones['FAX']:null;
		@($opciones['provincia'])?$this->opt['provincia']=$opciones['provincia']:null;
		@($opciones['telefono'])?$this->opt['telefono']=$opciones['telefono']:null;
		
		@($opciones['CP'])?$this->opt['CP']=$opciones['CP']:null;
		@($opciones['numero_empleados'])?$this->opt['numero_empleados']=$opciones['numero_empleados']:null;
		@($opciones['fecha_renovacion'])?$this->opt['fecha_renovacion']=date2timestamp($opciones['fecha_renovacion']):null;
		@($opciones['SPA_actual'])?$this->opt['SPA_actual']=$opciones['SPA_actual']:null;
		@($opciones['norma_implantada'])?$this->opt['norma_implantada']=$opciones['norma_implantada']:null;
		@($opciones['creditos'])?$this->opt['creditos']=$opciones['creditos']:null;
		
		@($opciones['gestor'])?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		$this->opt['gestor_obj'] = new Usuario($this->opt['gestor']);
		//Opciones del contacto
		@($opciones['contacto_nombre'])?$this->opt['contacto_nombre']=$opciones['contacto_nombre']:null;
		@($opciones['contacto_telefono'])?$this->opt['contacto_telefono']=$opciones['contacto_telefono']:null;
		@($opciones['contacto_email'])?$this->opt['contacto_email']=$opciones['contacto_email']:null;
		@($opciones['contacto_cargo'])?$this->opt['contacto_cargo']=$opciones['contacto_cargo']:null;
		
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
		($opciones['continuar'])?$this->opt['continuar']=true:$this->opt['continuar']=false;
		
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_tipos_clientes'] = $this->DB_Cliente->lista_Tipos();
		$this->datos['lista_grupos_empresas'] = $this->DB_Cliente->lista_Grupos_Empresas();
	}
	
	/**
	 * Registra el nuevo Cliente en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showCliente.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $cliente elevará excepciones ante errores en los datos
		try{
			$this->Cliente = new Cliente();
			$id_cliente = $this->Cliente->crear($this->opt);
			if(is_numeric($id_cliente)){
				$this->opt['id_cliente'] = $id_cliente;
				
				//Si todo ha ido bien, Redirigimos a "showCliente.php":
				header("Location: showCliente.php?id=$id_cliente");
			}
			else{
				$this->opt['error_msg']= $id_cliente." <br/><br/>PULSE CONTINUAR PARA OBVIAR LAS COINCIDENCIAS Y GUARDAR EL CLIENTE";
				$this->opt['encontrado'] = true;
			}
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}

?>