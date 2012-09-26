<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/Common/php/validar.php");

class EditFactura{
	
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
	 * Instancia de la clase Factura.
	 *
	 * @var object
	 */
	public $Factura;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaFacturas;
	public $gestor;	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	
	public function __construct($opciones){
		//Debugging..
		//FB::log($opciones, '_editar_datos_factura.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['id'] || !is_numeric($opciones['id']))
			exit("No se ha definido un ID de Factura v�lido");

		$this->Factura = new Factura($opciones['id']);
		$this->ListaFacturas = new ListaFacturas();
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosFactura($opciones);

		$this->Factura = new Factura($opciones['id']);
		$this->obtenerDatos();
	}
		
	private function get_Opciones_Factura($opciones){
		$opt = array();
		$opt['id'] = $opciones['id'];
		$opt['estado_factura'] = trim($opciones['estado_factura']);
		
		$opt['producto'] = trim($opciones['producto']);
		$opt['proveedor'] = trim($opciones['proveedor']);
		
		$opt['fecha_pago'] = trim($opciones['fecha_pago']);
		$opt['fecha_facturacion'] = trim($opciones['fecha_facturacion']);
		$opt['base_imponible'] = trim($opciones['base_imponible']);
		$opt['IVA'] = trim($opciones['IVA']);
		$opt['cantidad_pagada'] = trim($opciones['cantidad_pagada']);
		
		return $opt;
	}
	/**
	 * Modifica los datos referentes a la factura, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosFactura($opciones){
		//FB::log($opciones, "Opciones:EditarDatosFactura");		
		//Si se ha pulsado en guardar, comprobamos qué se va a guardar...
		if($opciones['guardar']){
			switch($opciones['edit']){
				case 'factura':
						//Obtener los datos de la factura y enviarlos a la BD
						$datos_factura = $this->get_Opciones_Factura($opciones);
				
						$this->Factura = new Factura($datos_factura['id']);
						try{
							
							$tipo_factura = $this->Factura->get_Estado_Factura();
							if($tipo_factura['id'] != $datos_factura['estado_factura'])
								$this->Factura->set_Estado($datos_factura['estado_factura']);
							
							if($this->Factura->get_Fecha_Pago() != $datos_factura['fecha_pago'])
								$this->Factura->set_Fecha_Pago(date2timestamp($datos_factura['fecha_pago']));
								
							if($this->Factura->get_Base_Imponible() != $datos_factura['base_imponible'])
								$this->Factura->set_Base_Imponible($datos_factura['base_imponible']);					
							if($this->Factura->get_IVA() != $datos_factura['IVA'])
								$this->Factura->set_IVA($datos_factura['IVA']);					
							if($this->Factura->get_Cantidad_Pagada() != $datos_factura['cantidad_pagada'])
								$this->Factura->set_Cantidad_Pagada($datos_factura['cantidad_pagada']);					
							
							if($this->Factura->get_Fecha_Facturacion() != $datos_factura['fecha_facturacion'])
								$this->Factura->set_Fecha_Facturacion(date2timestamp($datos_factura['fecha_facturacion']));
								
							
								$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				$this->Factura->del_Contacto($opciones['eliminar']);
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		//Obteniendo datos para los atributos seleccionables de una lista en la página
		$this->datos['lista_estados'] = $this->ListaFacturas->lista_Estados(true);
		
		$lista_usuarios = new ListaUsuarios();
		$todos_usuarios = $lista_usuarios->buscar();
		$this->datos['lista_gestores'] = $lista_usuarios;
	}
	
	
	
	
}




?>
