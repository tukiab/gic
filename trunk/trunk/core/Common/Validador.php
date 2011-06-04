<?php
/**
 * Clase auxiliar para validar datos introducidos desde formularios.
 * En los datos con un número de caracteres definidos, se pone este número
 * como máximo, ya que en las búsqueda se puede introducir un subconjunto de estos caracteres.
 */
 class Validador{
	 
	 //Cuando alguna validación devuelve false, se setea esta variable
	 //a true indicando que ha habido un error.
	 //Es útil cuando al final de un script se quiere saber si ha habido 
	 //algún error de validación
	 var $error=false;
	 
	 /**
	  * Constructor
	  */	
	 function Validador(){}

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
	 * Valida si una hora viene en formato HH:MM
	 * 
	 */
	function hora($hora){
		
		//$regexp 	= "^([[:digit:]]{2})\:([[:digit:]]{2})\:([[:digit:]]{2})$";
		$regexp2 	= "^([[:digit:]]{2})\:([[:digit:]]{2})$";
	  	
	  	if(!eregi($regexp2, $hora)){
	  		return false;
		}
	  	$valido = true;	
		$arraux = split(':',$hora); 
		
	  	if($arraux[0]>23 || $arraux[0]<0)
			$valido = false;
		
		if($arraux[1]>59 || $arraux[1]<0)
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
 	 * Validación de cualquier cadena de búsqueda sin patrón definido.
 	 * Se evita la inserción de caracteres ilegales en la cadena de búsqueda de la BD.
	 * Se puede utilizar, por ejemplo, en el nombre de centro, contactos, incidencias, etc...
 	 */
 	function cadena($data){
 		$valido = false;
 		
 		//expresion regular con la lista de caracteres permitidos:
 		$regexp = "[^[:alnum:]áéíóúÁÉÍÓÚ _.,:;ñÑºª@ü()'\"/-]+<>";
 		
	 	if(!eregi($regexp, $data))
	  		$valido = true;
	
	  	if($valido==false) $this->error=true;
		return $valido;	
 	}
 	
 	/**
 	 * Validación de código postal
 	 */
 	function CP($data){
 	  	$valido = false;
	  	//5 dígitos máximo, 2 como mínimo
	  	$regexp = "^[[:digit:]]{5}$";

	  	if(eregi($regexp, $data))
	  		$valido = true;
	
	  	if($valido==false) $this->error=true;
		return $valido;  			
 	}
 	
 	/**
 	 * Validación de teléfono
 	 */
 	function telefono($data){
		if($data=='') return true;
 	  	$valido = false;
	  	//Empieza por 9, luego 8 dígitos
	  	$regexp = "^9{1}[0-9]{8}$";
	  	
	  	if(eregi($regexp, $data))
	  		$valido = true;
		
	  	if($valido==false) $this->error=true;
	  	if($data == '') $valido=true;
		if(!$valido) return $this->movil($data);
		return $valido;  					
 	}
 /**
 	 * Validación de móvil
 	 */
 	function movil($data){
 	  	$valido = false;
	  	//Empieza por 6, luego 8 dígitos
	  	$regexp = "^6{1}[0-9]{8}$";
	  	
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
 	
 	// Valida un id
 	function id($data){
		return ($data!='' && is_numeric($data));
 	}

 	//Valida el NIF o el CIF
	function nif_cif($cif) {
	    if($cif == '') return true;
	    
	    return $this->valida_nif_cif_nie($cif);
	    
	    $cif = strtoupper($cif);
	    for ($i = 0; $i < 9; $i ++)
	       $num[$i] = substr($cif, $i, 1);
	    //si no tiene un formato valido devuelve error
	    if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif)){
	       return false;
	    }
	       
	    //comprobacion de NIFs estandar
	    if (ereg('(^[0-9]{8}[A-Z]{1}$)', $cif))
	       if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
	          return true;
	       else
	          return false;	
	       	         
	    //algoritmo para comprobacion de codigos tipo CIF
	    $suma = $num[2] + $num[4] + $num[6];
	    for ($i = 1; $i < 8; $i += 2)
	       $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]),1,1);
	    $n = 10 - substr($suma, strlen($suma) - 1, 1);
	    //comprobacion de NIFs especiales (se calculan como CIFs)
	    if (ereg('^[KLM]{1}', $cif))
	       if ($num[8] == chr(64 + $n))
	          return true;
	       else
	          return false;
	       
	    //comprobacion de CIFs
	    if (ereg('^[ABCDEFGHJNPQRSUVW]{1}', $cif)){
	       if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
	          return true;
	       else{
		   FB::error($num[8]);
		   FB::error($n,'n');
		   FB::warn(chr(64 + $n));
		   FB::warn(substr($n, strlen($n) - 1, 1));
	          return false;
	       }
	    }
	    
	    //Si no ha devuelto true...
	    return false;
	}
	
	public function valida_nif_cif_nie($cif) {
	    //Copyright ©2005-2011 David Vidal Serra. Bajo licencia GNU GPL.
	    //Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
	    //puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
	    //Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
	    //con la condicion de que el autor jamas sera responsable de su uso.
	    //Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
		     $cif = strtoupper($cif);
		     for ($i = 0; $i < 9; $i ++)
		     {
			      $num[$i] = substr($cif, $i, 1);
		     }
	    //si no tiene un formato valido devuelve error
		     if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif))
		     {
			      return 0;
		     }
	    //comprobacion de NIFs estandar
		     if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif))
		     {
			      if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
			      {
				       return 1;
			      }
			      else
			      {
				       return -1;
			      }
		     }
	    //algoritmo para comprobacion de codigos tipo CIF
		     $suma = $num[2] + $num[4] + $num[6];
		     for ($i = 1; $i < 8; $i += 2)
		     {
			      $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]), 1, 1);
		     }
		     $n = 10 - substr($suma, strlen($suma) - 1, 1);
	    //comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
		     if (preg_match('/^[KLM]{1}/', $cif))
		     {
			      if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
			      {
				       return 1;
			      }
			      else
			      {
				       return -1;
			      }
		     }
	    //comprobacion de CIFs
		     if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif))
		     {
			      if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
			      {
				       return 2;
			      }
			      else
			      {
				       return -2;
			      }
		     }
	    //comprobacion de NIEs
	    //T
		     if (preg_match('/^[T]{1}/', $cif))
		     {
			      if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $cif))
			      {
				       return 3;
			      }
			      else
			      {
				       return -3;
			      }
		     }
	    //XYZ
		     if (preg_match('/^[XYZ]{1}/', $cif))
		     {
			      if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
			      {
				       return 3;
			      }
			      else
			      {
				       return -3;
			      }
		     }
	    //si todavia no se ha verificado devuelve error
		     return 0;
	    }

	public function email($email){
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
			return true;
		else
			return false;

	}

} 
?>