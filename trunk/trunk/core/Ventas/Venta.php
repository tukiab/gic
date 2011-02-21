<?php
/**
 * Clase que gestiona las Ventas.
 */
include_once('../../html/Utils/utils.php');
class Venta{

	/**
	 * Identificador de la Venta. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;
	
	/**
	 * Nombre del alumno
	 * @var string
	 */
	private $nombre;

	/**
	 * forma de pago de la Venta
	 * @var array indexado por id y nombre
	 */
	private $forma_pago;

	/**
	 * formacion_bonificada que realiza la venta.
	 * @var string con el id del formacion_bonificada
	 */
	private $formacion_bonificada;

	/**
	 * oferta asociado a la venta.
	 * @var integer id del oferta
	 */
	private $oferta;
	
	/**
	 * tipo_comision asociado a la venta.
	 * @var integer id del tipo_comision
	 */
	private $tipo_comision;
	
	/**
	 * Fecha de asignaci�n a t�cnico en formato timestamp.
	 * @var integer
	 */
	private $fecha_asignacion_tecnico;

	/**
	 * fecha_aceptado de la venta
	 * @var integer
	 */
	private $fecha_aceptado;
	
	/**
	 * Probabilidad de contratación.
	 * @var integer
	 */
	private $fecha_entrada_vigor;
	
	private $plazos;	
	
	private $cliente;

	private $factura;
	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Venta.
	 *
	 * Si recibe un identificador válido, se carga la Venta de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar una Venta nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_venta Id de la Venta. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para la Venta en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Venta válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT ventas.*
						FROM ventas
						WHERE ventas.id = '$this->id'";
			//FB::info($query,'Venta->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar la Venta de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado la Venta en la BBDD".$query);

			$row = mysql_fetch_array($result);

			$this->nombre = $row['nombre'];
			
			$this->fecha_asignacion_tecnico = $row['fecha_asignacion_tecnico'];
			$this->nombre = $row['nombre'];
			$this->formacion_bonificada =$row['formacion_bonificada'];
			$this->oferta = $row['fk_oferta'];
			$this->fecha_aceptado = $row['fecha_aceptado'];
			$this->fecha_entrada_vigor = $row['fecha_entrada_vigor'];
			
			$oferta = new Oferta($this->oferta);
			$this->Oferta = $oferta;
			$cliente = $oferta->get_Cliente();
			$this->cliente = $cliente->get_Id();
			
			$q = "SELECT * FROM tipos_comision WHERE id = '".$row['fk_tipo_comision']."'";
			$rs = mysql_query($q);
			$this->tipo_comision = mysql_fetch_array($rs);;
			
