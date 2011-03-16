<?php
/**
 * Clase que gestiona los Proyectos.
 */
include_once('../../html/Utils/utils.php');
class Proyecto{

	/**
	 * Identificador del Proyecto. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * Id de la venta de la que procede el proyecto, puede ser NULL (proyecto creado desde cero)
	 * @var integer
	 */
	private $id_venta;

	/**
	 * Estado del proyecto
	 * @var <array> indexado por id y nombre
	 */
	private $estado;
	private $id_estado;

	/**
	 * Horas de documentación
	 * @var integer
	 */
	private $horas_documentacion;
	/**
	 * Horas de auditoría interna
	 * @var integer
	 */
	private $horas_auditoria_interna;
	/**
	 * Nombre del proyecto
	 * @var string
	 */
	private $nombre;
	/**
	 * Fecha de inicio del proyecto
	 * @var integer timestamp
	 */
	private $fecha_inicio;
	private $fecha_fin;
	private $observaciones;

	/**
	 * Array con las tareas realizadas en el proyecto.
	 * @var array Indexado por id, fecha, tipo, horas_desplazamiento, horas_visita,
	 * horas_despacho, horas_auditoria_interna, incentivable, id_sede, observaciones, id_usuario, localidad
	 */
	private $tareas;
	/**
	 * Gestor (técnico) que está asignado al proyecto
	 * @var integer
	 */
	private $id_usuario;
	/**
	 * Indica si el proyecto ha sido guardado como plantilla para cargarlo al definir otro nuevo
	 * @var boolean (1 o 0)
	 */
	private $es_plantilla;

	/**
	 * Id del cliente asociado al proyecto - debe coincidir con el de la venta!
	 * @var integer
	 */
	private $id_cliente;
	/**
	 * Indica la definición teórica del proyecto
	 * @var Array de arrays, cada array está indexado por id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos
	 */
	private $definicion_sedes;
	/**
	 * Indica el importe, puede coincidir con el de la venta
	 * @var integer
	 */
	private $importe;
	/*
	 * Métodos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Proyecto.
	 *
	 * Si recibe un identificador válido, se carga el Proyecto de la BBDD mediante el método cargar(), en caso contrario crea un objeto
	 * vacío, permitiendo insertar un Proyecto nuevo mediante el método crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_proyecto Id del Proyecto. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el Proyecto en la BBDD.
	 *
	 * Este método es invocado cuando se le pasa un id de Proyecto válido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT proyectos.*,
							 proyectos_estados.id AS id_estado, proyectos_estados.nombre AS nombre_estado
						FROM proyectos
				    		INNER JOIN proyectos_estados
								ON proyectos.fk_estado = proyectos_estados.id
						WHERE proyectos.id = '$this->id'";
			//FB::info($query,'Proyecto->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar el Proyecto de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado el Proyecto en la BBDD ".$this->id);

			$row = mysql_fetch_array($result);

			$this->id_cliente = $row['fk_cliente'];
			$this->id_venta = $row['fk_venta'];
			$this->horas_documentacion = $row['horas_documentacion'];
			$this->horas_auditoria_interna = $row['horas_auditoria_interna'];
			$this->nombre = $row['nombre'];
			$this->fecha_inicio = $row['fecha_inicio'];
			$this->fecha_fin = $row['fecha_fin'];
			$this->observaciones = $row['observaciones'];
			$this->id_usuario = $row['id_usuario'];
			$this->es_plantilla = $row['es_plantilla'];
			$this->importe = $row['importe'];

			$this->id_estado = $row['id_estado'];
			$this->estado = array('id'=>$row['id_estado'], 'nombre'=>$row['nombre_estado']);
			
			$this->cargar_Definicion();
			$this->cargar_Tareas();
		}
	}


	/**
	 * Carga la definición teórica del proyecto
	 */
	private function cargar_Definicion(){
		$query = "SELECT fk_sede as id_sede, horas_deslazamiento, horas_cada_visita, numero_visitas, gastos_incurridos, clientes_sedes.localidad
					FROM proyectos_rel_sedes
					INNER JOIN clientes_sedes ON proyectos_rel_sedes.fk_sede = clientes_sedes.id
					WHERE fk_proyecto = '$this->id';";

		$result = mysql_query($query);

		$this->definicion_sedes = array();
		while($row = mysql_fetch_array($result))
		$this->definicion_sedes[$row['id_sede']] = $row;
	}

