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
include ('_gestionTiposProducto.php');
	$var = new GestionTiposProducto($_POST);

include ($appRoot.'/include/html/header.php'); 
if(!$_GET['id_cliente'])
include ($appRoot.'/include/html/mainMenu.php');

?>
<div id="titulo"><?php echo  _translate("Tipos de producto")?></div>
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
		<!-- Datos de todos los tipos de producto -->
		<?php 
		foreach($var->datos['lista_tipos_de_productos'] as $TipoProducto){
			
		?>
		<tr class="ListaTitulo" align="center">
			<td align="center">
				<input type="text" name="nombre_<?php echo $TipoProducto->get_Id() ?>" value="<?php echo  $TipoProducto->get_Nombre();?>" size="15" />
			</td>
			<?php if($gestor_actual->esAdministradorTotal()){ ?><td align="center">
				<a href="#" onclick="eliminar('<?php echo $TipoProducto->get_Id();?>')"><input class="borrar" type="button" value="<?php echo _translate("Eliminar")?>"/></a>
			</td>
			<td align="center">
				<a href="#" name="guardatipoproducto" onclick="guardar('<?php echo $TipoProducto->get_Id();?>')"><input type="button" value="<?php echo _translate("Guardar")?>"/></a>
				
			</td> <?php }?>
		</tr>
		<?php }?>
		<tr>
			<td colspan="3" style="text-align: right;">
				<?php if($_GET['id_cliente']) {?>
					<a href="<?php echo $appDir.'/Ofertas/addOferta.php?id_cliente='.$_GET['id_cliente'];?>"><input type=button value="<?php echo _translate('Ir a crear Oferta/ON');?>" /></a>
				<?php } else {?>
					<a href="<?php echo $appDir.'/Clientes/addcliente.php';?>"><input type=button value="<?php echo _translate('Ir a crear cliente');?>" /></a>
				<?php }?>
				
			</td>
		</tr>
		</table>
			<br />

<!-- Parámetros ocultos -->
<input type="hidden" id="id_tipoproducto" name="id_tipoproducto" value="" />
<input type="hidden" id="eliminar" name="eliminar" value="" />
<input type="hidden" id="guardar" name="guardar" value="" />
</form>
</div>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<script language="JavaScript" type="text/javascript">
	<!--
	function eliminar(id_tipoproducto){
		if(confirm('confirmar borrado')){
			$('#id_tipoproducto').val(id_tipoproducto);
			$('#eliminar').val(1);
			$('#frmTipos').submit();
		}
	}
	function guardar(id_tipoproducto){
		$('#id_tipoproducto').val(id_tipoproducto);
		$('#guardar').val(1);
		$('#frmTipos').submit();
	}

	-->
</script>
<?php include($appRoot.'/include/html/footer.php');?>
