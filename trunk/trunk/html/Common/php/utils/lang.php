<?php
/**
 * Aquí irá la clase para traducir la aplicación...
 * Si el segunda parámetro es 'true', la cadena es devuelta en vez de imprimida.
 */
if(!function_exists(_translate)){
	function _translate($string, $return = false){
		if($return)
			return $string;
		else
			echo  utf8_encode($string);
	}
}
?>