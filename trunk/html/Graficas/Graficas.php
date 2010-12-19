<?/*
   *  Para pintar las Gráficas. 
   */
	include ('../appRoot.php');
	include ($codeRoot.'/config/dbConect.php');
	
	//Graficas en general
	require_once ($appRoot.'/Graficas/jpgraph-2.2/src/jpgraph.php');
	//para diagramas de barras
	require_once ($appRoot.'/Graficas/jpgraph-2.2/src/jpgraph_bar.php');
	//polígonos triangulares
	require_once ($appRoot.'/Graficas/jpgraph-2.2/src/jpgraph_line.php');
	require_once ($appRoot.'/Graficas/jpgraph-2.2/src/jpgraph_log.php');
	
	
/*
 * 	Clase encargada de pintar las gráficas con los datos que recibe de la consulta y opciones elegidas.
 *  
 *  - $consulta los datos devuelto por la consulta 
 * 	- $numNiv número de niveles de agrupamiento
 *	- $tipoGraf indica el tipo de gráfica ('1' = poligonal y '0'= barras) pedida.  
 */

class Graficas{

	public function haciendoGraficas($consulta, $tipoGraf, $etiquetas_nivel_1, $etiquetas_nivel_2, $segundo, $titulo='Default'){
	
		$salConsulta = mysql_query($consulta) or die(mysql_error());
		$numColumnas = mysql_num_fields($salConsulta);
		$numFilas    = mysql_num_rows($salConsulta);
		
		$dat = array();
		
		$numNiv = $numColumnas-1;
		
		// Estructurando los datos
		while($row = mysql_fetch_array($salConsulta)){
			if($numColumnas==2){
				$dat[$row[0]]=$row[1];
				$amoave[]=$row[0];
			}
			else if($numColumnas==3){
				$dat[$row[0]][$row[1]]=$row[2];
				$amoave[]=$row[1];
			}
			else
				exit("cago entó!");		
		}
		$amoave = array_unique($amoave);
		$amoave = array_reverse($amoave);
		
      
		// Obteniendo los datos para las etiquetas
		$d1 = array_keys($dat);
		($numNiv>1)?$d2 = getId($etiquetas_nivel_2, $amoave):null;
		$d2 = (is_array($d2))?array_reverse($d2):null;

		//Ántes calculamos el tamaño máximo de las etiquetas para ajustar la proporción de la gráfica.
		($tipoGraf=='1' && $numNiv==2)?$etq_max=get_max_etiqueta($etiquetas_nivel_2):$etq_max=get_max_etiqueta($etiquetas_nivel_1);
		if($etq_max<=12){
			$c_etq=80;
			$ancho=400;
			$largo=750;
		}
		else if($etq_max>12 && $etq_max <=20){
			$c_etq = 120;
			$ancho = 400;
			$largo = 750;
		}
		else if($etq_max>20 && $etq_max <=25){
			$c_etq=150;
			$ancho=450;
			$largo=800;
		}
		else if($etq_max>25 && $etq_max <=30){
			$c_etq=180;
			$ancho=450;
			$largo=800; 
		}
		else{
			$c_etq=210;
			$ancho=500;
			$largo=850;
		}	
		
		/*  
		 *  Creación de la gráfica. Ninguna de las dos pueden faltar nunca.
		 * 
		 *  SetScale  
		 *   - "textlin"  decimal
		 *   - "textlog"  logaritmica en base 10.
		 *   - "linlin"   linear para X e Y.
		 */
		   $graph = new Graph($largo, $ancho, "auto");
		   $graph->SetScale("textlin");
		
		/*
		 *   SetMargin  Margenes de la gráfica (izq,drch,arriba,abajo)
		 *   SetShadow  Sombra
		 */
		   $graph->img->SetMargin(60,40,30,$c_etq);
		   $graph->SetShadow();
		   
		 /*
		  *   Generacion de colores, tira de jpgraphp.php a partir de la línea 4974
		  */ 
			$col = new RGB();
		    $color = array_rand($col->rgb_table);
		
		/*
		 * Representación dependiendo del tipo y nº de niveles.	
		 */
		if($tipoGraf == '1'){
		  switch($numNiv){
			  
				case 1:
					//Datos
					$ydata   = array_values($dat);
					$datax   = array_keys($dat);
	
					//Etiquetas
					$etiquetas=($etiquetas_nivel_1)?getId($etiquetas_nivel_1, $datax):$datax;
			
					// Creando la linea
					$lineplot=new LinePlot($ydata);
					
					// Evaluacion de las lineas
					$lineplot->mark->SetType(MARK_CIRCLE);
					$lineplot->value->SetFormat('%d');
					$lineplot->value->SetFont(FF_FONT1,FS_BOLD);
					$lineplot->value->Show();
					
					$lineplot->SetColor($color);
					//$lineplot->SetFillColor($color);
					$lineplot->SetWeight(0.5);
					
					//$lineplot->SetLegend("Nivel 1");
					$graph->xaxis->SetTickLabels($etiquetas);
					// Add the plot to the graph
					$graph->Add($lineplot);

					break;
					
				case 2:
					
					$array_plots = obtener_line_plots($dat);
					// Obteniendo los datos pa la leyenda
					$leg = ($etiquetas_nivel_1)?getId($etiquetas_nivel_1, $d1):$d1;
					
					$i = 0;
					foreach($array_plots as $key=>$value){
						//Cada linea de un color
						$color = array_rand($col->rgb_table);
						$array_plots[$key]->SetColor($color);
						
						$array_plots[$key]->mark->SetType(MARK_CIRCLE);
						
						// Dato en cada pico de la grafica
						$array_plots[$key]->value->Show();
						
						$array_plots[$key]->SetLegend($leg[$i]);
						
						$graph ->Add($array_plots[$key]);
						$i++;
					}
					
					//Poniendo las etiquetas 
					$graph->xaxis->SetTickLabels($d2);
				    break;		

	
				default:
					break;
			}
			
		}else{ 
			
			switch($numNiv){
				
				case 1:
					//Datos
					$ydata = array_values($dat);
					$datax = array_keys($dat);
		
					// Creacion de las barras si solamente necesitamos una barra
					$bplot = new BarPlot($ydata);
					
					// Color
					$bplot->SetFillColor($color); 
					
					// Tamaño
					$bplot->SetWidth(0.5);
					
					// Evaluacion de las barras 
					$bplot->value->SetFormat('%d');
					$bplot->value->SetFont(FF_FONT1,FS_BOLD);
					$bplot->value->Show();
					$bplot->SetValuePos('center');
					
					//Etiquetas
					$etiquetas=($etiquetas_nivel_1)?getId($etiquetas_nivel_1, $datax):$datax;

					$graph->xaxis->SetTickLabels($etiquetas);
					//$bplot->SetLegend("Datos");
						
					$graph->Add($bplot);
				    break;
			
				case 2:
					
					$array_plots = obtener_bar_plots($dat);
					
					foreach($array_plots as $key=>$value){
						//Cada linea de un color
						$color = array_rand($col->rgb_table);
						
						$array_plots[$key]->SetFillColor($color);
						
						// Dato en cada pico de la grafica
						$array_plots[$key]->value->Show();

						//Haciendo la leyenda
						$array_plots[$key]->SetLegend($d2[$key]);
					} 	
				
			        $gbplot = new GroupBarPlot($array_plots);
			        
					//Etiquetas
					$etiquetas = ($etiquetas_nivel_1)?getId($etiquetas_nivel_1, $d1):$d1;
			        $graph->xaxis->SetTickLabels($etiquetas);

/*		print_r($dat);echo  "<br><br>";
		print_r($etiquetas_nivel_1);echo  "<br><br>";
		print_r($d1);echo  "<br><br>";
		print_r($d2);echo  "<br><br>";
*/		
			        
			        
			        $graph ->Add($gbplot);
				
				 	break;
               
				default:
					break;
			}
		}
			
			
		
		/*
		 *   Titulos con tipos de letras
		 */
		   $titleGr = $titulo;
		   $title1 = "eje X";
		   $title2 = "eje Y";
		   
		   //$graph->title->Set($titleGr);
		  // $graph->xaxis->title->Set($title1);
		   //$graph->yaxis->title->Set($title2);
		
		   //$graph->title->SetFont(FF_FONT1,FS_BOLD);
		   //$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		   //$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
		/*
		 *   Apariencia de lineas divisorias
		 */ 
		   $graph->ygrid->Show(true,false);
		   $graph->xgrid->Show(false,false);
		
		/*
		 *  Especificando los etiquetas de los ejes.
		 *  - SetLabelAngle   vértical, en grados
		 *  - SetTextLabelInterval  horizontal, unidades decimales
		 */
		   //$graph->xaxis->SetTickLabels($x);
		   //$graph->yaxis->SetTickLabels($a);
		   $graph->xaxis->SetLabelAngle(90);
		   //$graph->xaxis->SetTextLabelInterval(1);
		
		
		/*
		 *   Pie de la gráfica
		 *
		   $graph->footer->left->Set ("" );
		   $graph->footer->center->Set("" );
		   $graph->footer->center->SetColor("orange");
		   $graph->footer->center->SetFont( FF_FONT2, FS_BOLD);
		   $graph->footer->right->Set(date);
		*/
		
		
		/*
		 *   Posicion  y medidas de la leyenda
		 */
		  	$graph->legend->SetLayout(LEGEND_HOR); 
		    $graph->legend->Pos(0.05,0.05,"right","bottom"); //  "center","center"
		
		/*
		 *   Pintando la gráfica 
		 */ 
		 //$graph->Stroke();
        return $graph; 
        
	} 
}


