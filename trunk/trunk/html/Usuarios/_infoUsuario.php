<?php
include ('../appRoot.php');

//Acceso a datos
include_once ($appRoot.'/Administracion/datos/datosGrupos.php');
include_once ($appRoot.'/Administracion/datos/datosUsuarios.php');

//Validación de datos
include ($appRoot."/include/validar.php");

class infoUsuario{
	
	public $id;
	public $nombre;
	public $perfil;
	public $usuario;

	public $lista_acciones_hoy;
	public $lista_acciones_no_leidas;
	public $lista_ofertas;
	public $lista_ofertas_pendientes;
    public $lista_ventas;
	public $lista_alarmas=array();//Matriz indexada por a�o con lista de clientes que cumplen la renovaci�n en ese a�o (en los 3 pr�ximos meses)

	public $lista_proyectos;
	
	private $DB_perfiles;
	private $DB_usuarios;
	private $DB_acciones;
	private $DB_ofertas;
    private $DB_ventas;
	private $DB_clientes; //para las alarmas de las fechas de renovaci�n
	private $DB_proyectos;
	
	public function infoUsuario($id_usuario, $nombre, $opciones){
		$this->DB_perfiles = new datosPerfiles();
		$this->DB_usuarios = new datosUsuarios();
		$this->usuario = new Usuario($id_usuario);
		$this->DB_acciones = new ListaAcciones();
		$this->DB_ofertas = new ListaOfertas();
        $this->DB_ventas = new ListaVentas();
		$this->DB_clientes = new ListaClientes();
		$this->DB_proyectos = new ListaProyectos();

		$datos = $this->DB_usuarios->getDatosUsuario($id_usuario);

		$this->id = $id_usuario;
		$this->nombre = $datos['nombre']." ".$datos['apellidos'];
				
		$this->perfil = $this->DB_perfiles->getDatosPerfil($datos['perfil']);

		$this->obtener_Opciones($opciones);
		if($this->opt['guardar'])
			$this->guardar();

		$perfil = $this->usuario->get_Perfil();
		if(esPerfilComercial($perfil['id'])){
			$this->obtener_Acciones();
			$this->obtener_Ofertas();
			$this->obtener_Ventas();
			$this->obtener_Alarmas();
		}
		if(esPerfilTecnico ($perfil['id'])){
			$this->obtener_Proyectos();
		}
	}

	private function obtener_Opciones($opciones){
		($opciones['guardar'])?$this->opt['guardar']=$opciones['guardar']:null;
		($opciones['ids_acciones_leer'])?$this->opt['ids_acciones_leer']=$opciones['ids_acciones_leer']:null;
		($opciones['ids_ofertas_leer'])?$this->opt['ids_ofertas_leer']=$opciones['ids_ofertas_leer']:null;
	}

	private function obtener_Proyectos(){
		global $gestor_actual;
		global $permisos;
		$perfil_usr = $gestor_actual->get_Perfil();
		if(!in_array($perfil_usr['id'], array(4,5,6)))
			$filtros['id_usuario'] = $this->usuario->get_Id();
		$filtros['estados'] = '(1,2,4,5)';
		$filtros['order_by'] = 'estado';

		$this->DB_proyectos->buscar($filtros);
		$this->lista_proyectos = $this->DB_proyectos;
	}
	private function obtener_Acciones(){
		global $gestor_actual;
		$perfil_usr = $gestor_actual->get_Perfil();
		if(!in_array($perfil_usr['id'], array(4,5,7)))
			$filtros['id_usuario'] = $this->usuario->get_Id();
		$filtros['fecha_siguiente_desde'] = fechaActualTimeStamp();
		$filtros['fecha_siguiente_hasta'] = fechaActualTimeStamp();

		$this->DB_acciones->buscar($filtros);
		$this->lista_acciones_hoy = $this->DB_acciones;		
		
		$DB_acciones = new ListaAcciones();
		/*$fecha2semanas = fechaActualTimeStamp()-(2*7*24*60*60);
		$filtros['fecha_siguiente_desde'] = $fecha2semanas;
		$filtros['fecha_siguiente_hasta'] = fechaActualTimeStamp()-(24*60*60);*/
		if($filtros['id_usuario'])
			$filtros_no_leidas['id_usuario'] = $filtros['id_usuario'];
		$filtros_no_leidas['no_leida'] = true;
		$DB_acciones->buscar($filtros_no_leidas);
		$this->lista_acciones_no_leidas =$DB_acciones;
	}
	
	private function obtener_Ofertas(){
		global $gestor_actual;
		$perfil_usr = $gestor_actual->get_Perfil();
		if(!in_array($perfil_usr['id'], array(4,5,7)))
			$filtros['id_usuario'] = $this->usuario->get_Id();
		$filtros['fecha_definicion_desde'] = fechaActualTimeStamp();
		$filtros['fecha_definicion_hasta'] = fechaActualTimeStamp();

		$this->DB_ofertas->buscar($filtros);
		$this->lista_ofertas = $this->DB_ofertas;

		$DB_Ofertas = new ListaOfertas();
		if($filtros['id_usuario'])
			$filtros_no_leidas['id_usuario'] = $filtros['id_usuario'];
		$filtros_no_leidas['no_leida'] = true;
		$DB_Ofertas->buscar($filtros_no_leidas);
		$this->lista_ofertas_pendientes = $DB_Ofertas;
	}

    private function obtener_Ventas(){
		global $gestor_actual;
		$perfil_usr = $gestor_actual->get_Perfil();
		if(!in_array($perfil_usr['id'], array(4,5,7)))
			$filtros['id_usuario'] = $this->usuario->get_Id();

                $fecha2semanas = fechaActualTimeStamp()-(2*7*24*60*60);
		$filtros['fecha_plazos_desde'] = $fecha2semanas;
		$filtros['fecha_plazos_hasta'] = fechaActualTimeStamp();

		$this->DB_ventas->buscar($filtros);
		$this->lista_ventas = $this->DB_ventas;
	}

	private function obtener_Alarmas(){
		global $gestor_actual;
		
		$filtros['id_usuario'] = $gestor_actual->get_Id();
		
		$fecha_actual = timestamp2date(fechaActualTimeStamp());
		$array_fecha_temp = explode('/',$fecha_actual);
		$dia = $array_fecha_temp[0];
		$mes = $array_fecha_temp[1];
		$year_actual = $array_fecha_temp[2];
		
		//$fecha_3_meses = $fecha_actual+(3*31*24*60*60);
		
		$year = 2004;
		while($year <= $year_actual){
			$Lista_Clientes = new ListaClientes();
			$fecha_inicio = $dia.'/'.$mes.'/'.$year;
			$fecha_inicio_ts = date2timestamp($fecha_inicio);
			$filtros['fecha_renovacion_desde'] = $fecha_inicio_ts;
			$filtros['fecha_renovacion_hasta'] = $fecha_inicio_ts+(3*31*24*60*60);

			$Lista_Clientes ->buscar($filtros);
			$this->lista_alarmas[] = $Lista_Clientes;
						
			$year += 1;
		}		
	}

	private function guardar(){
		if($this->opt['ids_acciones_leer']){
			foreach($this->opt['ids_acciones_leer'] as $id_accion){
				$Accion = new Accion($id_accion);
				$Accion->leer();
			}
		}
		if($this->opt['ids_ofertas_leer']){
			foreach($this->opt['ids_ofertas_leer'] as $id){
				$Oferta = new Oferta($id);
				$Oferta->leer();
			}
		}
	}

}
?>
