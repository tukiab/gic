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
<script type="text/javascript">
	/*function actualizar_total_venta(){
		var val1 = parseInt($('#precio_consultoria').val());
		var val2 = parseInt($('#precio_formacion').val());
		var precio = val1+val2;
		
		$('#precio_total').val(precio);
	}*/
</script>
	<form method="GET" target="" action=""><br/>
		<div id="titulo">Proceso de venta - Aceptar <?php if( $var->opt['Oferta']->get_Es_Oportunidad_De_Negocio()) echo "Oportunindad" ; else echo "Oferta"." - ";?><br/><?php echo $var->opt['Oferta']->get_Nombre_Oferta(); ?></div>
		<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
		<?php if($permisos->escritura){?>

	<div align="center">
	  <table style="margin-top:8ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo"  colspan="2"><?php echo  _translate("Datos de la Venta")?></td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("C&oacute;digo de oferta")?></td>
			<td>
				<?php echo  $var->opt['Oferta']->get_Codigo();?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Nombre")?>&#42;</td>
			<td>
				<input type="text" name="nombre" value="<?php echo  $var->opt['nombre'];?>" />
			</td>
	    </tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Tipo de venta")?>&#42;</td>
		  <td  class="ColDer">
			<select  name="tipo_comision">
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
		  <td class="ColIzq"><?php echo  _translate("Forma de pago")?>&#42;</td>
		  <td  class="ColDer">
			<select  name="forma_pago">
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
		  <td class="ColIzq"><?php echo  _translate("Formaci&oacute;n bonificada")?>&#42;</td>
		  <td  class="ColDer">
			<select  name="formacion_bonificada">
				<?php 
				$formacion_bonificadaseleccionado = $var->opt['formacion_bonificada'];?>
				<option value="0" <?php if(0 == $formacion_bonificadaseleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("NO");?></option>
				<option value="1" <?php if(1 == $formacion_bonificadaseleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("S&iacute;");?></option>
			</select>
		  </td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha Aceptado")?>&#42;</td>
			<td class="ColDer">
				<?php echo  timestamp2date($var->opt['fecha_aceptado']);?>
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha Entrada en Vigor")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_entrada_vigor" value="<?php echo  timestamp2date($var->opt['fecha_entrada_vigor']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha de asignaci&oacute;n a t&eacute;cnico")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_asignacion_tecnico" value="<?php echo  timestamp2date($var->opt['fecha_asignacion_tecnico']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha de toma de contacto")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_toma_contacto" value="<?php echo  timestamp2date($var->opt['fecha_toma_contacto']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha de inicio")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_inicio" value="<?php echo  timestamp2date($var->opt['fecha_inicio']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha estimada de formaci&oacute;n")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_estimada_formacion" value="<?php echo  timestamp2date($var->opt['fecha_estimada_formacion']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Fecha de pago inicial")?>&#42;</td>
			<td class="ColDer">
				<input style="width:98px"   type="text" class="fecha" name="fecha_pago_inicial" value="<?php echo  timestamp2date($var->opt['fecha_pago_inicial']);?>" />
			</td>
		</tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("FORCEM")?></td>
			<td>
				<textarea rows="5" cols="30" name="forcem"><?php echo  $var->opt['forcem'];?></textarea>
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Plazo de ejecuci&oacute;n")?></td>
			<td>
				<textarea rows="5" cols="30" name="plazo_ejecucion"><?php echo  $var->opt['plazo_ejecucion'];?></textarea>
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Precio consultor&iacute;a")?></td>
			<td>
				<input type="text" name="precio_consultoria" id="precio_consultoria" value="<?php echo  $var->opt['precio_consultoria'];?>" onchange="/*actualizar_total_venta();*/"/>&euro;
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Precio formaci&oacute;n")?></td>
			<td>
				<input type="text" name="precio_formacion" id="precio_formacion" value="<?php echo  $var->opt['precio_formacion'];?>" onchange="/*actualizar_total_venta();*/" />&euro;
			</td>
	    </tr>
		<!--<tr>
			<td class="ColIzq"><?php echo  _translate("Precio total")?></td>
			<td>
				<input type="text" id="precio_total" value="<?php echo  $var->opt['precio_consultoria']+$var->opt['precio_formacion'];?>" readonly="readonly" />&euro;
			</td>
	    </tr>-->
		<tr>
			<td class="ColIzq"><?php echo  _translate("Pago inicial")?></td>
			<td>
				<input type="text" name="pago_inicial" value="<?php echo  $var->opt['pago_inicial'];?>" />&euro;
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Pago mensual")?></td>
			<td>
				<input type="text" name="pago_mensual" value="<?php echo  $var->opt['pago_mensual'];?>" />&euro;
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("N&uacute;mero de pagos mensuales")?></td>
			<td>
				<input type="text" name="numero_pagos_mensuales" value="<?php echo  $var->opt['numero_pagos_mensuales'];?>" />
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Cuenta de cargo")?></td>
			<td>
				<input type="text" name="cuenta_cargo" value="<?php echo  $var->opt['cuenta_cargo'];?>" />
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Observaciones de forma de pago")?></td>
			<td>
				<textarea rows="5" cols="30" name="observaciones_forma_pago" ><?php echo  $var->opt['observaciones_forma_pago'];?></textarea>
			</td>
	    </tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Subvenciones")?></td>
		  <td  class="ColDer">
			<select  name="subvenciones">
				<?php
				$subvenciones_seleccionado = $var->opt['subvenciones'];?>
				<option value="0" <?php if(0 == $subvenciones_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("NO");?></option>
				<option value="1" <?php if(1 == $subvenciones_seleccionado) echo  "selected:\"selected\"";?>><?php  echo _translate("S&Iacute;");?></option>
			</select>
		  </td>
	    </tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Certificaci&oacute;n")?></td>
		  <td  class="ColDer">
			<select  name="certificacion">
				<?php
				$certificacion_seleccionado = $var->opt['certificacion'];?>
				<option value="0" <?php if(0 == $certificacion_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("NO");?></option>
				<option value="1" <?php if(1 == $certificacion_seleccionado) echo  "selected:\"selected\"";?>><?php  echo _translate("S&Iacute;");?></option>
			</select>
		  </td>
	    </tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Presupuesto aceptado de certificadora")?></td>
		  <td  class="ColDer">
			<select  name="presupuesto_aceptado_certificadora">
				<?php
				$presupuesto_aceptado_certificadora_seleccionado = $var->opt['presupuesto_aceptado_certificadora'];?>
				<option value="0" <?php if(0 == $presupuesto_aceptado_certificadora_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("NO");?></option>
				<option value="1" <?php if(1 == $presupuesto_aceptado_certificadora_seleccionado) echo  "selected:\"selected\"";?>><?php  echo _translate("S&Iacute;");?></option>
			</select>
		  </td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Nombre de certificadora")?></td>
			<td>
				<input type="text" name="nombre_certificadora" value="<?php echo  $var->opt['nombre_certificadora'];?>" />
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Otros proyectos incluidos")?></td>
			<td>
				<textarea rows="5" cols="30" name="otros_proyectos" ><?php echo  $var->opt['otros_proyectos'];?></textarea>
			</td>
	    </tr>
		<tr>
			<td class="ColIzq"><?php echo  _translate("Observaciones")?></td>
			<td>
				<textarea rows="5" cols="30" name="observaciones" ><?php echo  $var->opt['observaciones'];?></textarea>
			</td>
	    </tr>		
	    <?php /*for($i=1;$i<=12;$i++){?>
	    <tr>
	      <td class="ColIzq" >
	      	<?php echo  _translate("Plazo n&uacute;mero ").$i?>
	    	</td>
	    	<td class="ColDer">
				<input  type="text"class="fecha" name="plazo<?php echo $i;?>" value="<?php echo timestamp2date($var->opt['plazos'][$i]);?>" /><br/>
				<select  name="estado_plazo<?php echo $i;?>">
					<?php
					$plazo_estado_seleccionado = $var->opt['plazos_estados'][$i];?>
					<!-- <option value="0" <?php if(0 == $plazo_estado_seleccionado) echo  "selected:\"selected\"";?>><?php echo _translate("Elija una opci&oacute;n");?></option> -->
					<?php foreach($var->datos['lista_estados_plazos'] as $estado){?>
					<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $plazo_estado_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $estado['nombre']?></option>
					<?php }?>
				</select>
			
			</td>
		</tr>
	    <?php }*/?>
	    
	  </table>  
	  <input  type="hidden" name="usuario" value="<?php echo  $var->opt['usuario_obj']->get_Id();?>" />
	  <input  type="hidden" name="id_oferta" value="<?php echo  $var->opt['id_oferta'];?>" />
	<table>
		<tr>
	      <td class="ColIzq"><?php echo  _translate("Gestor que realiza la venta")?></td>
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
					<td class="ColDer" >
						<input type="button" onClick="history.back()" value="<?php echo  _translate("Cancelar")?>"/>
					</td>
					<td class="ColDer">
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
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>