<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica para las búsquedas de Problemass.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class BusquedaProyectos{

	
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
			//FB::info($opciones, "BusquedaProyectos:Opciones");
			$this->gestor = new Usuario($_SESSION['usuario_login']);
			//Usamos el método para asignar las opciones pasadas desde la interfaz 	
			$this->obtener_Opciones($opciones);
		
			//Asignamos a una variable el objeto Lista_Proyectos
			$this->lista_Proyectos =  new ListaProyectos();
			
			if($this->opt['eliminar']) $this->eliminarProyectos();
			if($this->opt['asignar_gestores']) $this->asignarGestor();
			
			//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
			$this->obtener_Listas();
			
			//Paginando..
			list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
			
			if($this->opt['exportar_todo']){
				$this->opt['exportar'] = 1;
				$this->lista_Proyectos->buscar();
			}
			else{
			//Buscamos los proyectos con los parámetros establecidos en la interfaz
			$this->lista_Proyectos->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
			}
			//$this->lista_Proyectos->buscar($this->opt);
			$total = $this->lista_Proyectos->num_Resultados();
			$this->datos['lastPage'] = @($total/$this->datos['paso']); 
			$this->datos['lastPage'] = floor ($this->datos['lastPage']);
			$this->datos['lastPage'] = @( fmod($total,$this->datos['paso'])==0 ? $this->datos['lastPage'] : $this->datos['lastPage']+1 );
			
			//Hacemos accesible esta informacion desde fuera de la clase
			$this->datos['lista_proyectos']=$this->lista_Proyectos;
		}catch (Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	private function eliminarProyectos(){
	//Paginando..
		list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
		$this->lista_Proyectos->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
		$this->datos['lista_proyectos']=$this->lista_Proyectos;
		if(!$this->opt['borrado_total']){		
			foreach($this->opt['seleccionados'] as $idProyecto){
				$proyecto = new Proyecto($idProyecto);
				if(count($proyecto->get_Fecha_Fin()) < fechaActualTimeStamp())
					throw new Exception("Existen proyectos sin finalizar. Confirme el borrado");
			}
		}
		foreach($this->opt['seleccionados'] as $idProyecto){
			$proyecto = new Proyecto($idProyecto);
			$proyecto->del_Proyecto($this->opt['borrado_total']);
		}
		
	}
	
	private function asignarGestor(){//asignar gestores a los proyectos
		foreach($this->opt['seleccionados'] as $idProyecto){
			$proyecto = new Proyecto($idProyecto);
			$proyecto->asignar_Gestor($this->opt['gestor_asignar']);
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
		
		$perfil_usuario = $usuario->get_Perfil();
		if($perfil_usuario['id'] != 5 && $perfil_usuario['id'] != 4)
			$this->opt['id_usuario'] = $id_usuario;
		else
			@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;			

		@($opciones['exportar'])?$this->opt['exportar']=$opciones['exportar']:null;	

		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		@($opciones['borrado_total'])?$this->opt['borrado_total']=true:$this->opt['borrado_total']=false;
		@($opciones['asignar_gestor'])?$this->opt['asignar_gestor']=true:$this->opt['asignar_gestor']=false;
		@($opciones['gestor_asignar'])?$this->opt['gestor_asignar']=$opciones['gestor_asignar']:null;
		@($opciones['seleccionados'])?$this->opt['seleccionados']=$opciones['seleccionados']:null;
		@($opciones['nombre'])?$this->opt['nombre']=$opciones['nombre']:null;
		@($opciones['id_estado'] != 0)?$this->opt['id_estado']=$opciones['id_estado']:null;
		@($opciones['fecha_inicio_desde'])?$this->opt['fecha_inicio_desde']=date2timestamp($opciones['fecha_inicio_desde']):null;
		@($opciones['fecha_inicio_hasta'])?$this->opt['fecha_inicio_hasta']=date2timestamp($opciones['fecha_inicio_hasta']):null;
		@($opciones['fecha_fin_desde'])?$this->opt['fecha_fin_desde']=date2timestamp($opciones['fecha_fin_desde']):null;
		@($opciones['fecha_fin_hasta'])?$this->opt['fecha_fin_hasta']=date2timestamp($opciones['fecha_fin_hasta']):null;
		
		@($opciones['order_by'])?$this->opt['order_by']=$opciones['order_by']:null;
		@($opciones['order_by_asc_desc'])?$this->opt['order_by_asc_desc']=$opciones['order_by_asc_desc']:null;
		
		@($opciones['msg'])?$this->opt['msg']=$opciones['msg']:null;

		@($opciones['informe'])?$this->opt['informe']=$opciones['informe']:null;


		@(isset($opciones['gestor']))?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		if($this->opt['gestor'])
			$this->opt['id_usuario'] = $this->opt['gestor'];
		
	}

	/**
	 * Método con el que se obtienen los listados necesario para rellenar los desplegables de la interfaz
	 *
	 */
	 private function obtener_Listas(){	 	
	 	$this->datos['lista_estados'] = $this->lista_Proyectos->lista_Estados();
	 	$this->datos['lista_gestores'] = $this->lista_Proyectos->lista_Gestores();

		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$this->datos['lista_tecnicos'] = $listaUsuarios->buscar();	
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