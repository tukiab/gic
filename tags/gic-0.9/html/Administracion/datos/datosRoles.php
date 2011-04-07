<?php  include('appRoot.php');

//Conexión a la BD
include($codeRoot.'/config/dbConect.php');

/**
 * Clase que gestiona la información de los roles en la BD.
 */
class datosRoles{
	
	public $listaRoles 	= array();
	public $idrol	 			= null;
	public $nombre 			= null;
	public $nombreCorto 	= null;
	public $descripcion	= null;
	
	/**
	 * Constructor.
	 */
	public function datosRoles(){}
	
	public function getListaRoles(){
		$query = 'SELECT * FROM roles';
		$res = mysql_query($query);
		while($fila = mysql_fetch_assoc($res)){
			$this->listaRoles[] = $fila;
		}
		return $this->listaRoles;
	}
	
	public function getDatosRol($idrol_){
		$query = 'SELECT * FROM roles WHERE id="'.$idrol_.'"';
		$res = mysql_query($query);
		if(mysql_num_rows($res)>0){
			$rolaux = mysql_fetch_assoc($res);
			$this->idrol 		= $rolaux['id'];
			$this->nombre 		= $rolaux['nombre'];
			$this->nombreCorto	= $rolaux['nombre_corto'];
			$this->descripcion 	= $rolaux['descripcion'];
			return $this;
		}else{
			return false;
		}
	}
	
	public function delRol($idrol_ = null){
		if($idrol_!=null)
			$id = $idrol_;
		else
			$id = $this->idrol;
			
		//Primero borramos las referencias en otras tablas:
		$del_refs_1 ="DELETE FROM permisos_roles WHERE id_fk_roles='$id'";
		$del_refs_2 ="DELETE FROM operadores_rel_roles WHERE id_fk_roles='$id'";
		$delete = "DELETE FROM roles WHERE id='$id'";
		
		mysql_query($del_refs_1);
		mysql_query($del_refs_2);
		mysql_query($delete);
	}
	
	public function addRol(){
		$insert = 'INSERT INTO roles(id,nombre,nombre_corto,descripcion) 
										VALUES(null,"'.$this->nombre.'","'.$this->nombreCorto.'","'.$this->descripcion.'")';
		$res = mysql_query($insert);
		return $res;
	}
	
	public function setDatos(){
		$update = 'UPDATE roles SET 
						nombre = "'.			$this->nombre.'", 
						nombre_corto = "'.	$this->nombreCorto.'", 
						descripcion = "'.	$this->descripcion.'" 
						WHERE id ="'.		$this->idrol.'"';
		
		$res = mysql_query($update);
		return $res;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getIdRol(){
		return $this->idrol;
	}
	
	public function getNombreCorto(){
		return $this->nombreCorto;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setNombre($nombre_){
		$this->nombre = $nombre_;
	}
	
	public function setIdRol($idrol_){
		$this->idrol = $idrol_;
	}
	
	public function setNombreCorto($nombrecorto_){
		$this->nombreCorto = $nombrecorto_;
	}
	
	public function setDescripcion($descripcion_){
		$this->descripcion = $descripcion_;
	}
	
	
}