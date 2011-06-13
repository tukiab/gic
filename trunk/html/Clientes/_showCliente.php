<?php
/**
 * Clase que gestiona las presentación de la información de una Cliente.
 * 
 */
class ShowCliente{
												
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
			
			//Si no viene definido un id de Cliente válido, salimos..
			if (!$this->opt['id'] || !is_numeric($this->opt['id']))
				exit('Error al cargar el Cliente');
			
			$Cliente = new Cliente($this->opt['id']);
			//Hacemos visible al cliente fuera de la clase:
			$this->opt['Cliente'] = $Cliente;
			
			if($this->opt['eliminar']) $this->eliminar();
			if($this->opt['eliminarGestor']) $this->eliminarGestor();
			if($this->opt['eliminarAccion']) $this->eliminarAccion();
			
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	private function eliminar(){
		$this->opt['Cliente']->del_Cliente($this->opt['borrado_total']);
		header("Location: searchClientes.php?msg=cliente borrado");
	}
	private function eliminarGestor(){
		$this->opt['Cliente']->del_Gestor($this->opt['eliminarGestor']);
	}
	private function eliminarAccion(){
		$this->opt['Cliente']->del_Accion($this->opt['eliminarAccion']);
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		////FB::info($opciones, 'opciones _showCliente');
		//Indispensable, el id de la Cliente:
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		@($opciones['borrado_total'])?$this->opt['borrado_total']=true:$this->opt['borrado_total']=false;
		@($opciones['eliminarGestor'])?$this->opt['eliminarGestor']=$opciones['eliminarGestor']:$this->opt['eliminarGestor']=false;
		@($opciones['eliminarAccion'])?$this->opt['eliminarAccion']=$opciones['eliminarAccion']:$this->opt['eliminarAccion']=false;
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}
	
	
}
?>