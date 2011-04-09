<?php	include ('../appRoot.php');

	//Acceso a datos
	include($appRoot."/Administracion/datos/datosUsuarios.php");
	include($appRoot."/Administracion/datos/datosProcesos.php");


/**
 * Clase que gestiona la consulta de permisos para los usuarios.
 */
class Permisos{
	
	//Permisos sobre el script pasado en el constructor
	public $lectura = false;
	public $escritura = false;
	public $administracion = false;
	
	//Id del perfil
	public $perfil;
	
	//Variables de acceso a datos:
	private $datos_usuario;
	private $DB_procesos;
	
	/**
	 * Constructor de la clase.
	 * A partir del id del usuario y el script, establece las variables
	 * locales $lectura y $escritura según los permisos del primero sobre el segundo.
	 *
	 * @param string $uid 		Id del usuario
	 * @param string $script	Ruta del escript
	 */
	public function Permisos($uid, $script){
		$DB_usuarios = new datosUsuarios();
		$this->DB_procesos = new datosProcesos();
		
		$id_proceso = $this->getProceso($script);
		$this->datos_usuario = $DB_usuarios->getDatosUsuario($uid);
		$this->perfil = $this->datos_usuario['perfil'];
		
		$permisos = $this->DB_procesos->getPermisos($id_proceso, $this->datos_usuario['perfil']);
		
		$this->lectura = $permisos['lectura'];
		$this->escritura = $permisos['escritura'];
		$this->administracion = $permisos['administracion'];
		
	}
	
	/**
	 * Devuelve el permiso de lectura sobre el script pasado como parámetro.
	 * Si no se especifica, devuelve el permiso sobre el script especificado en el constructor.
	 * 
	 * @param string $script
	 * @return bool $permisos['lectura']
	 */
	public function permisoLectura($script=''){
		if($script=='')
			return $this->lectura;
		else{
			$id_proceso = $this->getProceso($script);
			$permisos = $this->DB_procesos->getPermisos($id_proceso, $this->datos_usuario['perfil']);
			return $permisos['lectura'];
		}
	}
	
	/**
	 * Devuelve el permiso de escritura sobre el script pasado como parámetro.
	 * Si no se especifica, devuelve el permiso sobre el script especificado en el constructor.
	 * 
	 * @param string $script
	 * @return bool $permisos['escritura']
	 */
	public function permisoEscritura($script=''){
		if($script=='')
			return $this->escritura;
		else{
			$id_proceso = $this->getProceso($script);
			$permisos = $this->DB_procesos->getPermisos($id_proceso, $this->datos_usuario['perfil']);
			return $permisos['escritura'];
		}
	}
	
	/**
	 * Devuelve el permiso de administración sobre el script pasado como parámetro.
	 * Si no se especifica, devuelve el permiso sobre el script especificado en el constructor.
	 * 
	 * @param string $script
	 * @return bool $permisos['administracion']
	 */
	public function permisoAdministracion($script=''){
		if($script=='')
			return $this->administracion;
		else{
			$id_proceso = $this->getProceso($script);
			$permisos = $this->DB_procesos->getPermisos($id_proceso, $this->datos_usuario['perfil']);
			return $permisos['administracion'];
		}
	}
	
	/**
	 * Comprueba si el usuario actual pertenece al perfil (id_perfil) pasado como parámetro
	 */
	public function isInPerfil($id_perfil){
		return $id_perfil == $this->perfil;
	}
	
	/*
	 * Función auxiliar que devuelve el id del proceso a partir de la ruta del script.
	 */
	private function getProceso($script){
		$ruta_script = $this->parseaRutaScript($script);
		
		return $this->DB_procesos->getIdProceso($ruta_script);
	}
	/*
	 * Función auxiliar que parsea la ruta $script para quedarse con la parte relevante.
	 */
	private function parseaRutaScript($script){
		//Borramos el directorio de instalación de la ruta que identifica al script.
		global $appDir;
		$tmp_1 = ereg_replace("^($appDir)", "", $script);
		$tmp_2 = explode("?", $tmp_1);
		$ruta_script = $tmp_2[0];

		//Debug:
		//print_r("Antes: $script <br /> Después: $ruta_script<br />");
		return $ruta_script;
	}
	
	/*
	 * Devuelve el nombre de la sección de la aplicación 
	 * donde nos encontramos, para resaltar en el menú.
	 */
	public function getMenuDir(){
		$path = $_SERVER['PHP_SELF'];
		
		$script = $this->DB_procesos->getScript($this->parseaRutaScript($path));

		return $script['menu'];
	}
}
?>