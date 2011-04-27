<?php include ('../appRoot.php');

/**
 * Clase encargada de la gestión de los datos para crear una Venta.
 *
 * Establece las listas de valores para las opciones.
 * Si la variable 'guardar' viene definida, gestiona el registro de la Venta.
 */

class AddVenta{
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
	 * Instancia de la clase Venta.
	 *
	 * @var object
	 */
	private $Venta;
	
	/**
	 * Instancia de la clase de acceso a datos para las Ventas.
	 *
	 * @var object
	 */
	private $DB_Venta;
	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	public function __construct($opciones){
	
	try{
		//FB::info($opciones,'addVenta: opciones pasadas');
		//Obtenemos las opciones pasadas al script
		$this->obtenerOpciones($opciones);
		if(!$this->opt['id_oferta'])
			throw new Exception("No se ha definido un id de oferta/oportunidad v&aacute;lido");
		if($this->opt['guardar'])
			$this->guardar();

		//Adquiriendo datos...
		$this->DB_Venta = new ListaVentas();
		$this->obtenerDatos();
	}catch(Exception $e){
		$this->opt['error_msg'] = $e->getMessage();
	}
	}

	/**
	 * Obtiene los parámetros pasados a la página.
	 * 
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	private function obtenerOpciones($opciones){
		//FB::error($opciones,'opciones pasadas');
		//Obteniendo las opciones pasadas
		@(isset($opciones['id_oferta']))?$this->opt['id_oferta']=$opciones['id_oferta']:null;
		$this->opt['Oferta'] = new Oferta($this->opt['id_oferta']);

		@(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:$this->opt['nombre']=$this->opt['Oferta']->get_Nombre_Oferta();
		@(isset($opciones['tipo_comision']))?$this->opt['tipo_comision']=$opciones['tipo_comision']:null;			
		@(isset($opciones['forma_pago']))?$this->opt['forma_pago']=$opciones['forma_pago']:null;
		@(isset($opciones['formacion_bonificada']))?$this->opt['formacion_bonificada']=$opciones['formacion_bonificada']:null;
		@(isset($opciones['fecha_entrada_vigor']))?$this->opt['fecha_entrada_vigor']=date2timestamp($opciones['fecha_entrada_vigor']):$this->opt['fecha_entrada_vigor']=fechaActualTimeStamp();
		@(isset($opciones['fecha_asignacion_tecnico']))?$this->opt['fecha_asignacion_tecnico']=date2timestamp($opciones['fecha_asignacion_tecnico']):$this->opt['fecha_asignacion_tecnico']=fechaActualTimeStamp();
		@(isset($opciones['fecha_aceptado']))?$this->opt['fecha_aceptado']=date2timestamp($opciones['fecha_aceptado']):$this->opt['fecha_aceptado']=fechaActualTimeStamp();

		@(isset($opciones['fecha_toma_contacto']))?$this->opt['fecha_toma_contacto']=date2timestamp($opciones['fecha_toma_contacto']):null;
		@(isset($opciones['fecha_inicio']))?$this->opt['fecha_inicio']=date2timestamp($opciones['fecha_inicio']):null;
		@(isset($opciones['fecha_estimada_formacion']))?$this->opt['fecha_estimada_formacion']=date2timestamp($opciones['fecha_estimada_formacion']):$this->opt['fecha_estimada_formacion']=fechaActualTimeStamp();
		@(isset($opciones['fecha_pago_inicial']))?$this->opt['fecha_pago_inicial']=date2timestamp($opciones['fecha_pago_inicial']):$this->opt['fecha_pago_inicial']=fechaActualTimeStamp();

		@(isset($opciones['forcem']))?$this->opt['forcem']=$opciones['forcem']:null;
		@(isset($opciones['plazo_ejecucion']))?$this->opt['plazo_ejecucion']=$opciones['plazo_ejecucion']:null;
		@(isset($opciones['cuenta_cargo']))?$this->opt['cuenta_cargo']=$opciones['cuenta_cargo']:null;
		@(isset($opciones['observaciones_forma_pago']))?$this->opt['observaciones_forma_pago']=$opciones['observaciones_forma_pago']:null;
		@(isset($opciones['nombre_certificadora']))?$this->opt['nombre_certificadora']=$opciones['nombre_certificadora']:null;
		@(isset($opciones['otros_proyectos']))?$this->opt['otros_proyectos']=$opciones['otros_proyectos']:null;
		@(isset($opciones['observaciones']))?$this->opt['observaciones']=$opciones['observaciones']:null;

		@(isset($opciones['precio_consultoria']))?$this->opt['precio_consultoria']=$opciones['precio_consultoria']:$this->opt['precio_consultoria']=0;
		@(isset($opciones['precio_formacion']))?$this->opt['precio_formacion']=$opciones['precio_formacion']:$this->opt['precio_formacion']=0;
		@(isset($opciones['pago_inicial']))?$this->opt['pago_inicial']=$opciones['pago_inicial']:null;
		@(isset($opciones['pago_mensual']))?$this->opt['pago_mensual']=$opciones['pago_mensual']:null;
		@(isset($opciones['numero_pagos_mensuales']))?$this->opt['numero_pagos_mensuales']=$opciones['numero_pagos_mensuales']:null;

		@(isset($opciones['subvenciones']))?$this->opt['subvenciones']=$opciones['subvenciones']:$this->opt['subvenciones']=0;
		@(isset($opciones['certificacion']))?$this->opt['certificacion']=$opciones['certificacion']:$this->opt['certificacion']=0;
		@(isset($opciones['presupuesto_aceptado_certificadora']))?$this->opt['presupuesto_aceptado_certificadora']=$opciones['presupuesto_aceptado_certificadora']:$this->opt['presupuesto_aceptado_certificadora']=0;
		
		@(isset($opciones['usuario']))?$this->opt['usuario']=$opciones['usuario']:$this->opt['usuario']=$_SESSION['usuario_login'];
		$this->opt['usuario_obj'] = new Usuario($this->opt['usuario']);
		
		for($i=1;$i<=12;$i++){
			@(isset($opciones['plazo'.$i]))?$this->opt['plazos'][$i]=date2timestamp($opciones['plazo'.$i]):null;
			@(isset($opciones['estado_plazo'.$i]))?$this->opt['estados'][$i]=$opciones['estado_plazo'.$i]:null;
		}
		
		isset($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
	}
	/**
	 * Obtiene los datos de la BBDD para los listados en los desplegables.
	 */
	private function obtenerDatos(){
		$this->datos['lista_formas_de_pago'] = $this->DB_Venta->lista_Formas_De_Pago();
		$this->datos['lista_tipos_comision'] = $this->DB_Venta->lista_Tipos_Comision();
		$this->datos['lista_estados_plazos'] = $this->DB_Venta->lista_Estados_Plazos();
	}
	
