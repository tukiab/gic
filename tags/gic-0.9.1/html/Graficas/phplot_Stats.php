<?  include ('../appRoot.php');
include ($codeRoot.'/config/dbConect.php');
include ($appRoot.'/Graficas/phplot.php');

define("MAXXDATA",50);//Número máximo a partir del cual no se mostrará la leyenda del eje X.
define("DEFAULT_BGCOLOR",'#Fcf3e2');
define("WHITE_BGCOLOR",'#FFFFFF');


/**
 * Simplifica el uso de la clase phplot mediante algunos métodos de adquisición y 
 * transformación de los datos, y estableciendo por defecto las opciones más comunes.
 */
class phplot_Stats{
	
	var $style;
	var $y_count=0;
	var $x_count=0;
	var $x_max_lenght=0;
	var $data=array();
	var $graph;
	var $field_names=array();
	var $legend=array();
	var $width;
	var $height;
	var $bgColor;
	
	/**
	 * Constructor.
	 */
	function phplot_Stats($which_width=600, $which_height=400, $title, $tyle="default"){
		 
        $this->graph= new PHPlot($which_width, $which_height);
        $this->width=$which_width;
        $this->height=$which_height;
        $this->graph->SetPrintImage(0);
        
        $this->graph->SetDataType("text-data");
        $this->graph->SetFileFormat("GIF");

        $this->graph->SetLineWidths(3);

        $this->graph->SetTitle($title);
		$this->style=$tyle;
		
		$this->bgColor=DEFAULT_BGCOLOR;//Color por defecto

        /* Defino los estilos de las gráficas  */
        switch ($tyle){
        		case "cheese":
				$this->graph->SetPlotType("pie");
        			break;
        			
        		case "bars":
         			$this->graph->SetPlotType("bars");
        			break;	
        			
        		default:
  				$this->graph->SetPlotType("lines");
  				$this->style="lines";
        }
    }
    
    /**
     * Establece el color de fondo.
     * El color por defecto es el de sigila. He añadido la posibilidad de poner el fondo blanco
     * para poder copiar las gráficas en informes.
     */
     function setBgColor($opt){
     	if($opt=='DEFAULT')
     		$this->bgColor=DEFAULT_BGCOLOR;//Color por defecto
     	else
     		$this->bgColor="#FFFFFF";//Blanco
     }
    
    /**
     * Establece el array de datos directamente del resultado de una consulta a la BD.
     */
	function setDataFromQuery($result){
		
		$this->y_count = mysql_num_fields($result);
		
		while($row=mysql_fetch_row($result)){
			$array=array();
			foreach($row as $key=>$value)
				array_push($array,utf8_decode($value));
				
			array_push($this->data, $array);
			$this->x_count++;
		}
		
		$index=1;
		while($index<$this->y_count){
			$info=mysql_fetch_field($result, $index++);
			$this->field_names[]=utf8_decode($info->name);
		}
	}
	
	/**
	 * Establece el array de datos desde un array.
	 */
	function setDataFromArray($array){
		
		unset($this->data);
		
		foreach($array as $keyVal=>$arrayVal){
			$this->field_names[]= $arrayVal[0];
			foreach($arrayVal as $key=>$val)	
				$array[$keyVal][$key]=utf8_decode($val);
		}
		
		$this->data=$array;
		$this->x_count=count($array);
		@$this->y_count=count($array[1]);
	}
	
