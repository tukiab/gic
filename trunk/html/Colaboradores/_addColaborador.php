<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Colaborador.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Colaborador.
 */

class AddColaborador{
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
	 * Instancia de la clase Colaborador.
	 *
	 * @var object
	 */
	private $Colaborador;
	
	private $Contacto;

	/**
	 * Instancia de la clase de acceso a datos para las Colaboradores.
	 *
	 * @var object
	 */
	private $DB_Colaborador;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
		FB::info($opciones,'addColaborador: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		
		if($this->opt['guardar'] || $this->opt['continuar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Colaborador = new ListaColaboradores();
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
		@($opciones['comision'])?$this->opt['comision']=$opciones['comision']:null;
		@($opciones['comision_por_renovacion'])?$this->opt['comision_por_renovacion']=$opciones['comision_por_renovacion']:null;
		
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['cc_pago_comisiones'])?$this->opt['cc_pago_comisiones']=$opciones['cc_pago_comisiones']:null;
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
		($opciones['continuar'])?$this->opt['continuar']=true:$this->opt['continuar']=false;
		
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		
	}
	
	/**
	 * Registra el nuevo Colaborador en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showColaborador.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $colaborador elevará excepciones ante errores en los datos
		try{
			$this->Colaborador = new Colaborador();
			$id_colaborador = $this->Colaborador->crear($this->opt);
			if(is_numeric($id_colaborador)){
				$this->opt['id_colaborador'] = $id_colaborador;
				
				//Si todo ha ido bien, Redirigimos a "showColaborador.php":
				header("Location: searchColaboradores.php");
				//$this->opt['error_msg'] = "Guardado";
			}
			else{
				$this->opt['error_msg']= $id_colaborador." <br/><br/>PULSE CONTINUAR PARA OBVIAR LAS COINCIDENCIAS Y GUARDAR EL CLIENTE";
				$this->opt['encontrado'] = true;
			}
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}
	
}

?>
