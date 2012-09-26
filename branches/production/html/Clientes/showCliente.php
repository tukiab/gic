<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_showCliente.php');
	$var = new ShowCliente($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/Common/php/header.php');
	include($appRoot.'/Common/php/menu.php');
	include($appRoot.'/Common/php/bottomMenu.php');
}
else
	include ($appRoot.'/Common/php/popupHeader.php');
?>
<style type="text/css">
	#derecha{
		float:right;width:55%;height:370px;margin-left:4%;
	}
	#derecha table{
		width:90%;
		margin-bottom:20px;
	}
</style>
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
</script>

<?php 
if($var->opt['msg']){?>
	<div id="error_msg" ><?php echo$var->opt['msg']?>
	<?php if($var->opt['eliminar']){?>
		<br/><br/><a style="float:right;margin-right:10px;bottom: 0" href="#" onclick="eliminar(true);"><input class="borrar" type="button" value="<?php echo  _translate("Borrar del todo")?>" /></a>
	<?php }?>
	</div>
<?php }?>
<?php if($permisos->lectura){?>
<?php $razon_social = $var->opt['Cliente']->get_Razon_Social();?>
<div id="titulo"><?php echo  $razon_social?></div>		
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<ul id="menu-sec">
		<li>
			<?php $url_dest = $appDir.'/Acciones/addAccion.php?id_cliente='.$var->opt['Cliente']->get_Id();
			if($permisos->permisoEscritura($url_dest)){?>
				<label title="<?php echo  _translate("Nueva acci&oacute;n")?>">
					<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=440,scrollbars=yes');"><?php echo  _translate("Nueva Acci&oacute;n")?></a>
				</label>
			<?php }?>
		</li>
		<li>
			<?php $url_dest = $appDir.'/Ofertas/addOferta.php?id_cliente='.$var->opt['Cliente']->get_Id();
			if($permisos->permisoEscritura($url_dest)){?>
				<label title="<?php echo  _translate("Nueva oferta")?>">
					<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Nueva Oferta")?></a>
				</label>
			<?php }?>
		</li>
		<li>
			<?php $url_dest = $appDir.'/Ofertas/addOferta.php?es_oportunidad=1&id_cliente='.$var->opt['Cliente']->get_Id();
			if($permisos->permisoEscritura($url_dest)){?>
				<label title="<?php echo  _translate("Nueva oportunidad")?>">
					<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');"><?php echo  _translate("Nueva Oportunidad")?></a>
				</label>
			<?php }?>
		</li>
		<li>
			<?php $usuario = new Usuario($_SESSION['usuario_login']);
			if($permisos->administracion && $usuario->esAdministradorTotal()){?>
				<label title="<?php echo  _translate("BORRAR")?>">
					<a href="#" onclick="eliminar(false);" class="borrar"><?php echo  _translate("Borrar empresa")?></a>

				</label>
			<?php }?>
		</li>
		<li>
			<?php $url_dest = $appDir.'/Proyectos/addProyecto.php?id_cliente='.$var->opt['Cliente']->get_Id();
			if($permisos->permisoEscritura($url_dest)){?>
				<label title="<?php echo  _translate("Crear proyecto directamente")?>">
					<a href="<?php echo $url_dest;?>" ><?php echo  _translate("Crear proyecto")?></a>
				</label>
			<?php }?>
		</li>
	</ul>
<div id="contenedor">
	<!-- **************** DATOS DEL CLIENTE **************** -->
		<table >
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos de la empresa")?><a class="show" href="#" clase="datos"></a></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Id empresa")?>:</td>
				<td class="ColDer"><?php echo  ($var->opt['Cliente']->get_Id());?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Raz&oacute;n social")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Razon_Social()?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Tipo")?>:</td>
				<td class="ColDer">
					<?php $tipo=$var->opt['Cliente']->get_Tipo_Cliente();echo  $tipo['nombre'];?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Grupo")?>:</td>
				<td class="ColDer">
					<?php $grupo=$var->opt['Cliente']->get_Grupo_Empresas();echo  $grupo['nombre'];?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Tel&eacute;fono")?>:</td>
				<td class="ColDer">
					<?php echo impArrayTelefono($var->opt['Cliente']->get_Telefono());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("FAX")?>:</td>
				<td class="ColDer">
					<?php echo  impArrayTelefono($var->opt['Cliente']->get_FAX());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("CIF/NIF")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_NIF();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Domicilio")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Domicilio();?>
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Localidad")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Localidad();?> 
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Provincia")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Provincia();?> 
				</td>				
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("C&oacute;digo Postal")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_CP();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de empleados")?>:</td>
				<td class="ColDer">
					<?php echo  $var->opt['Cliente']->get_Numero_Empleados();?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Web")?>:</td>
				<td class="ColDer">
					<?php  echo web($var->opt['Cliente']->get_Web());?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Sector")?>:</td>
				<td class="ColDer">
					<?php  echo $var->opt['Cliente']->get_Sector()?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("SPA actual")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_SPA_Actual()?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Fecha de renovaci&oacute;n")?>:</td>
				<td class="ColDer"><?php  echo timestamp2date($var->opt['Cliente']->get_Fecha_Renovacion())?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Norma implantada")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Norma_Implantada()?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Cr&eacute;ditos")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Creditos()?>&nbsp;&#8364;</td>
			</tr>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editCliente.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=800,height=600,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Otro datos")?><a class="show" href="#" clase="otrosdatos"></a></td>
			</tr>
			<tr class="otrosdatos">
				<td class="ColIzq" nowrap><?php echo  _translate("Actividad")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Actividad()?></td>
			</tr>
			<tr class="otrosdatos">
				<td class="ColIzq" nowrap><?php echo  _translate("Observaciones")?>:</td>
				<td class="ColDer"><?php  echo $var->opt['Cliente']->get_Observaciones()?></td>
			</tr>
			<?php 
			if($permisos->lectura){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editCliente.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=800,height=600,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>
		<!-- contactos -->
		<table >
			<tr>
			  	<td class="ListaTitulo" colspan="4"><?php echo  _translate("Contactos")?><a class="show" href="#" clase="contactos"></a></td>
			</tr>
			<tr class="contactos">
				<th ><?php echo  _translate("Nombre Contacto")?></th>
				<th ><?php echo  _translate("Tel&eacute;fono")?></th>
				<th ><?php echo  _translate("Email")?></th>
				<th ><?php echo  _translate("Cargo")?></th>
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
					<tr class="<?php  echo $class?> contactos" >
						<td ><?php echo  $contacto->get_Nombre();?></td>
						<td ><?php echo  $contacto->get_Telefono();?></td>
						<td ><?php echo  email($contacto->get_Email());?></td>
						<td ><?php echo  $contacto->get_Cargo();?></td>
					</tr>
				<?php }?>
			<?php 
			if($permisos->lectura){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editContactos.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=300,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>

		<!-- sedes -->
		<table >
			<tr>
			  	<td class="ListaTitulo" colspan="4"><?php echo  _translate("Sedes")?><a class="show" href="#" clase="sedes"></a></td>
			</tr>
			<?php $impar=false;
				$lista = $var->opt['Cliente']->get_Lista_Sedes();

				foreach ($lista as $sede){
					if($impar){
						$impar=false;
						$class = 'par';
					}else{
						$impar=true;
						$class = 'impar';
					}?>
					<tr class="<?php  echo $class?> sedes" >
						<td><a href="<?php echo $appDir.'/Clientes/showSede.php?id='.$sede->get_Id()?>"><?php echo  $sede->get_Localidad();?></a></td>
						<!--<td><?php echo  $sede->get_Provincia();?></td>
						<td><?php echo  email($sede->get_Direccion());?></td>-->
					</tr>
				<?php }?>
			<?php
			if($permisos->lectura){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/editSedes.php?id=".$var->opt['Cliente']->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=300,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>

		<!-- gestores -->
		<table >
			<tr>
			  	<td class="ListaTitulo" colspan="3"><?php echo  _translate("Gestores")?><a class="show" href="#" clase="gestores"></a></td>
			</tr>	
			<tr class="gestores">
				<th ><?php echo  _translate("Id Gestor")?></th>
				<th ><?php echo  _translate("Nombre Gestor")?></th>
				<?php if($permisos->administracion){?>
				<th ><?php echo  _translate("Eliminar")?></th>
				<?php } ?>
			</tr>
			<?php $impar=false;
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
					<tr class="<?php  echo $class?> gestores" >
						<td ><?php echo  $usuario->get_Id();?></td>
						<td ><?php echo  $usuario->get_Nombre_Y_Apellidos();?></td>
						<?php  if($permisos->administracion){?>
						<td ><a class="borrar" href="#" onclick="eliminarGestor('<?php echo $usuario->get_Id();?>');"><?php echo  _translate("Borrar")?></a>
						<?php }?>
					</td>
					</tr>
				<?php $i=1;
				}?>
			<?php  if($permisos->administracion){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Clientes/addGestores.php?id=".$var->opt['Cliente']->get_Id(); $perfil = $var->usuario->get_Perfil()?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=260,scrollbars=yes');"><?php if(esAdministrador($perfil['id'])) echo  _translate("A&ntilde;adir")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>
	
	<!-- **************** ACCIONES Y OFERTAS, CONTACTOS Y GESTORES **************** -->
				<table>
					<tr>
						<td class="ListaTitulo" colspan="7"><?php echo _translate("Acciones de la empresa")?><a class="show" href="#" clase="acciones"></a></td>
					</tr>
					<tr class="acciones">
						<th ><?php echo  _translate("Gestor")?></th>
			 			<th ><?php echo  _translate("Id de acci&oacute;n")?></th>
						<!-- <th ><?php echo  _translate("Descipci&oacute;n")?></th> -->
						<th ><?php echo  _translate("Tipo")?></th>
						<th ><?php echo  _translate("Fecha")?></th>
						<th ><?php echo  _translate("Fecha Siguiente")?></th>
						<th ><?php echo  _translate("Comentario")?></th>
						<?php if($permisos->administracion){?>
						<th ><?php echo  _translate("Eliminar")?></th>
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
						<tr class="<?php  echo $class?> acciones" >
							<td><?php echo $accion->get_Usuario(); ?></td>
							<td >
								<a href="<?php echo  $appDir.'/Acciones/showAccion.php?id='.$accion->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $accion->get_Id()?>&nbsp;&nbsp;</a>
								</td>
							<!-- <td ><?php echo  $accion->get_Descripcion();?></td> -->
							<td ><?php $tipo = $accion->get_Tipo_Accion(); echo $tipo['nombre'];?></td>
							<td ><?php echo  timestamp2date($accion->get_Fecha());?></td>
							<td ><?php echo  timestamp2date($accion->get_Fecha_Siguiente_Accion());?></td>
							<td ><?php echo  $accion->get_Descripcion();?></td>
							<?php if($permisos->administracion){?>
								<td ><a href="#" onclick="eliminarAccion('<?php echo $accion->get_Id();?>');"><input class="borrar" type="button" value="<?php echo  _translate("Borrar")?>" /></a>
								<?php }?>
						</tr>
					<?php }?>
				</table>
			<!-- ofertas y oportunidades -->
			<table>
				<tr>
					<td class="ListaTitulo" colspan="7"><?php echo _translate("Ofertas y Oportunidades de negocio")?><a class="show" href="#" clase="ofertas"></a></td>
				</tr>
				<tr class="ofertas">
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("C&oacute;digo")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Estado")?></th>
					<th ><?php echo  _translate("Fecha definici&oacute;n")?></th>
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
						<tr class="<?php  echo $class?> ofertas" >
							<td><?php echo $oferta->get_Usuario(); ?></td>
							<td >
								<a href="<?php echo  $appDir.'/Ofertas/showOferta.php?id='.$oferta->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $oferta->get_Codigo()?>&nbsp;&nbsp;</a>
							</td>
							<td ><?php echo  $oferta->get_Nombre_Oferta();?></td><?php $bold=""; if($oferta->get_Aceptado()) $bold="font-weight:bold;"; ?>
							<td  style="<?php echo $bold; ?>"><?php echo  $estado['nombre']?></td>
							<td ><?php echo  timestamp2date($oferta->get_Fecha_Definicion());?></td>
						</tr>
					<?php 
					}?>					
			</table>
			<!-- ventas -->
			<table>
				<tr>
					<td class="ListaTitulo" colspan="7"><?php echo _translate("Ventas")?><a class="show" href="#" clase="ventas"></a></td>
				</tr>
				<tr class="ventas">
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("C&oacute;digo")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Fecha")?></th>
				</tr>
				<?php $impar=false;
					$lista = $var->opt['Cliente']->get_Lista_Ventas();
					foreach ($lista as $venta){
						if($impar){
							$impar=false;
							$class = 'par';
						}else{
							$impar=true;
							$class = 'impar';
						}?>
						<tr class="<?php  echo $class?> ventas" >
							<td><?php echo $venta->get_Usuario(); ?></td>
							<td >
								<a href="<?php echo  $appDir.'/Ventas/showVenta.php?id='.$venta->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $venta->get_Codigo()?>&nbsp;&nbsp;</a>
							</td>
							<td ><?php echo  $venta->get_Nombre_venta();?></td>
							<td ><?php echo  timestamp2date($venta->get_Fecha_Aceptado());?></td>
						</tr>
					<?php
					}?>
			</table>
			<!-- proyectos -->
			<table>
				<tr>
					<td class="ListaTitulo" colspan="7"><?php echo _translate("Proyectos")?><a class="show" href="#" clase="proyectos"></a></td>
				</tr>
				<tr class="proyectos">
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("Id")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Fecha inicio")?></th>
				</tr>
				<?php $impar=false;
					$lista = $var->opt['Cliente']->get_Lista_Proyectos();
					foreach ($lista as $proyecto){
						if($impar){
							$impar=false;
							$class = 'par';
						}else{
							$impar=true;
							$class = 'impar';
						}?>
						<tr class="<?php  echo $class?> proyectos" >
							<td><?php echo $proyecto->get_Id_Usuario(); ?></td>
							<td >
								<a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $proyecto->get_Id()?>&nbsp;&nbsp;</a>
							</td>
							<td ><?php echo  $proyecto->get_Nombre();?></td>
							<td ><?php echo  timestamp2date($proyecto->get_Fecha_Inicio());?></td>
						</tr>
					<?php
					}?>
			</table>
</div>
<input type="hidden" id="eliminar" name="eliminar" value="0"/>
<input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
<input type="hidden" id="eliminarGestor" name="eliminarGestor" value="0" />
<input type="hidden" id="eliminarAccion" name="eliminarAccion" value="0" />
<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>


</form>
<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>
<?php include($appRoot.'/Common/php/footer.php')?>