<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_searchOfertas.php');

//Instanciamso la clase busqueda de ofertas.
$var = new BusquedaOfertas($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

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
		
		//Ordenación:
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
				$('#frm_ofertas').submit();
			}		
		}
</script>

<div id="titulo"><?php echo  _translate("Ofertas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<?php if($permisos->lectura){?>

<div id="contenedor" align="center">
<form method="GET" id="frm_ofertas" action="<?php echo  $_SERVER['_SELF']?>">

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
				<?php echo  _translate('C&oacute;digo')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="codigo" value="<?php  echo $var->opt['codigo']?>" />
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Nombre')?> &nbsp; 
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="nombre_oferta" value="<?php  echo $var->opt['nombre_oferta']?>" />
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Estado')?>
			</td>
			<td class="busquedaDcha">
				<select name="estado_oferta">
				<?php 
				$estado_seleccionado = $var->opt['estado_oferta'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_estados_ofertas'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_seleccionado) echo  'selected="selected"';?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
				</select>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Tipo de producto')?>
			</td>
			<td class="busquedaDcha">
				<select name="producto">
				<?php 
				$estado_seleccionado = $var->opt['producto'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_tipos_productos'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_seleccionado) echo  'selected="selected"';?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
				</select>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Proveedor')?>
			</td>
			<td class="busquedaDcha">
				<select name="proveedor">
				<?php 
				$estado_seleccionado = $var->opt['proveedor'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_proveedores_ofertas'] as $estado){?>
				<option value="<?php  echo $estado['NIF']?>" <?php if($estado['NIF'] == $estado_seleccionado) echo  'selected="selected"';?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
				</select>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Probabilidad de contrataci&oacute;n')?>
			</td>
			<td class="busquedaDcha">
				<select name="probabilidad_contratacion">
				<?php 
				$estado_seleccionado = $var->opt['probabilidad_contratacion'];?>
				<option value="0" <?php if($estado_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_probabilidades'] as $estado){?>
				<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_seleccionado) echo  'selected="selected"';?>><?php  echo $estado['nombre']?></option>
				<?php }?> 
				</select>
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('N&uacute;mero desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="codigo_desde" value="<?php  echo ($var->opt['codigo_desde'])?>" />
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('N&uacute;mero hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="codigo_hasta" value="<?php  echo ($var->opt['codigo_hasta'])?>" />
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_desde" value="<?php  echo timestamp2date($var->opt['fecha_desde'])?>" />
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_hasta" value="<?php  echo timestamp2date($var->opt['fecha_hasta'])?>" />
			</td>
		</tr>
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de definici&oacute;n desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_definicion_desde" value="<?php  echo timestamp2date($var->opt['fecha_definicion_desde'])?>" />
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha de definici&oacute;n hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_definicion_hasta" value="<?php  echo timestamp2date($var->opt['fecha_definicion_hasta'])?>" />
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Importe desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="importe_desde" value="<?php  echo$var->opt['importe_desde']?>" />
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Importe hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="12" name="importe_hasta" value="<?php  echo $var->opt['importe_hasta']?>" />
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('N&uacute;mero de ofertas por p&aacute;gina')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>" />
			</td>
				<td class="busquedaIzda" <?php $perfil = $var->gestor->get_Perfil(); if(!$permisos->administracion && !esPerfilTecnico($perfil['id'])) echo 'style="display:none"';?>>
				<?php echo  _translate('Gestor')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php if(!$permisos->administracion && !esPerfilTecnico($perfil['id'])) echo 'style="display:none"';?>>
				<select name="gestor">
					<?php 
					$gestor_seleccionado = $var->opt['gestor'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
					<?php foreach($var->datos['lista_gestores'] as $gestor){?>
					<option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  'selected="selected"';?>><?php  echo $gestor['id']?></option>
					<?php }?> 
				</select>
			</td>
		</tr>
		
		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Oferta/Oportunidad')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<select name="es_oportunidad_de_negocio">
					<?php 
					$oferta_seleccionado = $var->opt['es_oportunidad_de_negocio'];?>
					<option value="2" <?php if($oferta_seleccionado == 2) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
					<option value="0" <?php if($oferta_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Ofertas")?></option>
					<option value="1" <?php if($oferta_seleccionado == 1) echo  'selected="selected"';?>><?php echo  _translate("Oportunidades")?></option>
				</select>
			</td>
			<td colspan="2" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_ofertas']->num_Resultados();?>" />
				<!-- Criterios de ordenaci&uacute;n -->
				<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
				<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
			</td>
		</tr>
	</table>
</div>
<br/>

<!-- RESULTADOS -->
		<div class="listado">
		<label class="nota"><?php  echo $var->datos['lista_ofertas']->num_Resultados()." ".Resultados?></label>
		<?php if($permisos->administracion){//if($permisos->administracion){?><!-- <input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /> --><?php }?>
			<table>
				<thead>
					<tr>
						<th >
							<input type=checkbox id="chk_todos"/>
						</th>
						<th >
							<a href="#" onClick="javascript:orderBy('codigo')" ><?php echo  _translate("C&oacute;digo")?></a>
							<?php 
								if($var->opt['order_by']=='codigo' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='codigo' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th ><?php echo _translate("Raz&oacute;n social empresa");?></th>
						<th ><?php echo _translate("Gestor");?></th>
						<th ><?php echo _translate("Tipo");?></th>
						<th >
							<a href="#" onClick="javascript:orderBy('nombre_oferta')" ><?php echo  _translate("Nombre")?></a>
							<?php 
								if($var->opt['order_by']=='nombre_oferta' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='nombre_oferta' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th >
							<?php echo  _translate("Estado")?>
						</th>	
						<th ><?php echo _translate("Importe");?></th>
						<th >
							<a href="#" onClick="javascript:orderBy('fecha')" ><?php echo  _translate("Fecha")?></a>
							<?php 
								if($var->opt['order_by']=='fecha' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>		
						<th >
							<a href="#" onClick="javascript:orderBy('fecha_definicion')" ><?php echo  _translate("Fecha de definici&oacute;n")?></a>
							<?php 
								if($var->opt['order_by']=='fecha_definicion' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha_definicion' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>	
						<!--<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Operaciones")?></th>-->	
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($oferta = $var->datos['lista_ofertas']->siguiente() ){
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
					
						<td>
							<input class="chk" type=checkbox name="seleccionados[]" value="<?php echo $oferta->get_Id(); ?>" />							
						</td>
						<td>
							<a href="<?php echo  $appDir.'/Ofertas/showOferta.php?id='.$oferta->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $oferta->get_Codigo()?>&nbsp;&nbsp;</a>							
						</td>
						<?php $clienteoferta = $oferta->get_Cliente();?>
						<td>
							<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$clienteoferta->get_Id();?>"><?php echo $clienteoferta->get_Razon_Social();?></a>
						</td>	
						<td>
							<?php echo $oferta->get_Usuario();?>
						</td>
						<td>
							<?php  $es_oportunidad = $oferta->get_Es_Oportunidad_De_Negocio(); if($es_oportunidad) echo _translate("Oportunidad de negocio"); else echo _translate("Oferta");?>
						</td>
						<td>
							<?php  echo $oferta->get_Nombre_Oferta()?>
						</td>
						<td>
							<?php  $estado = $oferta->get_Estado_Oferta(); echo $estado['nombre'];?>
						</td>	
						<td>
							<?php  echo $oferta->get_Importe()?>
						</td>					
						<td>
							<?php  echo timestamp2date($oferta->get_Fecha());?>
						</td>
						<td>
							<?php  echo timestamp2date($oferta->get_Fecha_Definicion());?>
						</td>
					</tr> 
				<?php 
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista_ofertas']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
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
					<?php if($permisos->administracion  && $var->gestor->esAdministradorTotal() ){?>
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
include($appRoot.'/Common/php/bottomMenu.php');
include ($appRoot.'/Common/php/footer.php');
?>
<?php }?>