<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_index.php');

//Instanciamso la clase busqueda de visitas.
$var = new BusquedaVisitas($_GET);

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
				$('#frm_visitas').submit();
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

<div id="titulo"><?php echo  _translate("Planificaci&oacute;n")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>

<?php if($permisos->escritura){?>
<div id="contenedor" align="center">
<form method="GET" id="frm_visitas" action="<?php echo  $_SERVER['_SELF']?>">

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
				<input type="text" size="15"name="nombre_cliente" value="<?php  echo $var->opt['nombre_cliente']?>"/>
			</td>
			<td class="busquedaIzda">
				<?php echo  _translate('Nombre de proyecto contiene')?> &nbsp;
			</td>
			<td class="busquedaDcha">
				<input type="text" size="15"name="nombre_proyecto" value="<?php  echo $var->opt['nombre_proyecto']?>"/>
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
				<?php echo  _translate('N&uacute;mero por p&aacute;gina')?> &nbsp;
			</td>
			<td class="busquedaDcha"> 
				<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"/>
			</td>
				<td class="busquedaIzda" <?php if(!$permisos->administracion) echo 'style="display:none"';?>>
				<?php echo  _translate('Gestor')?> &nbsp;
			</td>
			<td class="busquedaDcha" <?php if(!$permisos->administracion) echo 'style="display:none"';?>>
				<select name="gestor">
					<?php 
					$gestor_seleccionado = $var->opt['gestor'];?>
					<option value="" ><?php echo  _translate("Cualquiera")?></option>
					<?php foreach($var->datos['lista_gestores'] as $gestor){?>
					<option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $gestor['id']?></option>
					<?php }?> 
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align:right;background: none;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_visitas']->num_Resultados();?>" />
				<!-- Criterios de ordenaci&oacute;n -->
				<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
				<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
			</td>
		</tr>
	</table>
</div>
<br/>
<!-- RESULTADOS -->
		<div class="listado" style="width:94%;margin-left:2em;">
		<label class="nota"><?php  echo $var->datos['lista_visitas']->num_Resultados()." ".Resultados?></label>
		<?php if($permisos->administracion){?><!-- <input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /> --><?php }?>
			<table>
				<thead>
					<tr>
						<th >
							<?php echo  _translate("A&ntilde;o")?>
						</th>
						<th >
							<?php echo  _translate("Mes")?>
						</th>
						<th >
							<?php echo  _translate("D&iacute;a")?>
						</th>
						<th >
							<?php echo  _translate("Hora")?>
						</th>
						<th >
							<?php echo  _translate("N&uacute;mero")?>
						</th>
						<th >
							<?php echo  _translate("T&eacute;cnico")?>
						</th>
						<th >
							<?php echo  _translate("Proyecto")?>
						</th>
						<th >
							<?php echo  _translate("Empresa")?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($visita = $var->datos['lista_visitas']->siguiente() ){
					$pro = $visita->get_Proyecto();
					$proyecto = new Proyecto($pro['id']);
					$style_laborable = "";
					if(!esLaborable($visita->get_Fecha()))
						$style_laborable = 'background: red';
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> style="<?php echo $style_laborable?>">
						<td style="text-align:center;width:5%;">
							<?php echo date("Y",$visita->get_Fecha());?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo get_Nombre_Mes($visita->get_Fecha());?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo get_Nombre_Dia_Semana($visita->get_Fecha());?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo $visita->get_Hora();?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo date("d",$visita->get_Fecha());?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo $visita->get_Usuario();?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php echo $proyecto->get_Nombre();?>
						</td>
						<td style="text-align:center;width:5%;">
							<?php $cliente = $proyecto->get_Cliente(); echo $cliente->get_Razon_Social();?>
						</td>
					</tr>
				<?php 
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista_visitas']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
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
<?php } ?>