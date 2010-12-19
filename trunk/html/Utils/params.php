<?php

/**
 * Ayuda a transmitir parámetros de un script a otro.
 * Al encriptar los datos antes de enviarlos, se asegura que no se cambiarán caracteres
 * por parte del navegador (escapar espacios o caracteres especiales), permitiendo transmitir
 * cualquier cadena de caracteres.
 * 
 * También contiene métodos para la serialización/deserialización de arrays.
 */
class paramStrings {
	
	var $optionsArray=array();
	
	
	/**
	 * Constructor.
	 */
	function paramStrings(){}
	
	/**
	 * Encripta e imprime la cadena de parámetros.
	 */
	function sentParams(){
		$cad="";
		foreach($this->optionsArray as $key => $value)
			$cad.=$key.'?'.base64_encode($value).'¬';
		$cad=base64_encode($cad);
		return $cad;
	}
	
	/**
	 * Recibe una lista de parámetros encriptada.
	 */
	function receiveParams($cadCrypt){
		unset($this->optionsArray);
		$tring=base64_decode($cadCrypt);
		$array=explode('¬',$tring);
		foreach($array as $value){
			$arr=explode('?',$value);
			if($arr[0]!='')
				@($this->addParam($arr[0], base64_decode($arr[1])));
		}
	}
	
	/**
	 * Añade un parámetro más a la lista.
	 */
	function addParam($name, $value){
		$this->optionsArray[$name]=$value;
	}
	
	/**
	 * Devuelve el valor del parámetro recibido como entrada.
	 */
	function getParam($name){
	 	return $this->optionsArray[$name];
	 }

	/**
	 * Utilidades para transformar arrays a strings y viceversa:
	 * 	- string2array: Crea un array a partir de una cadena creada con el método array2string.
	 */
	function string2array($string){
		return unserialize($string);
	}
	
	/**
	 * Utilidades para transformar arrays a strings y viceversa:
	 * 	- array2string: Crea un string a partir de un array, el cual podrá ser recuperado con 
	 * 		el método string2array.
	 */
	function array2string($array){
		return serialize($array);
	}
}