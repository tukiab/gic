<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica para las búsquedas de Problemass.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class BusquedaProveedores{

	
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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Proveedores
	 *
	 *@var object
	 *
	 */
	private $lista_Proveedores;
	
	public $gestor;
	/*
	 *Método que instancia un objeto Busqueda para entregar y recoger los datos necesarios de la interfaz
	 *
	 *@param array($opciones)
	 *
	 */

	public function __construct($opciones){
		//FB::log($opciones, "BusquedaProveedores:Opciones");		
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Usamos el método para asignar las opciones pasadas desde la interfaz 	
		$this->obtener_Opciones($opciones);
	
		if($this->opt['eliminar']) $this->eliminarProveedores();
	
		//Asignamos a una variable el objeto Lista_Proveedores
		$this->lista_Proveedores =  new ListaProveedores();
		
		//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
		$this->obtener_Listas();
		
		//Paginando..
		list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
		
		//Buscamos los proveedores con los parámetros establecidos en la interfaz
		$this->lista_Proveedores->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
		//$this->lista_Proveedores->buscar($this->opt);
		$total = $this->lista_Proveedores->num_Resultados();
		$this->datos['lastPage'] = $total/$this->datos['paso']; 
		$this->datos['lastPage'] = floor ($this->datos['lastPage']);
		$this->datos['lastPage'] = ( fmod($total,$this->datos['paso'])==0 ? $this->datos['lastPage'] : $this->datos['lastPage']+1 );
		
		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista_proveedores']=$this->lista_Proveedores;
	}
	
	private function eliminarProveedores(){
		foreach($this->opt['seleccionados'] as $id){
			$accion = new Proveedor($id);
			$accion->del_Proveedor();
		}
	}
	
	/*
	 *Metodo que filtra y establece los datos que se pasaran a las diferentes clases para instanciar los objetos que se necesiten.
	 *
	 *@param array($opciones)
	 *
	 */
	
	private function obtener_Opciones($opciones){
		
		//Asignar opciones según se nos pase desde la interfaz para construir una busqueda.	
		
		
		$id_usuario = $_SESSION['usuario_login'];
		$usuario = new Usuario($id_usuario);
		//FB::info($usuario);
		$perfil_usuario = $usuario->get_Perfil();
		if($perfil_usuario['id'] != 5 && $perfil_usuario['id'] != 4)
			$this->opt['id_usuario'] = $id_usuario;
		else
			@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;			
	
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		@($opciones['seleccionados'])?$this->opt['seleccionados']=$opciones['seleccionados']:null;
		@($opciones['razon_social'])?$this->opt['razon_social']=$opciones['razon_social']:null;
		@($opciones['CP'])?$this->opt['CP']=$opciones['CP']:null;		
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['order_by'])?$this->opt['order_by']=$opciones['order_by']:null;
		@($opciones['order_by_asc_desc'])?$this->opt['order_by_asc_desc']=$opciones['order_by_asc_desc']:null;
		
	}

	/**
	 * Método con el que se obtienen los listados necesario para rellenar los desplegables de la interfaz
	 *
	 */
	 private function obtener_Listas(){	 	
	 	
	 }
	 
	 private function get_Variables_Paginado($opciones){
		
		@(isset($opciones['paso'])?$paso=$opciones['paso']:$paso='40');
		@(isset($opciones['page'])?$page=$opciones['page']:$page='1');
		$total=$opciones['total'];//Primero se recoge de hidden y luego toma el valor total de row de la consulta
		
		(!$opciones['navigation'])?$opciones['navigation']='Inicio':null;
		switch ($opciones['navigation']){
			case 'Irpag'://Ir a la pagina indicada
				if (($page*$paso)>$total){//para que no se pase de pagina
					if($total%$paso==0)
						$nump=$total/$paso;
					else
						$nump=ceil($total/$paso);
					$page=($nump-1)*$paso;
				}else{
					$page=(($page-1)*$paso);//Obtenemos el numero de registro por donde empezar a contar
				}
				break;
			case 'Inicio':
				$page=0;
				break;
			case 'Anterior':
				if($page > 0)
				{ $page=$page-$paso; }
				break;
			case 'Siguiente':
				$page=$page+$paso;
				break;
			case 'Fin':
				$page = 0;
				$lastPage=$total/$paso;
				$lastPage=floor($lastPage);
				$page = ($lastPage*$paso);
				$page = ($page==$total)?$page-$paso:$page;
				break;
		}
		return array($page, $paso, $lastPage);
	 }
	 
	 
}
?>

