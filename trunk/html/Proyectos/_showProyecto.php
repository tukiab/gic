<?php
/**
 * Clase que gestiona las presentación de la información de una Proyecto.
 * 
 */
class ShowProyecto{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
	public $usuario;
	public $Proyecto;
												
	/**
	 * Se obtienen los datos necesarios para mostrar el la interfaz, a partir de los parámetros pasados al 
	 * constructor.
	 * También realiza las funciones de modificación de datos necesarias..
	 * 
	 * @param array $opciones Array de opciones pasados al script. Se corresponde con el array $_GET de la vista.
	 */
	public function __construct($opciones_get, $opciones){
		try{
			global $permisos;
					
			$this->get_Opciones($opciones_get, $opciones);
			$this->get_Datos();
			$this->usuario = new Usuario($_SESSION['usuario_login']);
			
			if($this->opt['eliminar']) $this->eliminar();
			if($this->opt['cerrar']) $this->cerrar();
			if($this->opt['reabrir']) $this->reabrir();
			if($this->opt['asignar']) $this->asignar();
			if($this->opt['planificar']) $this->insertar_visita();
			if($this->opt['tarea_editar']) $this->editar_tarea();
			if($this->opt['visita_editar']) $this->editar_visita();
			if($this->opt['tarea_eliminar']) $this->eliminar_tarea();
			if($this->opt['visita_eliminar']) $this->eliminar_visita();
			
		}catch(Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}
	
	private function eliminar(){
		$this->Proyecto->del_Proyecto($this->opt['borrado_total']);
		header("Location: searchProyectos.php?msg=proyecto borrado");
	}

	private function cerrar(){
		$this->Proyecto->cerrar();
	}

	private function reabrir(){
		$this->Proyecto->reabrir();
	}

	private function asignar(){
		$this->Proyecto->asignar($this->opt['id_usuario']);
		//hay que enviar correo electrónico al técnico en cuestión

		/*$usr = new Usuario($this->opt['id_usuario']);
	
		if($usr->get_Email()!='' && $usr->get_Email()!=null){
			
			$to = $usr->get_Email();
			$subject = 'Nuevo proyecto asignado en GIC';
			$message = 'Le ha sido asignado el proyecto '.$this->Proyecto->get_Nombre().' con identificador '.$this->Proyecto->get_Id().' en GIC. Puede consultarlo con su director.';
			
			mail($to, $subject, $message);
		}*/

	}

	private function insertar_visita(){
		$this->Proyecto->add_Visita($this->opt);
	}
	/**
	 * Obtiene los parámetros necesarios pasados al constructor.
	 * 
	 * @param Array $opciones Array de opciones pasados al constructor.
	 */
	private function get_Opciones($opciones_get, $opciones){

		//Indispensable, el id de la Proyecto:
		@(isset($opciones_get['id'])?$this->opt['id']=$opciones_get['id']:null);
		if(!$this->opt['id'])
			@(isset($opciones['id'])?$this->opt['id']=$opciones['id']:null);
		$Proyecto = new Proyecto($this->opt['id']);
			//Hacemos visible al proyecto fuera de la clase:
			$this->Proyecto = $Proyecto;
		@($opciones['eliminar'])?$this->opt['eliminar']=true:$this->opt['eliminar']=false;
		@($opciones['cerrar'])?$this->opt['cerrar']=true:$this->opt['cerrar']=false;
		@($opciones['reabrir'])?$this->opt['reabrir']=true:$this->opt['reabrir']=false;
		@($opciones['asignar'])?$this->opt['asignar']=true:$this->opt['asignar']=false;
		@($opciones['id_usuario'])?$this->opt['id_usuario']=$opciones['id_usuario']:null;
		@($opciones['borrado_total'])?$this->opt['borrado_total']=true:$this->opt['borrado_total']=false;
		@($opciones['tarea_editar'])?$this->opt['tarea_editar']=$opciones['tarea_editar']:null;
		@($opciones['visita_editar'])?$this->opt['visita_editar']=$opciones['visita_editar']:null;
		@($opciones['tarea_eliminar'])?$this->opt['tarea_eliminar']=$opciones['tarea_eliminar']:null;
		@($opciones['visita_eliminar'])?$this->opt['visita_eliminar']=$opciones['visita_eliminar']:null;

		foreach($this->Proyecto->get_Tareas() as $tarea){
			@($opciones['fecha_tarea_'.$tarea['id']])?$this->opt['fecha_tarea_'.$tarea['id']]=date2timestamp($opciones['fecha_tarea_'.$tarea['id']]):null;
			@($opciones['horas_desplazamiento_tarea_'.$tarea['id']])?$this->opt['horas_desplazamiento_tarea_'.$tarea['id']]=$opciones['horas_desplazamiento_tarea_'.$tarea['id']]:null;
			@($opciones['horas_visita_tarea_'.$tarea['id']])?$this->opt['horas_visita_tarea_'.$tarea['id']]=$opciones['horas_visita_tarea_'.$tarea['id']]:null;
			@($opciones['horas_despacho_tarea_'.$tarea['id']])?$this->opt['horas_despacho_tarea_'.$tarea['id']]=$opciones['horas_despacho_tarea_'.$tarea['id']]:null;
			@($opciones['horas_auditoria_interna_tarea_'.$tarea['id']])?$this->opt['horas_auditoria_interna_tarea_'.$tarea['id']]=$opciones['horas_auditoria_interna_tarea_'.$tarea['id']]:null;
		}

		foreach($this->Proyecto->get_Planificacion() as $planificacion){
			@($opciones['fecha_visita_'.$planificacion['id']])?$this->opt['fecha_visita_'.$planificacion['id']]=date2timestamp($opciones['fecha_visita_'.$planificacion['id']]):null;
			@($opciones['hora_visita_'.$planificacion['id']])?$this->opt['hora_visita_'.$planificacion['id']]=$opciones['hora_visita_'.$planificacion['id']]:null;
		}

		@($opciones['planificar'])?$this->opt['planificar']=$opciones['planificar']:null;
		@($opciones['hora_visita'])?$this->opt['hora_visita']=$opciones['hora_visita']:null;
		@($opciones['fecha_visita'])?$this->opt['fecha_visita']=date2timestamp($opciones['fecha_visita']):null;

		
		//Opciones de si mostrar o no la cabecera de la página:
		@(isset($opciones['head'])?$this->opt['mostrar_cabecera']=false:$this->opt['mostrar_cabecera']=true);
	}

	private function get_Datos(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_tecnicos'] = $listaUsuarios;
	}

	private function editar_tarea(){
		$tarea = new Tarea($this->opt['tarea_editar']);
		$tarea->set_Fecha($this->opt['fecha_tarea_'.$tarea->get_Id()]);
		$tarea->set_Horas_Desplazamiento($this->opt['horas_desplazamiento_tarea_'.$tarea->get_Id()]);
		$tarea->set_Horas_Visita($this->opt['horas_visita_tarea_'.$tarea->get_Id()]);
		$tarea->set_Horas_Despacho($this->opt['horas_despacho_tarea_'.$tarea->get_Id()]);
		$tarea->set_Horas_Auditoria_Interna($this->opt['horas_auditoria_interna_tarea_'.$tarea->get_Id()]);

		//recargamos el proyecto:
		$this->Proyecto = new Proyecto($this->opt['id']);
	}

	private function editar_visita(){
		$visita = new Visita($this->opt['visita_editar']);
		$visita->set_Fecha($this->opt['fecha_visita_'.$visita->get_Id()]);
		$visita->set_Hora($this->opt['hora_visita_'.$visita->get_Id()]);

		//recargamos el proyecto:
		$this->Proyecto = new Proyecto($this->opt['id']);
	}

	private function eliminar_tarea(){
		$tarea = new Tarea($this->opt['tarea_eliminar']);
		$tarea->del_Tarea();

		//recargamos el proyecto:
		$this->Proyecto = new Proyecto($this->opt['id']);
	}

	private function eliminar_visita(){
		$visita = new Visita($this->opt['visita_eliminar']);
		$visita->del_Visita();

		//recargamos el proyecto:
		$this->Proyecto = new Proyecto($this->opt['id']);
	}
}
?>