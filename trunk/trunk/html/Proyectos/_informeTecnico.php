<?php 
 include ('../appRoot.php');

class InformeTecnico{
	
	/*
	 *Variable array que contendrá los valores que se le pasaran a la clase como parámetros para construirla.
	 *
	 *@var array
	 */
	public $opt=array();
	
	/*
	 *Variable que es un array de datos que recogerá los diferentes valores necesarios para ir imprimiendolos en la interfaz
	 *
	 *@var array
	 */
	public $datos = array();


	/*
	 *Variable auxiliar de uso interno para contener el objeto Lista_Proyectos
	 *
	 *@var object
	 *
	 */
	private $lista_Proyectos;

	public $gestor;
	/*
	 *Método que instancia un objeto Busqueda para entregar y recoger los datos necesarios de la interfaz
	 *
	 *@param array($opciones)
	 *
	 */

	public function __construct($opciones){
		
		try{
			
			$this->gestor = new Usuario($_SESSION['usuario_login']);
			//Usamos el método para asignar las opciones pasadas desde la interfaz 	
			$this->obtener_Opciones($opciones);
		
			//Asignamos a una variable el objeto Lista_Proyectos
			$this->lista_Proyectos =  new ListaProyectos();
			
			//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
			$this->obtener_Listas();
			
			if($this->opt['mostrar']){
				//Buscamos los proyectos con los parámetros establecidos en la interfaz
				$this->opt['estados'] = '(3,4,5)'; //sólo los proyectos en estados 3,4,5; pendiente planificación, en curso, fuera de plazo
				$this->lista_Proyectos->buscar($this->opt);
			}
			
			//Hacemos accesible esta informacion desde fuera de la clase
			$this->datos['lista_proyectos']=$this->lista_Proyectos;
		}catch (Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
		
	/*
	 *Metodo que filtra y establece los datos que se pasaran a las diferentes clases para instanciar los objetos que se necesiten.
	 *
	 *@param array($opciones)
	 *
	 */
	
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
	}

	/**
	 * Método con el que se obtienen los listados necesario para rellenar los desplegables de la interfaz
	 *
	 */
	 private function obtener_Listas(){	 	
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_tecnicos'] = $listaUsuarios;
	 }
}
?>