<?php

if(!class_exists('Validator')){
	/**
	 * Clase auxiliar para validar datos introducidos desde formularios.
	 * En los datos con un número de caracteres definidos, se pone este número
	 * como máximo, ya que en las búsqueda se puede introducir un subconjunto de estos caracteres.
	 */
	 class Validator{
		 
		 //Cuando alguna validación devuelve false, se setea esta variable
		 //a true indicando que ha habido un error.
		 //Es útil cuando al final de un script se quiere saber si ha habido 
		 //algún error de validación
		 var $error=false;
		 
		 /**
		  * Constructor
		  */	
		 function Validator(){}
	
		/**
		 * Devuelve el estado de la variable $error
		 */
		function hayErrores(){
			return $this->error;
		}
		 /**
		  * Validación de fechas y horas en formato: dd/mm/aaaa hh:mm:ss
		  *
		  */
		function fechahora($fechahora){
			$arraux = split(' ',$fechahora);
			$valido = true;
	
			if(!$this->fecha($arraux[0])){
				$valido = false;
			}
			if(!$this->hora($arraux[1]) && $arraux[1]!=''){
				$valido = false;
			}
			return $valido;
		}
		
		/**
		 * Valida si una hora viene en formato HH:MM:SS 
		 * 
		 */
		function hora($hora){
	
			$regexp 	= "^([[:digit:]]{2})\:([[:digit:]]{2})\:([[:digit:]]{2})$";
			$regexp2 	= "^([[:digit:]]{2})\:([[:digit:]]{2})$";
		  	
		  	if(!eregi($regexp, $hora) && !eregi($regexp2, $hora)){
		  		return false;
			}
		  	$valido = true;	
			$arraux = split(':',$hora);
			
		  	if($arraux[0]>23 || $arraux[0]<0)
				$valido = false;
			if($arraux[1]>59 || $arraux[1]<0 || $arraux[2]>59 || $arraux[2]<0)
				$valido = false;
				
			return $valido;
		}
		
		/**
		 * Validación de fechas
		 * 
		 */
		function fecha($data){
	
			$valido = false;
		  	//patrón: dd/mm/aaaa
		  	$regexp = "^([[:digit:]]{1,2})/([[:digit:]]{1,2})/([[:digit:]]{2,4})$";
		  	
		  	if(!eregi($regexp, $data))
		  		return false;
		  	else{
		  		//comprobamos los rangos de los números
		  		$fecha = array();
		  		$fecha = explode("/", $data);
		  		$dia = $fecha[0];
		  		$mes = $fecha[1];
		  		$anyo = $fecha[2];
		  	
		  		if($mes<1 || $mes>12 || $dia<1)
		  			return false;
		  		
		  		switch($mes){
		  			case 1:
		  			case 3:
		  			case 5:
		  			case 7:
		  			case 8:
		  			case 10:
		  			case 12:
		  				if($dia <= 31)
		  					$valido = true;
		  				break;
		  			case 2:
		  				//comprobar anyo bisiesto:
		  				$bisiesto = false;
		  				
		  				//si es divisible por 4, 100 y 400, es bisiesto
		  				//si es divisible por 4, 100 pero no por 400, no es bisiesto
		  				//si es divisible por 4 y no por 100, es bisiesto
		  				$r4 = fmod($anyo, 4);
		  				$r100 = fmod($anyo, 100);
		  				$r400 = fmod($anyo, 400);
		  				
		  				if($r4 != 0)
		  					$bisiesto = false;
		  				else if($r100 != 0)
		  					$bisiesto = true;
		  				else if($r100 == 0 && $r400 != 0)
		  					$bisiesto = false;
		  				else if($r100 == 0 && $r400 == 0)
		  					$bisiesto = true;
	
		  				if($bisiesto){
		  					if($dia<=29)
		  						$valido = true;
		  				}
		  	  			else if($dia<=28){
		  						$valido = true;
		  	  			}
		  				break;
		  			case 4:
		  			case 6:
		  			case 9:
		  			case 11:
		  				if($dia<=30)
		  					$valido = true;
		  				break;
		  		}
		  	}//fin else
		  	
		  	if($valido==false) $this->error=true;
		  	return $valido;
		  }
		  
		/**
		 * Validación de código de centro
		 */
		function codigoCentro($data){
		  	$valido = false;
		  	//8 dígitos máximo, 2 como mínimo
		  	$regexp = "^[[:digit:]]{2,8}$";
		  	
		  	if(eregi($regexp, $data))
		  		$valido = true;
		
		  	if($valido==false) $this->error=true;
			return $valido;  	
		  }
		  
	 	/**
		 * Validación de código de incidencia
		 */
		function codigoIncidencia($data){
		  	$valido = false;
		  	//8 dígitos máximo, 2 como mínimo
		  	$regexp = "^[[:digit:]]{1,11}$";
		  	
		  	if(eregi($regexp, $data))
		  		$valido = true;
		
		  	if($valido==false) $this->error=true;
			return $valido;  	
		  }		  
		  
	 	/**
	 	 * Validación de cualquier cadena de búsqueda sin patrón definido.
	 	 * Se evita la inserción de caracteres ilegales en la cadena de búsqueda de la BD.
		 * Se puede utilizar, por ejemplo, en el nombre de centro, contactos, incidencias, etc...
	 	 */
	 	function cadena($data){
	 		$valido = false;
	 		
	 		//expresion regular con la lista de caracteres permitidos:
	 		$regexp = "[^[:alnum:]áéíóúÁÉÍÓÚ _.,:;ñÑºª@ü()'\"/-]+";
	 		
		 	if(!eregi($regexp, $data))
		  		$valido = true;
		
		  	if($valido==false) $this->error=true;
			return $valido;	
	 	}
	 	
	 	/**
	 	 * Validación de código postal
	 	 */
	 	function codigoPostal($data){
	 	  	$valido = false;
		  	//5 dígitos máximo, 2 como mínimo
		  	$regexp = "^[[:digit:]]{2,5}$";
	
		  	if(eregi($regexp, $data))
		  		$valido = true;
		
		  	if($valido==false) $this->error=true;
			return $valido;  			
	 	}
	 	
	 	/**
	 	 * Validación de teléfono
	 	 */
	 	function telefono($data){
	 	  	$valido = false;
		  	//9 dígitos máximo, 4 como mínimo
		  	$regexp = "^[[:digit:]]{4,9}$";
		  	
		  	if(eregi($regexp, $data))
		  		$valido = true;
		
		  	if($valido==false) $this->error=true;
			return $valido;  					
	 	}
	 	
	 	function ip($data){
	 		$valido = false;
	 		$regexp = "^([[:digit:]]{1,3})((\.[[:digit:]]{1,3}){0,3})(\.){0,1}$";
	 	  	
		  	if(eregi($regexp, $data)){
		  		$temp = explode(".", $data);
		  		$valido = true;	

		  		foreach($temp as $value){
		  			if($value>255)
		  				$valido = false;
		  		}
		  	}
		  		
		  	if($valido==false) $this->error=true;
			return $valido;  					
	 	}
	}
}	 
?>
