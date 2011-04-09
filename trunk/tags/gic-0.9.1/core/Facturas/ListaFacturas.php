<?php
/**
 * Clase encargada de las búsquedas y listados de Facturas.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaFacturas implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Facturas.
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
	 * Devuelve el número de Facturas almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Facturas.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 1);
	}

	/**
	 * Devuelve el siguiente Factura en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Factura El siguiente Factura en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_factura = $row[0];
		else
			return null;
		return new Factura($id_factura);
	}

	/**
	 * Lanza la búsqueda de Facturas aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Facturas.
	 */
	public function buscar($filtros, $page=0, $paso=0){
		//FB::info($filtros,'filtros ListaFacturas:buscar');
		$filtro ="";
		$join="";
		
		(isset($filtros['id']))?$filtro.=" AND facturas.id = '".$filtros['id']."' ":null;
		(isset($filtros['numero_factura']))?$filtro.=" AND facturas.numero_factura = '".$filtros['numero_factura']."' ":null;		
		(isset($filtros['estado_factura']))?$filtro.=" AND facturas.fk_estado_factura = '".$filtros['estado_factura']."' ":null;		
		
		if(isset($filtros['id_usuario'])){
			$join_ventas = " INNER JOIN ventas ON facturas.fk_venta = ventas.id " ;
			$join_ofertas = " INNER JOIN ofertas ON ofertas.id = ventas.fk_oferta AND ofertas.fk_usuario='".$filtros['id_usuario']."' " ;
		}

		(isset($filtros['base_imponible_desde']))?$filtro.=" AND facturas.base_imponible >= '".$filtros['base_imponible_desde']."' ":null;
		(isset($filtros['base_imponible_hasta']))?$filtro.=" AND facturas.base_imponible <= '".$filtros['base_imponible_hasta']."' ":null;
		
		(isset($filtros['fecha_pago_desde']))?$filtro.=" AND facturas.fecha_pago >= '".$filtros['fecha_pago_desde']."' ":null;
		(isset($filtros['fecha_pago_hasta']))?$filtro.=" AND facturas.fecha_pago <= '".$filtros['fecha_pago_hasta']."' ":null;

		(isset($filtros['fecha_facturacion_desde']))?$filtro.=" AND facturas.fecha_facturacion >= '".$filtros['fecha_facturacion_desde']."' ":null;
		(isset($filtros['fecha_facturacion_hasta']))?$filtro.=" AND facturas.fecha_facturacion <= '".$filtros['fecha_facturacion_hasta']."' ":null;
		
		(isset($filtros['numero_desde']))?$filtro.=" AND facturas.numero >= '".$filtros['numero_desde']."' ":null;		
		(isset($filtros['numero_hasta']))?$filtro.=" AND facturas.numero <= '".$filtros['numero_hasta']."' ":null;
		
		(isset($filtros['year_desde']))?$filtro.=" AND facturas.year >= '".$filtros['year_desde']."' ":null;		
		(isset($filtros['year_hasta']))?$filtro.=" AND facturas.year <= '".$filtros['year_hasta']."' ":null;
		
		if(isset($filtros['cliente'])){
			if(!$join_ventas)
				$join_ventas = " INNER JOIN ventas ON facturas.fk_venta = ventas.id " ;
			
				$join_clientes = " INNER JOIN clientes ON ventas.fk_cliente = clientes.id AND clientes.razon_social LIKE '%".trim($filtros['cliente'])."%' ";
		}
		
		
				//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " facturas.id ";
					break;
				case 'numero_factura':
						$order_by = " facturas.numero_factura ";
					break;
				case 'year':
						$order_by = "facturas.year";
					break;
				case 'fecha_pago':
						$order_by = "facturas.fecha_pago";
					break;
				case 'estado_factura':
						$order_by = "facturas.estado_factura";
					break;
				case 'fecha_facturacion':
						$order_by = "facturas.fecha_facturacion";
				case 'cliente':
					if(!$join_cllientes)
						$join_clientes = " INNER JOIN ventas ON facturas.fk_venta = ventas.id 
								   INNER JOIN clientes ON ventas.fk_cliente = clientes.id  ";
								   
						$order_by = "facturas.clientes.id";
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
			
			
		$query = "SELECT facturas.id
				FROM facturas
					$join_ventas
					$join_clientes
					$join_ofertas				
				WHERE 1
					$filtro
				GROUP BY facturas.id 
				$order		
				$limit;";
		
		FB::info($query,'query ListaFacturas:buscar');
		$this->result = @mysql_query($query);
		
		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	/**
	 * Devuelve un array con la lista de tipos de Factura
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de tipos de facturas.
	 */
	function lista_Estados($todos=null){
		$tipos = array();
		$query = "SELECT id, nombre FROM facturas_estados order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			if($row['id']!=2 || $todos)
                            $tipos[$row['id']] = $row;

		}
		
		return $tipos;
	}
	
}
?>
