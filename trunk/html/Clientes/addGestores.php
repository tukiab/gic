<?php 
/**
 * @ignore
 * @package default
 */

include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once ($appRoot.'/Utils/utils.php');
//Opciones
include ('_editCliente.php');
	$var = new EditCliente($_GET);

include ($appRoot.'/include/html/popupHeader.php');

?>
<div id="titulo"><?php echo  _translate("Añadir gestores")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<div id="contenedor" align="center">
<?php //if($permisos->escritura){?>
<form id="frmGestores" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
	<table>
		<tr>
			<td class="ListaTitulo" style="text-align:center;"><?php echo  _translate("Nombre")?></td>
			<td class="ListaTitulo" style="text-align:center;"><?php echo  _translate("Operaciones")?></td>
		</tr>
			<?php 
			$count = 0;
			while($gestor = $var->datos['lista_gestores']->siguiente()){				
			?>
				<tr class="ListaTitulo" align="center">
					<td align="center">
						<?php echo  $gestor->get_Nombre_Y_Apellidos() ?>
					</td>
					<td><a class="nota" href="#" onclick="add('<?php  echo $gestor->get_Id()?>')"><?php echo  _translate("Añadir")?></a></td>
				</tr>
			<?php $count++;}?>
			
			
		</table>
			<br />
	<!-- ParÃ¡metros ocultos -->
	<input type="hidden" name="id" value="<?php echo  $var->Cliente->get_Id();?>" />
	<input type="hidden" id="id_gestor" name="id_gestor" value="" />
	
	<div  class="bottomMenu">
	<table>
		<tr>
			<td width="40%"></td>
			<td style="text-align:right;" >
				<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
			</td>
		
		</tr>
	</table>
</div>
</form>
</div>
<?php /*}else{
echo  _translate("No tiene permisos suficientes");
}*/?>
<script language="JavaScript" type="text/javascript">
	<!--
	function cerrar(){
		opener.location=opener.location.href;
		window.close();
	}

	function add(idGestor){
		$('#id_gestor').val(idGestor);
		$('#frmGestores').submit();
	}
	-->
</script>
<?php include($appRoot.'/include/html/footer.php')?>