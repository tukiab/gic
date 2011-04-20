<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones
include ('_showProyecto.php');
	$var = new ShowProyecto($_GET, $_POST);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/Common/php/header.php');
	include($appRoot.'/Common/php/menu.php');
	include($appRoot.'/Common/php/bottomMenu.php');
}
else
	include ($appRoot.'/Common/php/popupHeader.php');
?>
<style type="text/css">
	
	td.center{
		text-align: center;
	}
	td.ColDer, td.ColIzq{
		width: 50%;
	}
	table{
		border:none;
		width: 600px;
	}
</style>
<script language="JavaScript" type="text/javascript">
function eliminar(borrado_total){
	if(confirm('Eliminar el proyecto')){
		$('#eliminar').val(1);
		if(borrado_total)
			$('#borrado_total').val(1);
		$('#frm').submit();
	}		
}
function cerrar(){
	if(confirm('Cerrar el proyecto')){
		$('#cerrar').val(1);
		$('#frm').submit();
	}
}
function editar_tarea(id_tarea){
	$('#tarea_editar').val(id_tarea);
	$('#frm').submit();
}
function eliminar_tarea(id_tarea){
if(confirm('confirmar borrado')){	$('#tarea_eliminar').val(id_tarea);
	$('#frm').submit();}
}
function editar_visita(id_tarea){
	$('#visita_editar').val(id_tarea);
	$('#frm').submit();
}
function eliminar_visita(id_tarea){
if(confirm('confirmar borrado')){	$('#visita_eliminar').val(id_tarea);
	$('#frm').submit();}
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
<?php $nombre = $var->Proyecto->get_Nombre();
$cliente = $var->Proyecto->get_Cliente();
$venta = $var->Proyecto->get_Venta();
$estado = $var->Proyecto->get_Estado();?>
<div id="titulo"><?php echo  $nombre;?></div>
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="POST">
	<ul id="menu-sec">
		<li>
			<?php
				if($permisos->administracion)
				if($estado['id'] != 6 ){//cerrado?>
					<label title="<?php echo  _translate("Cerrar")?>">
						<a href="#" onclick="cerrar();"><?php echo  _translate("Cerrar proyecto")?></a>
					</label>
				<?php }?>
		</li>
	</ul>
<div id="contenedor" >
	<!-- **************** DATOS DEL CLIENTE **************** -->
		<table >
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos del proyecto")?><a class="show" href="#" clase="datos"></a></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Id proyecto")?>:</td>
				<td class="ColDer"><?php echo  ($var->Proyecto->get_Id());?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Nombre")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Proyecto->get_Nombre()?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Estado")?>:</td>
				<td class="ColDer">
					<?php $estado=$var->Proyecto->get_Estado();echo  $estado['nombre'];?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Empresa")?>:</td>
				<td class="ColDer">
					<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>">
						<?php echo $cliente->get_Razon_Social();?>
					</a>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Venta")?>:</td>
				<td class="ColDer">
					<?php if($venta){?>
						<a href="<?php echo  $appDir.'/Ventas/showVenta.php?id='.$venta->get_Id(); ?>">
							<?php echo  $venta->get_Nombre();?>
						</a>
					<?php }?>
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Fecha de inicio")?>:</td>
				<td class="ColDer"><?php  echo timestamp2date($var->Proyecto->get_Fecha_Inicio());?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Fecha de finalizaci&oacute;n")?>:</td>
				<td class="ColDer"><?php  echo timestamp2date($var->Proyecto->get_Fecha_Fin());?></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Duraci&oacute;n")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Duracion();?> d&iacute;as</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Unidades")?>:</td>
				<td class="ColDer"><?php echo substr($var->Proyecto->get_Unidades(), 0, 5) ;?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Observaciones")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Proyecto->get_Observaciones();?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Precio consultor&iacute;a (venta)")?>:</td>
				<td class="ColDer">
					<?php echo  ($venta)?$venta->get_Precio_Consultoria():0;?> &euro;
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Precio formaci&oacute;n (venta)")?>:</td>
				<td class="ColDer">
					<?php echo  ($venta)?$venta->get_Precio_Formacion():0;?> &euro;
				</td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("T&eacute;cnico asignado")?>:</td>
				<td class="ColDer">
					<?php
					if($var->Proyecto->get_Id_Usuario())
						echo  $var->Proyecto->get_Id_Usuario();
					else{
						$estado = $var->Proyecto->get_Estado();
						if($estado['id'] == 2){//pendiente de asignación
						?>
						<select  name="id_usuario" onchange="if(this.value)$('#asignar').show();else $('#asignar').hide();" style="width:180px;">
							<?php $usuario_sel = $var->opt['id_usuario'];?>
							<option value="" ><?php echo _translate("No asignar");?></option>
							<?php while($user=$var->datos['lista_tecnicos']->siguiente()){?>
							<option value="<?php  echo $user->get_Id()?>" <?php if($user->get_Id() == $usuario_sel) echo 'selected="selected"';?>><?php  echo $user->get_Id()?></option>
							<?php }?>
						</select>
						<input style="display:none;float:right;" id="asignar" type="submit" value="asignar" name="asignar" />
					<?php }
						else echo "No se puede asignar un t&eacute;cnico en este estado";
					}?>
				</td>
			</tr>
			<?php 
			if($permisos->escritura){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Proyectos/editProyecto.php?id=".$var->Proyecto->get_Id();?>
					<label class="nota">
						<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=500,height=300,scrollbars=yes');">
						<?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>
		<!-- TAREAS DEL PROYECTO -->
		<table >
			<tr>
				<td class="ListaTitulo" colspan="8"><?php echo  _translate("Tareas")?><a class="show" href="#" clase="tareas"></a></td>
			</tr>

			<tr class="tareas">
				<th>Sede</th>
				<th>Fecha</th>
				<th>Horas de desplazamiento</th>
				<th>Horas de visita</th>
				<th>Horas de despacho</th>
				<th>Horas de auditor&iacute;a interna</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</tr>
			<?php foreach($var->Proyecto->get_Tareas() as $tarea){?>
			<tr class="tareas">
				<td ><?php echo  $tarea['localidad'];?></td>
				<td style="width:120px;"><input type="text" style="width:80px;" class="fecha" name="fecha_tarea_<?php echo $tarea['id']?>" value="<?php echo timestamp2date($tarea['fecha']);?>" /></td>
				<td ><input type="text" style="width:20px;" name="horas_desplazamiento_tarea_<?php echo $tarea['id']?>" value="<?php echo  $tarea['horas_desplazamiento'];?>" /></td>
				<td ><input type="text" style="width:20px;" name="horas_visita_tarea_<?php echo $tarea['id']?>" value="<?php echo  $tarea['horas_visita'];?>" /></td>
				<td ><input type="text" style="width:20px;" name="horas_despacho_tarea_<?php echo $tarea['id']?>" value="<?php echo  $tarea['horas_despacho'];?>" /></td>
				<td ><input type="text" style="width:20px;" name="horas_auditoria_interna_tarea_<?php echo $tarea['id']?>" value="<?php echo  $tarea['horas_auditoria_interna'];?>" /></td>
				<?php if($tarea['id_usuario'] == $_SESSION['usuario_login']){ ?>
				<td><a href="#" onclick="editar_tarea('<?php echo $tarea['id']?>')" >guardar</a></td>
				<td style="text-align: center"><a href="#" class="borrar" onclick="eliminar_tarea('<?php echo $tarea['id']?>')" >eliminar</a></td>
				<?php }?>
			</tr>
			<?php }?>
		</table>
		<table >
			<tr>
				<td class="ListaTitulo" colspan="2"><?php echo  _translate("Sedes de la empresa")?><a class="show" href="#" clase="sedes"></a></td>
			</tr>
			<tr class="sedes">
				<th>Sede</th>
				<th>Nueva tarea</th>
			</tr>
			<?php
			$Cliente = $var->Proyecto->get_Cliente();
			foreach($Cliente->get_Lista_Sedes() as $sede){
				?>
			<tr class="sedes">
				<td ><?php echo  $sede->get_Localidad();?></td>
				<td >
					<?php $url_dest = $appDir.'/Tareas/addTarea.php?id_sede='.$sede->get_Id().'&id_proyecto='.$var->Proyecto->get_Id();
					//Éste bot&oacute;n tiene que aparecer si el proyecto no está cerrado o fuera de plazo y si el usuario es el gestor asignado al proyecto					
					$estados_prohibidos = array(5,6);
					if($permisos->escritura && $_SESSION['usuario_login'] == $var->Proyecto->get_Id_Usuario())
					if(!in_array($estado['id'], $estados_prohibidos) &&
							($var->usuario->get_Id() == $var->Proyecto->get_Id_Usuario()
								|| $var->usuario->esAdministradorTotal())){?>
						<label title="<?php echo  _translate("A&ntilde;adir tarea")?>">
							<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=600,height=460,scrollbars=yes');">Nueva tarea</a>
						</label>
					<?php }?>
				</td>
			</tr>
			<?php }?>
		</table>
	
	<!-- **************** DEFINICIÓN **************** -->
		<table >
			<tr>
				<td class="ListaTitulo" colspan="2"><?php echo  _translate("Definici&oacute;n")?><a class="show" href="#" clase="definition"></a></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas documentaci&oacute;n")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Documentacion();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas auditor&iacute;a interna")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Auditoria_Interna();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Precio de venta")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Precio_Venta();?>&euro;</td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas de desplazamiento")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Desplazamiento();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas total de visita")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Cada_Visita();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de visitas")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Numero_Visitas();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Gastos incurridos")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Gastos_Incurridos();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas totales")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Totales();?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Carga de trabajo")?>:</td>
				<td class="ColDer"><?php echo  substr($var->Proyecto->get_Carga_Trabajo_Mensual(),0,5);?></td>
			</tr>
			<tr class="definition">
				<td class="ColIzq" nowrap><?php echo  _translate("Coste de horario de venta")?>:</td>
				<td class="ColDer"><?php echo substr($var->Proyecto->get_Coste_Horario_Venta(),0,6);?></td>
			</tr>
			<?php if($permisos->escritura) if(!$var->Proyecto->esta_Definido()){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Proyectos/definirProyecto.php?id=".$var->Proyecto->get_Id();?>
					<label class="nota"><a href="<?php echo $url_dest?>"><?php echo  _translate("Definir")?></a></label>
				</td>
			</tr>
			<?php }?>
		</table>
		<!-- DEFINICIÓN DESGLOSADA POR SEDES -->
		<table  >
			<tr>
				<td class="ListaTitulo" colspan="6"><?php echo  _translate("Desglose por sedes")?><a class="show" href="#" clase="desglose"></a></td>
			</tr>
			<tr  class="desglose">
				<th>Sede</th>
				<th>Horas de desplazamiento</th>
				<th>Horas de cada visita</th>
				<th>N&uacute;mero de visitas</th>
				<th>Gastos incurridos</th>
				<th>Total horas</th>
			</tr>
			<?php foreach($var->Proyecto->get_Definicion_Sedes() as $definicion){?>
			<tr class="desglose">
				<td class="ListaTitulo"><?php echo $definicion['localidad'];?></td>
				<td ><?php echo $definicion['horas_desplazamiento'];?></td>
				<td ><?php echo $definicion['horas_cada_visita'];?></td>
				<td ><?php echo $definicion['numero_visitas'];?></td>
				<td ><?php echo $definicion['gastos_incurridos'];?></td>
				<td><?php echo $definicion['horas_desplazamiento']+$definicion['horas_cada_visita']*$definicion['numero_visitas'];?></td>
			</tr>
			<?php }?>			
		</table>

		<!-- PLANIFICACIÓN -->
		<table  >			
			<tr>
				<td class="ListaTitulo" colspan="5"><?php echo  _translate("Planificaci&oacute;n")?><a class="show" href="#" clase="planificacion"></a></td>
			</tr>
			<tr><th>Fecha</th><th>Fecha</th><th>Hora</th> <th>editar</th><th>eliminar</th></tr>
		<?php
		if($var->Proyecto->get_Planificacion()){?>
		
			<?php
			foreach($var->Proyecto->get_Planificacion() as $planificacion){
		?>
			<tr class="planificacion">
				<td><?php echo imprimirFecha($planificacion['fecha']); ?></td>
				<td><input type="text" class="fecha" value="<?php echo timestamp2date($planificacion['fecha']); ?>" name="fecha_visita_<?php echo $planificacion['id']?>" /></td>
				<td><input type="text" value="<?php echo $planificacion['hora'];?>" name="hora_visita_<?php echo $planificacion['id']?>" /></td>
				<?php if($_SESSION['usuario_login'] == $planificacion['fk_usuario']) {?>
				<td><a href="#" onclick="editar_visita('<?php echo $planificacion['id']?>')" >guardar</a></td>
				<td style="text-align: center"> <a class="borrar" href="#" onclick="eliminar_visita('<?php echo $planificacion['id']?>')" >eliminar</a></td>
				<?php }?>
			</tr>
		<?php
			}?>
		<?php
		}if($estado['id'] == 3  || ($estado['id'] == 4 && count($var->Proyecto->get_Planificacion()) < $var->Proyecto->get_Numero_Visitas())){ //pendiente de planificación
			if(count($var->Proyecto->get_Planificacion()) < $var->Proyecto->get_Numero_Visitas()){			
				$num_visitas = $var->Proyecto->get_Numero_visitas();
				$planificadas = count($var->Proyecto->get_Planificacion());
				$quedan = $num_visitas-$planificadas;
				?>
			<tr class="planificacion"><td colspan="3"> <?php echo "Quedan ".$quedan." visitas por planificar"?> </td></tr>
			<tr class="planificacion">
				<td></td>
				<td> <input type="text" class="fecha" name="fecha_visita" id="fecha_visita" /> </td>
				<td> <input type="text" name="hora_visita" id="hora_visita" </td>
				<td> <?php if($permisos->escritura && $_SESSION['usuario_login'] == $var->Proyecto->get_Id_Usuario()){?><input type="submit" name="planificar" id="planificar" value="insertar visita" /> <?php }?></td>
			</tr>
		<?php 
			}
		} ?>
		</table>
</div>
<input type="hidden" id="eliminar" name="eliminar" value="0"/>
<input type="hidden" id="cerrar" name="cerrar" value="0"/>
<input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
<input type="hidden" id="tarea_editar" name="tarea_editar" value=""/>
<input type="hidden" id="visita_editar" name="visita_editar" value=""/>
<input type="hidden" id="tarea_eliminar" name="tarea_eliminar" value=""/>
<input type="hidden" id="visita_eliminar" name="visita_eliminar" value=""/>
<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>

</form>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
<?php include($appRoot.'/Common/php/footer.php')?>