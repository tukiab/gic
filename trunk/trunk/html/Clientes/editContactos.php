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
include ('_editCliente.php');
	$var = new EditCliente($_GET);

include ($appRoot.'/Common/php/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Contactos")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
<div>

<form action="<?php echo  $_SERVER['_SELF']?>" method="GET">
	<table>
		<tr class="ListaTitulo">
			<td><?php echo  _translate("Nombre")?></td>
			<td><?php echo  _translate("Tel&eacute;fono")?></td>
			<td><?php echo  _translate("Cargo")?></td>
			<td><?php echo  _translate("Email")?></td>
			<td></td>
		</tr>
			<?php 
			$count = 0;
			foreach($var->datos['lista_contactos'] as $Contacto){				
			?>
			<?php $disabled = $Contacto->get_DisableEdit();?>
				<tr class="ListaTitulo" >
					<td >
						<input <?php echo $disabled['nombre']; ?> type="text" name="<?php echo  $count."_"?>nombre" value="<?php echo  $Contacto->get_Nombre();?>" size="9" />
					</td>
					<td  nowrap>
						<input <?php echo $disabled['telefono']; ?> type="text" name="<?php echo  $count."_"?>telefono" value="<?php echo  $Contacto->get_Telefono();?>" size="9" />
					</td>
					<td >
						<input <?php echo $disabled['cargo']; ?> type="text" name="<?php echo  $count."_"?>cargo" value="<?php echo  $Contacto->get_Cargo();?>" size="9" />
					</td>
					<td >
						<input <?php echo $disabled['email']; ?> type="text" name="<?php echo  $count."_"?>email" value="<?php echo  $Contacto->get_Email();?>" size="9" />
							<input type="hidden" name="<?php echo  $count."_"?>id" value="<?php echo  $Contacto->get_Id();?>" size="9" />
					</td>
					<?php if($permisos->administracion){?>
					<td >
						<input class="borrar" type="button" name="eliminacontacto" value="Eliminar" onclick="javascript: if(confirm('Confirme que desea eliminar este contacto')){window.location = 'editContactos.php?id=<?php  echo  $var->Cliente->get_Id();?>&eliminar=<?php echo  $Contacto->get_Id();?>&edit=contactos';}"  />
					</td>
					<?php }?>
				</tr>
			<?php $count++;}?>
			<tr class="ListaTitulo" >
			<?php  $array_contacto = $var->opt['contacto_error']?>
				<td >
					<input type="text" name="n_nombre" size="9" value="<?php  echo $array_contacto['nombre']?>"/>
				</td>
				<td  nowrap>
					<input type="text" name="n_telefono" size="9" value="<?php  echo $array_contacto['telefono']?>"/>
				</td>
				<td >
					<input type="text" name="n_cargo" size="9" value="<?php  echo $array_contacto['cargo']?>"/>
				</td>
				<td >
					<input type="text" name="n_email" size="9" value="<?php  echo $array_contacto['email']?>"/>
				</td>
			</tr>
			<tr></tr>
		</table>
			<br />
	<!-- Parámetros ocultos -->
	<input type="hidden" name="id" value="<?php echo  $var->Cliente->get_Id();?>" />
	<input type="hidden" name="edit" value="contactos" />
<div  class="bottomMenu">
	<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
	<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
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
