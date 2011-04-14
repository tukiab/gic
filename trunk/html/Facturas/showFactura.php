<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_showFactura.php');
	$var = new ShowFactura($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/Common/php/header.php');
	include($appRoot.'/Common/php/menu.php');
	include($appRoot.'/Common/php/bottomMenu.php');
}
else
	include ($appRoot.'/Common/php/popupHeader.php');

	$cliente = new Cliente ($var->opt['Factura']->get_Cliente());
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
<div id="titulo"><?php echo  $cliente->get_Razon_Social()." - ".$var->opt['Factura']->get_Numero_Factura();?></div>
<?php if($permisos->lectura){?>

<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $titulo = $var->opt['Factura']->get_Numero_Factura();?>
		
<form id="frm" action="<?php echo  $_SERVER['PHP_SELF'];?>" method="GET">
<div align="center" style="margin-top:40px">
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Factura")?></td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Numero")?>:</td>
			<td class="ColDer"><?php echo  ($var->opt['Factura']->get_Numero_Factura());?></td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Venta")?>:</td>
			<td class="ColDer"><?php $venta = $var->opt['Factura']->get_Venta(); ?>
				<?php echo  $venta->get_Nombre()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Estado")?>:</td>
			<td class="ColDer">
				<?php $estado=$var->opt['Factura']->get_Estado_Factura();echo  $estado['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Base imponible")?>:</td>
			<td class="ColDer">
				<?php echo $var->opt['Factura']->get_Base_Imponible();?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("IVA")?>:</td>
			<td class="ColDer">
				<?php echo $var->opt['Factura']->get_IVA();?>%
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Pagado")?>:</td>
			<td class="ColDer">
				<?php echo $var->opt['Factura']->get_Cantidad_Pagada();?> 
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Total a pagar")?>:</td>
			<td class="ColDer"><?php $a_pagar = $var->opt['Factura']->get_Total()-$var->opt['Factura']->get_Cantidad_Pagada(); ?>
				<?php echo  $a_pagar;?>
			</td>				
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de pago")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Factura']->get_Fecha_Pago());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de facturacion")?>:</td>
			<td class="ColDer">
				<?php  echo timestamp2date($var->opt['Factura']->get_Fecha_Facturacion())?>
			</td>
		</tr>
		<?php 
		if($permisos->administracion){?>
		<tr>
			<td class="Transparente" colspan="6" style="text-align:right;">
				<?php $url_dest = $appDir."/Facturas/editFactura.php?id=".$var->opt['Factura']->get_Id();?>
				
				<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				
			</td>
		</tr>
		<?php }?>
	</table>
	
	<div class="bottomMenu">
		<table>
			<tr>
				<td colspan="2" style="text-align:right;" nowrap>
				<?php $usuario = new Usuario($_SESSION['usuario_login']);
					if($permisos->administracion && $usuario->esAdministradorTotal()){?>
							<label title="<?php echo  _translate("BORRAR")?>">
								<a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar factura")?>" /></a>
								<input type="hidden" id="eliminar" name="eliminar" value="0"/>
								<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>						
							</label>
							<label title="<?php echo  _translate("Impimir en pdf")?>">
								<a target="_blank" href="imprimirFacturaPDF.php?id_factura=<?php echo $var->opt['id']; ?>"><input type="button" value="<?php echo _translate("PDF")?>" /></a>
							</label>
							
						<?php }?>
						&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<?php }?>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php include($appRoot.'/Common/php/footer.php')?>