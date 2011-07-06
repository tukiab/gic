<?php
/**
 * Clase que gestiona las presentación de la información de una Oferta.
 * 
 */
class OfertasUlt{
												
	/** 
	 * Contendrá los parámetros que se pasan al constructor.
	 * 
	 * @var array  
	 */
	public $opt=array();
												
	/**
	 * Se obtienen los datos necesarios para mostrar el la interfaz, a partir de los parámetros pasados al 
	 * constructor.
	 * También realiza las funciones de modificación de datos necesarias..
	 * 
	 * @param array $opciones Array de opciones pasados al script. Se corresponde con el array $_GET de la vista.
	 */
	public function __construct($opciones_g, $opciones){
		try{		
			$this->get_Opciones($opciones_g, $opciones);
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
}
?>