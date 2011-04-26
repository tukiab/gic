<?php
/**
 * Clase encargada de las búsquedas y listados de Colaboradores.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaColaboradores implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Colaboradores.
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
	 * Devuelve el número de Colaboradores almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Colaboradores.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Colaborador en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Colaborador El siguiente Colaborador en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_colaborador = $row[0];
		else
			return null;
		return new Colaborador($id_colaborador);
	}

	/**
	 * Lanza la búsqueda de Colaboradores aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Colaboradores.
	 */
	public function buscar($filtros, $page=0, $paso=0){
		FB::info($filtros,'filtros ListaColaboradores:buscar');
		$filtro ="";
		$join="";
		
		(isset($filtros['id']))?$filtro.=" AND colaboradores.id = '".$filtros['id']."' ":null;
		(isset($filtros['razon_social']))?$filtro.=" AND colaboradores.razon_social LIKE '%".$filtros['razon_social']."%' ":null;
		
		(isset($filtros['NIF']))?$filtro.=" AND colaboradores.NIF LIKE '".$filtros['NIF']."' ":null;
		(isset($filtros['domicilio']))?$filtro.=" AND colaboradores.domicilio LIKE '%".$filtros['domicilio']."%' ":null;
		(isset($filtros['localidad']))?$filtro.=" AND colaboradores.localidad LIKE '%".$filtros['localidad']."%' ":null;
		(isset($filtros['CP']))?$filtro.=" AND colaboradores.CP = '".$filtros['CP']."' ":null;
		
		(isset($filtros['comision_desde']))?$filtro.=" AND colaboradores.comision >= '".$filtros['comision_desde']."' ":null;		
		(isset($filtros['comision_hasta']))?$filtro.=" AND colaboradores.comision <= '".$filtros['comision_hasta']."' ":null;
		(isset($filtros['comision_por_renovacion_desde']))?$filtro.=" AND colaboradores.comision_por_renovacion >= '".$filtros['comision_desde']."' ":null;		
		(isset($filtros['comision_por_renovacion_hasta']))?$filtro.=" AND colaboradores.comision_por_renovacion <= '".$filtros['comision_por_renovacion_hasta']."' ":null;
		
		//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " colaboradores.id ";
					break;
				case 'razon_social':
						$order_by = " colaboradores.razon_social ";
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
		
		$query = "SELECT SQL_CALC_FOUND_ROWS colaboradores.id
					FROM colaboradores
						$join				
				    WHERE 1
						$filtro
				    GROUP BY colaboradores.id $order
					$limit;";
		//throw new Exception($query);
		FB::info($query,'query ListaColaboradores:buscar');
		$this->result = @mysql_query($query);

		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	
	public function lista_Colaboradores(){
		$colaboradores = array();
		$query = "SELECT id, razon_social FROM colaboradores order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$colaboradores[$row['id']] = $row;
		
		return $colaboradores;
	}
}
?>
