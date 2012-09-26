<?  include ('../../appRoot.php');

include ($codeRoot.'/config/dbConect.php');
include ($codeRoot.'/config/mail.php');

/**
 * Clase encargada de realizar las consultas a la BD para obtener listas de operadores.
 */
class Operadores{
	
	/**
	 * Devuelve la lista de operadores pertenecientes al rol $id_rol
	 */
	public function listaOperadores_incidencias($id_rol=''){
		
		($id_rol)?$filtro = "AND operadores_rel_roles.id_fk_roles='$id_rol' ":$filtro='';
		
	$query = "SELECT 	operadores.id,
							operadores.nombre,
							operadores.num_tel,
							operadores.fk_op_estados as id_estado,
							op_estados.nombre as estado,
							COUNT( DISTINCT IF(problemas_rel_inci.id_fk_incidencias IS NOT NULL, NULL, incidencias.id) ) AS num_inc
					FROM operadores
					INNER JOIN operadores_rel_roles
					ON operadores_rel_roles.id_fk_operadores=operadores.id
					LEFT JOIN op_estados
					ON op_estados.id = operadores.fk_op_estados
					LEFT JOIN (incidencias
							INNER JOIN 
							( incidencias_rel_estados AS tmp_inci_rel_est
								INNER JOIN incidencias_estados
								ON tmp_inci_rel_est.id_fk_inci_estados=incidencias_estados.id
								AND tmp_inci_rel_est.id_fecha =
									(SELECT MAX(id_fecha) 
										FROM incidencias_rel_estados
										WHERE incidencias_rel_estados.id_fk_incidencias=tmp_inci_rel_est.id_fk_incidencias
										GROUP BY id_fk_incidencias)
							)
						ON incidencias.id=tmp_inci_rel_est.id_fk_incidencias
						LEFT OUTER JOIN problemas_rel_inci
						ON problemas_rel_inci.id_fk_incidencias = incidencias.id)
					ON incidencias.fk_operadores = operadores.id
					AND tmp_inci_rel_est.id_fk_inci_estados='3'
				WHERE 1 $filtro 
				GROUP BY operadores.id
				ORDER BY operadores.nombre";
		$res = mysql_query($query);
		$array_res = array();
		while($row = mysql_fetch_array($res)){
			array_push($array_res, $row);
		}
		return $array_res;
	}
	
	/**
	 * Devuelve la lista de operadores con incidencias.
	 */
	public function listaOperadoresConIncidencias(){
		$query = "SELECT 	operadores.id, 
							operadores.nombre,
							operadores.num_tel,
							op_estados.id as id_estado,
							op_estados.nombre as estado,
							COUNT(DISTINCT incidencias.id) AS num_inc
					FROM operadores
					INNER JOIN operadores_rel_roles
					ON operadores_rel_roles.id_fk_operadores=operadores.id
					INNER JOIN op_estados
					ON op_estados.id = operadores.fk_op_estados
					INNER JOIN incidencias
					ON incidencias.fk_operadores = operadores.id
					AND incidencias.fecha_fin='0'
				WHERE 1
				GROUP BY operadores.id
				ORDER BY operadores.nombre";
		return mysql_query($query);
	}	
	
	/**
	 * Incidencias sin operador
	 */
	public function getIncNoAsignadas(){
		$query = "SELECT COUNT(id) AS num_inc
				FROM incidencias
				WHERE fk_operadores = ''
				GROUP BY fk_operadores";
		return mysql_fetch_assoc(mysql_query($query));		
	}
	
	/**
	 * Estados de los operadores
	 */
	public function getEstados(){
		$query = "SELECT * 
				FROM op_estados 
				ORDER BY id";
		$res = mysql_query($query);	

		$array_res = array();
		while($row = mysql_fetch_assoc($res)){
			array_push($array_res, $row);
		}
		return $array_res;
	}	
	/**
	 * Cambia el estado del operador
	 */
	public function setEstado($id_operador, $id_estado){
		$query = "UPDATE operadores SET 
				 		fk_op_estados = '$id_estado'
				WHERE id = '$id_operador' ";
		return mysql_query($query);		
	}		
	/**
	 * Devuelve la lista de operadores pertenecientes al rol $id_rol
	 */
	public function listaOperadores_problemas($id_rol=''){
		
		($id_rol)?$filtro = "AND operadores_rel_roles.id_fk_roles='$id_rol' ":$filtro='';
		
		$query = "SELECT 	operadores.id,
							operadores.nombre,
							operadores.num_tel,
							op_estados.nombre as estado,
							op_estados.id as id_estado,
							COUNT( DISTINCT problemas.id) AS num_pr
					FROM operadores
					INNER JOIN operadores_rel_roles
						ON operadores_rel_roles.id_fk_operadores=operadores.id
					INNER JOIN op_estados
						ON op_estados.id = operadores.fk_op_estados
					LEFT OUTER JOIN problemas
						ON problemas.fk_operadores = operadores.id
						AND problemas.fecha_fin='0'
				WHERE 1 $filtro
				GROUP BY operadores.id
				ORDER BY operadores.nombre";
		$res = mysql_query($query);
		$array_res = array();
		while($row = mysql_fetch_array($res)){
			array_push($array_res, $row);
		}
		return $array_res;
	}

	public function listaOperadores_wr($id_rol=''){
		
		($id_rol)?$filtro = "AND operadores_rel_roles.id_fk_roles='$id_rol' ":$filtro='';
		
		$query = "SELECT 	operadores.id,
							operadores.nombre
					FROM operadores
					INNER JOIN operadores_rel_roles
						ON operadores_rel_roles.id_fk_operadores=operadores.id
				WHERE 1 $filtro
				GROUP BY operadores.id
				ORDER BY operadores.nombre";
		$res = mysql_query($query);
		$array_res = array();
		while($row = mysql_fetch_array($res)){
			array_push($array_res, $row);
		}
		return $array_res;
	}
	/**
	 * Problemas sin operador
	 */
	public function getProblemasNoAsignados(){
		$query = "SELECT COUNT(id) AS num_pr
				FROM problemas
				WHERE fk_operadores = ''
				GROUP BY fk_operadores";
		return mysql_fetch_assoc(mysql_query($query));		
	}
	
	/**
	 * Envía un correo electrónico a la lista de operadores
	 */
	public function enviarCorreosProblemaModificado($id_problema, $datos){
		$array_dir = array();
		global $appDir;
		
		foreach($datos as $info){
			$destinatario = $info['id_operador']."@".MAIL_DOM;
			
			$mensaje = utf8_decode("Se ha añadido una actuación al problema '$id_problema', \n asociado a tus incidencias ".$info['lista_inc'].".\n");
			$mensaje .= "\nIncidencias:\n";
				$array_inc = explode(", ", $info['lista_inc']);
				foreach($array_inc as $id_inc)
					$mensaje.="\t http://".SERVER_IP."$appDir/Incidencias/html/ver_incidencia.php?id_inc=".$id_inc."  \n\n ";
			$mensaje .= "\nProblema:\n";
				$mensaje.="\t http://".SERVER_IP."$appDir/Problemas/html/ver_detalles.php?id=".$id_problema." \n\n";
			
			mail($destinatario, 'Aviso de Problema modificado', $mensaje);
		}
		
	}
}

?>