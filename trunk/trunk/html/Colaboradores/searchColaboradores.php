<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_searchColaboradores.php');

//Instanciamso la clase busqueda de colaboradores.
$var = new BusquedaColaboradores($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

?>
<?php if($permisos->lectura){?>
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
			if(confirm('¿Eliminar los colaboradores seleccionados?')){
				$('#eliminar').val(1);
				$('#frm_colaboradores').submit();
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

<div id="titulo"><?php echo  _translate("Colaboradores")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<div id="contenedor" align="center">
<form method="GET" id="frm_colaboradores" action="<?php echo  $_SERVER['_SELF']?>">

<!-- RESULTADOS -->
		<div class="listado" >
		<label class="nota"><?php  echo $var->datos['lista_colaboradores']->num_Resultados()." ".Resultados?></label>
		<?php if($permisos->administracion && false){?><input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" /><?php }?>
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
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("NIF")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<a href="#" onClick="javascript:orderBy('razon_social')" ><?php echo  _translate("Raz&oacute;n social")?></a>
							<?php 
								if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='ASC')
									echo  "&uarr;";
								else if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='DESC')
									echo  "&darr;";
							?>
						</th>
						
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Comisi&oacute;n")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Comisi&oacute;n por renovaci&oacute;n")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("CC pago comisiones")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<?php echo  _translate("Localidad")?>
						</th>
                                                <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
							<?php echo  _translate("Provincia")?>
						</th>
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Domicilio")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("CP")?></th>
						<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Contactos")?></th>
					</tr>
				</thead>
				<tbody>
				<?php $fila_par=true;
				?>
				<?php while($colaborador = $var->datos['lista_colaboradores']->siguiente() ){
                                        if($colaborador->get_Id() != 1){
					
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>
					
						<td>
							<input class="chk" type=checkbox name="seleccionados[]" value="<?php echo $colaborador->get_Id(); ?>" />							
						</td>
						<td><?php $url_dest = $appDir.'/Colaboradores/editColaborador.php?id='.$colaborador->get_Id(); ?>
							<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest;?>','<?php echo  rand();?>','width=600,height=460,scrollbars=yes');">&nbsp;&nbsp;<?php  echo $colaborador->get_Id();?>&nbsp;&nbsp;</a>							
						</td>	
						<td>
							<?php  echo $colaborador->get_NIF()?>
						</td>
						<td>
							<?php  echo $colaborador->get_Razon_Social()?>
						</td>
						<td>
							<?php  echo $colaborador->get_Comision()?>
						</td>
						<td>
							<?php  echo $colaborador->get_Comision_Por_Renovacion()?>
						</td>
						<td>
							<?php  echo $colaborador->get_CC_Pago_Comisiones()?>
						</td>
						<td>
							<?php  echo $colaborador->get_Localidad()?>
						</td>
                                                <td>
							<?php  echo $colaborador->get_Provincia()?>
						</td>
						<td>
							<?php  echo $colaborador->get_domicilio()?>
						</td>
						<td>
							<?php  echo $colaborador->get_CP()?>
						</td>
						<td>
						<?php if($permisos->administracion){?>
							<?php $url_dest = $appDir."/Colaboradores/editContactos.php?id=".$colaborador->get_Id();?>
							<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=500,scrollbars=yes');">
						<?php }?>
						<?php  foreach($colaborador->get_Lista_Contactos() as $contacto)
							echo $contacto->get_Nombre()."<br/>"?>
							</a></label>
						</td>
						
					</tr>
				<?php }
				}?>	
					<tr>	
						<td>
							<?php echo  $var->datos['lista_colaboradores']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
						</td>
						<td colspan="13">
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
					<?php $usuario = new Usuario($_SESSION['usuario_login']); if($permisos->administracion && $usuario->esAdministradorTotal()){?>
					<tr>
						<td colspan="14" style="text-align: right;">
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
<?php 
include($appRoot.'/Common/php/bottomMenu.php');
include ($appRoot.'/Common/php/footer.php');
?>
<?php }

// ----- Â¡Â¡VAMONOS QUE NOS VAMOS A EXPORTAR!! ----- //
else{ 

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
	<thead>
		<tr>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Id")?>
			</th>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Razon social")?>
			</th>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Tipo")?>				
			</th>
			<th style="text-align: center;font-size: x-small;font-weight: normal">
				<?php echo  _translate("Grupo de empresas")?></th>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Localidad")?>
			</th>	<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Provincia")?>
			</th>
			<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("CP")?></th>
			<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Web")?></th>
			<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Sector")?></th>
			<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("SPA Actual")?></th>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
				<?php echo  _translate("Fecha de renovacion")?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $fila_par=true;
	?>
	<?php while($colaborador = $var->datos['lista_colaboradores']->siguiente() ){
		$tipo = $colaborador->get_Tipo_Colaborador();
		$resaltado = "";
		if($tipo['id'] == 2)
			$resaltado = 'style="font-weight:bold;"';
	?>
		<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>
			<td>
				<?php  echo $colaborador->get_Id()?>&nbsp;&nbsp;							
			</td>	
			<td>
				<?php  echo $colaborador->get_Razon_Social()?>
			</td>
			<td>
				<?php  echo  $tipo['nombre'];?>
			</td>
			<td>
				<?php  $grupo = $colaborador->get_Grupo_Empresas(); echo  $grupo['nombre'];?>
			</td>
			<td>
				<?php  echo $colaborador->get_Localidad()?>
			</td>
                        <td>
				<?php  echo $colaborador->get_Provincia()?>
			</td>
			<td>
				<?php  echo $colaborador->get_CP()?>
			</td>
			<td>
				<?php  echo $colaborador->get_Web()?>
			</td>
			<td>
				<?php  echo $colaborador->get_Sector()?>
			</td>
			<td>
				<?php  echo $colaborador->get_SPA_Actual()?>
			</td>
			<td>
				<?php  echo timestamp2date($colaborador->get_Fecha_Renovacion())?>
			</td>					
		</tr>
	<?php 
	}?>	
		
	</tbody>
</table>
<?php }?>

<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>