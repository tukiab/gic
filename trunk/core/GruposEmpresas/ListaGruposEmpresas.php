<?php
/**
 * Clase encargada de las búsquedas y listados de GruposEmpresas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaGruposEmpresas implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de GruposEmpresas.
	 * 
	 * @see buscar()
	 * @var unknown_type
	 */
	private $result;


	/**
	 * Devuelve el número de GruposEmpresas almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de GruposEmpresas.
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
			$id_GrupoEmpresas = $row[0];
		else
			return null;
		return new GrupoEmpresas($id_GrupoEmpresas);
	}

	/**
	 * Lanza la búsqueda de GruposEmpresas aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de GruposEmpresas.
	 */
	public function buscar($filtros=null){
				
		(isset($filtros['id']))?$filtro.=" AND .id = '".$filtros['id']."' ":null;
		(isset($filtros['nombre']))?$filtro.=" AND nombre LIKE '%".$filtros['nombre']."%' ":null;
		
		$query = "SELECT id FROM grupos_empresas WHERE 1 $filtro
				    GROUP BY id;";
			
		$this->result = @mysql_query($query);
	}
}
?>
