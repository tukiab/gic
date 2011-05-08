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
											
					$this->informe[$proyecto->get_Id_Usuario()][$mes_year]['incentivables'] += $this->get_unidades_incentivables($proyecto, $mes, $year);
					$this->informe[$proyecto->get_Id_Usuario()][$mes_year]['no_incentivables'] += $this->get_unidades_no_incentivables($proyecto, $mes, $year);

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

	 private function get_unidades_incentivables($proyecto, $mes, $year){
		 $fecha_fin_mes = date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year);
		if($proyecto->get_Id_Venta()){
			/*Proyectos "normales" derivados de una venta:
			 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo Y EL PROYECTO SE HA INICIADO, LAS HORAS TEÓRICAS (HT*)=HORAS INCENTIVABLES
				HT*= Horas teóricas TOTALES del proyecto/ número de meses TEÓRICOS de duración del proyecto.
			 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo, LAS HORAS INCENTIVABLES es siempre CERO
			 */

			$unidades_incentivables = 0;
			if( $proyecto->get_Fecha_Inicio() <= $fecha_fin_mes && $proyecto->get_Fecha_Fin() > $fecha_fin_mes)
				$unidades_incentivables = $proyecto->get_Unidades();

		}else{
			/*Proyectos creados DIRECTAMENTE por el director técnico.
			 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo, LAS HORAS REALES dedicada por el técnico en ese
				mes a ese proyecto=HORAS INCENTIVABLES
			 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo, LAS HORAS INCENTIVABLES es siempre CERO
			 */
			$unidades_incentivables = 0;
			if($proyecto->get_Fecha_Inicio() <= $fecha_fin_mes && $proyecto->get_Fecha_Fin() > $fecha_fin_mes)
				$unidades_incentivables = $proyecto->get_Horas_Totales_Reales()/8;
			
		}

		return $unidades_incentivables;
	 }

 	 private function get_unidades_no_incentivables($proyecto, $mes, $year){
		 //unidades no incentivables: =horas reales/8 si fecha_fin proyecto < fecha_hasta; e.o.c. =0
		 $fecha_fin_mes = date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year);
		if($proyecto->get_Id_Venta()){
			/*Proyectos "normales" derivados de una venta:
			 * Las HORAS REALES dedicada por el técnico en ese mes a ese proyecto=HORAS NO INCENTIVABLES.
			 */
			$unidades_no_incentivables = $proyecto->get_Horas_Totales_Reales()/8;
			
		}else{
			/*Proyectos creados DIRECTAMENTE por el director técnico.
			 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo
				las HORAS NO INCENTIVABLES son siempre CERO
			 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo
				las HORAS REALES dedicada por el técnico en ese mes a ese proyecto=HORAS NO INCENTIVABLES
			 */
			$unidades_no_incentivables = 0;
			if($proyecto->get_Fecha_Inicio() <= $fecha_fin_mes && $proyecto->get_Fecha_Fin() <= $fecha_fin_mes)
				$unidades_no_incentivables = $proyecto->get_Horas_Totales_Reales()/8;
			
		}

		return $unidades_no_incentivables;
	 }

}
?>