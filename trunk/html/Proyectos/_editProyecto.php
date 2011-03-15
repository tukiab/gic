<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/include/validar.php");

class EditProyecto{
	
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
	 * Instancia de la clase Proyecto.
	 *
	 * @var object
	 */
	public $Proyecto;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaProyectos;
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
		//FB::log($opciones, '_editar_datos_proyecto.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['id'] || !is_numeric($opciones['id']))
			exit("No se ha definido un ID de Proyecto valido.php");

		$this->Proyecto = new Proyecto($opciones['id']);
		$this->ListaProyectos = new ListaProyectos();
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosProyecto($opciones);

		$this->Proyecto = new Proyecto($opciones['id']);
		$this->obtenerDatos();
	}
		
	private function get_Opciones_Proyecto($opciones){
		$opt = array();
		$opt['id'] = $opciones['id'];
		$opt['nombre'] = $opciones['nombre'];
		
		$opt['fecha_inicio'] = trim($opciones['fecha_inicio']);
		$opt['fecha_fin'] = trim($opciones['fecha_fin']);

		$opt['observaciones'] = trim($opciones['observaciones']);
		
		return $opt;
	}
	/**
	 * Modifica los datos referentes a la proyecto, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosProyecto($opciones){
		//FB::log($opciones, "Opciones:EditarDatosProyecto");
		//Si se ha pulsado en guardar, comprobamos qué se va a guardar...
		if($opciones['guardar']){
			switch($opciones['edit']){
				case 'proyecto':
						//Obtener los datos de la proyecto y enviarlos a la BD
						$datos_proyecto = $this->get_Opciones_Proyecto($opciones);
				
						$this->Proyecto = new Proyecto($datos_proyecto['id']);
						try{
							if($this->Proyecto->get_Nombre_Proyecto() != $datos['nombre'])
								$this->Proyecto->set_Nombre($datos['nombre']);
							
							if($this->Proyecto->get_Fecha_Inicio() != $datos_proyecto['fecha_inicio'])
								$this->Proyecto->set_Fecha_Inicio(date2timestamp($datos_proyecto['fecha_inicio']));

							if($this->Proyecto->get_Fecha_Fin() != $datos_proyecto['fecha_fin'])
								$this->Proyecto->set_Fecha_Fin(date2timestamp($datos_proyecto['fecha_fin']));
								
							if($this->Proyecto->get_Observaciones() != $datos_proyecto['observaciones'])
								$this->Proyecto->set_Observaciones($datos_proyecto['observaciones']);
							
								$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				$this->Proyecto->del_Contacto($opciones['eliminar']);
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		
	}
}
?>
