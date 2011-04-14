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
include ('_gestionTiposFormasDePago.php');
	$var = new GestionTiposFormasDePago($_POST);

include ($appRoot.'/Common/php/header.php');
if(!$_GET['id_cliente'])
include ($appRoot.'/Common/php/menu.php');

?>
<div id="titulo"><?php echo  _translate("Tipos de forma de pago")?></div>
		<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\" >".$var->opt['msg']."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
<div align="center">
<form id="frmTipos" action="<?php echo  $_SERVER['_SELF']?>" method="POST">
	<table>
		<tr class="ListaTitulo">

			<td><?php echo  _translate("Nombre")?></td>
			<td colspan="2"><?php echo _translate("Operaciones")?></td>

		</tr>
		<!-- Datos para crear uno nuevo -->
		<tr class="ListaTitulo" align="center">

			<td align="center">
				<input type="text" name="nombre" value="<?php echo  $var->opt['nombre'];?>" size="15" />
			</td>

			<td colspan="2" align="center">
				<input type="submit" name="crear" value="<?php echo  _translate("Crear")?>" />
			</td>

		</tr>
		<!-- Datos de todos los tipos de forma de pago -->
		<?php
		foreach($var->datos['lista_tipos_de_formas_de_pago'] as $TipoProducto){

		?>
		<tr class="ListaTitulo" align="center">
			<td align="center">
				<input type="text" name="nombre_<?php echo $TipoProducto->get_Id() ?>" value="<?php echo  $TipoProducto->get_Nombre();?>" size="15" />
			</td>
			<?php if($permisos->administracion){ ?><td align="center">
				<a href="#" onclick="eliminar('<?php echo $TipoProducto->get_Id();?>')"><input class="borrar" type="button" value="<?php echo _translate("Eliminar")?>"/></a>
			</td>
			<td align="center">
				<a href="#" name="guardatipoformadepago" onclick="guardar('<?php echo $TipoProducto->get_Id();?>')"><input type="button" value="<?php echo _translate("Guardar")?>"/></a>

			</td> <?php }?>
		</tr>
		<?php }?>
		<tr>
			<td colspan="3" style="text-align: right;">
				<?php if($_GET['id_oferta']) {?>
					<a href="<?php echo $appDir.'/Ventas/addVenta.php?id_oferta='.$_GET['id_oferta'];?>"><input type=button value="<?php echo _translate('Ir a Venta');?>" /></a>
				<?php } else {?>
					<!--<a href="<?php echo $appDir.'/Clientes/addcliente.php';?>"><input type=button value="<?php echo _translate('Ir a crear cliente');?>" /></a>-->
				<?php }?>

			</td>
		</tr>
		</table>
			<br />

<!-- Parámetros ocultos -->
<input type="hidden" id="id_tipoformadepago" name="id_tipoformadepago" value="" />
<input type="hidden" id="eliminar" name="eliminar" value="" />
<input type="hidden" id="guardar" name="guardar" value="" />
</form>
</div>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<script language="JavaScript" type="text/javascript">
	<!--
	function eliminar(id_tipoformadepago){
		if(confirm('confirmar borrado')){
			$('#id_tipoformadepago').val(id_tipoformadepago);
			$('#eliminar').val(1);
			$('#frmTipos').submit();
		}
	}
	function guardar(id_tipoformadepago){
		$('#id_tipoformadepago').val(id_tipoformadepago);
		$('#guardar').val(1);
		$('#frmTipos').submit();
	}

	-->
</script>
<?php include($appRoot.'/Common/php/footer.php');?>
