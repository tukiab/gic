<?php  include_once('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
include_once('_atajosUsuario.php');
include_once($appRoot.'/Common/php/utils/lang.php');
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');

$OBJAtajosUsuarios=new AtajosUsuarios($_GET,$_SESSION['usuario_login']);

?>
<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Usuarios/js/atajosUsuarios.js' ?>"></script>
<div id="serverMessage" style="float:right;color:#FFFFFF;background-color:#CC0033;font-size:x-small;font-weight:bold;width:350px;"><?php _translate($OBJAtajosUsuarios->msg)?></div>
<table>
	<tr>
		<td class="TituloPag"><?php  _translate("Administraci&oacute;n accesos directos") ?></td>
	</tr>
</table>


<div id="principal">
	<form action="<?php  echo  $_SERVER['PHP_SELF'] ?>" method="GET" >
		<div id="CapaAtajosUsuario" class="block_left"  style="left:15%;top:10em;width:30%;overflow:visible;">
			<p class="titulo" ><?php  _translate("Mis Atajos")?></p>
			
			<ul id="listaAtajosUsuario" style="margin-top:3em;cursor:move;white-space:nowrap;">
			<?php  foreach ($OBJAtajosUsuarios->listadoAtajosUsuarios as $fila){ ?>
				<li id="<?php  echo  $fila['AtajoID']?>" title="<?php  echo  $fila['AtajoDescripcion'] ?>" style="list-style-type:none;" class="sortableitem" ><?php  echo  $fila['AtajoDescripcion'] ?>
						&nbsp;&nbsp;<a href="JavaScript:del('<?php echo  $fila['AtajoID'] ?>')" style="font-size:xx-small;" ><?php  echo  "&#91;x&#93;" ?></a>
					</label>
				</li>
			<?php  }?>
			</ul>
			<p style="position:absolute;bottom:4em;left:2ex;font-size:x-small;">&#8226;&nbsp;<?php _translate("Para ordenar la lista, arrastrar y soltar.")?></p>
			<input type="button" name="boton" id="boton" value="Guardar" style="position:absolute;bottom:2em;right:2ex" onClick="JavaScript:guardar()" />
		</div>
							
		<div id="CapaAtajosDisponibles" class="block_left" style="left:auto;right:15%;top:10em;width:30%;overflow:auto;">
			<p  class="titulo" ><?php  _translate("Atajos Disponibles")?></p>
			<ul id="listaAtajosDisponibles" style="margin-top:3em;white-space:nowrap;">
			<?php  foreach($OBJAtajosUsuarios->listadoAtajosDisponibles as $fila){ ?>
				<li id="<?php  echo  $fila['id'] ?>" title="<?php  echo  $fila['descripcion'] ?>" style="list-style-type:none" >
					<a href="JavaScript:add('<?php  echo  $fila['id'] ?>','<?php  echo  $fila['descripcion'] ?>')"  style="font-size:xx-small;" ><?php  echo  "&#91;<<&#93;" ?></a>&nbsp;&nbsp;
					<?php  echo  $fila['descripcion'] ?>
				</li>
			<?php  } ?>
			</ul>
		</div>
			
		<input type="hidden" name="accion" id="accion" value="0" />
		<input type="hidden" name="datos" id="datos" />
	</form>
</div>
<?php 
include($appRoot.'/Common/php/bottomMenu.php');
include($appRoot.'/Common/php/footer.php');
?>