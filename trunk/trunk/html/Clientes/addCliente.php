<?php /**
 * @ignore
 * @package default
 */
	
include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');
	
//Funciones auxiliares:
include ($appRoot.'/Common/php/utils/lang.php');
include_once($appRoot.'/Common/php/utils/utils.php');
	include ('_addCliente.php');
	$var = new AddCliente ($_GET);
		
include ($appRoot.'/Common/php/header.php');
include ($appRoot.'/Common/php/menu.php');
	
	?>
<div id="titulo"><?php echo  _translate("Registrar Empresa")?></div>
	<?php echo  ($var->opt['error_msg'])?"<div id=\"error_msg\" >".$var->opt['error_msg']."</div>":null;?>

<?php if($permisos->escritura){?>

<div id="contenedor" align="center">	
	<form method="GET" target="" action="">

	<?php $gestor = $var->opt['gestor_obj']; $perfil = $gestor->get_Perfil(); $id_perfil = $perfil['id'];
	 if(esAdministrador($id_perfil)){?>
	<label class="nota"><a href="<?php  echo $appDir."/Clientes/addClientes.php"?>"><?php echo  _translate("Introducir varias empresas desde archivo")?></a></label><br/>
	<?php } ?>
	  <table style="margin-top:0.2ex;margin-left:2%;margin-right:2%;">
	  	<tr>
		  <td class="ListaTitulo" colspan="2"><?php echo  _translate("Datos de la Empresa")?></td>
		</tr>
		<tr>
		  <td  class="busquedaIzda"><?php echo  _translate("Raz&oacute;n social")?>&#42;</td>
		  <td class="busquedaIzda">
			<input style="width:100%"  style="width:100%"  type="text" name="razon_social" value="<?php echo  $var->opt['razon_social'];?>" />
		  </td>
	    </tr>
	    <tr>
		  <td  class="busquedaIzda"><?php echo  _translate("Tipo");?>&#42;</td>
		  <td class="busquedaDcha" >
			<select  name="tipo_cliente">
				<?php $tipo_cliente_seleccionado = $var->opt['tipo_cliente'];?>
				<option value="0" <?php if($tipo_cliente_seleccionado == 0) echo 'selected="selected"'; ?>><?php echo _translate("Elegir una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_tipos_clientes'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_cliente_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
			</select>
		  </td>
		</tr>
		<tr>
		  <td  class="busquedaIzda"><?php echo  _translate("Grupo")?></td>
		  <td class="busquedaDcha" >
			<select  name="grupo_empresas">
				<?php 
				$grupo_empresas_seleccionado = $var->opt['grupo_empresas'];?>
				<option value="0" <?php if($grupo_empresas_seleccionado == 0) echo 'selected="selected"'; ?>><?php echo _translate("Elegir una opci&oacute;n");?></option>
				<?php foreach($var->datos['lista_grupos_empresas'] as $tipo){?>
				<option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $grupo_empresas_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
				<?php }?> 
				</select><label class="nota"><a href="<?php  echo $appDir."/Administracion/gestionGrupos.php"?>"><?php echo  _translate("Nuevo")?></a></label>
		  </td>
		</tr>
		<tr>
		  <td  class="busquedaIzda"><?php echo  _translate("CIF/NIF")?></td>
		  <td  class="busquedaDcha">
			<input style="width:100%"   type="text" name="NIF" value="<?php echo  $var->opt['NIF'];?>" />
		  </td>
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Domicilio")?></td>
		  <td  class="busquedaDcha">
		    <input style="width:100%"   type="text"  name="domicilio" value="<?php echo  trim(stripslashes($var->opt['domicilio']));?>" />
		  </td>	
	    </tr>
		<tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Localidad")?>&#42;</td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%"   type="text"  name="localidad" value="<?php echo  trim(stripslashes($var->opt['localidad']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Provincia")?>&#42;</td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%"   type="text"  name="provincia" value="<?php echo  trim(stripslashes($var->opt['provincia']));?>" />
		  </td>	
	    </tr>
		<tr>
	      <td  class="busquedaIzda"><?php echo  _translate("CP")?>&#42;</td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%"   type="text"  name="CP" value="<?php echo  $var->opt['CP'];?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Tel&eacute;fono")?>&#42;</td>
		  <td  class="busquedaDcha">
		  	<input type="text" style="width:100%" name="telefono" value="<?php echo  $var->opt['telefono'];?>" />
		  	
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("FAX")?></td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%" type="text"  name="FAX" value="<?php echo  $var->opt['FAX'];?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("N&uacute;mero de empleados")?></td>
		  <td class="busquedaDcha" >
			<input style="width:100%"   type="text" name="numero_empleados" value="<?php echo  $var->opt['numero_empleados'];?>" />
		  </td>	
	    </tr>	
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Web")?></td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%"   type="text"  name="web" value="<?php echo  trim(stripslashes($var->opt['web']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Sector")?>&#42;</td>
		  <td  class="busquedaDcha">
			<input style="width:100%"   type="text"  name="sector" value="<?php echo  trim(stripslashes($var->opt['sector']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("SPA actual")?></td>
		  <td  class="busquedaDcha">
			<input style="width:100%"   type="text"  name="SPA_actual" value="<?php echo  trim(stripslashes($var->opt['SPA_actual']));?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Fecha de renovaci&oacute;n")?></td>
		  <td  class="busquedaDcha">
			<input style="width:85%"   type="text" class="fecha" name="fecha_renovacion" value="<?php echo  timestamp2date($var->opt['fecha_renovacion']);?>" />
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Norma implantada")?></td>
		  <td  class="busquedaDcha">
		  	<input style="width:100%"   type="text"  name="norma_implantada" value="<?php echo  trim(stripslashes($var->opt['norma_implantada']));?>" />
		  </td>	
	    </tr>	
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Cr&eacute;ditos")?></td>
		  <td  class="busquedaDcha">
			<input style="width:85%"   type="text" name="creditos" value="<?php echo  $var->opt['creditos'];?>" />&euro;
		  </td>	
	    </tr>
	    <tr>
	      <td  class="busquedaIzda"><?php echo  _translate("Gestor que realiza el alta")?></td>
		  <td  class="busquedaDcha">
			<label  ><?php echo  $var->opt['gestor_obj']->get_Nombre_Y_Apellidos();?></label>
		  </td>	
	    </tr>
	  </table>  
	  <input style="width:100%" type="hidden" name="gestor" value="<?php echo  $var->opt['gestor_obj']->get_Id();?>" />

		<table style="margin-top:6.2ex;margin-left:2%;margin-right:2%;" id="contactos">
	  		<tr>
		    	<td colspan="6" class="ListaTitulo" style="text-align:center;" colspan="2"><?php echo  _translate("Otros contactos de la empresa")?></td>
			</tr>
			<tr>
				<th><?php echo  _translate("Nombre")?></th>
				<th><?php echo  _translate("Cargo")?></th>
				<th><?php echo  _translate("Tel&oacute;fono")?></th>
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
				<td colspan="4" >
					<input type="submit" name="guardar" value="<?php echo  _translate("Guardar datos")?>" />
				</td>
				<?php }else{?>
			  <td>

				<a href="<?php echo $appDir.'/Clientes/searchClientes.php' ?>"><input type="button" name='cancelar' value="<?php echo  _translate("Cancelar")?>"/></a>
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
		include($appRoot.'/Common/php/bottomMenu.php');
		include($appRoot.'/Common/php/footer.php');
	?>
<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>