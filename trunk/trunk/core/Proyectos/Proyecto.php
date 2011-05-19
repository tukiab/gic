<?php
/**
 * Clase que gestiona los Proyectos.
 */
include_once('../../html/Common/php/utils/utils.php');
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
	private $horas_desplazamiento_auditoria_interna;
	private $horas_auditoria_externa;
	private $horas_desplazamiento_auditoria_externa;
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

	/**
	 * Planificación del proyecto realizada por el técnico
	 * @var array indexado por fecha y hora
	 */
	private $planificacion;

	private $planificacion_sedes;

	/**
	 * Indica si el proyecto se puede cerrar
	 * @var boolean (1 o 0)
	 */
	private $cerrar;
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

			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar el Proyecto de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado el Proyecto en la BBDD ".$this->id." ".$query);

			$row = mysql_fetch_array($result);

			$this->id_cliente = $row['fk_cliente'];
			$this->id_venta = $row['fk_venta'];
			$this->horas_documentacion = $row['horas_documentacion'];
			$this->horas_auditoria_interna = $row['horas_auditoria_interna'];
			$this->horas_desplazamiento_auditoria_interna = $row['horas_desplazamiento_auditoria_interna'];
			$this->horas_auditoria_externa = $row['horas_auditoria_externa'];
			$this->horas_desplazamiento_auditoria_externa = $row['horas_desplazamiento_auditoria_externa'];
			$this->nombre = $row['nombre'];
			$this->fecha_inicio = $row['fecha_inicio'];
			$this->fecha_fin = $row['fecha_fin'];
			$this->observaciones = $row['observaciones'];
			$this->id_usuario = $row['fk_usuario'];
			$this->es_plantilla = $row['es_plantilla'];
			$this->importe = $row['importe'];
			$this->cerrar = $row['cerrar'];

			$this->id_estado = $row['id_estado'];
			$this->estado = array('id'=>$row['id_estado'], 'nombre'=>$row['nombre_estado']);
			
			$this->cargar_Definicion();
			$this->cargar_Tareas();
			$this->cargar_Planificacion();
		}
	}


	/**
	 * Carga la definición teórica del proyecto
	 */
	private function cargar_Definicion(){
		$query = "SELECT fk_sede as id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos, clientes_sedes.localidad
					FROM proyectos_rel_sedes
					INNER JOIN clientes_sedes ON proyectos_rel_sedes.fk_sede = clientes_sedes.id
					WHERE fk_proyecto = '$this->id';";

		if(!$result = mysql_query($query))
			throw new Exception('Error al cargar la definici&oacute;n del proyecto'.$query);

		$this->definicion_sedes = array();
		while($row = mysql_fetch_array($result))
		$this->definicion_sedes[$row['id_sede']] = $row;
	}

	private function cargar_Tareas(){
		$query = "SELECT tareas_tecnicas.id, fecha, fk_tipo as tipo, horas_desplazamiento, horas_visita,
						horas_despacho, horas_auditoria_interna, incentivable, fk_sede as id_sede,
						observaciones, fk_usuario as id_usuario, clientes_sedes.localidad
					FROM tareas_tecnicas
					INNER JOIN clientes_sedes ON clientes_sedes.id = tareas_tecnicas.fk_sede
					WHERE fk_proyecto = '$this->id';";

		if(!$result = mysql_query($query))
			throw new Exception('Error al cargar las tareas del proyecto');

		$this->tareas = array();
		while($row = mysql_fetch_array($result))
		$this->tareas[$row['id']] = $row;
	}

	private function cargar_Planificacion(){
		$query = "SELECT visitas.*
					FROM visitas
					WHERE fk_proyecto = '$this->id' AND fk_sede IS NULL ORDER BY fecha, hora"; 

		if(!$result = mysql_query($query))
			throw new Exception('Error al cargar la planificaci&oacute;n del proyecto');

		$this->planificacion = array();
		while($row = mysql_fetch_array($result))
		$this->planificacion[$row['id']] = $row;

		$query = "SELECT visitas.*
					FROM visitas
					WHERE fk_proyecto = '$this->id' AND fk_sede IS NOT NULL ORDER BY fecha, hora";

		if(!$result = mysql_query($query))
			throw new Exception('Error al cargar la planificaci&oacute;n de las sedes del proyecto');

		$this->planificacion_sedes = array();
		while($row = mysql_fetch_array($result))
		$this->planificacion_sedes[$row['id']] = $row;
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
	public function get_Horas_Documentacion_Reales(){
		$count = 0;
		foreach($this->tareas as $tarea){
			if($tarea['tipo'] == 2)
				$count += $tarea['horas_despacho'];
		}

		return $count;
	}
	/**
	 * Horas de auditoría interna
	 * @var integer
	 */
	public function get_Horas_Auditoria_Interna(){return $this->horas_auditoria_interna ;}
	public function get_Horas_Auditoria_Interna_Reales(){
		$count = 0;
		foreach($this->tareas as $tarea){
			if($tarea['tipo'] == 2)
				$count += $tarea['horas_auditoria_interna'];
		}

		return $count;
	}
	public function get_Horas_Desplazamiento_Auditoria_Interna(){return $this->horas_desplazamiento_auditoria_interna ;}
	public function get_Horas_Auditoria_Externa(){return $this->horas_auditoria_externa ;}
	public function get_Horas_Desplazamiento_Auditoria_Externa(){return $this->horas_desplazamiento_auditoria_externa ;}

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
	public function get_Observaciones(){
		if( $this-> observaciones)
			return $this->observaciones;
		
		$venta = new Venta($this->id_venta);
		return $venta->get_Observaciones();
	}
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

	public function get_Cerrar(){
		return $this->cerrar;
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

	public function get_Horas_Remuneradas(){
		return $this->get_Unidades()*8;
	}
	public function get_Horas_Incentivables(){
		$count = 0;
		foreach($this->tareas as $tarea){
			$count += ($tarea['incentivable'])?$tarea['horas_auditoria_interna']+$tarea['horas_despacho']+$tarea['horas_visita']:0;
		}

		return $count;
	}

	public function get_Horas_No_Remuneradas(){
		$count = 0;
		foreach($this->tareas as $tarea){
			$count += ($tarea['incentivable'])?0:$tarea['horas_auditoria_interna']+$tarea['horas_despacho']+$tarea['horas_visita'];
		}

		return $count;
	}

	public function get_Planificacion(){
		return $this->planificacion;
	}
	
	public function get_Planificacion_Sedes(){
		return $this->planificacion_sedes;
	}

	/**
	 * Indica la definición teórica del proyecto
	 * @var Array indexado por id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos, localidad
	 */
	public function get_Definicion_Sedes(){return $this->definicion_sedes ;}

	public function get_Definicion_Sede($id_sede){
		return $this->definicion_sedes[$id_sede];
	}
	/**
	 * Devuelve el importe
	 * @return integer
	 */
	public function get_Precio_Venta(){
		//return $this->importe;
		$venta = $this->get_Venta();
		if($venta)
			return $venta->get_Precio_Total();
		
		return 0;
	}

	// Los siguientes atributos no son sacados de la bbdd, se calculan a partir de los anteriores
	/**
	 * Horas de desplazamiento totales de todas las sedes + las específicas de AI y AE
	 * @var integer
	 */
	public function get_Horas_Desplazamiento(){
		$count = 0;
		foreach($this->definicion_sedes as $definicion)
			$count += $definicion['horas_desplazamiento'];
		
		return $count+$this->get_Horas_Desplazamiento_Auditoria_Externa()+$this->get_Horas_Desplazamiento_Auditoria_Interna();
	}

	public function get_Horas_Desplazamiento_Reales(){
		$count = 0;
		foreach($this->tareas as $tarea)
			$count += $tarea['horas_desplazamiento'];

		return $count;
	}

	/**
	 * Indica si el proyecto está definido
	 * @return <type>
	 */
	public function esta_Definido(){
		return $this->definicion_sedes;
	}
	/**
	 * Horas de visita totales de todas las sedes
	 * @var integer
	 */
	public function get_Horas_Cada_Visita(){
		$count = 0;
		foreach($this->definicion_sedes as $definicion)
			$count += $definicion['horas_cada_visita']*$definicion['numero_visitas'];
		
		return $count;
	}
	/**
	 * Numero de visitas totales de todas las sedes
	 * @var integer
	 */
	public function get_Numero_Visitas(){
		$count = 0;
		foreach($this->definicion_sedes as $definicion)
			$count += $definicion['numero_visitas'];
		
		return $count;
	}
	public function get_Numero_Visitas_Reales(){
		$count = 0;
		foreach($this->tareas as $tarea){
			$count += ($tarea['tipo'] == 1)?1:0;
		}

		return $count;
	}
	/**
	 * Gastos incurridos totales de todas las sedes
	 * @var integer
	 */
	public function get_Gastos_Incurridos(){
		$count = 0;
		foreach($this->definicion_sedes as $definicion)
			$count += $definicion['gastos_incurridos'];
		
		return $count;
	}
	/**
	 * Suma de todas las incurridas en todas las sedes
	 * @var <type>
	 */
	public function get_Horas_Totales(){
		return ($this->get_Horas_Documentacion()+$this->get_Horas_Desplazamiento()+$this->get_Horas_Cada_Visita()+$this->get_Horas_Auditoria_Interna()+$this->get_Horas_Auditoria_Externa());
	}

	public function get_Horas_Totales_Reales(){
		//return ($this->get_Horas_Documentacion_Reales() +$this->get_Horas_Auditoria_Interna_Reales()+$this->get_Horas_Desplazamiento_Reales());

		//cada tarea es un array Indexado por id, fecha, tipo, horas_desplazamiento, horas_visita, horas_despacho,
		//horas_auditoria_interna, incentivable, id_sede, observaciones, id_usuario, localidad
		$count = 0;
		foreach($this->tareas as $tarea){
			$count += $tarea['horas_desplazamiento']+$tarea['horas_visita']+$tarea['horas_despacho']+$tarea['horas_auditoria_interna'];
		}

		return $count;
	}
        
        public function get_Horas_Totales_Reales_Mensual($mes, $year){
	    
	    $fecha_inicio_mes = Fechas::date2timestamp('1/'.$mes.'/'.$year);
	    $fecha_fin_mes = Fechas::date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year);
	    //cada tarea es un array Indexado por id, fecha, tipo, horas_desplazamiento, horas_visita, horas_despacho,
	    //horas_auditoria_interna, incentivable, id_sede, observaciones, id_usuario, localidad
	    $count = 0;
	    foreach($this->tareas as $tarea){
		FB::info(timestamp2date ($tarea['fecha']));
		if($tarea['fecha']>=$fecha_inicio_mes && $tarea['fecha']<=$fecha_fin_mes){
		   FB::error('La sumo en el mes'. $mes);
		    $count += $tarea['horas_desplazamiento']+$tarea['horas_visita']+$tarea['horas_despacho']+$tarea['horas_auditoria_interna'];
		}else FB::error('NO La sumo en el mes'. $mes);
	    }

	    return $count;
	}
	/**
	 * Duración del proyecto en días
	 * @return timestamp
	 */
	public function get_Duracion(){
		return ceil(($this->fecha_fin - $this->fecha_inicio) / (60 * 60 * 24));
	}
	/**
	 * Horas totales / Duración
	 * @var integer
	 */
	public function get_Carga_Trabajo_Mensual(){
		$numero_meses = getNumeroMeses($this->fecha_inicio, $this->fecha_fin);
		if($this->get_Horas_Totales() && getNumeroMeses($this->fecha_inicio, $this->fecha_fin)){
			$num_meses = getNumeroMeses($this->fecha_inicio, $this->fecha_fin);
			return $this->get_Horas_Totales()/$num_meses;
		}
		return 0;
	}
	/**
	 * Precio de venta / horas totales
	 * @var <type>
	 */
	public function get_Coste_Horario_Venta(){
		if($this->get_Horas_Totales())
			return $this->get_Precio_Venta()/$this->get_Horas_Totales();
		return 0;
	}

	public function get_Unidades(){
		if($this->get_Horas_Totales() && getNumeroMeses($this->fecha_inicio, $this->fecha_fin)){
			$num_meses = getNumeroMeses($this->fecha_inicio, $this->fecha_fin);
			return $this->get_Horas_Totales()/(8*$num_meses);
		}
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
			$this->importe = $venta->get_Precio_Total();
			$this->nombre = $venta->get_Nombre_Venta();
			$this->fecha_inicio = $venta->get_Fecha_Inicio();
			$this->id_estado = 1;
			$this->observaciones = $venta->get_Observaciones();
		}else{
			if(!isset($datos['nombre']))
				throw new Exception('Debe indicar el nombre del proyecto');
			if(!isset($datos['fecha_inicio']))
				throw new Exception('Debe indicar la fecha de inicio del proyecto');
			if(isset($datos['fecha_fin']))
			if($datos['fecha_fin'] && ($datos['fecha_inicio'] > $datos['fecha_fin']))
				throw new Exception('La fecha de inicio ha de ser anterior a la de finalizaci&oacute;n');
			$this->nombre = mysql_real_escape_string($datos['nombre']);
			$this->id_venta = null;
			$this->importe = 0;
			$this->fecha_inicio = $datos['fecha_inicio'];
			$this->id_estado = 1;
			$this->observaciones = mysql_real_escape_string($datos['observaciones']);

			if($datos['id_cliente']){
				$this->id_cliente = trim($datos['id_cliente']);
			}
			else{
				//el cliente de este tipo de proyectos es la empresa principal:
				$lista = new ListaClientes();
				$this->id_cliente = $lista->get_Id_Cliente_Principal();
				if(!$this->id_cliente)
					throw new Exception('No se ha definido la empresa usuaria de GIC, contacte con su administrador');
			}

			$value = "";
			$campo="";
			//Se asigna el gestor directamente
			if($datos['id_usuario']){
				$lista = new ListaClientes();
				$this->id_usuario = trim($datos['id_usuario']);				
				$this->estado = 3;
				if($this->id_cliente == $lista->get_Id_Cliente_Principal())
					$this->estado = 4;
			}else throw new Exception('Ha de indicar el t&eacute;cnico asignado al proyecto');
			
			if($datos['fecha_fin']){
				$this->fecha_fin = $datos['fecha_fin'];
				$campo = ', fecha_fin';
				$value = ", '$this->fecha_fin'";
			}
		}

		$this->cerrar = '1'; 
		if(isset($datos['cerrar']))
			$this->cerrar = $datos['cerrar'];		

		$query = "INSERT INTO proyectos (fk_venta, fk_cliente, fk_estado, nombre, fecha_inicio,  cerrar, observaciones $campo)
					VALUE ('$this->id_venta', '$this->id_cliente', '$this->id_estado', '$this->nombre',
								'$this->fecha_inicio', '$this->cerrar', '$this->observaciones' $value); ";
		
		if(!mysql_query($query))
			throw new Exception('Error al crear el nuevo proyecto ');

		$this->id = mysql_insert_id();
		$this->cargar_Estado();

		if($this->id_usuario)
			$this->asignar ($this->id_usuario);
		return $this->id;
	}

	private function cargar_Estado(){
		$query = "SELECT * FROM proyectos_estados WHERE id = '$this->id_estado';";
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
		if($this->id_estado > 3)
			throw new Exception ('El proyecto no se puede redefinir');

		//Comprobando los datos "imprescindibles":
		$errores = '';
		$validar = new Validador();
		/*if($datos['horas_documentacion'] == '' || ! isset($datos['horas_documentacion']))
			$errores .= "<br/>Proyecto: Campo horas de documentacion obligatorio.";
		else{*/
			if(is_numeric(trim($datos['horas_documentacion'])))
				$this->horas_documentacion = trim($datos['horas_documentacion']);
			else
				$this->horas_documentacion = 0;
				//$errores .= '<br/>Proyecto: Campo horas de documentaci&oacute;n inv&aacute;lido';
		/*}
		if($datos['horas_auditoria_interna'] == '' || ! isset($datos['horas_auditoria_interna']))
			$errores .= "<br/>Proyecto: Campo horas de auditor&iacute;a interna obligatorio.";
		else{*/
			if(is_numeric(trim($datos['horas_auditoria_interna'])))
				$this->horas_auditoria_interna = trim($datos['horas_auditoria_interna']);
			else
				$this->horas_auditoria_interna = 0;

			if(is_numeric(trim($datos['horas_desplazamiento_auditoria_interna'])))
				$this->horas_desplazamiento_auditoria_interna = trim($datos['horas_desplazamiento_auditoria_interna']);
			else
				$this->horas_desplazamiento_auditoria_interna = 0;

			if(is_numeric(trim($datos['horas_auditoria_externa'])))
				$this->horas_auditoria_externa = trim($datos['horas_auditoria_externa']);
			else
				$this->horas_auditoria_externa = 0;

			if(is_numeric(trim($datos['horas_desplazamiento_auditoria_externa'])))
				$this->horas_desplazamiento_auditoria_externa = trim($datos['horas_desplazamiento_auditoria_externa']);
			else
				$this->horas_desplazamiento_auditoria_externa = 0;

				//$errores .= '<br/>Proyecto: Campo horas de auditor&iacute;a interna inv&aacute;lido';
		//}
		if($datos['nombre'] == '' || ! isset($datos['nombre']))
			$errores .= "<br/>Proyecto: Campo nombre obligatorio.";
		else{
			if($validar->cadena(trim($datos['nombre'])))
				$this->nombre = trim(mysql_escape_string ($datos['nombre']));
			else
				$errores .= '<br/>Proyecto: Campo nombre inv&aacute;lido';
		}
		/*if($datos['fecha_inicio'] == '' || ! isset($datos['fecha_inicio']))
			$errores .= "<br/>Proyecto: Campo fecha de inicio obligatorio.";
		else{*/
			if(is_numeric(trim($datos['fecha_inicio'])))
				$this->fecha_inicio = trim($datos['fecha_inicio']);
			else
				$errores .= '<br/>Proyecto: Campo fecha de inicio inv&aacute;lido';
		//}
		if($datos['fecha_fin'])
			if(is_numeric(trim($datos['fecha_fin']))){
				$this->fecha_fin = trim($datos['fecha_fin']);
			}else{
				$errores .= '<br/>Proyecto: Campo fecha de fin inv&aacute;lido';
			}
		
		//Por último comprobamos si vienen dados los datos de definición para todas las sedes
		$cliente = $this->get_Cliente();
		$sedes = $cliente->get_Sedes();
		foreach($sedes as $id_sede){
			/*if(!is_numeric(trim($datos['definicion_sedes_'.$id_sede.'_horas_desplazamiento']) )
				|| !is_numeric(trim($datos['definicion_sedes_'.$id_sede.'_horas_cada_visita']))
				|| !is_numeric(trim($datos['definicion_sedes_'.$id_sede.'_numero_visitas']))){
					 
					$errores .= '<br/>Proyecto: debe definir los datos de definici&oacute;n de todas las sedes de la empresa';
					continue;
			}else{*/
				$gastos = 0;
				if(isset($datos['definicion_sedes_'.$id_sede.'_gastos_incurridos']) && is_numeric($datos['definicion_sedes_'.$id_sede.'_gastos_incurridos']))
					$gastos = $datos['definicion_sedes_'.$id_sede.'_gastos_incurridos'];
				
				//id_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos
				$definicion_sedes[$id_sede] = array('id_sede' => $id_sede,
															'horas_desplazamiento' => trim($datos['definicion_sedes_'.$id_sede.'_horas_desplazamiento']),
															'horas_cada_visita' => trim($datos['definicion_sedes_'.$id_sede.'_horas_cada_visita']),
															'numero_visitas' => trim($datos['definicion_sedes_'.$id_sede.'_numero_visitas']),
															'gastos_incurridos' => $gastos);
			//}
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
				$this->set_Estado(3); //pendiente de planificación, se acaba de definir y tiene técnico asignado
			else
				$this->set_Estado(2);//Pendiente de asignación, está definido pero sin técnico asignado
		}
		$this->cargar_Estado();

		return $this->guardar_Definicion($definicion_sedes);
	}
	
	/**
	 * Método privado que guarda la definición teórica del proyecto
	 *
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar_Definicion($definicion_sedes){FB::info($definicion_sedes);
		$query = "UPDATE proyectos 
					SET horas_documentacion = '$this->horas_documentacion',
					horas_auditoria_interna = '$this->horas_auditoria_interna',
					horas_desplazamiento_auditoria_interna = '$this->horas_desplazamiento_auditoria_interna',
					horas_auditoria_externa = '$this->horas_auditoria_externa',
					horas_desplazamiento_auditoria_externa = '$this->horas_desplazamiento_auditoria_externa',
					nombre = '$this->nombre',
					fecha_inicio = '$this->fecha_inicio',
					fecha_fin = '$this->fecha_fin',
					importe = '$this->importe',
					es_plantilla = '$this->es_plantilla',
					observaciones = '$this->observaciones',
					fk_usuario = '$this->id_usuario',
					fk_estado = '$this->id_estado'

				WHERE id = '$this->id';";

		if(!mysql_query($query))
			throw new Exception("Error al definir el proyecto.");

		//Ahora guardamos la definición teórica de cada sede: borramos la definición actual e insertamos cada nueva definición
		$this->del_Definicion_Sedes();
		foreach($definicion_sedes as $definicion){
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
			$query = "INSERT INTO proyectos_rel_sedes (fk_proyecto, fk_sede, horas_desplazamiento, horas_cada_visita, numero_visitas, gastos_incurridos)
							VALUES ('".$this->id."', '".$definicion['id_sede']."',
									'".$definicion['horas_desplazamiento']."', '".$definicion['horas_cada_visita']."',
									'".$definicion['numero_visitas']."', '".$definicion['gastos_incurridos']."');";
		}else{
			$query = "UPDATE proyectos_rel_sedes
						SET horas_desplazamiento = '".$definicion['horas_desplazamiento']."',
							horas_cada_visita = '".$definicion['horas_cada_visita']."',
							numero_visitas = '".$definicion['numero_visitas']."',
							gastos_incurridos = '".$definicion['gastos_incurridos']."'
						WHERE fk_proyecto='$this->id' AND fk_sede = '".$definicion['id_sede']."'";
		}

		if(!mysql_query($query))
			throw new Exception("Error al definir el proyecto en las sedes.");
		
	}

	private function existe_Definicion_Sede($id_sede){
		return in_array($id_sede, array_keys($this->definicion_sedes));
	}

	public function add_Visita($datos){
		$visita = new Visita();
		$datos_visita['fecha'] = $datos['fecha_visita'];
		$datos_visita['hora'] = $datos['hora_visita'];
		$datos_visita['es_visita_interna'] = $datos['es_visita_interna'];
		$datos_visita['id_proyecto'] = $this->id;

		$visita->crear($datos_visita);
		$this->cargar_Planificacion();

		if($this->estado['id'] == 3)//pendiente de planificación
			$this->set_Estado(4);
	}

	public function add_Visita_De_Seguimiento($datos){
		$visita = new Visita();
		$datos_visita['fecha'] = $datos['fecha_visita_seguimiento'];
		$datos_visita['hora'] = $datos['hora_visita_seguimiento'];
		$datos_visita['id_sede'] = $datos['id_sede_visita_seguimiento'];
		$datos_visita['id_proyecto'] = $this->id;

		$visita->crear($datos_visita);
		$this->cargar_Planificacion();

		if($this->estado['id'] == 3)//pendiente de planificación
			$this->set_Estado(4);
	}
	
	public function del_Proyecto(){		
		$query = "DELETE FROM proyectos WHERE id = '$this->id';";
		mysql_query($query);
		$this->del_Definicion_Sedes();

		$query = " DELETE FROM visitas WHERE fk_proyecto='$this->id';";
		mysql_query($query);

		$query = " DELETE FROM tareas_tecnicas WHERE fk_proyecto='$this->id';";
		mysql_query($query);

	}
	private function del_Definicion_Sedes(){
		$query = "DELETE FROM proyectos_rel_sedes WHERE fk_proyecto = '$this->id';";
		mysql_query($query);
		$this->cargar();
	}
	
	/**
	 * Cambia el estado del proyecto
	 * Se puede cambiar el estado del proyecto si está cerrado y se va a abrir o si el estado nuevo es posterior al existente
	 * @param <integer> $id
	 */
	private function set_Estado($id){

		if(($this->estado['id'] == 6 && $id == 4) || $this->id_estado < $id){
			$query = "UPDATE proyectos set fk_estado = '$id' WHERE id = '$this->id'";
			if(!mysql_query($query))
				throw new Exception('Error al guardar el estado en la bbdd');
			$this->id_estado = $id;
			$this->cargar_Estado();
		}
	}

	public function set_Fecha_Inicio($fecha){
		$query = "UPDATE proyectos SET fecha_inicio='$fecha' WHERE id = '$this->id';";
		if(!mysql_query($query))
			throw new Exception('Error al actualizar la fecha de inicio del proyecto');

		$this->fecha_inicio = $fecha;
	}

	public function set_Fecha_Fin($fecha){
		$query = "UPDATE proyectos SET fecha_fin='$fecha' WHERE id = '$this->id';";
		if(!mysql_query($query))
			throw new Exception('Error al actualizar la fecha de finalizaci&oacute;n del proyecto');

		$this->fecha_fin = $fecha;
	}

	public function set_Nombre($nombre){
		if($nombre){
			$query = "UPDATE proyectos SET nombre='".mysql_real_escape_string($nombre)."' WHERE id = '$this->id';";
			if(!mysql_query($query))
				throw new Exception('Error al actualizar el nombre del proyecto');

			$this->nombre = $nombre;
		}
	}

	public function set_Observaciones($nombre){
		$query = "UPDATE proyectos SET observaciones='".mysql_real_escape_string($nombre)."' WHERE id = '$this->id';"; 
		if(!mysql_query($query))
			throw new Exception('Error al actualizar las observaciones del proyecto');

		$this->observaciones = $nombre;
	}

	public function asignar($id_usuario){
		if($this->id_estado == 2){
			$query = "UPDATE proyectos SET fk_usuario = '".trim($id_usuario)."' WHERE id = '$this->id';";
			if(!mysql_query($query))
				throw new Exception('Error al asignar el t&eacute;cnico');

			$this->id_usuario = trim($id_usuario);
			$this->set_Estado(3);

			$usr = new Usuario($this->id_usuario);

			if($usr->get_Email()!='' && $usr->get_Email()!=null){

				$to = $usr->get_Email();
				$subject = 'Nuevo proyecto asignado en GIC';
				$message = 'Le ha sido asignado el proyecto <b>'.$this->get_Nombre().'</b> con identificador <b>'.$this->get_Id().'</b> en GIC. <br/>Puede consultarlo con su director  o accediendo <b><a target="_blank" href="http://'.$_SERVER['HTTP_HOST'].'/gic/html/Proyectos/showProyecto.php?id='.$this->get_Id().'">aqu&iacute;</a></b>.';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				mail($to, $subject, $message, $headers);
			}
		}
	}
	
	public function cerrar(){
		if(!$this->cerrar)
			throw new Exception('Este proyecto no se puede cerrar');
		if(!$this->estado['id'] == 4)//Sólo se cierran proyectos en curso
			throw new Exception('No se puede cerrar un proyecto que no est&eacute; en curso');

		$this->set_Estado(6);
	}

	public function reabrir(){
		if(!$this->estado['id'] == 6)//Sólo se abren proyectos cerrados
			throw new Exception('No se puede reabrir un proyecto que no est&eacute; cerrado');

		$this->set_Estado(4);
	}
}
?>
