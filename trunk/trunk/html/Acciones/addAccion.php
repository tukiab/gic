<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once($appRoot.'/Utils/utils.php');
	include ('_addAccion.php');
	$var = new AddAccion ($_GET);
		
include ($appRoot.'/include/html/popupHeader.php');
	
	?>

	<form method="GET" target="">
		<div id="titulo" style="font-size:small;"><?php echo _translate("Nueva Acción")?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
		
	<div align="center">
	  <table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Acción")?></td>
		</tr>
		<tr>
		  <td nowrap><?php echo  _translate("Descripción")?>&#42;</td>
		  <td >
			<textarea name="descripcion" rows="20" cols="80"><?php  echo $var->opt['descripcion']?></textarea>
		  </td>
	    </tr>
	    <tr>
		  <td nowrap><?php echo  _translate("Tipo")?>&#42;</td>
		  <td  style="text-align:right;">
			<select style="width:120px" name="tipo_accion">
				<?php 
				$tipo_accion_seleccionado = $var->opt['tipo_accion'];?>
				<option value="0" <?php if(0 == $tipo_accion_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opción");?></option>
				<?php foreach($var->datos['lista_tipos_acciones'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_accion_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
				</select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionTiposAccion.php?id_cliente=".$var->opt['cliente']?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
	    </tr>		
	    <tr>
	      <td nowrap><?php echo  _translate("Fecha")?></td>
		  <td >
			<input style="width:85%"   type="text" class="fecha" name="fecha" value="<?php echo  timestamp2date($var->opt['fecha']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Fecha de la siguiente acción")?></td>
		  <td >
			<input style="width:85%"   type="text" class="fecha" name="fecha_siguiente_accion" value="<?php echo  timestamp2date($var->opt['fecha_siguiente_accion']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Gestor que realiza la accion")?></td>
		  <td >
			<label  ><?php echo  $var->opt['usuario_obj']->get_Nombre_Y_Apellidos();?></label>
		  </td>	
	    </tr>
	  </table>  
	  <input style="width:100%" type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input style="width:100%" type="hidden" name="id_cliente" value="<?php echo  $var->opt['cliente_obj']->get_Id();?>" />

	</div>

	 <div class="MenuInferiorFijo">
	  <table>
		<tr>
			<td>
				<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
			</td>
		  <?php //if($permisos->escritura){?>
			  
			  <td>
				<input id='guardar' name='guardar' type="submit" value="<?php echo  _translate("Guardar")?>"/>
			  </td>
			  
			  
		  <?php //}?>
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
