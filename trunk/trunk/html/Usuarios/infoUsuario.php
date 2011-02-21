<?php
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
include_once($appRoot.'/Utils/utils.php');
require ($appRoot.'/Usuarios/datos/Atajos.php');
	$atajosUsuario = new Atajos();
	$listadoAtajosUsuario=$atajosUsuario->getListaAtajosUsuario($_SESSION['usuario_login']);
		
//Opciones
include ('_infoUsuario.php');
	$var = new infoUsuario($_SESSION['usuario_login'], $_SESSION['usuario_nombre'], $_POST);

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');

include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');

$cfilaPar = "#DDDDDD";
$cfilaImpar = "#EEEEEE";

?>
<style type="text/css">
	td{text-align: center;}
    #inicio_izda, #inicio_dcha{
        width: 48%;
		overflow: auto;
        /*background-color: #fff;*/
    }
    #inicio_izda{
        float: left;
        margin-left: 1%;
    }
    #inicio_dcha{
        float: right;
        margin-right: 1%;
    }
    #inicio_izda > div, #inicio_dcha > div{
        margin-top: 20px;
        /*max-height: 300px;
        overflow: auto;*/
    }
    #inicio_wrapper{
        width: 100%;
        clear:both;
    }

    #inicio-wrapper table{
        width: 90%;
    }
</style>
<div id="titulo"><?php echo  _translate('Inicio - Informaci&oacute;n de usuario');?></div>	

<form action="" method="post">
<div id="contenedor" style="align:center;width:100%;" align="center">
	<!-- <div><table class="ListaGris" >
		<tr style="background-color:<?php  echo  $color ?>">
			<td class="TituloPag" style="background-color:#fff;text-align:left;"><?php echo   _translate("Ir a...") ?></td>
		</tr>
		<?php  if ($listadoAtajosUsuario!=null) {
			if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}	
			foreach($listadoAtajosUsuario as $fila) {?>
		<tr style="background-color:<?php  echo  $color ;?>">
			<td><a href="<?php echo  $appDir.$fila['AtajoURL']?>" >&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;<?php  echo  $fila['AtajoDescripcion'] ?>&nbsp;&nbsp;</a></td>
		</tr>
		<?php  }?>
		<tr>
			<td <?php if($par) echo 'par'; else echo 'impar';?>><?php echo  _translate("Sin atajos") ?></td>
		</tr>
		<?php  } ?>
	</table></div>
	 -->
