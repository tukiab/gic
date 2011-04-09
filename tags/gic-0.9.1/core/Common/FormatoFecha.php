<?
/**
 * Clase auxiliar para cambiar el formato de los datos introducidos desde formularios.
 * 
 */
class FormatoFecha{
	 
	 //Cuando alguna validación devuelve false, se setea esta variable
	 //a true indicando que ha habido un error.
	 //Es útil cuando al final de un script se quiere saber si ha habido 
	 //algún error de validación
	 var $error=false;
	 
	 /**
	  * Constructor
	  */	
	 function FormatoFecha(){}

	/**
	 * Devuelve el estado de la variable $error
	 */
	function hayErrores(){
		return $this->error;
	}
	
	/*
	 * Convierte una fecha del tipo: DD/MM/AAAA a AAAA-MM-DD
	 */
	function fecha2mysql($fecha){
		$res = false;
		$res=$res || ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
		$res=$res || ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
		$res=$res || ereg( "([0-9]{1,2}),([0-9]{1,2}),([0-9]{2,4})", $fecha, $mifecha);
		$res=$res || ereg( "([0-9]{1,2}).([0-9]{1,2}).([0-9]{2,4})", $fecha, $mifecha);
		$lafecha=$mifecha[1]."/".$mifecha[2]."/".$mifecha[3];
		//print($lafecha);
		if($res)
	   	 	return $lafecha;
	   	else
	   		return $fecha;
	}
	
	/*
	 * Convierte a timestamp una fecha en el formato dd/mm/aa
	 */
	function date2timestamp($date, $hora=false){
		if ($hora){
			$tmp = @explode("/", $date);
			return @mktime(23,59,59,$tmp[1], $tmp[0], $tmp[2]);
		}else{
			$tmp = @explode("/", $date);
			return @mktime(0,0,0,$tmp[1], $tmp[0], $tmp[2]);
		}
	}
	
	/*
	 * Convierte en timestamp en horas, minutos y segundos
	 */
	function tiempo2horas($tiempo){
		if ($tiempo<0) return false;
		$minutos = (int)($tiempo / 60); 
		$segundos = $tiempo % 60;
		$horas = (int)($minutos / 60); 
		$minutos = $minutos % 60;
		if(strlen($segundos)<2) 	$segundos= '0'.$segundos;
		if(strlen($minutos)<2) 	$minutos 	= '0'.$minutos;
		if(strlen($horas)<2) 		$horas 		= '0'.$horas;
		return $horas.':'.$minutos.':'.$segundos;
	}
 }
?>