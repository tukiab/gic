<?php
/**
 * Clase encargada de las búsquedas y listados de Clientes.
 * 
 * Además, obtiene dela BBDD las opciones necesarias para los desplegables en las interfaces de búsqueda.
 */
class ListaClientes implements IIterador{
	/**
	 * Almacena el resultado de la búsqueda de Clientes.
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
	 * Devuelve el número de Clientes almacenados en la búsqueda.
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
	 * Devuelve el puntero al inicio de la lista de Clientes.
	 */
	public function inicio(){
		@mysql_data_seek($this->result, 0);
	}

	/**
	 * Devuelve el siguiente Cliente en la lista y avanza el puntero.
	 * 
	 * Devuelve NULL si ya se ha llegado al último elemento.
	 * 
	 * @return Object $Cliente El siguiente Cliente en la lista.
	 */
	public function siguiente(){
		if($row = @mysql_fetch_row($this->result))
			$id_cliente = $row[0];
		else
			return null;
		return new Cliente($id_cliente);
	}

	/**
	 * Lanza la búsqueda de Clientes aplicando los filtros pasados como parámetro.
	 * 
	 * La variable local $result es actualizada con el resultado de la búsqueda.
	 * 
	 * @param array $filtros Lista de filtros a aplicar a la búsqueda de Clientes.
	 */
	public function buscar($filtros=null, $page=0, $paso=0){
		//FB::info($filtros,'filtros ListaClientes:buscar');
		$filtro ="";
		$join="";

		if(isset($filtros['cliente_principal'])){
			$filtro.=" AND clientes.cliente_principal = '1' ";
			$limit = " LIMIT 1 ";
		}
		(isset($filtros['id']))?$filtro.=" AND clientes.id = '".trim($filtros['id'])."' ":null;
		(isset($filtros['razon_social']))?$filtro.=" AND clientes.razon_social LIKE '%".trim($filtros['razon_social'])."%' ":null;
		(isset($filtros['tipo_cliente']))?$filtro .= " AND clientes.fk_tipo_cliente = '".trim($filtros['tipo_cliente'])."'":null;
		if(isset($filtros['grupo_empresas'])){
			$filtro .= " AND clientes.fk_grupo_empresas = '".trim($filtros['grupo_empresas'])."'";
		}
		(isset($filtros['NIF']))?$filtro.=" AND clientes.NIF LIKE '".trim($filtros['NIF'])."' ":null;
		(isset($filtros['domicilio']))?$filtro.=" AND clientes.domicilio LIKE '%".trim($filtros['domicilio'])."%' ":null;
		(isset($filtros['provincia']))?$filtro.=" AND clientes.provincia LIKE '%".trim($filtros['provincia'])."%' ":null;
		(isset($filtros['localidad']))?$filtro.=" AND clientes.localidad LIKE '%".trim($filtros['localidad'])."%' ":null;
		(isset($filtros['CP']))?$filtro.=" AND clientes.CP = '".trim($filtros['CP'])."' ":null;
		(isset($filtros['FAX']))?$filtro.=" AND clientes.FAX = '".trim($filtros['FAX'])."' ":null;
		(isset($filtros['telefono']))?$filtro.=" AND clientes.telefono = '".trim($filtros['telefono'])."' ":null;
		(isset($filtros['numero_empleados_min']))?$filtro.=" AND clientes.numero_empleados >= '".trim($filtros['numero_empleados_min'])."' ":null;
		(isset($filtros['numero_empleados_max']))?$filtro.=" AND clientes.numero_empleados <= '".trim($filtros['numero_empleados_max'])."' ":null;
		(isset($filtros['web']))?$filtro.=" AND clientes.web LIKE '%".trim($filtros['web'])."%' ":null;
		(isset($filtros['sector']))?$filtro.=" AND clientes.sector LIKE '%".trim($filtros['sector'])."%' ":null;
		(isset($filtros['SPA_actual']))?$filtro.=" AND clientes.SPA_actual LIKE '%".trim($filtros['SPA_actual'])."%' ":null;
		(isset($filtros['fecha_renovacion_desde']))?$filtro.=" AND clientes.fecha_renovacion >= '".trim($filtros['fecha_renovacion_desde'])."' ":null;
		(isset($filtros['fecha_renovacion_hasta']))?$filtro.=" AND clientes.fecha_renovacion <= '".trim($filtros['fecha_renovacion_hasta'])."' ":null;
		(isset($filtros['norma_implantada']))?$filtro.=" AND clientes.norma_implantada LIKE '%".trim($filtros['norma_implantada'])."%' ":null;
		(isset($filtros['creditos_desde']))?$filtro.=" AND clientes.creditos >= '".trim($filtros['creditos_desde'])."' ":null;		
		(isset($filtros['creditos_hasta']))?$filtro.=" AND clientes.creditos <= '".trim($filtros['creditos_hasta'])."' ":null;
		
		
		if(isset($filtros['id_usuario'])){
			$join .= " INNER JOIN clientes_rel_usuarios ON clientes.id = clientes_rel_usuarios.fk_cliente ";
			$filtro .= " AND clientes_rel_usuarios.fk_usuario = '".trim($filtros['id_usuario'])."'";
		}
		
		if(isset($filtros['contacto'])){
			$join_contactos = " INNER JOIN clientes_rel_contactos ON clientes.id = clientes_rel_contactos.fk_cliente AND clientes_rel_contactos.fk_contacto <> '0' 
							INNER JOIN contactos ON contactos.id = clientes_rel_contactos.fk_contacto ";
			
			if(isset($filtros['contacto']['nombre']))
				$join_contactos .= " AND contactos.nombre LIKE '%".trim($filtros['contacto']['nombre'])."%' ";
				
			if(isset($filtros['contacto']['telefono']))
				$join_contactos .= " AND contactos.telefono LIKE '%".trim($filtros['contacto']['telefono'])."%' ";

			if(isset($filtros['contacto']['cargo']))
				$join_contactos .= " AND contactos.cargo LIKE '%".trim($filtros['contacto']['cargo'])."%' ";
			
			if(isset($filtros['contacto']['email']))
				$join_contactos .= " AND contactos.email LIKE '%".trim($filtros['contacto']['email'])."%' ";
				
		}
		
		if(isset($filtros['acciones'])){
			
			if(isset($filtros['acciones']['acciones_de_trabajo_futuras'])){
				if($filtros['acciones']['acciones_de_trabajo_futuras'] == 1)
					$filtro .= " AND clientes.id IN(SELECT clientes.id FROM clientes
  															INNER JOIN acciones_de_trabajo ON clientes.id = acciones_de_trabajo.fk_cliente 
  															AND acciones_de_trabajo.fecha_siguiente_accion >= '".fechaActualTimeStamp()."') ";
				else
					$filtro .= " AND clientes.id NOT IN(SELECT clientes.id FROM clientes
	  									INNER JOIN acciones_de_trabajo ON clientes.id = acciones_de_trabajo.fk_cliente 
	  									AND acciones_de_trabajo.fecha_siguiente_accion >= '".fechaActualTimeStamp()."') ";

					
			}
		}
		
		//El orden establecido...
		if(isset($filtros['order_by'])){
			switch($filtros['order_by']){
				case 'id':
						$order_by = " clientes.id ";
					break;
				case 'razon_social':
						$order_by = " clientes.razon_social ";
					break;
				case 'tipo_cliente':
						$order_by = "clientes.tipo_cliente";
					break;
				case 'grupo_empresas':
						$order_by = "clientes.fk_grupo_empresas";
					break;
				case 'localidad':
						$order_by = "clientes.localidad";
					break;
				case 'fecha_renovacion':
						$order_by = "clientes.fecha_renovacion";
					break;
				case 'grupo_empresas':
						$order_by='clientes.fk_grupo_empresas';
					break;
				case 'CP':
						$order_by = "clientes.CP";
					break;
				case 'web':
						$order_by = "clientes.web";
					break;
				case 'sector':
						$order_by = "clientes.sector";
					break;
				case 'SPA_actual':
						$order_by = "clientes.SPA_actual";
					break;
				case 'numero_de_empleados':
						$order_by='clientes.numero_empleados';
					break;
				case 'domicilio':
						$order_by = "clientes.domicilio";
					break;
				case 'telefono':
						$order_by = "clientes.telefono";
					break;
				case 'ultima_accion':
						$join .= " LEFT OUTER JOIN acciones_de_trabajo ON clientes.id = acciones_de_trabajo.fk_cliente";
						$order_by = "acciones_de_trabajo.fecha";
					break;
				case 'contactos':
						if(!$join_contactos)
							$join_contactos = " INNER JOIN clientes_rel_contactos ON clientes.id = clientes_rel_contactos.fk_cliente AND clientes_rel_contactos.fk_contacto <> '0' 
							INNER JOIN contactos ON contactos.id = clientes_rel_contactos.fk_contacto ";
						$order_by = "contactos.nombre";
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
		
		$query = "SELECT SQL_CALC_FOUND_ROWS clientes.id
					FROM clientes
						$join				
						$join_contactos
				    WHERE 1
						$filtro
				    GROUP BY clientes.id $order
					$limit;";
		//throw new Exception($query);
		//FB::info($query,'query ListaClientes:buscar');
		$this->result = @mysql_query($query);

		//Obtenemos el número total de resultados sin paginar:
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
	
	/**
	 * Devuelve un array con la lista de tipos de Cliente
	 * 
	 * Cada posición del array indexado contiene: 'id' y 'nombre'
	 * 
	 * @return array $tipos Lista de tipos de clientes.
	 */
	function lista_Tipos($filtros=null){
            if(isset($filtros['nombre'])){
                $filtro = " AND nombre LIKE '".trim($filtros['nombre'])."' ";
            }
            $tipos = array();
            $query = "SELECT id, nombre FROM clientes_tipos WHERE 1 $filtro order by id;";
            $result = mysql_query($query);
            while($row = mysql_fetch_array($result))
                $tipos[$row['id']] = $row;

            return $tipos;
	}
	
	function lista_Grupos_Empresas(){
		$tipos = array();
		$query = "SELECT id, nombre FROM grupos_empresas";
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
	
	public function lista_Clientes(){
		$clientes = array();
		$query = "SELECT id, razon_social FROM clientes order by id;";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$clientes[$row['id']] = $row;
		
		return $clientes;
	}

	public static function get_Cliente_Principal(){
		$this->buscar(array('cliente_principal' => true));
		return $this->siguiente();
	}

	public function get_Id_Cliente_Principal(){
		$cliente = $this->get_Cliente_Principal();
		return $cliente->get_Id();
	}

	public static function cliente_array($id){
		$query = "SELECT id,razon_social FROM clientes WHERE id = '$id' LIMIT 1;";
		if(!$result=  mysql_query($query))
			throw new Exception('No se ha definido una empresa correcta');
		$row = mysql_fetch_array($result);
		return $row;
	}
}
?>