	/**
	 * En caso de que se quiera dibujar un queso, adapta los datos a %.
	 * 	-Si vienen dos columnas: utiliza una de ellas como leyenda, y la segunda como datos.
	 * 	-Si vienen más de dos: utiliza los nombres de los campos como leyenda, y las sumas 
	 * 		individuales del resto de columnas como datos.
	 */
	 function ifDrawCheese($legPercent=TRUE){

		$array=array(0);
		$legend=array();
		$value=array();

	 	if($this->style!="cheese" || $this->y_count<2)
	 		return false;
	 	
	 	//Primero adaptamos los datos:
	 	//----------------------------	
		if( $this->y_count==2 ){
			
			$sum=0;
			//Calculando la suma total
			foreach($this->data as $value){
				$sum+=$value[1];
			}
				
			//Si no suman ya 100, se hace que sumen 100 (%):
			if($sum!=100){
				reset($this->data);
				foreach($this->data as $value){
					$percent = ($value[1]*100)/$sum;
					if($legPercent)
						$legVal=" (".round($percent,1)."%)";
					else
						$legVal=" (".$value[1].")";
					array_push($array, $percent);
					array_push($legend, $value[0]."$legVal");
				}
				unset($this->data);
				
				$this->data=array($array);
				$this->legend=$legend;
			}
		}
		//Si hay que representar más de una gráfica, se calcula el total de cada una,
		//y se repite la misma operación que ántes por separado.
		else if($this->y_count>2){

			$sum=0;
			$arraySum=array();
			//Inicializando
			foreach($this->data as $id_fila => $fila){
				$arraySum[$id_fila]=0;
			}
			//Calculando las sumas parciales
			foreach($this->data as $id_fila => $fila){
				$num=count($fila);
				for($index=1; $index<$num; $index++){
					$arraySum[$id_fila]+=$fila[$index];
					//De paso calculamos la suma total:
					$sum+=$fila[$index];
				}
			}
				
			//Si no suman ya 100, se hace que sumen 100 (%):
			if($sum!=100){
				reset($this->data);
				foreach($arraySum as $id_fila => $sumaFila){
					$percent = ($sumaFila*100)/$sum;
					if($legPercent)
						$legVal=" (".round($percent,1)."%)";
					else
						$legVal=" (".$sumaFila.")";
					array_push($array, $percent);
					array_push($legend, $this->data[$id_fila][0] ."$legVal");
				}
				unset($this->data);
				
				$this->data=array($array);
				$this->legend=$legend;
			}

		}
		
		//Ahora adaptamos la gráfica:
		//---------------------------
		$lPos=$this->getLegendPosition();
		$lArea=$this->getLegendArea();
  		$this->graph->SetImageArea($this->width + $lArea, $this->height );
  		$this->graph->SetLegendPixels($lPos['x'], $lPos['y'],'');
  		$this->graph->SetLineSpacing(-2);
  		$this->graph->SetShading(30);
  		$this->graph->SetLegend($this->legend);

		return true;
	 }
	 
	/**
	  * Establece las últimas propiedades del objecto 'graph' y lo imprime.
	  */
	 function printGraph($legPercent=TRUE){

		//Adaptando, si es necesario, los datos para el formato 'queso'
	  	if(!$this->ifDrawCheese($legPercent)){
			//Si no se trabata de un 'queso', se gestionan las etiquetas del eje X.
			$this->setXTags();
			//Calcula la escala del eje Y
	 		$this->graph->SetVertTickIncrement($this->getVIncrement());
	  	}
	  		
		//Estableciendo el color de fondo
        	$this->graph->SetBackgroundColor($this->bgColor);

	 	$this->graph->SetDataValues($this->data);
				
	 	$this->graph->DrawGraph();

	 	echo  $this->graph->PrintImage();
	 }
	 
	 /**
	  * Calcula la escale en el eje Y más adecuada.
	  */
	 function getVIncrement(){
	 	$max=0;
	 	$elem=array();
	 	$ielem=array();
	 	
	 	foreach($this->data as $elem){
	 		foreach($elem as $ielem){
	 			if(is_numeric($ielem) && $ielem>$max)
	 				$max=round($ielem,0);
	 		}
	 	}
	 	($max<10)?$inc=1:$inc=round($max/10,0);
	 	
	 	return $inc;
	 }
	 
