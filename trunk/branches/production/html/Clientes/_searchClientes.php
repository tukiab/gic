<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica para las búsquedas de Problemass.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class BusquedaClientes{

	
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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Clientes
	 *
	 *@var object
	 *
	 */
	private $lista_Clientes;

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
		
			//Asignamos a una variable el objeto Lista_Clientes
			$this->lista_Clientes =  new ListaClientes();
			
			if($this->opt['eliminar']) $this->eliminarClientes();
			if($this->opt['agregar_gestores']) $this->agregarGestores();
			if($this->opt['agregar_grupos']) $this->agregarGrupos();
			
			//Obtenemos las listas necesarias para completar los desplegables de la interfaz.		
			$this->obtener_Listas();
			
			//Paginando..
			list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
			
			if($this->opt['exportar_todo']){
				$this->opt['exportar'] = 1;
				$this->lista_Clientes->buscar();
			}
			else if($this->opt['mostrar']){
				//Buscamos los clientes con los parámetros establecidos en la interfaz
				$this->lista_Clientes->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
			}
			
			$total = $this->lista_Clientes->num_Resultados();
			$this->datos['lastPage'] = @($total/$this->datos['paso']); 
			$this->datos['lastPage'] = floor ($this->datos['lastPage']);
			$this->datos['lastPage'] = @( fmod($total,$this->datos['paso'])==0 ? $this->datos['lastPage'] : $this->datos['lastPage']+1 );
			
			//Hacemos accesible esta informacion desde fuera de la clase
			$this->datos['lista_clientes']=$this->lista_Clientes;
		}catch (Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	private function eliminarClientes(){
	//Paginando..
			list($this->datos['page'], $this->datos['paso'], $this->datos['lastPage']) = $this->get_Variables_Paginado($opciones);
		$this->lista_Clientes->buscar($this->opt, $this->datos['page'], $this->datos['paso']);
		$this->datos['lista_clientes']=$this->lista_Clientes;
		if(!$this->opt['borrado_total']){		
			foreach($this->opt['seleccionados'] as $idCliente){
				$cliente = new Cliente($idCliente);
				if(count($cliente->get_Acciones()) > 0 || count($cliente->get_Ofertas()) > 0)
					throw new Exception("Existen clientes seleccionados con acciones u ofertas. Confirme el borrado");
			}
		}
		foreach($this->opt['seleccionados'] as $idCliente){
			$cliente = new Cliente($idCliente);
			$cliente->del_Cliente($this->opt['borrado_total']);
		}
		
	}
	
	private function agregarGestores(){
		foreach($this->opt['seleccionados'] as $idCliente){
			$cliente = new Cliente($idCliente);
			foreach($this->opt['gestores_seleccionados'] as $idGestor){
				$cliente->add_Gestor($idGestor);
			}
		}
	}
	private function agregarGrupos(){
		foreach($this->opt['seleccionados'] as $idCliente){
			$cliente = new Cliente($idCliente);
			$cliente->set_Grupo_Empresas($this->opt['grupo_seleccionado']);
			
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
		global $permisos;
		
		$id_usuario = $_SESSION['usuario_login'];
		$usuario = new Usuario($id_usuario);
		
		$perfil_usuario = $usuario->get_Perfil();
		if(!$permisos->administracion && !esPerfilTecnico($perfil_usuario['id'])){
			$this->opt['id_usuario'] = $id_usuario;
		}
		else
			@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;			

		@($opciones['exportar'])?$this->opt['exportar']=$opciones['exportar']:null;		
		@($opciones['exportar_todo'])?$this->opt['exportar_todo']=$opciones['exportar_todo']:null;

		@($opciones['mostrar'])?$this->opt['mostrar']=true:$this->opt['mostrar']=false;
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;		
		@($opciones['borrado_total'])?$this->opt['borrado_total']=true:$this->opt['borrado_total']=false;
		@($opciones['agregar_gestores'])?$this->opt['agregar_gestores']=true:$this->opt['agregar_gestores']=false;
		@($opciones['agregar_grupos'])?$this->opt['agregar_grupos']=true:$this->opt['agregar_grupos']=false;
		@($opciones['gestores_seleccionados'])?$this->opt['gestores_seleccionados']=$opciones['gestores_seleccionados']:null;
		@($opciones['grupo_seleccionado'])?$this->opt['grupo_seleccionado']=$opciones['grupo_seleccionado']:null;
		@($opciones['seleccionados'])?$this->opt['seleccionados']=$opciones['seleccionados']:null;
		@($opciones['razon_social'])?$this->opt['razon_social']=$opciones['razon_social']:null;	
		@($opciones['sector'])?$this->opt['sector']=$opciones['sector']:null;
		@($opciones['web'])?$this->opt['web']=$opciones['web']:null;
		@($opciones['tipo_cliente'] != 0)?$this->opt['tipo_cliente']=$opciones['tipo_cliente']:null;			
		@($opciones['grupo_empresas'])?$this->opt['grupo_empresas']=$opciones['grupo_empresas']:null;
		@($opciones['domicilio'])?$this->opt['domicilio']=$opciones['domicilio']:null;
		@($opciones['NIF'])?$this->opt['NIF']=$opciones['NIF']:null;
		@($opciones['localidad'])?$this->opt['localidad']=$opciones['localidad']:null;
		@($opciones['CP'])?$this->opt['CP']=$opciones['CP']:null;
		@($opciones['numero_empleados_min'])?$this->opt['numero_empleados_min']=$opciones['numero_empleados_min']:null;
		@($opciones['numero_empleados_max'])?$this->opt['numero_empleados_max']=$opciones['numero_empleados_max']:null;
		@($opciones['fecha_renovacion_desde'])?$this->opt['fecha_renovacion_desde']=date2timestamp($opciones['fecha_renovacion_desde']):null;
		@($opciones['fecha_renovacion_hasta'])?$this->opt['fecha_renovacion_hasta']=date2timestamp($opciones['fecha_renovacion_hasta']):null;
		@($opciones['SPA_actual'])?$this->opt['SPA_actual']=$opciones['SPA_actual']:null;
		@($opciones['norma_implantada'])?$this->opt['norma_implantada']=$opciones['norma_implantada']:null;
		@($opciones['creditos_desde'])?$this->opt['creditos_desde']=$opciones['creditos_desde']:null;
		@($opciones['creditos_hasta'])?$this->opt['creditos_hasta']=$opciones['creditos_hasta']:null;
		
		@($opciones['nombre_contacto'])?$this->opt['contacto']['nombre']=$opciones['nombre_contacto']:null;
		@($opciones['telefono_contacto'])?$this->opt['contacto']['telefono']=$opciones['telefono_contacto']:null;
		@($opciones['email_contacto'])?$this->opt['contacto']['email']=$opciones['email_contacto']:null;
		@($opciones['cargo_contacto'])?$this->opt['contacto']['cargo']=$opciones['cargo_contacto']:null;
				
		@($opciones['acciones_de_trabajo_futuras'])?$this->opt['acciones']['acciones_de_trabajo_futuras']=$opciones['acciones_de_trabajo_futuras']:null;
		
		@($opciones['order_by'])?$this->opt['order_by']=$opciones['order_by']:null;
		@($opciones['order_by_asc_desc'])?$this->opt['order_by_asc_desc']=$opciones['order_by_asc_desc']:null;
		
		@($opciones['msg'])?$this->opt['msg']=$opciones['msg']:null;

		@($opciones['telefono1'] && $opciones['telefono2'] && $opciones['telefono3'])?$this->opt['telefono']=$opciones['telefono1'].$opciones['telefono2'].$opciones['telefono3']:null;
		@($opciones['FAX1'] && $opciones['FAX2'] && $opciones['FAX3'])?$this->opt['FAX']=$opciones['FAX1'].$opciones['FAX2'].$opciones['FAX3']:null;		
		@(isset($opciones['gestor']))?$this->opt['gestor']=$opciones['gestor']:$this->opt['gestor']=$_SESSION['usuario_login'];
		if($this->opt['gestor'])
			$this->opt['id_usuario'] = $this->opt['gestor'];
		
	}

	/**
	 * Método con el que se obtienen los listados necesario para rellenar los desplegables de la interfaz
	 *
	 */
	 private function obtener_Listas(){	 	
	 	$this->datos['lista_tipos_clientes'] = $this->lista_Clientes->lista_Tipos();
	 	$this->datos['lista_grupos_empresas'] = $this->lista_Clientes->lista_Grupos_Empresas();
	 	$this->datos['lista_gestores'] = $this->lista_Clientes->lista_Gestores();
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