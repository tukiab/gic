<?php
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/export.php');
//Opciones:
include ('_gestion_permisos.php');
	$var = new GestionPermisos($_POST);

include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');

//Colores:
	$cGrupos = "#DDDDDD";
	$cRoles = "#EEEEEE";
	$cfilaPar = "#DDDDDD";
	$cfilaImpar = "#EEEEEE";
?>
<script language="JavaScript" type="text/javascript">
	<!--
	var origBgColorPar = "#DDDDDD";
	var origBgColorImpar = "#EEEEEE";
	var selectBgColor = "#CCFFCC"; var rgbBgColor = "rgb(204, 255, 204)"

	function switchColor(elem, pos){
	
		if(elem.style.backgroundColor == rgbBgColor){
			if(pos!=1)
				elem.style.backgroundColor=origBgColorPar
			else
				elem.style.backgroundColor=origBgColorImpar
		}
		else
			elem.style.backgroundColor=selectBgColor
	}
	
	function showInfo(id_info, id_tag){
		visible = document.getElementById(id_info).style.visibility
		if(visible == "collapse"){
			document.getElementById(id_info).style.visibility="visible"
			document.getElementById(id_tag).value="<?_translate("Ocultar")?>"
		}
		else{
			document.getElementById(id_info).style.visibility="collapse"	
			document.getElementById(id_tag).value="<?_translate("Ver")?>"
		}
	}
	<?if($permisos->escritura){?>
	function seleccionar(id_proceso){
		document.getElementById("proceso").value=id_proceso
		document.getElementById("seleccion").value=id_proceso
		document.forms[0].submit()
	}
	<?}?>
	//-->
</script>
<table>
	<tr>
		<td class="TituloPag" nowrap><?_translate("Gesti&oacute;n de Permisos para los Procesos")?></td>
	</tr>
</table>
<div id="serverMessage" style="position:absolute;top:140px;right:5px;color:#FFFFFF;background-color: #CC0033;font-size:small;font-weight:bold;width:350px;">
	<?if($var->guardar){?>
		<?_translate("Permisos actualizados.")?>
	<?}?>
