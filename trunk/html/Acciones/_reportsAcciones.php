<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica de la creación de informes.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class InformesAcciones{

	
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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Acciones
	 *
	 *@var object
	 *
	 */
	private $lista_Acciones;

	public $gestor;

	public $resumen;
	/*
	 *Método que instancia un objeto Busqueda para entregar y recoger los datos necesarios de la interfaz
	 *
	 *@param array($opciones)
	 *
	 */

	public function __construct($opciones){

		$this->obtener_Listas();
		//Usamos el método para asignar las opciones pasadas desde la interfaz 	
		$this->obtener_Opciones($opciones);
		
		//Buscamos los acciones con los parámetros establecidos en la interfaz
		if($this->opt['buscar']) $this->datos['informes_usuarios'] = $this->buscar(); else $this->datos['informes_usuarios'] = array();
		
		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista_acciones']=$this->lista_Acciones;
	}
	
	private function obtener_Listas(){
		$listaUsr = new ListaUsuarios();
		$this->datos['lista_gestores'] = $listaUsr->lista_Usuarios();
	}
	
	/*
	 *Metodo que filtra y establece los datos que se pasaran a las diferentes clases para instanciar los objetos que se necesiten.
	 *
	 *@param array($opciones)
	 *
	 */
	
	private function obtener_Opciones($opciones){
		
		//Asignar opciones según se nos pase desde la interfaz para construir una busqueda.	
		
		@($opciones['fecha_desde'])?$this->opt['fecha_desde']=date2timestamp($opciones['fecha_desde']):null;
		@($opciones['fecha_hasta'])?$this->opt['fecha_hasta']=date2timestamp($opciones['fecha_hasta']):null;
		
		@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;			
		
		@($opciones['buscar'])?$this->opt['buscar']=$opciones['buscar']:null;
		
	}

	private function buscar(){
		$filtro = "";
		if($this->opt['fecha_desde'])
			$filtro .= " AND acciones_de_trabajo.fecha >= '".$this->opt['fecha_desde']."' ";
		if($this->opt['fecha_hasta'])
			$filtro .= " AND acciones_de_trabajo.fecha <= '".$this->opt['fecha_hasta']."' ";
		if($this->opt['id_usuario'])
			$filtro .= " AND acciones_de_trabajo.fk_usuario = '".$this->opt['id_usuario']."'";

		$query = "SELECT acciones_de_trabajo.fk_usuario as usuario, acciones_de_trabajo.fk_tipo_accion as tipo, acciones_tipos.nombre,
					COUNT(DISTINCT acciones_de_trabajo.id) as num_acciones,
					COUNT(DISTINCT acciones_de_trabajo.fk_cliente) as num_clientes

					FROM acciones_de_trabajo
					INNER JOIN acciones_tipos ON acciones_tipos.id = acciones_de_trabajo.fk_tipo_accion
					INNER JOIN clientes ON clientes.id = acciones_de_trabajo.fk_cliente
					WHERE 1 $filtro

					GROUP BY usuario, tipo WITH ROLLUP;";FB::info($query);

		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$datos[$row['usuario']][] = $row;
		}
		FB::info($datos);
		$this->resumen = $datos;
		//return $datos;

		foreach($datos as $user => $resumen_usr){
						
		}
		$resultados = array(); //array multidimensional con la información a mostrar..
		
		//Iteramos sobre los usuarios
		$listaUsuarios = new ListaUsuarios();
		@($this->opt['id_usuario'])?$filtro['id']=$this->opt['id_usuario']:null;
		$listaUsuarios->buscar($filtro);
		while($usuario = $listaUsuarios->siguiente()){
			$resultado_usuario = array(); //resultado para cada usuario
			$total_acciones_usuario = 0;
			$total_clientes_usuario = 0;
						
			$resultado_usuario['id_usuario'] = $usuario->get_Id();
			
			//Indicamos que vamos a buscar acciones de este usuario y entre las fechas dadas
			$filtros = $this->opt;
			$filtros['id_usuario'] = $usuario->get_Id();
			
			//Iteramos sobre los tipos de accion
			$listaTiposDeAccion = new ListaTiposDeAccion();
			$listaTiposDeAccion->buscar();
			while($tipoAccion = $listaTiposDeAccion->siguiente()){
				$resultado_tipo_accion = array(); //resultado de cada tipo de accion
				
				$resultado_tipo_accion['tipo'] = $tipoAccion->get_nombre();
				
				//Indicamos que vamos a buscar acciones de este tipo
				$filtros['tipo_accion'] = $tipoAccion->get_Id();
				$listaAcciones = new ListaAcciones();
				
				$listaAcciones->buscar($filtros);//buscamos con las opciones pasadas (fechas) y con el usuario y el tipo en cuestión.
				
				$array_clientes_acciones = array();
				while($accion = $listaAcciones->siguiente()){
					//Ahora tenemos que procesar todas las acciones encontradas y obtener el número de clientes distintos
					$cliente = $accion->get_Cliente();
					if(!in_array($cliente['id'],$array_clientes_acciones))
						$array_clientes_acciones[] = $cliente['id'];
				}
				$num_acciones = $listaAcciones->num_Resultados();
				$num_clientes = count($array_clientes_acciones);
				
				$resultado_tipo_accion['num_acciones'] = $num_acciones;
				$resultado_tipo_accion['num_clientes'] = $num_clientes;
				
				
				$total_acciones_usuario += $num_acciones;
				$total_clientes_usuario += $num_clientes;
								
				$resultado_usuario['informes'][] = $resultado_tipo_accion;
				$resultado_usuario['total_acciones_usuario'] = $total_acciones_usuario;
				$resultado_usuario['total_clientes_usuario'] = $total_clientes_usuario;
			}
			$resultados[] = $resultado_usuario;
		}
		
		return $resultados;
	}
	 
}
?>

