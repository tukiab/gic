<?php 
/**
 * @ignore
 * @package default
 */

include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_editProveedor.php');
	$var = new EditProveedor($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Proveedor")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php if($permisos->administracion){?>
	<form action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr class="ListaTitulo">
			  <td class="ColIzq"><?php echo  _translate("Raz&oacute;n Social")?>:</td>
			  <td class="ColDer">
				<input type="text" name="razon_social" value="<?php echo  $var->Proveedor->get_Razon_Social();?>" size="25" />
			  </td>
			</tr>
			<tr class="ListaTitulo">
				
			<!-- <tr class="ListaTitulo">
				<td class="ColIzq"><?php //echo  _translate("CIF/NIF")?>:</td>
				<td class="ColDer">
					<input type="text" name="NIF" value="<?php //echo  trim(stripslashes($var->Proveedor->get_NIF()))?>" size="25" />
				</td>
			</tr>
			 -->
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<input type="text" name="domicilio" value="<?php echo  trim(stripslashes($var->Proveedor->get_Domicilio()))?>" size="25" />
				</td>				
			</tr>
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<input type="text" name="localidad" value="<?php echo  trim(stripslashes($var->Proveedor->get_Localidad()))?>" size="25" />
				</td>				
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<input type="text" name="web" value="<?php echo  trim($var->Proveedor->get_Web())?>" size="25" />
				</td>
			</tr>
			
		</table>
			<br />
		<!-- Parámetros ocultos -->
		<input type="hidden" name="NIF" value="<?php echo  $var->Proveedor->get_NIF()?>" />
		<input type="hidden" name="edit" value="proveedor" />
		
		<div  class="bottomMenu">
			<table>
				<tr>
					<td style="text-align:right;" >
						<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
					</td>
					<td style="text-align:right;">
						<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
					</td>
				</tr>
			</table>
		</div>
	</form>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<script language="JavaScript" type="text/javascript">
	<!--
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}
	-->
</script>
<?php include($appRoot.'/include/html/footer.php')?>
