<?php
/**
 * Clase encargada de las búsquedas y listados de Visitas.
 *
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaVisitasDeSeguimiento implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Visitas.
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
	 * Devuelve el número de Visitas almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Visitas.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Visita en la lista y avanza el puntero.
	 *
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 *
	 * @return Object $Visita El siguiente Visita en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_visita = $row[0];
		else
			return null;
		return new VisitaDeSeguimiento($id_visita);
	}

	/**
	 * Lanza la búsqueda de Visitas aplicando los filtros pasados como parámetro.
	 *
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 *
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Visitas.
	 */
	public function buscar($filtros){

		$filtro ="";
		$join="";

		(isset($filtros['id']))?$filtro.=" AND visitas_de_seguimiento.id = '".$filtros['id']."' ":null;

		(isset($filtros['fecha_desde']))?$filtro.=" AND visitas_de_seguimiento.fecha >= '".$filtros['fecha_desde']."' ":null;
		(isset($filtros['fecha_hasta']))?$filtro.=" AND visitas_de_seguimiento.fecha <= '".$filtros['fecha_hasta']."' ":null;

		if(isset($filtros['gestor']) &&($filtros['gestor'] != ''))
			$filtro .= " AND visitas_de_seguimiento.fk_usuario = '".$filtros['gestor']."'";

		if(isset($filtros['id_proyecto']))
			$filtro .= " AND visitas_de_seguimiento.fk_proyecto = '".$filtros['fk_proyecto']."'";

		if(isset($filtros['id_sede']))
			$filtro .= " AND visitas_de_seguimiento.fk_sede = '".$filtros['fk_sede']."'";

		if(isset($filtros['nombre_proyecto']))
			$join .= "INNER JOIN proyectos ON visitas_de_seguimiento.fk_proyecto = proyectos.id AND proyectos.nombre LIKE '".$filtros['nombre_proyecto']."' ";

		if(isset($datos['nombre_cliente'])){
			if(!$join)
				$join .= " INNER JOIN proyectos ON visitas_de_seguimiento.fk_proyecto = proyectos.id ";

			$join .= " INNER JOIN clientes ON clientes.id = proyectos.fk_cliente AND clientes.nombre LIKE '".$filtros['nombre_empresa']."'";
		}

		$order = "ORDER BY fecha, hora";


		$query = "SELECT visitas_de_seguimiento.id
					FROM visitas_de_seguimiento
						$join
				    WHERE 1
						$filtro
				    GROUP BY visitas_de_seguimiento.id $order ;";
		FB::error($query);
		$this->result = @mysql_query($query);

		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
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