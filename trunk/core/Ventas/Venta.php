<?php
/**
 * Clase que gestiona las Ventas.
 */
include_once('../../html/Common/php/utils/utils.php');
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

	//AMPLIACIÓN
	private $fecha_toma_contacto;
	private $fecha_inicio;
	private $fecha_estimada_formacion;
	private $fecha_pago_inicial;

	private $forcem;
	private $plazo_ejecucion;
	private $cuenta_cargo;
	private $observaciones_forma_pago;
	private $nombre_certificadora;
	private $otros_proyectos;
	private $observaciones;

	private $precio_consultoria;
	private $precio_formacion;
	private $pago_inicial;
	private $pago_mensual;
	private $numero_pagos_mensuales;

	private $subvenciones;
	private $certificacion;
	private $presupuesto_aceptado_certificadora;
	
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

			$this->fecha_asignacion_tecnico = $row['fecha_asignacion_tecnico'];
			$this->nombre = $row['nombre'];
			$this->formacion_bonificada =$row['formacion_bonificada'];
			$this->oferta = $row['fk_oferta'];
			$this->fecha_aceptado = $row['fecha_aceptado'];
			$this->fecha_entrada_vigor = $row['fecha_entrada_vigor'];

			$this->fecha_toma_contacto = $row['fecha_toma_contacto'];
			$this->fecha_inicio = $row['fecha_inicio'];
			$this->fecha_pago_inicial = $row['fecha_pago_inicial'];
			$this->fecha_estimada_formacion = $row['fecha_estimada_formacion'];

			$this->forcem = $row['forcem'];
			$this->plazo_ejecucion = $row['plazo_ejecucion'];
			$this->cuenta_cargo = $row['cuenta_cargo'];
			$this->observaciones_forma_pago = $row['observaciones_forma_pago'];
			$this->nombre_certificadora = $row['nombre_certificadora'];
			$this->otros_proyectos = $row['otros_proyectos'];
			$this->observaciones = $row['observaciones'];

			$this->precio_consultoria = $row['precio_consultoria'];
			$this->precio_formacion = $row['precio_formacion'];
			$this->pago_inicial = $row['pago_inicial'];
			$this->pago_mensual = $row['pago_mensual'];
			$this->numero_pagos_mensuales = $row['numero_pagos_mensuales'];

			$this->subvenciones = $row['subvenciones'];
			$this->certificacion = $row['certificacion'];
			$this->presupuesto_aceptado_certificadora = $row['presupuesto_aceptado_certificadora'];

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

	public function get_Fecha_Toma_Contacto(){
		return $this->fecha_toma_contacto;
	}

	public function get_Fecha_Inicio(){
		return $this->fecha_inicio;
	}

	public function get_Fecha_Estimada_Formacion(){
		return $this->fecha_estimada_formacion;
	}

	public function get_Fecha_Pago_Inicial(){
		return $this->fecha_pago_inicial;
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

	public function get_Precio_Consultoria(){
		return $this->precio_consultoria;
	}
	public function get_Precio_Formacion(){
		return $this->precio_formacion;
	}
	public function get_Pago_Mensual(){
		return $this->pago_mensual;
	}
	public function get_Pago_Inicial(){
		return $this->pago_inicial;
	}
	public function get_Numero_Pagos_Mensuales(){
		return $this->numero_pagos_mensuales;
	}
	public function get_Precio_Total(){
		return $this->precio_consultoria+$this->precio_formacion;
	}

	public function get_Plazo_Ejecucion(){
		return $this->plazo_ejecucion;
	}

	public function get_Forcem(){
		return $this->forcem;
	}
	public function get_Cuenta_Cargo(){
		return $this->cuenta_cargo;
	}

	public function get_Observaciones_Forma_Pago(){
		return $this->observaciones_forma_pago;
	}

	public function get_Nombre_Certificadora(){
		return $this->nombre_certificadora;
	}

	public function get_Otros_Proyectos(){
		return $this->otros_proyectos;
	}

	public function get_Observaciones(){
		return $this->observaciones;
	}

	public function get_Subvenciones(){
		return $this->subvenciones;
	}
	public function get_Certificacion(){
		return $this->certificacion;
	}
	public function get_Presupuesto_Aceptado_Certificadora(){
		return $this->presupuesto_aceptado_certificadora;
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
		FB::info($datos,'Venta crear: datos recibidos');
		
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
		if($datos['fecha_aceptado'] == '' || ! isset($datos['fecha_aceptado']))
			$errores .= "<br/>La fecha de aceptado es obligatoria.";

		if(! $datos['tipo_comision'])
			$errores .= "<br/>El tipo de venta es obligatorio.";
		if(! $datos['forma_pago'])
			$errores .= "<br/>La forma de pago es obligatoria.";

		if($datos['fecha_toma_contacto'] == '' || ! isset($datos['fecha_toma_contacto']))
			$errores .= "<br/>La fecha de toma de contacto es obligatoria.";
		if($datos['fecha_inicio'] == '' || ! isset($datos['fecha_inicio']))
			$errores .= "<br/>La fecha de inicio es obligatoria.";
		if($datos['fecha_estimada_formacion'] == '' || ! isset($datos['fecha_estimada_formacion']))
			$errores .= "<br/>La fecha estimada de formaci&oacute;n es obligatoria.";
		if($datos['fecha_pago_inicial'] == '' || ! isset($datos['fecha_pago_inicial']))
			$errores .= "<br/>La fecha de pago inicial es obligatoria.";

		if($datos['fecha_inicio'] > $datos['fecha_estimada_formacion'])
			throw new Exception ('La fecha de inicio ha de ser anterior a la fecha de finalizaci&oacute;n');
					
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
		$campos = "";
		$valores = "";

		if(isset($datos['forcem'])){
			$campos .= ", forcem";
			$valores .= ",'".mysql_real_escape_string(trim($datos['forcem']))."'";
		}
		if(isset($datos['fecha_asignacion_tecnico'])){
			$campos .= ", fecha_asignacion_tecnico";
			$valores .= ",'".mysql_real_escape_string(trim($datos['fecha_asignacion_tecnico']))."'";
		}
		if(isset($datos['plazo_ejecucion'])){
			$campos .= ", plazo_ejecucion";
			$valores .= ",'".mysql_real_escape_string(trim($datos['plazo_ejecucion']))."'";
		}
		if(isset($datos['cuenta_cargo'])){
			$campos .= ", cuenta_cargo";
			$valores .= ",'".mysql_real_escape_string(trim($datos['cuenta_cargo']))."'";
		}
		if(isset($datos['observaciones_forma_pago'])){
			$campos .= ", observaciones_forma_pago";
			$valores .= ",'".mysql_real_escape_string(trim($datos['observaciones_forma_pago']))."'";
		}
		if(isset($datos['nombre_certificadora'])){
			$campos .= ", nombre_certificadora";
			$valores .= ",'".mysql_real_escape_string(trim($datos['nombre_certificadora']))."'";
		}
		if(isset($datos['otros_proyectos'])){
			$campos .= ", otros_proyectos";
			$valores .= ",'".mysql_real_escape_string(trim($datos['otros_proyectos']))."'";
		}
		if(isset($datos['observaciones'])){
			$campos .= ",observaciones ";
			$valores .= ",'".mysql_real_escape_string(trim($datos['observaciones']))."'";
		}
		if(isset($datos['precio_consultoria'])){
			$campos .= ", precio_consultoria";
			$valores .= ",'".trim($datos['precio_consultoria'])."'";
		}
		if(isset($datos['precio_formacion'])){
			$campos .= ",precio_formacion ";
			$valores .= ",'".trim($datos['precio_formacion'])."'";
		}
		if(isset($datos['pago_inicial'])){
			$campos .= ",pago_inicial ";
			$valores .= ",'".trim($datos['pago_inicial'])."'";
		}
		if(isset($datos['pago_mensual'])){
			$campos .= ",pago_mensual ";
			$valores .= ",'".trim($datos['pago_mensual'])."'";
		}
		if(isset($datos['numero_pagos_mensuales'])){
			$campos .= ",numero_pagos_mensuales ";
			$valores .= ",'".trim($datos['numero_pagos_mensuales'])."'";
		}
		if(isset($datos['subvenciones'])){
			$campos .= ",subvenciones ";
			$valores .= ",'".trim($datos['subvenciones'])."'";
		}
		if(isset($datos['certificacion'])){
			$campos .= ", certificacion";
			$valores .= ",'".trim($datos['certificacion'])."'";
		}
		if(isset($datos['presupuesto_aceptado_certificadora'])){
			$campos .= ", presupuesto_aceptado_certificadora";
			$valores .= ",'".trim($datos['presupuesto_aceptado_certificadora'])."'";
		}

		$query = "
			INSERT INTO ventas (   nombre,
						formacion_bonificada,
						fk_forma_pago,
						fk_tipo_comision,
						fk_oferta,
						fecha_aceptado,
						fecha_entrada_vigor,
						fecha_toma_contacto,
						fecha_inicio,
						fecha_estimada_formacion,
						fecha_pago_inicial
						$campos
						
					)VALUES(
						'".mysql_real_escape_string(trim($datos['nombre']))."',
						'".trim($datos['formacion_bonificada'])."',
						'".trim($datos['forma_pago'])."',
						'".trim($datos['tipo_comision'])."',
						'".trim($datos['id_oferta'])."',
						'".trim($datos['fecha_aceptado'])."',
						'".trim($datos['fecha_entrada_vigor'])."',
						'".trim($datos['fecha_toma_contacto'])."',
						'".trim($datos['fecha_inicio'])."',
						'".trim($datos['fecha_estimada_formacion'])."',
						'".trim($datos['fecha_pago_inicial'])."'
						$valores
					);
		";
			FB::error($query,'Venta crear: QUERY');
			if(!mysql_query($query))
				throw new Exception("Error al crear la Venta. ".$query);
			$this->id = mysql_insert_id();
			
			for($i=1;$i<=12;$i++){
				if($datos['plazos'][$i])
					$this->add_Plazo($datos['plazos'][$i],$datos['estados'][$i]);		
			}
			//Aceptamos la oferta asociada y hacemos al cliente "Cliente definitivo"
			$oferta = new Oferta($datos['id_oferta']);
			$oferta->set_Estado(2);
			
			$cliente = $oferta->get_Cliente();
			$cliente->set_Tipo(2);

			//Por último creamos el proyecto asociado
			$datosProyecto['id_venta'] = $this->id;
			$proyecto = new Proyecto();
			$proyecto->crear($datosProyecto);
			
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
	public function set_Fecha_Toma_Contacto($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_toma_contacto='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha_toma_contacto = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	public function set_Fecha_Inicio($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_inicio='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha_inicio = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}

	public function set_Fecha_Estimada_Formacion($fecha){

		if(is_numeric($fecha)){
			$query = "UPDATE ventas SET fecha_estimada_formacion='$fecha' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la fecha en la BBDD.");
			$this->fecha_estimada_formacion = $fecha;

		}else
		throw new Exception("Debe introducir una fecha v&aacute;lida.");
	}
	/**
	 * Modifica la Fecha de asignaci�n a t�cnico
	 * @param int $fecha nueva fecha 
	 */
	public function set_Fecha_Asignacion_Tecnico($fecha){

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
		throw new Exception("Debe introducir un tipo v&aacute;lido.");
	}

	public function set_Forcem($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET forcem='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la descripci&oacute;n en la BBDD.");
			$this->forcem = $texto;

		}else
		throw new Exception("El campo forcem es inv&aacute;lido.");
	}

	public function set_Observaciones($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET observaciones='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar las observaciones en la BBDD.");
			$this->observaciones = $texto;

		}else
		throw new Exception("El campo observaciones es inv&aacute;lido.");
	}
	public function set_Plazo_Ejecucion($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET plazo_ejecucion='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el plazo de ejecuci&oacute;n en la BBDD.");
			$this->plazo_ejecucion = $texto;

		}else
		throw new Exception("El campo plazo de ejecuci&oacute;n es inv&aacute;lido.");
	}
	public function set_Cuenta_Cargo($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET cuenta_cargo='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la cuenta de cargo en la BBDD.");
			$this->forcem = $texto;

		}else
		throw new Exception("El campo cuenta de cargo es inv&aacute;lido.");
	}
	public function set_Observaciones_Forma_Pago($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET observaciones_forma_pago='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar las observaciones de la forma de pago en la BBDD.");
			$this->forcem = $texto;

		}else
		throw new Exception("El campo observaciones de la forma de pago es inv&aacute;lido.");
	}
	public function set_Nombre_Certificadora($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET nombre_certificadora='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el nombre de la certificadora en la BBDD.");
			$this->nombre_certificadora = $texto;

		}else
		throw new Exception("El campo forcem es inv&aacute;lido.");
	}
	public function set_otros_proyectos($texto){
		$validar = new Validador();
		if(($validar->cadena($texto))){
			$query = "UPDATE ventas SET otros_proyectos='$texto' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar los proyectos en la BBDD.");
			$this->otros_proyectos = $texto;

		}else
		throw new Exception("El campo otros proyectos es inv&aacute;lido.");
	}

	public function set_Precio_Consultoria($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET precio_consultoria='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el precio de consultor&iacute;a en la BBDD.");
			$this->precio_consultoria = $valor;

		}else
		throw new Exception("Debe introducir un precio v&aacute;lida.");
	}

	public function set_Precio_Formacion($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET precio_formacion='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el precio de formaci&oacute;n en la BBDD.");
			$this->precio_formacion = $valor;

		}else
		throw new Exception("Debe introducir un precio v&aacute;lido.");
	}
	public function set_Pago_Inicial($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET pago_inicial='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el pago inicial en la BBDD.");
			$this->pago_inicial = $valor;

		}else
		throw new Exception("Debe introducir un pago v&aacute;lido.");
	}
	public function set_Pago_Mensual($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET pago_mensual='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el pago mensual en la BBDD.");
			$this->pago_mensual = $valor;

		}else
		throw new Exception("Debe introducir un pago mensual v&aacute;lido.");
	}
	
	public function set_Numero_Pagos_Mensuales($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET numero_pagos_mensuales='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el n&uacute;mero de pagos mensuales en la BBDD.");
			$this->numero_pagos_mensuales = $valor;

		}else
		throw new Exception("Debe introducir un n&uacute;mero de pagos mensuales  v&aacute;lido.");
	}
	public function set_Presupuesto_Aceptado_Certificadora($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET presupuesto_aceptado_certificadora='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el presupuesto aceptado de certificadora en la BBDD.");

			$this->presupuesto_aceptado_certificadora = $valor;

		}else
		throw new Exception("Debe introducir un valor v&aacute;lido.");
	}
	public function set_Subvenciones($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET subvenciones='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar las subvenciones en la BBDD.");

			$this->subvenciones = $valor;

		}else
		throw new Exception("Debe introducir un valor de subvenciones v&aacute;lido.");
	}
	public function set_Certificacion($valor){

		if(is_numeric($valor)){
			$query = "UPDATE ventas SET certificacion='$valor' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la certificacion en la BBDD.");

			$this->certificacion = $valor;

		}else
		throw new Exception("Debe introducir una certificacion v&aacute;lida.");
	}

	public function del_Venta(){
		$query = "DELETE FROM ventas WHERE id='$this->id';";
		mysql_query($query);		
	}

	public function get_Proyecto(){
		//devuelve el proyecto asociado
		$listaProyectos = new ListaProyectos();
		$filtros['id_venta'] = $this->id;
		$listaProyectos->buscar($filtros);

		return $listaProyectos->siguiente();
	}
}
?>
