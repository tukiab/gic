<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_searchProveedores.php');

//Instanciamso la clase busqueda de proveedores.
$var = new BusquedaProveedores($_GET);

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
				$('#frm_proveedores').submit();
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

<div id="titulo"><?php echo  _translate("Proveedores")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<br />
<?php if($permisos->lectura){?>

<div id="contenedor" align="center">
<form id="frm_proveedores" method="GET" action="<?php echo  $_SERVER['_SELF']?>">

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
					<?php echo  _translate('Raz&oacute;n social')?> &nbsp;
				</td>
				<td class="busquedaDcha">
					<input type="text" size="15"name="razon_social" value="<?php  echo $var->opt['razon_social']?>"/>
				</td>
			
				<td class="busquedaIzda">
					<?php echo  _translate('CIF/NIF')?> &nbsp; 
				</td>
				<td class="busquedaDcha">
					<input type="text" size="15"name="NIF" value="<?php  echo $var->opt['NIF']?>"/>
				</td>
			</tr>
			<tr>
				<td class="busquedaIzda">
					<?php echo  _translate('Domicilio')?> &nbsp;
				</td>
				<td class="busquedaDcha"> 
					<input type="text" size="15"name="domicilio" value="<?php  echo $var->opt['domicilio']?>"/>
				</td>
				<td class="busquedaIzda">
					<?php echo  _translate('Provincia')?> &nbsp;
				</td>
				<td class="busquedaDcha"> 
					<input type="text" size="15"name="provincia" value="<?php  echo $var->opt['provincia']?>"/>
				</td>
			</tr>
			<tr>
				<td class="busquedaIzda">
					<?php echo  _translate('N&uacute;mero de proveedores por p&aacute;gina')?> &nbsp;
				</td>
				<td class="busquedaDcha"> 
					<input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"/>
				</td>
				<td class="busquedaIzda">
					<?php echo  _translate('CP')?> &nbsp;
				</td>
				<td class="busquedaDcha"> 
					<input type="text" size="15"name="CP" value="<?php  echo $var->opt['CP']?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" >
					<input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar")?>" />
					<input type="hidden" name="navigation" value="" />
					<input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
					<input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_proveedores']->num_Resultados();?>" />
					<!-- Criterios de ordenación -->
					<input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
					<input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
				</td>
			</tr>
	</table>
</div>
<br/>
<label class="nota"><a href=<?php echo  $appDir.'/Proveedores/addProveedor.php';?>><?php echo  _translate("A&tilde;nadir proveedor nuevo")?></a></label><br/>
<br/>
<!-- RESULTADOS -->
		<div class="listado" style="width:94%;margin-left:2em;">
		<label class="nota"><?php  echo $var->datos['lista_proveedores']->num_Resultados()." ".Resultados?></label>
			<table>
				<thead>
					<tr>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<input type=checkbox id="chk_todos"/>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('NIF')" ><?php echo  _translate("NIF")?></a>
							<?php 
								if($var->opt['order_by']=='NIF' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='NIF' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('razon_social')" ><?php echo  _translate("Raz&oacute;n social")?></a>
							<?php 
								if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<?php echo  _translate("CP")?>
						</th>	
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('localidad')" ><?php echo  _translate("Localidad")?></a>
							<?php 
								if($var->opt['order_by']=='localidad' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='localidad' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>					
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Web")?></th>		
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($proveedor = $var->datos['lista_proveedores']->siguiente() ){ ?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?> >
					
						<td style="text-align:center;width:5%;">
							<input class="chk" type=checkbox name="seleccionados[]" value="<?php echo $proveedor->get_NIF(); ?>" />							
						</td>
						<td style="text-align:center;width:5%;">
							<a href="<?php echo  $appDir.'/Proveedores/showProveedor.php?NIF='.$proveedor->get_NIF(); ?>">&nbsp;&nbsp;<?php  echo $proveedor->get_NIF()?>&nbsp;&nbsp;</a>							
						</td>	
						<td style="text-align:center;width:5%;">
							<?php  echo $proveedor->get_Razon_Social()?>
						</td>
						
						<td style="text-align:center;width:5%;">
							<?php  echo $proveedor->get_CP()?>
						</td>
						
						<td style="text-align:center;width:5%;">
							<?php  echo $proveedor->get_Localidad()?>
						</td>
						
						<td style="text-align:center;width:5%;">
							<?php  echo web($proveedor->get_Web());?>
						</td>
											
					</tr>
				<?php 
				}?>	
					<tr>	
						<td><?php echo  $var->datos['lista_proveedores']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?></td>
						<td colspan="9">
						<div style="display:inline;position:absolute;">
						<?php if($var->datos['page']>1){?>
							<a href="javaScript:repagina('Inicio')" title="<?php echo  _translate("Ir a la Primera")?>"><<</a> &nbsp;
							<a href="javaScript:repagina('Anterior')" title="<?php echo  _translate("Ir a la Anterior")?>"><</a> &nbsp;
						<?php }?>
							<?php echo  "P&aacute;gina ";echo  ($var->datos['page']/$var->datos['paso'])+1 ." de ".$var->datos['lastPage']?> &nbsp;
						<?php if((($var->datos['page']/$var->datos['paso'])+1) < $var->datos['lastPage']){?>
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
				<?php if($permisos->administracion && $var->gestor->esAdministradorTotal()){?>
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