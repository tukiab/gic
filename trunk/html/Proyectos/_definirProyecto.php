<?php
include ('../appRoot.php');


class DefinirProyecto{
	
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
	public $ListaProyectos;
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
		try{
			$this->gestor = new Usuario($_SESSION['usuario_login']);
			
			$this->obtenerOpciones($opciones);
			$this->obtenerDatos();

			if($this->opt['id_plantilla'])
				$this->cargar_Plantilla();
			else if($opciones['guardar'])
				$this->definir_Proyecto();			

		}catch(Exception $e){
			$this->msg= $e->getMessage();
		}
	}
		
	private function obtenerOpciones($opciones){
		$this->opt = array();
		($opciones['id'])?$this->opt['id'] = $opciones['id']:null;
		$this->Proyecto = new Proyecto($this->opt['id']);

		(isset($opciones['nombre']))?$this->opt['nombre'] = $opciones['nombre']:$this->opt['nombre'] = $this->Proyecto->get_Nombre();
		(isset($opciones['horas_documentacion']))?$this->opt['horas_documentacion'] = $opciones['horas_documentacion']:$this->opt['horas_documentacion'] = $this->Proyecto->get_Horas_Documentacion();
		(isset($opciones['horas_auditoria_interna']))?$this->opt['horas_auditoria_interna'] = $opciones['horas_auditoria_interna']:$this->opt['horas_auditoria_interna'] = $this->Proyecto->get_Horas_Auditoria_Interna();
		(isset($opciones['horas_desplazamiento_auditoria_interna']))?$this->opt['horas_desplazamiento_auditoria_interna'] = $opciones['horas_desplazamiento_auditoria_interna']:$this->opt['horas_desplazamiento_auditoria_interna'] = $this->Proyecto->get_Horas_Desplazamiento_Auditoria_Interna();
		(isset($opciones['horas_auditoria_externa']))?$this->opt['horas_auditoria_externa'] = $opciones['horas_auditoria_externa']:$this->opt['horas_auditoria_externa'] = $this->Proyecto->get_Horas_Auditoria_Externa();
		(isset($opciones['horas_desplazamiento_auditoria_externa']))?$this->opt['horas_desplazamiento_auditoria_externa'] = $opciones['horas_desplazamiento_auditoria_externa']:$this->opt['horas_desplazamiento_auditoria_externa'] = $this->Proyecto->get_Horas_Desplazamiento_Auditoria_externa();
		(isset($opciones['es_plantilla']))?$this->opt['es_plantilla'] = $opciones['es_plantilla']:null;

		(isset($opciones['fecha_inicio']))?$this->opt['fecha_inicio'] = date2timestamp($opciones['fecha_inicio']):$this->opt['fecha_inicio'] = $this->Proyecto->get_Fecha_Inicio();
		(isset($opciones['fecha_fin']))?$this->opt['fecha_fin'] = date2timestamp($opciones['fecha_fin']):$this->opt['fecha_fin'] = $this->Proyecto->get_Fecha_Fin();

		(isset($opciones['id_plantilla']))?$this->opt['id_plantilla'] = $opciones['id_plantilla']:null;

		$cliente = $this->Proyecto->get_Cliente();$Cliente= new Cliente($cliente['id']);
			foreach($Cliente->get_Lista_Sedes() as $sede){
				$definicion_sede = $this->Proyecto->get_Definicion_Sede($sede->get_Id());
				(isset($opciones['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento']))?$this->opt['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento']=$opciones['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento']:$this->opt['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento']=$definicion_sede['horas_desplazamiento'];
				(isset($opciones['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita']))?$this->opt['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita']=$opciones['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita']:$this->opt['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita']=$definicion_sede['horas_cada_visita'];
				(isset($opciones['definicion_sedes_'.$sede->get_Id().'_numero_visitas']))?$this->opt['definicion_sedes_'.$sede->get_Id().'_numero_visitas']=$opciones['definicion_sedes_'.$sede->get_Id().'_numero_visitas']:$this->opt['definicion_sedes_'.$sede->get_Id().'_numero_visitas']=$definicion_sede['numero_visitas'];
				(isset($opciones['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos']))?$this->opt['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos']=$opciones['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos']:$this->opt['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos']=$definicion_sede['gastos_incurridos'];
			}
	}
	
	private function definir_Proyecto(){
		
		$this->Proyecto->definir($this->opt);
		//Redirigimos al proyecto
		header('Location: showProyecto.php?id='.$this->Proyecto->get_Id());
	}

	/**
	 * Datos a mostrar en la interfaz.
	 * - Proyectos que son plantillas
	 */
	private function obtenerDatos(){
		$this->ListaProyectos = new ListaProyectos();
		$filtros['es_plantilla'] = 1;

		$this->ListaProyectos->buscar($filtros);
	}

	/**
	 * Copia la definición de un proyecto en los parámetros de definición del proyecto
	 *
	 * Copia primero la definición de cada sede, y posteriormente los datos independientes de las sedes
	 */
	private function cargar_Plantilla(){
		$plantilla = new Proyecto($this->opt['id_plantilla']);

		$cpl = $plantilla->get_Cliente();
		$cliente_plantilla = new Cliente($cpl['id']);
		$sedes_plantilla = $cliente_plantilla->get_Lista_Sedes();

		$cpr = $this->Proyecto->get_Cliente();
		$cliente_proyecto = new Cliente($cpr['id']);
		$sedes_proyecto = $cliente_proyecto->get_Lista_Sedes();

		if(count($sedes_plantilla) != count($sedes_proyecto))
			throw new Exception("La plantilla elegida y el proyecto no tienen el mismo número de sedes");
		
		$definicion_sedes_plantilla = $plantilla->get_Definicion_Sedes();
		for($i=0; $i<count($sedes_plantilla);$i++){
			$sede_plantilla = $sedes_plantilla[$i];
			$sede_proyecto = $sedes_proyecto[$i];

			$this->opt['definicion_sedes_'.$sede_proyecto->get_Id().'_horas_desplazamiento'] = $definicion_sedes_plantilla[$sede_plantilla->get_Id()]['horas_desplazamiento'];
			$this->opt['definicion_sedes_'.$sede_proyecto->get_Id().'_horas_cada_visita']	 = $definicion_sedes_plantilla[$sede_plantilla->get_Id()]['horas_cada_visita'];
			$this->opt['definicion_sedes_'.$sede_proyecto->get_Id().'_numero_visitas']		 = $definicion_sedes_plantilla[$sede_plantilla->get_Id()]['numero_visitas'];
			$this->opt['definicion_sedes_'.$sede_proyecto->get_Id().'_gastos_incurridos']	 = $definicion_sedes_plantilla[$sede_plantilla->get_Id()]['gastos_incurridos'];
		}

		$this->opt['nombre'] = $plantilla->get_Nombre();
		$this->opt['horas_documentacion'] = $plantilla->get_Horas_Documentacion();
		$this->opt['horas_auditoria_interna'] = $plantilla->get_Horas_Auditoria_Interna();
		$this->opt['horas_desplazamiento_auditoria_interna'] = $plantilla->get_Horas_Desplazamiento_Auditoria_Interna();
		$this->opt['horas_auditoria_externa'] = $plantilla->get_Horas_Auditoria_Externa();
		$this->opt['horas_desplazamiento_auditoria_externa'] = $plantilla->get_Horas_Desplazamiento_Auditoria_Externa();
		$this->opt['es_plantilla'] = false;
	}
}
?>