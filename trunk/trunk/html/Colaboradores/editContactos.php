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
include ('_editColaborador.php');
	$var = new EditColaborador($_GET);

include ($appRoot.'/Common/php/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Contactos")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />
<?php if($permisos->escritura){?>
<div id="contenedor" style="margin-top: 100px;" align="center">

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
				<tr class="ListaTitulo" align="center">
					<td align="center">
						<input <?php echo $disabled['nombre']; ?> type="text" name="<?php echo  $count."_"?>nombre" value="<?php echo  $Contacto->get_Nombre();?>" size="9" />
					</td>
					<td align="center" nowrap>
						<input <?php echo $disabled['telefono']; ?> type="text" name="<?php echo  $count."_"?>telefono" value="<?php echo  $Contacto->get_Telefono();?>" size="9" />
					</td>
					<td align="center">
						<input <?php echo $disabled['cargo']; ?> type="text" name="<?php echo  $count."_"?>cargo" value="<?php echo  $Contacto->get_Cargo();?>" size="9" />
					</td>
					<td align="center">
						<input <?php echo $disabled['email']; ?> type="text" name="<?php echo  $count."_"?>email" value="<?php echo  $Contacto->get_Email();?>" size="9" />
							<input type="hidden" name="<?php echo  $count."_"?>id" value="<?php echo  $Contacto->get_Id();?>" size="9" />
					</td>
					<?php if($var->gestor->esAdministradorTotal()){?>
					<td align="center">
						<input class="borrar" type="button" name="eliminacontacto" value="Eliminar" onclick="javascript: if(confirm('Confirme que desea eliminar este contacto')){window.location = 'editContactos.php?id=<?php  echo  $var->Colaborador->get_Id();?>&eliminar=<?php echo  $Contacto->get_Id();?>&edit=contactos';}"  />
					</td>
					<?php }?>
				</tr>
			<?php $count++;}?>
			<tr class="ListaTitulo" align="center">
			<?php  $array_contacto = $var->opt['contacto_error']?>
				<td class="ListaTitulo" align="center">
					<input type="text" name="n_nombre" size="9" value="<?php  echo $array_contacto['nombre']?>"/>
				</td>
				<td class="ListaTitulo" align="center" nowrap>
					<input type="text" name="n_telefono" size="9" value="<?php  echo $array_contacto['telefono']?>"/>
				</td>
				<td class="ListaTitulo" align="center">
					<input type="text" name="n_cargo" size="9" value="<?php  echo $array_contacto['cargo']?>"/>
				</td>
				<td class="ListaTitulo" align="center">
					<input type="text" name="n_email" size="9" value="<?php  echo $array_contacto['email']?>"/>
				</td>
			</tr>
			<tr><td></td></tr>
		</table>
			<br />
	<!-- ParÃ¡metros ocultos -->
	<input type="hidden" name="id" value="<?php echo  $var->Colaborador->get_Id();?>" />
	<input type="hidden" name="edit" value="contactos" />
<div  class="bottomMenu">
	<table>
		<tr>
			<td width="40%"></td>
			<td style="text-align:right;" >
				<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
			</td>
			<td style="text-align:right;">
				<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
			</td>
		</tr>
	</table>
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
