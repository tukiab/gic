<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showCliente.php');
	$var = new ShowCliente($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');
?>
<script language="JavaScript" type="text/javascript">
function eliminar(borrado_total){
	if(confirm('Eliminar la empresa')){
		$('#eliminar').val(1);
		if(borrado_total)
			$('#borrado_total').val(1);
		$('#frm').submit();
	}		
}
function eliminarGestor(idgestor){
	if(confirm('Eliminar el gestor')){
		$('#eliminarGestor').val(idgestor);
		$('#frm').submit();
	}		
}
function eliminarAccion(id){
	if(confirm('Eliminar la accion')){
		$('#eliminarAccion').val(id);
		$('#frm').submit();
	}		
}
$(document).ready(function()
{
	// ********** ACORDEÓN ********** //
/*	$('#myAccordion').Accordion({
		headerSelector: 'dt',
		panelSelector: 'dd',
		activeClass: 'myAccordionActive',
		hoverClass: 'myAccordionHover',
		panelHeight: 300,
		speed: 300
		}
	);*/		
	//********** ACORDEÓN ********** //
});
</script>

<?php 
if($var->opt['msg']){?>
	<div id="error_msg" ><?php echo$var->opt['msg']?>
	<?php if($var->opt['eliminar']){?>
		<br/><br/><a style="float:right;margin-right:10px;bottom: 0" href="#" onclick="eliminar(true);"><input class="borrar" type="button" value="<?php echo  _translate("Borrar del todo")?>" /></a>
	<?php }?>
	</div>
<?php }?>
<?php $razon_social = $var->opt['Cliente']->get_Razon_Social();?>
<div id="titulo"><?php echo  $razon_social?></div>		
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div id="contenedor" align="center">
	<!-- **************** DATOS DEL CLIENTE **************** -->
	<div id="izquierda" style="float:left;width:40%;">
		<table style="width:100%">
			<tr>
			  	<td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos de la empresa")?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Id empresa")?>:</td>
				<td class="ColDer"><?php echo  ($var->opt['Cliente']->get_Id());?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Raz&oacute;n social")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Razon_Social()?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Tipo")?>:</td>
				<td class="ColDer">
					<?php $tipo=$var->opt['Cliente']->get_Tipo_Cliente();echo  $tipo['nombre'];?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Grupo")?>:</td>
				<td class="ColDer">
					<?php $grupo=$var->opt['Cliente']->get_Grupo_Empresas();echo  $grupo['nombre'];?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Tel&eacute;fono")?>:</td>
				<td class="ColDer">
					<?php echo impArrayTelefono($var->opt['Cliente']->get_Telefono());?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("FAX")?>:</td>
				<td class="ColDer">
					<?php echo  impArrayTelefono($var->opt['Cliente']->get_FAX());?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("CIF/NIF")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_NIF();?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Domicilio();?>
				</td>				
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Localidad();?> 
				</td>				
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Provincia();?> 
				</td>				
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("C&oacute;digo Postal")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_CP();?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de empleados")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Numero_Empleados();?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<?php  echo web($var->opt['Cliente']->get_Web());?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Sector")?>:</td>
				<td class="ColDer">
					<?php  echo $var->opt['Cliente']->get_Sector()?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("SPA actual")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_SPA_Actual()?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Fecha de renovaci&oacute;n")?>:</td>
				<td class="ColDer"><?php  echo timestamp2date($var->opt['Cliente']->get_Fecha_Renovacion())?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Norma implantada")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Norma_Implantada()?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Cr&eacute;ditos")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Creditos()?>&nbsp;&#8364;</td>
			</tr>
			<?php 
			//if($permisos->administracion){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editCliente.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=800,height=600,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php //}?>
		</table>
		<!-- contactos -->
		<table style="width:100%;margin-top:20px">
			<tr>
			  	<td class="ListaTitulo" style="text-align:center;" colspan="4"><?php echo  _translate("Contactos")?></td>
			</tr>
			<tr>				
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Nombre Contacto")?></th>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Tel&eacute;fono")?></th>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Email")?></th>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Cargo")?></th>
			</tr>
			<?php $impar=false;
				$listaContactos = $var->opt['Cliente']->get_Lista_Contactos();
				
				foreach ($listaContactos as $contacto){
					if($impar){
						$impar=false;
						$class = 'par';
					}else{
						$impar=true;
						$class = 'impar';
					}?>
					<tr class="<?php  echo $class?>" align="center">
						<td align="center"><?php echo  $contacto->get_Nombre();?></td>
						<td align="center"><?php echo  $contacto->get_Telefono();?></td>
						<td align="center"><?php echo  email($contacto->get_Email());?></td>
						<td align="center"><?php echo  $contacto->get_Cargo();?></td>
					</tr>
				<?php }?>
			<?php 
			//if($permisos->escritura){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editContactos.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=500,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php //}?>
		</table>
					
		<!-- gestores -->
		<table style="width:100%;margin-top:20px">
			<tr>
			  	<td class="ListaTitulo" style="text-align:center;" colspan="3"><?php echo  _translate("Gestores")?></td>
			</tr>	
			<tr>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Id Gestor")?></th>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Nombre Gestor")?></th>
				<?php if($gestor_actual->esAdministradorTotal()){?>
				<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Eliminar")?></th>
				<?php } ?>
			</tr>
			<?php $impar=false;
                        FB::info($var->opt['Cliente']);
				$listaGestores = $var->opt['Cliente']->get_Lista_Gestores();
				$i = 0;
                                
				foreach ($listaGestores as $usuario){
					if($impar){
						$impar=false;
						$class = 'par';
					}else{
						$impar=true;
						$class = 'impar';
					}?>
					<tr class="<?php  echo $class?>" align="center">
						<td align="center"><?php echo  $usuario->get_Id();?></td>
						<td align="center"><?php echo  $usuario->get_Nombre_Y_Apellidos();?></td>
						<?php if($gestor_actual->esAdministradorTotal()){?>
						<td align="center"><a href="#" onclick="eliminarGestor('<?php echo $usuario->get_Id();?>');"><input class="borrar" type="button" value="<?php echo  _translate("Borrar")?>" /></a>
						<?php }?>
					</td>
					</tr>
				<?php $i=1;
				}?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/addGestores.php?id=".$var->opt['Cliente']->get_Id(); $perfil = $var->usuario->get_Perfil()?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=1000,height=260,scrollbars=yes');"><?php if(esAdministrador($perfil['id'])) echo  _translate("A&ntilde;adir")?></a></label>
				</td>
			</tr>
		</table>


	</div>
	
	<!-- **************** ACCIONES Y OFERTAS, CONTACTOS Y GESTORES **************** -->
	<div id="derecha"  style="float:right;width:60%;height:370px">
		<dl id="myAccordion">
			<!-- acciones -->
			<dt ><b><?php echo _translate("Acciones de la empresa")?></b></dt>
			<!-- <dd style="display: block; height: 100px;"> -->
			<dd style="margin-bottom: 20px">
				<table>
					<tr>				
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Gestor")?></th>
			 			<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Id de acci&oacute;n")?></th>
						<!-- <th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Descipci&oacute;n")?></th> -->
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Tipo")?></th>
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Fecha")?></th>
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Fecha Siguiente")?></th>
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Comentario")?></th>
						<?php if($gestor_actual->esAdministradorTotal()){?>
						<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Eliminar")?></th>
						<?php } ?>
					</tr>
				<?php $impar=false;
					$listaAcciones = $var->opt['Cliente']->get_Lista_Acciones();
					foreach ($listaAcciones as $accion){
						if($impar){
							$impar=false;
							$class = 'par';
						}else{
							$impar=true;
							$class = 'impar';
						}?>
						<tr class="<?php  echo $class?>" align="center">
							<td><?php echo $accion->get_Usuario(); ?></td>
							<td align="center">
								<a href="<?php echo  $appDir.'/Acciones/showAccion.php?id='.$accion->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $accion->get_Id()?>&nbsp;&nbsp;</a>
								</td>
							<!-- <td align="center"><?php echo  $accion->get_Descripcion();?></td> -->
							<td align="center"><?php $tipo = $accion->get_Tipo_Accion(); echo $tipo['nombre'];?></td>
							<td align="center"><?php echo  timestamp2date($accion->get_Fecha());?></td>
							<td align="center"><?php echo  timestamp2date($accion->get_Fecha_Siguiente_Accion());?></td>
							<td align="center"><?php echo  $accion->get_Descripcion();?></td>
							<?php if($gestor_actual->esAdministradorTotal()){?>
								<td align="center"><a href="#" onclick="eliminarAccion('<?php echo $accion->get_Id();?>');"><input class="borrar" type="button" value="<?php echo  _translate("Borrar")?>" /></a>
								<?php }?>
						</tr>
					<?php }?>
				</table>
			</dd>
			<!-- ofertas y oportunidades -->
			<dt><b><?php echo _translate("Ofertas y Oportunidades de negocio")?></b></dt>
			<!-- <dd style="display: none; height: 1px;"> --><dd style="margin-bottom: 20px">
				<table>			
				<tr>
					<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Gestor")?></th>
					<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("C&oacute;digo")?></th>
					<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Nombre")?></th>
					<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Estado")?></th>
					<th style="font-weight: normal;font-size:x-small;"><?php echo  _translate("Fecha definici&oacute;n")?></th>
				</tr>
				<?php $impar=false;
					$listaOfertas = $var->opt['Cliente']->get_Lista_Ofertas();
					foreach ($listaOfertas as $oferta){
						
						$estado = $oferta->get_Estado_Oferta();
						if($impar){
							$impar=false;
							$class = 'par';
						}else{
							$impar=true;
							$class = 'impar';
						}?>
						<tr class="<?php  echo $class?>" align="center">
							<td><?php echo $oferta->get_Usuario(); ?></td>
							<td align="center">
								<a href="<?php echo  $appDir.'/Ofertas/showOferta.php?id='.$oferta->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $oferta->get_Codigo()?>&nbsp;&nbsp;</a>
							</td>
							<td align="center"><?php echo  $oferta->get_Nombre_Oferta();?></td><?php $bold=""; if($oferta->get_Aceptado()) $bold="font-weight:bold;"; ?>
							<td align="center" style="<?php echo $bold; ?>"><?php echo  $estado['nombre']?></td>
							<td align="center"><?php echo  timestamp2date($oferta->get_Fecha_Definicion());?></td>
						</tr>
					<?php 
					}?>
					
				</table>
			</dd>
		</dl>
	</div>
