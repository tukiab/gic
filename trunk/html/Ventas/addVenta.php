<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once($appRoot.'/Utils/utils.php');
	include ('_addVenta.php');
	$var = new AddVenta ($_GET);
		FB::info($var->opt);
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');	
	?>
	<form method="GET" target=""><br/>
		<div id="titulo">Proceso de venta - Aceptar <?php if( $var->opt['Oferta']->get_Es_Oportunidad_De_Negocio()) echo "Oportunindad" ; else echo "Oferta"." - ";?><br/><?php echo $var->opt['Oferta']->get_Nombre_Oferta(); ?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
		
	<div align="center">
	  <table style="margin-top:8ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la Venta")?></td>
		</tr>
		<tr>
			<td nowrap><?php echo  _translate("Nombre")?>&#42;</td>
			<td>
				<input style="width:120px"  style="width:100%"  type="text" name="nombre" value="<?php echo  $var->opt['nombre'];?>" />
			</td>
	    </tr>
		<tr>
		  <td nowrap><?php echo  _translate("Tipo comisi&oacute;n")?>&#42;</td>
		  <td  style="text-align:right;">
			<select style="width:120px" name="tipo_comision">
				<?php 
				$tipo_comision_seleccionado = $var->opt['tipo_comision'];?>
				<option value="0" <?php if(0 == $tipo_comision_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_tipos_comision'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_comision_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
			</select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionTiposComision.php?id_oferta=".$var->opt['id_oferta']?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
	    </tr>
	    <tr>
		  <td nowrap><?php echo  _translate("Forma de pago")?>&#42;</td>
		  <td  style="text-align:right;">
			<select style="width:120px" name="forma_pago">
				<?php 
				$forma_de_pagoseleccionado = $var->opt['forma_pago'];?>
				<option value="0" <?php if(0 == $forma_de_pagoseleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_formas_de_pago'] as $forma_de_pago){?>
				<option value="<?php  echo $forma_de_pago['id']?>" <?php if($forma_de_pago['id'] == $forma_de_pagoseleccionado) echo  "selected:\"selected\"";?>><?php  echo $forma_de_pago['nombre']?></option>
				<?php }?> 
                        </select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionTiposFormasDePago.php?id_oferta=".$var->opt['id_oferta']?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
	    </tr>
	    <tr>
		  <td nowrap><?php echo  _translate("Formaci&oacute;n bonificada")?>&#42;</td>
		  <td  style="text-align:right;">
			<select style="width:120px" name="formacion_bonificada">
				<?php 
				$formacion_bonificadaseleccionado = $var->opt['formacion_bonificada'];?>
				<option value="0" <?php if(0 == $formacion_bonificadaseleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("NO");?></option>
				<option value="1" <?php if(1 == $formacion_bonificadaseleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("S&iacute;");?></option>
			
		  </td>
	    </tr>
	   <tr>
	      <td nowrap><?php echo  _translate("Fecha Aceptado")?>&#42;</td>
		  <td style="text-align: right;">
			<?php echo  timestamp2date($var->opt['fecha_aceptado']);?>
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Fecha Entrada en Vigor")?>&#42;</td>
		  <td style="text-align: right;">
			<input style="width:98px"   type="text" class="fecha" name="fecha_entrada_vigor" value="<?php echo  timestamp2date($var->opt['fecha_entrada_vigor']);?>" />
		  </td>	
	    </tr>
	    	    
	     <tr>
	      <td nowrap><?php echo  _translate("Fecha de asignaci&oacute;n a t&eacute;cnico")?>&#42;</td>
		  <td style="text-align: right;">
			<input style="width:98px"   type="text" class="fecha" name="fecha_asignacion_tecnico" value="<?php echo  timestamp2date($var->opt['fecha_asignacion_tecnico']);?>" />
		  </td>	
	    </tr>
	    <!-- <tr>
	    	<td>
	    		<a href="#" class="mostrar_plazo" nombre="plazo1" > <?php echo  _translate("A&ntilde;adir plazo")?></a>
	    	</td>
	    	<td></td>
	    </tr> -->	
	    <?php for($i=1;$i<=12;$i++){?>    
	    <tr>
	      <td >
	      	<!-- <div style="display:none" id="plazo<?php echo $i;?>"> -->
	    		<?php echo  _translate("Plazo n&uacute;mero ").$i?>
	    	</td>
	    	<td>	  
				<input style="width:98px;" type="text"class="fecha" name="plazo<?php echo $i;?>" value="<?php echo timestamp2date($var->opt['plazos'][$i]);?>" /><br/>
				<select style="width:120px" name="estado_plazo<?php echo $i;?>">
				<?php 
				$plazo_estado_seleccionado = $var->opt['plazos_estados'][$i];?>
				<!-- <option value="0" <?php if(0 == $plazo_estado_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option> -->
				<?php foreach($var->datos['lista_estados_plazos'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $plazo_estado_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
			</select>
			</div>
		  </td>	
	    </tr>
	    <?php }?>
	    
	  </table>  
	  <input style="width:100%" type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input style="width:100%" type="hidden" name="id_oferta" value="<?php echo  $var->opt['id_oferta'];?>" />
	<table>
		<tr>
	      <td nowrap><?php echo  _translate("Gestor que realiza la venta")?></td>
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
	$(document).ready(function(){
		$(".mostrar_plazo").click(function(event) {
			event.preventDefault();
			var plazo = $(this).attr('nombre');
			$(this).hide(); 
			$("#"+plazo).toggle();
		});
		
			
	});
	-->
	</script>
	<?php 
//		include($appRoot.'/include/html/bottomMenu.php');
//		include($appRoot.'/include/html/footer.php');
	?>
