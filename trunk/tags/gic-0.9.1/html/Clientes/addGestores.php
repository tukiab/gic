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
<div id="titulo"><?php echo  _translate("A&ntilde;adir gestores")?></div>
		<?php echo  ($var->msg)?"<div id=\"error_msg\" >".$var->msg."</div>":null;?>
<div >
<?php if($permisos->administracion){?>
<form id="frmGestores" action="<?php echo  $_SERVER['_SELF']?>" method="GET">
	<table>
		<tr>
			<td class="ListaTitulo" ><?php echo  _translate("Nombre")?></td>
			<td class="ListaTitulo" ><?php echo  _translate("Operaciones")?></td>
		</tr>
			<?php 
			$count = 0;
			while($gestor = $var->datos['lista_gestores']->siguiente()){				
			?>
				<tr class="ListaTitulo" >
					<td >
						<?php echo  $gestor->get_Nombre_Y_Apellidos() ?>
					</td>
					<td><a class="nota" href="#" onclick="add('<?php  echo $gestor->get_Id()?>')"><?php echo  _translate("A&ntilde;adir")?></a></td>
				</tr>
			<?php $count++;}?>
			
			
		</table>
			<br />
	<!-- Parámetros ocultos -->
	<input type="hidden" name="id" value="<?php echo  $var->Cliente->get_Id();?>" />
	<input type="hidden" id="id_gestor" name="id_gestor" value="" />
	
	<div  class="bottomMenu">

				<input type="button" onClick="cerrar()" value="<?php echo  _translate("Cerrar")?>"/>
		</div>
</form>
</div>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
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