<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/utils/utils.php');

//Opciones
include ('_informeTecnico.php');

//Instanciamso la clase busqueda de proyectos.
$var = new InformeTecnico($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

?>
<style type="text/css">
	#opcionesBusqueda td{width:33%;}
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
                    <?php echo  _translate('Fecha desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
				<select id="mes_desde" name="mes_desde">
					<?php $mes_desde = $var->opt['mes_desde'];
					foreach(listaMeses() as $mes){
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
					foreach(listaYears() as $year){
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
					foreach(listaMeses() as $mes){
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
					foreach(listaYears() as $year){
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
                   <?php echo  _translate("Id proyecto")?>
            </th>
			<th>
                    <?php echo  _translate("Empresa");?>
            </th>
            <th>
                    <?php echo  _translate("Nombre")?>
            </th>

            <th>
                   <?php echo  _translate("T&eacute;nico asignado")?>
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
    <?php $fila_par=true;
    ?>
    <?php while($proyecto = $var->datos['lista_proyectos']->siguiente() ){
        $estado = $proyecto->get_Estado();?>
        <tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>
            <td>
                    <a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $proyecto->get_Id()?>&nbsp;&nbsp;</a>
            </td>
			<td>
				<?php $cliente = $proyecto->get_Cliente();?>
                    <a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $cliente->get_Razon_Social()?>&nbsp;&nbsp;</a>
            </td>
            <td>
                    <?php  echo $proyecto->get_Nombre()?>
            </td>
			<td>
                    <?php  echo $proyecto->get_Id_Usuario();?>
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
                    <?php //unidades incentivables: =unidades si fecha_fin proyecto < fecha_hasta; e.o.c. =0
						$unidades_incentivables = 0;
						if($proyecto->get_Fecha_Fin()<=$var->opt['fecha_hasta'])
							$unidades_incentivables = $proyecto->get_Unidades();
						echo substr($unidades_incentivables,0,5);
					?>
            </td>
			<td>
                    <?php //unidades no incentivables: =horas reales/8 si fecha_fin proyecto < fecha_hasta; e.o.c. =0
						$unidades_no_incentivables = 0;
						if($proyecto->get_Fecha_Fin()>=$var->opt['fecha_hasta'])
							$unidades_no_incentivables = $proyecto->get_Horas_Totales_Reales()/8;
						echo substr($unidades_no_incentivables,0,5);
					?>
            </td>
        </tr>
    <?php
    }?>
    </tbody>
</table>	
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