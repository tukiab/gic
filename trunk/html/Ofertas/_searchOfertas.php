<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica para las búsquedas de Problemass.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class BusquedaOfertas{

	
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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Ofertas
	 *
	 *@var object
	 *
	 */
	private $lista_Ofertas;

	public $gestor;
	/*
	 *Método que instancia un objeto Busqueda para entregar y recoger los datos necesarios de la interfaz
	 *
	 *@param array($opciones)
	 *
	 */

	public function __construct($opciones){
		////FB::log($opciones, "BusquedaOfertas:Opciones");
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Usamos el método para asignar las opciones pasadas desde la interfaz 	
		$this->obtener_Opciones($opciones);
	
		if($this->opt['eliminar']) $this->eliminarOfertas();
		//Asignamos a una variable el objeto Lista_Ofertas
		$this->lista_Ofertas =  new ListaOfertas();
		
		//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
		$this->obtener_Listas();
		
		//Paginando..
		list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
		
		//Buscamos los ofertas con los parámetros establecidos en la interfaz
		$this->lista_Ofertas->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
		//$this->lista_Ofertas->buscar($this->opt);
		$total = $this->lista_Ofertas->num_Resultados();
		$this->datos['lastPage'] = @($total/$this->datos['paso']); 
		$this->datos['lastPage'] = floor ($this->datos['lastPage']);
		$this->datos['lastPage'] = @( fmod($total,$this->datos['paso'])==0 ? $this->datos['lastPage'] : $this->datos['lastPage']+1 );
		
		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista_ofertas']=$this->lista_Ofertas;
	}
	
	private function eliminarOfertas(){
		foreach($this->opt['seleccionados'] as $idOferta){
			$oferta = new Oferta($idOferta);
			$oferta->del_Oferta();
		}
	}
	
	/*
	 *Metodo que filtra y establece los datos que se pasaran a las diferentes clases para instanciar los objetos que se necesiten.
	 *
	 *@param array($opciones)
	 *
	 */
	
	private function obtener_Opciones($opciones){
				global $permisos;

		//Asignar opciones según se nos pase desde la interfaz para construir una busqueda.	
		$id_usuario = $_SESSION['usuario_login'];
		$usuario = new Usuario($id_usuario);
		
		$perfil_usuario = $usuario->get_Perfil();
		if(!$permisos->administracion && !esPerfilTecnico($perfil_usuario['id']))
			$this->opt['id_usuario'] = $id_usuario;
		else
			@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;			

		@($opciones['exportar'])?$this->opt['exportar']=$opciones['exportar']:null;		

				@($opciones['mostrar'])?$this->opt['mostrar']=true:$this->opt['mostrar']=false;

		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		@($opciones['seleccionados'])?$this->opt['seleccionados']=$opciones['seleccionados']:null;
		@($opciones['codigo'])?$this->opt['codigo']=$opciones['codigo']:null;	
		@($opciones['nombre_oferta'])?$this->opt['nombre_oferta']=$opciones['nombre_oferta']:null;
		@($opciones['estado_oferta'])?$this->opt['estado_oferta']=$opciones['estado_oferta']:null;			
		@($opciones['producto'])?$this->opt['producto']=$opciones['producto']:null;
		@($opciones['proveedor'])?$this->opt['proveedor']=$opciones['proveedor']:null;
		@($opciones['probabilidad_contratacion'])?$this->opt['probabilidad_contratacion']=$opciones['probabilidad_contratacion']:null;
		@($opciones['fecha_desde'])?$this->opt['fecha_desde']=date2timestamp($opciones['fecha_desde']):null;
		@($opciones['fecha_hasta'])?$this->opt['fecha_hasta']=date2timestamp($opciones['fecha_hasta']):null;
		@($opciones['fecha_definicion_desde'])?$this->opt['fecha_definicion_desde']=date2timestamp($opciones['fecha_definicion_desde']):null;
		@($opciones['fecha_definicion_hasta'])?$this->opt['fecha_definicion_hasta']=date2timestamp($opciones['fecha_definicion_hasta']):null;
		@($opciones['importe_desde'])?$this->opt['importe_desde']=$opciones['importe_desde']:null;
		@($opciones['importe_hasta'])?$this->opt['importe_hasta']=$opciones['importe_hasta']:null;
		@($opciones['codigo_desde'])?$this->opt['codigo_desde']=$opciones['codigo_desde']:null;
		@($opciones['codigo_hasta'])?$this->opt['codigo_hasta']=$opciones['codigo_hasta']:null;
		
		@(isset($opciones['es_oportunidad_de_negocio']))?$this->opt['es_oportunidad_de_negocio']=$opciones['es_oportunidad_de_negocio']:$this->opt['es_oportunidad_de_negocio']=2;
		
		@($opciones['order_by'])?$this->opt['order_by']=$opciones['order_by']:null;
		@($opciones['order_by_asc_desc'])?$this->opt['order_by_asc_desc']=$opciones['order_by_asc_desc']:null;
		
		@($opciones['msg'])?$this->opt['msg']=$opciones['msg']:null;

				
		@(isset($opciones['gestor']))?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		if($this->opt['gestor'])
			$this->opt['id_usuario'] = $this->opt['gestor'];
		
	}

	/**
	 * Método con el que se obtienen los listados necesario para rellenar los desplegables de la interfaz
	 *
	 */
	 private function obtener_Listas(){
	 	$this->datos['lista_estados_ofertas'] = $this->lista_Ofertas->lista_Estados();
		$this->datos['lista_tipos_productos'] = $this->lista_Ofertas->lista_Tipos_Productos();
		$this->datos['lista_probabilidades'] = $this->lista_Ofertas->lista_Probabilidades();
		$this->datos['lista_colaboradores'] = $this->lista_Ofertas->lista_Colaboradores();
		$this->datos['lista_gestores'] = $this->lista_Ofertas->lista_Gestores();
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

