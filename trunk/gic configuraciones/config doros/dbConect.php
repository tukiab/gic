<?php 
	/** 
	 * $dbhost guarda la dirección del servidor de MySQL en un formato 
	 * <nombre>:<puerto>.
	 * 
	 * @staticvar string
	 */
	$dbhost="db8.1and1.es";
	
	/** 
	 * $dbuser guarda el nombre de un usuario de la base de datos
	 * 
	 * El usuario debe tener los siguientes permisos 
	 * sobre la base de datos de SIGILA: SELECT, INSERT y UPDATE.
	 * Este usuario ha de ser creado por el administrador de la base de 
	 * datos como parte del proceso de instalación.
	 * 
	 * @staticvar string
	 */
	$dbuser="dbo346184166";
	
	/** 
	 * $db guarda el nombre de la base de datos
	 *
	 * @staticvar string
	 */
	$db="db346184166";
	
	/**
	 * $dbpass es la clave del usuario dbuser.
	 *
	 * @staticvar string
	 */
	$dbpass = "gepet00";
	
	/**
	 * Estas instrucciones crean el link a la base de datos de SIGILA.
	 */
	$link=mysql_connect("$dbhost","$dbuser","$dbpass");
	mysql_select_db("$db",$link);
	mysql_query("SET NAMES 'utf8'");
?>
