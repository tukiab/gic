<?php
include ('../appRoot.php');
require_once ($codeRoot.'/config/dbConect.php');
	

function web($web){
	return "<a target=\"_blank\" href=\"http://".$web."\">".$web."</a>";
}
function email($mail){
		return "<a href=\"mailto:".$mail."\">".$mail."</a>";
}
// Convierte una fecha del tipo: DD/MM/AAAA a AAAA-MM-DD
function fecha2mysql($fecha){
	$res = false;
	$res=$res || ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	$res=$res || ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
	$res=$res || ereg( "([0-9]{1,2}),([0-9]{1,2}),([0-9]{2,4})", $fecha, $mifecha);
	$res=$res || ereg( "([0-9]{1,2}).([0-9]{1,2}).([0-9]{2,4})", $fecha, $mifecha);
	$lafecha=$mifecha[1]."/".$mifecha[2]."/".$mifecha[3];
	//print($lafecha);
	if($res)
   	 	return $lafecha;
   	else
   		return $fecha;
}

function esAdministrador($id_perfil){
	return ($id_perfil == 5 || $id_perfil == 6);
}

/**
 * Convierte a timestamp una fecha en el formato dd/mm/aa
 */
function date2timestamp($date, $hora=false){
	if ($hora){
		$tmp = explode("/", $date);
		return @mktime(23,59,59,$tmp[1], $tmp[0], $tmp[2]);
	}else{
		$tmp = explode("/", $date);
		return @mktime(0,0,0,$tmp[1], $tmp[0], $tmp[2]);
	}
}
function fechaActualTimeStamp(){
	$fecha = date("d/m/Y",time());
 	$fecha_ts = date2timestamp($fecha);
 	return $fecha_ts;
}
/**
 * Convierte una fecha en formato timestamp al formato dd/mm/aaaa
 */
function timestamp2date($ts){
	if($ts)
		return date("d/m/Y", $ts);
	return "";
}

/**
 * 
 * @param $ts Fecha en formato timestamp
 * @return $day Día de la semana correspondiente a la fecha dada
 */
function dayOfTheWeek($dia, $mes, $year){
	$ts = mktime(0,0,0,$mes,$dia,$year);
	$number_day = date("w",$ts);
	//FB::info($ts, "timestamp");
	//$fecha = date("Y/m/d", $ts);
	//FB::info($fecha, "en date");
	switch($number_day){
		case 0:
			return "Dom";
			break;
		case 1:
			return "Lun";
			break;
		case 2:
			return "Mar";
			break;
		case 3:
			return "Mie";
			break;
		case 4:
			return "Jue";
			break;
		case 5:
			return "Vie";
			break;
		case 6:
			return "Sab";
			break;
	}
}
/**
 * 
 * @return $lista array que contiene los meses del año
 */
function listaMeses(){
	$lista = array(0 => array('num' => 1, 'nombre' => Enero),
									1 => array('num' => 2, 'nombre' => Febrero),  
									2 => array('num' => 3, 'nombre' => Marzo), 
									3 => array('num' => 4, 'nombre' => Abril), 
									4 => array('num' => 5, 'nombre' => Mayo), 
									5 => array('num' => 6, 'nombre' => Junio), 
									6 => array('num' => 7, 'nombre' => Julio),
									7 => array('num' => 8, 'nombre' => Agosto), 
									8 => array('num' => 9, 'nombre' => Septiembre), 
									9 => array('num' => 10, 'nombre' => Octubre), 
									10 => array('num' => 11, 'nombre' => Noviembre), 
									11 => array('num' => 12, 'nombre' => Diciembre), 									 																																						
		
		);
	return $lista;
}
/**
 * 
 * @return $lista lista con años para mostrar en los desplegables
 * Cambiar esta función para que lea de la BBDD o algo y no sea estático
 */
function listaYears(){
	$lista = array(2009,2010,2011);
	return $lista;
}

/**
 * 
 * @param mes y año
 * @return array $lista_dias array indexado por número de día (num_dia), día de la semana (dia_sem) y laborable (es_laborable)
 */
function listaDias($mes, $year){
		
	$lista_dias = array();
	$num_dias = numeroDeDias($mes, $year);

	for($i=0; $i<$num_dias; $i++){
		$lista_dias[] = array('num_dia' => $i+1, 'dia_sem' => dayOfTheWeek($i+1, $mes, $year), 'es_laborable' => esLaborable($i+1, $mes, $year));
	}
	
	return $lista_dias;
}
function obtenerNombreMes($mes){
	$nombre = "";
	switch($mes){
		case 1:
			$nombre = "Enero";
			break;
		case 2:
			$nombre = "Febrero";
			break;
		case 3:
			$nombre = "Marzo";
			break;
		case 4:
			$nombre = "Abril";
			break;
		case 5:
			$nombre = "Mayo";
			break;
		case 6:
			$nombre = "Junio";
			break;
		case 7:
			$nombre = "Julio";
			break;
		case 8:
			$nombre = "Agosto";
			break;
		case 9:
			$nombre = "Septiembre";
			break;
		case 10:
			$nombre = "Octubre";
			break;
		case 11:
			$nombre = "Noviembre";
			break;
		case 12:
			$nombre = "Diciembre";
			break;
	}
	return $nombre;
}
/**
 * 
 * @param dia, mes y año
 * @return boolean es_laborable Boolean que indica si la fecha pasada es laborable o no
 */
