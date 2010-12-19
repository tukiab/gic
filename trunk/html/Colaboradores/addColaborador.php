<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include_once($appRoot.'/Utils/utils.php');
	include ('_addColaborador.php');
	$var = new AddColaborador ($_GET);
		
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');
	
	?>
<div id="titulo"><?php echo  _translate("Registrar Colaborador")?></div>
	<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>
<div id="contenedor" align="center">	
	<form method="GET" target="">	

	<?php $gestor = $var->opt['gestor_obj']; $perfil = $gestor->get_Perfil(); $id_perfil = $perfil['id'];
	 if(esAdministrador($id_perfil)){?>
	<label class="nota"><a href="<?php  echo $appDir."/Colaboradores/addColaboradores.php"?>"><?php echo  _translate("Introducir varios colaboradores desde archivo")?></a></label><br/>
	<?php } ?>
	  <table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Datos del Colaborador")?></td>
		</tr>
		<tr>
		  <td nowrap><?php echo  _translate("Raz&oacute;n social")?>&#42;</td>
		  <td >
			<input style="width:100%"  style="width:100%"  type="text" name="razon_social" value="<?php echo  $var->opt['razon_social'];?>" />
		  </td>
	    </tr>
	    
		<tr>
		  <td nowrap><?php echo  _translate("NIF")?></td>
		  <td >
			<input style="width:100%"   type="text" name="NIF" value="<?php echo  $var->opt['NIF'];?>" />
		  </td>
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Domicilio")?></td>
		  <td >
		    <input style="width:100%"   type="text"  name="domicilio" value="<?php echo  trim(stripslashes($var->opt['domicilio']));?>" />
		  </td>	
	    </tr>
		<tr>
	      <td nowrap><?php echo  _translate("Localidad")?>&#42;</td>
		  <td >
		  	<input style="width:100%"   type="text"  name="localidad" value="<?php echo  trim(stripslashes($var->opt['localidad']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Provincia")?></td>
		  <td >
		  	<input style="width:100%"   type="text"  name="provincia" value="<?php echo  trim(stripslashes($var->opt['provincia']));?>" />
		  </td>	
	    </tr> 
		<tr>
	      <td nowrap><?php echo  _translate("CP")?>&#42;</td>
		  <td >
		  	<input style="width:100%"   type="text"  name="CP" value="<?php echo  $var->opt['CP'];?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Comisi&oacute;n (en %)")?>&#42;</td>
		  <td style="text-align:right">
		  	<input type="text" style="width:100%" name="comision" value="<?php echo  $var->opt['comision'];?>" />
		  	
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("Comisi&oacute;n por renovaci&oacute;n (en %)")?></td>
		  <td style="text-align:right">
		  	<input style="width:100%" type="text"  name="comsion_por_renovacion" value="<?php echo  $var->opt['comsion_por_renovacion'];?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td nowrap><?php echo  _translate("CC pago comisiones")?></td>
		  <td >
			<input style="width:100%"   type="text" name="cc_pago_comisiones" value="<?php echo  $var->opt['cc_pago_comisiones'];?>" />
		  </td>	
	    </tr>	
	  </table>  
	 	<table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;" id="contactos">
	  		<tr>
		    	<td colspan="6" class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Otros contactos del colaborador")?></td>
			</tr>
			<tr>
				<th><?php echo  _translate("Nombre")?></th>
				<th><?php echo  _translate("Cargo")?></th>
				<th><?php echo  _translate("Tel&eacute;fono")?></th>
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
		<label class="nota"><a href="#" onClick="addContacto()" >&#91;<?php echo  _translate("A&ntilde;adir contacto")?>&#93;</a></label>
		<br/><br/>
		<table>
			<tr>
			<?php if(!$var->opt['encontrado']){?>
				<td colspan="4" style="text-align:right;">
					<input type="submit" name="guardar" value="<?php echo  _translate("Guardar datos")?>" />
				</td>
				<?php }else{?>
			  <td>
				<input type="submit" name='continuar' value="<?php echo  _translate("Continuar")?>"/>
			  </td>	
		  	  <?php }?>
			</tr>
		</table>

	
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
	<?php 
		include($appRoot.'/include/html/bottomMenu.php');
		include($appRoot.'/include/html/footer.php');
	?>
