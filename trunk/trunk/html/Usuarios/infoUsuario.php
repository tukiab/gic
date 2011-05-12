<?php
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
include_once($appRoot.'/Common/php/utils/utils.php');
require ($appRoot.'/Usuarios/datos/Atajos.php');
	$atajosUsuario = new Atajos();
	$listadoAtajosUsuario=$atajosUsuario->getListaAtajosUsuario($_SESSION['usuario_login']);

//Opciones
include ('_infoUsuario.php');
	$var = new infoUsuario($_SESSION['usuario_login'], $_SESSION['usuario_nombre'], $_POST);

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');

include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

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
<div id="contenedor">
		<?php
		$perfil = $var->usuario->get_Perfil();
		if(esPerfilComercial($perfil['id'])){ ?>

		<!-- ofertas y oportunidades de hoy -->

			<table>
				<tr>
					<td class="ListaTitulo"  colspan="5"><?php echo  _translate("Ofertas y oportunidades que se definen hoy")?><a class="show" href="#" clase="ofertas_hoy"></a></td>
				</tr>
				<tr class="ofertas_hoy">
					<th ><?php echo  _translate("Desactivar")?></th>
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("Tipo")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
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
		<!-- ofertas y oportunidades pendientes -->

			<table>
				<tr>
					<td class="ListaTitulo"  colspan="5"><?php echo  _translate("Ofertas y oportunidades pendientes")?><a class="show" href="#" clase="ofertas_pendientes"></a></td>
				</tr>
				<tr class="ofertas_pendientes">
					<th ><?php echo  _translate("Desactivar")?></th>
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("Tipo")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
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

		<!-- ventas con plazos pendientes -->

			<table>
				<tr>
					<td class="ListaTitulo"  colspan="4"><?php echo  _translate("Ventas con plazos pendientes (2 semanas)")?><a class="show" href="#" clase="ventas_2_semanas"></a></td>
				</tr>
				<tr class="ventas_2_semanas">
					<th ><?php echo  _translate("Gestor")?></th>
					<th ><?php echo  _translate("Nombre")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
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
			</table>

		<!-- alarmas -->

			<table >
				<tr>
					<td class="ListaTitulo"  colspan="4"><?php echo  _translate("ALARMAS - Empresas que tienen la renovaci&oacute;n en los 3 meses siguientes")?><a class="show" href="#" clase="alarmas"></a></td>
				</tr>
				<tr class="alarmas">
					<th ><?php echo  _translate("Gestor principal")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
					<th ><?php echo  _translate("Fecha Renovaci&oacute;n")?></th>
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
			</table>

		<?php } $cliente = null;
		if(esPerfilTecnico ($perfil['id'])){?>
		<!-- proyectos -->
			<table>
				<tr>
					<td class="ListaTitulo"  colspan="6"><?php echo  _translate("Proyectos")?><!--<a class="show" href="#" clase="proyectos"></a>--></td>
				</tr>
				<tr class="proyectos">
					<th ><?php echo  _translate("Empresa")?></th>
					<th ><?php echo  _translate("Nombre proyecto")?></th>
					<th ><?php echo  _translate("Estado")?></th>
					<th ><?php echo  _translate("T&eacute;cnico asignado")?></th>
					<th ><?php echo  _translate("Fecha de inicio")?></th>
					<th ><?php echo  _translate("Fecha de finalizaci&oacute;n")?></th>
				</tr>
				<?php $nombre_estado_anterior = null;

				if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
					while($proyecto = $var->lista_proyectos->siguiente()) { 
						$cliente = $proyecto->get_Cliente();
						$estado = $proyecto->get_Estado();
						$nombre_estado = $estado['nombre'];
					?>
				<?php
					//Miramos si ha cambiado de estado, si lo ha hecho imprimimos la cabecera
					if($nombre_estado_anterior != $nombre_estado){
						$nombre_estado_anterior = $nombre_estado;
				?>
					<tr class="proyectos">
						<td class="ListaTitulo" style="text-align: left;" colspan="6"><?php echo "Proyectos ".$nombre_estado?><a class="show" href="#" clase="proyectos_<?php echo $estado['id'];?>"></a></td>
					</tr>
				<?php }?>
				<tr <?php if($par) echo 'par'; else echo 'impar';?> class="proyectos proyectos_<?php echo $estado['id'];?>">
					<td><a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>"><?php echo $cliente->get_Razon_Social();?></a></td>
					<td><a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id();?>"><?php echo $proyecto->get_Nombre();?></a></td>
					<td><?php $estado = $proyecto->get_Estado(); echo $estado['nombre'];?></td>
					<td><?php echo $proyecto->get_Id_Usuario(); ?></td>
					<td><?php echo timestamp2date($proyecto->get_Fecha_Inicio()); ?></td>
					<td><?php echo timestamp2date($proyecto->get_Fecha_Fin()); ?></td>
				</tr>
				<?php  }?>

			</table>

		<?php }?>
    	<!-- acciones del día -->
		<?php if(esPerfilComercial($perfil['id'])){ ?>
    		<table >
				<tr>
					<td class="ListaTitulo"  colspan="5"><?php echo  _translate("Acciones del d&iacute;a")?><a class="show" href="#" clase="acciones_hoy"></a></td>
				</tr>
				<tr class="acciones_hoy">
					<th ><?php echo  _translate("Desactivar")?></th>
					<th ><?php echo  _translate("Gestor")?></th>
					<th>Fecha</th>
					<th ><?php echo  _translate("Acci&oacute;n")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
				</tr>
				<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
					while($accion = $var->lista_acciones_hoy->siguiente()) {

						$tipo_accion = $accion->get_Tipo_Accion();
						$cliente_accion = $accion->get_Cliente();
					?>
				<tr <?php if($par) echo 'par'; else echo 'impar';?> class="acciones_hoy">
					<td><?php if($accion->get_Usuario() == $var->usuario->get_Id()){?><input type="checkbox" name="ids_acciones_leer[]" value="<?php echo $accion->get_Id();?>" /><? }?></td>
					<td><?php echo $accion->get_Usuario();?></td>
					<td><?php echo Fechas::timestamp2date($accion->get_Fecha());?></td>
					<td>
						<a href="<?php echo  $appDir.'/Acciones/showAccion.php?id='.$accion->get_Id(); ?>"><?php echo $tipo_accion['nombre']; ?></a>
					</td>
					<td>
						<a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente_accion['id']; ?>"><?php echo $cliente_accion['razon_social'];?></a>
					</td>
				</tr>
				<?php  }?>

			</table>
		<!-- acciones pendientes -->
			<table>
				<tr>
					<td class="ListaTitulo"  colspan="5"><?php echo  _translate("Acciones pendientes")?><a class="show" href="#" clase="acciones_pendientes"></a></td>
				</tr>
				<tr class="acciones_pendientes">
					<th ><?php echo  _translate("Desactivar")?></th>
					<th ><?php echo  _translate("Gestor")?></th>
					<th>Fecha</th>
					<th ><?php echo  _translate("Acci&oacute;n")?></th>
					<th ><?php echo  _translate("Empresa")?></th>
				</tr>
				<?php  if($par){$color=$cfilaPar;$par=false;}else{$color=$cfilaImpar;$par=true;}
					while($accion = $var->lista_acciones_no_leidas->siguiente()) {

						$tipo_accion = $accion->get_Tipo_Accion();
						$cliente_accion = $accion->get_Cliente();
					?>
				<tr <?php if($par) echo 'par'; else echo 'impar';?> class="acciones_pendientes">
					<td><?php if($accion->get_Usuario() == $var->usuario->get_Id()){?><input type="checkbox" name="ids_acciones_leer[]" value="<?php echo $accion->get_Id();?>" /> <?php }?></td>
					<td><?php echo $accion->get_Usuario();?></td>
					<td><?php echo Fechas::timestamp2date($accion->get_Fecha());?></td>
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
		<?php }?>
     <?php if(esPerfilComercial($perfil['id'])){ ?>
	<div class="bottomMenu">
		<table>
			<tr>
				<td>
					<label title="<?php echo  _translate("Nueva acci&oacute;n")?>">
						<input type="submit" name="guardar" id="guardar" value="<?php echo  _translate("Guardar")?>" />
					</label>
				</td>
			</tr>
		</table>
	</div>
	 <?php }?>
</form>
<?php
include($appRoot.'/Common/php/bottomMenu.php');
include ($appRoot.'/Common/php/footer.php');
?>