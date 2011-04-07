<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showSede.php');
	$var = new ShowSede($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');
?>
<style type="text/css">
	#contenedor table{
		width:300px;
		margin-bottom:20px;
	}
</style>
<?php 
if($var->opt['msg']){?>
	<div id="error_msg" ><?php echo$var->opt['msg']?></div>
<?php }?>
<?php if($permisos->lectura){?>
<?php $localidad = $var->Sede->get_Localidad();?>
<div id="titulo"><?php echo  $localidad?></div>
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div id="contenedor" align="center" style="margin: 0 auto;" >
	<!-- **************** DATOS DE LA SEDE **************** -->
		<table>
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos de la sede")?><a class="show" href="#" clase="datos"></a></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Id sede")?>:</td>
				<td class="ColDer"><?php echo  ($var->Sede->get_Id());?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Empresa")?>:</td>
				<td class="ColDer"><?php echo  ($var->Cliente->get_Razon_Social());?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Sede->get_Localidad();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Sede->get_Provincia();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("C&oacute;digo Postal")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Sede->get_CP();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Direcci&oacute;n")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Sede->get_Direccion();?>
				</td>
			</tr>
		</table>
		<!-- contactos -->
		<?php $listaContactos = $var->Sede->get_Lista_Contactos();?>
		<table>
			<tr>
			  	<td class="ListaTitulo" colspan="4"><?php echo  _translate("Contactos de la sede")?><a class="show" href="#" clase="contactos"></a></td>
			</tr>
			<?php if($listaContactos){?>
			<tr class="contactos">
				<th ><?php echo  _translate("Nombre Contacto")?></th>
				<th ><?php echo  _translate("Tel&eacute;fono")?></th>
				<th ><?php echo  _translate("Email")?></th>
				<th ><?php echo  _translate("Cargo")?></th>
			</tr>
			<?php }?>
			<?php $impar=false;
				foreach ($listaContactos as $contacto){
					if($impar){
						$impar=false;
						$class = 'par';
					}else{
						$impar=true;
						$class = 'impar';
					}?>
					<tr class="<?php  echo $class?> contactos" >
						<td ><?php echo  $contacto->get_Nombre();?></td>
						<td ><?php echo  $contacto->get_Telefono();?></td>
						<td ><?php echo  email($contacto->get_Email());?></td>
						<td ><?php echo  $contacto->get_Cargo();?></td>
					</tr>
				<?php }?>
			<?php 
			if($permisos->administracion){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/rel_Sedes_Contactos.php?id=".$var->Sede->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=500,scrollbars=yes');"><?php echo  _translate("Editar los contactos de la sede")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>
</div>
<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>
<div class="bottomMenu">
	<table>
		<tr>
			<td colspan="2" style="text-align:right;" nowrap>
				<label title="<?php echo  _translate("Volver")?>">
					<a href="<?php echo $appDir.'/Clientes/showCliente.php?id='.$var->Cliente->get_Id();?>"><input type="button"value="<?php echo  _translate("Volver")?>" /></a>
				</label>
			</td>
		</tr>
	</table>
</div>

</form>
<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>
<?php include($appRoot.'/include/html/footer.php')?>