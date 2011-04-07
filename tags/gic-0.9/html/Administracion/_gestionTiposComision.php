<?php	include ('../appRoot.php');


//Definiendo la clase
class GestionTiposComision{

	//Listado de datos a mostrar
		public $opt;
		public $datos;
		private $DB_tipocomisiones;

	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionTiposComision($opciones){

		try{
			$usuario = new Usuario($_SESSION['usuario_login']);
			$perfil = $usuario->get_Perfil();
			$this->opt['esAdministrador'] = esAdministrador($perfil['id']);

			//Inicializando el acceso a datos
			$this->DB_tipocomisiones = new ListaTiposDeComision();

			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);

			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de tipocomisiones para tenerlos todos actualizados en la interfaz
			$this->obtenerDatos();
		}
		catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}

	private function obtenerDatos(){
	 	$this->DB_tipocomisiones->buscar();
	 	$this->datos['lista_tipos_de_comisiones'] = array();
		while($tipocomision = $this->DB_tipocomisiones->siguiente())
			$this->datos['lista_tipos_de_comisiones'][] = $tipocomision;
	}
	private function obtenerOpciones($opciones){

		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_tipocomision']))?$this->opt['id_tipocomision']=$opciones['id_tipocomision']:null;

		//Datos de los tipocomisiones
		foreach($this->datos['lista_tipos_de_comisiones'] as $tipocomision){
			(isset($opciones['nombre_'.$tipocomision->get_Id()]))?$this->opt['nombre_'.$tipocomision->get_Id()]=$opciones['nombre_'.$tipocomision->get_Id()]:null;
		}

		(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;
		(isset($opciones['id_cliente']))?$this->opt['id_cliente']=$opciones['id_cliente']:null;

	}

	/**
	 * Guardar:
 	 */
	private function guardar(){
		FB::info('guardando');
		$id = $this->opt['id_tipocomision'];
		$tipocomision = new TipoDeComision($id);
		$tipocomision->set_Nombre($this->opt['nombre_'.$id]);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		$tipocomision = new TipoDeComision();
		$tipocomision->crear($this->opt);
	}

	private function eliminar(){
		$tipocomision = new TipoDeComision($this->opt['id_tipocomision']);
		$tipocomision->eliminar();
	}

}
?>