	private function cargar_Tareas(){
		$query = "SELECT id, fecha, fk_tipo as tipo, horas_desplazamiento, horas_visita,
						horas_despacho, horas_auditoria_interna, incentivable, fk_sede as id_sede,
						observaciones, fk_usuario as id_usuario, sedes. localidad
					FROM tareas_tecnicas
					INNER JOIN clientes_sedes ON clientes_sedes.id = tareas_tecnica.fk_sede
					WHERE fk_proyecto = '$this->id';";

		$result = mysql_query($query);

		$this->tareas = array();
		while($row = mysql_fetch_array($result))
		$this->tareas[$row['id']] = $row;
	}


	/*
	 * Métodos observadores.
	 ***********************/

	/**
	 * Identificador del Proyecto. Coincide con el id de la BBDD.
	 * @var integer
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Id de la venta de la que procede el proyecto, puede ser NULL (proyecto creado desde cero)
	 * @var integer
	 */
	public function get_Id_Venta(){
		return $this->id_venta;
	}
	public function get_Venta(){
		return ($this->id_venta)?new Venta ($this->id_venta):null;
	}

	/**
	 * Estado del proyecto
	 * @var <array> indexado por id y nombre
	 */
	public function get_Estado(){
		return $this->estado ;
	}

	/**
	 * Horas de documentación
	 * @var integer
	 */
	public function get_Horas_Documentacion(){return $this->horas_documentacion ;}
	/**
	 * Horas de auditoría interna
	 * @var integer
	 */
	public function get_Horas_Auditoria_Interna(){return $this->horas_auditoria_interna ;}
	/**
	 * Nombre del proyecto
	 * @var string
	 */
	public function get_Nombre(){return $this->nombre ;}
	/**
	 * Fecha de inicio del proyecto
	 * @var integer timestamp
	 */
	public function get_Fecha_Inicio(){return $this->fecha_inicio ;}
	public function get_Fecha_Fin(){return $this->fecha_fin ;}
	public function get_Observaciones(){return $this-> observaciones;}
	/**
	 * Gestor (técnico) que está asignado al proyecto
	 * @var integer
	 */
	public function get_Id_Usuario(){return $this->id_usuario ;}
	public function get_Usuario(){
		return new Usuario($this->id_usuario);
	}
	/**
	 * Indica si el proyecto ha sido guardado como plantilla para cargarlo al definir otro nuevo
	 * @var boolean (1 o 0)
	 */
	public function get_Es_Plantilla(){return $this->es_plantilla ;}

	/**
	 * Id del cliente asociado al proyecto - debe coincidir con el de la venta!
	 * @var integer
	 */
	public function get_Id_Cliente(){return $this->id_cliente ;}
	public function get_Cliente(){
		return new Cliente($this->id_cliente);
	}

	/**
	 * Devuelve el array de tareas
	 * @return array Indexado por id, fecha, tipo, horas_desplazamiento, horas_visita,
	 * horas_despacho, horas_auditoria_interna, incentivable, id_sede, observaciones, id_usuario, localidad
	 *
	 */
	public function get_Tareas(){
		return $this->tareas;
	}
	/**
	 * Indica la definición teórica del proyecto
	 * @var Array indexado por id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos, localidad
	 */
	public function get_Definicion_Sedes(){return $this->definicion_sedes ;}

