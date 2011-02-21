<?php
/**
 * Clase encargada de las búsquedas y listados de Usuarios.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaUsuarios implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Usuarios.
	 * 
	 * @see buscar()
	 * @var unknown_type
	 */
	private $result;


	/**
	 * Devuelve el número de Usuarios almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Usuarios.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente Usuario en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Usuario El siguiente Usuario en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_usuario = $row[0];
		else
			return null;
		return new Usuario($id_usuario);
	}

	/**
	 * Lanza la búsqueda de Usuarios aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Usuarios.
	 */
	public function buscar($filtros=null){
		$filtro ="";
		$join="";
		
		(isset($filtros['id']))?$filtro.=" AND usuarios.id = '".$filtros['id']."' ":null;
		(isset($filtros['password']))?$filtro.=" AND usuarios.password LIKE '%".$filtros['password']."%' ":null;
		(isset($filtros['perfil']))?$join .= " INNER JOIN usuarios_perfiles ON usuarios.fk_perfil = '".$filtros['perfil']."'":null;
		(isset($filtros['nombre']))?$filtro.=" AND usuarios.nombre LIKE '%".$filtros['nombre']."%' ":null;
		(isset($filtros['apellidos']))?$filtro.=" AND usuarios.apellidos LIKE '".$filtros['apellidos']."' ":null;
		
		$query = "SELECT usuarios.id
					FROM usuarios
						$join				
				    WHERE 1
						$filtro
				    GROUP BY usuarios.id;";
		$this->result = @mysql_query($query);
	}
	
	/**
	 * Devuelve un array con la lista de perfiles de Usuario
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de perfiles de Usuario.
	 */
	function lista_Perfiles(){
		$perfiles = array();
		$query = "SELECT id, nombre FROM usuarios_perfiles order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$perfiles[$row['id']] = $row;
		
		return $perfiles;
	}
	/**
	 * Devuelve un array con la lista de Usuario
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de Usuarios.
	 */
	function lista_Usuarios(){
		$usuarios = array();
		$query = "SELECT id, nombre FROM usuarios";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$usuarios[$row['id']] = $row;
		
		return $usuarios;
	}
	
}
?>
