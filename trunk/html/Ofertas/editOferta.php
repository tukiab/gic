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
include ('_editOferta.php');
	$var = new EditOferta($_GET);

include ($appRoot.'/Common/php/popupHeader.php');
?>
<div id="titulo"><?php echo  _translate("Editar Oferta")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr class="ListaTitulo">
			  <td class="ColIzq"><?php echo  _translate("Nombre")?>:</td>
			  <td class="ColDer">
				<input <?php echo $disabled['nombre']; ?> type="text" name="nombre" value="<?php echo  $var->Oferta->get_Nombre_Oferta();?>" size="25" />
			  </td>
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Estado")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['estado']; ?> style="width:190px" name="estado_oferta">
						<?php $estado_seleccionado = $var->Oferta->get_Estado_Oferta();?>
						<?php foreach($var->datos['lista_estados_ofertas'] as $estado){?>
							<option value="<?php echo  $estado['id']?>" <?php echo  ($estado_seleccionado['id']==$estado['id'])?'selected="selected"':null;?>>
								<?php echo  $estado['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Tipo de producto")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['producto']; ?> style="width:190px" name="producto">
						<?php $producto_seleccionado = $var->Oferta->get_Producto();?>
						<?php foreach($var->datos['lista_tipos_productos'] as $producto){?>
							<option value="<?php echo  $producto['id']?>" <?php echo  ($producto_seleccionado['id']==$producto['id'])?'selected="selected"':null;?>>
								<?php echo  $producto['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Proveedor")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['proveedor']; ?> style="width:190px" name="proveedor">
						<?php $proveedor_seleccionado = $var->Oferta->get_Proveedor();?>
						<?php foreach($var->datos['lista_proveedores'] as $proveedor){?>
							<option value="<?php echo  $proveedor['id']?>" <?php echo  ($proveedor_seleccionado['id']==$proveedor['id'])?'selected="selected"':null;?>>
								<?php echo  $proveedor['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Fecha")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['fecha']; ?> type="text" class="fecha" name="fecha" value="<?php  echo timestamp2date($var->Oferta->get_Fecha())?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Importe")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['Importe']; ?> type="text" name="importe" value="<?php echo  trim(stripslashes($var->Oferta->get_Importe()))?>" size="25" />&nbsp;&euro;
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Fecha de definici&oacute;n")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['fecha_definicion']; ?> type="text" class="fecha" name="fecha_definicion" value="<?php  echo timestamp2date($var->Oferta->get_Fecha_Definicion())?>" size="25" />
				</td>
			</tr>
			
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Probabilidad de contrataci&oacute;n")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['probabilidad_contratacion']; ?> style="width:190px" name="probabilidad_contratacion">
						<?php $probabilidad_contratacion_seleccionado = $var->Oferta->get_Probabilidad_Contratacion();?>
						<?php foreach($var->datos['lista_probabilidades'] as $probabilidad_contratacion){?>
							<option value="<?php echo  $probabilidad_contratacion['id']?>" <?php echo  ($probabilidad_contratacion_seleccionado['id']==$probabilidad_contratacion['id'])?'selected="selected"':null;?>>
								<?php echo  $probabilidad_contratacion['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td class="ColIzq"><?php echo  _translate("Colaborador")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['colaborador']; ?> style="width:190px" name="colaborador">
						<?php $colaborador_seleccionado = $var->Oferta->get_Colaborador();?>
						<?php foreach($var->datos['lista_colaboradores'] as $colaborador){?>
							<option value="<?php echo  $colaborador['id']?>" <?php echo  ($colaborador_seleccionado['id']==$proveedor['id'])?'selected="selected"':null;?>>
								<?php echo  $colaborador['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			
		</table>
			<br />
		<!-- Parámetros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Oferta->get_Id()?>" />
		<input type="hidden" name="edit" value="oferta" />
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
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php include($appRoot.'/Common/php/footer.php')?>