<?php /*
require_once ($appRoot.'/Autentificacion/Usuarios.php');
require_once ($appRoot.'/Usuarios/datos/Atajos.php');
$atajosUsuario = new Atajos();
$listadoAtajosUsuario=$atajosUsuario->getListaAtajosUsuario($_SESSION['usuario_login']);
$atajosPorDefecto = $atajosUsuario->getListaAtajosPorDefecto();
?>
<div class="footerMenu">
	<table>
		<tr>
			<td style="font-weight:bold;font-size:x-small;" nowrap><a style="padding-right:3ex;" class="ldark" href="javascript:void(0);" onClick="showHidUp('footerMenu')"><?php echo  _translate("Ir a")?>...</a></td>
		</tr>
		<tr class="impar">
			<td>
				<div id="footerMenu" style="display:none;overflow:visible;white-space:nowrap;color:black;padding-right:3ex;">
					<ul style="list-style-type:none;">
						<?php if(count($listadoAtajosUsuario)>0){?>
							<?php  foreach($listadoAtajosUsuario as $fila){?>
								<li><a href="<?php  echo  $appDir.$fila['AtajoURL'] ?>"><?php  echo  $fila['AtajoDescripcion'] ?></a></li>
							<?php  } ?>
						<?php }else{?>
					
						<?php }?>
					</ul>
					<?php  //Administración de atajos
					if($atajosPorDefecto){?>
						<p style="width:100%;text-align:right;font-size:x-small;"><a href="<?php  echo  $appDir.$atajosPorDefecto['url'] ?>">&#91;<?php echo  $atajosPorDefecto['descripcion']?>&#93;</a></p>
					<?php }?>		
				</div>
			</td>
		</tr>
	</table>
</div>

<?php */ ?>