/*
 * Devuelve el array de objetos "barPlot" con los que se dibujará la gráfica.
 * 
 * Como entrada recibe un array con la estructura $dat[$row[0]][$row[1]]=$row[2];
 */
function obtener_bar_plots($dat){

	$array_plots = array();
	//Claves distintas del primer nivel = número de grupos de barras.
	$claves_distintas_primer_nivel = array_keys($dat);
	//Obtenemos el número máximo de elementos del segundo nivel según cada valor del primero,
	//que se corresponde con el número de barras en cada grupo.
	$max = get_max_elem($dat, $claves_distintas_primer_nivel);
	
	//Ahora definimos $max ARRAYS con $claves_distintas_primer_nivel ELEMENTOS.
	$array_datos = array();
	for($i=0;$i<$max;$i++){
		$arr = array();
		foreach($claves_distintas_primer_nivel as $clave){
			$dat_tmp = array_values($dat[$clave]);
			
			if($dat_tmp[$i])
				array_push($arr,$dat_tmp[$i]);
			else
				array_push($arr,0);
		}
		array_push($array_datos, $arr);
	}
	
	//Ahora que tenemos los arrays, nos creamos los objetos "barPlot" correspondientes.
	foreach($array_datos as $datos){
		$temp_plot = new barPlot($datos);

		array_push($array_plots, $temp_plot);
	}
	
	return $array_plots;
}