			$q = "SELECT * FROM formas_de_pago WHERE id = '".$row['fk_forma_pago']."'";
			$rs = mysql_query($q);
			$this->forma_pago = mysql_fetch_array($rs);
			
						
			$this->cargar_Plazos();
			$this->cargar_Factura();

		}
	}
	private function cargar_Plazos(){
		$query = "SELECT * FROM ventas_plazos WHERE fk_venta = '$this->id'";
		$rs = mysql_query($query);
		while($row = mysql_fetch_array($rs))
			$this->plazos[] = $row;
	}
	
	private function cargar_Factura(){
		$query = "SELECT id FROM facturas WHERE fk_venta = '$this->id' limit 1;";
		$rs = mysql_query($query);
		if($row = mysql_fetch_array($rs))
			$this->factura = $row['id'];
	}

	/*
	 * Métodos observadores.
	 ***********************/

	public function get_Cliente(){
		return new Cliente($this->cliente);
		
	}
	
	public function get_Factura(){
		if($this->factura)
			return new Factura($this->factura);
		return null;
	}
	/**
	 * Devuelve la Fecha de asignaci�n a t�cnico
	 * @return int $fecha
	 */
	public function get_Fecha_Asignacion_Tecnico(){
		return $this->fecha_asignacion_tecnico;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve el nombre del contacto/alumno
	 * @return string $nombre
	 */
	public function get_Nombre(){
		return $this->nombre;
	}

	public function get_Nombre_Venta(){
		$oferta = $this->get_Oferta();
		return $oferta->get_Nombre_Oferta();
	}
	/**
	 * Devuelveformacion_bonificada
	 * @return int $formacion_bonificada
	 */
	public function get_Formacion_Bonificada(){
		return $this->formacion_bonificada;
	}

	/**
	 * Devuelve el forma de pago de venta
	 * @return array $forma_pago indexado por id y nombre
	 */
	public function get_Forma_Pago(){
		return $this->forma_pago;
	}

	/**
	 * Devuelve el oferta
	 * @return oferta $oferta 
	 */
	public function get_Oferta(){
		return $this->Oferta;
	}

	public function get_Producto(){
		$oferta = $this->get_Oferta();
		return $oferta->get_Producto();
	}

	public function get_Importe(){
		$oferta = $this->get_Oferta();
		return $oferta->get_Importe();
	}
	public function get_Fecha_Aceptado(){
		return $this->fecha_aceptado;
	}
	
	public function get_Fecha_Entrada_Vigor(){
		return $this->fecha_entrada_vigor;
	}
	public function get_Plazos(){
		return $this->plazos;
	}
        /**
         * Devuelve el tipo de comisión. Array indexado por id y nombre
         * @return <type>
         */
	public function get_Tipo_Comision(){
		return $this->tipo_comision;
	}

	public function get_Codigo(){
		return $this->Oferta->get_Codigo();
	}

	public function get_Usuario(){
		return $this->Oferta->get_Usuario();
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea una nueva Venta en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al método privado guardar(), que devolverá el id asignado por el gestor de BBDD,
	 * que a su vez será el devuelto por éste método.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para una nueva Venta.
	 * @return integer $id_venta Id del nuevo Venta.
	 */
	public function crear($datos){
		//FB::info($datos,'Venta crear: datos recibidos');
		
		$validar = new Validador();
		$ListaVentas = new ListaVentas();
				
		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['id_oferta'] == '' || ! isset($datos['id_oferta']))
			$errores .= "<br/>No se ha indicado la oferta.";
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			$errores .= "<br/>El nombre es obligatorio.";
		if($datos['fecha_entrada_vigor'] == '' || ! isset($datos['fecha_entrada_vigor']))
			$errores .= "<br/>La fecha de entrada en vigor es obligatoria.";
		
			
		if($errores != '') throw new Exception($errores);
		//Si todo ha ido bien:
		return $this->guardar($datos);
	}

	/**
	 * Método privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * venta, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de una venta.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
		//FB::info($datos, 'datos al crear Venta');
		
		$query = "
			INSERT INTO ventas (   nombre,
						formacion_bonificada,
						fk_forma_pago,
						fk_tipo_comision,
						fk_oferta,
						fecha_aceptado,
						fecha_entrada_vigor,
						fecha_asignacion_tecnico
						
					)VALUES(
						'".mysql_real_escape_string(trim($datos['nombre']))."',
						'".trim($datos['formacion_bonificada'])."',
						'".trim($datos['forma_pago'])."',
						'".trim($datos['tipo_comision'])."',
						'".trim($datos['id_oferta'])."',
						'".time()."',
						'".trim($datos['fecha_entrada_vigor'])."',
						'".trim($datos['fecha_asignacion_tecnico'])."'
					);
		";
			//FB::info($query,'Venta crear: QUERY');
			if(!mysql_query($query))
				throw new Exception("Error al crear la Venta. ");
			$this->id = mysql_insert_id();
			
			for($i=1;$i<=12;$i++){
				if($datos['plazos'][$i])
					$this->add_Plazo($datos['plazos'][$i],$datos['estados'][$i]);		
			}
			//por �ltimo aceptamos la oferta asociada y hacemos al cliente "Cliente definitivo"
			$oferta = new Oferta($datos['id_oferta']);
			$oferta->set_Estado(2);
			
			$cliente = $oferta->get_Cliente();
			$cliente->set_Tipo(2);

                        return $this->id;
	}
	
	public function add_Plazos($plazos,$estados){
		foreach($plazos as $plazo){
			$this->add_Plazo($plazo['']);
		}
	}
	
	public function add_Plazo($plazo,$estado){
		//FB::info($plazo);
			if(count($this->plazos) < 12){
				$q = "INSERT INTO ventas_plazos (fecha, fk_venta, fk_estado) 
							VALUES ('".$plazo."','$this->id', '".$estado."')";
				if(!$rs = mysql_query($q))
					throw new Exception("Ha ocurrido un error al insertar el plazo");
				$this->plazos[] = $plazo;
			}else
				throw new Exception("No se pueden insertar m&aacute;s plazos");
	
	}
	
	/**
	 * Modifica la nombre  de la venta
	 * @param int $nombre nueva nombre 
	 */
	public function set_Nombre($nombre){
		
		
		$validar = new Validador();
		if(($validar->cadena($nombre))){
			$query = "UPDATE ventas SET nombre='$nombre' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->nombre = $nombre;

		}else
		throw new Exception("Debe introducir un nombre v&aacute;lido.");
	}

	/**
	 * Modifica la fecha  de la venta
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha_Aceptado($fecha){
		
			
		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_aceptado='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha_Aceptado = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}
	public function set_Fecha_Entrada_Vigor($fecha){
			
		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_entrada_vigor='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha_entrada_vigor = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}
	/**
	 * Modifica la Fecha de asignaci�n a t�cnico
	 * @param int $fecha nueva fecha 
	 */
	public function set_fecha_Asignacion_Tecnico($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_asignacion_tecnico='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha de la siguiente acci&oacute;n en la BBDD.");
			$this->fecha_asignacion_tecnico = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	/**
	 * Modifica el formacion_bonificada de la venta
	 * @param int $formacion_bonificada nuevo formacion_bonificada
	 */
	public function set_Formacion_Bonificada($formacion_bonificada){

		$Listaformacion_bonificadas = new Listaformacion_bonificadas();
		$array_formacion_bonificadas = $Listaformacion_bonificadas->lista_formacion_bonificadas();

		if(is_numeric($formacion_bonificada) && in_array($formacion_bonificada, array_keys($array_formacion_bonificadas))){
			$query = "UPDATE ventas SET fk_formacion_bonificada='$formacion_bonificada' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el formacion_bonificada en la BBDD.");

			$this->formacion_bonificada = $formacion_bonificada;

		}else
		throw new Exception("Debe introducir un formacion_bonificada v&aacute;lido.");
	}

	/**
	 * Modifica el oferta de la venta
	 * @param int $id_oferta nuevo oferta
	 */
	public function set_Oferta($id_oferta){
	
		$Listaofertas = new Listaofertas();
		$array_ofertas = $Listaofertas->lista_ofertas();

		if(is_numeric($id_oferta) && in_array($id_oferta, array_keys($array_ofertas))){
			$query = "UPDATE ventas SET fk_oferta='$id_oferta' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el oferta en la BBDD.");

			$this->oferta = $id_oferta;

		}else
		throw new Exception("Debe introducir un oferta v&aacute;lido.");
	}

	/**
	 * Modifica el forma de pago de la venta
	 * @param int $id_forma de pago nuevo forma de pago
	 */
	public function set_Forma_De_Pago($id_formaformacion_boni){
		
		if(is_numeric($id_forma)){
			$query = "UPDATE ventas SET fk_forma_pago='$id_forma' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la forma de pago en la BBDD.");

			$query = "SELECT id, nombre FROM formas_de_pago WHERE id= '$id_forma' limit 1;";
			$rs = mysql_query($query);
			$row = mysql_fetch_array($rs);

			$this->forma_pago = array('id'=>$row['id'], 'nombre'=>$row['nombre']);
			
		}else
		throw new Exception("Debe introducir un forma de pago v&aacute;lido.");
	}
	
	public function set_Tipo_Comision($id_tipo_comision){

		if(is_numeric($id_tipo_comision)){
			$query = "UPDATE ventas SET fk_tipo_comision='$id_tipo_comision' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el tipo_comision en la BBDD.");

			$this->tipo_comision = $id_tipo_comision;

		}else
		throw new Exception("Debe introducir un tipo_comision v&aacute;lido.");
	}
	
		
	public function del_Venta(){
		$query = "DELETE FROM ventas WHERE id='$this->id';";
		mysql_query($query);		
	}
	
}
?>
