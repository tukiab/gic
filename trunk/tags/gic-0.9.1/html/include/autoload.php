<?php include_once ('../appRoot.php');
function __autoload($class_name) {
	
	global $classRoot, $wsRoot;
	
	//Core
	$path = $classRoot;
	$dir = opendir($path);
	while ($root_name = @readdir($dir)){
		if(file_exists($classRoot.'/'.$root_name.'/'.$class_name.'.php'))
    		require_once $classRoot.'/'.$root_name.'/'.$class_name.'.php';
	} 
	
	//Web Services
    if(file_exists($wsRoot.'/datos/'.$class_name.'.php'))
    	 require_once $wsRoot.'/datos/'.$class_name.'.php';
    else if(file_exists($wsRoot.'/servicios/'.$class_name.'.php'))
    	 require_once $wsRoot.'/servicios/'.$class_name.'.php';
	
    //DEBUG:
    if($class_name == 'FB' && file_exists($classRoot.'/Common/FirePHPCore-0.3.1/lib/FirePHPCore/fb.php')){
    	require_once $classRoot.'/Common/FirePHPCore-0.3.1/lib/FirePHPCore/fb.php';
    }
}
?>