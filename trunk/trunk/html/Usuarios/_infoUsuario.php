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
	public $lista_acciones_anteriores;
	public $lista_ofertas;
        public $lista_ventas;
	public $lista_alarmas=array();//Matriz indexada por a�o con lista de clientes que cumplen la renovaci�n en ese a�o (en los 3 pr�ximos meses)
	
	private $DB_perfiles;
	private $DB_usuarios;
	private $DB_acciones;
	private $DB_ofertas;
        private $DB_ventas;
	private $DB_clientes; //para las alarmas de las fechas de renovaci�n
	
	public function infoUsuario($id_usuario, $nombre){
		$this->DB_perfiles = new datosPerfiles();
		$this->DB_usuarios = new datosUsuarios();
		$this->usuario = new Usuario($id_usuario);
		$this->DB_acciones = new ListaAcciones();
		$this->DB_ofertas = new ListaOfertas();
                $this->DB_ventas = new ListaVentas();
		$this->DB_clientes = new ListaClientes();

		$datos = $this->DB_usuarios->getDatosUsuario($id_usuario);
		
		$this->id = $id_usuario;
		$this->nombre = $datos['nombre']." ".$datos['apellidos'];
				
		$this->perfil = $this->DB_perfiles->getDatosPerfil($datos['perfil']);
		$this->obtener_Acciones();
		$this->obtener_Ofertas();
                $this->obtener_Ventas();
		$this->obtener_Alarmas();
	}

	private function obtener_Acciones(){
		global $gestor_actual;
		if(!$gestor_actual->esAdministradorTotal())
			$filtros['id_usuario'] = $this->usuario->get_Id();
		$filtros['fecha_siguiente_desde'] = fechaActualTimeStamp();
		$filtros['fecha_siguiente_hasta'] = fechaActualTimeStamp();

		$this->DB_acciones->buscar($filtros);
		$this->lista_acciones_hoy = $this->DB_acciones;		
		
		$DB_acciones = new ListaAcciones();
		$fecha2semanas = fechaActualTimeStamp()-(2*7*24*60*60);
		$filtros['fecha_siguiente_desde'] = $fecha2semanas;
		$filtros['fecha_siguiente_hasta'] = fechaActualTimeStamp()-(24*60*60);
		$DB_acciones->buscar($filtros);
		$this->lista_acciones_anteriores =$DB_acciones;	
	}
	
	private function obtener_Ofertas(){
		global $gestor_actual;
		if(!$gestor_actual->esAdministradorTotal())
			$filtros['id_usuario'] = $this->usuario->get_Id();
		$filtros['fecha_definicion_desde'] = fechaActualTimeStamp();
		$filtros['fecha_definicion_hasta'] = fechaActualTimeStamp();

		$this->DB_ofertas->buscar($filtros);
		$this->lista_ofertas = $this->DB_ofertas;	
	}

        private function obtener_Ventas(){
		global $gestor_actual;
		if(!$gestor_actual->esAdministradorTotal())
			$filtros['id_usuario'] = $this->usuario->get_Id();

                $fecha2semanas = fechaActualTimeStamp()-(2*7*24*60*60);
		$filtros['fecha_plazos_desde'] = $fecha2semanas;
		$filtros['fecha_plazos_hasta'] = fechaActualTimeStamp();

		$this->DB_ventas->buscar($filtros);
		$this->lista_ventas = $this->DB_ventas;
	}

	private function obtener_alarmas(){
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

}
?>
