<?	include ('appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
	include ($appRoot.'/Utils/lang.php');

include ($appRoot.'/Problemas/_busqueda.php');
//Opciones
	(empty($_GET['estado']))?$arrayOpciones['estado'] = 'x':null;
	$arrayOpciones['operador'] = $_SESSION['usuario_login'];
	$arrayOpciones['mostrar'] = '1';
	$opciones = array_merge($arrayOpciones, $_GET);	
	$var = new Busqueda($opciones);
	
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>
<!-- Funciones varias para mejorar la interfaz -->
<script language="JavaScript" type="text/javascript" src="js/sortable/common.js"></script>
<script language="JavaScript" type="text/javascript" src="js/sortable/css.js"></script>
<script language="JavaScript" type="text/javascript" src="js/sortable/standardista-table-sorting.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
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
	//-->
</script>

<table width="100%">
	<tr>
		<td class="TituloPag" nowrap><?_translate("B&uacute;squeda de problemas")?></td>
	</tr>
</table>
<div id="serverMessage" style="position:absolute;top:140px;right:5px;color:#FFFFFF;background-color:#CC0033;font-size:x-small;font-weight:bold;width:350px;">
	<?_translate($var->error)?>
</div>
<br />
<form method="GET" action="<?echo  $_SERVER['PHP_SELF']?>">

<!-- Lista de Problemas -->
<div style="position:relative;width:70%;left:5%;margin-top:0em;overflow:visible;text-align:left;">
	<table style="width:99%;">
		<tr class="MenuTable">
			<td colspan="6" class="ListaTitulo"><?_translate("Opciones de b&uacute;squeda")?></td>
		</tr>
		<tr class="MenuTable">
			<td><?_translate("C&oacute;digo Pr.")?></td>
			<td><?_translate("Tipo")?></td>
			<td><?_translate("Estado")?></td>
			<td><?_translate("Prioridad")?></td>
			<td><?_translate("Asignada a")?></td>
			<td rowspan="2" style="vertical-align:bottom;text-align:right;" >
				<input type="submit" id="mostrar" name="mostrar" value="<?_translate("Actualizar")?>" />
				<input type="hidden" name="navigation" value="" />
				<input type="hidden" name="page" value="<?echo  $var->datos['page']?>" />
				<input type="hidden" name="total" id="total" value="<?php echo  $var->datos['lista_Problemas']->num_Resultados();?>" />
			</td>
		</tr>
		<tr class="MenuTable">
			<td>
				<input type="text" id="codigo" name="id_problema" style="width:8em;text-align:right;" value="<?echo  $var->opt['id_problema']?>" />
			</td>
			<td>
				<select id="tipo" name="tipo" style="width:8em;">
					<option value=""><?_translate("Cualquier")?></option>
					<?foreach ($var->datos['lista_Tipos'] as $tipo){?>
						<option value="<?echo  $tipo['id']?>"
							<?if( ($tipo['id']==$var->opt['tipo']) )
								echo  'selected';?> >
							<?echo  ucfirst($tipo['nombre'])?>
						</option>';
					<?}?>
                 </select>
                 
			</td>
			<td>
				<select id="estado" name="estado" style="width:8em;">
					<option value="x"<?if(!isset($var->opt['estado'])||$var->opt['estado']=='x'){echo  'selected';}?>><?_translate("No cerrado")?></option>
					<option value="0"<?if(!isset($var->opt['estado'])&&$var->opt['mostrar']=='Actualizar') echo  'selected'?>><?_translate("Todos");?></option>
					<?foreach ($var->datos['lista_Estados'] as $estado){?>
						<option value="<?echo  $estado['id']?>"
							<?if($estado['id']==$var->opt['estado'])
								echo  'selected'?> >
							<?echo  $estado['nombre']?>
						</option>
					<?}?>
                 </select>
                 <?echo  $var->opt['estado_aux']?>
			</td>
			<td>
				<select id="prioridad" name="prioridad" style="width:8em;">
					<option value=""><?_translate("Todas")?></option>
					<?foreach($var->datos['lista_Prioridades'] as $prioridad){?>
						<option value="<?echo  $prioridad['id']?>"
							<?if( ($prioridad['id']==$var->opt['prioridad']) )
								echo  'selected';?> >
							<?echo  $prioridad['nombre']?>
						</option>
					<?}?>
                 </select>
			</td>
			<td>
				<select id="operador" name="operador" style="width:12em;">
					<option value=""><?_translate("Cualquiera")?></option>
					<option value="x" <?if( ($var->opt['operador']=='x') )
								echo  'selected';?> ><?_translate("No asignada")?></option>
					<?foreach($var->datos['lista_Operadores'] as $opaux){?>
						<option value="<?echo  $opaux['id']?>"
							<?if( ($opaux['id']==$var->opt['operador']) )
								echo  'selected';?> >
							<?echo  $opaux['nombre']?>
						</option>';
					<?}?>
                 </select>
			</td>
		</tr>
		<tr class="MenuTable">
			<td colspan="6" style="text-align:right;">
				<?_translate("M&aacute;s opciones")?>
				<input type="checkbox" id="mas_opciones" name="mas_opciones" onChange="show_opt('opt_avanzadas', this)" 
					<?if($var->opt['mas_opciones']) echo  "checked"?>/>
			</td>
		</tr>
		<tr>
			<td  colspan="5">
				<div id="opt_avanzadas" style="visibility:collapse;display:none;">
					<table class="MenuTable" style="width:100%;margin-left:0;">
						<tr>
							<td class="ListaTitulo" style="width:30%;text-align:left;" nowrap colspan="2">
								<?_translate("Que contenga:")?>
							</td>
							<td class="ListaTitulo" style="width:30%;text-align:left;" nowrap>
								<?_translate("Incidencias/Sedes asociadas")?>
							</td>							
						</tr>
						<tr>
							<td nowrap><?_translate("Alguna de las palabras:")?></td>
							<td><br /><input type="input" name="alguna" size="40"
								 <?if($var->opt['alguna']!='')echo  "value=\"".$var->opt['alguna']."\"";?>/>
							</td>
							<td rowspan="3" nowrap>
								<?_translate("C&oacute;digo Incidencia")?>:&nbsp;&nbsp;<input type="text" id="inc" name="inc" style="width:8em;" value="<?echo  $var->opt['id_inci']?>" />
								<br />
								<br />
								<?_translate("C&oacute;digo Centro")?>:&nbsp;&nbsp;<input type="text" id="cod_centro" name="cod_centro" style="width:8em;" value="<?echo  $var->opt['centro']?>" />
								<br />
								<br />
								<?_translate("C&oacute;digo Sede")?>:&nbsp;&nbsp;<input type="text" id="cod_sede" name="cod_sede" style="width:8em;" value="<?echo  $var->opt['sede']?>" />
							</td>
						</tr>
						<tr><td nowrap><?_translate("Ninguna de las palabras:")?></td>
							<td><br /><input type="input" name="ninguna" size="40" 
								<?if($var->opt['ninguna']!='')echo  "value=\"".$var->opt['ninguna']."\"";?>/>
							</td>
						</tr>
						<tr><td nowrap><?_translate("Todas las palabras:")?></td>
							<td><br /><input type="input" name="todas" size="40" 
									<?if($var->opt['todas']!='')echo  "value=\"".$var->opt['todas']."\"";?>/>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<?if($var->datos['lista_Problemas']->num_Resultados()>0){$par=false;?>
	<!-- resultados -->
	<div id="listado" style="position:relative;width:80%;height:600px;margin-left:10%;overflow:visible;margin-top:3em;">
		<table style="width:99%;" class="sortable">
			<thead>
				<tr>
					<th style="font-size:small;color:black;" ><?echo  $var->datos['lista_Problemas']->num_Resultados()?>&nbsp;<?_translate("Res.")?></th>
					<th colspan="9" width="80%">
						<div style="display:inline;position:absolute;">
							<?if($var->datos['page']>1){?>
								<a href="javaScript:repagina('Inicio')" title="<?_translate("Ir a la Primera")?>"><<</a> &nbsp;
								<a href="javaScript:repagina('Anterior')" title="<?_translate("Ir a la Anterior")?>"><</a> &nbsp;
							<?}?>
									<?echo  "P&aacute;gina ";echo  ($var->datos['page']/$var->datos['paso'])+1 ." de ".$var->datos['lastPage']?> &nbsp;
							<?if((($var->datos['page']/$var->datos['paso'])+1) < $var->datos['lastPage']){?>
								<a href="javaScript:repagina('Siguiente')" title="<?_translate("Ir a la Siguiente")?>">></a> &nbsp;
								<a href="javaScript:repagina('Fin')" title="<?_translate("Ir a la &Uacute;ltima")?>">>></a>
							<?}?>
						</div>
						<div style="display:inline;float:right;">
							Ir a p&aacute;gina: 
							<input type="text" name="numpag" id="numpag" value="" size="4" onkeypress="return EvaluateText('%f', this, event);">
							<input type="button" value="Ir" onclick="javascript:irpag('numpag');">&nbsp;
						</div>
					</th>
					<!-- <th colspan="2" nowrap><a href="javaScript:repagina('Exportar')" title="<?_translate("Exportar")?>"><?_translate('Exportar resultados')?></a></th>  -->
				</tr>
				<tr class="MenuTable">
					<th nosort="1" width="10px" nowrap><?_translate(" Id ")?></th>
					<th><?_translate("Descripci&oacute;n")?></th>
					<th><?_translate("Estado")?></th>
					<th><?_translate("Prioridad")?></th>
					<th nowrap><?_translate("ID WR.")?></th>
					<th><?_translate("Inc.")?></th>
					<th><?_translate("Centros")?></th>
					<th><?_translate("Actual.")?></th>
					<th><?_translate("Tipo")?></th>
					<th><?_translate("RFCs")?></th>
					<th><?_translate("Operador")?></th>
				</tr>
			</thead>
			<tbody>
				<?while($problema = $var->datos['lista_Problemas']->siguiente()){
					$problema_id = $problema->get_Id();
					($par)?$par=false:$par=true;?>
				<tr hover class="<?if($par) echo  'par'; else echo  'impar';?>" >
					<td style="text-align:center"><a href="<?echo  $appDir.'/Problemas/ver_detalles.php?id='.$problema_id; ?>">&nbsp;&nbsp;<?echo  $problema_id?>&nbsp;&nbsp;</a></td>
					<td><?echo  $problema->get_Descripcion()?></td>
					<td nowrap style="text-align:center"
						<?$estado = end($problema->get_Lista_Estados());
						switch($estado['id']){
						case '3'://Cerrado
							echo  "closed";
							break;
						case '4'://Resuelto
							echo  "ok";
							break;
						}?>					
					>
						<?
						($estado['id']=='2')?$bloqueo=" (".$estado['nombre_ente'].")":$bloqueo='';
						echo  $estado['nombre'].$bloqueo;?>
					</td>
					<td style="text-align:center">
						<?$prioridad=end($problema->get_Lista_Prioridades());
						echo  $prioridad['nombre'];?>
					</td>	
					<td style="text-align:center">
						<? $arr=array();
						$lista_Wr = $problema->get_Lista_Wr();
						foreach ($lista_Wr as $WR)
							$arr[]=$WR->get_Id();
						 echo  implode(',', $arr);
						?>
					</td>
					<td style="text-align:center;">
						<?echo  count($problema->get_Lista_Incidencias());?>
					</td>	
					<td style="text-align:center;">
						<?echo  count($problema->get_Lista_Sedes())?>
					</td>	
					<td style="text-align:center">
					<?$ult_Actuacion = end($problema->get_Lista_Actuaciones());
						echo  date("Y/m/d",$ult_Actuacion->get_Fecha_Fin());?>
					</td>				
					<td style="text-align:center">
						<?$tipo = $ult_Actuacion->get_Tipo();
						echo  $tipo['nombre']?>
					</td>
					<td nowrap style="text-align:center">
						<?$RFCs = $problema->get_Lista_RFC();?>
						<div style="max-height:5em;overflow:auto;">
						<?foreach($RFCs as $RFC){?>
							<a href="<?echo  $appDir?>/Cambios/mostrarRFC.php?id=<?echo  $RFC->get_Id();?>">
								<?$estado = $RFC->get_Estado();?>
								<?echo  $RFC->get_Id()." (".$estado['nombre'].")";?>
							</a> <br />
						<?}?>
						</div>
					</td>
					<td style="text-align:center" <?$operador=$problema->get_Operador();
						if(!$operador['id'])
							echo  "warning";?>>
							<?if($operador['id']){?>
								<?echo  $operador['id'];?>
							<?}else if($permisos->administracion){?>
 								<a href="<?echo  $appDir?>/Problemas/asignacion.php?accion=mostrar&codigo=<?echo  $problema_id;?>">
 								<?_translate("Sin asignar")?></a>	
							<?}else{?>
								<?_translate("Sin asignar")?>
							<?}?>
					</td>
				</tr>
				<?}?>
				<tr>
					<th style="font-size:small;color:black;" ><?echo  $var->datos['lista_Problemas']->num_Resultados()?>&nbsp;<?_translate("Res.")?></th>
					<th colspan="9" width="80%">
						<div style="display:inline;position:absolute;">
							<?if($var->datos['page']>1){?>
								<a href="javaScript:repagina('Inicio')" title="<?_translate("Ir a la Primera")?>"><<</a> &nbsp;
								<a href="javaScript:repagina('Anterior')" title="<?_translate("Ir a la Anterior")?>"><</a> &nbsp;
							<?}?>
									<?echo  "P&aacute;gina ";echo  ($var->datos['page']/$var->datos['paso'])+1 ." de ".$var->datos['lastPage']?> &nbsp;
							<?if((($var->datos['page']/$var->datos['paso'])+1) < $var->datos['lastPage']){?>
								<a href="javaScript:repagina('Siguiente')" title="<?_translate("Ir a la Siguiente")?>">></a> &nbsp;
								<a href="javaScript:repagina('Fin')" title="<?_translate("Ir a la &Uacute;ltima")?>">>></a>
							<?}?>
						</div>
						<div style="display:inline;float:right;">
							Ir a p&aacute;gina: 
							<input type="text" name="numpag" id="numpag" value="" size="4" onkeypress="return EvaluateText('%f', this, event);">
							<input type="button" value="Ir" onclick="javascript:irpag('numpag');">&nbsp;
						</div>
					</th>
					<!-- <th colspan="2" nowrap><a href="javaScript:repagina('Exportar')" title="<?_translate("Exportar")?>"><?_translate('Exportar resultados')?></a></th>  -->
				</tr>
			</tbody>
		</table>
	</div>
<?}else{?>
	<div id="listado" style="position:relative;width:80%;height:600px;margin-left:10%;overflow:visible;margin-top:3em;">
		<table style="width:99%;" class="sortable">
			<thead>
				<tr>
					<th style="font-size:small;color:black;" ><?_translate("Sin resultados.")?></th>
				</tr>
			</thead>
		</table>
	</div>
<?}?>
</form>
<br />
<br />

<script language="JavaScript" type="text/javascript">
	<!--
	show_opt('opt_avanzadas', document.getElementById('mas_opciones'));
	function show_opt(id_opt, obj){
		if(obj.checked){
			document.getElementById(id_opt).style.visibility="visible"
			document.getElementById(id_opt).style.display="block"
		}
		else{
			document.getElementById(id_opt).style.visibility="collapse"
			document.getElementById(id_opt).style.display="none"
		}
	}	
	//-->
</script>
<?
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>