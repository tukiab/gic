<?php
 include ('../appRoot.php');
/**
 * Clase encargada de la gestión de la lógica de la creación de informes.
 *
 * Obtiene los datos para los filtros a partir de las opciones pasadas al constructor y establece
 * valores para los desplegables de la interfaz a partir de la BBDD.
 *
 */
class InformeComisiones{


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
	public $lista_Ventas;

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

		$this->lista_Ventas = new ListaVentas();
		//Buscamos los ventas con los parámetros establecidos en la interfaz
		if($this->opt['buscar'] || $this->opt['exportar'])
			$this->buscar();
	}

	private function obtener_Listas(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(1,2,7)'; //comerciales, televendedores y directores comerciales
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_comerciales'] = $listaUsuarios;
	}

	/*
	 *Metodo que filtra y establece los datos que se pasaran a las diferentes clases para instanciar los objetos que se necesiten.
	 *
	 *@param array($opciones)
	 *
	 */

	private function obtener_Opciones($opciones){

		//Asignar opciones según se nos pase desde la interfaz para construir una busqueda.

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

		@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;

		@($opciones['buscar'])?$this->opt['buscar']=$opciones['buscar']:null;
		@($opciones['exportar'])?$this->opt['exportar']=$opciones['exportar']:null;
	}

	private function buscar(){
		$this->opt['fecha_aceptado_desde'] = $this->opt['fecha_desde'];
		$this->opt['fecha_aceptado_hasta'] = $this->opt['fecha_hasta'];

		$this->opt['order'] = ' ofertas.fk_usuario, ventas.fecha_aceptado, ventas.fk_tipo_comision ';

		$this->lista_Ventas->buscar($this->opt);
		$this->obtener_totales();

	}

	/**
	 * Hay que obtener las siguientes sumas:
	 *  - Total importe de ventas por gestor mes y tipo de venta
	 *  - Total importe de ventas por gestor y mes
	 *  - Ventas acumuladas: suma de las ventas desde enero por gestor mes y tipo de venta
	 */
	private function obtener_totales(){

		$totales = array();
		$tipo_anterior = null;
		while($venta=$this->lista_Ventas->siguiente()){
			$mes = date("m",$venta->get_Fecha_Aceptado());
			$mes = (int) $mes;
			$year = date("Y",$venta->get_Fecha_Aceptado());
			$nombre_mes = Fechas::obtenerNombreMes($mes);
			$mes_year = $nombre_mes.'/'.$year;
			$nuevo_mes = ($mes_year != $mes_year_anterior);
			$tipo_comision = $venta->get_Tipo_Comision();
			$tipo_venta = $tipo_comision['nombre'];
			$nuevo_tipo = ($tipo_venta != $tipo_anterior) || $nuevo_mes;

			if($nuevo_tipo){
				$totales[$venta->get_Usuario().$mes_year] += $venta->get_Precio_Total();
				$totales[$venta->get_Usuario().$mes_year.$tipo_venta] += $venta->get_Precio_Total();
				$totales[$venta->get_Usuario().$year.$tipo_venta] += $venta->get_Precio_Total();
			}

			$tipo_anterior = $tipo_venta;
		}
		
		$this->datos['totales'] = $totales;
		$this->lista_Ventas->inicio();
	}

}
?>

