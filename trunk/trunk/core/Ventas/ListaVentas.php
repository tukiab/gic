<?php
/**
 * Clase encargada de las búsquedas y listados de Ventas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaVentas implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Ventas.
	 * 
	 * @see buscar()
	 * @var unknown_type
	 */
	private $result;

	/**
	 * Almacena el número de resultados en una búsqueda, sin tener en cuenta
	 * la paginación.
	 * 
	 * @var integer
	 */
	private $num_rows;
	
	/**
	 * Devuelve el número de Ventas almacenados en la búsqueda.
	 * 
	 * Si no se ha lanzado previamente una búsqueda, el valor devuelto será NULL.
	 * 
	 * @see buscar()
	 * @return integer $num_resultados Número de Sedes encontradas en buscar()
	 */
	public function num_Resultados(){
		return @mysql_num_rows($this->result);
	}

	/**
	 * Devuelve el puntero al inicio de la lista de Ventas.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente Venta en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Venta El siguiente Venta en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_venta = $row[0];
		else
			return null;
		return new Venta($id_venta);
	}

	/**
	 * Lanza la búsqueda de Ventas aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Ventas.
	 */
	public function buscar($filtros, $page=0, $paso=0){
		FB::error($filtros,'filtros ListaVentas');
		$filtro ="";
		$join_ofertas="";
		
		(isset($filtros['id']))?$filtro.=" AND ventas.id = '".$filtros['id']."' ":null;
		(isset($filtros['nombre']))?$filtro.=" AND ventas.nombre LIKE '%".$filtros['nombre']."%' ":null;

		if(isset($filtros['codigo'])){
			$join_ofertas = " INNER JOIN ofertas ON ventas.fk_oferta = ofertas.id AND ofertas.codigo LIKE '%".trim($filtros['codigo'])."%'";		
		}
		
		if(isset($filtros['id_usuario'])){
			if(!$join_ofertas)
				$join_ofertas = " INNER JOIN ofertas ON ventas.fk_oferta = ofertas.id AND ofertas.codigo LIKE '%".trim($filtros['codigo'])."%'";		
			else
				$join_ofertas .= " AND ventas.fk_oferta = ofertas.id AND ofertas.fk_usuario = '".trim($filtros['codigo'])."'";
		}
		
		(isset($filtros['forma_pago']))?$filtro.=" AND ventas.fk_forma_pago = '".$filtros['forma_pago']."' ":null;
		(isset($filtros['tipo_comision']))?$filtro.=" AND ventas.fk_tipo_comision = '".$filtros['tipo_comision']."' ":null;
		if(isset($filtros['formacion_bonificada'])){
			if($filtros['formacion_bonificada'] == 1)
				$filtro.=" AND ventas.formacion_bonificada = '0' ";
			else if($filtros['formacion_bonificada'] == 2)
				$filtro.=" AND ventas.formacion_bonificada = '1' ";
		}
		(isset($filtros['fecha_aceptado_desde']))?$filtro.=" AND ventas.fecha_aceptado >= '".$filtros['fecha_aceptado_desde']."' ":null;
		(isset($filtros['fecha_aceptado_hasta']))?$filtro.=" AND ventas.fecha_aceptado <= '".$filtros['fecha_aceptado_hasta']."' ":null;

		(isset($filtros['fecha_asignacion_tecnico_desde']))?$filtro.=" AND ventas.fecha_asignacion_tecnico >= '".$filtros['fecha_asignacion_tecnico_desde']."' ":null;
		(isset($filtros['fecha_asignacion_tecnico_hasta']))?$filtro.=" AND ventas.fecha_asignacion_tecnico <= '".$filtros['fecha_asignacion_tecnico_hasta']."' ":null;
		(isset($filtros['fecha_entrada_vigor_desde']))?$filtro.=" AND ventas.fecha_entrada_vigor >= '".$filtros['fecha_entrada_vigor_desde']."' ":null;
		(isset($filtros['fecha_entrada_vigor_hasta']))?$filtro.=" AND ventas.fecha_entrada_vigor <= '".$filtros['fecha_entrada_vigor_hasta']."' ":null;
		
		if(isset($filtros['fecha_plazos_desde']) || isset($filtros['fecha_plazos_hasta'])){
                    $join_plazos = " INNER JOIN ventas_plazos ON ventas_plazos.fk_venta = ventas.id AND ventas_plazos.fk_estado = '1' ";
                    if(isset($filtros['fecha_plazos_desde']))
                        $join_plazos .= " AND ventas_plazos.fecha >= '".$filtros['fecha_plazos_desde']." '";
                    if(isset($filtros['fecha_plazos_hasta']))
                        $join_plazos .= " AND ventas_plazos.fecha <= '".$filtros['fecha_plazos_hasta']." '";
                }
		
		//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " ventas.id ";
					break;
				case 'nombre':
						$order_by = "ventas.nombre";
					break;
				case 'tipo_comision':
						$order_by = "ventas.fk_tipo_comision";
					break;
				case 'formacion_bonificada':
						$order_by = "ventas.formacion_bonificada";
					break;
				case 'forma_pago':
						$order_by = "ventas.fk_forma_pago";
					break;
				case 'fecha_aceptado':
						$order_by = "ventas.fecha_aceptado";
					break;
				
				case 'fecha_asignacion_tecnico':
						$order_by = "ventas.fecha_asignacion_tecnico";
					break;
				case 'fecha_entrada_vigor':
						$order_by = "ventas.fecha_entrada_vigor";
					break;

			}
			if($order_by){
				($filtros['order_by_asc_desc']=="DESC")?$asc_desc=" DESC ":$asc_desc=" ASC ";
				$order=" ORDER BY ".$order_by." $asc_desc ";
			}
		}else
			$order = null;
			
			
		//Paginando...
		if($page!=0 || $paso!=0)
			$limit = " LIMIT $page,$paso ";
			
			
		$query = "SELECT ventas.id
				FROM ventas
						$join_ofertas
                                                $join_plazos
				WHERE 1
						$filtro
				GROUP BY ventas.id $order				    
					
					$limit;";
		
		FB::error($query,'query ListaVentas:buscar');
		$this->result = @mysql_query($query);
		
		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	function lista_Tipos_Comision(){
		$tipos = array();
		$query = "SELECT id, nombre FROM tipos_comision";
		$result = mysql_query($query);
		while($row = @mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Formas_De_Pago(){
		$tipos = array();
		$query = "SELECT id, nombre FROM formas_de_pago";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Estados_Plazos(){
		$tipos = array();
		$query = "SELECT id, nombre FROM plazos_estados";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Gestores(){
		$tipos = array();
		$query = "SELECT id, nombre FROM usuarios";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
}
?>
