<?php include ('../appRoot.php');

class ImprimirFacturaPDF{

	/**
	 * Array que contendrá las opciones pasadas al constructor para que sean
	 * accesibles desde fuera de la clase.
	 *
	 * @var mixed
	 */
	public $opt = array();

	/**
	 * Array que contendrá los datos de la BBDD necesarios para mostrar opciones
	 * en la interfaz.
	 *
	 * @var mixed
	 */
	public $datos = array();

	/**
	 * Instancia de la clase de acceso a datos de las de los usuarios.
	 *
	 * @var object
	 */
	private $DB_Facturas;	
	
	public $Factura;
	/**
	 * Constructor de la clase.
	 * 
	 * Inicializa los objetos de acceso a datos, las clases necesarias, y los arrays con opciones
	 * y datos útiles para la interfaz.
	 * 
	 * @param $opciones Array con los parámetros pasados a la interfaz.
	 */
	public function __construct($opciones){
		//FB::info($opciones, 'opciones pasadas a control de facturas');
		try{
			//Obteniendo opciones pasadas a la página:
			$this->obtenerOpciones($opciones);

			//Obteniendo datos
			$this->obtenerDatos();
			$this->Factura = new Factura($this->opt['id_factura']);
		
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * Establece las variables en el array $opt a partir de las pasadas como parámetros.
	 * 
	 * @param string $opciones Array de opciones.
	 */
	private function obtenerOpciones($opciones){
		
		//Establecer atributos según las opciones pasadas...
		($opciones['id_factura'])?$this->opt['id_factura']=$opciones['id_factura']:null;
	}
	
	/**
	 *	Obtiene los datos de la BBDD para los recorridos
	 */
	private function obtenerDatos(){
	}
	
}
?>