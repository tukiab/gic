<?php	include ('../appRoot.php');


//Definiendo la clase
class GestionTiposFormasDePago{

	//Listado de datos a mostrar
		public $opt;
		public $datos;
		private $DB_tipoformadepagos;

	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionTiposFormasDePago($opciones){

		try{
			$usuario = new Usuario($_SESSION['usuario_login']);
			$perfil = $usuario->get_Perfil();
			$this->opt['esAdministrador'] = esAdministrador($perfil['id']);

			//Inicializando el acceso a datos
			$this->DB_tipoformadepagos = new ListaTiposDeFormasDePago();

			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);

			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de tipoformadepagos para tenerlos todos actualizados en la interfaz
			$this->obtenerDatos();
		}
		catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}

	private function obtenerDatos(){
	 	$this->DB_tipoformadepagos->buscar();
	 	$this->datos['lista_tipos_de_formas_de_pago'] = array();
		while($tipoformadepago = $this->DB_tipoformadepagos->siguiente())
			$this->datos['lista_tipos_de_formas_de_pago'][] = $tipoformadepago;
	}
	private function obtenerOpciones($opciones){

            (isset($opciones['id_oferta']))?$this->opt['id_oferta']=$opciones['id_oferta']:null;

            ($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
            (isset($opciones['crear']))?$this->opt['crear']=true:null;
            ($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
            (isset($opciones['id_tipoformadepago']))?$this->opt['id_tipoformadepago']=$opciones['id_tipoformadepago']:null;

            //Datos de los tipoformadepagos
            foreach($this->datos['lista_tipos_de_formas_de_pago'] as $tipoformadepago){
                    (isset($opciones['nombre_'.$tipoformadepago->get_Id()]))?$this->opt['nombre_'.$tipoformadepago->get_Id()]=$opciones['nombre_'.$tipoformadepago->get_Id()]:null;
            }

            (isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;

	}

	/**
	 * Guardar:
 	 */
	private function guardar(){
		FB::info('guardando');
		$id = $this->opt['id_tipoformadepago'];
		$tipoformadepago = new TipoDeFormaDePago($id);
		$tipoformadepago->set_Nombre($this->opt['nombre_'.$id]);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		$tipoformadepago = new TipoDeFormaDePago();
		$tipoformadepago->crear($this->opt);
	}

	private function eliminar(){
		$tipoformadepago = new TipoDeFormaDePago($this->opt['id_tipoformadepago']);
		$tipoformadepago->eliminar();
	}

}
?>
