<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_searchFacturas.php');

//Instanciamso la clase busqueda de facturas.
$var = new BusquedaFacturas($_GET);
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
		
		//OrdenaciÃƒÂ³n:
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
				$('#frm').submit();
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

<div id="titulo"><?php echo  _translate("Facturas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<div id="contenedor" align="center">
<form method="GET" id="frm" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->
<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small">>> <?php echo  _translate("Mostrar/Ocultar opciones de búsqueda")?></a></i><br/>
<div id="opcionesBusqueda">
	<table>
		<tr class="BusquedaTable">
			<td colspan="6" class="ListaTitulo">
				<div style="float:left"><?php echo  _translate("Opciones de búsqueda")?></div>
			</td>
		</tr>		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Número de factura')?> &nbsp; 
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="numero_factura" value="<?php  echo $var->opt['numero_factura']?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Empresa')?> &nbsp; 
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="cliente" value="<?php  echo $var->opt['cliente']?>"></input>
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Base imponible desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="base_imponible_desde" value="<?php  echo ($var->opt['base_imponible_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Base imponible hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name=base_imponible_hasta" value="<?php  echo ($var->opt['base_imponible_hasta'])?>"></input>
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha pago desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_pago_desde" value="<?php  echo timestamp2date($var->opt['fecha_pago_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha pago hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_pago_hasta" value="<?php  echo timestamp2date($var->opt['fecha_pago_hasta'])?>"></input>
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de facturación desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_facturacion_desde" value="<?php  echo timestamp2date($var->opt['fecha_facturacion_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de facturación hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_facturacion_hasta" value="<?php  echo timestamp2date($var->opt['fecha_facturacion_hasta'])?>"></input>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Año desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="year_desde" value="<?php  echo$var->opt['year_desde']?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Año hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="year_hasta" value="<?php  echo $var->opt['year_hasta']?>"></input>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Número de facturas por página')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"></input>
			</td>
				<td class="busquedaIzda" <?php if(!$var->gestor->esAdministrador()) echo 'style="display:none"';?>>
				<?php echo  _translate('Gestor')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php if(!$var->gestor->esAdministrador()) echo 'style="display:none"';?>> 
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
				<?php echo  _translate('Estado')?>
			</td>
			<td class="busquedaDcha">
				<select name="estado">
				<?php 
				$estado_seleccionado = $var->opt['estado'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_estados'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
				</select>
			</td>
			<td colspan="2" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista']->num_Resultados();?>" />
				<!-- Criterios de ordenación -->
				<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
				<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
			</td>
		</tr>
	</table>
</div>
<br/>

<!-- RESULTADOS -->
		<div class="listado" style="width:94%;margin-left:2em;">
		<label class="nota"><?php  echo $var->datos['lista']->num_Resultados()." ".Resultados?></label>
		<?php if($gestor_actual->esAdministrador()){?><!-- <input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /> --><?php }?>
			<table>
				<thead>
					<tr>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<input type=checkbox id="chk_todos"/>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('numero_factura')" ><?php echo  _translate("Número de factura")?></a>
							<?php 
								if($var->opt['order_by']=='numero_factura' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='numero_factura' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('cliente')" ><?php echo  _translate("Empresa")?></a>
							<?php 
								if($var->opt['order_by']=='cliente' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='cliente' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('gestor')" ><?php echo  _translate("Gestor")?></a>
							<?php 
								if($var->opt['order_by']=='gestor' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='gestor' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							
						<a href="#" onClick="javascript:orderBy('estado')" ><?php echo  _translate("Estado")?></a>
							<?php 
								if($var->opt['order_by']=='estado' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='estado' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							
						<a href="#" onClick="javascript:orderBy('base_imponible')" ><?php echo  _translate("Base imponible")?></a>
							<?php 
								if($var->opt['order_by']=='base_imponible' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='base_imponible' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('fecha_pago')" ><?php echo  _translate("Fecha de pago")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_pago' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_pago' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>		
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('fecha_facturacion')" ><?php echo  _translate("Fecha de facturación")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_facturacion' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_facturacion' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>	
						
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($facturacion = $var->datos['lista']->siguiente() ){
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
					
						<td style="text-align:center;width:5%;">
							<input class="chk" type=checkbox name="seleccionados[]" value="<?php echo $facturacion->get_Id(); ?>" />							
						</td>
						<td style="text-align:center;width:5%;">
							<a href="<?php echo  $appDir.'/Facturas/showFactura.php?id='.$facturacion->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $facturacion->get_Numero_Factura()?>&nbsp;&nbsp;</a>							
						</td>
						<?php $clientefacturacion = $facturacion->get_Cliente();?>
						<td style="text-align:center;width:5%;">
							<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$clientefacturacion->get_Id();?>"><?php echo $clientefacturacion->get_Razon_Social();?></a>
						</td>	
						<td style="text-align:center;width:5%;">
							<?php echo $facturacion->get_Usuario();?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php  $estado = $facturacion->get_Estado_Factura(); echo $estado['nombre'];?>
						</td>	
						<td style="text-align:center;width:5%;">
							<?php  echo $facturacion->get_Base_Imponible()?>
						</td>					
						<td style="text-align:center;width:5%;">
							<?php  echo timestamp2date($facturacion->get_Fecha_Pago());?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php  echo timestamp2date($facturacion->get_Fecha_Facturacion());?>
						</td>
					</tr>
				<?php 
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
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
					<?php if($gestor_actual->esAdministrador()){?>
					<tr>
						<td colspan="11" style="text-align: right;">
							<a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar seleccionados")?>" /></a>
							<input type="hidden" id="eliminar" name="eliminar" value="0"/>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		<!-- <input type="hidden" name="id_usuario" id="id_usuario" value="<?php  echo $var->opt['id_usuario']?>" /> -->		
		
		</div>

</form>
</div>
<br />
<br />
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>
<?php }
