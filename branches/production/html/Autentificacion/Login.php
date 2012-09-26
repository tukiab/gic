<?php	include ('../appRoot.php');

//Funciones auxiliares:
	include_once ($appRoot.'/Common/php/utils/lang.php');

include ($appRoot.'/Common/php/mensajes.php');
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
?>
<style type="text/css">
	body{
		background: url('<?php echo $appDir?>/Common/imagenes/img/fondo_fb.png') repeat-x;
	}
</style>
<div id="titulo"><?php echo  _translate("Login")?></div>
<form action="" method="POST">
<div id="contenedor" align="center" class="login_div">
	<div id="opcionesBusqueda" style="float:right;">
		<table>
			<tr class="BusquedaTable">
				<td colspan="6" class="ListaTitulo">
					<div style="float:left"><?php echo  _translate("Entrar en el sistema")?></div>
				</td>
			</tr>
			<tr>
				<td class="busquedaIzda">
					<?php echo  _translate('Usuario')?> &nbsp;
				</td>
				<td class="busquedaDcha">
					<input type="text" size="15" name="user" />
				</td>
			</tr>
			<tr>
				<td class="busquedaIzda">
					<?php echo  _translate('Password')?> &nbsp;
				</td>
				<td class="busquedaDcha">
					<input type="password" class="texto" size="15" name="pass" />
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right;background: none;" >
					<input type="submit" name="accion" value="<?php echo  _translate("Entrar");?>" />
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<script language="JavaScript" type="text/javascript">
	//Ponemos el foco en el primer campo del formulario
	document.forms[0].user.focus();
</script>
<?php
include ($appRoot.'/Common/php/footer.php');
?>