<div id="inicio-wrapper">

    <div id="inicio_izda">

	<div>
		<table >
			<tr>
				<td class="ListaTitulo" style="text-align:left;" colspan="5"><?php echo  _translate("Ofertas y oportunidades que se definen hoy")?><a class="show" href="#" clase="ofertas_hoy"></a></td>
			</tr>
			<tr class="ofertas_hoy">
				<th style="font-weight: normal;"><?php echo  _translate("Desactivar")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Gestor")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Tipo")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Nombre")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
			</tr>
			<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
				while($oferta = $var->lista_ofertas->siguiente()) {
					$es_oportunidad = $oferta->get_Es_Oportunidad_De_Negocio();
					$cliente_oferta = $oferta->get_Cliente();
				?>
			<tr <?php if($par) echo 'par'; else echo 'impar';?> class="ofertas_hoy">
				<td><input type="checkbox" name="ids_ofertas_leer[]" value="<?php echo $oferta->get_Id();?>"</td>
				<td><?php echo $oferta->get_Usuario();?></td>
				<td><?php if($es_oportunidad) echo "OPORTUNIDAD DE NEGOCIO"; else echo "OFERTA";?></td>
				<td>
					<a href="<?php echo  $appDir.'/Ofertas/showOferta.php?id='.$oferta->get_Id(); ?>"><?php echo $oferta->get_Nombre_Oferta(); ?></a>
				</td>
				<td>
					<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_oferta->get_Id(); ?>"><?php echo $cliente_oferta->get_Razon_Social();?></a>
				</td>
			</tr>
			<?php  }?>

		</table>
	</div>

	<div>
		<table >
			<tr>
				<td class="ListaTitulo" style="text-align:left;" colspan="5"><?php echo  _translate("Ofertas y oportunidades pendientes")?><a class="show" href="#" clase="ofertas_pendientes"></a></td>
			</tr>
			<tr class="ofertas_pendientes">
				<th style="font-weight: normal;"><?php echo  _translate("Desactivar")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Gestor")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Tipo")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Nombre")?></th>
				<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
			</tr>
			<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
				while($oferta = $var->lista_ofertas_pendientes->siguiente()) {

					$es_oportunidad = $oferta->get_Es_Oportunidad_De_Negocio();
					$cliente_oferta = $oferta->get_Cliente();
				?>
			<tr <?php if($par) echo 'par'; else echo 'impar';?> class="ofertas_pendientes">
				<td><input type="checkbox" name="ids_ofertas_leer[]" value="<?php echo $oferta->get_Id();?>"</td>
				<td><?php echo $oferta->get_Usuario();?></td>
				<td><?php if($es_oportunidad) echo "OPORTUNIDAD DE NEGOCIO"; else echo "OFERTA";?></td>
				<td>
					<a href="<?php echo  $appDir.'/Ofertas/showOferta.php?id='.$oferta->get_Id(); ?>"><?php echo $oferta->get_Nombre_Oferta(); ?></a>
				</td>
				<td>
					<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_oferta->get_Id(); ?>"><?php echo $cliente_oferta->get_Razon_Social();?></a>
				</td>
			</tr>
			<?php  }?>

		</table>
	</div>
	
        <div><table >
		<tr>
		  	<td class="ListaTitulo" style="text-align:left;" colspan="4"><?php echo  _translate("Ventas con plazos pendientes (2 semanas)")?><a class="show" href="#" clase="ventas_2_semanas"></a></td>
		</tr>
		<tr class="ventas_2_semanas">
			<th style="font-weight: normal;"><?php echo  _translate("Gestor")?></th>
			<th style="font-weight: normal;"><?php echo  _translate("Nombre")?></th>
			<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
		</tr>
		<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
			while($venta = $var->lista_ventas->siguiente()) {
                            $oferta_venta = $venta->get_Oferta();
				$cliente_venta = $venta->get_Cliente();
			?>
		<tr <?php if($par) echo 'par'; else echo 'impar';?> class="ventas_2_semanas">
			<td><?php echo $oferta_venta->get_Usuario();?></td>
			<td>
				<a href="<?php echo  $appDir.'/Ventas/showVenta.php?id='.$venta->get_Id(); ?>"><?php echo $venta->get_Nombre(); ?></a>
			</td>
			<td>
				<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_venta->get_Id(); ?>"><?php echo $cliente_venta->get_Razon_Social();?></a>
			</td>
		</tr>
		<?php  }?>

	</table></div>
	
	<div><table style="">
		<tr>
		  	<td class="ListaTitulo" style="text-align:left;" colspan="4"><?php echo  _translate("ALARMAS - Empresas que tienen la renovaci&oacute;n en los 3 meses siguientes")?><a class="show" href="#" clase="alarmas"></a></td>
		</tr>
		<tr class="alarmas">
			<th style="font-weight: normal;"><?php echo  _translate("Gestor principal")?></th>
			<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
			<th style="font-weight: normal;"><?php echo  _translate("Fecha Renovaci&oacute;n")?></th>
		</tr>
		<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
			foreach($var->lista_alarmas as $listacliente)
				while($cliente = $listacliente->siguiente()){
			?>
			<tr <?php if($par) echo 'par'; else echo 'impar';?> class="alarmas">
				<td><?php echo $cliente->get_Gestor_Inserta();?></td>
				<td>
					<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>"><?php echo $cliente->get_Razon_Social();?></a>
				</td>
				<td><?php echo timestamp2date($cliente->get_Fecha_Renovacion());?></td>
			</tr>
			<?php }?>

	</table></div>
	
    </div>
    <div id="inicio_dcha">
        <div>
			<table >
				<tr>
					<td class="ListaTitulo" style="text-align:left;" colspan="4"><?php echo  _translate("Acciones del d&iacute;a")?><a class="show" href="#" clase="acciones_hoy"></a></td>
				</tr>
				<tr class="acciones_hoy">
					<th style="font-weight: normal;"><?php echo  _translate("Desactivar")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Gestor")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Acci&oacute;n")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
				</tr>
				<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
					while($accion = $var->lista_acciones_hoy->siguiente()) {

						$tipo_accion = $accion->get_Tipo_Accion();
						$cliente_accion = $accion->get_Cliente();
					?>
				<tr <?php if($par) echo 'par'; else echo 'impar';?> class="acciones_hoy">
					<td><input type="checkbox" name="ids_acciones_leer[]" value="<?php echo $accion->get_Id();?>"</td>
					<td><?php echo $accion->get_Usuario();?></td>
					<td>
						<a href="<?php echo  $appDir.'/Acciones/showAccion.php?id='.$accion->get_Id(); ?>"><?php echo $tipo_accion['nombre']; ?></a>
					</td>
					<td>
						<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_accion['id']; ?>"><?php echo $cliente_accion['razon_social'];?></a>
					</td>
				</tr>
				<?php  }?>

			</table>
		</div>
	
		<div>
			<table>
				<tr>
					<td class="ListaTitulo" style="text-align:left;" colspan="4"><?php echo  _translate("Acciones pendientes")?><a class="show" href="#" clase="acciones_pendientes"></a></td>
				</tr>
				<tr class="acciones_pendientes">
					<th style="font-weight: normal;"><?php echo  _translate("Desactivar")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Gestor")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Acci&oacute;n")?></th>
					<th style="font-weight: normal;"><?php echo  _translate("Empresa")?></th>
				</tr>
				<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
					while($accion = $var->lista_acciones_no_leidas->siguiente()) {

						$tipo_accion = $accion->get_Tipo_Accion();
						$cliente_accion = $accion->get_Cliente();
					?>
				<tr <?php if($par) echo 'par'; else echo 'impar';?> class="acciones_pendientes">
					<td><input type="checkbox" name="ids_acciones_leer[]" value="<?php echo $accion->get_Id();?>"</td>
					<td><?php echo $accion->get_Usuario();?></td>
					<td>
						<a href="<?php echo  $appDir.'/Acciones/showAccion.php?id='.$accion->get_Id(); ?>"><?php echo $tipo_accion['nombre']; ?></a>
					</td>
					<td>
						<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_accion['id']; ?>"><?php echo $cliente_accion['razon_social'];?></a>
					</td>
				</tr>
				<?php  }?>
			</table>
		</div>

    </div>
