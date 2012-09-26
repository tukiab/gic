<?	include ('../appRoot.php');

	//Acceso a datos
	include_once ('datos/datosProcesos.php');
	include ('datos/datosGrupos.php');
	include ('datos/datosRoles.php');
	
//Definiendo la clase
class GestionPermisos{
	
	//Listado de datos a mostrar
		public $listaProcesos;
		public $listaGrupos;
		public $listaRoles;
		
	/*
	 * Opciones de la página. Tres pasos:
	 * 		-Elegir proceso.
	 * 		-Establecer permisos.
	 * 		-Guardar.
	 */
		public $seleccion = false;	//Opción de edición de un proceso
		public $guardar = false;	//Opción guardar
		public $proceso = null;		//Guarda los datos del proceso seleccionado
			
	//Variables privadas de la clase
		private $DB_procesos;
		private $DB_grupos;
		private $DB_roles;
	
	/**
	 * Constructor:
	 * A partir de las opciones establece las variables necesarias para mostrar la página
	 * llamante.
	 * 
	 * @param array $opciones
	 */
	public function GestionPermisos($opciones){

		(isset($opciones['proceso']))?$id_proceso=$opciones['proceso']:$id_proceso=null;
		(isset($opciones['seleccion']))?$this->seleccion=true:$this->seleccion=false;
		(isset($opciones['guardar']))?$this->guardar=true:$this->guardar=false;
		
		//Inicializando el acceso a datos
		$this->DB_procesos = new datosProcesos();
		$this->DB_grupos = new datosGrupos();
		$this->DB_roles = new datosRoles();
		
		//Obteniendo datos necesarios para mostrar la página.
		$this->listaProcesos = $this->DB_procesos->getListaProcesos();
		$this->listaGrupos = $this->DB_grupos->getListaGrupos();
		$this->listaRoles = $this->DB_roles->getListaRoles();
		
		if($this->seleccion){
			//Establecer datos y opciones para editar el proceso $this->id_proceso
			$this->proceso = $this->DB_procesos->getProceso($id_proceso);
		}
		else if($this->guardar){
			//Comprobar datos y actualizar los permisos para el proceso $this->id_proceso
				$this->proceso = $this->DB_procesos->getProceso($id_proceso);

			//Adquiriendo datos:
			$datos_permisos = $this->getDatosPermisos($opciones);
			
			$this->DB_procesos->setPermisos($id_proceso, $datos_permisos);
		}
				
	}
	
	public function getListaPermisos($id){
		return$this->DB_procesos->getListaPermisos($id);
	}
	
	/**
	 * A partir de las opciones pasadas al script, devuelve los permisos establecidos
	 * en la interfaz en un formato adecuado para enviarlo a la BD.
	 *
	 * @param array $opciones
	 */
	private function getDatosPermisos($opciones){
		$data = array();
		//Grupos:
		foreach($this->listaGrupos as $grupo){
			$index = "grupos_".$grupo['id'];
			$valor = $opciones[$index];
			$data['grupos'][$grupo['id']] = $this->valor2arrayPermisos($valor);
		}
			
		foreach($this->listaRoles as $role){
			$index =  "roles_".$role['id'];
			$valor = $opciones[$index];
			$data['roles'][$role['id']] = $this->valor2arrayPermisos($valor);
		}

		return $data;
	}
	
	/**
	 * Convierte el valor introducido en el formulario a un array de permisos.
	 *
	 * @param string $valor
	 * @return array
	 */
	private function valor2arrayPermisos($valor){
		$array_permisos = array('lectura'=>0, 'escritura'=>0, 'administracion'=>0);
		switch($valor){
				case 'N':
					break;
				case 'L':
					$array_permisos['lectura']=1;
					break;
				case 'E':
					$array_permisos['lectura']=1;
					$array_permisos['escritura']=1;
					break;
				case 'A':
					$array_permisos['lectura']=1;
					$array_permisos['escritura']=1;
					$array_permisos['administracion']=1;
					break;
			}
		return $array_permisos;
	}
	/**
	 * Lo contrario que la anterior
	 */
	public function arrayPermisos2valor($array_perm){
		
		if($array_perm['administracion'])
			$valor = "A";
		else if($array_perm['escritura'])
			$valor = "E";
		else if($array_perm['lectura'])
			$valor = "L";
		else
			$valor = "N";
			
		return $valor;
	}
}
?>