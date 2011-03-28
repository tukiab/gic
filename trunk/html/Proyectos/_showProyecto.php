<?php
/**
 * Clase que gestiona las presentación de la información de una Proyecto.
 * 
 */
class ShowProyecto{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
	public $usuario;
	public $Proyecto;
												
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
			$this->get_Datos();
			$this->usuario = new Usuario($_SESSION['usuario_login']);
			
			//Si no viene definido un id de Proyecto válido, salimos..
			if (!$this->opt['id'] || !is_numeric($this->opt['id']))
				exit('Error al cargar el Proyecto');
			
			$Proyecto = new Proyecto($this->opt['id']);
			//Hacemos visible al proyecto fuera de la clase:
			$this->Proyecto = $Proyecto;
			
			if($this->opt['eliminar']) $this->eliminar();
			if($this->opt['cerrar']) $this->cerrar();
			if($this->opt['asignar']) $this->asignar();
			
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	private function eliminar(){
		$this->Proyecto->del_Proyecto($this->opt['borrado_total']);
		header("Location: searchProyectos.php?msg=proyecto borrado");
	}

	private function cerrar(){
		$this->Proyecto->cerrar();
	}

	private function asignar(){
		$var->Proyecto->asignar($this->opt['id_usuario']);
	}
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		//FB::info($opciones, 'opciones _showProyecto');
		//Indispensable, el id de la Proyecto:
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;
		@($opciones['cerrar'])?$this->opt['cerrar']=true:$this->opt['cerrar']=false;
		@($opciones['asignar'])?$this->opt['asignar']=true:$this->opt['asignar']=false;
		@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;
		@($opciones['borrado_total'])?$this->opt['borrado_total']=true:$this->opt['borrado_total']=false;
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}

	private function get_Datos(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$this->datos['lista_tecnicos'] = $listaUsuarios->buscar();
	}
}
?>