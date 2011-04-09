<?php
/**
 * Clase encargada de las búsquedas y listados de Contactos.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaContactos implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Contactos.
	 * 
	 * @see buscar()
	 * @var unknown_type
	 */
	private $result;


	/**
	 * Devuelve el número de Contactos almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Contactos.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente Contacto en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Contacto El siguiente Contacto en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_contacto = $row[0];
		else
			return null;
		return new Contacto($id_contacto);
	}

	/**
	 * Lanza la búsqueda de Contactos aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Contactos.
	 */
	public function buscar($filtros){
		FB::info($filtros,'filtros ListaContactos:buscar');
		$filtro ="";
		$join="";
		
		(isset($filtros['email']))?$filtro.=" AND contactos.email LIKE '".$filtros['email']."' ":null;
		(isset($filtros['cargo']))?$filtro.=" AND contactos.cargo LIKE '%".$filtros['cargo']."%' ":null;
		(isset($filtros['comision_por_renovacion']))?$filtro.=" AND contactos.comision_por_renovacion = '".$filtros['comision_por_renovacion']."' ":null;
		(isset($filtros['comision']))?$filtro.=" AND contactos.comision = '".$filtros['comision']."' ":null;
		(isset($filtros['fax']))?$filtro.=" AND contactos.fax = '".$filtros['fax']."' ":null;
		(isset($filtros['nombre']))?$filtro.=" AND contactos.nombre LIKE '%".$filtros['nombre']."%' ":null;
		(isset($filtros['movil']))?$filtro.=" AND contactos.movil = '".$filtros['movil']."' ":null;
		(isset($filtros['telefono']))?$filtro.=" AND contactos.telefono <= '".$filtros['telefono']."' ":null;
		
		$query = "SELECT contactos.id
					FROM contactos	
					$join			
				    WHERE 1
						$filtro
				    GROUP BY contactos.id;";
		
		FB::info($query,'query ListaContactos:buscar');
		$this->result = @mysql_query($query);
	}
	
	
}
?>
