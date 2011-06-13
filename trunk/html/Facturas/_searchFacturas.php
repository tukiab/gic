<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica para las búsquedas de Problemass.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class BusquedaFacturas{

	
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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Facturas
	 *
	 *@var object
	 *
	 */
	private $lista_Facturas;

	public $gestor;
	/*
	 *Método que instancia un objeto Busqueda para entregar y recoger los datos necesarios de la interfaz
	 *
	 *@param array($opciones)
	 *
	 */

	public function __construct($opciones){
		////FB::log($opciones, "BusquedaFacturas:Opciones");
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Usamos el método para asignar las opciones pasadas desde la interfaz 	
		$this->obtener_Opciones($opciones);
	
		if($this->opt['eliminar']) $this->eliminarFacturas();
		//Asignamos a una variable el objeto Lista_Facturas
		$this->lista_Facturas =  new ListaFacturas();
		
		//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
		$this->obtener_Listas();
		
		//Paginando..
		list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
		
		//Buscamos los facturacions con los parámetros establecidos en la interfaz
		$this->lista_Facturas->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
		//$this->lista_Facturas->buscar($this->opt);
		$total = $this->lista_Facturas->num_Resultados();
		$this->datos['lastPage'] = @($total/$this->datos['paso']); 
		$this->datos['lastPage'] = floor ($this->datos['lastPage']);
		$this->datos['lastPage'] = @( fmod($total,$this->datos['paso'])==0 ? $this->datos['lastPage'] : $this->datos['lastPage']+1 );
		
		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista']=$this->lista_Facturas;
	}
	
	private function eliminarFacturas(){
		foreach($this->opt['seleccionados'] as $idFactura){
			$facturacion = new Factura($idFactura);
			$facturacion->del_Factura();
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
		@($opciones['seleccionados'])?$this->opt['seleccionados']=$opciones['seleccionados']:null;
		@($opciones['cliente'])?$this->opt['cliente']=$opciones['cliente']:null;	
		@($opciones['base_imponible_desde'])?$this->opt['base_imponible_desde']=$opciones['base_imponible_desde']:null;
		@($opciones['base_imponible_hasta'])?$this->opt['base_imponible_hasta']=$opciones['base_imponible_hasta']:null;			
		@($opciones['numero_factura'])?$this->opt['numero_factura']=$opciones['numero_factura']:null;
		@($opciones['probabilidad_contratacion'])?$this->opt['probabilidad_contratacion']=$opciones['probabilidad_contratacion']:null;
		@($opciones['fecha_pago_desde'])?$this->opt['fecha_pago_desde']=date2timestamp($opciones['fecha_pago_desde']):null;
		@($opciones['fecha_pago_hasta'])?$this->opt['fecha_pago_hasta']=date2timestamp($opciones['fecha_pago_hasta']):null;
		@($opciones['fecha_facturacion_desde'])?$this->opt['fecha_facturacion_desde']=date2timestamp($opciones['fecha_facturacion_desde']):null;
		@($opciones['fecha_facturacion_hasta'])?$this->opt['fecha_facturacion_hasta']=date2timestamp($opciones['fecha_facturacion_hasta']):null;
		@($opciones['year_desde'])?$this->opt['year_desde']=$opciones['year_desde']:null;
		@($opciones['year_hasta'])?$this->opt['year_hasta']=$opciones['year_hasta']:null;
		@($opciones['estado'])?$this->opt['estado']=$opciones['estado']:null;
		
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
	 	$this->datos['lista_estados_facturacions'] = $this->lista_Facturas->lista_Estados();
		
	 	$listaUsuarios = new ListaOfertas();
		$this->datos['lista_gestores'] = $listaUsuarios->lista_Gestores();
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

