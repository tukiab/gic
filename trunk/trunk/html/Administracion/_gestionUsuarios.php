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
FB::info($opciones, 'opciones gestion usuarios');
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
	private function obtenerOpciones($opciones){

		($opciones['guardar'] == 1)?$this->opt['guardar']=true:null;
		(isset($opciones['crear']))?$this->opt['crear']=true:null;
		($opciones['eliminar'] == 1)?$this->opt['eliminar']=true:null;
		(isset($opciones['id_usuario_accion']))?$this->opt['id_usuario_accion']=$opciones['id_usuario_accion']:null;

		//Datos de los usuarios
		foreach($this->datos['lista_usuarios'] as $usuario){
			(isset($opciones['id_'.$usuario->get_Id()]))?$this->opt['id_'.$usuario->get_Id()]=$opciones['id_'.$usuario->get_Id()]:null;
			(isset($opciones['nombre_'.$usuario->get_Id()]))?$this->opt['nombre_'.$usuario->get_Id()]=$opciones['nombre_'.$usuario->get_Id()]:null;
			(isset($opciones['apellidos_'.$usuario->get_Id()]))?$this->opt['apellidos_'.$usuario->get_Id()]=$opciones['apellidos_'.$usuario->get_Id()]:null;
			(isset($opciones['password_'.$usuario->get_Id()]))?$this->opt['password_'.$usuario->get_Id()]=$opciones['password_'.$usuario->get_Id()]:null;
                        (isset($opciones['email_'.$usuario->get_Id()]))?$this->opt['email_'.$usuario->get_Id()]=$opciones['email_'.$usuario->get_Id()]:null;
			(isset($opciones['perfil_'.$usuario->get_Id()]))?$this->opt['perfil_'.$usuario->get_Id()]=$opciones['perfil_'.$usuario->get_Id()]:null;
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
		FB::warn('guardando');
		$usuario = new Usuario($this->opt['id_usuario_accion']);
		$datos = array('id' => $this->opt['id_'.$usuario->get_Id()], 'nombre' => $this->opt['nombre_'.$usuario->get_Id()], 'apellidos' => $this->opt['apellidos_'.$usuario->get_Id()], 'password' => $this->opt['password_'.$usuario->get_Id()], 'email' => $this->opt['email_'.$usuario->get_Id()], 'perfil' => $this->opt['perfil_'.$usuario->get_Id()], );
		$usuario->actualizar($datos);
	}

	/**
	 * Crear:
 	 */

	private function crear(){
		FB::warn('creando');
		$usuario = new Usuario();
		$usuario->crear($this->opt);	
	}

	private function eliminar(){
		FB::warn('eliminando');
		$usuario = new Usuario($this->opt['id_usuario_accion']);
		$usuario->eliminar();
	}

}
?>
