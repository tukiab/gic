<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_informeTecnicoMensual.php');

//Instanciamso la clase busqueda de proyectos.
$var = new InformeTecnicoMensual($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

?>
<style type="text/css">
	#opcionesBusqueda td{width:33%;}
	tr.total{background: #ccc;}
	tr.total td{padding:15px;}
</style>
<!-- Funciones varias para mejorar la interfaz -->
<script language="JavaScript" type="text/javascript">
</script>

<div id="titulo"><?php echo  _translate("Informe t&eacute;cnico")?></div>
<?php if( $var->opt['msg']){?>
<div id="error_msg">
	<?php echo $var->opt['msg']?>
</div>
<?php } ?>
<?php if($permisos->lectura){?>
<div id="contenedor" align="center">
<form method="GET" id="frm_proyectos" action="<?php echo  $_SERVER['_SELF']?>">

<div id="opcionesBusqueda">
<table>
    <tr class="BusquedaTable">
            <td colspan="3" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar proyectos")?></div>
            </td>
    </tr>
    <tr>
			<td class="busquedaIzda">
                    <?php echo  _translate('Mes/A&ntilde;o')?> &nbsp;
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
    <tr >
            <td class="busquedaIzda">
                    <?php echo  _translate('T&eacute;cnico')?>
            </td>
            <td class="busquedaDcha">
				<select name="gestor">
					<?php
					$gestor_seleccionado = $var->opt['gestor'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
					<?php while($gestor=$var->datos['lista_tecnicos']->siguiente()){?>
					<option value="<?php  echo $gestor->get_Id()?>" <?php if($gestor->get_Id() == $gestor_seleccionado) echo  'selected="selected"';?>>
						<?php  echo $gestor->get_Id()?>
					</option>
					<?php }?>
				</select>
            </td>
            <td style="text-align:right;background: none;" >
                    <input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Generar informe")?>" />
            </td>
    </tr>
</table>
</div>

<!-- RESULTADOS -->
<div class="listado">
<table>
    <thead>
        <tr>
			<th>
                   <?php echo  _translate("Mes/A&ntilde;o")?>
            </th>
			<th>
                   <?php echo  _translate("T&eacute;nico asignado")?>
            </th>
            <th>
                   <?php echo  _translate("Id proyecto")?>
            </th>
            <th>
                    <?php echo  _translate("Proyecto")?>
            </th>
			<th>
                    <?php echo  _translate("Empresa");?>
            </th>            
            <th>
                   <?php echo  _translate("Estado")?>
            </th>
            <th>
                    <?php echo  _translate("Fecha de inicio")?>
            </th>
			<th>
                    <?php echo  _translate("Fecha de finalizaci&oacute;n")?>
            </th>
			<th>
                    <?php echo  _translate("Unidades incentivables");?>
            </th>
			<th>
                    <?php echo  _translate("Unidades no incentivables");?>
            </th>
        </tr>
    </thead>
    <tbody>
	<?php
		/*
		 * Vamos a recorrer todos los meses entre las fechas dadas.
		 * Para cada mes recorremos los proyectos, y si en el mes dado el proyecto estaba "vivo" (había comenzado)
		 *	imprimimos la información relativa al proyecto
		 */
		$mes  = $var->opt['mes_desde'];
		$year = $var->opt['year_desde'];
		
		//while(Fechas::date2timestamp('1/'.$mes.'/'.$year) < $var->opt['fecha_hasta']){
			$nombre_mes = Fechas::obtenerNombreMes($mes);
			$primero_mes = true; //para imprimir el nombre del mes
			$var->datos['lista_proyectos']->inicio();
			$fila_par=true;
			$usr_anterior = null;
			$totales = array();
			
			while($proyecto = $var->datos['lista_proyectos']->siguiente() ){
				//if($proyecto->get_Fecha_Inicio() < Fechas::date2timestamp(date('1/'.$mes.'/'.$year))){
					$estado = $proyecto->get_Estado();
					if($proyecto->get_Id_Usuario()) $usr_proyecto = $proyecto->get_Id_Usuario(); else $usr_proyecto = "Sin asignar";
					$nuevo_usr = false;
					if($usr_anterior != $usr_proyecto){						
						$nuevo_usr = true;
						$fila_par=(!$fila_par);
					}

					// Imprimimos la fila de totales del usuario anterior (si lo había)
					if($nuevo_usr && $usr_anterior!=null){?>
					<tr class="total">
						<td>Total</td>
						<td colspan="7"></td>
						<td><?php echo round($totales[$usr_anterior.'incentivables'],2); ?></td>
						<td><?php echo round($totales[$usr_anterior.'noincentivables'],2); ?></td>
					</tr>
			<?php	}
					?>
					<tr <?php echo  ($fila_par)?"par":"impar";?> <?php  echo $resaltado?> >
						<td>
							<strong><?php if($primero_mes) {echo $nombre_mes.'/'.$year; $primero_mes = false;}?></strong>
						</td>
						<td>
							<strong><?php if($nuevo_usr)echo $usr_proyecto; ?></strong>
						</td>
						<td>
							<a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $proyecto->get_Id()?>&nbsp;&nbsp;</a>
						</td>
						<td>
							<?php  echo $proyecto->get_Nombre()?>
						</td>
						<td>
							<?php $cliente = $proyecto->get_Cliente();?>
							<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $cliente->get_Razon_Social()?>&nbsp;&nbsp;</a>
						</td>
						<td>
							<?php  echo  $estado['nombre'];?>
						</td>
						<td>
							<?php  echo timestamp2date($proyecto->get_Fecha_Inicio())?>
						</td>
						<td>
							<?php  echo timestamp2date($proyecto->get_Fecha_Fin())?>
						</td>
						<td>
							<?php 
								//unidades incentivables: =unidades si fecha_fin proyecto < fecha_hasta; e.o.c. =0
								if($proyecto->get_Id_Venta()){
									/*Proyectos "normales" derivados de una venta:
									 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo, LAS HORAS TEÓRICAS (HT*)=HORAS INCENTIVABLES
										HT*= Horas teóricas TOTALES del proyecto/ número de meses TEÓRICOS de duración del proyecto.
									 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo, LAS HORAS INCENTIVABLES es siempre CERO
									 */
									$unidades_incentivables = 0;
									if($proyecto->get_Fecha_Fin() > date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year))
										$unidades_incentivables = $proyecto->get_Unidades();
									echo round($unidades_incentivables,2);
								}else{
									/*Proyectos creados DIRECTAMENTE por el director técnico.
									 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo, LAS HORAS REALES dedicada por el técnico en ese
										mes a ese proyecto=HORAS INCENTIVABLES
									 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo, LAS HORAS INCENTIVABLES es siempre CERO
									 */
									$unidades_incentivables = 0;
									if($proyecto->get_Fecha_Fin() > date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year))
										$unidades_incentivables = $proyecto->get_Horas_Totales_Reales();
									echo round($unidades_incentivables,2);
								}
								$totales[$usr_proyecto.'incentivables'] += $unidades_incentivables;
							?>
						</td>
						<td>
							<?php //unidades no incentivables: =horas reales/8 si fecha_fin proyecto < fecha_hasta; e.o.c. =0

								if($proyecto->get_Id_Venta()){
									/*Proyectos "normales" derivados de una venta:
									 * Las HORAS REALES dedicada por el técnico en ese mes a ese proyecto=HORAS NO INCENTIVABLES.
									 */
									$unidades_no_incentivables = $proyecto->get_Horas_Totales_Reales();
									echo round($unidades_no_incentivables,2);
								}else{
									/*Proyectos creados DIRECTAMENTE por el director técnico.
									 * Si EL MES de la fecha fin del proyecto es MAYOR que el MES de calculo
										las HORAS NO INCENTIVABLES son siempre CERO
									 * Si EL MES de la fecha fin del proyecto es MENOR que el MES de calculo
										las HORAS REALES dedicada por el técnico en ese mes a ese proyecto=HORAS NO INCENTIVABLES
									 */
									$unidades_no_incentivables = 0;
									if($proyecto->get_Fecha_Fin() <= date2timestamp(Fechas::numeroDeDias($mes, $year).'/'.$mes.'/'.$year))
										$unidades_no_incentivables = $proyecto->get_Horas_Totales_Reales();
									echo round($unidades_no_incentivables,2);
								}
								$totales[$usr_proyecto.'noincentivables'] += $unidades_no_incentivables;
							?>
						</td>
					</tr>
	<?php $usr_anterior = $usr_proyecto;
				//}
			} ?>
					<tr class="total">>
						<td>Total</td>
						<td colspan="7"></td>
						<td><?php echo round($totales[$usr_anterior.'incentivables'],2); ?></td>
						<td><?php echo round($totales[$usr_anterior.'noincentivables'],2); ?></td>
					</tr>
	<?php
		/*	$siguiente_mes = Fechas::siguienteMes($mes);
			$mes = $siguiente_mes;
			if($mes == 1)
				$year++;*/
		//}
	?>
    </tbody>
</table>
</div>
</form>
</div>
<?php 
include($appRoot.'/Common/php/bottomMenu.php');
include ($appRoot.'/Common/php/footer.php');
?>
<?php }
?>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>