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
include ('_editFactura.php');
	$var = new EditFactura($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Factura")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php 
?>
	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr class="ListaTitulo">
			  <td><?php echo  _translate("Numero")?>:</td>
			  <td class="impar">
				<?php echo  $var->Factura->get_Numero_Factura();?>
			  </td>
			</tr>			
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Estado")?>:</td>
				<td class="impar">
					<select  style="width:190px" name="estado_factura">
						<?php $estado_seleccionado = $var->Factura->get_Estado_Factura();?>
						<?php foreach($var->datos['lista_estados'] as $estado){?>
							<option value="<?php echo  $estado['id']?>" <?php echo  ($estado_seleccionado['id']==$estado['id'])?'selected':null;?>>
								<?php echo  $estado['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>				
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Fecha de pago")?>:</td>
				<td class="impar">
					<input type="text" class="fecha" name="fecha_pago" value="<?php  echo timestamp2date($var->Factura->get_Fecha_Pago())?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Fecha de facturacion")?>:</td>
				<td class="impar">
					<input type="text" class="fecha" name="fecha_facturacion" value="<?php  echo timestamp2date($var->Factura->get_Fecha_Facturacion())?>" size="25" />
				</td>
			</tr>			
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Base imponible")?>:</td>
				<td class="impar">
					<input type="text" name="base_imponible" value="<?php echo  trim(stripslashes($var->Factura->get_Base_Imponible()))?>" size="25" />&nbsp;&euro;
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("IVA")?>:</td>
				<td class="impar">
					<input type="text" name="IVA" value="<?php echo  trim(stripslashes($var->Factura->get_IVA()))?>" size="25" />&nbsp;&euro;
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Cantidad pagada")?>:</td>
				<td class="impar">
					<input type="text" name="cantidad_pagada" value="<?php echo  trim(stripslashes($var->Factura->get_Cantidad_Pagada()))?>" size="25" />&nbsp;&euro;
				</td>
			</tr>
		</table>
			<br />
		<!-- Parámetros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Factura->get_Id()?>" />
		<input type="hidden" name="edit" value="factura" />
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

</script>
<?php include($appRoot.'/include/html/footer.php')?>
