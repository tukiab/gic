<?php	include ('../appRoot.php');

	
//Definiendo la clase
class GestionTiposAccion{
	
	//Listado de datos a mostrar
		public $opt;		
		public $datos;
		private $DB_tipoacciones;
	
	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionTiposAccion($opciones){

		try{
			$usuario = new Usuario($_SESSION['usuario_login']);
			$perfil = $usuario->get_Perfil();
			$this->opt['esAdministrador'] = esAdministrador($perfil['id']);

			//Inicializando el acceso a datos
			$this->DB_tipoacciones = new ListaTiposDeAccion();
			
			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);		
		
			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de tipoacciones para tenerlos todos actualizados en la interfaz		
			$this->obtenerDatos();
		}
		catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}
	
	private function obtenerDatos(){
	 	$this->DB_tipoacciones->buscar();
	 	$this->datos['lista_tipos_de_acciones'] = array();
		while($tipoaccion = $this->DB_tipoacciones->siguiente())
			$this->datos['lista_tipos_de_acciones'][] = $tipoaccion;
	}
	private function obtenerOpciones($opciones){

		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_tipoaccion']))?$this->opt['id_tipoaccion']=$opciones['id_tipoaccion']:null;
	
		//Datos de los tipoacciones
		foreach($this->datos['lista_tipos_de_acciones'] as $tipoaccion){
			(isset($opciones['nombre_'.$tipoaccion->get_Id()]))?$this->opt['nombre_'.$tipoaccion->get_Id()]=$opciones['nombre_'.$tipoaccion->get_Id()]:null;
		}

		(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;		
		(isset($opciones['id_cliente']))?$this->opt['id_cliente']=$opciones['id_cliente']:null;	
		
	}	

	/**
	 * Guardar:
 	 */
	private function guardar(){
		FB::info('guardando');
		$id = $this->opt['id_tipoaccion'];
		$tipoaccion = new TipoDeAccion($id);
		$tipoaccion->set_Nombre($this->opt['nombre_'.$id]);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		$tipoaccion = new TipoDeAccion();
		$tipoaccion->crear($this->opt);	
	}

	private function eliminar(){
		$tipoaccion = new TipoDeAccion($this->opt['id_tipoaccion']);
		$tipoaccion->eliminar();
	}

}
?>
