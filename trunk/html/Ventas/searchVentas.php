<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_searchVentas.php');

//Instanciamso la clase busqueda de ventas.
$var = new BusquedaVentas($_GET);
FB::info($var);
if(!$var->opt['exportar']){
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');

?>
<!-- Funciones varias para mejorar la interfaz -->
<script language="JavaScript" type="text/javascript">
<!--
		$(function(){
			$("#mostrarBusqueda").click(function(event) {
				event.preventDefault();
				$("#opcionesBusqueda").slideToggle();
			});
		});
		
		function repagina(nav){
			document.forms[0].navigation.value=nav;
			mostrar = document.getElementById("mostrar");
			if(nav!='Exportar')
				mostrar.click();
			else{
				mostrar.click();
			}
			document.forms[0].navigation.value='Inicio'
		}
		function irpag(numpag){
			var valorpag=document.getElementById('numpag').value;
			mostrar = document.getElementById("mostrar");
			
			valorpag=parseInt(valorpag);
			if(valorpag=="" || valorpag==undefined)
				valorpag='1';
			document.forms[0].navigation.value='Irpag';
			document.forms[0].page.value=valorpag;
			mostrar.click();
		}
		function EvaluateText(cadena, obj, e){//evalua la entrada de numeros
			opc = false;
			tecla = (document.all) ? e.keyCode : e.which;
			if(tecla == 13){//Si pulsa intro
				irpag('numpag');//Envia formulario con la nueva pagina
			}else if(tecla==8){//Si pulsa la tecla de borrado
				opc = true;
			}else{
				if (cadena == "%d")
					if (tecla > 47 && tecla < 58)
						opc = true;
				if (cadena == "%f"){
					if (tecla > 47 && tecla < 58)
						opc = true;
				if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
					if (tecla == 46)
						opc = true;
				}

			}
			return opc;
		}
		
		//OrdenaciÃ³n:
			//variables: 'order_by' y 'order_by_asc_desc'
		function orderBy(order_by){
			if($('#order_by_asc_desc').attr('value') == 'ASC')
				$('#order_by_asc_desc').attr('value', 'DESC');
			else
				$('#order_by_asc_desc').attr('value', 'ASC');
			
			$('#order_by').attr('value', order_by);
			$('#mostrar').click();
		}				
	//-->
		function eliminar(){
			if(confirm('Confirmar borrado')){
				$('#eliminar').val(1);
				$('#frm_ventas').submit();
			}		
		}
	
	$(document).ready(function(){
		$('#chk_todos').click(function(){
			if($('#chk_todos').attr("checked"))
				$('.chk').attr("checked", "checked");
			else
				$('.chk').removeAttr("checked");			
		});
	});
</script>

<div id="titulo"><?php echo  _translate("Ventas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<?php if($permisos->lectura){?>

<div id="contenedor" align="center">
<form method="GET" id="frm_ventas" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->
<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small">>> <?php echo  _translate("Mostrar/Ocultar opciones de b&uacute;squeda")?></a></i><br/>
<div id="opcionesBusqueda">
	<table>
		<tr class="BusquedaTable">
			<td colspan="6" class="ListaTitulo">
				<div style="float:left"><?php echo  _translate("Opciones de b&uacute;squeda")?></div>
			</td>
		</tr>		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Nombre')?> &nbsp; 
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="nombre" value="<?php  echo $var->opt['nombre']?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('C&oacute;digo oferta/oportunidad')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="codigo" value="<?php  echo $var->opt['codigo']?>"></input>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Forma de pago')?>
			</td>
			<td class="busquedaDcha">
				<select name="forma_pago">
				<?php 
				$forma_pago_seleccionado = $var->opt['forma_pago'];?>
				<option value="0" <?php if($forma_pago_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_formas_pago'] as $forma_pago){?>
				<option value="<?php  echo $forma_pago['id']?>" <?php if($forma_pago['id'] == $forma_pago_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $forma_pago['nombre']?></option>
				<?php }?> 
				</select>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Tipo de comisi&oacute;n')?>
			</td>
			<td class="busquedaDcha">
				<select name="tipo_comision">
				<?php 
				$tipo_comision_seleccionado = $var->opt['tipo_comision'];?>
				<option value="0" <?php if($tipo_comision_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_tipos_comision'] as $tipo_comision){?>
				<option value="<?php  echo $tipo_comision['id']?>" <?php if($tipo_comision['id'] == $tipo_comision_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $tipo_comision['nombre']?></option>
				<?php }?> 
				</select>
			</td>
		</tr>
		<tr>
			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha aceptado desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_aceptado_desde" value="<?php  echo timestamp2date($var->opt['fecha_aceptado_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha aceptado hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_aceptado_hasta" value="<?php  echo timestamp2date($var->opt['fecha_aceptado_hasta'])?>"></input>
			</td>
		</tr>
		
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha asignaci&oacute;n a t&eacute;cnico desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_asignacion_tecnico_desde" value="<?php  echo timestamp2date($var->opt['fecha_asignacion_tecnico_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha asignaci&oacute;n a t&eacute;cnico hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_asignacion_tecnico_hasta" value="<?php  echo timestamp2date($var->opt['fecha_asignacion_tecnico_hasta'])?>"></input>
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de entrada en vigor desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_entrada_vigor_desde" value="<?php  echo timestamp2date($var->opt['fecha_entrada_vigor_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de entrada en vigor hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_entrada_vigor_hasta" value="<?php  echo timestamp2date($var->opt['fecha_entrada_vigor_hasta'])?>"></input>
			</td>
		</tr>
		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Formaci&oacute;n bonificada')?>
			</td>
			<td class="busquedaDcha">
				<select name="formacion_bonificada">
				<?php 
				$estado_seleccionado = $var->opt['formacion_bonificada'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
				<option value="1" <?php if(1 == $estado_seleccionado) echo  "selected:\"selected\"";?>>NO</option>
				<option value="2" <?php if(2 == $estado_seleccionado) echo  "selected:\"selected\"";?>>S&Iacute;</option>
				
				</select>
			</td>
			<td class="busquedaIzda" <?php if(!$permisos->administracion) echo 'style="display:none"';?>>
				<?php echo  _translate('Gestor')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php if(!$permisos->administracion) echo 'style="display:none"';?>>
				<select name="gestor">
					<?php 
					$gestor_seleccionado = $var->opt['gestor'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
					<?php foreach($var->datos['lista_gestores'] as $gestor){?>
					<option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $gestor['id']?></option>
					<?php }?> 
				</select>
			</td>
		</tr>
		
		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('N&uacute;mero de ventas por p&aacute;gina')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"></input>
			</td>
				
			<td colspan="2" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_ventas']->num_Resultados();?>" />
				<!-- Criterios de ordenaci&aacute;n -->
				<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
				<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
			</td>
		</tr>
	</table>
</div>
<br/>

<!-- RESULTADOS -->
		<div class="listado" style="width:94%;margin-left:2em;">
		<label class="nota"><?php  echo $var->datos['lista_ventas']->num_Resultados()." ".Resultados?></label>
		<?php if($permisos->administracion){?><!-- <input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /> --><?php }?>
			<table>
				<thead>
					<tr>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<input type=checkbox id="chk_todos"/>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('id')" ><?php echo  _translate("Id")?></a>
							<?php 
								if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('nombre')" ><?php echo  _translate("Nombre")?></a>
							<?php 
								if($var->opt['order_by']=='nombre' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='nombre' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('tipo_comision')" ><?php echo  _translate("Tipo comisi&oacute;n")?></a>
							<?php 
								if($var->opt['order_by']=='tipo_comision' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='tipo_comision' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('formacion_bonificada')" ><?php echo  _translate("Formaci&oacute;n bonificada")?></a>
							<?php 
								if($var->opt['order_by']=='formacion_bonificada' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='formacion_bonificada' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('forma_pago')" ><?php echo  _translate("Forma de pago")?></a>
							<?php 
								if($var->opt['order_by']=='forma_pago' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='forma_pago' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('fecha_aceptado')" ><?php echo  _translate("Fecha aceptado")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_aceptado' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_aceptado' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('fecha_asignacion_tecnico')" ><?php echo  _translate("Fecha asignaci&oacute;n t&eacute;cnico")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_asignacion_tecnico' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_asignacion_tecnico' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('fecha_entrada_vigor')" ><?php echo  _translate("Fecha entrada vigor")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_entrada_vigor' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_entrada_vigor' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($venta = $var->datos['lista_ventas']->siguiente() ){
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
					
						<td style="text-align:center;width:5%;">
							<input class="chk" type=checkbox name="seleccionados[]" value="<?php echo $venta->get_Id(); ?>" />							
						</td>
						<td style="text-align:center;width:5%;">
							<a href="<?php echo  $appDir.'/Ventas/showVenta.php?id='.$venta->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $venta->get_Id()?>&nbsp;&nbsp;</a>							
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo $venta->get_Nombre();?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php $tipo = $venta->get_Tipo_Comision();echo $tipo['nombre'];?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php if($venta->get_Formacion_Bonificada()) echo "S&Iacute;"; else echo "NO";?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php  $forma = $venta->get_Forma_Pago(); echo $forma['nombre'];?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php  echo timestamp2date($venta->get_Fecha_Aceptado()); ?>
						</td>	
						<td style="text-align:center;width:5%;">
							<?php  echo timestamp2date($venta->get_Fecha_Asignacion_Tecnico());?>
						</td>					
						<td style="text-align:center;width:5%;">
							<?php  echo timestamp2date($venta->get_Fecha_Entrada_Vigor());?>
						</td>
					</tr>
				<?php 
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista_ventas']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
						</td>
						<td colspan="10">
							<div style="display:inline;position:absolute;">
							<?php if($var->datos['page']>1){?>
								<a href="javaScript:repagina('Inicio')" title="<?php echo  _translate("Ir a la Primera")?>"><<</a> &nbsp;
								<a href="javaScript:repagina('Anterior')" title="<?php echo  _translate("Ir a la Anterior")?>"><</a> &nbsp;
							<?php }?>
								<?php echo  "P&aacute;gina ";echo  @($var->datos['page']/$var->datos['paso'])+1 ." de ".$var->datos['lastPage']?> &nbsp;
							<?php if((@($var->datos['page']/$var->datos['paso'])+1) < $var->datos['lastPage']){?>
								<a href="javaScript:repagina('Siguiente')" title="<?php echo  _translate("Ir a la Siguiente")?>">></a> &nbsp;
								<a href="javaScript:repagina('Fin')" title="<?php echo  _translate("Ir a la &Uacute;ltima")?>">>></a>
							<?php }?>
							</div>
							<div style="display:inline;float:right;">
								Ir a p&aacute;gina: 
								<input type="text" name="numpag" id="numpag" value="" size="4" onkeypress="return EvaluateText('%f', this, event);">
								<input type="button" value="Ir" onclick="javascript:irpag('numpag');">&nbsp;
							</div>
						</td>
					</tr>
					<?php if($permisos->administracion){?>
					<tr>
						<td colspan="11" style="text-align: right;">
							<a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar seleccionados")?>" /></a>
							<input type="hidden" id="eliminar" name="eliminar" value="0"/>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
</form>
</div>
<br />
<br />
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>
<?php }?>