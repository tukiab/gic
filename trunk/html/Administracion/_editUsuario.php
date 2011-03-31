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

		foreach($this->datos['lista_meses'] as $objetivo_mes)
			if(isset($opciones['objetivo_'.$objetivo_mes['id']]))
				$this->opt['objetivo_'.$objetivo_mes['id']]=$opciones['objetivo_'.$objetivo_mes['id']];
			else{
				$objetivo = $this->Usuario->get_Objetivo($objetivo_mes['id']);
				$this->opt['objetivo_'.$objetivo_mes['id']]=$objetivo['comision'];
			}

		foreach($this->datos['lista_penalizaciones'] as $penalizacion)
			if(isset($opciones['penalizacion_'.$penalizacion['id']]))
				$this->opt['penalizacion_'.$penalizacion['id']]=$opciones['penalizacion_'.$penalizacion['id']];
			else{
				$penalizacion = $this->Usuario->get_Penalizacion($penalizacion['id']);
				$this->opt['penalizacion_'.$penalizacion['id']]= $penalizacion['penalizacion'];
			}

		foreach($this->datos['lista_tipos_comision'] as $comision)
			if(isset($opciones['comision_'.$comision['id']]))
				$this->opt['comision_'.$comision['id']]=$opciones['comision_'.$comision['id']];
			else{
				$comision = $this->Usuario->get_Comision ($comision['id']);
				$this->opt['comision_'.$comision['id']]=$comision['comision'];
			}

		(isset($opciones['guardar']))?$this->opt['guardar']=$opciones['guardar']:null;
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
		foreach($this->datos['lista_meses'] as $objetivo_mes)
			$objetivos[] = array('id' => $objetivo_mes['id'], 'comision' => $this->opt['objetivo_'.$objetivo_mes['id']]);
		foreach($this->datos['lista_penalizaciones'] as $penalizacion)
			$penalizaciones[] = array('id' => $penalizacion['id'], 'penalizacion' => $this->opt['penalizacion_'.$penalizacion['id']]);
		foreach($this->datos['lista_tipos_comision'] as $comision)
			$comisiones[] = array('id' => $comision['id'], 'comision' => $this->opt['comision_'.$comision['id']]);

		$this->Usuario->set_Objetivos($objetivos);
		$this->Usuario->set_Penalizaciones($penalizaciones);
		$this->Usuario->set_Comisiones($comisiones);

		$this->msg = "Guardado";

	}
}

?>
