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
include ('_gestionUsuarios.php');
	$var = new GestionUsuarios($_POST);
	
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>
<div id="titulo"><?php echo  _translate("Gestores");?></div>
		<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\" >".$var->opt['msg']."</div>":null;?>
<br />
<?php //if($permisos->escritura){?>
<div align="center">
<form id="frmUsuarios" action="<?php echo  $_SERVER['_SELF'];?>" method="POST">
	<table style="border:none;">
		<tr class="ListaTitulo">
			<td><?php echo  _translate("Id");?></td>
			<td><?php echo  _translate("Nombre");?></td>
			<td><?php echo  _translate("Apellidos");?></td>
			<td><?php echo  _translate("Password");?></td>
            <td><?php echo  _translate("Email");?></td>
			<td><?php echo  _translate("Perfil");?></td>
			<td colspan="2"><?php echo _translate("Operaciones");?></td>

		</tr>
		<!-- Datos para crear uno nuevo -->
		<tr class="ListaTitulo" align="center">
			<td align="center">
				<input type="text" name="id_usuario" value="<?php if(!$var->opt['guardado']) echo $var->opt['id'];?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="nombre" value="<?php if(!$var->opt['guardado']) echo  $var->opt['nombre'];?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="apellidos" value="<?php if(!$var->opt['guardado']) echo  $var->opt['apellidos'];?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="password" value="<?php if(!$var->opt['guardado']) echo  $var->opt['password'];?>" size="15" />
			</td>
            <td align="center">
				<input type="text" name="email" value="<?php if(!$var->opt['guardado']) echo  $var->opt['email'];?>" size="15" />
			</td>
			<td align="center">
				<select name="perfil">
				<?php foreach($var->datos['lista_perfiles'] as $perfil){ 
					
				?>
					<option value="<?php echo $perfil['id'];?>" <?php if($var->opt['perfil'] == $perfil['id'] && !$var->opt['guardado'])  echo 'selected="selected"';?>><?php  echo $perfil['nombre'];?></option>
				<?php }?>
				</select>
			</td>
			<td colspan="2" align="center">
				<input type="submit" name="crear" value="<?php echo  _translate("Crear");?>" />
			</td>
		</tr>
		<!-- Datos de todos los usuarios -->
		<?php 
		foreach($var->datos['lista_usuarios'] as $Usuario){
		?>
		<tr class="ListaTitulo" align="center">
			<td align="center">
				<input type="hidden" readonly="readonly" name="id_<?php echo $Usuario->get_Id() ;?>" value="<?php echo  $Usuario->get_Id();?>" size="15" />
				<?php $url_dest = $appDir."/Administracion/editUsuario.php?id=".$Usuario->get_Id();?>
				<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=800,height=600,scrollbars=yes');"><?php echo $Usuario->get_Id() ;?></a>
			</td>
			<td align="center">
				<input type="text" name="nombre_<?php echo $Usuario->get_Id() ;?>" value="<?php echo  $Usuario->get_Nombre();?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="apellidos_<?php echo $Usuario->get_Id() ;?>" value="<?php echo  $Usuario->get_Apellidos();?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="password_<?php echo $Usuario->get_Id() ;?>" value="<?php echo  $Usuario->get_Password();?>" size="15" />
			</td>
			<td align="center">
				<input type="text" name="email_<?php echo $Usuario->get_Id() ;?>" value="<?php echo  $Usuario->get_Email();?>" size="15" />
			</td>
			<td align="center">
				<select name="perfil_<?php echo $Usuario->get_Id() ;?>">
				<?php foreach($var->datos['lista_perfiles'] as $perfil){ 
					$perfil_usuario = $Usuario->get_Perfil();
				?>
					<option value="<?php echo $perfil['id'];?>" <?php if($perfil['id'] == $perfil_usuario['id']) echo  "selected:\"selected\"";?>><?php  echo $perfil['nombre'];?></option>
				<?php }?>
				</select>
			</td>
			<!--<td align="center">
				<a href="#" onclick="eliminar('<?php echo $Usuario->get_Id();?>')"><input class="borrar" type="button" value="<?php echo _translate("Eliminar");?>" /></a>
			</td>-->
			<td align="center">
				<a href="#" onclick="guardar('<?php echo $Usuario->get_Id();?>')" ><input type="button" value="<?php echo _translate("Guardar");?>" /></a>
			</td>
		</tr>
		<?php  }?>
		<tr style="font-weight: bold;text-align: left;background: #fff;">
			<td colspan="7" style="border: 1px solid #ccc;padding: 5px 5px 5px 20px;">&uarr; Acceda al usuario para editar las comisiones</td></tr>
		</table>
			<br />

<!-- Parámetros ocultos -->
<input type="hidden" id="id_usuario_accion" name="id_usuario_accion" value="" />
<input type="hidden" id="eliminar" name="eliminar" value="" />
<input type="hidden" id="guardar" name="guardar" value="" />
</form>
</div>
<?php /*}else{
echo  _translate("No tiene permisos suficientes");
}*/?>
<script language="JavaScript" type="text/javascript">
	<!--
	function eliminar(id_usuario){
		if(confirm('confirmar borrado')){
			$('#id_usuario_accion').val(id_usuario);
			$('#eliminar').val(1);
			$('#frmUsuarios').submit();
		}
	};
	function guardar(id_usuario){
		$('#id_usuario_accion').val(id_usuario);
		$('#guardar').val(1);
		$('#frmUsuarios').submit();
	};

	-->
</script>
<?php include($appRoot.'/include/html/footer.php');?>