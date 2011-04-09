<?php
/**
 * En éste archivo se irán incluyendo las funciones para exportar datos a
 * los formatos que haga falta.
 */


	/**
	 * Exporta en formato de "hoja de cálculo" (sxc)
	 * 
	 * Recibe el título ($title) y el resultado ($result) de una consulta 
	 * en MySql y manda al cliente un archivo sxc con los datos.
	 *
	 * @param string $title
	 * @param object $result
	 */
	function printToSxcFile($title,$result,$nombre_fichero="export.sxc"){
		//Cabecera enviada al navegador para el archivo sxc.
		if(substr($nombre_fichero,-3)!='sxc')
			$nombre_fichero = $nombre_fichero.'.sxc';
		header("Content-type: application/vnd.sun.xml.calc; charset=UTF-8 ");
		header("Content-Disposition: attachment; filename=".$nombre_fichero);
		header("Pragma: no-cache");
		header("Expires: 0");
		
		//Nos servirá para especificar la ruta hacia el escript en perl.
		include ('../appRoot.php');
 		
		//Obteniendo lista de campos:
		$i=0;
		$head="";
		$nfields=mysql_num_fields($result);
		while ($i < $nfields) {
			
			$name = mysql_field_name($result, $i++);
			if (!$name)
				$head.="NoName-:-:--:-:-";
			else
				$head.=$name."-:-:--:-:-";
		}
	
		//Creando lista de valores
		while($row=mysql_fetch_array($result)){
	
			//Añadimos cada campo a la fila...
			$i=0;
			$line="";
			while ($i < $nfields) {
	
				$line.=$row["$i"]."-:-:--:-:-";
				$i++;
			}
			//Añadimos cada fila al archivo...
			$data .= trim($line)."\t\n";
		}
	
		//Quitamos los caracteres que no queremos del archivo...
		$data = str_replace("\r","",$data);
	
		//Creamos el archivo xls en el directorio /temp
		$handle = fopen("/tmp/centros.xls","wb");
	
		$xls = "$title\t\n$head\t\n$data";
		fwrite ($handle,$xls);
	
		fclose ($handle);
	
		
		//Comando: perl xls2sxc.pl <nombre_fichero_sin_extension>
		shell_exec("perl $appRoot/Scripts/xls2sxc.pl centros");
		
		//Abrimos el fichero creado por el escript y lo enviamos al cliente...
		$handle = fopen("/tmp/centros.sxc","rb");
		$fichero = fread($handle,filesize("/tmp/centros.sxc"));
		fclose ($handle);
	
		exit($fichero);
	}
	
	/**
	 * Exporta en formato de "hoja de cálculo" (sxc)
	 * 
	 * Recibe el título ($title), un array con la cabecera de la tabla
	 * y otro con los datos.
	 * Manda al cliente un archivo sxc con los datos.
	 *
	 * @param string $title
	 * @param object $result 	 
	 */
	function printArrayToSxcFile($title,$header,$input_data, $nombre_fichero="export.sxc"){
		//Cabecera enviada al navegador para el archivo sxc.
		if(substr($nombre_fichero,-3)!='sxc')
			$nombre_fichero = $nombre_fichero.'.sxc';
		header("Content-type: application/vnd.sun.xml.calc; charset=UTF-8 ");
		header("Content-Disposition: attachment; filename=".$nombre_fichero);
		header("Pragma: no-cache");
		header("Expires: 0");
		
		//Nos servirá para especificar la ruta hacia el script en perl.
		include ('../appRoot.php');
 		
		//Obteniendo lista de campos:
		$i=0;
		$head="";
		$nfields=count($header);
		for ($i=0; $i<$nfields; $i++) {
			
			$name = $header[$i];
			if (!$name)
				$head.="NoName-:-:--:-:-";
			else
				$head.=$name."-:-:--:-:-";
		}
	
		//Creando lista de valores
		foreach($input_data as $fila){
	
			//Añadimos cada campo a la fila...
			$i=0;
			$line="";
			while ($i < $nfields) {
	
				$line.=$fila["$i"]."-:-:--:-:-";
				$i++;
			}
			//Añadimos cada fila al archivo...
			$data .= trim($line)."\t\n";
		}
	
		//Quitamos los caracteres que no queremos del archivo...
		$data = str_replace("\r","",$data);
	
		//Creamos el archivo xls en el directorio /temp
		$handle = fopen("/tmp/centros.xls","wb");
	
		$xls = "$title\t\n$head\t\n$data";
		fwrite ($handle,$xls);
	
		fclose ($handle);
	
		
		//Comando: perl xls2sxc.pl <nombre_fichero_sin_extension>
		shell_exec("perl $appRoot/Scripts/xls2sxc.pl centros");
		
		//Abrimos el fichero creado por el escript y lo enviamos al cliente...
		$handle = fopen("/tmp/centros.sxc","rb");
		$fichero = fread($handle,filesize("/tmp/centros.sxc"));
		fclose ($handle);
	
		exit($fichero);
	}

	/**
	 * Exporta en formato de "Nagios" (sxc)
	 * 
	 * Recibe el título ($title), un array con la cabecera de la tabla
	 * y otro con los datos.
	 * Manda al cliente un archivo sxc con los datos.
	 *
	 * @param string $title
	 * @param object $result 	 
	 */
	function printArrayToNagiosFile($nlines, $input_data, $nombre_fichero="centros.db"){
		//Cabecera enviada al navegador para el archivo db texto plano.
		if(substr($nombre_fichero,-3)!='.db')
			$nombre_fichero = $nombre_fichero.'.db';
		header("Content-type: text/plain; charset=UTF-8 ");
		header("Content-Disposition: attachment; filename=".$nombre_fichero);
		header("Pragma: no-cache");
		header("Expires: 0");
		
		//Creando lista de valores
		foreach($input_data as $fila){
			$i=0;
			$line="";
			
			while($i <= $nlines){
				$line.=$fila["$i"]."\n";
				$i++;
			}
			
			//Añadimos cada fila al archivo...
			$data .= trim($line)."\t\n";
		}
		
		//Quitamos los caracteres que no queremos del archivo...
		$data = str_replace("\r","",$data);
		
		//Creamos el archivo db en el directorio /temp
		$handle = fopen("/tmp/centros.db","wb");
		fwrite ($handle,$data);
	
		fclose ($handle);
		
		//Comando: perl xls2sxc.pl <nombre_fichero_sin_extension>
		//shell_exec("perl $appRoot/Scripts/xls2sxc.pl centros");
		
		//Abrimos el fichero creado por el script y lo enviamos al cliente...
		$handle = fopen("/tmp/centros.db","rb");
		$fichero = fread($handle, filesize("/tmp/centros.db"));
		
		fclose ($handle);
	
		exit($fichero);
	}
	
	/**
	 * Envia un archivo $nombre (el contenido en $contenido) del tipo $mimetype
	 */
	function sentFile($nombre, $contenido, $mimetype="text/plain"){
		header("Content-type: $mimetype; charset=UTF-8 ");
		header("Content-Disposition: attachment; filename=".$nombre);
		header("Pragma: no-cache");
		header("Expires: 0");
		
		exit($contenido);
	}
?>