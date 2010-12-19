<?php	include ('../appRoot.php');

	
//Definiendo la clase
class GestionGrupos{
	
	//Listado de datos a mostrar
		public $opt;		
		public $datos;
		private $DB_grupos;
	
	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionGrupos($opciones){

		try{
			$usuario = new Usuario($_SESSION['usuario_login']);
			$perfil = $usuario->get_Perfil();
			$this->opt['esAdministrador'] = esAdministrador($perfil['id']);

			//Inicializando el acceso a datos
			$this->DB_grupos = new ListaGruposEmpresas();
			
			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);		
		
			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de grupos para tenerlos todos actualizados en la interfaz		
			$this->obtenerDatos();
		}
		catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}
	
	private function obtenerDatos(){
	 	$this->DB_grupos->buscar();
	 	$this->datos['lista_grupos'] = array();
		while($grupo = $this->DB_grupos->siguiente())
                    if($grupo->get_Id() != 1)
			$this->datos['lista_grupos'][] = $grupo;
	}
	private function obtenerOpciones($opciones){
FB::info($opciones);
		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_grupo']))?$this->opt['id_grupo']=$opciones['id_grupo']:null;
	
		//Datos de los grupos
		foreach($this->datos['lista_grupos'] as $grupo){
			(isset($opciones['nombre_'.$grupo->get_Id()]))?$this->opt['nombre_'.$grupo->get_Id()]=$opciones['nombre_'.$grupo->get_Id()]:null;
		}

		(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;		
		
	}	

	/**
	 * Guardar:
 	 */
	private function guardar(){
		FB::info('guardando');
		$id = $this->opt['id_grupo'];
		$grupo = new GrupoEmpresas($id);
		$grupo->set_Nombre($this->opt['nombre_'.$id]);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		$grupo = new GrupoEmpresas();
		$grupo->crear($this->opt);	
	}

	private function eliminar(){
		$grupo = new GrupoEmpresas($this->opt['id_grupo']);
		$grupo->eliminar();
	}

}
?>
