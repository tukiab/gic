<?php
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica de la creación de informes.
 *
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 *
 */
class InformesVentas{


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
	 *Variable auxiliar de uso interno para contener el objeto Lista_Ventas
	 *
	 *@var object
	 *
	 */
	private $lista_Ventas;

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

		//Buscamos los ventas con los parámetros establecidos en la interfaz
		if($this->opt['buscar'] || $this->opt['exportar'])
			$this->buscar();

		//Hacemos accesible esta informacion desde fuera de la clase
		$this->datos['lista_ventas']=$this->lista_Ventas;
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
		@($opciones['exportar'])?$this->opt['exportar']=$opciones['exportar']:null;
	}

	private function buscar(){
		$filtro = "";
		if($this->opt['fecha_desde'])
			$filtro .= " AND ventas.fecha >= '".$this->opt['fecha_desde']."' ";
		if($this->opt['fecha_hasta'])
			$filtro .= " AND ventas.fecha <= '".$this->opt['fecha_hasta']."' ";
		if($this->opt['id_usuario'])
			$filtro .= " AND ventas.fk_usuario = '".$this->opt['id_usuario']."'";

		$query = "SELECT ventas.fecha_aceptado as fecha, ofertas.fk_usuario as usuario,
						ofertas.fk_tipo_producto as tipo, productos_tipos.nombre,
						SUM(ofertas.importe) as importe,
						COUNT(DISTINCT ventas.id) as num_ventas,
						COUNT(DISTINCT ofertas.fk_cliente) as num_clientes
					FROM ventas
					INNER JOIN ofertas
						ON ofertas.id = ventas.fk_oferta
					INNER JOIN productos_tipos
						ON productos_tipos.id = ofertas.fk_tipo_producto
					INNER JOIN clientes
						ON clientes.id = ofertas.fk_cliente
					WHERE 1 $filtro
					GROUP BY usuario, tipo WITH ROLLUP;";

		$result = mysql_query($query);
		$datos = array();
		while($row = mysql_fetch_array($result)){
			$datos[$row['usuario']][] = $row;
		}

		$this->resumen = $datos;
	}

}
?>

