<?php 
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');

//Opciones:
include ('_addClientes.php');
	$var = new InsertarClientes($_POST, $_FILES);



include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>

<script language="JavaScript" type="text/javascript">

	function check(cBox, txtArea){
		if(cBox.value == 1){
			cBox.value = 0;
			document.getElementById(txtArea).disabled = true;
			//document.getElementById(txtArea).style.visibility = "collapse";
		}
		else{
			cBox.value = 1;
			document.getElementById(txtArea).disabled = false;
			//document.getElementById(txtArea).style.visibility = "visible";
		}
		
	}	

	
	
</script>

<div id="titulo"><?php echo  _translate("Inserci&oacute;n m&uacute;ltiple de empresas")?></div>

<div id="contenedor">

	<form action="" method="POST" enctype="multipart/form-data">
		<table class="FormTitulo">
			<tr>
				<td style="background-color: #fff" <?php echo  $style?> nowrap><?php echo  _translate("Archivo")?>: </td>
				<td style="background-color: #fff">
					<input type="hidden" name="ok" id="ok" value="ok">
					<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="1000000"> 
					<input  <?php echo  $style?> type="file" size="20" name="archivo" id="archivo" value="<?php echo  _translate("Examinar")?>" />
					<label style="font-size: xx-small"><i>Archivo de texto con los datos de las empresas separados por ";" y en orden. Cada empresa irá separada por ":::"</i></label>
				</td>
			</tr>
		</table>
		<table >
			<tr>
				<td style="background-color: #fff">
					<?php //if($permisos->isInRol(3)){?>
						<input type="submit" name="accion" value="<?php echo  _translate("Insertar empresas")?>" />
						<input type="hidden" name="order" value="" />
						<input type="hidden" name="enviado" id="enviado" value="1" />
					<?php //}?>
				</td>
			</tr>
		</table>
	</form>
	<table>	
	<tr>
		<?php  if($_POST['enviado'] == 1){ //Usamos este filtro para que no aparezca recién cargado el mensaje de "debe cargar un archivo"
		?>
		<td style="background-color: #fff">
			<!-- <i><a href="#" onclick="muestra_oculta('lista_errores')" style="font-size: x-small;color: #881e1e;font-weight: bold"><u>Mostrar/Ocultar errores</u></a></i> -->
			<div id="msgs" style="margin: 10px 25px; overflow: auto; height: 450px; font-size: x-small;"><?php  echo $var->opt['msgs'] ?></div>
		</td>
	<?php }?>
	</tr>
	
	</table>
</div>
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>
