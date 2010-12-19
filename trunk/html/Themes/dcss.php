<?php
header('content-type:text/css');
$arch_css=$_GET['c'];

$css=load($arch_css);

preg_match_all("/\\$(\w+).*=.*\'(.*)\'/",$css,$constants);
for($i=0;$i<sizeof($constants[1]);$i++){
	$css=preg_replace('/\\$'.$constants[1][$i].'/',$constants[2][$i],$css);
}
$css=preg_replace("/\\#.*=.*?;\s+/s",'',$css);
//TODO: Quitar también los comentarios...

echo  $css;

function load($filelocation){
	
	if (file_exists($filelocation)){
		$newfile = fopen($filelocation,"r");
		$file_content = fread($newfile, filesize($filelocation));
		fclose($newfile);
		return $file_content;
	}
}
?>
