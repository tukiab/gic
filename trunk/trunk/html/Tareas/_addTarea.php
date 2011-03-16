<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Tarea.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Tarea.
 */

class AddTarea{
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
	 * Instancia de la clase Tarea.
	 *
	 * @var object
	 */
	private $Tarea;
	
	/**
	 * Instancia de la clase de acceso a datos para las Tareas.
	 *
	 * @var object
	 */
	private $DB_Tarea;

	public $Proyecto;
	public $Usuario;
	public $Sede;

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
		//FB::info($opciones,'addTarea: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);

		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Tarea = new ListaTareas();
		$this->obtenerDatos();
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		FB::error($opciones);
		//Obteniendo las opciones pasadas
		
		@(isset($opciones['tipo']))?$this->opt['tipo']=$opciones['tipo']:$this->opt['tipo']=1;
		@(isset($opciones['fecha']))?$this->opt['fecha']=date2timestamp($opciones['fecha']):$this->opt['fecha']=fechaActualTimeStamp();
		@(isset($opciones['horas_desplazamiento']))?$this->opt['horas_desplazamiento']=$opciones['horas_desplazamiento']:null;
		@(isset($opciones['horas_visita']))?$this->opt['horas_visita']=$opciones['horas_visita']:null;
		@(isset($opciones['horas_auditoria_interna']))?$this->opt['horas_auditoria_interna']=$opciones['horas_auditoria_interna']:null;
		@(isset($opciones['horas_despacho']))?$this->opt['horas_despacho']=$opciones['horas_despacho']:null;
		
		@(isset($opciones['id_usuario']))?$this->opt['usuario']=$opciones['id_usuario']:$this->opt['usuario']=$_SESSION['usuario_login'];
		$this->Usuario = new Usuario($this->opt['usuario']);
		
		@(isset($opciones['id_proyecto']))?$this->opt['proyecto']=$opciones['id_proyecto']:null;
		$this->Proyecto = new Proyecto($this->opt['proyecto']);
		
		@(isset($opciones['id_sede']))?$this->opt['sede']=$opciones['id_sede']:null;
		$this->Proyecto = new Sede($this->opt['sede']);
		
		isset($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_tipos_tareas'] = $this->DB_Tarea->lista_Tipos();
	}
	
	/**
	 * Registra el nuevo Tarea en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showProyecto.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		$this->Proyecto->add_Tarea($this->opt);
		$this->opt['error_msg'] = "Operaci&oacute;n realizada con &eacute;xito";
		
	}
	
}

?>
