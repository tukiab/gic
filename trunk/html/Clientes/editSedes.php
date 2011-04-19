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
<div id="titulo"><?php echo  _translate("Editar Sedes")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<br />

<div >

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
			<?php $disabled = 'disabled="disabled"';?>
				<tr class="ListaTitulo" >
					<td >
						<input <?php if(!$permisos->escritura)echo $disabled; ?> type="text" name="<?php echo  $count."_"?>localidad" value="<?php echo  $Sede->get_Localidad();?>" size="9" />
					</td>
					<td  nowrap>
						<input <?php if(!$permisos->escritura)echo $disabled; ?> type="text" name="<?php echo  $count."_"?>provincia" value="<?php echo  $Sede->get_Provincia();?>" size="9" />
					</td>
					<td >
						<input <?php if(!$permisos->escritura)echo $disabled; ?> type="text" name="<?php echo  $count."_"?>CP" value="<?php echo  $Sede->get_CP();?>" size="9" />
					</td>
					<td >
						<input <?php if(!$permisos->escritura)echo $disabled; ?> type="text" name="<?php echo  $count."_"?>direccion" value="<?php echo  $Sede->get_Direccion();?>" size="9" />
							<input type="hidden" name="<?php echo  $count."_"?>id" value="<?php echo  $Sede->get_Id();?>" size="9" />
					</td>
					<?php if($permisos->administracion && !$Sede->es_Sede_Principal()){?>
					<td >
						<input class="borrar" type="button" name="eliminasede" value="Eliminar" onclick="javascript: if(confirm('Confirme que desea eliminar esta sede')){window.location = 'editSedes.php?id=<?php  echo  $var->Cliente->get_Id();?>&eliminar=<?php echo  $Sede->get_Id();?>&edit=sedes';}"  />
					</td>
					<?php }?>
				</tr>
			<?php $count++;}?>
			<tr class="ListaTitulo" >
			<?php  $array_sede = $var->opt['sede_error']?>
				<td >
					<input type="text" name="n_localidad" size="9" value="<?php  echo $array_sede['localidad']?>"/>
				</td>
				<td  nowrap>
					<input type="text" name="n_provincia" size="9" value="<?php  echo $array_sede['provincia']?>"/>
				</td>
				<td >
					<input type="text" name="n_CP" size="9" value="<?php  echo $array_sede['CP']?>"/>
				</td>
				<td >
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

	<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
	<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />

</div>
</form>
</div>
<script language="JavaScript" type="text/javascript">
	<!--
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}
	-->
</script>
<?php include($appRoot.'/Common/php/footer.php')?>
