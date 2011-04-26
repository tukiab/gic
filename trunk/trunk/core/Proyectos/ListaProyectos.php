<?php
/**
 * Clase encargada de las búsquedas y listados de Proyectos.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaProyectos implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Proyectos.
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
	 * Devuelve el número de Proyectos almacenados en la búsqueda.
	 * 
	 * Si no se ha lanzado previamente una búsqueda, el valor devuelto será NULL.
	 * 
	 * @see buscar()
	 * @return integer $num_resultados Número de Sedes encontradas en buscar()
	 */
	public function num_Resultados(){
		return $this->num_rows;
	}

	/**
	 * Devuelve el puntero al inicio de la lista de Proyectos.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Proyecto en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Proyecto El siguiente Proyecto en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_proyecto = $row[0];
		else
			return null;
		return new Proyecto($id_proyecto);
	}

	/**
	 * Lanza la búsqueda de Proyectos aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Proyectos.
	 */
	public function buscar($filtros=null, $page=0, $paso=0){
		//FB::info($filtros,'filtros ListaProyectos:buscar');
		$filtro ="";
		$join="";

		(!isset($filtros['con_cerrar']))?$filtro.=" AND cerrar = 1 ":null;

		(isset($filtros['id']))?$filtro.=" AND proyectos.id = '".trim($filtros['id'])."' ":null;
		if(isset($filtros['razon_social']))
			$join .= "INNER JOIN clientes ON proyectos.fk_cliente = clientes.id AND clientes.razon_social LIKE '%".$filtros['razon_social']."%'";
		
		(isset($filtros['nombre']))?$filtro.=" AND proyectos.nombre LIKE '%".trim($filtros['nombre'])."%' ":null;
		if(isset($filtros['id_estado']))
			$join .= " INNER JOIN proyectos_estados ON proyectos.fk_estado = '".trim($filtros['id_estado'])."'";
		else if(isset($filtros['estados']))
			$join .= " INNER JOIN proyectos_estados ON proyectos.fk_estado IN ".trim($filtros['estados'])."";
		(isset($filtros['fecha_inicio_desde']))?$filtro.=" AND proyectos.fecha_inicio >= '".trim($filtros['fecha_inicio_desde'])."' ":null;
		(isset($filtros['fecha_inicio_hasta']))?$filtro.=" AND proyectos.fecha_inicio <= '".trim($filtros['fecha_inicio_hasta'])."' ":null;
		(isset($filtros['fecha_fin_desde']))?$filtro.=" AND proyectos.fecha_fin >= '".trim($filtros['fecha_fin_desde'])."' ":null;
		(isset($filtros['fecha_fin_hasta']))?$filtro.=" AND proyectos.fecha_fin <= '".trim($filtros['fecha_fin_hasta'])."' ":null;

		if(isset($filtros['fecha_desde']) && isset($filtros['fecha_hasta'])){
			$filtro .= " AND (
								(proyectos.fecha_inicio >= '".trim($filtros['fecha_desde'])."' AND proyectos.fecha_inicio <= '".trim($filtros['fecha_hasta'])."' ) OR
								(proyectos.fecha_fin >= '".trim($filtros['fecha_desde'])."' AND proyectos.fecha_fin <= '".trim($filtros['fecha_hasta'])."' )
							)";
		}

		(isset($filtros['gestor']) && $filtros['gestor'] != '0')?$filtros['id_usuario']=$filtros['gestor']:null;
		(isset($filtros['id_usuario']) && $filtros['id_usuario']!='0')?$filtro .= " AND proyectos.fk_usuario = '".trim($filtros['id_usuario'])."'":null;
		(isset($filtros['id_cliente']))?$filtro .= " AND proyectos.fk_cliente = '".trim($filtros['fk_cliente'])."'":null;
		(isset($filtros['id_venta']))?$filtro .= " AND proyectos.fk_venta = '".trim($filtros['id_venta'])."'":null;
		
		(isset($filtros['es_plantilla']))?$filtro .= " AND proyectos.es_plantilla = '".trim($filtros['es_plantilla'])."'":null;
		
		//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " proyectos.id ";
					break;
				case 'nombre':
						$order_by = " proyectos.nombre ";
					break;
				case 'estado':
						$order_by = "proyectos.fk_estado";
					break;
				case 'fecha_inicio':
						$order_by = "proyectos.fecha_inicio";
					break;
				case 'fecha_fin':
						$order_by = "proyectos.fecha_fin";
					break;
				case 'gestor':
						$order_by = "proyectos.fk_usuario";
					break;
				case 'id_usuario':
						$order_by = "proyectos.fk_usuario";
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
		
		$query = "SELECT SQL_CALC_FOUND_ROWS proyectos.id
					FROM proyectos
						$join										
				    WHERE 1
						$filtro
				    GROUP BY proyectos.id $order
					$limit;";
		
		FB::info($query,'query ListaProyectos:buscar');
		$this->result = @mysql_query($query);

		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	
	function lista_Estados(){            
		$tipos = array();
		$query = "SELECT id, nombre FROM proyectos_estados;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;

		return $tipos;
	}
	function lista_Gestores(){
		$tipos = array();
		$query = "SELECT id, nombre FROM usuarios;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;

		return $tipos;
	}
}
?>
