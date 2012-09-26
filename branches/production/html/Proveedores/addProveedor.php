<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_addProveedor.php');
	$var = new AddProveedor ($_GET);
		
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');	
	?>	
<div id="titulo"><?php echo  _translate("Registrar Proveedor")?></div>
	<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>

	<?php if($permisos->administracion){?>


<div id="contenedor">	
	<form method="GET" target="" action="">
	<div align="center">
	<label class="nota"><a href="<?php  echo $appDir."/Proveedores/addProveedores.php"?>"><?php echo  _translate("Introducir varios proveedores desde archivo")?></a></label><br/>
	  <table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos del Proveedor")?></td>
		</tr>
		<tr>
		  <td class="ColIzq"><?php echo  _translate("Raz&oacute;n social")?>&#42;</td>
		  <td  class="ColDer">
			<input     type="text" name="razon_social" value="<?php echo  $var->opt['razon_social'];?>" />
		  </td>
	    </tr>
	   
		<tr>
		  <td class="ColIzq"><?php echo  _translate("CIF/NIF")?>&#42;</td>
		  <td  class="ColDer">
			<input    type="text" name="NIF" value="<?php echo  $var->opt['NIF'];?>" />
		  </td>
	    </tr>
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("Domicilio")?></td>
		  <td  class="ColDer">
		    <input    type="text"  name="domicilio" value="<?php echo  trim(stripslashes($var->opt['domicilio']));?>" />
		  </td>	
	    </tr>
		<tr>
	      <td class="ColIzq"><?php echo  _translate("Localidad")?></td>
		  <td  class="ColDer">
		  	<input    type="text"  name="localidad" value="<?php echo  trim(stripslashes($var->opt['localidad']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("Provincia")?>&#42;</td>
		  <td  class="ColDer">
		  	<input    type="text"  name="provincia" value="<?php echo  trim(stripslashes($var->opt['provincia']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("CP")?>&#42;</td>
		  <td  class="ColDer">
		  	<input    type="text"  name="CP" value="<?php echo  trim(stripslashes($var->opt['CP']));?>" />
		  </td>	
	    </tr>	
	    <tr>
	      <td class="ColIzq"><?php echo  _translate("Web")?></td>
		  <td  class="ColDer">
		  	<input    type="text"  name="web" value="<?php echo  trim(stripslashes($var->opt['web']));?>" />
		  </td>	
	    </tr>
	 
	  </table>  
	  <input  type="hidden" name="gestor" value="<?php echo  $var->opt['gestor_obj']->get_Id();?>" />
	</div>
	<br/>
	
	<div align="center">
		<table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;" id="contactos">
	  		<tr>
		    	<td colspan="6" class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Otros contactos del proveedor")?></td>
			</tr>
			<tr>
				<th><?php echo  _translate("Nombre")?></th>
				<th><?php echo  _translate("Cargo")?></th>
				<th><?php echo  _translate("Tel�fono")?></th>
				<th><?php echo  _translate("Email")?></th>
			</tr>
			<tr>
				<td style="padding-left:10px;">
					<input style="width:100px;text-align:right;" type="text" name="contacto_nombre" value="<?php  echo $var->opt['contacto_nombre']?>" />&nbsp;
				</td>
				<td style="padding-left:10px;">
					<input style="width:100px;text-align:right;" type="text" name="contacto_cargo" value="<?php  echo $var->opt['contacto_cargo']?>" />&nbsp;
				</td>
				<td style="padding-left:10px;">
					<input style="width:100px;text-align:right;" type="text" name="contacto_telefono" value="<?php  echo $var->opt['contacto_telefono']?>" />&nbsp;
				</td>
				<td style="padding-left:10px;">
					<input style="width:100px;text-align:right;" type="text" name="contacto_email" value="<?php  echo $var->opt['contacto_email']?>" />&nbsp;
				</td>
			</tr>
		</table>
		<label class="nota"><a href="#" onClick="addContacto()" >&#91;<?php echo  _translate("A�adir contacto")?>&#93;</a></label>
		<br/><br/><table>
			<tr>
			<?php if(!$var->opt['encontrado']){?>
				<td colspan="4" style="text-align:right;">
					<input type="submit" name="guardar" value="<?php echo  _translate("Guardar datos")?>" />
				</td>
				<?php }else{?>
			  <td>
				<input  id='continuar' name='continuar' type="submit" value="<?php echo  _translate("Continuar")?>"/>
			  </td>	
		  	  <?php }?>
			</tr>
		</table>
	</div>
	<!-- <div class="MenuInferiorFijo">
	  <table>
		<tr>
		  <?php //if($permisos->escritura){?>
			  <td>
				<input  id='guardar' name='guardar' type="submit" value="<?php echo  _translate("Guardar")?>"/>
			  </td>
			  
		  <?php //}?>
	    </tr>
	  </table>
	</div> -->
	</form>
</div>
	<script type="text/javascript">
	function addContacto(){

		var td_nombre = creaTDContacto('nombre');
		var td_cargo = creaTDContacto('cargo');
		var td_telefono = creaTDContacto('telefono');
		var td_email = creaTDContacto('email');
		
		var table_id = "contactos";
			
		var tr = document.createElement("tr");

		tr.setAttribute("class", "MenuTable");

		tr.appendChild(td_nombre);
		tr.appendChild(td_cargo);
		tr.appendChild(td_telefono);
		tr.appendChild(td_email);
		document.getElementById(table_id).appendChild(tr);
		
	}

	function creaTDContacto(name){
		var input_size="100px";
		var input_name = "contacto_"+name;			
		
		var td = document.createElement("td");
		var inp = document.createElement("input");
		
		inp.type="text"; inp.style.width=input_size; inp.style.textAlign='right'; inp.name=input_name;
		td.appendChild(inp);
		td.style.paddingLeft = '10px';
		td.style.paddingRight = '10px';

		return td;
	}
	
	</script>
<?php }else{
echo  _translate("No tiene permisos suficientes");
}?>
	<?php 
		include($appRoot.'/Common/php/bottomMenu.php');
		include($appRoot.'/Common/php/footer.php');
	?>