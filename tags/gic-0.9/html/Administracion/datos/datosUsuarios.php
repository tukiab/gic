<?php  include('appRoot.php');

//Conexión a la BD
include($codeRoot.'/config/dbConect.php');

/**
 * Clase que gestiona la información de los usuarios en la BD referente a Perfiles y Roles.
 */
class datosUsuarios{
	
	/**
	 * Constructor.
	 */
	public function datosUsuarios(){}
	
	/**
	 * Devuelve la lista de usuarios 
	 * @param string $filtro Nombre (o comienzo del nombre) del usuario/s buscado/s
	 */
	public function getListaUsuarios($filtro=''){
		($filtro!='')?$filtro="WHERE id IN ( $filtro ) ":null;
		
		$query = "SELECT * FROM usuarios $filtro ORDER BY id";

		$result = mysql_query($query);
		$ret_array = array();
		while($row = mysql_fetch_array($result)){
			array_push($ret_array, array('id'=>$row['id'], 'nombre'=>$row['nombre']));
		}
		return $ret_array;
	}
	
	/**
	 * Devuelve un array con el perfil y roles del usuario
	 *
	 * @param string $id
	 */
	public function getDatosUsuario($id){
		/*
		 * Devuelve un array en formato:
		 * 		$array['perfil'] = $id_perfil;
		 * 		$array['roles'][$id_rol] = true;
		 */
		//return array('perfil'=>'5', 'roles'=>array('1'=>true, '4'=>true, '6'=>true));
		$perfil 	= "SELECT * FROM usuarios WHERE id='$id'";
		$res 	= mysql_query($perfil);
		$perfil 	= mysql_fetch_assoc($res);
		
		return array('perfil'=>$perfil['fk_perfil'],'nombre'=>$perfil['nombre'],'apellidos'=>$perfil['apellidos']);
	}
	
	/**
	 * Dado un id de usuario y un array con datos (perfil) establecerá ese perfil al usuario
	 *
	 * @param string $id
	 * @param array $datos
	 */
	public function setPerfil($id,$datos){
		$update = 'UPDATE usuarios SET fk_perfil='.$datos['perfil'].' WHERE id="'.$id.'"';
		mysql_query($update);
	}
	

	
}