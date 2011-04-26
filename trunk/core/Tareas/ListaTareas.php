<?php
/**
 * Clase encargada de las búsquedas y listados de Tareas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaTareas implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Tareas.
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
	 * Devuelve el número de Tareas almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Tareas.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Tarea en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Tarea El siguiente Tarea en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_tarea = $row[0];
		else
			return null;
		return new Tarea($id_tarea);
	}

	/**
	 * Lanza la búsqueda de Tareas aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Tareas.
	 */
	public function buscar($filtros){
		
		$filtro ="";
		$join="";
		$join .= "INNER JOIN clientes ON clientes.id = tareas_tecnicas.fk_cliente";
		(isset($filtros['id']))?$filtro.=" AND tareas_tecnicas.id = '".$filtros['id']."' ":null;
		(isset($filtros['id_proyecto']))?$filtro.=" AND tareas_tecnicas.fk_proyecto = '".$filtros['id_proyecto']."' ":null;
		(isset($filtros['tipo_tarea']))?$filtro.=" AND tareas_tecnicas.fk_tipo_tarea = '".$filtros['tipo_tarea']."' ":null;
		(isset($filtros['id_sede']))?$filtro.=" AND tareas_tecnicas.fk_sede = '".$filtros['id_sede']."' ":null;
		(isset($filtros['fecha_desde']))?$filtro.=" AND tareas_tecnicas.fecha >= '".$filtros['fecha_desde']."' ":null;
		(isset($filtros['fecha_hasta']))?$filtro.=" AND tareas_tecnicas.fecha <= '".$filtros['fecha_hasta']."' ":null;
		(isset($filtros['incentivable']))?$filtro.=" AND tareas_tecnicas.incenticable = '1' ":null;
		(isset($filtros['no_incentivable']))?$filtro.=" AND tareas_tecnicas.incenticable = '0' ":null;

		(isset($filtros['horas_desplazamiento_desde']))?$filtro.=" AND tareas_tecnicas.horas_desplazamiento >= '".$filtros['horas_desplazamiento_desde']."' ":null;
		(isset($filtros['horas_desplazamiento_hasta']))?$filtro.=" AND tareas_tecnicas.horas_desplazamiento <= '".$filtros['horas_desplazamiento_hasta']."' ":null;

		(isset($filtros['horas_visita_desde']))?$filtro.=" AND tareas_tecnicas.horas_visita >= '".$filtros['horas_visita_desde']."' ":null;
		(isset($filtros['horas_visita_hasta']))?$filtro.=" AND tareas_tecnicas.horas_visita <= '".$filtros['horas_visita_hasta']."' ":null;

		(isset($filtros['horas_despacho_desde']))?$filtro.=" AND tareas_tecnicas.horas_despacho >= '".$filtros['horas_despacho_desde']."' ":null;
		(isset($filtros['horas_despacho_hasta']))?$filtro.=" AND tareas_tecnicas.horas_despacho <= '".$filtros['horas_despacho_hasta']."' ":null;

		(isset($filtros['horas_auditoria_interna_desde']))?$filtro.=" AND tareas_tecnicas.horas_auditoria_interna >= '".$filtros['horas_auditoria_interna_desde']."' ":null;
		(isset($filtros['horas_auditoria_interna_hasta']))?$filtro.=" AND tareas_tecnicas.horas_auditoria_interna <= '".$filtros['horas_auditoria_interna_hasta']."' ":null;
		
				//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " tareas_tecnicas.id ";
					break;
				case 'tipo_tarea':
						$order_by = " tareas_tecnicas.fk_tipo_tarea ";
					break;
				case 'fecha':
						$order_by = "tareas_tecnicas.fecha";
					break;
				case 'id_usuario':
						$order_by = "tareas_tecnicas.fk_usuario";
					break;
				case 'id_proyecto':
						$order_by = "clientes.fk_proyecto";
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
			
			
		$query = "SELECT tareas_tecnicas.id
					FROM tareas_tecnicas
						$join				
				    WHERE 1
						$filtro
				    GROUP BY tareas_tecnicas.id $order $limit;";
		
		$this->result = @mysql_query($query);
		
		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}

	/**
	 * Devuelve un array con la lista de tipos de Tarea
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de tipos de tareas.
	 */
	function lista_Tipos(){
		$tipos = array();
		$query = "SELECT id, nombre FROM tareas_tecnicas_tipos order by id;";
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
