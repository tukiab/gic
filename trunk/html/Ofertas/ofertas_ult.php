<?php
include ('../appRoot.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_ofertas_ult.php');
	$var = new OfertasUlt($_GET, $_POST);
?>
<form id="frm" action="<?php echo  $_SERVER['PHP_SELF'];?>" method="POST">
<div id="contenedor">
	<table class="ConDatos">
		<tr>
			<td class="ColIzq" >dt</td>
			<td class="ColDer"><input type="text" class="fecha" value="<?php echo Fechas::timestamp2date($var->dt);?>" /></td>
		</tr>
		<tr>
			<td class="ColIzq" >st</td>
			<td class="ColDer">
				<input type="checkbox" <?php if($var->st) echo 'checked="checked"';?> />
			</td>
		</tr>
		<tr>
			<td class="ColIzq" >ps</td>
			<td class="ColDer">
				<input type="password" />
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="ea" name="ea" /><</td>
		</tr>
	</table>
</div>
</form>