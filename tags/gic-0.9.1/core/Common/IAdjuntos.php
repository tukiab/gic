<?
/**
 * Interfaz a cumplir para las clases que permiten archivos adjuntos.
 * 
 * @package Utils
 * @version 0.1
 * @author
 * Juan Ramón González Hidalgo
 * 
 * Maria José Prieto García
 */
interface IAdjuntos{
	
	/**
	 * Devuelte el id de la entidad que adjunta los archivos.
	 * 
	 * @return integer $id Identificador de la entidad.
	 */
	public function get_Id();
	
	/**
	 * Añade un archivo adjunto.
	 * 
	 * @param $Adjunto Instancia de la clase Adjunto con los datos del archivo a guardar.
	 */
	public function add_Adjunto($Adjunto = null);
	
	/**
	 * Elimina un archivo adjunto.
	 * 
	 * @param $Adjunto Instancia de la clase Adjunto con los datos del archivo a eliminar.
	 */
	public function del_Adjunto($Adjunto = null);

	/**
	 * Devuelve la lista de archivos adjuntos.
	 * 
	 * @param array $adjuntos Array de archivos adjuntos. Instancias de la clase Adjunto.
	 */
	public function get_Adjuntos();
}
?>