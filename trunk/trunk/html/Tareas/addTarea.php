<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_addTarea.php');
	$var = new AddTarea ($_GET);
include ($appRoot.'/Common/php/popupHeader.php');
	
	?>

<script type="text/javascript">
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}

	function cambia_tipo(id_tipo){
		$('.tipo').hide();
		$('.tipo'+id_tipo).show();
	}

	$(document).ready(function(){

		cambia_tipo(<?php echo $var->opt['tipo'];?>);

	});
</script>
<form method="GET" target="" action="">
	<div id="titulo"><?php echo $var->Proyecto->get_Nombre()." - ".$var->Sede->get_Localidad()."<br/>"; echo _translate("Nueva Tarea");?></div>
	<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
	<?php if($permisos->escritura){?>
	
	<div align="center">
		<table style="margin-top:8ex;">
			<tr>
				<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Tarea")?></td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Tipo")?>&#42;</td>
				<td class="ColDer">
					<select id="tipo" onchange="cambia_tipo(this.value)" name="tipo">
					<?php
						$tipo_seleccionado = $var->opt['tipo'];
						foreach($var->datos['lista_tipos_tareas'] as $tipo){
						?>
						<option value="<?php echo $tipo['id']?>"
								<?php if($tipo['id'] == $tipo_seleccionado) echo  "selected=\"selected\"";?>>
							<?php  echo $tipo['nombre']?>
						</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Fecha")?>&#42;</td>
				<td  class="ColDer">
					<input    type="text" class="fecha" name="fecha" value="<?php echo  timestamp2date($var->opt['fecha']);?>" />
				</td>
			</tr>
			<tr class="tipo tipo1 tipo3 tipo4">
				<td class="ColIzq"><?php echo  _translate("Horas desplazamiento")?>&#42;</td>
				<td>
					<input type="text" name="horas_desplazamiento" value="<?php echo  $var->opt['horas_desplazamiento'];?>" />
				</td>
			</tr>
			<tr class="tipo tipo3 tipo4">
				<td class="ColIzq"><?php echo  _translate("Horas de visita")?>&#42;</td>
				<td>
					<input type="text" name="horas_visita" value="<?php echo  $var->opt['horas_visita'];?>" />
				</td>
			</tr>
			<tr class="tipo ">
				<td class="ColIzq"><?php echo  _translate("Horas de auditor&iacute;a interna")?>&#42;</td>
				<td>
					<input type="text" name="horas_auditoria_interna" value="<?php echo  $var->opt['horas_auditoria_interna'];?>" />
				</td>
			</tr>
			<tr class="tipo tipo2">
				<td class="ColIzq"><?php echo  _translate("Horas de despacho")?>&#42;</td>
				<td>
					<input type="text" name="horas_despacho" value="<?php echo  $var->opt['horas_despacho'];?>" />
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Observaciones")?></td>
				<td>
					<textarea name="observaciones" ><?php echo  $var->opt['observaciones'];?></textarea>
				</td>
			</tr>
		</table>
		<input style="width:100%" type="hidden" name="id_usuario" value="<?php echo  $var->Usuario->get_Id();?>" />
		<input style="width:100%" type="hidden" name="id_proyecto" value="<?php echo  $var->Proyecto->get_Id();?>" />
		<input style="width:100%" type="hidden" name="id_sede" value="<?php echo  $var->Sede->get_Id();?>" />

		<table>
			<tr>
				<td class="ColIzq"><?php echo  _translate("T&eacute;cnico")?></td>
				<td>
					<label  ><?php  echo $var->Proyecto->get_Id_Usuario();?></label>
				</td>
			</tr>
		</table>
	</div>
	 <div  class="bottomMenu">
		<table>
			<tr>
				<td width="40%"></td>
				<td  class="ColDer" >
					<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
				</td>
				<td  class="ColDer">
					<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
				</td>
			</tr>
		</table>
	</div>
	<?php }else{
	echo  _translate("No tiene permisos suficientes");
	}?>
</form>