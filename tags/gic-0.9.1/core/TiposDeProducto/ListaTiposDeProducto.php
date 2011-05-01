<?php
/**
 * Clase encargada de las búsquedas y listados de GruposEmpresas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaTiposDeProducto implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de TipoDeProducto.
	 * 
	 * @see buscar()
	 * @var unknown_type
	 */
	private $result;


	/**
	 * Devuelve el número de TipoDeProducto almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de TipoDeProducto.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente GrupoEmpresas en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $GrupoEmpresas El siguiente GrupoEmpresas en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_TipoDeProducto = $row[0];
		else
			return null;
		return new TipoDeProducto($id_TipoDeProducto);
	}

	/**
	 * Lanza la búsqueda de TipoDeProducto aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de TipoDeProducto.
	 */
	public function buscar($filtros=null){
		//FB::info($filtros,'filtros ListaTipoDeProducto:buscar');
		
		(isset($filtros['id']))?$filtro.=" AND .id = '".$filtros['id']."' ":null;
		(isset($filtros['nombre']))?$filtro.=" AND nombre LIKE '%".$filtros['descripcion']."%' ":null;
		
		$query = "SELECT id FROM productos_tipos WHERE 1 $filtro
				    GROUP BY id;";
		FB::info($query,'buscar grupos');
	
		$this->result = @mysql_query($query);
	}
}
?>