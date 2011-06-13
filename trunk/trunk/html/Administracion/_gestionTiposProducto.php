<?php	include ('../appRoot.php');

	
//Definiendo la clase
class GestionTiposProducto{
	
	//Listado de datos a mostrar
		public $opt;		
		public $datos;
		private $DB_tipoproductos;
	
	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionTiposProducto($opciones){

		try{
			$usuario = new Usuario($_SESSION['usuario_login']);
			$perfil = $usuario->get_Perfil();
			$this->opt['esAdministrador'] = esAdministrador($perfil['id']);

			//Inicializando el acceso a datos
			$this->DB_tipoproductos = new ListaTiposDeProducto();
			
			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);		
		
			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de tipoproductos para tenerlos todos actualizados en la interfaz		
			$this->obtenerDatos();
		}
		catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}
	
	private function obtenerDatos(){
	 	$this->DB_tipoproductos->buscar();
	 	$this->datos['lista_tipos_de_productos'] = array();
		while($tipoproducto = $this->DB_tipoproductos->siguiente())
			$this->datos['lista_tipos_de_productos'][] = $tipoproducto;
	}
	private function obtenerOpciones($opciones){

		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_tipoproducto']))?$this->opt['id_tipoproducto']=$opciones['id_tipoproducto']:null;
	
		//Datos de los tipoproductos
		foreach($this->datos['lista_tipos_de_productos'] as $tipoproducto){
			(isset($opciones['nombre_'.$tipoproducto->get_Id()]))?$this->opt['nombre_'.$tipoproducto->get_Id()]=$opciones['nombre_'.$tipoproducto->get_Id()]:null;
		}

		(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;		
		
	}	

	/**
	 * Guardar:
 	 */
	private function guardar(){
		//FB::info('guardando');
		$id = $this->opt['id_tipoproducto'];
		$tipoproducto = new TipoDeProducto($id);
		$tipoproducto->set_Nombre($this->opt['nombre_'.$id]);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		$tipoproducto = new TipoDeProducto();
		$tipoproducto->crear($this->opt);	
	}

	private function eliminar(){
		$tipoproducto = new TipoDeProducto($this->opt['id_tipoproducto']);
		$tipoproducto->eliminar();
	}

}
?>
