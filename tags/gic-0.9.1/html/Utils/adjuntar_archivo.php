<?php 
include ('../appRoot.php');
//require ($appRoot.'/Autentificacion/Usuarios.php');

include ($appRoot.'/Utils/lang.php');

include ($appRoot.'/Utils/_adjuntar_archivo.php');
$var = new AdjuntarArchivo($_POST, $_GET, $_FILES);

include ($appRoot.'/include/html/popupHeader.php');
?>
<script language="JavaScript" type="text/javascript">
	<!--
	function enviar(accion,id){
		document.getElementById('accion').value = accion;
		document.getElementById('id_archivo').value = id;
		document.forms[0].submit();
	}
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}
</script>
<br />
<table width="100%">
	<tr>
		<td class="MiniTituloPag" nowrap><?echo  "<b>".$var->opt['clase']." ".$var->opt['id']."</b>"?></td>
	</tr>
</table>

<div id="serverMessage" style="position:absolute;top:10px;right:5px;color:#FFFFFF;background-color:#CC0033;font-size:x-small;font-weight:bold;width:350px;"><?_translate($var->opt['error_msg'])?></div>

<form enctype="multipart/form-data" action="" method="post">
	<table width="90%">
		<tr class="MenuTable">
			<td class="ListaTitulo"><?_translate("Archivos adjuntos")?></td>
		</tr>
		<tr class="MenuTable">
			<td style="vertical-align:top;">
				<table class="MenuTable" width="100%">
				<?if($var->datos['lista_archivos']){?>
					<?foreach($var->datos['lista_archivos'] as $Adjunto){?>
						<tr hover>
							<td class="impar" width="30%"><a href="javascript:void(0);" onClick="window.open('<?echo  $appDir.'/Utils/enviar_archivo.php?id='.$var->opt['id'].'&clase='.$var->opt['clase'].'&id_archivo='.$Adjunto->get_Id()?>','<?echo  rand()?>','width=700,height=350,scrollbars=yes');" ><?echo  $Adjunto->get_Name()?></a></td>
							<td class="impar">&nbsp;<?echo  $Adjunto->get_Descripcion()?></td>
							<td class="impar" width="5%"><?echo  $Adjunto->get_Hum_Size()?></td>
							<td class="impar" style="font-size:x-small;vertical-align:bottom;"><a href="javascript:void(0)" onClick="enviar('del', '<?echo  $Adjunto->get_Id()?>');" ><?_translate("Borrar")?></a></td>
						</tr>			
					<?}?>
				<?}?>
				</table>
			</td>
		</tr>
		<tr class="MenuTable">
			<td class="ListaTitulo"><?_translate("Subir archivo")?></td>
		</tr>
		<tr class="MenuTable">
			<td>
				<table>
					<tr>
						<td><?_translate("Descripci&oacute;n")?>:&nbsp;</td><td><input type="text" name="descripcion" size="40"></td>
					</tr>
					<tr>
						<td><?_translate("Archivo")?>:&nbsp;</td><td><input type="file" name="fichero" size="30"></td>
					</tr>
					<tr><td colspan="2" style="text-align:right;font-weight:bold;font-size:x-small;"><?_translate("El tamaño m&aacute;ximo es de ~6M.")?></td></tr>
					<tr>
						<td style="text-align:right;" colspan="2">
							<input type="button" onClick="enviar('add', null)" value="&nbsp;&nbsp;<?_translate("Enviar")?>&nbsp;&nbsp;" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?echo  $var->opt['id']?>" />
	<input type="hidden" name="clase" value="<? echo  $var->opt['clase']?>" />
	<input type="hidden" name="accion" id="accion" />
	<input type="hidden" name="id_archivo" id="id_archivo" />
	<br />
	<br />
<div  class="bottomMenu">
	<table>
		<tr>
			<td width="50%"></td>
			<td style="text-align:center;" colspan="2">
				<input type="button" onClick="cerrar()" value="Cerrar"/>
			</td>
		</tr>
	</table>
</div>
</form>
<?include ($appRoot.'/include/html/footer.php');?>