<?php
/**
 * Clase que gestiona las presentación de la información de una Oferta.
 * 
 */
class ShowOferta{
												
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
			
			//Si no viene definido un id de Oferta válido, salimos..
			if (!$this->opt['id'] || !is_numeric($this->opt['id']))
				exit('Error al cargar la Oferta');
			
			$Oferta = new Oferta($this->opt['id']);
			//Hacemos visible al oferta fuera de la clase:
			$this->opt['Oferta'] = $Oferta;
			
			if($this->opt['eliminar']) $this->eliminar();
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
			
		}
	}
	
	private function eliminar(){
		$this->opt['Oferta']->del_Oferta();
		header("Location: searchOfertas.php?msg=oferta borrada");
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		//FB::info($opciones, 'opciones _showOferta');
		//Indispensable, el id de la Oferta:
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}
	
	
}
?>