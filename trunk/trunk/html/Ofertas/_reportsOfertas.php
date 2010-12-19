<?php 
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica de la creación de informes.
 * 
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 * 
 */
class InformesOfertas{

	
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

		$this->obtener_Listas();
		//Usamos el método para asignar las opciones pasadas desde la interfaz 	
		$this->obtener_Opciones($opciones);
		
		//Buscamos los ofertas con los parámetros establecidos en la interfaz
		if($this->opt['buscar']) $this->datos['informes_usuarios'] = $this->buscar(); else $this->datos['informes_usuarios'] = array();
		
		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista_ofertas']=$this->lista_Ofertas;
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
		$resultados = array(); //array multidimensional con la información a mostrar..
		
		//Iteramos sobre los usuarios
		$listaUsuarios = new ListaUsuarios();
		@($this->opt['id_usuario'])?$filtro['id']=$this->opt['id_usuario']:null;
		$listaUsuarios->buscar($filtro);
		while($usuario = $listaUsuarios->siguiente()){
			$resultado_usuario = array(); //resultado para cada usuario
			$total_ofertas_usuario = 0;
			$total_clientes_usuario = 0;
						
			$resultado_usuario['id_usuario'] = $usuario->get_Id();
			
			//Indicamos que vamos a buscar ofertas de este usuario
			$filtros = $this->opt;
			$filtros['id_usuario'] = $usuario->get_Id();
			
			//Iteramos sobre los tipos de oferta
			$listaTiposDeProducto = new ListaTiposDeProducto();
			$listaTiposDeProducto->buscar();
			while($tipoProducto = $listaTiposDeProducto->siguiente()){
				$resultado_tipo_producto = array(); //resultado de cada tipo de oferta
				
				$resultado_tipo_producto['tipo'] = $tipoProducto->get_nombre();
				
				//Indicamos que vamos a buscar ofertas de este tipo
				$filtros['producto'] = $tipoProducto->get_Id();
				$listaOfertas = new ListaOfertas();
				
				$listaOfertas->buscar($filtros);//buscamos con las opciones pasadas (fechas) y con el usuario y el tipo en cuestión.
				
				$array_clientes_ofertas = array();
				while($oferta = $listaOfertas->siguiente()){
					//Ahora tenemos que procesar todas las ofertas encontradas y obtener el número de clientes distintos
					$cliente = $oferta->get_Cliente();
					if(!in_array($cliente->get_Id(),$array_clientes_ofertas))
						$array_clientes_ofertas[] = $cliente->get_Id();
				}
				$num_ofertas = $listaOfertas->num_Resultados();
				$num_clientes = count($array_clientes_ofertas);
				
				$resultado_tipo_producto['num_ofertas'] = $num_ofertas;
				$resultado_tipo_producto['num_clientes'] = $num_clientes;
				
				
				$total_ofertas_usuario += $num_ofertas;
				$total_clientes_usuario += $num_clientes;
								
				$resultado_usuario['informes'][] = $resultado_tipo_producto;
				$resultado_usuario['total_ofertas_usuario'] = $total_ofertas_usuario;
				$resultado_usuario['total_clientes_usuario'] = $total_clientes_usuario;
			}
			$resultados[] = $resultado_usuario;
		}
		
		return $resultados;
	}
	 
}
?>

