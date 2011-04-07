<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_miEmpresa.php');
	$var = new MiEmpresa($_GET);

	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');

?>
<script language="JavaScript" type="text/javascript">

$(document).ready(function()
{
});
</script>

<?php 
if($var->opt['msg']){?>
	<div id="error_msg" ><?php echo$var->opt['msg']?>	
	</div>
<?php }?>
<div id="titulo">Mi empresa</div>
<?php if($permisos->escritura){?>
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div id="contenedor" align="center">
<?php
if($var->Cliente && $var->Cliente->get_Razon_Social() && !$var->opt['editar']){
$razon_social = $var->Cliente->get_Razon_Social();?>

	<!-- **************** DATOS DEL CLIENTE **************** -->	
		<table>
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos b&aacute;sicos de la empresa")?><a class="show" href="#" clase="datos"></a></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Id empresa")?>:</td>
				<td class="ColDer"><?php echo  ($var->Cliente->get_Id());?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Raz&oacute;n social")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_Razon_Social()?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Tel&eacute;fono")?>:</td>
				<td class="ColDer">
					<?php echo impArrayTelefono($var->Cliente->get_Telefono());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("FAX")?>:</td>
				<td class="ColDer">
					<?php echo impArrayTelefono($var->Cliente->get_FAX());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("CIF")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_NIF();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_Domicilio();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_Localidad();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_Provincia();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("C&oacute;digo Postal")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_CP();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de empleados")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Cliente->get_Numero_Empleados();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<?php  echo web($var->Cliente->get_Web());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Sector")?>:</td>
				<td class="ColDer">
					<?php  echo $var->Cliente->get_Sector()?>
				</td>
			</tr>						
		</table>
	
		<input type="submit" value="Editar" name="editar" />
	
	<?php
}else{?>
	<table>
		<tr>
			<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos b&aacute;sicos de la Empresa")?></td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Raz&oacute;n social")?>&#42;</td>
			<td class="ColDer">
				<input type="text" name="razon_social" value="<?php echo  $var->opt['razon_social'];?>" />
			</td>
		</tr>

		<tr>
			<td  class="ColIzq"><?php echo  _translate("Tel&eacute;fono")?>&#42;</td>
			<td  class="ColDer">
				<input type="text"  name="telefono" value="<?php echo  $var->opt['telefono'];?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("FAX")?></td>
			<td  class="ColDer">
				<input  type="text"  name="FAX" value="<?php echo  $var->opt['FAX'];?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("CIF")?></td>
			<td  class="ColDer">
				<input type="text" name="NIF" value="<?php echo  $var->opt['NIF'];?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Domicilio")?></td>
			<td  class="ColDer">
				<input type="text"  name="domicilio" value="<?php echo  trim(stripslashes($var->opt['domicilio']));?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Localidad")?>&#42;</td>
			<td  class="ColDer">
				<input type="text"  name="localidad" value="<?php echo  trim(stripslashes($var->opt['localidad']));?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Provincia")?>&#42;</td>
			<td  class="ColDer">
				<input type="text"  name="provincia" value="<?php echo  trim(stripslashes($var->opt['provincia']));?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("CP")?>&#42;</td>
			<td  class="ColDer">
				<input type="text"  name="CP" value="<?php echo  $var->opt['CP'];?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("N&uacute;mero de empleados")?></td>
			<td class="ColDer" >
				<input type="text" name="numero_empleados" value="<?php echo  $var->opt['numero_empleados'];?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Web")?></td>
			<td  class="ColDer">
				<input type="text"  name="web" value="<?php echo  trim(stripslashes($var->opt['web']));?>" />
			</td>
		</tr>
		<tr>
			<td  class="ColIzq"><?php echo  _translate("Sector")?>&#42;</td>
			<td  class="ColDer">
				<input type="text"  name="sector" value="<?php echo  trim(stripslashes($var->opt['sector']));?>" />
			</td>
		</tr>
		<tr class="botones">
			<td colspan="2">
				<input type="submit" value="Guardar" name="guardar" />
			</td>
		</tr>
		
	</table>
	<?php }?>
</div>
</form>

<?php include($appRoot.'/include/html/footer.php')?>
<?php }else{
	echo _translate("No tiene permisos suficientes");
}?>