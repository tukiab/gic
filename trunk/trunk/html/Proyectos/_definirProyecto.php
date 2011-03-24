<?php
include ('../appRoot.php');


class DefinirProyecto{
	
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
	public $Proyecto;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	public $ListaProyectos;
	public $gestor;	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	
	public function __construct($opciones){
		//Debugging..
		try{
			$this->gestor = new Usuario($_SESSION['usuario_login']);
			
			$this->obtenerOpciones($opciones);
			$this->obtenerDatos();

			if($this->opt['id_plantilla'])
				$this->cargar_plantilla();
			else if($opciones['guardar'])
				$this->definir_Proyecto($opciones);			

		}catch(Exception $e){
			$this->msg= $e->getMessage();
		}
	}
		
	private function obtenerOpciones($opciones){
		$this->opt = array();
		($opciones['id'])?$this->opt['id'] = $opciones['id']:null;
		$this->Proyecto = new Proyecto($this->opt['id']);

		($opciones['nombre'])?$this->opt['nombre'] = $opciones['nombre']:$this->opt['nombre'] = $this->Proyecto->get_Nombre();
		($opciones['horas_documentacion'])?$this->opt['horas_documentacion'] = $opciones['horas_documentacion']:null;
		($opciones['horas_auditoria_interna'])?$this->opt['horas_auditoria_interna'] = $opciones['horas_auditoria_interna']:null;
		($opciones['es_plantilla'])?$this->opt['es_plantilla'] = $opciones['es_plantilla']:null;

		($opciones['fecha_inicio'])?$this->opt['fecha_inicio'] = date2timestamp($opciones['fecha_inicio']):$this->opt['fecha_inicio'] = $this->Proyecto->get_Fecha_Inicio();
		($opciones['fecha_fin'])?$this->opt['fecha_fin'] = date2timestamp($opciones['fecha_fin']):$this->opt['fecha_fin'] = $this->Proyecto->get_Fecha_Fin();

		($opciones['id_plantilla'])?$this->opt['id_plantilla'] = $opciones['id_plantilla']:null;

	}
	
	private function definir_Proyecto(){

		$this->msg = "Proyecto definido";						
	}
	
	private function obtenerDatos(){
		$this->ListaProyectos = new ListaProyectos();
		$filtros['es_plantilla'] = 1;

		$this->ListaProyectos->buscar($filtros);
	}

	private function cargar_Plantilla(){
		$proyecto = new Proyecto($this->opt['id_plantilla']);

		$seguir = true;
		while($seguir){

		}
	}
}
?>
