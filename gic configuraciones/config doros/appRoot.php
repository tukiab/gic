<?php

/**
 * @ignore
 * @package default
 */

//DEBUG
	define('DEBUG', true);
	//FB::log($var, 'Etiqueta'); / info / warn / error

//Obtenemos los parámetros necesarios para calcular la ruta de instalación..

	$doc_root = "/homepages/26/d339816794/htdocs/";
	$script_name = "/gic/html/index.php";

	$dir = 'gic';

//Definiendo las variables y constantes que se usan en el resto de la aplicación:
	$appDir='/'.$dir.'/html';
	$codeRoot = ($doc_root[strlen($doc_root)-1]=='/')?$doc_root.$dir:$doc_root.'/'.$dir;
	$appRoot = ($doc_root[strlen($doc_root)-1]=='/')?$doc_root.$dir.'/html':$doc_root.'/'.$dir.'/html';
	$classRoot = ($doc_root[strlen($doc_root)-1]=='/')?$doc_root.$dir.'/core':$doc_root.'/'.$dir.'/core';



	//Ruta para subir archivos adjuntos:
		//define('UPLOAD_PATH', $codeRoot.'/archive/');
?>
