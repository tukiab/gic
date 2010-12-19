<?	include ('appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
	include ($appRoot.'/Utils/lang.php');
	require_once ($appRoot.'/Utils/utils.php');
		
include ($appRoot.'/Incidencias/_busquedaIncidencias.php');
//Opciones
	(empty($_GET['estado']))?$arrayOpciones['estado'] = 'x':null;
	(empty($_GET['operador']))?$arrayOpciones['operador']='1':null;
	$arrayOpciones['ult_act'] = '1';
	$arrayOpciones['mostrar'] = '1';
	$opciones = array_merge($arrayOpciones, $_GET);
	$var = new _BusquedaIncidencias($opciones);
	
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>
<script language="JavaScript" type="text/javascript">
var img_cal='Graficas/img/calendar.gif';
</script>


<table style="width:100%">
	<tr>
		<td class="TituloPag" nowrap><?_translate("SIGILA")?></td>
	</tr><? echo  $style;?>
</table>
	<div id="top_right" style="position:relative;margin-left:3%;width:40%;height:100%">
		<table>
			<tr>
				<td width="60%">
					<form id="filtros" method="GET" action="<?echo  $_SERVER['PHP_SELF']?>">
					<table width="100%" class="MenuTable">
						<tr>
							<td class="ListaTitulo" nowrap colspan="2" style="letter-spacing:0.25em;font-variant:small-caps;">
								<label><input <?if($var->opt_incidencias['operador']!='') echo  "checked";?> value="1" type="checkbox" name="operador"/><strong>&nbsp;<?_translate("Mis incidencias")?></strong></label>
							</td>
						</tr>
						<tr class="MenuTable"><td><?_translate("C&oacute;digo Inc.")?></td>
							<td class="impar"><input type="input" name="codigo" size="7" 
									<?if($var->opt_incidencias['codigo']!='')echo  "value=\"".$var->opt_incidencias['codigo']."\"";?>
								/></td>
						</tr>
						<tr class="MenuTable"><td><?_translate("Fecha apertura")?></td>
							<td class="impar">&nbsp;desde&nbsp;
							<?$style=""; if($var->error['fdesde']) $style="style=\"color:red;border-color:red\"";?>
							<input <? echo  $style;?> type="input" class="fecha" name="fdesde" size="10"  
							<?if($var->opt_incidencias['fdesde']!='')echo  "value=\"".timestamp2date($var->opt_incidencias['fdesde'])."\"";?>
							<?$style=""; if($var->error['fhasta']) $style="style=\"color:red;border-color:red\"";?>
								/>&nbsp;&nbsp;&nbsp;hasta&nbsp;<input type="input" <? echo  $style;?> class="fecha" name="fhasta" size="10"   
									<?if($var->opt_incidencias['fhasta']!='')echo  "value=\"".timestamp2date($var->opt_incidencias['fhasta'])."\"";?>
								/></td>
						</tr>
						<tr class="MenuTable"><td><?_translate("Tipo")?></td>
							<td class="impar">
								<select name="tipo_inc">
									<option value="0"><?_translate("Todos")?></option>
								<?foreach($var->listaTipos_inc as $row){?>
									<option value="<?echo  $row['id']?>"
											<?if($var->opt_actuaciones['tipo']==$row['id']) echo  "selected";?>
									><?echo  $row['nombre']?></option>
								<?}?>
								</select>
							</td>
						</tr>
						<tr><td><?_translate("Origen")?>:</td>
							<td class="impar">
								<select name="origen">
									<option value="0"><?_translate("Todos")?></option>
								<?foreach($var->listaOrigenes as $origen_inc){?>
									<option value="<?echo  $origen_inc['id']?>"
											<?if($var->opt_incidencias['origen']==$origen_inc['id']) echo  "selected";?>
									><?echo  $origen_inc['nombre']?></option>
								<?}?>
								</select>
							</td>
						</tr>
						<tr class="MenuTable"><td><?_translate("Estado")?></td>
							<td class="impar" nowrap>
								<div id='aux' style="position:absolute;width:20%;">
									<select id="estado" name="estado" onChange="check(this.value, 'block')">
										<option value="0"><?_translate("Todos")?></option>
										<option value="x" <?if($var->opt_incidencias['estado']=='x') echo  'selected';?>><?_translate("No Cerrada")?></option>
										<option value="mis_incidencias" <?if($var->opt_incidencias['estado']=='mis_incidencias') echo  'selected';?>><?_translate("Abierta/No resuelta")?></option>
									<?foreach($var->listaEstados as $tmp_estado){?>
										<option value="<?echo  $tmp_estado['id']?>"
												<?if($var->opt_incidencias['estado']==$tmp_estado['id']) echo  "selected";?>
										><?echo  $tmp_estado['nombre']?></option>
									<?}?>
									</select>
								</div>
								<div id='block' style="position:relative;visibility:collapse;margin-left:50%;width:30%;">
									<select hilight name="id_bloqueo" >
										<option value=""><?_translate("Todos")?></option>
									<?foreach($var->listaBloqueos as $bloqueo){?>
										<option value="<?echo  $bloqueo['id']?>" <?if($var->opt_incidencias['id_bloqueo'] == $bloqueo['id']) echo  "selected";?> >
											<?echo  $bloqueo['nombre']?>
										</option>
									<?}?>
									</select>						
								</div>
								<div style="display:inline;margin-left:1.5em;padding-top:0.2em;">
									antes de&nbsp;
									<span class="calendar_wrap">
					
		        					<input class="fecha" type="input" name="e_desde" size="10"  
										<?if($var->opt_incidencias['e_desde']!='')echo  "value=\"".timestamp2date($var->opt_incidencias['e_desde'])."\"";?>
										/>
									</span>
								</div>
							</td>
						</tr>
						<tr class="MenuTable">
							<td colspan="3" style="text-align:right;">
								<input type="submit" id="mostrar" name="mostrar" value="<?_translate("Buscar")?>" />
								<input type="hidden" name="page" value="<?echo  $var->page?>" />
								<input type="hidden" name="navigation" value="" />
								<input type="hidden" name="id" value="<?echo  $var->id_sede?>" />
								<input type="hidden" name="total" id="total" value="<?php echo  $var->total;?>" />
								<input type="hidden" name="mostrar" value="Aceptar" />
							</td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<br />
<br />
	<?if($var->mostrarDatos){?>
		<table style="width:95%">
			<tr>
				<th colspan="2" style="font-size:small;color:black;" ><?echo  $var->total?>&nbsp;<?_translate("Resultados")?></th>
				<th colspan="5" width="60%">
					<div style="display:inline;position:absolute;">
						<?if($var->page>1){?>
							<a href="javaScript:repagina('Inicio')" title="<?_translate("Ir a la Primera")?>"><<</a> &nbsp;&nbsp;
							<a href="javaScript:repagina('Anterior')" title="<?_translate("Ir a la Anterior")?>"><</a> &nbsp;&nbsp;
						<?}?>
								<?echo  "P&aacute;gina ";echo  ($var->page/$var->paso)+1 ." de $var->lastPage"?> &nbsp;&nbsp;
						<?if((($var->page/$var->paso)+1)<$var->lastPage){?>
							<a href="javaScript:repagina('Siguiente')" title="<?_translate("Ir a la Siguiente")?>">></a> &nbsp;&nbsp;
							<a href="javaScript:repagina('Fin')" title="<?_translate("Ir a la &Uacute;ltima")?>">>></a>
						<?}?>
					</div>
					<div style="display:inline;float:right;">
						Ir a p&aacute;gina: 
						<input type="text" name="numpag" id="numpag" value="" size="4" onkeypress="return EvaluateText('%f', this, event);">
						<input type="button" value="Ir" onclick="javascript:irpag('numpag');">&nbsp;
					</div>
				</th>
				<th colspan="2" nowrap><a href="javaScript:repagina('Exportar')" title="<?_translate("Exportar")?>"><?_translate('Exportar resultados')?></a></th> 
			</tr>
			<tr class="ListaTitulo">
			<tr class="MenuTable">
				<th><?_translate("Inc.")?></th>
				<th><?_translate("Centro")?></th>
				<th><?_translate("Descripci&oacute;n")?></th>
				<th><?_translate("Apertura")?></th>
				<th><?_translate("Estado")?></th>
				<th><?_translate("Fecha Estado")?></th>
				<th><?_translate("Tipo")?></th>
				<th><?_translate("Problema")?></th>
				<th><?_translate("Actualizada")?></th>
				<th><?_translate("Operador")?></th>
			</tr>
			<tr><td class="ListaTitulo" colspan="9"></td></tr>
			<?$impar=false;
			while($Incidencia = $var->ListaIncidencias->siguiente()){
				$ultima_act = end($Incidencia->get_Lista_Actuaciones());
				$ultimo_est = end($Incidencia->get_Lista_Estados());
				$Sede = $Incidencia->get_Sede();
				$Problema = $Incidencia->get_Problema();
				
				$respuestas_pendientes = $Incidencia->respuestas_Pendientes();
				
				if($impar){
					$impar=false;
					$class = 'par';
				}else{
					$impar=true;
					$class = 'impar';
				}
				?>
				<tr hover class="<?echo  $class?>">
					<td  style="font-weight:bold;" nowrap>				
						<a href="<?echo  $appDir."/Incidencias/ver_incidencia.php"?>?<?echo  'id_sede='.$Sede->get_Id().'&id_inc='.$Incidencia->get_Id();?>">&nbsp;&nbsp;<?echo  $Incidencia->get_Id()?>&nbsp;&nbsp;</a>
					</td>
					<td>
						<?$destino = $appDir."/Centros/mostrarSede.php?id=".$Sede->get_Id();?>
						<?if($permisos->permisoLectura($destino)){?>
							<a href="<?echo  $destino?>" ><?echo  $Sede->get_Cod_Centro();?></a>
						<?}else{?>
							<?echo  $Sede->get_Cod_Centro();?>
						<?}?>
					</td>
					<td style="width:200em;"><?echo  $Incidencia->get_Descripcion()?></td>
					<td><?echo  date("d/m/Y",$Incidencia->get_Fecha_Inicio())?></td>
					<td>
						<?($ultimo_est['id']=='2')?$bloqueo=" (".$ultimo_est['nombre_ente'].")":$bloqueo='';?>
						<label title="<?echo  $ultimo_est['nombre'].$bloqueo?>"><?echo  substr($ultimo_est['nombre'].$bloqueo, 0, 30)?></label>
					</td>
					<td><?echo  date("d/m/Y", $ultimo_est['fecha'])?></td>
					<td><label style="font-size:small;" title="<?$tipo_act = $ultima_act->get_Tipo();echo  $tipo_act['nombre']?>"><?echo  $tipo_act['nombre']?></label></td>
					<td style="text-align:right;font-size:xx-small;" 
						<?
						if($Problema){?>
							<?	
								$p_estado = end($Problema->get_Lista_Estados());
								if($p_estado['id']=='3')
									echo  "closed"; 
								else if($p_estado['id']=='4')
									echo  "ok";
								else
									echo  "warning";?> 
					>
							<a href="<?echo  $appDir."/Problemas/ver_detalles.php?"; echo  'id='.$Problema->get_Id(); ?>"><?echo  $Problema->get_Id();?></a>
							<?//WA aplicables
							if(count($Problema->get_Lista_WR())>0){
								echo  "<p style=\"display:inline;font-weight:bold;\">("._translate("wa", true).")</p>";
							}
						}?>
					</td>
					<td nowrap><?echo  date("d/m/Y H:i",$Incidencia->get_Fecha_Actualizacion())?></td>
					<td <?$operador = $Incidencia->get_Operador();
					if($Incidencia->get_Escalado()) echo  "style=\"font-weight:bold;width:10em;\""; else echo  "class=\"ColIzq\" style=\"width:10em;\"";?>>
						<?if(!$operador){?>
								<?_translate("No asignada")?>
						<?}else{?>
							&nbsp;&nbsp;<?echo  $operador['id'];?>
						<?}?>
					</td>
					<td nowrap style="width:10em;">
						<a href="javascript:void(0);" onclick="window.open('<?echo  $appDir."/Llamadas/detalleIncidencia.php"?>?<?php echo  'sede='.$Sede->get_Id().'&inc='.$Incidencia->get_Id(); ?>','<?echo  rand()?>','width=800,height=350,scrollbars=yes');">&#91;<?echo  count($Incidencia->get_Lista_Actuaciones())." ";_translate("Act.")?>&#93;</a>
						<?if(count($Incidencia->get_Lista_Comentarios())>0 && $respuestas_pendientes){?>
							<br /><a style="color:red;" href="<?echo  $appDir."/Incidencias/gest_comentarios.php?&id=".$Incidencia->get_Id();?>">&#91;<?_translate("Resp. Pdte.")?>&#93;</a>
						<?}else if(count($Incidencia->get_Lista_Comentarios())>0){?>
							<br /><a href="<?echo  $appDir."/Incidencias/gest_comentarios.php?&id=".$Incidencia->get_Id();?>">&#91;<?echo  count($Incidencia->get_Lista_Comentarios())." ";_translate("Coment.")?>&#93;</a>
						<?}?>
					</td>
				</tr>
			<?}?>
			<tr><td class="ListaTitulo" colspan="9"></td></tr>
			<tr class="MenuTable">
				<th colspan="2" style="font-size:small;color:black;" ><?echo  $var->total?>&nbsp;<?_translate("Resultados")?></th>
				<th colspan="5" width="60%">
					<?if($var->page>1){?>
						<a href="javaScript:repagina('Inicio')" title="<?_translate("Ir a la Primera")?>"><<</a> &nbsp;&nbsp;
						<a href="javaScript:repagina('Anterior')" title="<?_translate("Ir a la Anterior")?>"><</a> &nbsp;&nbsp;
					<?}?>
							<?echo  "P&aacute;gina ";echo  ($var->page/$var->paso)+1 ." de $var->lastPage"?> &nbsp;&nbsp;
					<?if((($var->page/$var->paso)+1)<$var->lastPage){?>
						<a href="javaScript:repagina('Siguiente')" title="<?_translate("Ir a la Siguiente")?>">></a> &nbsp;&nbsp;
						<a href="javaScript:repagina('Fin')" title="<?_translate("Ir a la &Uacute;ltima")?>">>></a>
					<?}?>
				</th>
				<th colspan="2" nowrap><a href="javaScript:repagina('Exportar')" title="<?_translate("Exportar")?>"><?_translate('Exportar resultados')?></a></th> 
			</tr>
		</table>
	<?}else{?>
		<table style="width:80%">
			<tr>
				<th style="font-size:small;color:black;" ><?_translate("0 Resultados.")?></th>
			</tr>
		</table>
	<?}?>
	
</form>
<br />
<script language="JavaScript" type="text/javascript">
	<!--
		check( '<?echo  $var->opt_incidencias['estado']?>' ,'block');
		function check(value, target){
			if(document.getElementById(target)){
				if(value=='2')//Bloqueada
					document.getElementById(target).style.visibility="visible"
				else
					document.getElementById(target).style.visibility="collapse"
			}
		}
		function repagina(nav){
			document.forms[0].navigation.value=nav;
			mostrar = document.getElementById("mostrar");
			if(nav!='Exportar')
				mostrar.click();
			else{
				<?if($var->total >=400){?>
				if(confirm("<?_translate("Con más de 400 Incidencias el proceso puede tardar varios minutos.")?>"))
				<?}?>
					mostrar.click();
			}
			document.forms[0].navigation.value='Inicio'
		}
		
		function irpag(numpag){
			var valorpag=document.getElementById('numpag').value;
			valorpag=parseInt(valorpag);
			if(valorpag=="" || valorpag==undefined)
				valorpag='1';
			document.forms[0].navigation.value='Irpag';
			document.forms[0].page.value=valorpag;
			document.forms[0].submit();
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

<?
include($appRoot.'/include/html/bottomMenu.php');
include($appRoot.'/include/html/footer.php');
?>
