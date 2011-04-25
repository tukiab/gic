<?php
/**
 * Clase estática que contempla operaciones de fechas
 * 
 * @package Utils
 * @version 0.1
 * @author 
 * José Ignacio Ortiz de Galisteo Romero
 * 
 */

class Fechas{
	
	/**
	 * Convierte a timestamp una fecha en el formato dd/mm/aa
	 * @param Date $date Fecha en formato dd/mm/aa
	 * @param boolean $hora Indica si tenemos en cuenta la hora, minutos y segundos actuales
	 * @return timestamp $ts fecha en formato timestamp 
	 */
	public static function date2timestamp($date, $hora=false){
		if ($hora){
			$tmp = explode("/", $date);
			return @mktime(23,59,59,$tmp[1], $tmp[0], $tmp[2]);
		}else{
			$tmp = explode("/", $date);
			return @mktime(0,0,0,$tmp[1], $tmp[0], $tmp[2]);
		}
	}
	
	/**
	 * Devuelve la fecha actual en timestamp, sin tener en cuenta las horas, minutos y segundos. 
	 * Devuelve, por tanto, el timestamp asociado al inicio del día.
	 * @return timestamp $ts fecha en formato timestamp
	 */
	public static function fechaActualTimeStamp(){
		$fecha = date("d/m/Y",time());
	 	$fecha_ts = self::date2timestamp($fecha);
	 	return $fecha_ts;
	}

	/**
	 * Convierte una fecha en formato timestamp al formato dd/mm/aaaa
	 * @param timestamp $ts fecha en timestamp
	 * @param boolean $hour Indica si hemos de tener en cuenta las horas, minutos y segundos.
	 */
	public static function timestamp2date($ts, $hour=False){
		if($ts)
			if($hour)
				return date("d/m/Y - H:i", $ts);
			else
				return date("d/m/Y", $ts);
		return "";
	}

        public static function timstamp2date2order($ts, $hour=false){
            if($ts)
                if($hour)
                    return date("Y/m/d - H:i", $ts);
                else
                    return date("Y/m/d", $ts);
            return "";
        }
	
