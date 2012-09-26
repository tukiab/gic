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

			$this->get_Datos();
			$this->get_Opciones($opciones);
			
			if($this->opt['eliminar']) $this->eliminar();

			else if($this->opt['cambiar_tipo_comision'])
				$this->opt['Venta']->set_Tipo_Comision($this->opt['tipo_comision']);
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
		
		@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		$Venta = new Venta($this->opt['id']);
		//Hacemos visible al venta fuera de la clase:
		$this->opt['Venta'] = $Venta;

		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);

		$tipo=$this->opt['Venta']->get_Tipo_Comision();
		@($opciones['tipo_comision'])?$this->opt['tipo_comision']=$opciones['tipo_comision']:$this->opt['tipo_comision']=$tipo['id'];

		if($this->opt['tipo_comision'] != $tipo['id'])
			$this->opt['cambiar_tipo_comision'] = true;

	}

	private function get_Datos(){
		$listaVentas = new ListaVentas();
		$this->datos['lista_tipos_comision'] = $listaVentas->lista_Tipos_Comision();
	}
}
?>
