<?php  include('appRoot.php');

//Conexión a la BD
include($codeRoot.'/config/dbConect.php');

/**
 * Clase que gestiona la información de los perfiles en la BD.
 */
class datosPerfiles{

	public $listaPerfiles 	= array();
	public $idperfil 			= null;
	public $nombre 			= null;
	public $nombreCorto 	= null;
	public $descripcion	= null;
												
	/**
	 * Constructor.
	 */
	public function datosPerfiles(){}
	
	public function getListaPerfiles(){
		$query = 'SELECT * FROM usuarios_perfiles';
		$res = mysql_query($query);
		while($fila = mysql_fetch_assoc($res)){
			$this->listaPerfiles[] = $fila;
		}
		return $this->listaPerfiles;
	}
	
	public function getDatosPerfil($idperfil_){
		$query = 'SELECT * FROM usuarios_perfiles WHERE id="'.$idperfil_.'"';
		$res = mysql_query($query);
		if(mysql_num_rows($res)>0){
			$perfilaux = mysql_fetch_assoc($res);
			$this->idperfil 			= $perfilaux['id'];
			$this->nombre 			= $perfilaux['nombre'];
			return $this;
		}else{
			return false;
		}
	}
	
	public function delPerfil($idperfil_ = null){
		if($idperfil_!=null)
			$id = $idperfil_;
		else
			$id = $this->idperfil;

		//Borramos primero las referencias...	
		$del_refs_1 = "DELETE FROM usuarios_perfiles WHERE id_fk_perfil='$id'";
		$del_refs_2 = "UPDATE usuarios SET fk_perfil='1' WHERE fk_perfil='$id'";
		$delete = "DELETE FROM perfiles WHERE id='$id'";
		
		mysql_query($del_refs_1);
		mysql_query($del_refs_2);
		mysql_query($delete);
	}
	
	public function addPerfil(){
		$insert = 'INSERT INTO usuarios_perfiles(id,nombre) 
										VALUES(null,"'.$this->nombre.'"';
		$res = mysql_query($insert);
		return $res;
	}
	
	public function setDatos(){
		$update = 'UPDATE usuarios_perfiles SET 
						nombre = "'.			$this->nombre.'", 
					WHERE id ="'.		$this->idperfil.'"';
		
		$res = mysql_query($update);
		return $res;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getIdPerfil(){
		return $this->idperfil;
	}
	
	public function setNombre($nombre_){
		$this->nombre = $nombre_;
	}
	
	public function setIdPerfil($idperfil_){
		$this->idperfil = $idperfil_;
	}
	

	
}