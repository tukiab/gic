<?

/**
 * Clase auxiliar con los métodos comunmente utilizados en la gestión de 
 * contraseñas.
 *
 */
class PAux{
	
	/**
	 * Codifica una contraseña para guardarla en la BBDD.
	 * También se usará para comparar la cadena
	 * introducida con la almacenada previamente en la BBDD, 
	 * codificada con este mismo método.
	 * 
	 * @param string $pass_clear Contraseña en texto plano.
	 * @return string $pass_encode Contraseña codificada.
	 */
	public static function encode($pass_clear){
		$alt_ini = "..este puede ser el principio";
		$alt_end = "de una gran amistad...";
		
		return md5($alt_ini.$pass_clear.$alt_end);
	}
	
	/**
	 * Generación de password aleatorios.
	 *
	 * @param integer $size Número de caracteres. Por defecto 9.
	 * @return string $pass Contraseña aleatoria.
	 */
	public static function gen_Password($size = 9){
		//Grupos de caracteres a incluir
		$chars = "abcdefghijklmnopqrstuvwyz";
		$nums = "0123456789";

		$num_chars = ceil($size/2);
		$num_nums = $size - $num_chars;
			
		$pass = "";

		//Caracteres
		for($i=0; $i<$num_chars; $i++){
			$pos = rand(0, strlen($chars)-1);
			$pass .= $chars[$pos];
		}
		//Números
		for($i=0; $i<$num_nums; $i++){
			$pos = rand(0, strlen($nums)-1);
			$pass .= $nums[$pos];
		}
		
		return $pass;		
	}
}

?>