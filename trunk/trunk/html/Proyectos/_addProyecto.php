<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Proyecto.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Proyecto.
 */

class AddProyecto{
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
	 * Instancia de la clase Proyecto.
	 *
	 * @var object
	 */
	private $Proyecto;
	
	public $msg;

	/**
	 * Instancia de la clase de acceso a datos para las Proyectos.
	 *
	 * @var object
	 */
	private $DB_Proyecto;
	
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
			//Obtenemos las opciones pasadas al script
			$this->obtenerOpciones($opciones);

			//Adquiriendo datos...
			$this->DB_Proyecto = new ListaProyectos();
			$this->obtenerDatos();

			if($this->opt['guardar'])
				$this->guardar();

		}catch(Exception $e){
			$this->msg= $e->getMessage();
		}
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		
		//Obteniendo las opciones pasadas
		@($opciones['nombre'])?$this->opt['nombre']=$opciones['nombre']:null;
		@($opciones['id_cliente'])?$this->opt['id_cliente']=$opciones['id_cliente']:null;
		@($opciones['fecha_inicio'])?$this->opt['fecha_inicio']=date2timestamp($opciones['fecha_inicio']):null;
		@($opciones['fecha_fin'])?$this->opt['fecha_fin']=date2timestamp($opciones['fecha_fin']):null;
		@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;
				
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_tecnicos'] = $listaUsuarios;
	}
	
	/**
	 * Registra el nuevo Proyecto en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showProyecto.php. En caso
	 * contrario almacena el mensaje de error en $msg para ser mostrado en la interfaz.
	 */
	private function guardar(){		
		$this->Proyecto = new Proyecto();
		$id_proyecto = $this->Proyecto->crear($this->opt);
		//Si todo ha ido bien, Redirigimos a "showProyecto.php":
		header("Location: showProyecto.php?id=$id_proyecto");
	}
	
}

?>