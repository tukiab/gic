<?php 	include ('appRoot.php');
	include ($appRoot.'/Utils/lang.php');
	include_once ($appRoot.'/Utils/utils.php');
//Opciones:
include("_mainMenu.php");
	//Inicializando..
	$var_menu = new MainMenu($_SESSION['usuario_login']);
?>
<div id="menuh">
	<ul>
	<?foreach($var_menu->menus as $menu) printMenu($menu);?>
        <li > <a href=<?php echo  "$appDir/Autentificacion/Logout.php"?> ><?php echo  _translate("Salir")?></a></li>
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

