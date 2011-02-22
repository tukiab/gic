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
<div id="titulo"><?php echo  _translate("Editar empresa")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php //if($permisos->administracion){
$disabled = $var->Cliente->get_DisableEdit(); 
?>
	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr >
			  <td class="ColIzq"><?php echo  _translate("Raz&oacute;n Social")?>:</td>
			  <td class="ColDer">
				<input <?php echo $disabled['razon_social']; ?> type="text" name="razon_social" value="<?php echo  $var->Cliente->get_Razon_Social();?>" size="25" />
			  </td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Tipo de empresa")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['tipo_cliente']; ?> style="width:190px" name="tipo_cliente">
						<?php $tipo_cliente = $var->Cliente->get_Tipo_Cliente();?>
						<?php foreach($var->datos['lista_tipos_cliente'] as $tipo){?>
							<option value="<?php echo  $tipo['id']?>" <?php echo  ($tipo['id']==$tipo_cliente['id'])?'selected':null;?>>
								<?php echo  $tipo['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Grupo de empresas")?>:</td>
				<td class="ColDer">
					<select <?php echo $disabled['grupo_empresas']; ?> style="width:190px" name="grupo_empresas">
						<?php $grupo_seleccionado = $var->Cliente->get_Grupo_Empresas();?>
						<?php foreach($var->datos['lista_grupos_empresas'] as $grupo){?>
							<option value="<?php echo  $grupo['id']?>" <?php echo  ($grupo_seleccionado['id']==$grupo['id'])?'selected':null;?>>
								<?php echo  $grupo['nombre'];?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("CIF/NIF")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['NIF']; ?> type="text" name="NIF" value="<?php echo  trim(stripslashes($var->Cliente->get_NIF()))?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Tel&eacute;fono")?>:</td>
				<td class="ColDer" >
				  	<input <?php echo $disabled['telefono']; ?> type="text" size="25" name="telefono" value="<?php echo  $var->Cliente->get_Telefono();?>" />
				</td>				
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("FAX")?>:</td>

				<td class="ColDer">
				  	<input <?php echo $disabled['FAX']; ?> size="25" type="text"  name="FAX" value="<?php echo  $var->Cliente->get_FAX();?>" />
				 </td>	
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['domicilio']; ?> type="text" name="domicilio" value="<?php echo  trim(stripslashes($var->Cliente->get_Domicilio()))?>" size="25" />
				</td>				
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['localidad']; ?> type="text" name="localidad" value="<?php echo  trim(stripslashes($var->Cliente->get_Localidad()))?>" size="25" />
				</td>				
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['provincia']; ?> type="text" name="provincia" value="<?php echo  trim(stripslashes($var->Cliente->get_Provincia()))?>" size="25" />
				</td>				
			</tr>			
			<tr >
				<td class="ColIzq"><?php echo  _translate("CP")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['CP']; ?> type="text" name="CP" value="<?php echo  trim($var->Cliente->get_CP())?>" size="25" />
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("N&uacute;mero de empleados")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['numero_empleados']; ?> type="text" name="numero_empleados" value="<?php echo  trim($var->Cliente->get_Numero_Empleados())?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['web']; ?> type="text" name="web" value="<?php echo  trim($var->Cliente->get_Web())?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Sector")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['sector']; ?> type="text" name="sector" value="<?php  echo $var->Cliente->get_Sector();?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("SPA actual")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['SPA_actual']; ?> type="text" name="SPA_actual" value="<?php  echo $var->Cliente->get_SPA_Actual();?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Fecha de renovaci&oacute;n")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['fecha']; ?> type="text" class="fecha" name="fecha_renovacion" value="<?php  echo timestamp2date($var->Cliente->get_Fecha_Renovacion())?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Norma implantada")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['norma_implantada']; ?> type="text" name="norma_implantada" value="<?php  echo $var->Cliente->get_Norma_Implantada()?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Cr&eacute;ditos")?>:</td>
				<td class="ColDer">
					<input <?php echo $disabled['creditos']; ?> type="text" name="creditos" value="<?php  echo $var->Cliente->get_Creditos()?>" size="25" />
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Actividad")?>:</td>
				<td class="ColDer">
					<textarea <?php echo $disabled['actividad']; ?>rows="5" cols="30" name="actividad"><?php  echo $var->Cliente->get_Actividad()?></textarea>
				</td>
			</tr>
			<tr >
				<td class="ColIzq"><?php echo  _translate("Observaciones")?>:</td>
				<td class="ColDer">
					<textarea <?php echo $disabled['observaciones']; ?>rows="5" cols="30" name="observaciones"><?php  echo $var->Cliente->get_Observaciones()?></textarea>
				</td>
			</tr>
		</table>
			<br />
		<!-- Parámetros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Cliente->get_Id()?>" />
		<input type="hidden" name="edit" value="cliente" />
		<input type="hidden" id="guardar" name="guardar" value="" />
		
		<div  class="bottomMenu">
			<table>
				<tr>
					<td width="40%"></td>
					<td style="text-align:right;" >
						<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
					</td>
					<td style="text-align:right;">
						<input type="button" onclick="$('select').removeAttr('disabled');
							$('#guardar').val('guardar');
						$('#frm').submit();"  value="<?php echo  _translate("Guardar")?>" />
					</td>
				</tr>
			</table>
		</div>
	</form>
<?php //}?>
<script language="JavaScript" type="text/javascript">

	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	};
	function guardar(){
		
	};

</script>
<?php include($appRoot.'/include/html/footer.php')?>
