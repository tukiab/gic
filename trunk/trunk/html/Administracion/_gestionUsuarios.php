<?php	include ('../appRoot.php');

	
//Definiendo la clase
class GestionUsuarios{
	
	//Listado de datos a mostrar
		public $opt;		
		public $datos;
		private $DB_usuarios;
	
	/**
	 * Constructor:
	 * @param array $opciones
	 */
	public function GestionUsuarios($opciones){
//FB::info($opciones, 'opciones gestion usuarios');
		try{
			//Inicializando el acceso a datos
			$this->DB_usuarios = new ListaUsuarios();
			
			$this->obtenerDatos();
			$this->obtenerOpciones($opciones);
					
			if($this->opt['guardar'])
				$this->guardar();
			else if($this->opt['crear'])
				$this->crear();
			else if($this->opt['eliminar'])
				$this->eliminar();

			//Reiniciamos la búsqueda de usuarios para tenerlos todos actualizados en la interfaz		
			$this->obtenerDatos();
			
		}catch(Exception $e){$this->opt['msg'] = $e->getMessage();}
	}
	
	private function obtenerDatos(){
	 	$this->DB_usuarios->buscar();
	 	$this->datos['lista_usuarios'] = array();
		while($usuario = $this->DB_usuarios->siguiente())
			$this->datos['lista_usuarios'][] = $usuario;
		
		$this->datos['lista_perfiles'] = $this->DB_usuarios->lista_Perfiles();			
	}
	private function obtenerOpciones($opciones){//FB::info($opciones,'opcionesa');

		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_usuario_accion']))?$this->opt['id_usuario_accion']=$opciones['id_usuario_accion']:null;

		//Datos de los usuarios
		foreach($this->datos['lista_usuarios'] as $usuario){
			$name_param = str_replace(".", "_", $usuario->get_Id());
			(isset($opciones['id_'.$name_param]))?$this->opt['id_'.$name_param]=$opciones['id_'.$name_param]:null;
			(isset($opciones['nombre_'.$name_param]))?$this->opt['nombre_'.$name_param]=$opciones['nombre_'.$name_param]:null;
			(isset($opciones['apellidos_'.$name_param]))?$this->opt['apellidos_'.$name_param]=$opciones['apellidos_'.$name_param]:null;
			(isset($opciones['password_'.$name_param]))?$this->opt['password_'.$name_param]=$opciones['password_'.$name_param]:null;
			(isset($opciones['email_'.$name_param]))?$this->opt['email_'.$name_param]=$opciones['email_'.$name_param]:null;
			(isset($opciones['perfil_'.$name_param]))?$this->opt['perfil_'.$name_param]=$opciones['perfil_'.$name_param]:null;
		}

		//Datos de un nuevo usuario
		(isset($opciones['id_usuario']))?$this->opt['id']=$opciones['id_usuario']:null;
		(isset($opciones['nombre']))?$this->opt['nombre']=$opciones['nombre']:null;
		(isset($opciones['apellidos']))?$this->opt['apellidos']=$opciones['apellidos']:null;
		(isset($opciones['perfil']))?$this->opt['perfil']=$opciones['perfil']:null;
		(isset($opciones['password']))?$this->opt['password']=$opciones['password']:null;
		(isset($opciones['email']))?$this->opt['email']=$opciones['email']:null;

	}	

	/**
	 * Guardar:
 	 */
	private function guardar(){
		$usuario = new Usuario($this->opt['id_usuario_accion']);
		$name_param = str_replace(".", "_", $usuario->get_Id());
		$datos = array('nombre' => $this->opt['nombre_'.$name_param], 'apellidos' => $this->opt['apellidos_'.$name_param], 'password' => $this->opt['password_'.$name_param], 'email' => $this->opt['email_'.$name_param], 'perfil' => $this->opt['perfil_'.$name_param], );
		$usuario->actualizar($datos);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		//FB::warn('creando');
		$usuario = new Usuario();
		$usuario->crear($this->opt);
		$this->opt['guardado'] = true;
	}

	private function eliminar(){
		//FB::warn('eliminando');
		$usuario = new Usuario($this->opt['id_usuario_accion']);
		$usuario->eliminar();
	}

}
?>
