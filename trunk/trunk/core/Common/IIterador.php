<?php
/**
 * Interfaz a cumplir para el patrón Iterador.
 * 
 * Es usado por las clases que gestionan listados de elementos (ListaRFCs, ListaCambios, etc...)
 * 
 * @package G.Cambios
 * @version 0.1
 * @author
 * Juan Ramón González Hidalgo
 * 
 * María José Prieto García
 */
interface IIterador{

	/**
	 * Devuelve el número de elementos en la lista.
	 */
	public function num_Resultados();

	/**
	 * Establece el puntero a el primer elemento.
	 */
	public function inicio();
	
	/**
	 * Devuelve el siguiente elemento en la lista e incrementa el puntero.
	 */
	public function siguiente();
	
	
}
?>