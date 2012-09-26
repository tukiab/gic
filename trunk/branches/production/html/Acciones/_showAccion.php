<?php
/**
 * Clase que gestiona las presentación de la información de una Accion.
 * 
 */
class ShowAccion{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
												
	/**
	 * Se obtienen los datos necesarios para mostrar el la interfaz, a partir de los parámetros pasados al 
	 * constructor.
	 * También realiza las funciones de modificación de datos necesarias..
	 * 
	 * @param array $opciones Array de opciones pasados al script. Se corresponde con el array $_GET de la vista.
	 */
	public function __construct($opciones){
		try{
			global $permisos;
					
			$this->get_Opciones($opciones);
			
			//Si no viene definido un id de Accion válido, salimos..
			if (!$this->opt['id'] || !is_numeric($this->opt['id']))
				exit('Error al cargar la Accion');
			
			$Accion = new Accion($this->opt['id']);
			//Hacemos visible al accion fuera de la clase:
			$this->opt['Accion'] = $Accion;
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
			//FB::error($e->getMessage());
		}
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		//FB::info($opciones, 'opciones _showAccion');
		//Indispensable, el id de la Accion:
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}
	
	
}
?>