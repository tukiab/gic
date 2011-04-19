<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_showVenta.php');
	$var = new ShowVenta($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/Common/php/header.php');
	include($appRoot.'/Common/php/menu.php');
	include($appRoot.'/Common/php/bottomMenu.php');
}
else
	include ($appRoot.'/Common/php/popupHeader.php');

	$oferta = new Oferta ($var->opt['Venta']->get_Oferta());
?>
<style type="text/css">
	table.ConDatos td{width:50%}
	.ColDer{max-width:300px;}
</style>
<script language="JavaScript" type="text/javascript">
	function eliminar(){
		if(confirm('confirmar borrado')){
			$('#eliminar').val(1);
			$('#frm').submit();
		}		
	}
</script>
<div id="titulo"><?php echo  "Venta: ".$var->opt['Venta']->get_Nombre();?></div>
<?php 
if($var->opt['msg']){
	echo  "<div id=\"error_msg\" >".$var->opt['msg']."</div>";
}
else{?>
<?php $titulo = $var->opt['Venta']->get_Nombre();?>

<?php if($permisos->lectura){ ?>

<form id="frm" action="<?php echo  $_SERVER['PHP_SELF'];?>" method="GET">
<!--	<ul id="menu-sec">
		<?php if($permisos->administracion){?>
		<li>
			<label title="<?php echo  _translate("BORRAR")?>">
				<a href="#" onclick="eliminar();" class="borrar"><?php echo  _translate("Borrar venta")?></a>
				<input type="hidden" id="eliminar" name="eliminar" value="0"/>
				<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>
			</label>
		<li>
			<?php $factura = $var->opt['Venta']->get_Factura();if($factura){?>
				<a href="<?php echo $appDir."/Facturas/showFactura.php?id=".$factura->get_Id();?>"><input type="button" value="<?php echo  _translate("Factura")?>" /></a>
			<?php }else{?>
				<a href="<?php echo $appDir."/Facturas/addFactura.php?id_venta=".$var->opt['Venta']->get_Id();?>"><input type="button" value="<?php echo  _translate("Crear factura")?>" /></a>
			<?php }?>
		</li>
		<?php }?>
	</ul>
-->
<div id="contenedor">
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Venta")?></td>
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
			<td class="ColIzq" nowrap><?php echo  _translate("Importe oferta")?>:</td>
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
			<td class="ColIzq" nowrap><?php echo  _translate("Tipo de venta")?>:</td>
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
		
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de toma de contacto")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Toma_Contacto());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de inicio")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Inicio());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha estimada de formaci&oacute;n ")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Estimada_Formacion());?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Fecha de pago inicial")?>:</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['Venta']->get_Fecha_Pago_Inicial());?>
			</td>
		</tr>
	</table>
	<table class="ConDatos">
		<tr>
		  	<td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos adicionales")?></td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("FORCEM")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Forcem()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Plazo de ejecuci&oacute;n")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Plazo_Ejecucion()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Precio consultor&iacute;a")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Precio_Consultoria()?>&euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Precio formaci&oacute;n")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Precio_Formacion()?>&euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Pago inicial")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Pago_Inicial()?>&euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Pago mensual")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Pago_Mensual()?>&euro;
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de pagos mensuales")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Numero_Pagos_Mensuales()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Cuenta de cargo")?>:</td>
			<td class="ColDer">
				<?php  echo $var->opt['Venta']->get_Cuenta_Cargo();?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Observaciones de forma de pago")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Observaciones_Forma_Pago()?>
			</td>
		</tr>

		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Subvenciones")?>:</td>
			<td class="ColDer">
				<?php  if($var->opt['Venta']->get_Subvenciones()) echo "S&Iacute;"; else echo "NO";?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Certificaci&oacute;n")?>:</td>
			<td class="ColDer">
				<?php  if($var->opt['Venta']->get_Certificacion()) echo "S&Iacute;"; else echo "NO";?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Presupuesto aceptado de certificadora")?>:</td>
			<td class="ColDer">
				<?php  if($var->opt['Venta']->get_Presupuesto_Aceptado_Certificadora()) echo "S&Iacute;"; else echo "NO";?>
			</td>
		</tr>

		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Nombre de certificadora")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Nombre_Certificadora()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Otros proyectos incluidos")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Otros_Proyectos()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Observaciones")?>:</td>
			<td class="ColDer">
				<?php echo  $var->opt['Venta']->get_Observaciones()?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq" nowrap><?php echo  _translate("Proyecto asociado")?>:</td>
			<td class="ColDer">
				<?php $proyecto = $var->opt['Venta']->get_Proyecto();?>
				<a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id();?>"><?php echo $proyecto->get_Nombre();?></a>
			</td>
		</tr>

	</table>
</div>
</form>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php }?>
<?php include($appRoot.'/Common/php/footer.php')?>