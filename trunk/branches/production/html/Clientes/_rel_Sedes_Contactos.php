<?php include ('../appRoot.php');

class RelSedesContactos{
	/**
	 * Array que contendrá las opciones pasadas al constructor para que sean
	 * accesibles desde fuera de la clase.
	 *
	 * @var mixed
	 */
	public $opt = array();

	/**
	 * Instancia de la clase Cliente.
	 *
	 * @var object
	 */
	public $Cliente;

	public $Sede;

	public function __construct($opciones){
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);

		if($this->opt['guardar'])
			$this->guardar();
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 *
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		//Obteniendo las opciones pasadas
		@($opciones['id'])?$this->opt['id']=$opciones['id']:null;
		$this->Sede = new Sede($this->opt['id']);
		$this->Cliente = $this->Sede->get_Cliente();
		($opciones['ids_contactos'])?$this->opt['ids_contactos']=$opciones['ids_contactos']:null;
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;		
	}

	private function guardar(){

		//El objeto $cliente elevará excepciones ante errores en los datos
		try{
			$this->Sede->set_Contactos($this->opt['ids_contactos']);
			$this->msg = "Guardado";
		}catch(Exception $e){
			$this->msg= $e->getMessage();
		}
	}

}

?>