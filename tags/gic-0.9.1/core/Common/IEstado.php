<?
/**
 * Interfaz a cumplir para las clases que implementen el comportamiento de un estado concreto de un Cambio.
 * 
 * @package G.Cambios
 * @subpackage Cambios_Estados
 * @version 0.1
 * @author
 * Juan Ramón González Hidalgo
 * 
 * Maria José Prieto García
 */
interface IEstado{
	
	/**
	 * Devuelve un array con la información del estado.
	 * 
	 * @return array $estado Array indexado con al menos: 'id', 'nombre', 'aceptado', 'fecha' y 'operador'
	 */
	public function get_Estado();
	
	/**
	 * Devuelve las opciones disponibles para el estado actual, con el nombre del método y la descripción de la acción.
	 * 
	 * @return array $array_opciones Array de las opciones disponibles: Cada posición tiene 'nombre', 'descripcion' y 'parametros'. 
	 */
	public function get_Opciones();

	/**
	 * Método aceptar para el estado.
	 * 
	 * @param array $datos Datos necesarios para aceptar el Cambio en el contexto concreto.
	 */
	public function aceptar($datos = null);

	/**
	 * Método rechazar para el estado.
	 * 
	 * @param array $datos Datos necesarios para rechazar el Cambio en el contexto concreto.
	 */
	public function rechazar($datos = null);

	/**
	 * Método siguiente para el estado.
	 * 
	 * @param array $datos Datos necesarios para el método siguiente, cuando proceda.
	 */
	public function siguiente($datos = null);
	
	/**
	 * Método anterior para el estado.
	 * 
	 * @param array $datos Datos necesarios para el método anterior, cuando proceda.
	 */
	public function anterior($datos = null);
}
?>