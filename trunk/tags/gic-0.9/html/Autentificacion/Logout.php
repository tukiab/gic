<?php include ('../appRoot.php');
//include ($codeRoot.'/config/ldapConect.php');
include ($codeRoot.'/config/server.php');
require_once ($codeRoot.'/config/dbConect.php');

// le damos un nombre a la sesion (por si quisieramos identificarla)
session_name('agesene');
// iniciamos sesiones
session_start();
// destruimos la session de usuarios.
foreach ($_SESSION as $key => $value) {
	unset ($_SESSION[$key]);
}
session_destroy();

header ("Location: $appDir/index.php");
?>
