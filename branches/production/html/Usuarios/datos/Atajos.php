<?php include ('../../appRoot.php');
include ($codeRoot.'/config/dbConect.php');

/**
 * Clase Atajos
 * 
 * 
 * Clase encargada de proveer los metodos necesarios para incorporar y borrar atajos a los usuarios
 * 
 * @name Atajos
 * @author jacampano
 * 
 */

class Atajos {
	
	/**
	 * Da una lista con todos los atajos disponibles
	 * @name getListaAtajosDisponibles
	 *
	 */
	public function getListaAtajosDisponibles(){
		
		$consulta="SELECT * from atajos WHERE id!='1' ORDER BY descripcion";
		$res=mysql_query($consulta);
		
		$resultado = array();
		while($fila=mysql_fetch_array($res))
			array_push($resultado, $fila);	
		return $resultado;
		
	}
	
	/**
	 * Da una lista con los atajos por defecto 
	 * (caso de que el usuario aún no tenga ninguno definidos)
	 * @name getListaAtajosPorDefecto
	 *
	 */
	public function getListaAtajosPorDefecto(){
		
		$consulta="SELECT * from atajos WHERE id='1'";
		$res=mysql_query($consulta);
		
		$resultado = mysql_fetch_array($res);
		return $resultado;
		
	}
	
	/**
	 *  Da la lista con los atajos del usuario
	 * @name getListaAtajosUsuario
	 * @param String $id_usuario:
	 * 			$id_usuario = $_SESSION['usuario_login']
	 */
	
	public function getListaAtajosUsuario($id_usuario){
		
		$consulta="SELECT atajos.id AS AtajoID,atajos.nombre AS AtajoNombre,atajos.descripcion AS AtajoDescripcion, 
							atajos.url AS AtajoURL
					FROM atajos
					INNER JOIN (usuarios_rel_atajos INNER JOIN usuarios on usuarios_rel_atajos.fk_usuario=usuarios.id)
									ON usuarios_rel_atajos.fk_atajo=atajos.id
					WHERE usuarios.id LIKE '$id_usuario'
					";
		$res=mysql_query($consulta);
		
		
		$resultado = array();
		while(@$fila=mysql_fetch_array($res)){
			array_push($resultado, $fila);
		}
		return $resultado;
	}
	
	/**
	 * Añade un determinado atajo a un usuario
	 * @name addAtajosUsuario
	 * @param String $id_usuario
	 * @param int $id_atajo
	 * @param int $orden
	 */
	
	public function addAtajosUsuario($id_usuario,$id_atajo){
		
		$consulta="INSERT INTO usuarios_rel_atajos(fk_usuario,fk_atajo) VALUES ('$id_usuario',$id_atajo)";
		
		if($id_atajo)
			$res=mysql_query($consulta);
			
	}
			
	/**
	 * Elimina un atajo al usuario
	 * @name delAtajosusuario
	 * @param String $id_usuario
	 * @param int $id_atajo
	 */
	
	public function delAtajosUsuario($id_usuario,$id_atajo){
		
		$consulta="DELETE FROM usuarios_rel_atajos WHERE fk_usuario LIKE '$id_usuario' AND fk_atajo=$id_atajo";
		
		$res=mysql_query($consulta);
	}
	/**
	 * Borra al completo los atajos del usuario X
	 * @name borrarTodosAtajosUsuario
	 * @param String $id_usuario
	 * 
	 */
	public function borrarTodosAtajosUsuario($id_usuario){
		
		$consulta="DELETE FROM usuarios_rel_atajos WHERE fk_usuario LIKE '$id_usuario'";
		
		$res=mysql_query($consulta);
	}
}
?>