//TODO Mejorar la función para que acceda a alguna parte donde se indique si un día es laborable o no.
function esLaborable($dia, $mes, $year){
	$day = dayOfTheWeek($dia, $mes, $year);
	if($day == "Dom" || $day == "Sab") //Sábado o Domingo
		return 0;
	if(es_Festivo($dia, $mes, $year))
		return 0;
		
	return 1;
}
function es_Festivo($dia, $mes, $year){
	$date = $dia."/".$mes."/".$year;
	$fecha_ts = date2timestamp($date);
	
	$query = "SELECT * FROM dias_festivos WHERE fecha='$fecha_ts' limit 1;";
	$rs = mysql_query($query);
	
	if(mysql_num_rows($rs) < 1)
		return false;
	
	return true;
	
}
function es_Festiva($fecha_ts){
	$query = "SELECT * FROM dias_festivos WHERE fecha='$fecha_ts' limit 1;";
	$rs = mysql_query($query);
	
	if(mysql_num_rows($rs) < 1)
		return false;
	
	return true;
	
}
function actualizarDiasFestivos($fechas_festivos, $fechas_no_festivos){
	
	foreach($fechas_festivos as $fecha){
		if(!es_Festiva($fecha)){
			$query = "INSERT INTO dias_festivos (fecha) VALUES ('$fecha')";
			$rs = mysql_query($query);
		}
	}
	foreach($fechas_no_festivos as $fecha){
		if(es_Festiva($fecha)){
			$query = "DELETE FROM dias_festivos WHERE fecha='$fecha'";
			$rs = mysql_query($query);
		}
	}
}
/**
 * Devuelve el número de días de un mes en un año dados.
 * @param int $mes
 * @param int_type $year
 * @return int
 */
function numeroDeDias($mes, $year){
	
	if (((fmod($year,4)==0) and (fmod($year,100)!=0)) or (fmod($year,400)==0))
    	$dias_febrero = 29;
	else
    	$dias_febrero = 28;
	
	if($mes == 01 || $mes == 03  || $mes == 05  || $mes == 07  || $mes == 08  || $mes == 10  || $mes == 12)
		return 31;
	else if($mes == 02)
		return $dias_febrero;
	else
		return 30;
}
/**
 * Devuelve la fecha en formato timestamp del primer día del mes de la fecha dada
 * @param timestamp $ts
 * @return timestamp
 */
function inicioMes($ts){
	$fecha = getdate($ts);
	$year = $fecha['year'];
	$mes = $fecha['mon'];
	$num_dias = numeroDeDias($mes, $year);
		
	return mktime(0,0,0,$mes,1,$year);
}
/**
 * Devuelve la fecha en formato timestamp del primer día del mes siguiente de la fecha dada
 * @param timestamp $ts
 * @return timestamp
 */
function finMes($ts){
	$fecha = getdate($ts);
	$year = $fecha['year'];
	$mes = $fecha['mon'];
	$num_dias = numeroDeDias($mes, $year);
		
	return mktime(0,0,0,$mes,$num_dias+1, $year);		
}

/**
 * Devuelve un array preparado para poder ser enviado como parámetro
 * @param array() $array array a enviar
 * @return $tmp array para enviar como parámetro
 */
function array2arrayAEnviar($array) {
     $tmp = serialize($array);
     $tmp = urlencode($tmp);

     return $tmp;
} 
/**
 * Devuelve un array php a partir de un array enviado como parámetro.
 * Usualmente esta función se usará en los scripts que reciban el parámetro enviado por otro tras usar la función @array2arrayAEnviar
 * @param $url_array Parámetro recibido a convertir en array
 * @return array() $tmp Array php
 */
function arrayRecibido2array($url_array) {
     $tmp = stripslashes($url_array);
     $tmp = urldecode($tmp);
     $tmp = unserialize($tmp);

    return $tmp;
} 
function getArrayTelefono($tel){
	substr('abcdef', 1, 3);  // bcd
	$tel1 = substr($tel, 0, 3);
	$tel2 = substr($tel, 3, 3);
	$tel3 = substr($tel, 6, 3);
	return array($tel1, $tel2, $tel3);
}
function impArrayTelefono($t){
	$tel = getArrayTelefono($t);
	return $tel[0]."&#8212;".$tel[1]."&#8212;".$tel[2];
}
?>