<?php	include ('../appRoot.php');

include ($codeRoot.'/config/server.php');
require_once ($codeRoot.'/config/dbConect.php');

require_once ($appRoot.'/Autentificacion/_permisos.php');
include ($appRoot.'/Common/php/mensajes.php');
include ($appRoot.'/Autentificacion/datos/datosLogin.php');
include ($appRoot.'/Common/php/utils/syslogRegister.php');

include ($appRoot.'/Common/php/autoload.php');

//FB::setEnabled(DEBUG);
if(DEBUG)
	ob_start();

//Ruta hacia el archivo de error de lectura:
$error_no_lectura = "/Autentificacion/error_acceso.php";
//Ruta hacia el archivo de login:
$ruta_login = "/Autentificacion/Login.php";
//Ruta hacia el script actual (junto con todas las opciones pasadas en la URL)
$peticion_url = getLoginURL();

//Chequea si se llama directo al script
$url = explode("?",$_SERVER['HTTP_REFERER']);
$origen=$url[0];
if (( strcmp(basename($_SERVER['PHP_SELF'],"/"), "")==0) ){
	//Registro LOG
	GuardarSyslog (LOG_DEBUG,basename($_SERVER['PHP_SELF'],"/"),$_SESSION["usuario_login"],"Error: Acceso Incorrecto");
	header ("Location: http://$peticion_url&errno=1");//ACCESO INCORRECTO
	exit;
}

// Comprueba si se viene del formulario de entrada al sistema:
if (  isset($_POST['user']) && isset($_POST['pass']) ) {
	if(!comprobarPass($_POST['user'], $_POST['pass'])){
		GuardarSyslog (LOG_ERR,basename($_SERVER['PHP_SELF'],"/"),$_SESSION["usuario_login"],"Error usuario y password");		
		header ("Location:  http://$peticion_url&errno=2");
	}
	else{
	
		$usuario = new Usuario($_POST['user']);
		$login = $_POST['user'];
		// Conexión establecida
		// En este punto, el usuario ya esta validado
		// Grabo los datos del usuario en una sesión
					
			// le doy un nombre a la sesión.
			session_name('agesene');
			// Decimos al navegador que no "cachee" esta página.
			session_cache_limiter('nocache,private');
			
			// inicio sesiones
			session_start();
						
			$_SESSION['usuario_nombre']=$usuario->get_Nombre();
		
			$usuario_tipo = $usuario->get_Perfil();
			$_SESSION['usuario_tipo'] = $usuario_tipo;
			$_SESSION['usuario_login']=$login;
		
			$datos_usuario=new dataUsers();
			$result=$datos_usuario->obtenerDatosUsuario($login);
			
			//En caso de error en la consulta, lo registramos en el syslog y salimos:
			if(!$result) {
				echo  'Error ';
				echo  mysql_errno();
				echo  ': ';
				echo  mysql_error();
				//Registro LOG
				GuardarSyslog (LOG_ERR,basename($_SERVER['PHP_SELF'],"/"),$_SESSION["usuario_login"],$query);
				//En este punto, antes de salir destruimos todos los datos de la sesión:
				foreach ($_SESSION as $Nombre => $Valor) {
					unset ($_SESSION[$Nombre]);
				} 
				unset($login);
				unset ($relogin);
				session_destroy();
				//Saliendo...		
				die();
			}	
			
			//Borramos las variables "importantes"
			unset($login);
			unset ($relogin);
			
			//Vamos a la página actual (sin https)
			@header("Location: http://$peticion_url");
		}
}
else{
	// Si no viene del formulario de entrada al sistema, chequear si la sesión existe:

	// usamos la sesion de nombre definido.
	session_name('agesene');
	// Iniciamos el uso de sesiones
	session_start();

	// Registro LOG
	GuardarSyslog (LOG_DEBUG,basename($_SERVER['PHP_SELF'],"/"),$_SESSION["usuario_login"],"Acceso"); //"Acceso realizado con exito."

	// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
	// El caso mas común es el de una vez "matado" la sesión se intenta volver hacia atras
	// con el navegador.

	if (!isset($_SESSION['usuario_login'])){
		//Si no está definida es que el usuario no ha pasado por el formulario de autentificación:
		
		// Borramos la sesión por el inicio de sesión anterior
		session_destroy();
		
		//Registro LOG
		GuardarSyslog (LOG_ERR,basename($_SERVER['PHP_SELF'],"/"),$_SESSION["usuario_login"],"Error de Acceso");
	
		closelog();
		
		include($appRoot.$ruta_login);
		exit;
	}
	
	//Registros LOG Cerrar
	closelog();
}

//Comprobando los derecho s de acceso
/* 
 * Clase que, a partir del usuario y el script, devuelve los permisos de el primero sobre el segundo.
 */ 
  		$permisos = new Permisos($_SESSION["usuario_login"], $_SERVER['PHP_SELF']);
  		//Si no tiene permiso de lectura, redirigimos a la pantalla correspondiente:
  		if(!$permisos->lectura){
  			include($appRoot.$error_no_lectura);
  			exit;
  		}
  		$gestor_actual = new Usuario($_SESSION["usuario_login"]);
/* 
 * Variable que indica qué permisos tiene el usuario sobre el escript actual:
 * 		$permisos->lectura 		=> bool
 * 		$permisos->escritura 	=> bool
 * 		$permisos->administracion	=> bool
 * 
 * También implementa un método para averiguar el permiso de lectura del usuario actual 
 * sobre cualquier escript:
 * 		$permisos->permisoLectura($nombre_escript)	=> bool
 * 
 * (Se pueden utilizar en cada página para ocultación de botones, mensajes de error, etc...)
 */
  		
  		
 /**
  * Función auxiliar que devuelve la ULR actual
  */
function getLoginURL(){
	global $appDir;
	
	$params="?";
	foreach($_GET as $key => $value){
		if($key=='Nq55R7R-qfw')
			break;
		$params.="&$key=$value";
	}
	$params.="&Nq55R7R-qfw";
	
	$url = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].$params;
	return $url;
}

function comprobarPass($usuario, $pass){

	$query = "SELECT password FROM usuarios WHERE id='$usuario'";
	//FB::info($query,'query pass');
	$rs = mysql_query($query);
	$row = mysql_fetch_array($rs);
	//FB::info("pass pasado: ".$pass." y pass cogido: ".$row['password']);
	if($pass == $row['password'])
		return true;
		
	return false;
}
?>
