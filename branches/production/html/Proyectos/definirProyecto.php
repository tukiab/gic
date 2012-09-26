<?php /**
 * @ignore
 * @package default
 */

include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_definirProyecto.php');
	$var = new DefinirProyecto($_GET);
		
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
	?>
<script type="text/javascript">
function cargar_plantilla(id_proyecto){
	$('#id_plantilla').val(id_proyecto);
	$('#frm_definicion').submit();
}
</script>
<style type="text/css">

</style>
<form method="GET" target="" action="" id="frm_definicion">
	<div id="titulo"><?php echo $var->Proyecto->get_Nombre();?></div>
	<?php
	$venta = $var->Proyecto->get_Venta();
	if($permisos->administracion){?>
	<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
	<div id="contenedor">
			<table>
				<tr>
					<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la definici&oacute;n")?></td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Nombre")?>&#42;</td>
					<td>
						<input type="text" value="<?php echo $var->opt['nombre'];?>" name="nombre" id="nombre" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de documentaci&oacute;n")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['horas_documentacion'];?>" name="horas_documentacion" id="horas_documentacion" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de auditor&iacute;a interna")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['horas_auditoria_interna'];?>" name="horas_auditoria_interna" id="horas_auditoria_interna" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas desplazamiento auditor&iacute;a interna")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['horas_desplazamiento_auditoria_interna'];?>" name="horas_desplazamiento_auditoria_interna" id="horas_desplazamiento_auditoria_interna" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de auditor&iacute;a externa")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['horas_auditoria_externa'];?>" name="horas_auditoria_externa" id="horas_auditoria_externa" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de desplazamiento auditor&iacute;a externa")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['horas_desplazamiento_auditoria_externa'];?>" name="horas_desplazamiento_auditoria_externa" id="horas_desplazamiento_auditoria_externa" />
					</td>
				</tr>
				<?php if($venta){?>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Plazo de ejecuci&oacute;n (venta)")?></td>
					<td>
						<?php echo $venta->get_Plazo_Ejecucion();?>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Fecha de inicio")?></td>
					<td>
						<input type="text" class="fecha" value="<?php echo timestamp2date($var->opt['fecha_inicio']);?>" name="fecha_inicio" id="fecha_inicio" />
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Fecha de finalizaci&oacute;n")?></td>
					<td>
						<input type="text" class="fecha" value="<?php echo timestamp2date($var->opt['fecha_fin']);?>" name="fecha_fin" id="fecha_fin" />
					</td>
				</tr>
			</table>
				<!-- datos de las sedes -->
			<table>	<?php
				$cliente = $var->Proyecto->get_Cliente();
				$Cliente = new Cliente($cliente['id']);
				foreach($Cliente->get_Lista_Sedes() as $sede){ ?>
				<tr>
					<td class="ListaTitulo"  colspan="2"><?php echo $sede->get_Localidad();?></td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de desplazamiento")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento'];?>"
							name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento';?>"/>
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Horas de cada visita seguimiento")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita'];?>"
							name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_horas_cada_visita';?>"/>
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("N&uacute;mero de visitas seguimiento")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_numero_visitas'];?>"
							name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_numero_visitas';?>"/>
					</td>
				</tr>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Gastos incurridos")?></td>
					<td>
						<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos'];?>"
							name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_gastos_incurridos';?>"/>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="ColIzq"><?php echo  _translate("Guardar como plantilla")?></td>
					<td>
						<input type="checkbox" name="es_plantilla" <?php if($var->Proyecto->get_Es_Plantilla()) echo 'checked="checked"';?> />
					</td>
				</tr>
				<tr class="botones">
					<td colspan="2"><input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" /></td>
				</tr>
			</table>
			<input  type="hidden" name="id" value="<?php echo  $var->opt['id'];?>" />
			<input  type="hidden" id="id_plantilla" name="id_plantilla" />
		
			<!-- Plantillas -->
			<table>
				<tr>
					<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Plantillas")?><a class="show" href="#" clase="plantillas"></a></td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td>Cargar</td>
				</tr>
				<?php while($proyecto = $var->ListaProyectos->siguiente()){?>
				<tr>
					<td><?php echo $proyecto->get_Nombre()?></td>
					<td><input type="button" value="Cargar" onclick="cargar_plantilla('<?php echo $proyecto->get_Id(); ?>')"/></td>
				</tr>
			<?php }?>
			</table>
	</div>
	<div  class="bottomMenu">
				<input type="button" onClick="history.back()" value="<?php echo  _translate("Volver")?>"/>
		
	</div>
	<?php }else{
	echo  _translate("No tiene permisos suficientes");
	}?>
</form>
