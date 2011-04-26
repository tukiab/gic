<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_informeComisiones.php');

//Instanciamso la clase busqueda de ventas.
$var = new InformeComisiones($_GET);
if($permisos->administracion){

if(!$var->opt['exportar']){
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
}
else{
header("Content-type: application/vnd.ms-excel;charset=latin");
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
}
if(!$var->opt['exportar']){
?>
<style type="text/css">
	table{color:#000;}
	table td, table th{padding:4px;}
</style>
<div id="titulo"><?php echo  _translate("Ventas")?></div>
	<?php echo  ($var->opt['msg'])?"<div id=\"error_msg\">".$var->opt['msg']."</div>":null;?>
<div id="contenedor" align="center">
<form method="GET" id="frm_ventas" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->

<div id="opcionesBusqueda">
	<table>
    <tr class="BusquedaTable">
            <td colspan="3" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar ventas")?></div>
            </td>
    </tr>
    <tr>
			<td class="busquedaIzda">
                    <?php echo  _translate('Fecha desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
				<select id="mes_desde" name="mes_desde">
					<?php $mes_desde = $var->opt['mes_desde'];
					foreach(Fechas::listaMeses() as $mes){
					?>
					<option value="<?php echo $mes['num'];?>" <?php if($mes_desde == $mes['num']) echo 'selected="selected"'; ?>>
						<?php echo $mes['nombre']; ?>
					</option>
					<?php }?>
				</select>
			</td>
			<td class="busquedaDcha">
				<select id="year_desde" name="year_desde">
					<?php $year_desde = $var->opt['year_desde'];
					foreach(Fechas::listaYears() as $year){
					?>
					<option value="<?php echo $year;?>" <?php if($year_desde == $year) echo 'selected="selected"'; ?>>
						<?php echo $year; ?>
					</option>
					<?php }?>
				</select>
            </td>
	</tr>
	<tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Fecha hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                <select id="mes_hasta" name="mes_hasta">
					<?php $mes_hasta = $var->opt['mes_hasta'];
					foreach(Fechas::listaMeses() as $mes){
					?>
					<option value="<?php echo $mes['num'];?>" <?php if($mes_hasta == $mes['num']) echo 'selected="selected"'; ?>>
						<?php echo $mes['nombre']; ?>
					</option>
					<?php }?>
				</select>
			</td>
			<td class="busquedaDcha">
				<select id="year_hasta" name="year_hasta">
					<?php $year_hasta = $var->opt['year_hasta'];
					foreach(Fechas::listaYears() as $year){
					?>
					<option value="<?php echo $year;?>" <?php if($year_hasta == $year) echo 'selected="selected"'; ?>>
						<?php echo $year; ?>
					</option>
					<?php }?>
				</select>
            </td>
	</tr>
    <tr >
            <td class="busquedaIzda">
                    <?php echo  _translate('Comercial')?>
            </td>
            <td class="busquedaDcha">
				<select name="gestor">
					<?php
					$gestor_seleccionado = $var->opt['gestor'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
					<?php while($gestor=$var->datos['lista_comerciales']->siguiente()){?>
					<option value="<?php  echo $gestor->get_Id()?>" <?php if($gestor->get_Id() == $gestor_seleccionado) echo  'selected="selected"';?>>
						<?php  echo $gestor->get_Id()?>
					</option>
					<?php }?>
				</select>
            </td>
            <td style="text-align:right;background: none;" >
                    <input type="submit" id="buscar" name="buscar" value="<?php echo  _translate("Generar informe")?>" />
            </td>
    </tr>
</table>
</div>
<br/>
<!-- RESULTADOS -->
<?php }
if($permisos->administracion && $var->resumen && !$var->opt['exportar']){?><!--<input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" />-->
<?php }?>
<?php if(!$var->opt['exportar']){?>
<div class="listado" >
<?php }?>
	<table>
		<thead>
			<tr>
				<th>
					<?php echo _translate("Usuario"); ?>
				</th>
				<th>
					<?php echo _translate("Mes/A&ntilde;o"); ?>
				</th>
				<th>
					<?php echo _translate("Objetivo"); ?>
				</th>
				<th>
					<?php echo _translate("Objetivo acumulado de venta"); ?>
				</th>
				<th>
					<?php echo _translate("Tipo venta"); ?>
				</th>				
				<th>
					<?php echo _translate("Venta del mes"); ?>
				</th>
				<th>
					<?php echo _translate("% del mes");?>
				</th>
				<th>
					<?php echo _translate("Venta acumulada por tipo de venta"); ?>
				</th>
				<th>
					<?php echo _translate("% acumulado"); ?>
				</th>
				<th>
					<?php echo _translate("Comisi&oacute;n"); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			/**
			 * Vamos a recorrer todas las ventas entre las fechas dadas y mostramos comercial, mes/año y objetivos en los casos necesarios
			 * Los totales están calculados en el controlador y aquí se utilizan
			 */
			$usuario_anterior = null;
			$mes_year_anterior = null;
			$tipo_anterior = null;
			$par=false;			FB::info($var->datos['totales']);
			while($venta=$var->lista_Ventas->siguiente()){ FB::warn($venta);
				$mes = date("m",$venta->get_Fecha_Aceptado());$mes = (int)$mes;
				$year = date("Y",$venta->get_Fecha_Aceptado());
				$nombre_mes = Fechas::obtenerNombreMes($mes);
				$mes_year = $nombre_mes.'/'.$year;
				$nuevo_mes = ($mes_year != $mes_year_anterior);
				$tipo_comision = $venta->get_Tipo_Comision();
				$tipo_venta = $tipo_comision['nombre'];
				$id_tipo_venta = $tipo_comision['id'];
				$nuevo_tipo = ($tipo_venta != $tipo_anterior) || $nuevo_mes;
				if($nuevo_mes)$par=!$par;
				if($nuevo_tipo){
			?>
			<tr <?php if($par) echo 'par'; else echo 'impar'; ?>>
				<td>
					<strong>
					<?php
					// Mostrar usuario una vez
					if($usuario_anterior != $venta->get_Usuario()) {
						echo $venta->get_Usuario();
						$usuario_anterior=$venta->get_Usuario();
						$Usuario_venta = new Usuario($venta->get_Usuario());
					} ?>
					</strong>
				</td>
				<td>
					<strong><?php
						// mostrar el mes (la primera vez de cada gestor/mes)
						if($nuevo_mes)echo $mes_year; ?>
					</strong>
				</td>
				<td>
					<?php
						// mostrar el objetivo del mes (la primera vez de cada gestor/mes)
						if($nuevo_mes){
							$obj = $Usuario_venta->get_Objetivo($mes); 
							echo $obj['comision'];
						}
						?>
				</td>
				<td>
					<?php
						// mostrar el objetivo acumulado del mes (la primera vez de cada gestor/mes)
						if($nuevo_mes){
							$obj = $Usuario_venta->get_Objetivo_Acumulado($mes);
							echo $obj;
						} ?>
				</td>
				<td>
					<?php
						// tipo de venta (si ha cambiado)
						if($nuevo_tipo) echo $tipo_venta; ?>
				</td>
				<td>
					<?php
						// Venta del mes (venta de ese gestor en ese mes)
						if($nuevo_mes){
							echo $var->datos['totales'][$venta->get_Usuario().$mes_year];
						} ?>
				</td>
				<td>
					<?php
						// % del mes = importe/total del mes:
						// importe de ese gestor en ese mes para ese tipo de venta dividido por el total de todas las ventas de ese gestor y en ese mes
						if($var->datos['totales'][$venta->get_Usuario().$mes_year])
							echo round($var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo_venta]*100/$var->datos['totales'][$venta->get_Usuario().$mes_year],2); ?>%
				</td>
				<td>
					<?php
						// Venta del mes (venta de ese gestor, para ese tipo y en ese mes)
						echo $var->datos['totales'][$venta->get_Usuario().$year.$id_tipo_venta]; ?>
				</td>
				<td>
					<?php 
						// % Acumulado (Acumulado de ventas/objetivo Acumulado, por tipo, gestor y mes)
						echo round($var->datos['totales'][$venta->get_Usuario().$year.$id_tipo_venta]*100/$Usuario_venta->get_Objetivo_Acumulado($mes),2); ?>%
				</td>
				<td>
					<?php
						// VCO*(CVi+VP)+VFO*(CVi+VP)+VCNO*CVi+VFNO*CVi+VL*CVi+OV*CVi
						if($nuevo_mes){
							$comision = 0;
							foreach($var->lista_Ventas->lista_Tipos_Comision() as $tipoventa){
								$id_tipo = $tipoventa['id'];
								$VP = 0;
								$comision_tipo = $Usuario_venta->get_Comision($id_tipo);
								$CV = $comision_tipo['comision'];
								$total_venta = ($var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo])?$var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo]:0;
								$comision +=  $total_venta * ($CV + $VP);
							}
							echo $comision;
						}?>
				</td>
			</tr>
			<?php }
				$mes_year_anterior = $mes_year;
				$tipo_anterior = $tipo_venta;
			}?>
		</tbody>
	</table>
<?php if(!$var->opt['exportar']){?>
</div>
</form>
</div>
<?php }?>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>