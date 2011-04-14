<?php
/**
 * @ignore
 * @package default
 */

include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_rel_Sedes_Contactos.php');
	$var = new RelSedesContactos($_GET);

include ($appRoot.'/Common/php/popupHeader.php');

?>
<script type="text/javascript">
$(document).ready(function(){
	$('.checkall')
});
</script>
<div id="titulo"><?php echo  _translate("Editar contactos de la sede")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
<div id="contenedor" style="margin-top: 100px;" align="center">

<form action="<?php echo  $_SERVER['_SELF']?>" method="GET">
	<input type=hidden name="id" value="<?php echo $var->Sede->get_Id();?>"/>
	<table>
		<tr>
			<td class="ListaTitulo" colspan="5"><?php echo  _translate("Contactos")?></td>
		</tr>
		<tr>
			<td><input type="checkbox" id="chk_todos" /></td>
			<td><?php echo  _translate("Nombre")?></td>
			<td><?php echo  _translate("Tel&eacute;fono")?></td>
			<td><?php echo  _translate("Cargo")?></td>
			<td><?php echo  _translate("Email")?></td>
			<td></td>
		</tr>
			<?php
			FB::info($var->Cliente->get_Lista_Contactos());
			foreach($var->Cliente->get_Lista_Contactos() as $Contacto){
			?>
				<tr class="ListaTitulo" align="center">
					<td>
						<input type="checkbox" name="ids_contactos[]" class="chk" value="<?php echo $Contacto->get_Id();?>" <?php if($var->Sede->tiene_Contacto($Contacto->get_Id())) echo 'checked="checked"';?> />
					</td>
					<td align="center">
						<?php echo  $Contacto->get_Nombre();?>
					</td>
					<td align="center" nowrap>
						<?php echo  $Contacto->get_Telefono();?>
					</td>
					<td align="center">
						<?php echo  $Contacto->get_Cargo();?>
					</td>
					<td align="center">
						<?php echo  $Contacto->get_Email();?>
					</td>					
				</tr>
			<?php }?>
		</table>
<div  class="bottomMenu">
	<table>
		<tr>
			<td width="40%"></td>
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
</div>
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
<?php include($appRoot.'/Common/php/footer.php')?>