	/**
	 * Calcula el número de día de la semana (L -> 1, M -> 2, ..., D -> 7)
	 * @param integer $dia 
	 * @param integer $mes
	 * @param integer $year
	 * 
	 * @return integer $numerodiasemana día de la semana (L -> 1, M -> 2, ..., D -> 7)
	 */
	public static function numeroDiaSemana($dia,$mes,$year){
			$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$year));
			if ($numerodiasemana == 0) 
				$numerodiasemana = 6;
			else
				$numerodiasemana--;
				
			return $numerodiasemana;
		}
	
	/**
	 * Devuelve el nombre del día de la semana asociado a la fecha dada.
	 * @param integer $dia 
	 * @param integer $mes
	 * @param integer $year
	 * @return $day Nombre del día de la semana correspondiente a la fecha dada
	 */
	public static function dayOfTheWeek($dia, $mes, $year){
		$ts = mktime(0,0,0,$mes,$dia,$year);
		$number_day = date("w",$ts);
		
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
	 * Devuelve un array indexado por 'num' y 'nombre, representando el número y el nombre del mes, respectivamente.
	 * @return Array $lista array que contiene los meses del año
	 */
	public static function listaMeses(){
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
	 * Devuelve un array con la lista de años
	 * @return array $lista lista con años para mostrar en los desplegables
	 */
	public static function listaYears(){
		$lista = array();
		$this_year = date("Y",time());
		for($y=2009;$y<=$this_year;$y++)
			$lista[] = $y;
		return $lista;
	}
	
	/**
	 * 
	 * @param mes y año
	 * @return array $lista_dias array indexado por número de día (num_dia), día de la semana (dia_sem) y laborable (es_laborable)
	 */
	public static function listaDias($mes, $year){
			
		$lista_dias = array();
		$num_dias = self::numeroDeDias($mes, $year);
	
		for($i=1; $i<=$num_dias; $i++){
			$lista_dias[] = array('num_dia' => $i, 'dia_sem' => self::dayOfTheWeek($i, $mes, $year), 'es_laborable' => self::esLaborable($i, $mes, $year));
		}
		
		return $lista_dias;
	}
	
	/**
	 * Devuelve el nombre del mes pasado.
	 * @param integer $mes número del mes
	 * @return string $nombre nombre del mes
	 */
	public static function obtenerNombreMes($mes){
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
	 * @return boolean $es_laborable indica si la fecha pasada es laborable o no
	 */
	public static function esLaborable($dia, $mes, $year){
		$day = self::dayOfTheWeek($dia, $mes, $year);
		if($day == "Dom" || $day == "Sab") //Sábado o Domingo
			return 0;
		if(self::es_Festivo($dia, $mes, $year))
			return 0;
			
		return 1;
	}
	
	/**
	 * Indica si el día pasado es festivo.
	 * El día es festivo si está guardado en la BBDD como tal
	 * @param $dia
	 * @param $mes
	 * @param $year
	 * 
	 * @return boolean $es_festivo Indica si el día es festivo
	 */
	public static function es_Festivo($dia, $mes, $year){
		$date = $dia."/".$mes."/".$year;
		/*$fecha_ts = self::date2timestamp($date);
		
		$query = "SELECT * FROM dias_festivos WHERE fecha='$fecha_ts' limit 1;";
		$rs = mysql_query($query);
		
		if(mysql_num_rows($rs) < 1)
			return false;
		
		return true;
		*/
		return self::es_Festiva(self::date2timestamp($date));
	}
	
	/**
	 * Indica si la fecha dada es festiva.
	 * La fecha es festiva si está guardada en la BBDD y su bandera 'festiva' está activa
	 * @param timestamp $fecha_ts
	 * @return boolean $es_festiva Indica si la fecha es festiva
	 */
	public static function es_Festiva($fecha_ts){
		$query = "SELECT * FROM dias_festivos WHERE fecha='$fecha_ts' AND festivo='1' limit 1;";
		$rs = mysql_query($query);
		
		if(mysql_num_rows($rs) < 1)
			return false;
		
		return true;
		
	}
	/**
	 * Actualiza la BBDD con las fechas que son festivas y las que no.
	 * @param array $fechas_festivos Array con las fechas (en formato timestamp) que son festivas
	 * @param array $fechas_no_festivos Array con las fechas (en formato timestamp) que NO son festivas
	 */
	public static function actualizarDiasFestivos($fechas_festivos, $fechas_no_festivos){
		
		foreach($fechas_festivos as $fecha){
			if(!self::es_Festiva($fecha)){ //Comprobamos si ya es festivo
				//Si no lo es tenemos que comprobar si la fecha existe en la BBDD, para actualizar el registro, o para actualizarlo
				if(self::fecha_Registrada($fecha))
					$query = "UPDATE dias_festivos SET fecha='$fecha', fecha_cambio='".self::fechaActualTimeStamp()."',
														festivo='1', fk_operador='".$_SESSION['usuario_login']."';";
				else
					$query = "INSERT INTO dias_festivos (fecha, fecha_cambio, festivo, fk_operador) 
									VALUES ('$fecha','".time()."','1','".$_SESSION['usuario_login']."')";
					
				if(!$rs = mysql_query($query))
					throw new Exception("Error al actualizar los d&iacute;s festivos en la BBDD");
			}
		}
		foreach($fechas_no_festivos as $fecha){
			if(self::es_Festiva($fecha)){//Si es festivo tenemos que anularlo de la BBDD 
				
				$query = "UPDATE dias_festivos 
							SET fecha_cambio='".time()."',
									festivo='0', fk_operador='".$_SESSION['usuario_login']."'
							WHERE fecha='$fecha';";
				
				if(!$rs = mysql_query($query))
					throw new Exception("Error al actualizar los d&iacute;s no festivos en la BBDD");
			}//En caso contrario no hemos de hacer nada.
		}
	}
	
	/**
	 * Indica si la fecha dada está registrada en la BBDD como posible dia_festivo
	 * @param timestamp $fecha
	 * @return boolean $registrada
	 */
	public static function fecha_Registrada($fecha){
		
		$query = "SELECT fecha FROM dias_festivos WHERE fecha='$fecha' limit 1;";
		$rs = mysql_query($query);
		
		if(mysql_num_rows($rs) > 0)
			return true;
			
		return false;
	}
	
	public static function obtener_Datos_Festivos($fecha){
		$query = "SELECT * FROM dias_festivos WHERE fecha='$fecha' limit 1;";
		$rs = mysql_query($query);
		
		if(mysql_num_rows($rs) > 0)
			return mysql_fetch_array($rs);
	}
	/**
	 * Devuelve el número de días de un mes y año dados.
	 * @param int $mes
	 * @param int_type $year
	 * @return int $numerodedias
	 */
	public static function numeroDeDias($mes, $year){
		$res = 0;
		if (((fmod($year,4)==0) and (fmod($year,100)!=0)) or (fmod($year,400)==0))
	    	$dias_febrero = 29;
		else
	    	$dias_febrero = 28;
	
		if($mes == 1 || $mes == 3  || $mes == 5  || $mes == 7  || $mes == 8  || $mes == 10  || $mes == 12)
			$res = 31;
		else if($mes == 02)
			$res = $dias_febrero;
		else
			$res = 30;
			
		return $res;
	}
	
	/**
	 * Devuelve la fecha en formato timestamp del primer día del mes de la fecha dada
	 * @param timestamp $ts
	 * @return timestamp
	 */
	public static function inicioMes($ts){
		$fecha = getdate($ts);
		$year = $fecha['year'];
		$mes = $fecha['mon'];
		$num_dias = self::numeroDeDias($mes, $year);
			
		return mktime(0,0,0,$mes,1,$year);
	}
	
	/**
	 * Devuelve la fecha en formato timestamp del primer día del mes siguiente de la fecha dada
	 * @param timestamp $ts
	 * @return timestamp $fecha fecha en formato timestamp
	 */
	public static function finMes($ts){
		$fecha = getdate($ts);
		$year = $fecha['year'];
		$mes = $fecha['mon'];
		$num_dias = self::numeroDeDias($mes, $year);
			
		return mktime(0,0,0,$mes,$num_dias+1, $year);		
	}

	public static function siguienteMes($mes){
		if($mes == 12)
			return 1;

		return $mes+1;
	}
	/*
	 * ************************************************
	 *  Funciones para pintar el cuadro del calendario
	 * ************************************************
	 */
	
	public static function mostrarCalendarioFestivos($mes,$year){
		$nombre_mes = self::obtenerNombreMes($mes);
		
		// CABECERA
		echo '<table class="month">';
			//MES Y AÑO
		echo '	<tr>
					<td colspan="7" class="name" >'.$nombre_mes." ".$year.'</td>';
		echo '	</tr>';
			//DÍAS DE LA SEMANA
		echo '	<tr>
				    <td class="dayweek" >L</td>
				    <td class="dayweek" >M</td>
				    <td class="dayweek" >X</td>
				    <td class="dayweek" >J</td>
				    <td class="dayweek" >V</td>
				    <td class="dayweek" >S</td>
				    <td class="dayweek" >D</td>
				</tr>';
		
		$dia_actual = 1;
		$numero_dia_semana = self::numeroDiaSemana(1,$mes,$year);
		$ultimo_dia = self::numeroDeDias($mes,$year);
		
		//PRIMERA LÍNEA: columnas vacías hasta llegar al primer día del mes
		echo '	<tr>';
		for ($i=0;$i<7;$i++){
			if ($i < $numero_dia_semana){
				//columna vacía si no hemos llegado al primer día
				echo '<td style="background:none"></td>';
			} else {
				self::print_day($dia_actual, $mes, $year);
				$dia_actual++;
			}
		}
		echo '	</tr>';
		
		//RESTO DE LÍNEAS
		$numero_dia_semana = 0;
		while ($dia_actual <= $ultimo_dia){
			//si estamos a principio de la semana empieza la línea: <tr>
			if ($numero_dia_semana == 0)
				echo '<tr>';
			self::print_day($dia_actual, $mes, $year);
			$dia_actual++;
			$numero_dia_semana++;
			//si es el último de la semana reiniciamos el día y cerramos la fila: </tr>
			if ($numero_dia_semana == 7){
				$numero_dia_semana = 0;
				echo '</tr>';
			}
		}
		
		//columnas vacías hasta final de la semana
		for ($i=$numero_dia_semana;$i<7;$i++){
			echo '		<td style="display:none"></td>';
		}
		
		echo '	</tr>';
		echo '</table>';
	}	
	public static function print_day($dia_actual, $mes, $year){
		$class = 'class="day"';
		$dia_sem = self::numeroDiaSemana($dia_actual, $mes, $year);
		
		if($dia_sem == 5 || $dia_sem == 6)
			$class = 'class="finde"';

		else if(!self::esLaborable($dia_actual,$mes,$year))
			$class = 'class="festive_day"';
		$datos = self::obtener_Datos_Festivos(self::date2timestamp($dia_actual."/".$mes."/".$year));
		
		$title='';
		if($datos['fk_operador'])
			$title='title="Modificado por '.$datos['fk_operador'].' el '.self::timestamp2date($datos['fecha_cambio'],true).'"';
		
			echo '<td '.$class.' '.$title.' value="'.$dia_actual.'/'.$mes.'/'.$year.'">'.$dia_actual.'</td>';
	}

        /**
         * Devuelve la fecha timestamp correspondiente al inicio del día de la fecha dada
         * @param <integer> $ts
         * @return <integer>  $fecha
         */
        public static function principioDia($ts){
            return self::date2timestamp(self::timestamp2date($ts));
        }
}

?>