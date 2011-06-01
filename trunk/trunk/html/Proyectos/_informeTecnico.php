<?php
 include ('../appRoot.php');

class InformeTecnico{

	public $opt=array();
	public $datos = array();
	private $lista_Proyectos;
	public $gestor;
	public $informe;

	public function __construct($opciones){
		try{

			$this->gestor = new Usuario($_SESSION['usuario_login']);
			$this->obtener_Opciones($opciones);
			$this->lista_Proyectos =  new ListaProyectos();
			$this->obtener_Listas();

			actualizarProyectosFueraDePlazo();
			
			if($this->opt['mostrar']){
				//$this->opt['estados'] = '(3,4,5)'; //sólo los proyectos en estados 3,4,5; pendiente planificación, en curso, fuera de plazo
				$this->lista_Proyectos->buscar($this->opt);
				$this->obtener_informe();
			}
			$this->datos['lista_proyectos']=$this->lista_Proyectos;
		}catch (Exception $e){
			$this->opt['msg'] = $e->getMessage();
		}
	}

	private function obtener_Opciones($opciones){
		global $permisos;

		$id_usuario = $_SESSION['usuario_login'];
		$usuario = new Usuario($id_usuario);

		if(!$permisos->administracion)//$perfil_usuario['id'] != 5 && $perfil_usuario['id'] != 4)
			$this->opt['gestor'] =  $_SESSION['usuario_login'];
		else
			@($opciones['gestor'])?$this->opt['gestor']=$opciones['gestor']:null;

		
		@($opciones['mostrar'])?$this->opt['mostrar']=$opciones['mostrar']:null;

		@($opciones['mes_desde'])?$this->opt['mes_desde']=$opciones['mes_desde']:null;
		@($opciones['mes_hasta'])?$this->opt['mes_hasta']=$opciones['mes_hasta']:null;
		@($opciones['year_desde'])?$this->opt['year_desde']=$opciones['year_desde']:null;
		@($opciones['year_hasta'])?$this->opt['year_hasta']=$opciones['year_hasta']:null;

		//generamos fecha desde y fecha hasta:
		$this->opt['fecha_desde'] = date2timestamp('1/'.$this->opt['mes_desde'].'/'.$this->opt['year_desde']);
		$dia = numeroDeDias($this->opt['mes_hasta'], $this->opt['year_hasta']);
		$this->opt['fecha_hasta'] = date2timestamp($dia.'/'.$this->opt['mes_hasta'].'/'.$this->opt['year_hasta']);

		if($this->opt['fecha_desde'] >$this->opt['fecha_hasta'])
			throw new Exception ('El rango de fechas introducido es inv&aacute;lido');
	}

	private function obtener_Listas(){
		$listaUsuarios = new ListaUsuarios();
		$filtros['perfiles'] = '(3,6)'; //técnicos y directores técnicos
		$listaUsuarios->buscar($filtros);
		$this->datos['lista_tecnicos'] = $listaUsuarios;
	 }

	 /*
	 * Vamos a recorrer todos los meses entre las fechas dadas.
	 * Para cada mes recorremos todo los proyectos, y si en el mes dado el proyecto estaba "vivo" (había comenzado)
	 *	actualizamos la información relativa al proyecto (al técnico y al mes)
	 */
	 private function obtener_informe(){
		$mes  = $this->opt['mes_desde'];
		$year = $this->opt['year_desde'];
		$clientes = array();

		while(Fechas::date2timestamp('1/'.$mes.'/'.$year) < $this->opt['fecha_hasta']){
			$nombre_mes = Fechas::obtenerNombreMes($mes);
			$this->lista_Proyectos->inicio();
			while($proyecto = $this->lista_Proyectos->siguiente() ){
				$nombre_mes = Fechas::obtenerNombreMes($mes);
				$mes_year = $nombre_mes.'/'.$year;

				$fecha_inicio_mes = Fechas::date2timestamp(date('1/'.$mes.'/'.$year));
				$fecha_fin_mes = date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year);
				if($proyecto->get_Fecha_Inicio() <= $fecha_fin_mes && $proyecto->get_Fecha_Fin() >= $fecha_inicio_mes){

					$this->informe[$proyecto->get_Id_Usuario()][$mes_year]['incentivables'] += ListaProyectos::get_unidades_incentivables($proyecto, $mes, $year);
					$this->informe[$proyecto->get_Id_Usuario()][$mes_year]['no_incentivables'] += ListaProyectos::get_unidades_no_incentivables($proyecto, $mes, $year);

					if(!$clientes[$proyecto->get_Id_Usuario()] ||
							!in_array($proyecto->get_Id_Cliente(), $clientes[$proyecto->get_Id_Usuario()])){
						$clientes[$proyecto->get_Id()][] = $proyecto->get_Id_Cliente();
						$this->informe[$proyecto->get_Id_Usuario()][$mes_year]['numero_empresas'] ++;
					}
				}
			}
			$siguiente_mes = Fechas::siguienteMes($mes);
			$mes = $siguiente_mes;
			if($mes == 1)
				$year++;
		}
	 }
}
?>