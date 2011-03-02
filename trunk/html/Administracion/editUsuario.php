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
include ('_editUsuario.php');
	$var = new EditUsuario($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Usuario")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php
?>
	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table>
			<tr>
				<td class="ListaTitulo">
					<?php echo  _translate("Datos del usuario")?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo  $var->Usuario->get_Id();?>
				</td>
				<td>
					<?php echo  $var->Usuario->get_Nombre();?>
				</td>
				<td>
					<?php echo  $var->Usuario->get_Apellidos();?>
				</td>
				<td>
					<?php echo  $var->Usuario->get_Email();?>
				</td>
				<td>
					<?php $perfil = $var->Usuario->get_Perfil(); echo $perfil['nombre'];?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="ListaTitulo">
					<?php echo  _translate("Objetivos mensuales")?>
				</td>
			</tr>
			<tr>
				<?php foreach($var->datos['lista_meses'] as $obj_mes){?>
				<td class="ColIzq">
					<?php echo $obj_mes['mes'];?>
				</td>
				<td class="ColDer">
					<input type="text" name="objetivo_<?php echo $obj_mes['id']?>" value="<?php echo $var->opt['objetivo_'.$obj_mes['id']]; ?>"  />
				</td>
				<?php }?>
			</tr>
		</table>
		<table>
			<tr>
				<td class="ListaTitulo">
					<?php echo  _translate("Penalizaciones")?>
				</td>
			</tr>
			<tr>
				<?php foreach($var->datos['lista_penalizaciones'] as $penalizacion){?>
				<td class="ColIzq">
					<?php echo $penalizacion['nombre'];?>
				</td>
				<td class="ColDer">
					<input type="text" name="penalizacion_<?php echo $penalizacion['id']?>" value="<?php echo $var->opt['penalizacion_'.$penalizacion['id']]; ?>"  />
				</td>
				<?php }?>
			</tr>
		</table>
		<table>
			<tr>
				<td class="ListaTitulo">
					<?php echo  _translate("Comisiones por tipo de venta")?>
				</td>
			</tr>
			<tr>
				<?php foreach($var->datos['lista_tipos_comision'] as $tipo_comision){?>
				<td class="ColIzq">
					<?php echo $tipo_comision['nombre'];?>
				</td>
				<td class="ColDer">
					<input type="text" name="comision_<?php echo $tipo_comision['id']?>" value="<?php echo $var->opt['comision_'.$tipo_comision['id']]; ?>"  />
				</td>
				<?php }?>
			</tr>
		</table>
		
		<!-- Parámetros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Usuario->get_Id()?>" />

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
</script>
<?php include($appRoot.'/include/html/footer.php')?>
