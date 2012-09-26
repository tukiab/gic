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
include ('_editProyecto.php');
	$var = new EditProyecto($_GET);

include ($appRoot.'/Common/php/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Proyecto")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php if($permisos->escritura){
	$disabled = 'readonly="readonly"';
	?>


	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr class="ListaTitulo">
			  <td class="ColIzq"><?php echo  _translate("Nombre")?>:</td>
			  <td class="ColDer">
				<input <?php if(!$permisos->administracion)echo $disabled; ?> type="text" name="nombre" value="<?php echo  $var->Proyecto->get_Nombre();?>" size="25" />
			  </td>
			</tr>			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Fecha inicio")?>:</td>
				<td class="ColDer">
					<input <?php if(!$permisos->administracion)echo $disabled; ?> type="text" <?php if($permisos->administracion){?>class="fecha"<?php }?> name="fecha_inicio" value="<?php  echo timestamp2date($var->Proyecto->get_Fecha_Inicio())?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Fecha finalizaci&oacute;n")?>:</td>
				<td class="ColDer">
					<input <?php if(!$permisos->administracion)echo $disabled; ?> type="text" <?php if($permisos->administracion){?>class="fecha"<?php }?> name="fecha_fin" value="<?php  echo timestamp2date($var->Proyecto->get_Fecha_Fin())?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
			  <td class="ColIzq"><?php echo  _translate("Observaciones")?>:</td>
			  <td class="ColDer">
				  <textarea  name="observaciones"><?php echo  $var->Proyecto->get_Observaciones();?></textarea>
			  </td>
			</tr>
		</table>
			<br />
		<!-- Parámetros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Proyecto->get_Id()?>" />
		<input type="hidden" name="edit" value="proyecto" />
		<input type="hidden" id="guardar" name="guardar" value="" />
		
		<div  class="bottomMenu">
			<table>
				<tr>
					<td width="40%"></td>
					<td style="text-align:right;" >
						<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
					</td>
					<td style="text-align:right;">
						<input type="button" onclick="$('select').removeAttr('disabled');
							$('#guardar').val('guardar');
						$('#frm').submit();"  value="<?php echo  _translate("Guardar")?>" />
					</td>
				</tr>
			</table>
		</div>
	</form>
<?php //}?>
<script language="JavaScript" type="text/javascript">

	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	};
	function guardar(){
		
	};

</script><?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php include($appRoot.'/Common/php/footer.php')?>