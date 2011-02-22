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
include ('_editCliente.php');
	$var = new EditCliente($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Sedes")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />
<?php //if($permisos->escritura){?>
<div id="contenedor" style="margin-top: 100px;" align="center">

<form action="<?php echo  $_SERVER['_SELF']?>" method="GET">
	<table>
		<tr class="ListaTitulo">
			<td><?php echo  _translate("Localidad")?></td>
			<td><?php echo  _translate("Provincia")?></td>
			<td><?php echo  _translate("CP")?></td>
			<td><?php echo  _translate("Direcci&oacute;n")?></td>
			<td></td>
		</tr>
			<?php 
			$count = 0;
			if($var->datos['lista_sedes'])
			foreach($var->datos['lista_sedes'] as $Sede){
			?>
			<?php $disabled = $Sede->get_DisableEdit();?>
				<tr class="ListaTitulo" align="center">
					<td align="center">
						<input <?php echo $disabled['localidad']; ?> type="text" name="<?php echo  $count."_"?>localidad" value="<?php echo  $Sede->get_Localidad();?>" size="9" />
					</td>
					<td align="center" nowrap>
						<input <?php echo $disabled['provincia']; ?> type="text" name="<?php echo  $count."_"?>provincia" value="<?php echo  $Sede->get_Provincia();?>" size="9" />
					</td>
					<td align="center">
						<input <?php echo $disabled['CP']; ?> type="text" name="<?php echo  $count."_"?>CP" value="<?php echo  $Sede->get_CP();?>" size="9" />
					</td>
					<td align="center">
						<input <?php echo $disabled['direccion']; ?> type="text" name="<?php echo  $count."_"?>direccion" value="<?php echo  $Sede->get_Direccion();?>" size="9" />
							<input type="hidden" name="<?php echo  $count."_"?>id" value="<?php echo  $Sede->get_Id();?>" size="9" />
					</td>
					<?php if($var->gestor->esAdministradorTotal()){?>
					<td align="center">
						<input class="borrar" type="button" name="eliminasede" value="Eliminar" onclick="javascript: if(confirm('Confirme que desea eliminar esta sede')){window.location = 'editSedes.php?id=<?php  echo  $var->Cliente->get_Id();?>&eliminar=<?php echo  $Sede->get_Id();?>&edit=sedes';}"  />
					</td>
					<?php }?>
				</tr>
			<?php $count++;}?>
			<tr class="ListaTitulo" align="center">
			<?php  $array_sede = $var->opt['sede_error']?>
				<td align="center">
					<input type="text" name="n_localidad" size="9" value="<?php  echo $array_sede['localidad']?>"/>
				</td>
				<td align="center" nowrap>
					<input type="text" name="n_provincia" size="9" value="<?php  echo $array_sede['provincia']?>"/>
				</td>
				<td align="center">
					<input type="text" name="n_CP" size="9" value="<?php  echo $array_sede['CP']?>"/>
				</td>
				<td align="center">
					<input type="text" name="n_direccion" size="9" value="<?php  echo $array_sede['direccion']?>"/>
				</td>
			</tr>
			<tr></tr>
		</table>
			<br />
	<!-- Parámetros ocultos -->
	<input type="hidden" name="id" value="<?php echo  $var->Cliente->get_Id();?>" />
	<input type="hidden" name="edit" value="sedes" />
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
<?php /*}else{
echo  _translate("No tiene permisos suficientes");
}*/?>
<script language="JavaScript" type="text/javascript">
	<!--
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}
	-->
</script>
<?php include($appRoot.'/include/html/footer.php')?>
