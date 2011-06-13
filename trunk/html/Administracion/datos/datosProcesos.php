<?php  include('appRoot.php');

//Conexión a la BD
include($codeRoot.'/config/dbConect.php');

/**
 * Clase que gestiona la información de los procesos en la BD según los scripts de la aplicación.
 */
class datosProcesos{

	public $listaProcesos 	= array();
	public $idproceso			= null;
	public $proceso 			= null;
	public $descripcion		= null;
	
	/**
	 * Constructor.
	 */
	public function datosProcesos(){}

	/**
	 * Devuelve el id del proceso al que pertenece el script pasado como parámetro.
	 *
	 * @param string $ruta_script	Ruta hacia el script
	 */
	public function getIdProceso($ruta_script){
		/*
		 * Si el script está en la BD, devolverá el id del proceso al que pertenece.
		 * Si no, se insertará con fk_proceso=1 (Proceso Genérico)
		 */
		$id=1;
		$query_busca = "SELECT fk_proceso
						FROM scripts 
						WHERE ruta LIKE '$ruta_script' ";
		
		$res_busca = mysql_query($query_busca);
		if(mysql_num_rows($res_busca)==0){
			$query_insert = "INSERT INTO scripts SET fk_proceso='$id', ruta='$ruta_script' ";
			mysql_query($query_insert);
		}
		else{
			$row = mysql_fetch_array($res_busca);
			$id = $row['fk_proceso'];
		}
		
		return $id;
	}
	
	/**
	 * Devuelve los permisos para el perfil $id_perfil y los roles en $array_roles para 
	 * el proceso $id_proceso.
	 *
	 * @param int $id_proceso		Id del proceso
	 * @param int $id_perfil			Id del perfil
	 * @param array $array_roles	Lista de Ids de roles
	 */
	public function getPermisos($id_proceso, $id_perfil){
		/*
		 * Devuelve un array del tipo:
		 * array('lectura'=> bool, 'escritura'=> bool);
		 */	
		$qry 	= "SELECT SQL_CACHE * FROM permisos_usuarios_perfiles WHERE fk_perfil='$id_perfil' AND fk_proceso='$id_proceso'";
		$res 	= mysql_query($qry);
		$grp 	= mysql_fetch_assoc($res);
		////FB::info($qry,'query permisos');
		
		$prm['lectura'] 		= $grp['lectura'];
		$prm['escritura']	= $grp['escritura'];
		$prm['administracion'] = $grp['administracion'];
		
		return array('lectura'=> $prm['lectura'], 'escritura'=> $prm['escritura'], 'administracion'=> $prm['administracion']);
	}
	
	/**
	 * Establece los permisos en la BD para un proceso determinado (perfiles)
	 * @param array $datos 	contiene, a su vez, 2 arrays con los permisos de los perfiles
	 */
	public function setPermisos($id_proceso,$datos){
		$perfiles_aux = $datos['perfiles'];
		
		foreach($perfiles_aux as $id=>$perms){
			$query = 'UPDATE permisos_usuarios_perfiles 
							SET lectura="'.$perms['lectura'].'",escritura="'.$perms['escritura'].'",administracion="'.$perms['administracion'].'"   
							WHERE fk_perfil='.$id.' AND fk_proceso='.$id_proceso;
			$res = mysql_query($query);
			$afectado = mysql_affected_rows();
			if($afectado==0){
				$query2 = 'SELECT * 
								FROM permisos_usuarios_perfiles 
								WHERE fk_perfil='.$id.' AND fk_proceso='.$id_proceso;
				$res2 = mysql_query($query2);

				if(mysql_num_rows($res2)==0){
					$insert = "INSERT INTO permisos_usuarios_perfiles(fk_perfil,fk_proceso,lectura,escritura,administracion)
									VALUES ($id,$id_proceso,$perms[lectura],$perms[escritura],$perms[administracion])";
					mysql_query($insert);
				}
			}
		}
	}
	
	/**
	 * Devuelve la lista de permisos del proceso $id_proceso.
	 *
	 * Debe devolver
	 * 	array(
	 * 			'perfiles'=>array('g1'=>permisos, 'gn'=>permisos)
	 * 	);
	 */
	public function getListaPermisos($id_proceso){
		//testing
		global $appRoot;
		include_once ($appRoot.'/Administracion/datos/datosperfiles.php');
		include_once ($appRoot.'/Administracion/datos/datosRoles.php');
		$db_perfiles = new datosPerfiles();
		
		$listaperfiles = $db_perfiles->getListaPerfiles();
		$array_ret = array();
		
		foreach($listaperfiles as $perfil){
			// TODO : Hacer una consulta por cada  me parece una chapuza, optimizar
			$query = 'SELECT * FROM permisos_usuarios_perfiles WHERE fk_perfil='.$perfil['id'].' AND fk_proceso='.$id_proceso;
			$res = mysql_query($query);
			if(mysql_num_rows($res)>0){
				$fila = mysql_fetch_assoc($res);
				$array_ret['perfiles'][$perfil['id']]=array('lectura'=>$fila['lectura'], 'escritura'=>$fila['escritura'], 'administracion'=>$fila['administracion']);			
			}else{
				$array_ret['perfiles'][$perfil['id']]=array('lectura'=>false, 'escritura'=>false, 'administracion'=>false);
			}
			
		}
		
		return $array_ret;
	}
	
	/**
	 * Devuelve la lista de todos los procesos
	 *
	 * @return array
	 */
	public function getListaProcesos(){
		//testing
		$query = 'SELECT * FROM procesos';
		$res = mysql_query($query);
		while($fila = mysql_fetch_assoc($res)){
			$this->listaProcesos[] = $fila;
		}
		return $this->listaProcesos;
		
	}
	
	/**
	 * Devuelve los datos de el proceso $id_proceso
	 */
	public function getProceso($id_proceso){
		$query = 'SELECT * FROM procesos WHERE id="'.$id_proceso.'"';
		$res = mysql_query($query);
		if(mysql_num_rows($res)>0){
			
			while($proceso = mysql_fetch_assoc($res)){
				if($proceso['id']==$id_proceso)
					return $proceso;
			}
			return $this;
		}else{
			return false;
		}
		
				
		return null;
	}
	
	/**
	 * Devuelve los datos de el proceso $id_proceso
	 */
	public function getScript($ruta){
		$query = 'SELECT * FROM scripts WHERE ruta="'.$ruta.'"';
		$res = mysql_query($query);
		if(mysql_num_rows($res)>0){		
			$script = mysql_fetch_assoc($res);
			return $script;
		}else{
			return null;
		}
		
				
		return null;
	}	
}
	