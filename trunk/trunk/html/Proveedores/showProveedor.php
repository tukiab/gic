<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showProveedor.php');
	$var = new ShowProveedor($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');

?>
<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $razon_social = $var->opt['Proveedor']->get_Razon_Social();?>
<div id="titulo"><?php echo  $razon_social?></div>		
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div id="contenedor" align="center">
	<!-- **************** DATOS DEL PROVEEDOR **************** -->
	<div id="izquierda">
		<table>
			<tr>
			  	<td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos del Proveedor")?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("CIF/NIF Proveedor")?>:</td>
				<td class="ColDer"><?php echo  ($var->opt['Proveedor']->get_NIF());?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Razón social")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Proveedor']->get_Razon_Social()?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Proveedor']->get_Domicilio();?>
				</td>				
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Proveedor']->get_Localidad();?> 
				</td>				
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Proveedor']->get_Provincia();?>
				</td>
			</tr>		
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<?php echo  web($var->opt['Proveedor']->get_Web());?>
				</td>
			</tr>
			<?php 
			//if($permisos->administracion){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Proveedores/editProveedor.php?NIF=".$var->opt['Proveedor']->get_NIF();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php //}?>
		</table>
	</div>
<br/>

<!-- **************** CONTACTOS **************** -->

<div style="clear:both;" align="center">
	<!-- Contactos -->
	<table>
		<tr>
		  	<td class="ListaTitulo" style="text-align:center;" colspan="5"><?php echo  _translate("Contactos del Proveedor")?></td>
		</tr>
 		<tr>				
			<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Nombre Contacto")?></th>
			<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Teléfono")?></th>
			<!-- <th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Móvil")?></th> -->
			<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Email")?></th>
			<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Cargo")?></th>
		</tr>
		<?php $impar=false;
			$listaContactos = $var->opt['Proveedor']->get_Lista_Contactos();
			FB::info($var->opt['Proveedor']);
			foreach ($listaContactos as $contacto){
				if($impar){
					$impar=false;
					$class = 'par';
				}else{
					$impar=true;
					$class = 'impar';
				}?>
				<tr class="<?php  echo $class?>" align="center">
					<td align="center"><?php echo  $contacto->get_Nombre();?></td>
					<td align="center"><?php echo  $contacto->get_Telefono();?></td>
					<!-- <td align="center"><?php echo  $contacto->get_Movil();?></td> -->
					<td align="center"><?php echo  email($contacto->get_Email());?></td>
					<td align="center"><?php echo  $contacto->get_Cargo();?></td>
				</tr>
			<?php }?>
		<?php //Cualquiera que tenga permiso de escritura en "Incidencias" puede editar los contactos
		//if($permisos->escritura){?>
		<tr>
			<td class="Transparente" colspan="6" style="text-align:right;">
				<?php $url_dest = $appDir."/Proveedores/editContactos.php?NIF=".$var->opt['Proveedor']->get_NIF();?>
				<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=260,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
			</td>
		</tr>
		<?php //}?>
	</table>	
</div>



</div>
</form>
<?php }?>
<?php include($appRoot.'/include/html/footer.php')?>
