<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_showProyecto.php');
	$var = new ShowProyecto($_GET);

if($var->opt['mostrar_cabecera']){
	include($appRoot.'/include/html/header.php');
	include($appRoot.'/include/html/mainMenu.php');
	include($appRoot.'/include/html/bottomMenu.php');
}
else
	include ($appRoot.'/include/html/popupHeader.php');
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
<?php $nombre = $var->Proyecto->get_Nombre();
$cliente = $var->Proyecto->get_Cliente();
$venta = $var->Proyecto->get_Venta();?>
<div id="titulo"><?php echo  $nombre?></div>
<form id="frm" action="<?php echo  $_SERVER['_SELF'];?>" method="GET">
<div id="contenedor" >
	<!-- **************** DATOS DEL CLIENTE **************** -->
	<div id="izquierda" style="float:left;width:40%;">
		<table style="width:100%">
			<tr>
			  	<td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos del proyecto")?><a class="show" href="#" clase="datos"></a></td>
			</tr>
			<tr class="datos">
				<td class="ColIzq" nowrap><?php echo  _translate("Id proyecto")?>:</td>
				<td class="ColDer"><?php echo  ($var->Proyecto->get_Id());?></td>
			</tr>
			<tr>
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
						<a href="<?php echo  $appDir.'/Ventas/showVenta.php?id='.$cliente->get_Id(); ?>">
							<?php echo  impArrayTelefono($var->Proyecto->get_FAX());?>
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
				<td class="ColDer"><?php echo  $var->Proyecto->get_Duracion();?></td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("Observaciones")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Proyecto->get_Observaciones();?>
				</td>
			</tr>
			<tr>
				<td class="ColIzq" nowrap><?php echo  _translate("T&eacute;cnico asignado")?>:</td>
				<td class="ColDer">
					<?php echo  $var->Proyecto->get_Id_Usuario();?>
				</td>
			</tr>
			<?php 
			//if($permisos->administracion){?>
			<tr>
				<td class="Transparente" colspan="6" style="text-align:right;">
					<?php $url_dest = $appDir."/Proyectos/editProyecto.php?id=".$var->Proyecto->get_Id();?>
					<label class="nota"><a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=800,height=600,scrollbars=yes');"><?php echo  _translate("Editar")?></a></label>
				</td>
			</tr>
			<?php //}?>
		</table>
	</div>
	
	<!-- **************** DEFINICIÓN **************** -->
	<div id="derecha">
		<table style="width:100%;">
			<tr>
				<td class="ListaTitulo" colspan="2"><?php echo  _translate("Definici&oacute;n")?><a class="show" href="#" clase="definicion"></a></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas documentaci&oacute;n")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Documentacion();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas auditor&iacute;a interna")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Auditoria_Interna();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Precio de venta")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Precio_Venta();?>&euro;</td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas de desplazamiento")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Desplazamiento();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas de cada visita")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Cada_Visita();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de visitas")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Numero_Visitas();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Gastos incurridos")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Gastos_Incurridos();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas totales")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Horas_Totales();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Carga de trabajo")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Carga_Trabajo_Mensual();?></td>
			</tr>
			<tr class="definicion">
				<td class="ColIzq" nowrap><?php echo  _translate("Coste de horario de venta")?>:</td>
				<td class="ColDer"><?php echo  $var->Proyecto->get_Coste_Horario_Venta();?></td>
			</tr>
		</table>
		<!-- DEFINICIÓN DESGLOSADA POR SEDES -->
		<table style="width:100%;">
			<tr class="desglose">
				<td class="ListaTitulo" colspan="2"><?php echo  _translate("Desglose por sedes")?><a class="show" href="#" clase="desglose"></a></td>
			</tr>
			<?php foreach($var->Proyecto->get_Definicion_Sedes() as $definicion){?>
			<tr class="desglose">
				<td class="ListaTitulo" colspan="2"><?php echo $definicion['nombre_sede'];?></td>
			</tr>
			<tr class="desglose">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas desplazamiento")?>:</td>
				<td class="ColDer"><?php echo  $definicion['horas_desplazamiento'];?></td>
			</tr>
			<tr class="desglose">
				<td class="ColIzq" nowrap><?php echo  _translate("Horas cada visita")?>:</td>
				<td class="ColDer"><?php echo  $definicion['horas_cada_visita'];?></td>
			</tr>
			<tr class="desglose">
				<td class="ColIzq" nowrap><?php echo  _translate("N&uacute;mero de visitas")?>:</td>
				<td class="ColDer"><?php echo  $definicion['numero_visitas'];?></td>
			</tr>
			<tr class="desglose">
				<td class="ColIzq" nowrap><?php echo  _translate("Gastos incurridos")?>:</td>
				<td class="ColDer"><?php echo  $definicion['gastos_incurridos'];?></td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>
<input type="hidden" id="eliminar" name="eliminar" value="0"/>
<input type="hidden" id="cerrar" name="cerrar" value="0"/>
<input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
<input type=hidden name="id" value="<?php echo $var->opt['id']?>"/>
<div class="bottomMenu">
	<table>
		<tr>
			<td colspan="2" style="text-align:right;" nowrap>
				<?php $url_dest = $appDir.'/definicion/addTareaTecnica.php?id_proyecto='.$var->Proyecto->get_Id();
				//if($permisos->permisoLectura($url_dest)){?>
					<label title="<?php echo  _translate("Nueva tarea")?>">
						<a href="javascript: void(0);" onclick="window.open('<?php echo  $url_dest?>','<?php echo  rand()?>','width=1000,height=600,scrollbars=yes');"><input type="button" name="addAccion" value="<?php echo  _translate("Nueva Acci&oacute;n")?>" /></a>
					</label>
				<?php //}?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?php //if($gestor_actual->esAdministradorTotal()){?>
					<label title="<?php echo  _translate("Cerrar")?>">
						<a href="#" onclick="cerrar();"><input type="button" value="<?php echo  _translate("Cerrar")?>" /></a>

					</label>
				<?php //}?>
			</td>
		</tr>
	</table>
</div>

</form>

<?php include($appRoot.'/include/html/footer.php')?>
