<?
/**
 * Clase abstracta encargada de dar soporte a la parte "observada" del patrón Observador.
 * 
 * @package G.Cambios
 * @abstract
 * @version 0.1
 */
abstract class ASujeto{

	protected $observadores=array();
	
	/**
	 * Añade observadores a la clase.
	 * 
	 * @param Observador $obs Objeto observador de la clase.
	 */
	abstract public function add_Observador($obs = null);
	
	/**
	 * Elimina observadores a la clase.
	 * 
	 * @param Observador $obs Objeto observador a eliminar.
	 */
	abstract public function del_Observador($obs = null);
	
	/**
	 * Pre-notifica a todos los observadores del evento especificado.
	 * 
	 * @param string $evento Nombre del evento a pre-notificar a los observadores de la clase.
	 */
	abstract protected function pre_notificar($evento);
		
	/**
	 * Notifica a todos los observadores del evento especificado.
	 * 
	 * @param string $evento Nombre del evento a notificar a los observadores de la clase.
	 */
	abstract protected function notificar($evento);
}
?>