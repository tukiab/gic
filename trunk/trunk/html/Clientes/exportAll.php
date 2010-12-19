<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');

//Opciones
include ('_searchClientes.php');

//Instanciamso la clase busqueda de clientes.
$opt['exportar_todo']=1;
$var = new BusquedaClientes($opt);

?>

<?php if($gestor_actual->esAdministrador()){?>		
	<input type="submit" style="display:none" id="exportar_todo" name="exportar_todo" value="<?php echo  _translate("Exportar todo")?>" />		
<?php }?>
		 
<?php
//if($var->opt['exportar']){
header("Content-type: application/vnd.ms-excel;charset=latin");
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
	<thead>
		<tr>	
		</tr>
	</thead>
	<tbody>
	<?php while($cliente = $var->datos['lista_clientes']->siguiente() ){?>
		<tr>
			<td style="text-align:center;width:5%;">
				<?php  echo $cliente->get_Id()?>							
			</td>	
			<td style="text-align:center;width:5%;">
				<?php  echo utf8_decode($cliente->get_Razon_Social())?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php $tipo = $cliente->get_Tipo_Cliente();  echo  utf8_decode($tipo['nombre']);?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  $grupo = $cliente->get_Grupo_Empresas(); echo  utf8_decode($grupo['nombre']);?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo utf8_decode($cliente->get_Localidad())?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo $cliente->get_CP()?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php echo $cliente->get_Web();?>
			</td>
			<td style="text-align:center;width:5%;">
				sector: <?php  echo utf8_decode($cliente->get_Sector());?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo $cliente->get_Numero_Empleados()?> empleados
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo utf8_decode($cliente->get_SPA_Actual())?>
			</td>
			<td style="text-align:center;width:5%;">
				renovacion: <?php  echo timestamp2date($cliente->get_Fecha_Renovacion())?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo utf8_decode($cliente->get_domicilio())?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php  echo $cliente->get_Telefono()?>
			</td>
			<td> --- </td>
			<?php  foreach($cliente->get_Lista_Contactos() as $contacto){?>
			<td>Contacto:</td>
			<td style="text-align:center;width:5%;">
				<?php echo utf8_decode($contacto->get_Nombre());?>
			</td>	
			<td style="text-align:center;width:5%;">
				<?php echo utf8_decode($contacto->get_Cargo());?>
			</td>	
			<td style="text-align:center;width:5%;">
				<?php echo utf8_decode($contacto->get_Email());?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php echo utf8_decode($contacto->get_Movil());?>
			</td>
			<td style="text-align:center;width:5%;">
				<?php echo utf8_decode($contacto->get_Telefono());?>
			</td>
			<td> </td>
			<?php } ?>
			<td> --- </td>	
			<?php $listaAcciones = $cliente->get_Lista_Acciones();
			foreach ($listaAcciones as $accion){?>
				<td>Accion:</td>
				<td align="center"><?php $tipo = $accion->get_Tipo_Accion(); echo utf8_decode($tipo['nombre']);?></td>
				<td align="center"><?php echo  timestamp2date($accion->get_Fecha());?></td>
				<td align="center"><?php echo  timestamp2date($accion->get_Fecha_Siguiente_Accion());?></td>
				<td align="center"><?php echo  utf8_decode($accion->get_Descripcion());?></td>
				<td></td>
			<?php } ?>
			<td> --- </td>	
			<?php $listaOfertas = $cliente->get_Lista_Ofertas();
			foreach ($listaOfertas as $oferta){ ?>
				<td>Oferta/Oportunidad</td>
				<td align="center"><?php echo  utf8_decode($oferta->get_Nombre_Oferta());?></td>
				<td align="center"><?php echo  utf8_decode($estado['nombre'])?></td>
				<td align="center"><?php echo  timestamp2date($oferta->get_Fecha_Definicion());?></td>
				<td></td>
			<?php } ?>
			<td> --- </td>	
		</tr>
	<?php 
	}?>	
		
	</tbody>
</table>
<?php // }?>

