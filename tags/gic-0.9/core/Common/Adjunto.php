<? 	
/**
* Clase que gestiona los Archivos Adjuntos.
* 
* @package Utils
* @version 0.1
*/
class Adjunto{

	/**
	 * Identificador del Adjunto.
	 *
	 * @var integer
	 */
	private $id=null;
	
	/**
	 * Identificador del operador que adjunta el archivo.
	 *
	 * @var string
	 */
	private $operador;
	/**
	 * Fecha en la que se adjunta el archivo.
	 * 
	 * @var string
	 */
	private $fecha;
	/**
	 * Nombre del archivo original en el cliente.
	 * 
	 * @var string
	 */
	private $name;
	/**
	 * Nombre temporal asignado al archivo en el servidor.
	 * 
	 * @var string
	 */
	private $tmp_name;
	/**
	 * Tipo mime del archivo.
	 * 
	 * @var string
	 */
	private $type;
	/**
	 * Tamaño del archivo.
	 * 
	 * @var integer
	 */
	private $size;
	/**
	 * Descripción del archivo.
	 * 
	 * @var string
	 */
	private $descripcion;	
	
	/**
	 * Contenido del archivo.
	 * 
	 * @var object
	 */
	private $archivo;
	
	/**
	 * Nombre de la clase cuya intancia adjunta el archivo.
	 *
	 * @var string
	 */
	private $entidad;
	
	/**
	 * Identificador del objeto que adjunta el archivo
	 *
	 * @var integer
	 */
	private $id_entidad;
	
	
	/**
	 * Constructor de la clase.
	 * 
	 * Si se le pasa un id válido de RFC, se invoca el método privado {@link cargar()}, con el que se cargan los datos
	 * de la BBDD.
	 * En caso contrario, se crea un RFC "vacío", con el que se podrá crear uno nuevo en la BBDD mediante el método
	 * {@link crear()}.
	 * 
	 * @see cargar()
	 * @see crear()
	 * @param integer $id Id del RFC. Cuando está definido, se carga de la BBDD.
	 */
	public function __construct($datos){
		
		if($datos['id'])
			$this->id = $datos['id'];
			
		$this->entidad = $datos['entidad'];
		$this->id_entidad = $datos['id_entidad'];
		if(!class_exists($this->entidad) || !$this->id_entidad)
			throw new Exception("Error: Datos insuficientes para adjuntar el archivo.aa".$this->entidad);
		
		($datos['operador'])?$this->operador = $datos['operador']: $this->operador = $_SESSION['usuario_login'];
		($datos['fecha'])?$this->fecha = $datos['fecha']: $this->fecha = time();
		$this->name = $datos['name'];
			if(!$this->name)
				throw new Exception("Error: Nombre de archivo no v&aacute;lido.");
		$this->tmp_name = $datos['tmp_name'];
			if(!$this->id && !$this->tmp_name)
				throw new Exception("Error: Nombre temporal de archivo no v&aacute;lido.");
		$this->type = $datos['type'];
			if(!$this->type)
				throw new Exception("Error: Tipo de archivo no v&aacute;lido.");
		$this->size = $datos['size'];
			if(!$this->size)
				throw new Exception("Error: Tamaño de archivo no v&aacute;lido.");
		$this->descripcion = $datos['descripcion'];
		//if(!$this->descripcion)
			//	throw new Exception("Error: Descripci&oacute;n de archivo no v&aacute;lida.");
		$this->archivo = $datos['archivo'];
	}


	/**
	* Métodos observadores.
	*/

	/**
	* Devuelve el id del RFC.
	* 
	* @return integer $id Id del RFC
	*/
	public function get_Id(){
		return $this->id;
	}
	
	/**
	 * Devuelve el identificador del operador que adjuntó el archivo.
	 * 
	 * @return string $operador Id de operador.
	 */
	public function get_Operador(){
		return $this->operador;
	}

	/**
	 * Devuelve la fecha en que se adjuntó el archivo.
	 * 
	 * @return string $fecha Fecha en la que se adjuntó el archivo.
	 */
	public function get_Fecha(){
		return $this->fecha;
	}

	/**
	 * Devuelve el nombre original del archivo en el cliente.
	 * 
	 * @return string $name Nombre original del archivo.
	 */
	public function get_Name(){
		return $this->name;
	}
	
	/**
	 * Devuelve el nombre temporal del archivo en el servidor
	 * 
	 * @return string $tmp_name Nombre temporal del archivo en el servidor.
	 */
	public function get_Tmp_Name(){
		return $this->tmp_name;
	}

	/**
	 * Devuelve el tipo mime del archivo.
	 * 
	 * @return string $type Tipo mime del archivo.
	 */
	public function get_Type(){
		return $this->type;
	}

	/**
	 * Devuelve el tamaño del archivo.
	 * 
	 * @return integer $size Tamaño del archivo.
	 */
	public function get_Size(){
		return $this->size;
	}
	
	/**
	 * Devuelve el tamaño del archivo en formato "legible".
	 * 
	 * @return string $size Tamaño del archivo debidamente formateado.
	 */
	public function get_Hum_Size(){
		$size = $this->size;
		$i=0;
		$iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
		while (($size/1024)>1){
			$size=$size/1024;
			$i++;
		}
		
		return substr($size,0,strpos($size,'.')+2).$iec[$i];
	}

	/**
	* Devuelve la descripción del archivo.
	* 
	* @return string $descripcion Descripción del archivo.
	*/
	public function get_Descripcion(){
		return $this->descripcion;
	}
	
	/**
	* A partir del identificador para localizar el archivo, devuelve el contenido del mismo.
	* 
	* En caso de que se hubiera guardado dicho contenido en la BBDD, se debidamente
	* formateado para descargar por el usuario.
	* 
	* @return string $content Contenido del archivo.
	*/
	public function get_Archivo(){
		if(!file_exists(UPLOAD_PATH.$this->archivo))
			throw new Exception("Ups.. Archivo no encontrado!");
		else if(!is_readable(UPLOAD_PATH.$this->archivo))
			throw new Exception("Error: El archivo no se puede 'read' (en homenage a Windo&#36;)" );
			
		return file_get_contents(UPLOAD_PATH.$this->archivo);
	}
	
	/**
	* Almacena el archivo adjunto en el directorio correspondiente.
	* 
	* En caso de que se quisiera guardar dicho contenido en la BBDD, se devolvería dicho contenido debidamente
	* formateado para que sea aceptado por el motor de BBDD.
	* 
	* @return string $archivo Identificador único para localizar el archivo.
	*/
	public function set_Archivo(){
		if(is_uploaded_file($this->tmp_name) && file_exists($this->tmp_name)){
			
			//Definiendo el formato del nombre en el sistema de ficheros:
			$nombre = $this->entidad."_".$this->id_entidad."_".hash_file("md5", $this->tmp_name)."_".hash("md5", $this->name);
			
			if(!file_exists(UPLOAD_PATH.$nombre))
				move_uploaded_file($this->tmp_name, UPLOAD_PATH.$nombre);
			else
				throw new Exception("Error: Estás subiendo dos veces el mismo archivo cuñao!.");
		}else
			throw new Exception("Error GORDO en la subida del archivo adjunto.");
		
		return $nombre;
	}
	
	/**
	* Elimina el fichero del directorio.
	* 
	* En caso de que se hubiera guardado dicho contenido en la BBDD, no se hace nada.
	*/
	public function unset_Archivo(){
		if(file_exists(UPLOAD_PATH.$this->archivo) && is_writable(UPLOAD_PATH.$this->archivo))
			unlink(UPLOAD_PATH.$this->archivo);
	}
}?>