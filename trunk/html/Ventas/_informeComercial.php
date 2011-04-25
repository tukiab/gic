<?php 
 include ('../appRoot.php');

class InformeComercial{
	
	public $opt=array();	
	public $datos = array();
	private $lista_Proyectos;
	public $gestor;

	public function __construct($opciones){		
		try{
			
			$this->gestor = new Usuario($_SESSION['usuario_login']);
			$this->obtener_Opciones($opciones);
			$this->lista_Proyectos =  new ListaProyectos();
			$this->obtener_Listas();
			
			if($this->opt['mostrar']){				
				//$this->opt['estados'] = '(3,4,5)'; //sólo los proyectos en estados 3,4,5; pendiente planificación, en curso, fuera de plazo
				$this->lista_Proyectos->buscar($this->opt);
			}
			$this->datos['lista_proyectos']=$this->lista_Proyectos;
		}catch (Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
		
	private function obtener_Opciones($opciones){
		
		@($opciones['gestor'])?$this->opt['gestor']=$opciones['gestor']:null;
		@($opciones['mostrar'])?$this->opt['mostrar']=$opciones['mostrar']:null;

		@($opciones['mes_desde'])?$this->opt['mes_desde']=$opciones['mes_desde']:null;
		@($opciones['mes_hasta'])?$this->opt['mes_hasta']=$opciones['mes_hasta']:null;
		@($opciones['year_desde'])?$this->opt['year_desde']=$opciones['year_desde']:null;
		@($opciones['year_hasta'])?$this->opt['year_hasta']=$opciones['year_hasta']:null;

		//generamos fecha desde y fecha hasta:
		$this->opt['fecha_desde'] = date2timestamp('1/'.$this->opt['mes_desde'].'/'.$this->opt['year_desde']);
		$dia = numeroDeDias($this->opt['mes_hasta'], $this->opt['year_hasta']);
		$this->opt['fecha_hasta'] = date2timestamp($dia.'/'.$this->opt['mes_hasta'].'/'.$this->opt['year_hasta']);

		if($this->opt['fecha_desde'] >$this->opt['fecha_hasta'])
			throw new Exception ('El rango de fechas introducido es inv&aacute;lido');
	}
	
	private function obtener_Listas(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_comerciales'] = $listaUsuarios;
	 }
}
?>