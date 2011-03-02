<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/include/validar.php");

class EditUsuario{

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
	 * Instancia de la clase Usuario.
	 *
	 * @var object
	 */
	public $Usuario;

	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaUsuarios;
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

		try{
			$this->Usuario = new Usuario($opciones['id']);
			$this->ListaUsuarios = new ListaUsuarios();
			
			$this->obtener_Datos();
			$this->obtener_Opciones($opciones);
			
			if($this->opt['guardar'])
				$this->guardar();
		}catch(Exception $e){
			$this->msg = $e->getMessage();
		}
	}

	private function obtener_Opciones($opciones){
		(isset($opciones['id']))?$this->opt['id'] = $opciones['id']:null;
		foreach($this->datos['lista_meses'] as $obj_mes)
			(isset($opciones['obj_'.$obj_mes['id']]))?$this->opt['obj_'.$obj_mes['id']]=$opciones['obj_'.$obj_mes['id']]:$this->opt['obj_'.$obj_mes['id']]=0;
		foreach($this->datos['lista_penalizaciones'] as $obj_mes)
			(isset($opciones['penalizacion_'.$obj_mes['id']]))?$this->opt['penalizacion_'.$obj_mes['id']]=$opciones['penalizacion_'.$obj_mes['id']]:$this->opt['penalizacion_'.$obj_mes['id']]=0;
		foreach($this->datos['lista_tipos_comision'] as $obj_mes)
			(isset($opciones['comision_'.$obj_mes['id']]))?$this->opt['comision_'.$obj_mes['id']]=$opciones['comision_'.$obj_mes['id']]:$this->opt['comision_'.$obj_mes['id']]=0;
	}

	private function obtener_Datos(){
		$this->datos['lista_meses'] = $this->ListaUsuarios->lista_Meses();
		$this->datos['lista_penalizaciones'] = $this->ListaUsuarios->lista_Penalizaciones();
		$this->datos['lista_tipos_comision'] = $this->ListaUsuarios->lista_Tipos_Comision();
	}

	private function guardar(){
		$objetivos = array();
		$penalizaciones = array();
		$comisiones = array();
		foreach($this->datos['lista_meses'] as $obj_mes)
			$objetivos[] = array('id' => $obj_mes['id'], 'comision' => $this->opt['obj_'.$obj_mes['id']]);
		foreach($this->datos['lista_penalizaciones'] as $obj_mes)
			$penalizaciones[] = array('id' => $obj_mes['id'], 'penalizacion' => $this->opt['penalizacion_'.$obj_mes['id']]);
		foreach($this->datos['lista_tipos_comision'] as $obj_mes)
			$comisiones[] = array('id' => $obj_mes['id'], 'comision' => $this->opt['comision_'.$obj_mes['id']]);

		$this->Usuario->set_Objetivos($objetivos);
		$this->Usuario->set_Penalizaciones($penalizaciones);
		$this->Usuario->set_Comisiones($comisiones);

		$this->msg = "Guardado";

	}
}

?>
