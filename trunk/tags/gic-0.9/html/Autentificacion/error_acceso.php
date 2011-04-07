<?php
include ('../appRoot.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>
<table width="100%">
	<tr>
		<td class="TituloPag" nowrap><?_translate("Error de acceso")?></td>
	</tr>
	<tr>
		<td>
			<br />
			<br />
			<p style="text-align:center;"><?_translate("No tiene permisos suficientes")?></p>
			<br />
		</td>
	</tr>
</table>
<?php
include ($appRoot.'/include/html/footer.php');
?>