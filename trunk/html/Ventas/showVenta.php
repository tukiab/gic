<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showVenta.php');
	$var = new ShowVenta($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');

	$oferta = new Oferta ($var->opt['Venta']->get_Oferta());
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
<div id="titulo"><?php echo  $oferta->get_Nombre_Oferta()." - ".$var->opt['Venta']->get_Nombre();?></div>
<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $titulo = $var->opt['Venta']->get_Nombre();?>
		
<form id="frm" action="<?php echo  $_SERVER['PHP_SELF'];?>" method="GET">
<div align="center" style="margin-top:40px">
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Venta")?></td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Nombre")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Nombre()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Oferta")?>:</td>
			<td class="ColDer">
				<?php $oferta = $var->opt['Venta']->get_Oferta();echo  $oferta->get_Codigo();?>
			</td>
		</tr>
                <tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Importe")?>:</td>
			<td class="ColDer">
				<?php echo  $oferta->get_Importe();?> &euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Empresa")?>:</td>
			<td class="ColDer">
				<?php $cliente = $oferta->get_Cliente(); echo $cliente->get_Razon_Social()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Producto")?>:</td>
			<td class="ColDer">
				<?php $producto=$oferta->get_Producto();echo  $producto['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Tipo comisi&oacute;n")?>:</td>
			<td class="ColDer">
				<?php $producto=$var->opt['Venta']->get_Tipo_Comision();echo  $producto['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Forma de pago")?>:</td>
			<td class="ColDer">
				<?php $producto=$var->opt['Venta']->get_Forma_Pago();echo  $producto['nombre'];?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha aceptado")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Aceptado());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de asignaci&oacute;n a t&eacute;cnico")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Asignacion_Tecnico());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de entrada en vigor")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Entrada_Vigor());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Formaci&oacute;n bonificada")?>:</td>
			<td class="ColDer">
				<?php  if($var->opt['Venta']->get_Formacion_Bonificada()) echo "S&Iacute;"; else echo "NO";?>
			</td>
		</tr>

		<?php $i=1;$plazos = $var->opt['Venta']->get_Plazos();
		if($plazos)
			foreach($plazos as $plazo){?>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Plazo ".$i)?>:</td>
			<td class="ColDer">
				<?php  echo timestamp2date($plazo['fecha']); $i++;
				if($plazo['fk_estado'] == 1) echo " -- PENDIENTE"; else echo " -- ACEPTADO";
				?>
			</td>
		</tr>
		<?php }?>

	</table>
	
	<div class="bottomMenu">
		<table>
			<tr>
				<td colspan="2" style="text-align:right;" nowrap>
				<?php FB::info($var->opt['Venta']); if($gestor_actual->esAdministradorTotal()){?>
							<label title="<?php echo  _translate("BORRAR")?>">
								<a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar venta")?>" /></a>
								<input type="hidden" id="eliminar" name="eliminar" value="0"/>
								<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>						
							</label>
							<?php $factura = $var->opt['Venta']->get_Factura();if($factura){?>
								<a href="<?php echo $appDir."/Facturas/showFactura.php?id=".$factura->get_Id();?>"><input type="button" value="<?php echo  _translate("Factura")?>" /></a>
							<?php }else{?>
								<a href="<?php echo $appDir."/Facturas/addFactura.php?id_venta=".$var->opt['Venta']->get_Id();?>"><input type="button" value="<?php echo  _translate("Crear factura")?>" /></a>
							<?php }?>
						<?php }?>
						&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<?php }?>
<?php include($appRoot.'/include/html/footer.php')?>
