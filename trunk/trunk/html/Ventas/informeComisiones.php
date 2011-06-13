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
<div id="titulo"><?php echo  _translate("Comisiones")?></div>
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
			$tipos_anteriores = array();
			$par=false;			
			while($venta=$var->lista_Ventas->siguiente()){
				$usuario = $venta->get_Usuario();
				$mes = date("m",$venta->get_Fecha_Aceptado());$mes = (int)$mes;
				$year = date("Y",$venta->get_Fecha_Aceptado());
				$nombre_mes = Fechas::obtenerNombreMes($mes);
				$mes_year = $nombre_mes.'/'.$year;
				$nuevo_mes = ($mes_year != $mes_year_anterior || $usuario != $usuario_anterior);
				$tipo_comision = $venta->get_Tipo_Comision();
				$tipo_venta = $tipo_comision['nombre']; 
				$id_tipo_venta = $tipo_comision['id'];
				$nuevo_tipo = !in_array($usuario.$mes_year.$tipo_venta, $tipos_anteriores);//($tipo_venta != $tipo_anterior) || $nuevo_mes;
					if($nuevo_tipo) $tipos_anteriores[] = $usuario.$mes_year.$tipo_venta;
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
							if($obj['comision'])
								echo formatearImporte($obj['comision'])." &euro;";
							else echo "0"." &euro;";
						}
						?> 
				</td>
				<td>
					<?php
						// mostrar el objetivo acumulado del mes (la primera vez de cada gestor/mes)
						if($nuevo_mes){
							$obj = $Usuario_venta->get_Objetivo_Acumulado($mes);
							echo formatearImporte($obj)." &euro;";
						} ?> 
				</td>
				<td>
					<?php
						// tipo de venta (si ha cambiado)
						if($nuevo_tipo) echo $tipo_venta; ?>
				</td>
				<td>
					<?php
						// Venta del mes: venta de ese gestor en ese mes para ese tipo de venta
						//if($nuevo_mes){
							echo formatearImporte($var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo_venta])." &euro;";
						//} ?>
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
						// Venta acumulada por tipo de venta (venta de ese gestor, para ese tipo acumulado desde enero)
						$venta_acumulada = 0;
						for($month=1;$month<=$mes;$month++){
							$nombre_month = Fechas::obtenerNombreMes($month);
							$venta_acumulada += $var->datos['totales'][$venta->get_Usuario().$nombre_month.'/'.$year.$id_tipo_venta];
						}
						echo formatearImporte($venta_acumulada)." &euro;";
						//echo $var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo_venta]." &euro;"; ?>
				</td>
				<td>
					<?php
						// El % acumulado de venta sólo se calcula si el tipo de venta es objetivable (id de tipo de comisión 1 o 3), si no es 100%,
						// .
						// % Acumulado (Acumulado de ventas/objetivo Acumulado, por tipo, gestor y mes)
						$porc_acumulado = 200;
						if(!in_array($tipo_comision['id'], array(1,3)))
							$porc_acumulado = 100;
						else if($Usuario_venta->get_Objetivo_Acumulado($mes))
							$porc_acumulado = round($venta_acumulada*100/$Usuario_venta->get_Objetivo_Acumulado($mes),2);
						echo $porc_acumulado;?>%
				</td>
				<td>
					<?php
						/** Cálculo de la comisión:
						 *
						 * VCO*(CVi+VP)+VFO*(CVi+VP)+VCNO*CVi+VFNO*CVi+VL*CVi+OV*CVi
						 * La comisión sólo se pondera (tiene en cuenta las penalizaciones) si el tipo de venta es objetivable (id de tipo de comisión 1 o 3),
						 *	si no sólo se tiene en cuenta las comisiones por tipo de venta
						 */
					
						//if($nuevo_mes){
							//foreach($var->lista_Ventas->lista_Tipos_Comision() as $tipoventa){
							//$id_tipo = $tipoventa['id'];

							//Penalización:
							$VP = 0;
							if(in_array($tipo_comision['id'], array(1,3)))
								$VP = $Usuario_venta->get_Penalizacion_Porcentaje($porc_acumulado);

							//Comisión por tipo de venta
							$comision_tipo = $Usuario_venta->get_Comision($id_tipo_venta);
							$CV = $comision_tipo['comision'];
							$total_venta = $var->datos['totales'][$venta->get_Usuario().$mes_year.$id_tipo_venta];

							//Cálculo de la comisión
							$comision =  round($total_venta * ($CV + $VP) /100,1);
							
							//}
							echo formatearImporte($comision)." &euro;";
						//}?>
				</td>
			</tr>
			<?php }
				$mes_year_anterior = $mes_year;
				$tipo_anterior = $tipo_venta;
				$usuario_anterior = $usuario;
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