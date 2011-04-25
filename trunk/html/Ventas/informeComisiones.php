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
		<div class="listado" style="width:94%;margin-left:2em;">
			<?php
}
				$totales = array();
			?>
			<?php
			if($var->resumen){?>
			<table>
				<thead>
					<tr>
						<th>
							<?php echo _translate("Usuario"); ?>
						</th>
						<th>
							Mes/A&ntilde;o
						</th>
						<th>
							Objetivo
						</th>
						<th>
							Objetivo acumulado de venta
						</th>
						<th>
							%
						</th>
						<th>
							<?php echo _translate("Tipo venta"); ?>
						</th>
						<th>
							<?php echo _translate("Venta acumulada por tipo de venta"); ?>
						</th>
						<th>
							% acumulado
						</th>
						<th>
							Comisi&oacute;n
						</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach($var->resumen as $user => $informe_usr){
				$total_usuario = end($informe_usr);
				$total_ventas = $total_usuario['num_ventas'];
				$total_clientes = $total_usuario['num_clientes'];
				$total_importe = $total_usuario['importe'];
				if($user){
				?>
					<?php
						$primero = true;
						$fila_par=true;
						$mes_year_anterior = null;

						foreach($informe_usr as $informe_tipo_venta){
							$ULTIMO = ($total_usuario == $informe_tipo_venta);

							if(!$ULTIMO){
								$mes = date("m",$informe_tipo_venta['fecha']);
								$mes_year = Fechas::obtenerNombreMes($mes).'/'.date("Y",$informe_tipo_venta['fecha']);
								$primero_mes = false;
								if($mes_year_anterior != $mes_year){
									$primero_mes = true;
									$mes_year_anterior = $mes_year;
								}

								?>
								<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
									<?php
										$tipo_venta = $informe_tipo_venta['tipo'];
										$num_ventas = $informe_tipo_venta['num_ventas'];
										$num_clientes = $informe_tipo_venta['num_clientes'];
										$importe = $informe_tipo_venta['importe'];
									?>
										<td>
											<?php if($primero) echo "<b>".$user."</b>"; $primero=false;?>
										</td>
										<td>
											<?php if($primero_mes) echo $mes_year;?>
										</td>
										<td>
											<?php 
											if($primero_mes){
												$usuario = new Usuario($user);
												$objetivo = $usuario->get_Objetivo(obtenerMes($informe_tipo_venta['fecha']));
												echo $objetivo['comision'];
											}?>
										</td>
										<td>
											<?php
											if($primero_mes){
												$usuario = new Usuario($user);
												$objetivo = $usuario->get_Objetivo_Acumulado(obtenerMes($informe_tipo_venta['fecha']));
												echo $objetivo;
											}?>
										</td>
										<td>
											<?php echo $num_ventas; ?>
										</td>
										<td>
											<?php echo $informe_tipo_venta['nombre']; ?> <?php if($total_ventas)echo substr($num_ventas*100/$total_ventas,0,4)."%"; ?>
										</td>
										<td>
											<?php echo $num_clientes; ?>
										</td>
										<td>
											<?php if($total_clientes) echo  substr($num_clientes*100/$total_clientes,0,4)."%"; ?>
										</td>
										<td>
											<?php echo $importe; ?>&euro;
										</td>
										<td>
											<?php if($total_importe) echo  substr($importe*100/$total_importe,0,4)."%"; ?>
										</td>
								</tr>
								<?php
									$totales[$tipo_venta]['num_ventas'] += $num_ventas;
									$totales[$tipo_venta]['num_clientes'] += $num_clientes;
									$totales[$tipo_venta]['importe'] += $importe;
									$totales['tipos'][$tipo_venta]['ventas']	+= $num_ventas;
									$totales['tipos'][$tipo_venta]['clientes']	+= $num_clientes;
									$totales['tipos'][$tipo_venta]['importe']	+= $importe;
									$totales['tipos'][$tipo_venta]['nombre'] = $informe_tipo_venta['nombre'];
							}else{?>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td><?php echo  $total_ventas;?></td>
									<td></td>
									<td><?php echo  $total_clientes;?></td>
									<td></td>
									<td><?php echo  $total_importe;?></td>
									<td></td>
								</tr>
					<?php	}
						}?>
			<?php
				$totales['ventas']	+= $total_ventas;
				$totales['clientes']	+= $total_clientes;
				$totales['importe']	+= $total_importe;
			}
		}
		}?>
				<?php
					$total_ventas = $totales['ventas'];
					$total_clientes = $totales['clientes'];
					$total_importe = $totales['importe'];
				?>
				<?php $primero = true;$fila_par=true;
				if(($var->opt['buscar'] || $var->opt['exportar']) && $totales['tipos'])
				 foreach($totales['tipos'] as $informe_tipo_venta){
					$nombre = $informe_tipo_venta['nombre'];
					$num_ventas = $informe_tipo_venta['ventas'];
					$num_clientes = $informe_tipo_venta['clientes'];
					$importe = $informe_tipo_producto['importe'];
				?>
						<tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?>>
							<td>
								<?php if($primero) echo "<b>TOTALES</b>"; $primero=false;?>
							</td>
							<td></td>
							<td></td>
							<td>
								<?php echo $nombre; ?>
							</td>
							<td>
								<?php echo $num_ventas; ?>
							</td>
							<td>
								<?php if($total_ventas)echo substr($num_ventas*100/$total_ventas,0,4)."%"; ?>
							</td>
							<td>
								<?php echo $num_clientes; ?>
							</td>
							<td>
								<?php if($total_clientes)echo substr($num_clientes*100/$total_clientes,0,4)."%"; ?>
							</td>
							<td>
								<?php echo $importe; ?>&euro;
							</td>
							<td>
								<?php if($total_importe)echo substr($importe*100/$total_importe,0,4)."%"; ?>
							</td>
						<?php } ?>
						</tr>
						<tr>
							<td>Total</td><td></td><td></td>
							<td><?php echo  $total_ventas;?></td>
							<td></td>
							<td><?php echo  $total_clientes;?></td>
							<td></td>
							<td><?php echo  $total_importe;?></td>
						</tr>

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