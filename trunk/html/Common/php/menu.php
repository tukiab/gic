<?php 	include ('appRoot.php');
	include ($appRoot.'/Common/php/utils/lang.php');
	include_once ($appRoot.'/Common/php/utils/utils.php');
//Opciones:
include("_menu.php");
	//Inicializando..
	$var_menu = new MainMenu($_SESSION['usuario_login']);
?>

<div id="menuh">
	<a id="logo" href="<?php echo $appDir;?>/Usuarios/infoUsuario.php"><img alt="" src="<?php echo $appDir;?>/Common/imagenes/img/logo.png" /></a>
	<ul>
	<?foreach($var_menu->menus as $menu) printMenu($menu);?>
		<?php if($_SESSION['usuario_login']){?>
        <li> <a href=<?php echo  "$appDir/Autentificacion/Logout.php"?> ><?php echo  _translate("Salir ")?><?php echo "(".$_SESSION['usuario_login'].")";?></a></li>
		<?php } ?>
	</ul>
</div>

<?php 
	/* Función recursiva para imprimir el menú principal y sus submenús */
	function printMenu($menu, $sub = false){
		global $permisos;
		if(is_array($menu) && isset($permisos) && $permisos->permisoLectura($menu[1]->url)){
			?>
			<li><a href="#"><?php echo  _translate($menu[0]->tag);?></a>
				<ul>
					<?php foreach($menu as $key=>$submenu){
						if($key!=0)
							printMenu($submenu, true);
					}?>
				</ul>
			</li>
		<?php }else if(!is_array($menu) && isset($permisos) && $permisos->permisoLectura($menu->url)){
		?>
			<li> <a  href="<?php echo  $menu->url?>" ><?php echo  _translate($menu->tag)?></a></li> 
		<?php }else if(!isset($permisos)){?>
			<li> <a href="<?php echo  $menu->url?>" ><?php echo  _translate($menu->tag)?></a></li> 
		<?php }
	}
?>

<?php
if($_SESSION['usuario_login']){?>
	<div class="aviso_sistema">
		<?php
	if(!getIdClientePrincipal()){?>
		<?php
		$usuario = new Usuario($_SESSION['usuario_login']);
		if($usuario->esAdministradorTotal()){
	?>
		No se han definido los datos de su empresa, acceda <strong><a href="<?php echo $appDir?>/Administracion/miEmpresa.php">aqu&iacute;</a></strong>

<?php }else{?>
		No se han definido los datos de su empresa, consulte con el administrador.
<?php }
	}else{?>
		<img alt="" src="<?php echo $appDir;?>/Common/imagenes/img/logo.jpg" style="width:150px;"/>
		<?php } ?>
	</div>
			<?php }?>