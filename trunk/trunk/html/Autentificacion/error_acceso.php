<?php
include ('../appRoot.php');

//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
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
include ($appRoot.'/Common/php/footer.php');
?>