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
include ('_gestionGrupos.php');
	$var = new GestionGrupos($_POST);

include ($appRoot.'/include/html/header.php'); 
include ($appRoot.'/include/html/mainMenu.php');

?>
<div id="titulo"><?php echo  _translate("Gestores")?></div>
		<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\" >".$var->opt['msg']."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
<div align="center">
<form id="frmGrupos" action="<?php echo  $_SERVER['_SELF']?>" method="POST">
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
		<!-- Datos de todos los grupos -->
		<?php 
		foreach($var->datos['lista_grupos'] as $Grupo){
			
		?>
		<tr class="ListaTitulo" align="center">
			<td align="center">
				<input type="text" name="nombre_<?php echo $Grupo->get_Id() ?>" value="<?php echo  $Grupo->get_Nombre();?>" size="15" />
			</td>
			<?php if($gestor_actual->esAdministradorTotal()){ ?><td align="center">
				<a href="#" onclick="eliminar('<?php echo $Grupo->get_Id();?>')"><input class="borrar" type="button" value="<?php echo _translate("Eliminar")?>"/></a>
			</td>
			<td align="center">
				<a href="#" name="guardagrupo" onclick="guardar('<?php echo $Grupo->get_Id();?>')"><input type="button" value="<?php echo _translate("Guardar")?>"/></a>
				
			</td> <?php }?>
		</tr>
		<?php }?>
		<tr>
			<td colspan="3" style="text-align: right;">
				<a href="<?php echo $appDir.'/Clientes/addCliente.php';?>"><input type=button value="<?php echo _translate('Ir a crear cliente');?>" /></a>
			</td>
		</tr>
		</table>
			<br />

<!-- Parámetros ocultos -->
<input type="hidden" id="id_grupo" name="id_grupo" value="" />
<input type="hidden" id="eliminar" name="eliminar" value="" />
<input type="hidden" id="guardar" name="guardar" value="" />
</form>
</div>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<script language="JavaScript" type="text/javascript">
	<!--
	function eliminar(id_grupo){
		if(confirm('Confirmar borrado')){
			$('#id_grupo').val(id_grupo);
			$('#eliminar').val(1);
			$('#frmGrupos').submit();
		}
	}
	function guardar(id_grupo){
		$('#id_grupo').val(id_grupo);
		$('#guardar').val(1);
		$('#frmGrupos').submit();
	}

	-->
</script>
<?php include($appRoot.'/include/html/footer.php');?>
