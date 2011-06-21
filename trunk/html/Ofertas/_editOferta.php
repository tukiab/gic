<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/Common/php/validar.php");

class EditOferta{
	
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
	 * Instancia de la clase Oferta.
	 *
	 * @var object
	 */
	public $Oferta;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaOfertas;
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
		//FB::log($opciones, '_editar_datos_oferta.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['id'] || !is_numeric($opciones['id']))
			exit("No se ha definido un ID de Oferta v�lido.php");

		$this->Oferta = new Oferta($opciones['id']);
		$this->ListaOfertas = new ListaOfertas();
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosOferta($opciones);

		$this->Oferta = new Oferta($opciones['id']);
		$this->obtenerDatos();
	}
		
	private function get_Opciones_Oferta($opciones){
		$opt = array();
		$opt['id'] = $opciones['id'];
		$opt['nombre'] = $opciones['nombre'];
		$opt['estado_oferta'] = trim($opciones['estado_oferta']);
		
		$opt['producto'] = trim($opciones['producto']);
		$opt['proveedor'] = trim($opciones['proveedor']);
		
		$opt['fecha'] = trim($opciones['fecha']);
		$opt['importe'] = trim($opciones['importe']);
		$opt['fecha_definicion'] = trim($opciones['fecha_definicion']);
		$opt['probabilidad_contratacion'] = trim($opciones['probabilidad_contratacion']);
		$opt['colaborador'] = trim($opciones['colaborador']);
		
		return $opt;
	}
	/**
	 * Modifica los datos referentes a la oferta, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosOferta($opciones){
		//FB::log($opciones, "Opciones:EditarDatosOferta");		
		//Si se ha pulsado en guardar, comprobamos qué se va a guardar...
		if($opciones['guardar']){
			switch($opciones['edit']){
				case 'oferta':
						//Obtener los datos de la oferta y enviarlos a la BD
						$datos_oferta = $this->get_Opciones_Oferta($opciones);
				
						$this->Oferta = new Oferta($datos_oferta['id']);
						try{
							if($this->Oferta->get_Nombre_Oferta() != $datos_oferta['nombre'])
								$this->Oferta->set_Nombre_Oferta($datos_oferta['nombre']);								
							
							$tipo_oferta = $this->Oferta->get_Estado_Oferta();
							if($tipo_oferta['id'] != $datos_oferta['estado_oferta'])
								$this->Oferta->set_Estado($datos_oferta['estado_oferta']);
							
							$tipo_oferta = $this->Oferta->get_Producto();
							if($tipo_oferta['id'] != $datos_oferta['producto'])
								$this->Oferta->set_Producto($datos_oferta['producto']);
								
							$tipo_oferta = $this->Oferta->get_Proveedor();
							if($tipo_oferta['id'] != $datos_oferta['proveedor'])
								$this->Oferta->set_Proveedor($datos_oferta['proveedor']);

							if($this->Oferta->get_Fecha() != $datos_oferta['fecha'])
								$this->Oferta->set_Fecha(date2timestamp($datos_oferta['fecha']));
								
							if($this->Oferta->get_Importe() != $datos_oferta['importe'])
								$this->Oferta->set_Importe($datos_oferta['importe']);					
							
							if($this->Oferta->get_Fecha_Definicion() != $datos_oferta['fecha_definicion'])
								$this->Oferta->set_Fecha_Definicion(date2timestamp($datos_oferta['fecha_definicion']));
								
							$tipo_oferta = $this->Oferta->get_Probabilidad_Contratacion();
							if($tipo_oferta['id'] != $datos_oferta['probabilidad_contratacion'])
								$this->Oferta->set_Probabilidad_Contratacion($datos_oferta['probabilidad_contratacion']);
								
							$tipo_oferta = $this->Oferta->get_Colaborador();
							if($tipo_oferta['id'] != $datos_oferta['colaborador'])
								$this->Oferta->set_Colaborador($datos_oferta['colaborador']);
							
								$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				$this->Oferta->del_Contacto($opciones['eliminar']);
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		//Obteniendo datos para los atributos seleccionables de una lista en la página
		$this->datos['lista_estados_ofertas'] = $this->ListaOfertas->lista_Estados();
		$this->datos['lista_tipos_productos'] = $this->ListaOfertas->lista_Tipos_Productos();
		$this->datos['lista_probabilidades'] = $this->ListaOfertas->lista_Probabilidades();
		$this->datos['lista_colaboradores'] = $this->ListaOfertas->lista_Colaboradores();
		$this->datos['lista_proveedores'] = $this->ListaOfertas->lista_Proveedores();
		
		$lista_usuarios = new ListaUsuarios();
		$todos_usuarios = $lista_usuarios->buscar();
		$this->datos['lista_gestores'] = $lista_usuarios;
	}
	
	
	
	
}




?>
