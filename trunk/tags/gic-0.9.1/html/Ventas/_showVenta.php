<?php
/**
 * Clase que gestiona las presentación de la información de una Venta.
 * 
 */
class ShowVenta{
												
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
			
			//Si no viene definido un id de Venta válido, salimos..
			if (!$this->opt['id'] || !is_numeric($this->opt['id']))
				exit('Error al cargar la Venta');
			
			$Venta = new Venta($this->opt['id']);
			//Hacemos visible al venta fuera de la clase:
			$this->opt['Venta'] = $Venta;
			
			if($this->opt['eliminar']) $this->eliminar();
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
			
		}
	}
	
	private function eliminar(){
		$this->opt['Venta']->del_Venta();
		header("Location: searchVentas.php?msg=venta borrada");
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		//FB::info($opciones, 'opciones _showVenta');
		//Indispensable, el id de la Venta:
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}
}
?>
