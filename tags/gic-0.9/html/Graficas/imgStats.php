<?  include ('../appRoot.php');
/**
 * Éste archivo hace de punto de entrada para generar una gráfica con Graficas/php_stats.php.
 * Para los parámetros se utiliza la clase Utils/params.php.
 * 
 * 	<img src="<?echo  "/Graficas/imgStats.php?opt=".objetoParams.sentParams();?>">
 * 
 * Puesto que éste archivo lo único que hace es utilizar la clase phplot_Stats,
 * los parámetros pasados dependen del tipo de gráfica que se desea generar.
 */

	include ($codeRoot.'/config/dbConect.php');
	include ($appRoot.'/Graficas/phplot_Stats.php');
	include ($appRoot.'/Utils/params.php');

	$array=array();
	$params = new paramStrings();
	$params->receiveParams($_GET['opt']);

	@(($params->getParam('style')!='')?$style=$params->getParam('style'):$style="bars");
	@(($params->getParam('bgcolor')!='')?$bgcolor=$params->getParam('bgcolor'):$bgcolor="DEFAULT");
	@(($params->getParam('title')!='')?$title=utf8_decode($params->getParam('title')):$title="");
	@(($params->getParam('query')!='')?$query=$params->getParam('query'):$query="");
	@(($params->getParam('array')!='')?$arrayString=$params->getParam('array'):$arrayString="");
	@(($params->getParam('legPercent')=="FALSE")?$legPercent=FALSE:$legPercent=TRUE);
	@(($params->getParam('legend')!='')?$legendString=$params->getParam('legend'):$legendString="");

	$graph = new phplot_Stats(500,480,$title,$style);
	
	if($query!=''){
		$result=mysql_query($query) or die(mysql_error());
		$graph->setDataFromQuery($result); 
		$graph->setBgColor($bgcolor);

		$graph->printGraph($legPercent);
		exit;
	}else if($arrayString!=NULL){
		$array=$params->string2array($arrayString);
		if($legendString!=""){
			$legend = $params->string2array($legendString);
			$graph->setLegend($legend);
		}
	
		$graph->setDataFromArray($array);
		$graph->setBgColor($bgcolor);

		$graph->printGraph($legPercent);
	}else
		exit;
?>
