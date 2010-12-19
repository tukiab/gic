<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once($appRoot.'/Utils/utils.php');
	include ('_addFactura.php');
	$var = new AddFactura ($_GET);
		FB::info($var->opt);
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');	
	?>
	<form method="GET" target=""><br/>
		<div id="titulo">Crear factura </div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
		
	<div align="center">
	<table style="margin-top:8ex;margin-left:2%;margin-right:2%;">
		<tr>
	      	<td nowrap><?php echo  _translate("Gestor")?></td>
		  	<td>
				<label  ><?php echo  $var->opt['usuario_obj']->get_Nombre_Y_Apellidos();?></label>
			</td>	
		</tr>
		<tr>
	      	<td nowrap><?php echo  _translate("Venta")?></td>
		  	<td>
				<label  ><?php echo  $var->opt['Venta']->get_Nombre();?></label>
			</td>	
		</tr>
		<tr>
	      	<td nowrap><?php echo  _translate("Empresa")?></td>
		  	<td>
				<label  ><?php $cliente = $var->opt['Venta']->get_Cliente(); echo $cliente->get_Razon_Social();?></label>
			</td>	
		</tr>
                <tr>
	      	<td nowrap><?php echo  _translate("Producto")?></td>
		  	<td>
				<label  ><?php  $producto=$var->opt['Venta']->get_Producto();echo  $producto['nombre'];?></label>
			</td>
		</tr>
	</table> 
	
	  <table style="margin-top:8ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Factura")?></td>
		</tr>
		<tr>
                    <td nowrap><?php echo  _translate("Base imponible ")?>&euro;&#42;</td>
			<td>
				<input style="width:120px"  style="width:100%"  type="text" name="base_imponible" value="<?php echo  $var->opt['base_imponible'];?>" />
			</td>
	    </tr>
	    <tr>
			<td nowrap><?php echo  _translate("IVA %")?>&#42;</td>
			<td>
				<input style="width:120px"  style="width:100%"  type="text" name="IVA" value="<?php echo  $var->opt['IVA'];?>" />
			</td>
	    </tr>
	    <tr>
			<td nowrap><?php echo  _translate("Cantidad pagada")?>&#42;</td>
			<td>
				<input style="width:120px"  style="width:100%"  type="text" name="cantidad_pagada" value="<?php echo  $var->opt['cantidad_pagada'];?>" />
			</td>
	    </tr>
	    <tr>
		  <td nowrap><?php echo  _translate("Estado")?>&#42;</td>
		  <td  style="text-align:right;">
			<select style="width:120px" name="estado_factura">
				<?php 
				$estado_factura_seleccionado = $var->opt['estado_factura'];?>
				<option value="0" <?php if(0 == $estado_factura_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_estados_facturas'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_factura_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
	    </tr>
		<tr>
	      <td nowrap><?php echo  _translate("Fecha de pago")?>&#42;</td>
		  <td style="text-align: right;">
			<input style="width:98px"   type="text" class="fecha" name="fecha_pago" value="<?php echo  timestamp2date($var->opt['fecha_pago']);?>" />
		  </td>	
	    </tr>
	    	    
	     <tr>
	      <td nowrap><?php echo  _translate("Fecha de facturaci&oacute;n")?>&#42;</td>
		  <td style="text-align: right;">
			<input style="width:98px"   type="text" class="fecha" name="fecha_facturacion" value="<?php echo  timestamp2date($var->opt['fecha_facturacion']);?>" />
		  </td>	
	    </tr>
	  </table>  
	  <input style="width:100%" type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input style="width:100%" type="hidden" name="id_venta" value="<?php echo  $var->opt['id_venta'];?>" />
	
	</div>

	 <div  class="bottomMenu">
			<table>
				<tr>
					<td width="40%"></td>
					<td style="text-align:right;" >
						<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
					</td>
					<td style="text-align:right;">
						<input type="submit" name="guardar" value="<?php echo  _translate("Guardar")?>" />
					</td>
				</tr>
			</table>
		</div>
	</form>
	
	<script type="text/javascript">
	<!--
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}
	-->
	</script>
	<?php 
//		include($appRoot.'/include/html/bottomMenu.php');
//		include($appRoot.'/include/html/footer.php');
	?>
