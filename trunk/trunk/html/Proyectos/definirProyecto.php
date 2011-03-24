<?php /**
 * @ignore
 * @package default
 */

include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once($appRoot.'/Utils/utils.php');
	include ('_definirProyecto.php');
	$var = new DefinirProyecto($_GET);
		
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
	?>
<script type="text/javascript">
function cargar_plantilla(id_proyecto){
	$('#id_plantilla').val(id_proyecto);
	$('frm_definicion').submit();
}
</script>

	<form method="GET" target="" action="" id="frm_definicion">
		<div id="titulo"><?php echo $var->Proyecto->get_Nombre();?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

	<div align="center">
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
				<td class="ColIzq"><?php echo  _translate("Horas de documentaci&oacute;n")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['horas_documentacion'];?>" name="horas_documentacion" id="horas_documentacion" />
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Horas de auditor&iacute;a interna")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['horas_auditoria_interna'];?>" name="horas_auditoria_interna" id="horas_auditoria_interna" />
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Fecha de inicio")?>&#42;</td>
				<td>
					<input type="text" class="fecha" value="<?php echo timestamp2date($var->opt['fecha_inicio']);?>" name="fecha_inicio" id="fecha_inicio" />
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Fecha de finalizaci&oacute;n")?>&#42;</td>
				<td>
					<input type="text" class="fecha" value="<?php echo timestamp2date($var->opt['fecha_fin']);?>" name="fecha_fin" id="fecha_fin" />
				</td>
			</tr>
		<!-- datos de las sedes -->
		<?php
			$Cliente = $var->Proyecto->get_Cliente();
			foreach($Cliente->get_Lista_Sedes() as $sede){ ?>
			<tr>
			  <td class="ListaTitulo"  colspan="2"><?php echo $sede->get_Localidad();?></td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Horas de desplazamiento")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento'];?>" 
						   name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_horas_desplazamiento';?>"/>
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Horas de cada visita")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_horas_cada_visita'];?>"
						   name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_horas_cada_visita';?>"/>
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("N&uacute;mero de visitas")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_numero_visitas'];?>"
						   name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_numero_visitas';?>"/>
				</td>
			</tr>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Gastos incurridos")?>&#42;</td>
				<td>
					<input type="text" value="<?php echo $var->opt['definicion_sedes_'.$sede->get_Id().'_gastos_incurridos'];?>"
						   name="<?php echo 'definicion_sedes_'.$sede->get_Id().'_gastos_incurridos';?>"/>
				</td>
			</tr>
		<?php } ?>
			<tr>
				<td class="ColIzq"><?php echo  _translate("Guardar como plantilla")?>&#42;</td>
				<td>
					<input type="checkbox" <?php echo ($var->opt['es_plantilla'])?'checked="checked"':null;?> />
				</td>
			</tr>		
	  </table>
	  <!-- Plantillas -->
	  <table>
			<tr>
			  <td class="ListaTitulo"  colspan="2"><?php echo  _translate("Plantillas")?><a class="show" href="#" clase="plantillas"></a></td>
			</tr>
	  </table>
		<table class="plantillas">
			<tr>
				<td>Nombre</td>
				<td>Cargar</td>
			</tr>
			<?php while($proyecto = $var->ListaProyectos->siguiente()){?>
			<tr>
				<td><?php echo $proyecto->get_Nombre()?></td>
				<td><input type="button" value="Cargar" onclick="cargar_plantilla('<?php echo $proyecto->get_Id(); ?>')"/>td>
			</tr>
			<?php }?>
		</table>
	  <input  type="hidden" name="id" value="<?php echo  $var->opt['id'];?>" />
	  <input  type="hidden" name="id_plantilla" value="<?php echo  $var->opt['id_plantilla'];?>" />
	</div>

	 <div  class="bottomMenu">
		<table>
			<tr>
				<td width="40%"></td>
				<td class="ColDer" >
					<input type="button" onClick="history.back()" value="<?php echo  _translate("Volver")?>"/>
				</td>
				<td class="ColDer">
					<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
				</td>
			</tr>
		</table>
	</div>
	</form>