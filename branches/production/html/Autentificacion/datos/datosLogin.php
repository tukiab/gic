<?php  include ('../appRoot.php');
include ($codeRoot.'/config/dbConect.php');

/**
 * Obtiene datos sobre los usuarios en la BD.
 */
class dataUsers{

	/**
	 * Constructor.
	 */
	function dataUsers(){}
	
	/**
	 * Devuelve los datos de un usuario.
	 */
	function obtenerDatosUsuario($id){ 		
		$query="SELECT * FROM usuarios WHERE id='$id'";
		$result=mysql_query($query);

		return $result;
	}
	
	/**
	 * Inserta un usuario en la tabla usuarios.
	 */
	function insertarUsuario($login, $id){
		
		$query="INSERT INTO usuarios 
			SET nombre='$login',
			id='$id'";
		$result=mysql_query($query);
		
		return $result;
	}
	
	/**
	 * Actualizar datos de un usuario.
	 */
	 function actualizarUsuario($login, $id){
	 	
		$query="UPDATE usuarios 
			SET nombre='$login' 
			WHERE id='$id'";
		$result=mysql_query($query);	
		
		return $result;
	 }
	
}
?>