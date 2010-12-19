<?php include('appRoot.php');
   include_once($appRoot.'/include/autoload.php');
   include_once($codeRoot.'/config/dbConect.php');

/**
 * Clase para adjuntar Archivos de forma generica en Sigila
 * Las clases que permitan adjuntar archivos deben implementar la interfaz IAdjuntos.
 * 	
 * @package Utils
 * @subpackage Interfaz
 * @version 0.1
 * @author 
 * Juan Ramón González Hidalgo
 * 
 * Maria José Prieto García
 */
class AdjuntarArchivo{
	
	/**
	 * Array de opciones.
	 *
	 * @var array
	 */
	public $opt = array();
	
	/**
	 * Array de datos visible desde fuera de la clase.
	 *
	 * @var array
	 */
	public $datos = array();
		
	/**
	 * Constructor de la clase
	 * 
	 * Se adquieren los parámetros necesarios para adjuntar un archivo a una entidad (Incidencia, RFC, etc..)
	 * 
	 * @param $opciones --> Array POST
	 * @param $opciones_url --> Array GET
	 * @param opciones_archivos --> Array FILES
	 */
	public function AdjuntarArchivo($opciones, $opciones_url, $opt_archivo){
		
		/*
		 * Las variables necesarias:
		 * 		* id => 		Identificador de la entidad.
		 * 		* clase => 	Nombre de la clase a la que pertenece la entidad. Debe implementar la interfaz IAdjuntos.
		 * 		* accion =>	Acción a realizar: add (Añadir archivo a la entidad) ó del (Eliminar archivo de la entidad)
		 * 		* id_archivo => Sólo necesario en el caso de Eliminar archivos.
		 * 		* Los datos pertinentes de los formularios HTML de envío de archivos al servidor.
		 */
		
		$this->adquirirOpciones($opciones_url, $opciones);
		try{
			if($this->opt['id']){
				$id = $this->opt['id'];
				$nombre_clase = $this->opt['clase'];
				eval("\$Entidad = new $nombre_clase(\$id );");
				
				switch($this->opt['accion']){
					case "add":
						$datos_archivo['operador']=$_SESSION['usuario_login'];
						$datos_archivo['fecha']=time();
						$datos_archivo['name']=$opt_archivo['fichero']['name'];
						$datos_archivo['tmp_name']=$opt_archivo['fichero']['tmp_name'];
						$datos_archivo['type']=$opt_archivo['fichero']['type'];
						$datos_archivo['size']=$opt_archivo['fichero']['size'];
						$datos_archivo['descripcion']=$opciones['descripcion'];

						$datos_archivo['entidad']=$nombre_clase;
						$datos_archivo['id_entidad']=$id;

						$archivo = new Adjunto($datos_archivo);
						$Entidad->add_Adjunto($archivo);
						break;
					case "del":
							$id_archivo = $this->opt['id_archivo'];
							$lista_archivos = $Entidad->get_Adjuntos();
							$Entidad->del_Adjunto($lista_archivos[$id_archivo]);
						break;
				}
						
			}
		}catch (Exception $e){
			$this->opt['error_msg'] = $e->getMessage();
		}
		
		//Hacemos visible la lista de archivos desde fuera de la clase:
		eval("\$Entidad = new $nombre_clase(\$id );");
		$this->datos['lista_archivos'] = $Entidad->get_Adjuntos();	//Cada elemento es una instancia de la clase Adjunto.

	}

	/**
	 * Adquiere las principales opciones pasadas a la página.
	 */
	private function adquirirOpciones($opciones_url, $opciones){

		($opciones['id'])?$this->opt['id'] = $opciones['id']: $this->opt['id'] = $opciones_url['id'];
		($opciones['clase'])?$this->opt['clase'] = $opciones['clase']: $this->opt['clase'] = $opciones_url['clase'];
		$this->opt['id_archivo'] = $opciones['id_archivo'];
		$this->opt['accion'] = $opciones['accion'];
	}
}
?>