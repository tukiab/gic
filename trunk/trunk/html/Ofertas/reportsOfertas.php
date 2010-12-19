<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_reportsOfertas.php');

//Instanciamso la clase busqueda de ofertas.
$var = new InformesOfertas($_GET);
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
				if (obj.value.reports("[.*]") == -1 && obj.value.length != 0)
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
				$('#frm_ofertas').submit();
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

<div id="titulo"><?php echo  _translate("Ofertas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<div id="contenedor" align="center">
<form method="GET" id="frm_ofertas" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->

<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small"> <?php echo  _translate("Mostrar/Ocultar opciones de búsqueda")?></a></i><br/>
<div id="opcionesBusqueda">
	<table>
		<tr class="BusquedaTable">
			<td colspan="6" class="ListaTitulo">
				<div style="float:left"><?php echo  _translate("Opciones de búsqueda")?></div>
			</td>
		</tr>		
		<tr>			
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha desde')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_desde" value="<?php  echo timestamp2date($var->opt['fecha_desde'])?>"></input>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Fecha hasta')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" class="fecha" size="12" name="fecha_hasta" value="<?php  echo timestamp2date($var->opt['fecha_hasta'])?>"></input>
			</td>
		</tr>
		<tr>
			<td class="busquedaIzda" <?php if(!$gestor_actual->esAdministrador()) echo 'style="display:none"';?>>
				<?php echo  _translate('Gestor')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php if(!$gestor_actual->esAdministrador()) echo 'style="display:none"';?>> 
				<select name="id_usuario">
					<?php 
					$gestor_seleccionado = $var->opt['id_usuario'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Todos")?></option>
					<?php foreach($var->datos['lista_gestores'] as $gestor){?>
					<option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $gestor['id']?></option>
					<?php }?> 
				</select>
			</td>
			<td colspan="2" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="buscar" value="<?php echo  _translate("Buscar")?>" />
			</td>
		</tr>
	</table>
</div>
<br/>
<!-- RESULTADOS -->
		<div class="listado" style="width:94%;margin-left:2em;">
		
			<?php 
					
					$totales = array();
				?>
				<?php foreach($var->datos['informes_usuarios'] as $informe_usr){
					$total_ofertas = $informe_usr['total_ofertas_usuario'];
					$total_clientes = $informe_usr['total_clientes_usuario'];					
					
					?>
					<table>
						<thead>
							<tr>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Usuario"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Tipo producto"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Número ofertas"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									%
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Número de empresas"); ?>
								</th>		
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									%
								</th>	
							</tr>
						</thead>
						<tbody>							
							<?php $primero = true;$fila_par=true;
								foreach($informe_usr['informes'] as $informe_tipo_oferta){ ?>
								<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>	
									<?php 
										$tipo_oferta = $informe_tipo_oferta['tipo'];
										$num_ofertas = $informe_tipo_oferta['num_ofertas'];
										$num_clientes = $informe_tipo_oferta['num_clientes'];
										
									?>
										<td style="text-align:center;width:5%;">
											<?php if($primero) echo "<b>".$informe_usr['id_usuario']."</b>"; $primero=false;?>		
										</td>
										<td style="text-align:center;width:5%;">
											<?php echo $tipo_oferta; ?>
										</td>
										<td style="text-align:center;width:5%;">
											<?php echo $num_ofertas; ?>
										</td>
										<td style="text-align:center;width:5%;">
											<?php if($total_ofertas)echo substr($num_ofertas*100/$total_ofertas,0,4)."%"; ?>		
										</td>
										<td style="text-align:center;width:5%;">
											<?php echo $num_clientes; ?>				
										</td>
										<td style="text-align:center;width:5%;">
											<?php if($total_ofertas) echo  substr($num_clientes*100/$total_clientes,0,4)."%"; ?>
										</td>							
									<?php 
										$totales[$tipo_oferta]['num_ofertas'] += $num_ofertas;
										$totales[$tipo_oferta]['num_clientes'] += $num_clientes;
									} ?>
									
								</tr>
								<tr>
									<td style="text-align:center;width:5%;">Total</td><td></td>
									<td style="text-align:center;width:5%;"><?php echo  $total_ofertas;?></td>
									<td></td>
									<td style="text-align:center;width:5%;"><?php echo  $total_clientes;?></td>
									<td></td>
								</tr>
							</tbody>
						</table>
				<?php 
					$totales['ofertas'] += $total_ofertas;
					$totales['clientes'] += $total_clientes;
				}?>	
					<!-- TOTALES -->
					<?php
						$total_ofertas = $totales['ofertas'];
						$total_clientes = $totales['clientes'];
					?>
					
					<table>
						<thead>
							<tr>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Totales"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Tipo producto"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Número ofertas"); ?>
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									%
								</th>
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									<?php echo _translate("Número de empresas"); ?>
								</th>		
								<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
									%
								</th>	
							</tr>
						</thead>
						<tbody>	
					<?php $primero = true;$fila_par=true;
					if($var->opt['buscar'])
					 foreach($informe_usr['informes'] as $informe_tipo_oferta){ ?>
					
					<?php 
						$tipo_oferta = $informe_tipo_oferta['tipo'];
						$num_ofertas = $totales[$tipo_oferta]['num_ofertas'];
						$num_clientes = $totales[$tipo_oferta]['num_clientes'];
					?>			
							<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
								<td style="text-align:center;width:5%;">
									<?php if($primero) echo "<b>TOTALES</b>"; $primero=false;?>
								</td>
								<td style="text-align:center;width:5%;">
									<?php echo $tipo_oferta; ?>
								</td>
								<td style="text-align:center;width:5%;">
									<?php echo $num_ofertas; ?>
								</td>
								<td style="text-align:center;width:5%;">
									<?php if($total_ofertas)echo substr($num_ofertas*100/$total_ofertas,0,4)."%"; ?>		
								</td>
								<td style="text-align:center;width:5%;">
									<?php echo $num_clientes; ?>				
								</td>
								<td style="text-align:center;width:5%;">
									<?php if($total_ofertas)echo substr($num_clientes*100/$total_clientes,0,4)."%"; ?>
								</td>							
							<?php } ?>
							</tr>
							<tr>
								<td style="text-align:center;width:5%;">Total</td><td></td>
								<td style="text-align:center;width:5%;"><?php echo  $total_ofertas;?></td>
								<td></td>
								<td style="text-align:center;width:5%;"><?php echo  $total_clientes;?></td>
								<td></td>
							</tr>						
		
						</tbody>
					</table>
		</div>
</form>
</div>
<br />
<br />
<?php }?>
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>