</div>
	<!-- ATAJOS 
	<div><table style="margin-top:2em">
		<tr>
			<td class="ColCentro">
				<input onClick="javascript:history.back()" type="button" value="<?php echo  _translate("Volver")?>" />
				<input type="button" name="editarAtajos" id="editarAtajos" value="Administrar Atajos" onClick="JavaScript:window.location.replace('<?php  echo  'AtajosUsuario.php'?>')"/>
				<br />
			</td>
		</tr>
	</table></div>
	 -->
<!--
<div id="info_usuario_wrapper" style="position: fixed; left: 50px; bottom: 100px;">
<div><table class="ListaGris" style="border-color:white;width:20%;margin-left:2%;font-family:monospace;font-size:small;">
	<tr style="background-color:#DDDDDD;">
		<td width="15%" style="background-color:#fff;vertical-align:text-top;text-align:left;font-size:small;">
			<strong><?php echo  _translate("Usuario")?></strong>
		</td>
		<td style="background-color:#fff;vertical-align:text-top;font-size:small;">
			<?php echo  $var->id ?>
		</td>
	</tr>
	<tr style="background-color:#EEEEEE;">
		<td style="background-color:#fff;vertical-align:text-top;text-align:left;font-size:small;">
			<strong><?php echo  _translate("Nombre")?></strong>
		</td>
		<td nowrap style="background-color:#fff;vertical-align:text-top;font-size:small;">
			<?php echo  $var->nombre ?>
		</td>
	</tr>
	<tr style="background-color:white">			
		<td colspan="2" >
		</td>
	</tr>
	<tr <?php if($par) echo 'par'; else echo 'impar';?>>
		<td style="background-color:#fff;vertical-align:text-top;text-align:left;font-size:small;">
			<strong><?php echo  _translate("Perfil")?></strong>
		</td>
		<td style="background-color:#fff;vertical-align:text-top;text-align:left;font-size:small;" nowrap >
			<?php echo  $var->perfil->nombre ?>
		</td>
	</tr>
</table></div>
</div> -->
	<div class="bottomMenu">
		<table>
			<tr>
				<td colspan="2" style="text-align:right;" nowrap>
					<label title="<?php echo  _translate("Nueva acci&oacute;n")?>">
						<input type="submit" name="guardar" id="guardar" value="<?php echo  _translate("Guardar")?>" />
					</label>
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>