	/**
	 * Registra el nuevo Venta en la BBDD.
	 *
	 * Si se ha registrado sin errores, redirige a la página showCliente.php. En caso
	 * contrario almacena el mensaje de error en $opt['error_msg'] para ser mostrado en la interfaz.
	 */
	private function guardar(){
		
		//El objeto $Venta elevará excepciones ante errores en los datos
		try{
			$venta = new Venta();
			$id=$venta->crear($this->opt);
            $this->enviar_mail($id);
			//header("Location: showVenta.php?id=$id");
		}catch(Exception $e){
			$this->opt['error_msg']= $e->getMessage();
		}
	}

        private function enviar_mail($id_venta){
            $venta=new Venta($id_venta);
            $listaUsuarios = new ListaUsuarios();
            $filtros['perfiles'] = '(4,6)'; //gerente y dir técnico
            $listaUsuarios->buscar($filtros);

            $oferta = $venta->get_Oferta();
            $cliente=$venta->get_Cliente();
            $producto = $venta->get_Producto();
            $tipo_comision = $venta->get_Tipo_Comision();
            $forma_pago=$venta->get_Forma_Pago();
            if($venta->get_Formacion_Bonificada()) $formacion='SI';else $formacion='NO';
			if($venta->get_Subvenciones()) $subvencion="SI";else $subvencion="NO";
            while($gerente = $listaUsuarios->siguiente()){

                if($gerente->get_Email() != '' && $gerente->get_Email() != null){
                    $to      = $gerente->get_Email();
                    $subject = 'Nueva Venta en GIC';
                    $message = utf8_decode('
<br/>
Se ha producido una nueva venta en GIC.
<br/><br/>
Los datos de la venta son los siguientes:<br/>
Nombre: <b>'.$venta->get_Nombre().'</b>.<br/>
Importe: <b>'.$venta->get_Precio_Total().' euros</b>.<br/>
Empresa: <b>'.$cliente->get_Razon_Social().'</b>.<br/>
Producto: <b>'.$producto['nombre'].'</b>.<br/>
Fecha aceptado: <b>'.  timestamp2date($venta->get_Fecha_Aceptado()).'</b>.<br/>
Fecha de inicio: <b>'.  timestamp2date($venta->get_Fecha_Inicio()).'</b>.<br/>
Formacion bonificada: <b>'.$formacion.'</b>.<br/>
Subvenciones: <b>'.$subvencion.'</b>.<br/>
Otros proyectos incluido: <b>'.$venta->get_Otros_Proyectos().'</b>.<br/>
Gestor: <b>'.$oferta->get_Usuario().'</b>.<br/>
Puede acceder a la venta en GIC con el id de venta <b>'.$venta->get_Id().'</b> o accediendo <b><a target="_blank" href="http://www.'.$_SERVER['HOST'].'/gic/html/Ventas/showVenta.php?id='.$venta->get_Id().'">aqu&iacute;</a></b>');

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    mail($to, $subject, $message, $headers);
                }
            }
           
        }
	
}

?>
