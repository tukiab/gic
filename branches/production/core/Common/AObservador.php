<?
/**
 * Clase abstracta encargada de dar soporte a la parte "observadora" del patrón Observador.
 * 
 * @package G.Cambios
 * @abstract
 * @version 0.1
 */
abstract class AObservador{
	
	/**
	 * Este método es invocado por la clase observada.
	 * 
	 * @static
	 * @param Sujeto $sujeto Objeto observado.
	 * @param string $evento Nombre del evento pre-notificado.
	 */
	static public function pre_notificacion($sujeto, $evento){}
	
	/**
	 * Este método es invocado por la clase observada.
	 * 
	 * @static
	 * @param Sujeto $sujeto Objeto observado.
	 * @param string $evento Nombre del evento notificado.
	 */
	static public function notificacion($sujeto, $evento){}

}
?>