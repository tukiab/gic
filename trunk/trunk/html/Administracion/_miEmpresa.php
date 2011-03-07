<?php
/**
 * Clase que gestiona las presentación de la información de una Cliente.
 * 
 */
class MiEmpresa{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
	public $usuario;
	public $Cliente;
												
	/**
	 * Se obtienen los datos necesarios para mostrar el la interfaz, a partir de los parámetros pasados al 
	 * constructor.
	 * También realiza las funciones de modificación de datos necesarias..
	 * 
	 * @param array $opciones Array de opciones pasados al script. Se corresponde con el array $_GET de la vista.
	 */
	public function __construct($opciones){
		try{
			$this->get_Opciones($opciones);			
			$this->usuario = new Usuario($_SESSION['usuario_login']);
			
			//Buscamos el cliente en la BBDD, si existe:
			$ListaClientes = new ListaClientes();
			$ListaClientes->get_Cliente_Principal();

			if($this->opt['guardar'])
				$this->guardar();
			
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones){
		@($opciones['razon_social'])?$this->opt['razon_social']=$opciones['razon_social']:null;
		@($opciones['sector'])?$this->opt['sector']=$opciones['sector']:null;
		@($opciones['web'])?$this->opt['web']=$opciones['web']:null;
		$this->opt['tipo_cliente']=2; //Cliente definitivo
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['FAX'])?$this->opt['FAX']=$opciones['FAX']:null;
		@($opciones['provincia'])?$this->opt['provincia']=$opciones['provincia']:null;
		@($opciones['telefono'])?$this->opt['telefono']=$opciones['telefono']:null;

		@($opciones['CP'])?$this->opt['CP']=$opciones['CP']:null;
		@($opciones['numero_empleados'])?$this->opt['numero_empleados']=$opciones['numero_empleados']:null;
		
		@($opciones['gestor'])?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		$this->opt['gestor_obj'] = new Usuario($this->opt['gestor']);
		
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
		($opciones['editar'])?$this->opt['editar']=true:$this->opt['editar']=false;

		$this->opt['cliente_principal'] = true;
	}

	/**
	 * Guarda el cliente.
	 * Si el cliente existe... lo actualiza. Si no... pues crea uno nuevo! MWAHAHA!!
	 */
	private function guardar(){
		if(!$this->Cliente){
			$this->Cliente = new Cliente();
			$this->Cliente->crear($this->opt);
		}else{
			$this->Cliente->editar($this->opt);
		}

		$this->opt['msg'] = 'Guardado';
	}
	
}
?>