	 /**
	  * Gestiona la forma de mostrar la leyenda del eje X según el número de elementos
	  * y el tamaño de la etiqueta mas larga.
	  */
	 function setXTags(){
	 	$xnum=count($this->data);
		if($xnum>MAXXDATA){
			if($xnum < (MAXXDATA + 10)){
				$this->graph->SetXLabelAngle(90);
				$tagSpace=5;
				$this->graph->SetPlotAreaPixels(($this->width/10),($this->height/10),$this->width-($this->width/8),$this->height-($this->height/$tagSpace));
			}
			else{
				$felem=reset($this->data);
				$lelem=end($this->data);
				
				$this->graph->SetDrawXDataLabels('0');
				$this->graph->SetXTickPos("xaxis");
				$this->graph->SetXLabel("($xnum valores) Intervalo: ".$felem[0]." - ".$lelem[0]);
				$tagSpace=5;
				$this->graph->SetPlotAreaPixels(($this->width/10),($this->height/10),$this->width-($this->width/8),$this->height-($this->height/$tagSpace));
				$this->graph->SetMarginsPixels(25,25,25,25);
			}
	 	}
		else{
			$this->graph->SetXTickPos("none");

			//Calcula el espacio que hay que dejarle a las etiquetas del eje X
			$tagSpace=$this->getXTagSpace();
			$this->graph->SetPlotAreaPixels(($this->width/10),($this->height/10),$this->width-($this->width/8),$this->height-($this->height/$tagSpace));
		}
	 }
	 
	 /**
	  * Calcula el espacio que hay que dejarle a las etiquetas del eje X
	  */
	 function getXTagSpace(){

		//Cadena mas larga de la leyenda.
		$max=$this->getMaxLegend();

	 	if($max<=10 )
	 		$value=5;
	 	else if($max>10 && $max<=20)
	 		 $value=4;
	 	else if($max>20 && $max<=30)
	 		 $value=3;
	 	else
	 		 $value=2;
	 		 
		if($max>5)
			$this->graph->SetXLabelAngle(90);
		else
			$this->graph->SetXLabelAngle(0);
		
		return $value;
	 }

	 /**
	  * Devuelve el número de caracteres de la cadena mas larga de la leyenda.
	  * 	- En el caso del 'queso', la leyenda está en el array $this->legend
	  */
	 function getMaxLegend($type=''){
	 	$max=0;
	 	$elem=array();
	 	$ielem=array();
	 	
	 	if($type=='cheese'){
			foreach($this->legend as $elem){
	 			if(is_string($elem) && strlen($elem)>$max)
	 				$max=strlen($elem);
	 		}
	 	}
	 	else{
		 	foreach($this->data as $elem){
	 			foreach($elem as $ielem){
		 			if(is_string($ielem) && strlen($ielem)>$max)
		 				$max=strlen($ielem);
		 		}
		 	}
	 	}
		return $max;
	 }
	 
	 /**
	  * Calcula la posición más adecuada para la leyenda de un 'queso'
	  */
	 function getLegendPosition(){
	 	
	 	//Mínimo en array(1, 1)
	 	$maxChars=$this->getMaxLegend('cheese');
	 	
	 	if($this->x_count < 20){
	 		$ypos=40;
	 		if($maxChars<20)
	 			$xpos=220;
	 		else
	 			$xpos=150;
	 	}
	 	else if($this->x_count < 30){
	 		$ypos=40;
	 		if($maxChars<20)
	 			$xpos=150;
	 		else if($maxChars<40)
	 			$xpos=100;
	 		else
	 			$xpos=50;
	 		
	 	}
	 	else{
			$ypos=1;
			$xpos=1;
	 	}

		return array('x'=>$xpos, 'y'=>$ypos);
	 }

	/**
	 * Calcula el área extra que hay que dejarle a la imagen para que la leyenda
	 * de un 'queso' no tape la gráfica.
	 */
	 function getLegendArea(){

	 	$ret = $this->width * 0.5;
	 	
	 	return $ret;
	 }
	 
	 function setLegend($array){
	 	foreach($array as $value)
	 		$this->legend[]=utf8_decode($value);
	 	$this->graph->SetLegend($this->legend);
	 	$this->graph->SetLegendPixels(65, 30,'');
	 }
}
?>