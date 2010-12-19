<?php
/**
 * Clase que gestiona las presentación de la información de una Proveedor.
 * 
 */
class ShowProveedor{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
	public $usuario;
												
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
			
			$this->usuario = new Usuario($_SESSION['usuario_login']);
			
			//Si no viene definido un id de Proveedor válido, salimos..
			if (!$this->opt['NIF'])
				exit('Error al cargar el Proveedor');
			
			$Proveedor = new Proveedor($this->opt['NIF']);
			//Hacemos visible al proveedor fuera de la clase:
			$this->opt['Proveedor'] = $Proveedor;
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
			FB::error($e->getMessage());
		}
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		//FB::info($opciones, 'opciones _showProveedor');
		//Indispensable, el id de la Proveedor:
		@(isset($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null);
		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}
	
	
}
?>
