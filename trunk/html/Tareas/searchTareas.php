<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_searchTareas.php');

//Instanciamso la clase busqueda de tareas.
$var = new BusquedaTareas($_GET);
//FB::info($var);
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
				$('#frm_tareas').submit();
			}		
		}
</script>

<div id="titulo"><?php echo  _translate("Tareas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<?php if($permisos->escritura){?>
<div id="contenedor" align="center">
<form method="GET" id="frm_tareas" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->

<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small"> <?php echo  _translate("Mostrar/Ocultar opciones de b&uacute;squeda")?></a></i><br/>
<div id="opcionesBusqueda">
	<table>
		<tr class="BusquedaTable">
			<td colspan="6" class="ListaTitulo">
				<div style="float:left"><?php echo  _translate("Opciones de b&uacute;squeda")?></div>
			</td>
		</tr>		
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Raz&oacute;n social de empresa contiene')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="razon_social" value="<?php  echo $var->opt['razon_social']?>"/>
			</td>
			<td class="busquedaIzda">
				<?php //echo  _translate('Id tarea')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<!-- <input type="text" size="15"name="id" value="<?php  echo $var->opt['id']?>"/> -->
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('Observaciones contiene')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="observaciones" value="<?php  echo $var->opt['observaciones']?>"/>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Tipo de tarea')?>
			</td>
			<td class="busquedaDcha">
				<select name="tipo_tarea">
				<?php 
				$tipo_seleccionado = $var->opt['tipo_tarea'];?>
				<option value="0" <?php if($tipo_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
				<?php foreach($var->datos['lista_tipos_tareas'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
				</select>
			</td>
		</tr>
		
		
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_desde" value="<?php  echo timestamp2date($var->opt['fecha_desde'])?>"/>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_hasta" value="<?php  echo timestamp2date($var->opt['fecha_hasta'])?>"/>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda">
				<?php echo  _translate('N&uacute;mero de tareas por p&aacute;gina')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"/>
			</td>
				<td class="busquedaIzda" <?php $perfil = $var->gestor->get_Perfil(); if(!$permisos->administracion) echo 'style="display:none"';?>>
				<?php echo  _translate('Usuario')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php  if(!$permisos->administracion ) echo 'style="display:none"';?>>
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
			<td colspan="4" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_tareas']->num_Resultados();?>" />
				<!-- Criterios de ordenaci&oacute;n -->
				<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
				<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
			</td>
		</tr>
	</table>
</div>
<br/>
<!-- RESULTADOS -->
		<div class="listado">
		<label class="nota"><?php  echo $var->datos['lista_tareas']->num_Resultados()." ".Resultados?></label>
		<?php if($permisos->administracion){?><!-- <input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /> --><?php }?>
			<table>
				<thead>
					<tr>
						<!--<th  nowrap>
							<a href="#" onClick="javascript:orderBy('id')" ><?php echo  _translate("Id")?></a>
							<?php 
								if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>-->
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('id_usuario')" ><?php echo  _translate("Gestor")?></a>
							<?php 
								if($var->opt['order_by']=='id_usuario' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='id_usuario' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('tipo_tarea')" ><?php echo  _translate("Tipo")?></a>
							<?php 
								if($var->opt['order_by']=='tipo_tarea' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='tipo_tarea' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('id_proyecto')" ><?php echo  _translate("Proyecto")?></a>
							<?php
								if($var->opt['order_by']=='id_proyecto' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='id_proyecto' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('id_cliente')" ><?php echo  _translate("Empresa")?></a>
							<?php 
								if($var->opt['order_by']=='id_cliente' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='id_cliente' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('fecha')" ><?php echo  _translate("Fecha")?></a>
							<?php 
								if($var->opt['order_by']=='fecha' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='fecha' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>		
						<th  nowrap>
							<?php echo  _translate("Observaciones")?>
						</th>	
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('horas_desplazamiento')" ><?php echo  _translate("Horas de desplazamiento")?></a>
							<?php 
								if($var->opt['order_by']=='horas_desplazamiento' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='horas_desplazamiento' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>	
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('horas_visita')" ><?php echo  _translate("Horas de visita")?></a>
							<?php 
								if($var->opt['order_by']=='horas_visita' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='horas_visita' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>	
						<th  nowrap>
							<a href="#" onClick="javascript:orderBy('horas_despacho')" ><?php echo  _translate("Horas de despacho")?></a>
							<?php 
								if($var->opt['order_by']=='horas_despacho' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='horas_despacho' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>	
						<!--<th  nowrap>
							<a href="#" onClick="javascript:orderBy('horas_auditoria_interna')" ><?php echo  _translate("Horas de auditor&iacute;a")?></a>
							<?php 
								if($var->opt['order_by']=='horas_auditoria_interna' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='horas_auditoria_interna' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>-->
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($tarea = $var->datos['lista_tareas']->siguiente() ){
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
						<!--<td >
							<a href="<?php echo  $appDir.'/Tareas/showTarea.php?id='.$tarea->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $tarea->get_Id()?>&nbsp;&nbsp;</a>							
						</td>-->
						<td >
							<?php echo $tarea->get_Id_Usuario();?>
						</td>
						<td >
							<?php  $tipo = $tarea->get_tipo(); echo $tipo['nombre'];?>
						</td>
						<td>
							<?php $proyecto = $tarea->get_Proyecto(); ?>
							<a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id(); ?>"><?php echo $proyecto->get_Nombre(); ?>&nbsp;&nbsp;</a>
						</td>
						<td >
						<?php $cliente = $proyecto->get_Cliente(); ?>
							<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id();?>"><?php  echo $cliente->get_Razon_Social();?></a>
						</td>						
						<td >
							<?php  echo timestamp2date($tarea->get_Fecha());?>
						</td>
						<td >
							<?php  echo $tarea->get_Observaciones();?>
						</td>
						<td >
							<?php  echo $tarea->get_Horas_Desplazamiento();?>
						</td>
						<td >
							<?php  echo $tarea->get_Horas_Visita();?>
						</td>
						<td >
							<?php  echo $tarea->get_Horas_Despacho();?>
						</td>
						<!--<td >
							<?php  echo $tarea->get_Horas_Auditoria_Interna();?>
						</td>-->
					</tr>
				<?php 
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista_tareas']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
						</td>
						<td colspan="14">
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
					<!--<tr>
						<td colspan="11" style="text-align: right;">
							<a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar seleccionados")?>" /></a>
							<input type="hidden" id="eliminar" name="eliminar" value="0"/>
						</td>
					</tr>-->
					<?php }?>
				</tbody>
			</table>	
		</div>

</form>
</div>
<br />
<br />

<?php } ?>
<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>
<?php 
include($appRoot.'/Common/php/bottomMenu.php');
include ($appRoot.'/Common/php/footer.php');
?>