</div>
<br />
<br />
<form action="<?$_SERVER['PHP_SELF']?>" method="POST">
	<?if($var->seleccion || $var->guardar){
		//Adquiriendo los datos para el proceso:
		$data = $var->getListaPermisos($var->proceso['id']);
		?>
	<!-- Vista de edición de un proceso -->
		<?if($permisos->escritura){?>
		<div class="BloqueAdmin">
		<table style="border-width:thin;border-style:solid;background-color:white;">
			<tr><td colspan="3"><?_translate("Permisos para: "); echo  "<font style=\"font-weight:bold;\">".$var->proceso['nombre']."</font>"?></td></tr>
			<tr><td><br /></td></tr>
			<tr><td style="background-color:white;"></td><td colspan="2" class="ListaGrisA" style="text-align:center;"><?_translate("Grupos")?></td></tr>
			<?foreach($var->listaGrupos as $info_grupo){
				//Permisos para cada grupo
				$perm_tmp = $var->arrayPermisos2valor($data['grupos'][$info_grupo['id']]);?>
			<tr>
				<td style="background-color:white;" width="20%"></td>
				<td class="ListaGrisA" nowrap width="70%"><?echo  $info_grupo['nombre']?></td>
				<td>
					<select name="<?echo  "grupos_".$info_grupo['id']?>">
						<option value="N" <?if($perm_tmp == "N") echo  "selected"?> >N</option>
						<option value="L" <?if($perm_tmp == "L") echo  "selected"?> >L</option>
						<option value="E" <?if($perm_tmp == "E") echo  "selected"?> >L/E</option>
						<option value="A" <?if($perm_tmp == "A") echo  "selected"?> >L/E/A</option>
					</select>
				</td>
			</tr>
			<?}?>
			<tr><td><br /></td></tr>
			<tr><td style="background-color:white;"></td><td colspan="2" class="ListaGrisB" style="text-align:center;"><?_translate("Roles")?></td></tr>
			<?foreach($var->listaRoles as $info_roles){
				//Permisos para cada role
				$perm_tmp = $var->arrayPermisos2valor($data['roles'][$info_roles['id']]);?>
			<tr>
				<td style="background-color:white;"></td>
				<td class="ListaGrisB" nowrap><?echo  $info_roles['nombre']?></td>
				<td>
					<select name="<?echo  "roles_".$info_roles['id']?>">
						<option value="N" <?if($perm_tmp == "N") echo  "selected"?> >N</option>
						<option value="L" <?if($perm_tmp == "L") echo  "selected"?> >L</option>
						<option value="E" <?if($perm_tmp == "E") echo  "selected"?> >L/E</option>
						<option value="A" <?if($perm_tmp == "A") echo  "selected"?> >L/E/A</option>
					</select>
				</td>
			</tr>
			<?}?>
			<tr><td><br /></td></tr>		
		</table>
		<br />
		<p style="width:90%;text-align:right;">
			<input type="submit" name="volver" value="<?_translate("Volver")?>" /> &nbsp;&nbsp;&nbsp;
			<input type="submit" name="guardar" value="<?_translate("Guardar")?>" />
		</p>
		<input type="hidden" id="proceso" name="proceso" value="<?echo  $var->proceso['id']?>" />
		<br />
		<br />
		<br />
		<br />
		</div>
		<?}?>
	<?}else{?>
	<!-- Vista por defecto. Consulta de permisos para cada proceso -->
	<div class="BloqueAdmin">
		<table width="80%" class="ListaGris">
			<tr><td colspan="3" style="text-align:center;padding-bottom:1.5em;"><?_translate("Procesos")?></td></tr>
			<?foreach($var->listaProcesos as $info_proceso){
				//Alternando los colores en las filas:
					if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
				//Adquiriendo los datos para cada proceso:
					$data = $var->getListaPermisos($info_proceso['id']);?>
			<tr style="background-color:<?echo  $color?>;">
				<td width="70%">
					<?echo  $info_proceso['nombre']?>
					<? // en vez de class:  visibility:collapse;width:100%;text-align:right; ?>
					<div id="<?echo  "info_".$info_proceso['id']?>" class="InfoAdmin" style="visibility:collapse;">
						<table>
							<tr>
								<td width="25%"></td>
								<td>
									<table style="background-color:white;">
										<tr><td colspan="2" class="ListaGrisA" style="text-align:center;"><?_translate("Grupos")?></td></tr>
										<?foreach($var->listaGrupos as $info_grupo){
											$perm_tmp = $data['grupos'][$info_grupo['id']];
											if( ($perm_tmp['lectura'] || $perm_tmp['escritura'] || $perm_tmp['administracion'])){?>
											<tr>
												<td class="ListaGrisA">
													<?echo  $info_grupo['nombre']?>
												</td>
												<td class="ListaGrisA">
													<?
														if($perm_tmp['lectura'] && $perm_tmp['escritura'] && $perm_tmp['administracion'])
															echo  "L/E/A";
														else if($perm_tmp['lectura'] && $perm_tmp['escritura'])
															echo  "L/E";
														else if($perm_tmp['lectura'])
															echo  "L";
														else
															echo  "N";
													?>
												</td>
											</tr>
											<?}?>
										<?}?>
										<tr><td><br /></td></tr>
										<tr><td colspan="2" class="ListaGrisB" style="text-align:center;"><?_translate("Roles")?></td></tr>
										<?foreach($var->listaRoles as $info_roles){
											$perm_tmp = $data['roles'][$info_roles['id']];
											if( ($perm_tmp['lectura'] || $perm_tmp['escritura'] || $perm_tmp['administracion'])){?>
											<tr>
												<td class="ListaGrisB">
													<?echo  $info_roles['nombre']?>
												</td>
												<td class="ListaGrisB">
													<?
														if($perm_tmp['lectura'] && $perm_tmp['escritura'] && $perm_tmp['administracion'])
															echo  "L/E/A";
														else if($perm_tmp['lectura'] && $perm_tmp['escritura'])
															echo  "L/E";
														else if($perm_tmp['lectura'])
															echo  "L";
														else
															echo  "N";
													?>
												</td>
											</tr>
											<?}?>
										<?}?>				
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td width="15%" style="vertical-align:text-top;text-align:center;">
					<input 	id="<?echo  "tag_".$info_proceso['id']?>" 
							style="width:100%;" 
							type="button" 
							onClick="showInfo('<?echo  "info_".$info_proceso['id']?>', '<?echo  "tag_".$info_proceso['id']?>')" 
							value="<?_translate("Ver")?>" 
					/>
				</td>
				<td width="15%" style="vertical-align:text-top;text-align:center;">
				<?if($permisos->escritura){?>
					<input style="width:100%;" type="button" name="editar" value="<?_translate("Editar")?>" onClick="seleccionar('<?echo  $info_proceso['id']?>')" />
				<?}else{?>
					<input style="width:100%;" type="button" name="editar" value="<?_translate("Editar")?>" />
				<?}?>
				</td>
			</tr>
			<?}?>
		</table>
		<input type="hidden" id="proceso" name="proceso" value="" />
		<input type="hidden" id="seleccion" name="seleccion" value="" />
		<br />
		<br />
		<br />
		<br />
		<br />
	</div>
	<?}?>
</form>



<!-- Leyenda de las abreviaturas de los permisos -->
<div id="leyendaAdmin">
	<?_translate("Leyenda")?>
	<table>
		<tr><td colspan="2" class="ListaGrisA" style="text-align:center;"><?_translate("Permisos")?></td></tr>
			<tr class="ListaGrisF0">
				<td style="padding:3px;">N</td>
				<td style="padding:3px;"><?_translate("Ninguno")?></td>
			</tr>
			<tr class="ListaGrisF1" >
				<td>L</td>
				<td><?_translate("Lectura")?></td>
			</tr>
			<tr class="ListaGrisF0">
				<td>E</td>
				<td><?_translate("Escritura")?></td>
			</tr>
			<tr class="ListaGrisF1">
				<td>A</td>
				<td><?_translate("Administracion")?></td>
			</tr>
	</table>
	<br />
</div>

<?
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>