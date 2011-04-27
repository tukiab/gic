<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_addProyecto.php');
	$var = new AddProyecto ($_GET);
		
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
	
	?>
<div id="titulo"><?php echo  _translate("Registrar Proyecto")?></div>
<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<?php if($permisos->administracion){?>

<div id="contenedor" align="center">	
	<form method="GET" target="" action="">
	<table>
			<tr>
				<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos del proyecto")?></td>
			</tr>
			<tr>
				<td  class="busquedaIzda"><?php echo  _translate("Nombre")?>&#42;</td>
				<td class="busquedaDcha">
					<input type="text" name="nombre" value="<?php echo  $var->opt['nombre'];?>" />
				</td>
			</tr>
			<tr>
				<td  class="busquedaIzda"><?php echo  _translate("Fecha de inicio")?></td>
				<td  class="busquedaDcha">
					<input type="text" class="fecha" name="fecha_inicio" value="<?php echo  timestamp2date($var->opt['fecha_inicio']);?>" />
				</td>
			</tr>
			<tr>
				<td  class="busquedaIzda"><?php echo  _translate("Fecha de finalizaci&oacute;n")?></td>
				<td  class="busquedaDcha">
					<input type="text" class="fecha" name="fecha_fin" value="<?php echo  timestamp2date($var->opt['fecha_fin']);?>" />
				</td>
			</tr>
			<tr>
				<td  class="busquedaIzda"><?php echo  _translate("Asignar a t&eacute;cnico");?></td>
				<td class="busquedaDcha" >
					<select  name="id_usuario">
						<?php $usuario_sel = $var->opt['id_usuario'];?>
						<option value="" ><?php echo _translate("No asignar");?></option>
						<?php while($user=$var->datos['lista_tecnicos']->siguiente()){?>
						<option value="<?php  echo $user->get_Id()?>" <?php if($user->get_Id() == $usuario_sel) echo 'selected="selected"';?>><?php  echo $user->get_Id()?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr class="botones">
				<td colspan="2">
					<input type="submit" value="Guardar" name="guardar" />
				</td>
			</tr>
		</table>
		<input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $var->opt['id_cliente'];?>" />
	</form>
</div>
	<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
	<?php 
		include($appRoot.'/Common/php/bottomMenu.php');
		include($appRoot.'/Common/php/footer.php');
	?>