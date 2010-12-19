<?php

// Niveles de Syslog :
/* ******************
echo  LOG_EMERG;
echo  LOG_ALERT;
echo  LOG_CRIT;
echo  LOG_ERR;
echo  LOG_WARNING;
echo  LOG_NOTICE;
echo  LOG_INFO;
echo  LOG_DEBUG;
****************** */

//definir nivel de depuración usando los niveles de syslog.
$nombre_nivel_syslog = array
(
   0 => "Emergencia",
   1 => "Alerta",
   2 => "Critico",
   3 => "Error",
   4 => "Warning",
   5 => "Notice",
   6 => "Info",
   7 => "Debug"
);

/*define_syslog_variables();
$log_local = LOG_LOCAL0;
openlog("sigila", LOG_PID | LOG_PERROR, $log_local);
*/
function GuardarSyslog ($tipo,$nombre,$usuario,$mensaje){
	/*
//Registro LOG
$nivel_log = LOG_DEBUG;

//definir nivel de depuración usando los niveles de syslog.
$nombre_nivel_syslog = array(  0 => "Emergencia",
							   1 => "Alerta",
							   2 => "Critico",
							   3 => "Error",
							   4 => "Warning",
							   5 => "Notice",
							   6 => "Info",
							   7 => "Debug"
							);
	if ($nivel_log >=  $tipo) {
		syslog ($tipo,$nombre_nivel_syslog[$tipo]." : ".$nombre." : ".$usuario." : ".$mensaje);
		return TRUE;
	}
	else{
		return FALSE;
	}*/
}
?>