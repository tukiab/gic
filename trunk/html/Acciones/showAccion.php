<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showAccion.php');
	$var = new ShowAccion($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');

	$cliente = $var->opt['Accion']->get_Cliente();
	$tipo_accion = $var->opt['Accion']->get_Tipo_Accion();
	
?>
<br/>
<div id="titulo"><?php echo  $cliente['razon_social']." - ".$tipo_accion['nombre'];?></div>
<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $titulo = $tipo_accion['nombre'];?>
		
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div align="center" style="margin-top:40px">
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Acci�n")?></td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Tipo Acci�n")?>:</td>
			<td class="ColDer">
				<?php echo  $tipo_accion['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Usuario")?>:</td>
			<td class="ColDer">
				<?php $usuario = new Usuario($var->opt['Accion']->get_Usuario());echo  $usuario->get_Nombre_Y_Apellidos();?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Accion']->get_Fecha());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha siguiente acci�n")?>:</td>
			<td class="ColDer">
				<?php  echo timestamp2date($var->opt['Accion']->get_Fecha_Siguiente_Accion())?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Descipci�n")?>:</td>
			<td class="ColDer"><?php echo  ($var->opt['Accion']->get_Descripcion());?></td>
		</tr>
	<?php 
		//if($permisos->administracion){?>
		<!-- <tr>
			<td class="Transparente" colspan="6" style="text-align:right;">
				<?php $url_dest = $appDir."/Accions/editAccion.?id=".$var->opt['Accion']->get_Id();?>
				<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
			</td>
		</tr> -->
		<?php //}?>
	</table>
</div>
</form>
<?php }?>
<?php include($appRoot.'/include/html/footer.php')?>
