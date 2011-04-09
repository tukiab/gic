<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showOferta.php');
	$var = new ShowOferta($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');

	$cliente = $var->opt['Oferta']->get_Cliente();
?>
<script language="JavaScript" type="text/javascript">
	function eliminar(){
		if(confirm('confirmar borrado')){
			$('#eliminar').val(1);
			$('#frm').submit();
		}		
	}
</script>
<br/>
<?php if($permisos->lectura){?>

<div id="titulo"><?php echo  $cliente->get_Razon_Social()." - ".$var->opt['Oferta']->get_Nombre_Oferta();?></div>
<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $titulo = $var->opt['Oferta']->get_Nombre_Oferta();?>
		
<form id="frm" action="<?php echo  $_SERVER['PHP_SELF'];?>" method="GET">

<ul id="menu-sec">


	<?php if($permisos->administracion  && !$var->opt['Oferta']->get_Aceptado() || $usuario->esAdministradorTotal()){?>
		<li>
			<label title="<?php echo  _translate("BORRAR")?>">
				<a class="borrar" href="#" onclick="eliminar();"><?php echo  _translate("Borrar oferta")?></a>
				<input type="hidden" id="eliminar" name="eliminar" value="0"/>
				<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>
			</label>
		</li>
		<li>
			<a href="<?php echo $appDir."/Ventas/addVenta.php?id_oferta=".$var->opt['Oferta']->get_Id() ;?>">
				<?php echo  _translate("Aceptar oferta")?>
			</a>
		</li>
		<?php }else if($var->opt['Oferta']->get_Usuario() == $gestor_actual->get_Id()){?>
		<li>
			<a href="<?php echo $appDir."/Ventas/addVenta.php?id_oferta=".$var->opt['Oferta']->get_Id() ;?>"><input type="button" value="<?php echo  _translate("Aceptar oferta")?>" /></a>
		</li>
		<?php }?>
	</ul>

<div id="contenedor">
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Oferta")?></td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("C&oacute;digo")?>:</td>
			<td class="ColDer"><?php echo  ($var->opt['Oferta']->get_Codigo());?></td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Nombre")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Oferta']->get_Nombre_Oferta()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Usuario")?>:</td>
			<td class="ColDer">
				<?php $usuario = new Usuario($var->opt['Oferta']->get_Usuario());echo  $usuario->get_Id();?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Estado")?>:</td>
			<td class="ColDer">
				<?php $estado=$var->opt['Oferta']->get_Estado_Oferta();echo  $estado['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Producto")?>:</td>
			<td class="ColDer">
				<?php $producto=$var->opt['Oferta']->get_Producto();echo  $producto['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Proveedor")?>:</td>
			<td class="ColDer">
				<?php $proveedor=$var->opt['Oferta']->get_Proveedor();echo  $proveedor['razon_social'];?>
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Empresa")?>:</td>
			<td class="ColDer">
				<?php $cliente = $var->opt['Oferta']->get_Cliente(); echo  $cliente->get_Razon_Social();?> 
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Colaborador")?>:</td>
			<td class="ColDer">
				<?php $proveedor=$var->opt['Oferta']->get_Colaborador();echo  $proveedor['nombre'];?>
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Fecha")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Oferta']->get_Fecha());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Importe")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Oferta']->get_Importe();?> &euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Probabilidad de contrataci&oacute;n")?>:</td>
			<td class="ColDer">
				<?php $prob = $var->opt['Oferta']->get_Probabilidad_Contratacion(); echo $prob['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Fecha de definici&oacute;n")?>:</td>
			<td class="ColDer">
				<?php  echo timestamp2date($var->opt['Oferta']->get_Fecha_Definicion())?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" ><?php echo  _translate("Aceptado")?>:</td>
			<td class="ColDer"><?php  if($var->opt['Oferta']->get_Aceptado())echo  _translate("S&Iacute;"); else echo  "NO";?></td>
		</tr>		<?php 
		if($permisos->administracion){?>
		<tr>
			<td class="Transparente" colspan="6" style="text-align:right;">
				<?php $url_dest = $appDir."/Ofertas/editOferta.php?id=".$var->opt['Oferta']->get_Id();?>
				<?php if(!$var->opt['Oferta']->get_Aceptado()){?>
				<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				<?php } ?>
			</td>
		</tr>
		<?php }?>
	</table>
</div>
</form>
<?php }?>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php include($appRoot.'/include/html/footer.php')?>