	/**
	 * Devuelve el importe
	 * @return integer
	 */
	public function get_Precio_Venta(){return $this->importe;}
	// Los siguientes atributos no son sacados de la bbdd, se calculan a partir de los anteriores
	/**
	 * Horas de desplazamiento totales de todas las sedes
	 * @var integer
	 */
	public function get_Horas_Desplazamiento(){
		$cont = 0;
		foreach($this->definicion_sedes as $definicion)
			$cont += $definicion['horas_desplazamiento'];
		
		return $cont;
	}
	/**
	 * Horas de visita totales de todas las sedes
	 * @var integer
	 */
	public function get_Horas_Cada_Visita(){
		$cont = 0;
		foreach($this->definicion_sedes as $definicion)
			$cont += $definicion['horas_cada_visita'];
		
		return $cont;
	}
	/**
	 * Numero de visitas totales de todas las sedes
	 * @var integer
	 */
	public function get_Numero_Visitas(){
		$cont = 0;
		foreach($this->definicion_sedes as $definicion)
			$cont += $definicion['numero_visitas'];
		
		return $cont;
	}
	/**
	 * Gastos incurridos totales de todas las sedes
	 * @var integer
	 */
	public function get_Gastos_Incurridos(){
		$cont = 0;
		foreach($this->definicion_sedes as $definicion)
			$cont += $definicion['gastos_incurridos'];
		
		return $cont;
	}
	/**
	 * Suma de todas las incurridas en todas las sedes
	 * @var <type>
	 */
	public function get_Horas_Totales(){
		return ($this->get_Horas_Documentacion()+$this->get_Horas_Documentacion()+$this->get_Horas_Cada_Visita()*$this->get_Numero_Visitas()+$this->get_Horas_Auditoria_Interna());
	}
	/**
	 * Duración del proyecto
	 * @return timestamp
	 */
	public function get_Duracion(){
		return $this->fecha_fin - $this->fecha_inicio;
	}
	/**
	 * Horas totales / Duración
	 * @var integer
	 */
	public function get_Carga_Trabajo_Mensual(){
		return $this->get_Horas_Totales()/$this->get_Duracion();
	}
	/**
	 * Precio de venta / horas totales
	 * @var <type>
	 */
	public function get_Coste_Horario_Venta(){
		return $this->get_Precio_Venta()/$this->get_Horas_Totales();
	}

	public function get_Unidades(){
		$numero_meses = get_Numero_Meses($this->fecha_inicio, $this->fecha_fin);
		if($this->get_Horas_Totales())
			return $this->get_Horas_Totales()/(8*$numero_meses);
		return 0;
	}

	/*
	 * Métodos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea un nuevo proyecto en la bbdd.
	 * Este método en principio sólo es llamado desde las Ventas, de manera que se crea el proyecto para ser definido más adelante
	 * Es obligatorio indicar el cliente del proyecto. Si viene dada la venta se obtiene el cliente de la venta, si no el cliente tiene que venir como parámetro
	 * @param array $datos
	 */
	public function crear($datos){
		if(isset($datos['id_venta'])){
			$this->id_venta = $datos['id_venta'];
			$venta = new Venta($this->id_venta);
			$cliente = $venta->get_Cliente();
			$this->id_cliente = $cliente->get_Id();
			$this->importe = $venta->get_Importe();
		}else{
			if(!isset($datos['id_cliente']))
				throw new Exception('Debe indicar al menos la Proyecto del proyecto');
			$this->id_venta = null;
			$this->id_cliente = $datos['id_cliente'];
			$this->importe = 0;
		}
		$this->id_estado = 1;

		$query = "INSERT INTO proyectos (fk_venta, fk_cliente, fk_estado) VALUE ('$this->id_venta', '$this->id_cliente', '$this->id_estado' ); ";
		if(!mysql_query($query))
			throw new Exception('Error al crear el nuevo proyecto');

		$this->id = mysql_insert_id();
		$this->estado = $this->cargar_Estado();
		return $this->id;
	}

	private function cargar_Estado(){
		$query = "SELECT * FROM proyectos_estados WHERE id = '$this->estado';";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);

