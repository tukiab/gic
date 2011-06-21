<?php
/**
 * Clase encargada de las búsquedas y listados de Ofertas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaOfertas implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Ofertas.
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
	 * Devuelve el número de Ofertas almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Ofertas.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Oferta en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Oferta El siguiente Oferta en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_oferta = $row[0];
		else
			return null;
		return new Oferta($id_oferta);
	}

	/**
	 * Lanza la búsqueda de Ofertas aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Ofertas.
	 */
	public function buscar($filtros, $page=0, $paso=0){
		//FB::info($filtros,'filtros ListaOfertas:buscar');
		$filtro ="";
		
		(isset($filtros['id']))?$filtro.=" AND ofertas.id = '".$filtros['id']."' ":null;
		(isset($filtros['codigo']))?$filtro.=" AND ofertas.codigo = '".$filtros['codigo']."' ":null;
		(isset($filtros['nombre_oferta']))?$filtro.=" AND ofertas.nombre_oferta LIKE '%".$filtros['nombre_oferta']."%' ":null;

		(isset($filtros['no_leida']))?$filtro.=" AND ofertas.leida = '0' ":null;
		(isset($filtros['estado_oferta']))?$filtro.=" AND ofertas.fk_estado_oferta = '".$filtros['estado_oferta']."' ":null;
		(isset($filtros['producto']))?$filtro.=" AND ofertas.fk_tipo_producto = '".$filtros['producto']."' ":null;
		(isset($filtros['proveedor']))?$filtro.=" AND ofertas.fk_proveedor = '".$filtros['proveedor']."' ":null;
		(isset($filtros['cliente']))?$filtro.=" AND ofertas.fk_cliente = '".$filtros['cliente']."' ":null;
		(isset($filtros['colaborador']))?$filtro.=" AND ofertas.fk_colaborador = '".$filtros['colaborador']."' ":null;
		
		(isset($filtros['probabilidad_contratacion']))?$filtro.=" AND ofertas.probabilidad_contratacion = '".$filtros['probabilidad_contratacion']."' ":null;
		
		(isset($filtros['fecha_desde']))?$filtro.=" AND ofertas.fecha >= '".$filtros['fecha_desde']."' ":null;
		(isset($filtros['fecha_hasta']))?$filtro.=" AND ofertas.fecha <= '".$filtros['fecha_hasta']."' ":null;

		(isset($filtros['fecha_definicion_desde']))?$filtro.=" AND ofertas.fecha_definicion >= '".$filtros['fecha_definicion_desde']."' ":null;
		(isset($filtros['fecha_definicion_hasta']))?$filtro.=" AND ofertas.fecha_definicion <= '".$filtros['fecha_definicion_hasta']."' ":null;
		
		(isset($filtros['importe_desde']))?$filtro.=" AND ofertas.importe >= '".$filtros['importe_desde']."' ":null;		
		(isset($filtros['importe_hasta']))?$filtro.=" AND ofertas.importe <= '".$filtros['importe_hasta']."' ":null;
		
		(isset($filtros['codigo_desde']))?$having.=" AND (sub_codigo >= '".$filtros['codigo_desde']."' OR (sub_codigo = 0 AND sub_codigo2 >= '".$filtros['codigo_desde']."') )":null;		
		(isset($filtros['codigo_hasta']))?$having.=" AND (sub_codigo <= '".$filtros['codigo_hasta']."' OR (sub_codigo = 0 AND sub_codigo2 <= '".$filtros['codigo_hasta']."') )":null;

		(isset($filtros['probabilidad_desde']))?$having.=" AND ofertas.probabilidad_de_contratacion >= '".$filtros['probabilidad_desde']."' ":null;		
		(isset($filtros['probabilidad_hasta']))?$having.=" AND ofertas.probabilidad_de_contratacion <= '".$filtros['probabilidad_hasta']."' ":null;
		
		if(isset($filtros['id_usuario']))
			$filtro .= " AND ofertas.fk_usuario = '".$filtros['id_usuario']."'";
		
		(isset($filtros['es_oportunidad_de_negocio']) && ($filtros['es_oportunidad_de_negocio']==0 || $filtros['es_oportunidad_de_negocio'] == 1))?$filtro.=" AND ofertas.es_oportunidad_de_negocio = '".$filtros['es_oportunidad_de_negocio']."' ":null;

		(isset($filtros['aceptado']))?$filtro.=" AND ofertasaceptado = '".$filtros['aceptado']."' ":null;
		
		
		
				//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " ofertas.id ";
					break;
				case 'codigo':
						$order_by = " ofertas.codigo ";
					break;
				case 'nombre_oferta':
						$order_by = "ofertas.nombre_oferta";
					break;
				case 'producto':
						$order_by = "ofertas.fk_tipo_producto";
					break;
				case 'estado_oferta':
						$order_by = "ofertas.estado_oferta";
					break;
				case 'fecha_definicion':
						$order_by = "ofertas.fecha_definicion";
				case 'fecha':
						$order_by = "ofertas.fecha";
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
			
			
		$query = "SELECT ofertas.id, CAST(SUBSTRING_INDEX(codigo,'/',1) AS SIGNED ) as sub_codigo,
    								 CAST(substr(SUBSTRING_INDEX(codigo,'/',1),3) AS SIGNED ) as sub_codigo2
					FROM ofertas		
				    WHERE 1
						$filtro
				    GROUP BY ofertas.id 
				    HAVING 1
						$having
					$order		
					$limit;";
		
	//	//FB::info($query,'query ListaOfertas:buscar');
		$this->result = @mysql_query($query);
		
		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	/**
	 * Devuelve un array con la lista de tipos de Oferta
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de tipos de ofertas.
	 */
	function lista_Estados(){
		$tipos = array();
		$query = "SELECT id, nombre FROM ofertas_estados order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			if($row['id']!=2)$tipos[$row['id']] = $row;
		}
		
		return $tipos;
	}
	
	function lista_Tipos_Productos(){
		$tipos = array();
		$query = "SELECT id, nombre FROM productos_tipos order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Tipos_Proveedores(){
		$tipos = array();
		$query = "SELECT * FROM proveedores;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['NIF']] = $row;
		
		return $tipos;
	}
	
	function lista_Probabilidades(){
		$tipos = array();
		$query = "SELECT id, nombre FROM ofertas_probabilidades;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Colaboradores(){
		$tipos = array();
		$query = "SELECT id, razon_social as nombre FROM colaboradores;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$tipos[$row['id']] = $row;
		
		return $tipos;
	}
	
	function lista_Proveedores(){
		$tipos = array();
		$query = "SELECT id, razon_social as nombre FROM proveedores;";
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
