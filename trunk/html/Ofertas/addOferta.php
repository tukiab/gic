<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_addOferta.php');
	$var = new AddOferta ($_GET);
		//FB::info($var->opt);
include ($appRoot.'/Common/php/popupHeader.php');
	
	?>

	<form method="GET" target="" action=""><br/>
		<div id="titulo"><?php echo $var->opt['cliente_obj']->get_Razon_Social()." - "; if($var->opt['es_oportunidad_de_negocio']) echo _translate("Nueva Oportunidad"); else echo _translate("Nueva Oferta");?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
<?php if($permisos->escritura){?>
	<div align="center">
	  <table style="margin-top:8ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Oferta")?></td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Nombre")?>&#42;</td>
			<td class="ColDer">
				<input   type="text" name="nombre_oferta" value="<?php echo  $var->opt['nombre_oferta'];?>" />
			</td>
	    </tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Estado")?>&#42;</td>
		  <td   class="ColDer">
			<select  name="estado_oferta">
				<?php 
				$estado_oferta_seleccionado = $var->opt['estado_oferta'];?>
				<option value="0" <?php if(0 == $estado_oferta_seleccionado) echo  'selected="selected"';?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_estados_ofertas'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_oferta_seleccionado) echo  'selected="selected"';?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
	    </tr>
	    <tr>
		  <td class="ColIzq"><?php echo  _translate("Tipo de producto")?>&#42;</td>
		  <td   class="ColDer">
			<select  name="producto">
				<?php 
				$producto_seleccionado = $var->opt['producto'];?>
				<option value="0" <?php if(0 == $producto_seleccionado) echo  'selected="selected"';?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_tipos_productos'] as $producto){?>
				<option value="<?php  echo $producto['id']?>" <?php if($producto['id'] == $producto_seleccionado) echo  'selected="selected"';?>><?php  echo $producto['nombre']?></option>
				<?php }?> 
			</select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionTiposProducto.php?id_cliente=".$var->opt['cliente']?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
	    </tr>
	    <tr>
		  <td class="ColIzq"><?php echo  _translate("Proveedor")?>&#42;</td>
		  <td   class="ColDer">
			<select  name="proveedor">
				<?php 
				$proveedor_seleccionado = $var->opt['proveedor'];?>
				<option value="-1" <?php if(-1 == $producto_seleccionado) echo  'selected="selected"';?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_proveedores'] as $proveedor){?>
				<option value="<?php  echo $proveedor['id']?>" <?php if($proveedor['id'] == $proveedor_seleccionado) echo  'selected="selected"';?>><?php  echo $proveedor['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
	    </tr>
	   	<tr>
	      <td class="ColIzq"><?php echo  _translate("Fecha")?>&#42;</td>
		  <td  class="ColDer">
			<input    type="text" class="fecha" name="fecha" value="<?php echo  timestamp2date($var->opt['fecha']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("Importe")?>&#42;</td>
		  <td>
			<input    type="text" name=importe value="<?php echo  $var->opt['importe'];?>" />&nbsp;&euro;
		  </td>	
	    </tr>
	    
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("Fecha de definici&oacute;n")?>&#42;</td>
		  <td  class="ColDer">
			<input    type="text" class="fecha" name="fecha_definicion" value="<?php echo  timestamp2date($var->opt['fecha_definicion']);?>" />
		  </td>	
	    </tr>
	    <tr>
		  <td class="ColIzq"><?php echo  _translate("Probabilidad de contrataci&oacute;n")?>&#42;</td>
		  <td   class="ColDer">
			<select  name="probabilidad_contratacion">
				<?php 
				$probabilidad_seleccionado = $var->opt['probabilidad_contratacion'];?>
				<option value="0" <?php if(0 == $probabilidad_seleccionado) echo  'selected="selected"';?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_probabilidades'] as $probabilidad){?>
				<option value="<?php  echo $probabilidad['id']?>" <?php if($probabilidad['id'] == $probabilidad_seleccionado) echo  'selected="selected"';?>><?php  echo $probabilidad['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
	    </tr>
	    <tr>
		  <td class="ColIzq"><?php echo  _translate("Colaborador")?>&#42;</td>
		  <td   class="ColDer">
			<select  name="colaborador">
				<?php 
				$colaborador_seleccionado = $var->opt['colaborador'];?>
				<option value="0" <?php if(0 == $colaborador_seleccionado) echo  'selected="selected"';?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_colaboradores'] as $colaborador){?>
				<option value="<?php  echo $colaborador['id']?>" <?php if($colaborador['id'] == $colaborador_seleccionado) echo  'selected="selected"';?>><?php  echo $colaborador['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
	    </tr>
	    
	  </table>  
	  <input style="width:100%" type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input style="width:100%" type="hidden" name="id_cliente" value="<?php echo  $var->opt['cliente_obj']->get_Id();?>" />
	  <input style="width:100%" type="hidden" name="es_oportunidad" value="<?php echo  $var->opt['es_oportunidad_de_negocio'];?>" />

	<table>
		<tr>
	      <td class="ColIzq"><?php echo  _translate("Gestor que realiza la oferta")?></td>
		  <td>
			<label  ><?php echo  $var->opt['usuario_obj']->get_Nombre_Y_Apellidos();?></label>
		  </td>	
	    </tr>
	  </table> 
	</div>

	 <div  class="bottomMenu">
			<table>
				<tr>
					<td width="40%"></td>
					<td  class="ColDer" >
						<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
					</td>
					<td  class="ColDer">
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
//		include($appRoot.'/Common/php/bottomMenu.php');
//		include($appRoot.'/Common/php/footer.php');
	?>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>