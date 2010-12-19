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
include ('_editColaborador.php');
	$var = new EditColaborador($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Editar Colaborador")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>

<br />
<?php //if($permisos->administracion){
$disabled = $var->Colaborador->get_DisableEdit(); 
?>
	<form id="frm" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
		<table >
			<tr class="ListaTitulo">
			  <td><?php echo  _translate("Raz�n Social")?>:</td>
			  <td class="impar">
				<input <?php echo $disabled['razon_social']; ?> type="text" name="razon_social" value="<?php echo  $var->Colaborador->get_Razon_Social();?>" size="25" />
			  </td>
			</tr>
			
			<tr class="ListaTitulo">
				<td><?php echo  _translate("CIF/NIF")?>:</td>
				<td class="impar">
					<input <?php echo $disabled['NIF']; ?> type="text" name="NIF" value="<?php echo  trim(stripslashes($var->Colaborador->get_NIF()))?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Comisi�n")?>:</td>
				<td class="impar" style="text-align:right">
				  	<input <?php echo $disabled['comision']; ?> type="text" size="25" name="comision" value="<?php echo  $var->Colaborador->get_Comision();?>" />
				</td>				
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Comisi�n por renovaci�n")?>:</td>

				<td class="impar"style="text-align:right">
				  	<input <?php echo $disabled['comision_por_renovacion']; ?> size="25" type="text"  name="comision_por_renovacion" value="<?php echo  $var->Colaborador->get_Comision_Por_Renovacion();?>" />
				 </td>	
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("CC pago comisiones")?>:</td>
				<td class="impar" style="text-align:right">
				  	<input <?php echo $disabled['cc_pago_comisiones']; ?> type="text" size="25" name="cc_pago_comisiones" value="<?php echo  $var->Colaborador->get_CC_Pago_Comisiones();?>" />
				</td>				
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Domicilio")?>:</td>
				<td class="impar">
					<input <?php echo $disabled['domicilio']; ?> type="text" name="domicilio" value="<?php echo  trim(stripslashes($var->Colaborador->get_Domicilio()))?>" size="25" />
				</td>				
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("Localidad")?>:</td>
				<td class="impar">
					<input <?php echo $disabled['localidad']; ?> type="text" name="localidad" value="<?php echo  trim(stripslashes($var->Colaborador->get_Localidad()))?>" size="25" />
				</td>				
			</tr>
                        <tr class="ListaTitulo">
				<td><?php echo  _translate("Provincia")?>:</td>
				<td class="impar">
					<input <?php echo $disabled['Provincia']; ?> type="text" name="provincia" value="<?php echo  trim(stripslashes($var->Colaborador->get_Provincia()))?>" size="25" />
				</td>
			</tr>
			<tr class="ListaTitulo">
				<td><?php echo  _translate("CP")?>:</td>
				<td class="impar">
					<input <?php echo $disabled['CP']; ?> type="text" name="CP" value="<?php echo  trim($var->Colaborador->get_CP())?>" size="25" />
			</tr>
			
		</table>
			<br />
		<!-- ParÃ¡metros ocultos -->
		<input type="hidden" name="id" value="<?php echo  $var->Colaborador->get_Id()?>" />
		<input type="hidden" name="edit" value="colaborador" />
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
