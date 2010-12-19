<?php	include ('../appRoot.php');

//Comprobamos si el puerto es el adecuado.
/*if($_SERVER['SERVER_PORT']!='443')
	@header("Location: https://$peticion_url");
*/
//Funciones auxiliares:
	include_once ($appRoot.'/Utils/lang.php');

include ($appRoot.'/include/mensajes.php');
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
?>
<div id="titulo"><?php echo  _translate("Login")?></div>
<div id="contenedor" align="center">
<table>
	<tr>
		<td style="background: none">
			<form action="" method="POST">
			<table>
				<tr>
					<td style="background: none">
						<table class="FormTitulo">
							<tr>
								<td style="background: none" colspan="2" nowrap>
									<?php if (isset($_GET["errno"])){?>
										<?php echo  _translate($msgs[$_GET["errno"]]);?>
									<?php }?>
								</td>
							</tr>
							<tr>
								<td style="background: none" class="ColIzq"><?php echo  _translate("Usuario");?>:</td>
								<td style="background: none" class="ColDer">
									<input type="hidden" name="secure" value="sigila" />
									<input type="text" name="user" size="15" />
								</td>
							</tr>
							<tr>
								<td style="background: none" class="ColIzq"><?php echo  _translate("Password");?>:</td>
								<td style="background: none" class="ColDer">
									<input type="password" name="pass" size="15" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="background: none">
						<table class="Botoncitos">
							<tr>
								<td style="background: none">
									<input type="submit" name="accion" value="<?php echo  _translate("Entrar");?>" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</div>
<script language="JavaScript" type="text/javascript">
	//Ponemos el foco en el primer campo del formulario
	document.forms[0].user.focus();
</script>
<?php
include ($appRoot.'/include/html/footer.php');
?>