		$this->estado = $row;
	}

	/**
	 * Define un nuevo Proyecto (ya creado en la BBDD) a partir de un array indexado con todos los campos.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para definir un Proyecto.
	 * @return integer $id_proyecto Id del Proyecto.
	 */
	public function definir($datos){
		if($this->id_estado > 1)
			throw new Exception ('El proyecto ya ha sido definido');
		//Comprobando los datos "imprescindibles":
		$errores = '';
		$validar = new Validador();
		if($datos['horas_documentacion'] == '' || ! isset($datos['horas_documentacion']))
			$errores .= "<br/>Proyecto: Campo horas de documentacion obligatorio.";
		else{
			if(is_numeric(trim($datos['horas_documentacion'])))
				$this->horas_documentacion = trim($datos['horas_documentacion']);
			else
				$errores .= '<br/>Proyecto: Campo horas de documentaci&oacute;n inv&aacute;lido';
		}
		if($datos['horas_auditoria_interna'] == '' || ! isset($datos['horas_auditoria_interna']))
			$errores .= "<br/>Proyecto: Campo horas de auditor&iacute;a interna obligatorio.";
		else{
			if(is_numeric(trim($datos['horas_auditoria_interna'])))
				$this->horas_auditoria_interna = trim($datos['horas_auditoria_interna']);
			else
				$errores .= '<br/>Proyecto: Campo horas de auditor&iacute;a interna inv&aacute;lido';
		}
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			$errores .= "<br/>Proyecto: Campo nombre obligatorio.";
		else{
			if($validar->cadena(trim($datos['nombre'])))
				$this->nombre = trim(mysql_escape_string ($datos['nombre']));
			else
				$errores .= '<br/>Proyecto: Campo nombre inv&aacute;lido';
		}
		if($datos['fecha_inicio'] == '' || ! isset($datos['fecha_inicio']))
			$errores .= "<br/>Proyecto: Campo fecha de inicio obligatorio.";
		else{
			if($validar->fecha(trim($datos['fecha_inicio'])))
				$this->fecha_inicio = trim($datos['fecha_inicio']);
			else
				$errores .= '<br/>Proyecto: Campo fecha de inicio inv&aacute;lido';
		}
		if($datos['fecha_fin'] == '' || ! isset($datos['fecha_fin']))
			$errores .= "<br/>Proyecto: Campo fecha de fin obligatorio.";
		else{
			if($validar->fecha(trim($datos['fecha_fin'])))
				$this->fecha_fin = trim($datos['fecha_fin']);
			else
				$errores .= '<br/>Proyecto: Campo fecha de fin inv&aacute;lido';
		}
		//Por último comprobamos si vienen dados los datos de definición para todas las sedes
		$cliente = $this->get_Cliente();
		$sedes = $cliente->get_Sedes();
		foreach($sedes as $id_sede){
			if(!is_numeric(trim($datos['definicion_sedes'][$id_sede]['horas_desplazamiento']) )
				|| !is_numeric(trim($datos['definicion_sedes'][$id_sede]['horas_cada_visita']))
				|| !is_numeric(trim($datos['definicion_sedes'][$id_sede]['numero_visitas']))
				|| !is_numeric(trim($datos['definicion_sedes'][$id_sede]['gastos_incurridos']))){
					 
					$errores .= '<br/>Proyecto: debe definir los datos de definici&oacute;n de todas las sedes de la empresa';
					continue;
			}else{
				//id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos
				$this->definicion_sedes[$id_sede] = array('id_sede' => $id_sede,
															'horas_desplazamiento' => trim($datos['definicion_sedes'][$id_sede]['horas_desplazamiento']),
															'horas_cada_visita' => trim($datos['definicion_sedes'][$id_sede]['horas_cada_visita']),
															'numero_visitas' => trim($datos['definicion_sedes'][$id_sede]['numero_visitas']),
															'gastos_incurridos' => trim($datos['definicion_sedes'][$id_sede]['gastos_incurridos']),);
			}

		}
		
		if($errores != '') throw new Exception($errores);

		//Resto de atributos
		$this->importe = ($datos['importe'] && is_numeric(trim($datos['importe'])))?trim($datos['importe']):$this->importe;
		$this->es_plantilla = (isset($datos['es_plantilla']))?1:0;
		$this->observaciones = trim($datos['observaciones']);
		if(isset($datos['id_usuario'])){
			$this->id_usuario = trim($datos['id_usuario']);
			$this->set_Estado(3); //pendiente de planificación, se acaba de definir y tiene técnico asignado
		}else{
			if($this->id_usuario)
				$this->set_Estado(2); //Pendiente de asignación, está definido pero sin técnico asignado
		}
		$this->cargar_Estado();

		return $this->guardar_Definicion();
	}
	
	/**
	 * Método privado que guarda la definición teórica del proyecto
	 *
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar_Definicion(){
		$query = "UPDATE proyectos 
					SET horas_documentacion = '$this->horas_documentacion',
					SET horas_auditoria_interna = '$this->horas_auditoria_interna',
					SET nombre = '$this->nombre',
					SET fecha_inicio = '$this->fecha_inicio',
					SET fecha_fin = '$this->fecha_fin',
					SET importe = '$this->importe',
					SET es_plantilla = '$this->es_plantilla',
					SET observaciones = '$this->observaciones',
					SET fk_usuario = '$this->id_usuario',
					SET fk_estado = '$this->id_estado'

				WHERE id = '$this->id';";

		if(!mysql_query($query))
			throw new Exception("Error al definir el proyecto.");

		//Ahora guardamos la definición teórica de cada sede: borramos la definición actual e insertamos cada nueva definición
		$this->del_Definicion_Sedes();
		foreach($this->definicion_sedes as $definicion){
			$this->definir_Sede($definicion);
		}

		return $this->id;
	}
	/**
	 * Crea una tarea en la bbdd
	 */
	public function add_Tarea($datos){
		$tarea = new Tarea();
		$datos['id_proyecto'] = $this->id;

		$tarea->crear($datos);
		$this->cargar_Tareas();
	}
	/**
	 * Define una sede dada por un array con todos los campos
	 * @param <type> $definicion
	 */
	private function definir_Sede($definicion){
		if(!$this->existe_Definicion_Sede($definicion['id_sede'])){
			$query = "INSERT INTO proyectos_rel_sedes (horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos)
							VALUES ('".$definicion['horas_desplazamiento']."', '".$definicion['horas_cada_visita']."',
									'".$definicion['numero_visitas']."', '".$definicion['gastos_incurridos']."');";
		}else{
			$query = "UPDATE proyectos_rel_sedes
						SET horas_desplazamiento'".$definicion['horas_desplazamiento']."',
							horas_cada_visita'".$definicion['horas_cada_visita']."',
							numero_visitas'".$definicion['numero_visitas']."',
							gastos_incurridos'".$definicion['gastos_incurridos']."'";
		}

		if(!mysql_query($query))
			throw new Exception("Error al definir el proyecto en las sedes.");
		
	}

	private function existe_Definicion_Sede($id_sede){
		return in_array($id_sede, array_keys($this->definicion_sedes));
	}
	
	public function del_Proyecto(){		
		$query = "DELETE FROM proyectos WHERE id = '$this->id';";
		mysql_query($query);
		$this->del_Definicion_Sedes();
	}
	private function del_Definicion_Sedes(){
		$query = "DELETE FROM proyectos_rel_sedes WHERE fk_proyecto = '$this->id';";
		mysql_query($query);
	}
	private function asignar_Gestor($id){
		if($id){
			if(!$this->id_usuario){
				$query = "UPDATE proyectos set fk_usuario = '$id' WHERE id = '$this->id'";
				if(!mysql_query($query))
					throw new Excepcion("Error al asignar el gestor al proyecto");
				$this->id_usuario = $id;
				$this->set_Estado(3);
			}
		}
	}

	/**
	 * Cambia el estado del proyecto
	 * @param <integer> $id
	 */
	private function set_Estado($id){
		if($this->id_estado < $id){
			$query = "UPDATE proyectos set fk_estado = '$id' WHERE id = '$this->id'";
			if(!mysql_query($query))
				throw new Exception('Error al guardar el estado en la bbdd');
			$this->id_estado = $id;
			$this->cargar_Estado();
		}
	}

	public function cerrar(){
		$this->set_Estado(6);
	}
}
?>
