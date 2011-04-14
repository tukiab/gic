<?php	include ('../appRoot.php');
	require ($appRoot.'/Autentificacion/Usuarios.php');

	//Utils
	include_once ($appRoot.'/Common/php/utils/export.php');

	$id = $_GET['id'];
	$nombre_clase = $_GET['clase'];
	$id_archivo = $_GET['id_archivo'];
	
	if(!$id || !class_exists($nombre_clase) || !$id_archivo)
		exit("Error: Faltan datos para enviar el archivo.");
	
	eval("\$Entidad = new $nombre_clase(\$id );");
		
	try{
		$archivos = $Entidad->get_Adjuntos();
		if(!$archivos[$id_archivo] || "Adjunto" != get_class($archivos[$id_archivo]))
			exit("Error: El archivo no existe.");
		
		$Adjunto = $archivos[$id_archivo];
		
		$contenido = $Adjunto->get_Archivo();
		$mimetype = $Adjunto->get_Type();
		$nombre = $Adjunto->get_Name();
		
		header("Content-type: $mimetype; charset=UTF-8 ");
		header("Content-Disposition: attachment; filename=".urlencode($nombre));
		header("Pragma: no-cache");
		header("Expires: 0");
		
		exit($contenido);
	}catch (Exception $e){
		exit("Error: El archivo especificado no existe en el sistema de ficheros.");
	}
?>