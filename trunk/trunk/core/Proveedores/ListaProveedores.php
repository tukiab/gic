<?php
/**
 * Clase encargada de las búsquedas y listados de Proveedores.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaProveedores implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Proveedores.
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
	 * Devuelve el número de Proveedores almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Proveedores.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Proveedor en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Proveedor El siguiente Proveedor en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$NIF_proveedor = $row[0];
		else
			return null;
		return new Proveedor($NIF_proveedor);
	}

	/**
	 * Lanza la búsqueda de Proveedores aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Proveedores.
	 */
	public function buscar($filtros, $page=0, $paso=0){
		//FB::info($filtros,'filtros ListaProveedores:buscar');
		$filtro ="";
		$join="";
		
		(isset($filtros['NIF']))?$filtro.=" AND proveedores.NIF = '".$filtros['NIF']."' ":null;
		(isset($filtros['razon_social']))?$filtro.=" AND proveedores.razon_social LIKE '%".$filtros['razon_social']."%' ":null;
		(isset($filtros['provincia']))?$filtro.=" AND proveedores.provincia LIKE '%".$filtros['provincia']."%' ":null;
		(isset($filtros['domicilio']))?$filtro.=" AND proveedores.domicilio LIKE '%".$filtros['domicilio']."%' ":null;
		(isset($filtros['localidad']))?$filtro.=" AND proveedores.localidad LIKE '".$filtros['localidad']."' ":null;
		(isset($filtros['CP']))?$filtro.=" AND proveedores.CP = '".$filtros['CP']."' ":null;
		
		(isset($filtros['web']))?$filtro.=" AND proveedores.web LIKE '%".$filtros['web']."%' ":null;
		
		
		
		if(isset($filtros['id_usuario'])){
			$join .= " INNER JOIN proveedores_rel_usuarios ON proveedores.NIF = proveedores_rel_usuarios.fk_proveedor ";
			$filtro .= " AND proveedores_rel_usuarios.fk_usuario = '".$filtros['id_usuario']."'";
		}
		
		
		//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'NIF':
						$order_by = " proveedores.NIF ";
					break;
				case 'razon_social':
						$order_by = " proveedores.razon_social ";
					break;
				case 'provincia':
						$order_by = " proveedores.provincia ";
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
		
		$query = "SELECT SQL_CALC_FOUND_ROWS proveedores.NIF
					FROM proveedores
						$join				
				    WHERE 1
						$filtro
				    GROUP BY proveedores.NIF $order
					$limit;";
		
		$this->result = @mysql_query($query);

		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}

	public static function proveedor_array($id){
		$query = "SELECT id, razon_social FROM proveedores WHERE id='$id' LIMIT 1";
		if(!$result = mysql_query($query))
			throw new Exception("Proveedor incorrecto");

		$row = mysql_fetch_array($result);
		return $row;
	}
}
?>
