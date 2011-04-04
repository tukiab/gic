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

<style type="text/css">
	input[type=text],select{max-width: 150px;}
</style>
<div id="titulo" style="font-size:small;"><?php echo _translate("Nueva Acci&oacute;n")?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
<?php if($permisos->escritura){?>
	<form method="GET" target="" action="">
	<div align="center">
	  <table style="margin-top:4.2ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Acci&oacute;n")?></td>
		</tr>
		<tr>
		  <td class="ColIzq" style="vertical-align:top"><?php echo  _translate("Descripci&oacute;n")?>&#42;</td>
		  <td class="ColDer">
			<textarea name="descripcion" rows="10" cols="40"><?php  echo $var->opt['descripcion']?></textarea>
		  </td>
	    </tr>
	    <tr>
		  <td class="ColIzq" style="vertical-align:top"><?php echo  _translate("Tipo")?>&#42;</td>
		  <td class="ColDer"  >
			<select name="tipo_accion">
				<?php 
				$tipo_accion_seleccionado = $var->opt['tipo_accion'];?>
				<option value="0" <?php if(0 == $tipo_accion_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_tipos_acciones'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_accion_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
				</select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionTiposAccion.php?id_cliente=".$var->opt['cliente']?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
	    </tr>		
	    <tr>
	      <td class="ColIzq" style="vertical-align:top"><?php echo  _translate("Fecha")?></td>
		  <td  class="ColDer">
			<input style="width:85%"   type="text" class="fecha" name="fecha" value="<?php echo  timestamp2date($var->opt['fecha']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td class="ColIzq" style="vertical-align:top"><?php echo  _translate("Fecha de la siguiente acci&oacute;n")?></td>
		  <td  class="ColDer">
			<input style="width:85%"   type="text" class="fecha" name="fecha_siguiente_accion" value="<?php echo  timestamp2date($var->opt['fecha_siguiente_accion']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td class="ColIzq" style="vertical-align:top"><?php echo  _translate("Gestor que realiza la accion")?></td>
		  <td  class="ColDer">
			<label  ><?php echo  $var->opt['usuario_obj']->get_Nombre_Y_Apellidos();?></label>
		  </td>	
	    </tr>
	  </table>  
	  <input  type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input  type="hidden" name="id_cliente" value="<?php echo  $var->opt['cliente_obj']->get_Id();?>" />

	</div>

	 <div class="MenuInferiorFijo">
	  <table>
		<tr>
			<td>
				<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
			</td>
		  <?php if($permisos->escritura){?>			  
			  <td>
				<input id='guardar' name='guardar' type="submit" value="<?php echo  _translate("Guardar")?>"/>
			  </td>
		  <?php }?>
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

<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>