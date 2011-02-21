<?php
/**
 * Clase encargada de las búsquedas y listados de Acciones.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaAcciones implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Acciones.
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
	 * Devuelve el número de Acciones almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Acciones.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente Accion en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Accion El siguiente Accion en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_accion = $row[0];
		else
			return null;
		return new Accion($id_accion);
	}

	/**
	 * Lanza la búsqueda de Acciones aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Acciones.
	 */
	public function buscar($filtros){
		
		$filtro ="";
		$join="";
		$join .= "INNER JOIN clientes ON clientes.id = acciones_de_trabajo.fk_cliente";
		(isset($filtros['id']))?$filtro.=" AND acciones_de_trabajo.id = '".$filtros['id']."' ":null;
		(isset($filtros['descripcion']))?$filtro.=" AND acciones_de_trabajo.descripcion LIKE '%".$filtros['descripcion']."%' ":null;
		(isset($filtros['tipo_accion']))?$filtro.=" AND acciones_de_trabajo.fk_tipo_accion = '".$filtros['tipo_accion']."' ":null;
		(isset($filtros['fecha_desde']))?$filtro.=" AND acciones_de_trabajo.fecha >= '".$filtros['fecha_desde']."' ":null;
		(isset($filtros['fecha_hasta']))?$filtro.=" AND acciones_de_trabajo.fecha <= '".$filtros['fecha_hasta']."' ":null;
		(isset($filtros['no_leida']))?$filtro.=" AND acciones_de_trabajo.leida = '0' ":null;

		(isset($filtros['fecha_siguiente_desde']))?$filtro.=" AND acciones_de_trabajo.fecha_siguiente_accion >= '".$filtros['fecha_siguiente_desde']."' ":null;
		(isset($filtros['fecha_siguiente_hasta']))?$filtro.=" AND acciones_de_trabajo.fecha_siguiente_accion <= '".$filtros['fecha_siguiente_hasta']."' ":null;
		
		if(isset($filtros['id_usuario']))
			$filtro .= " AND acciones_de_trabajo.fk_usuario = '".$filtros['id_usuario']."'";
		
		if(isset($filtros['id_cliente']))
			$filtro .= " AND acciones_de_trabajo.fk_cliente = '".$filtros['id_cliente']."'";
		
		if(isset($filtros['razon_social'])){
			
			$filtro .= "AND clientes.razon_social LIKE '%".$filtros['razon_social']."%' ";
		}	
		
				//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " acciones_de_trabajo.id ";
					break;
				case 'tipo_accion':
						$order_by = " acciones_de_trabajo.fk_tipo_accion ";
					break;
				case 'fecha':
						$order_by = "acciones_de_trabajo.fecha";
					break;
				case 'fecha_siguiente':
						$order_by = "acciones_de_trabajo.fecha_siguiente_accion";
					break;
				case 'usuario':
						$order_by = "acciones_de_trabajo.fk_usuario";
					break;
				case 'cliente':
						$order_by = "clientes.razon_social";
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
			
			
		$query = "SELECT acciones_de_trabajo.id
					FROM acciones_de_trabajo
						$join				
				    WHERE 1
						$filtro
				    GROUP BY acciones_de_trabajo.id $order $limit;";
		
		$this->result = @mysql_query($query);
		
		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}

	/**
	 * Devuelve un array con la lista de tipos de Accion
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de tipos de acciones.
	 */
	function lista_Tipos(){
		$tipos = array();
		$query = "SELECT id, nombre FROM acciones_tipos order by id;";
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