/**
 * Devuelve el array de objetos "LinePlot" con los que se dibujará la gráfica.
 * 
 * Como entrada recibe un array con la estructura $dat[$row[0]][$row[1]]=$row[2];
 */
function obtener_line_plots($dat){

/*
Array ( [1] => Array ( [1] => 552.19401611 [3] => 500.74970420 [5] => 26.32635050 ) 
		[2] => Array ( [1] => 688.73938577 [3] => 688.24639378 ) )
*/
	$array_plots = array();
	//Claves distintas del primer nivel = número de lineas
	$claves_distintas_primer_nivel = array_keys($dat);
	//Obtenemos el número máximo de elementos del segundo nivel según cada valor del primero,
	//que se corresponde con el número de barras en cada grupo.
	$max = get_max_elem($dat, $claves_distintas_primer_nivel);
	
	//Ahora definimos $claves_distintas_primer_nivel ARRAYS con $max ELEMENTOS.
	$array_datos = array();
	foreach($claves_distintas_primer_nivel as $clave){
		$arr = array();
		
		for($i=0;$i<$max;$i++){
			$dat_tmp = array_values($dat[$clave]);
			if($dat_tmp[$i])
				array_push($arr,$dat_tmp[$i]);
			else
				array_push($arr,0);			
		}
		array_push($array_datos, $arr);
	}
	
	//Ahora que tenemos los arrays, nos creamos los objetos "LinePlot" correspondientes.
	foreach($array_datos as $datos){
		$temp_plot = new LinePlot($datos);
		array_push($array_plots, $temp_plot);
	}
	
	return $array_plots;
}

/*
 * Devuelve el número máximo de elementos del segundo nivel de $dat correspondiente a cada clave de $claves.
 */
function get_max_elem($dat, $claves){
	$max = 0;
	foreach($claves as $clave)
		(count($dat[$clave])>$max)?$max=count($dat[$clave]):null;
	return $max;
}

/*
 *  Devuelve los indices y nombres de los arrays de etiquetas
 */

function getId($etiquetas, $datos){
	
	$etq = array();
	$valores = array_values($etiquetas);

	foreach($datos as $dato){
	  for($i=0; $i<count($etiquetas); $i++){
		@($etiquetas[$i]['id'] == $dato)?array_push($etq, utf8_decode($etiquetas[$i]['nombre'])):null;
	  } 
	}
	
	return $etq;
}

/*
 * Devuelve el ancho máximo del campo de las etiquetas.
 */
function get_max_etiqueta($array_etiquetas){

	foreach($array_etiquetas as $etiqueta){
		if( strlen($etiqueta['nombre']) > $max)
			$max = strlen($etiqueta['nombre']);
	}

	return $max;
}
?>