</div>
<input type="hidden" id="eliminar" name="eliminar" value="0"/>
<input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
<input type="hidden" id="eliminarGestor" name="eliminarGestor" value="0" />
<input type="hidden" id="eliminarAccion" name="eliminarAccion" value="0" />
<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>
<div class="bottomMenu">
	<table>
		<tr>
			<td colspan="2" style="text-align:right;" nowrap>
			<?php //if($var->opt['mostrar_cabecera']){?>
			
				<?php //Enlaces a otros scripts: Comprobando permisos del destino: ?>
					
					<?php $url_dest = $appDir.'/Acciones/addAccion.php?id_cliente='.$var->opt['Cliente']->get_Id();
					//if($permisos->permisoLectura($url_dest)){?>
						<label title="<?php echo  _translate("Nueva acci&oacute;n")?>">
							<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=1000,height=600,scrollbars=yes');"><input type="button" name="addAccion" value="<?php echo  _translate("Nueva Acci&oacute;n")?>" /></a>
						</label>
					<?php //}?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $url_dest = $appDir.'/Ofertas/addOferta.php?id_cliente='.$var->opt['Cliente']->get_Id();
					//Éste bot&oacute;n tiene que aparecer si el usuario pertenece a Problemas (rol=5 &oacute; 6) (el 9 es de administrador)
					//if($permisos->permisoLectura($url_dest) && ($permisos->isInRol(9) || $permisos->isInRol(5) || $permisos->isInRol(6))){?>			
						<label title="<?php echo  _translate("Nueva oferta")?>">
							<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><input type="button" name="addOferta" value="<?php echo  _translate("Nueva Oferta")?>" /></a>						
						</label>
					<?php //}?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $url_dest = $appDir.'/Ofertas/addOferta.php?es_oportunidad=1&id_cliente='.$var->opt['Cliente']->get_Id();
					//Éste bot&oacute;n tiene que aparecer si el usuario pertenece a Problemas (rol=5 &oacute; 6) (el 9 es de administrador)
					//if($permisos->permisoLectura($url_dest) && ($permisos->isInRol(9) || $permisos->isInRol(5) || $permisos->isInRol(6))){?>			
						<label title="<?php echo  _translate("Nueva oportunidad")?>">
							<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><input type="button" name="addOferta" value="<?php echo  _translate("Nueva Oportunidad")?>" /></a>						
						</label>
					<?php //}?>
					<?php if($gestor_actual->esAdministradorTotal()){?>
						<label title="<?php echo  _translate("BORRAR")?>">
							<a href="#" onclick="eliminar(false);"><input class="borrar" type="button" value="<?php echo  _translate("Borrar empresa")?>" /></a>
													
						</label>
					<?php }?>
					&nbsp;&nbsp;&nbsp;&nbsp;
			<!--		&nbsp;&nbsp;&nbsp;&nbsp;
					<?php  /*$url_dest = $appDir.'/Llamadas/incidenciasCliente.php?id='.$var->opt['Cliente']->get_Id();
					if($permisos->permisoLectura($url_dest)){?>			
						<label title="<?php echo  $var->opt['lista_Incidencias']->num_Resultados()." incidencias";?>">
							<a href="<?php echo  $url_dest?>"><input <?php if($var->opt['lista_Incidencias']->num_Resultados()) echo  "warning";?> type="button" name="volver" value="<?php echo  _translate("Incidencias")?>" /></a>
						</label>
					<?php }?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $url_dest = $appDir.'/Problemas/busqueda.php?mostrar=Actualizar&mas_opciones=on&cod_centro='.$var->opt['Cliente']->get_Cod_Cliente();
					if($permisos->permisoLectura($url_dest)){?>
						<label title="<?php echo  $var->opt['lista_Problemas']->num_Resultados()." problemas";?>">
							<a href="<?php echo  $url_dest?>"><input <?php if($var->opt['lista_Problemas']->num_Resultados()) echo  "warning";?> type="button" name="volver" value="<?php echo  _translate("Problemas")?>" /></a>						
						</label>
					<?php }?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $url_dest = $appDir.'/Cambios/busquedaRFC.php?buscar=Buscar&cod_centro='.$var->opt['Cliente']->get_Cod_Cliente();
					if($permisos->permisoLectura($url_dest)){?>
						<label title="<?php echo  "Consultar RFCs";?>">
							<a href="<?php echo  $url_dest?>"><input type="button" name="volver" value="<?php echo  _translate("RFCs")?>" /></a>						
						</label>
					<?php }*/?> -->
			<?php //}else{?>
				<!-- <input type="button" onClick="cerrar()" value="Cerrar"/> -->
			<?php //}?>
			</td>
		</tr>
	</table>
</div>

</form>

<?php include($appRoot.'/include/html/footer.php')?>
