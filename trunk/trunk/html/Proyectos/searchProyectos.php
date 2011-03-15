<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');
//include ($appRoot.'/cliente/utils/thickbox.php');

//Opciones
include ('_searchProyectos.php');

//Instanciamso la clase busqueda de proyectos.
$var = new BusquedaProyectos($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');

?>
<!-- Funciones varias para mejorar la interfaz -->
<script language="JavaScript" type="text/javascript">
<!--
$(function(){
        $("#mostrarBusqueda").click(function(event) {
                event.preventDefault();
                $("#opcionesBusqueda").slideToggle();
        });
});

function repagina(nav){
        document.forms[0].navigation.value=nav;
        mostrar = document.getElementById("mostrar");
        if(nav!='Exportar')
                mostrar.click();
        else{
                mostrar.click();
        }
        document.forms[0].navigation.value='Inicio'
}
function irpag(numpag){
        var valorpag=document.getElementById('numpag').value;
        mostrar = document.getElementById("mostrar");

        valorpag=parseInt(valorpag);
        if(valorpag=="" || valorpag==undefined)
                valorpag='1';
        document.forms[0].navigation.value='Irpag';
        document.forms[0].page.value=valorpag;
        mostrar.click();
}
function EvaluateText(cadena, obj, e){//evalua la entrada de numeros
        opc = false;
        tecla = (document.all) ? e.keyCode : e.which;
        if(tecla == 13){//Si pulsa intro
                irpag('numpag');//Envia formulario con la nueva pagina
        }else if(tecla==8){//Si pulsa la tecla de borrado
                opc = true;
        }else{
                if (cadena == "%d")
                        if (tecla > 47 && tecla < 58)
                                opc = true;
                if (cadena == "%f"){
                        if (tecla > 47 && tecla < 58)
                                opc = true;
                if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
                        if (tecla == 46)
                                opc = true;
                }

        }
        return opc;
}

//Ordenación:
        //variables: 'order_by' y 'order_by_asc_desc'
function orderBy(order_by){
        if($('#order_by_asc_desc').attr('value') == 'ASC')
                $('#order_by_asc_desc').attr('value', 'DESC');
        else
                $('#order_by_asc_desc').attr('value', 'ASC');

        $('#order_by').attr('value', order_by);
        $('#mostrar').click();
}				
//-->
function eliminar(){
        if(confirm('Confirmar borrado')){
                $('#eliminar').val(1);
                $('#frm_proyectos').submit();
        }
}
function eliminar_todo(){
        if(confirm('Confirmar borrado')){
                $('#eliminar').val(1);
                $('#borrado_total').val(1);
                $('#frm_proyectos').submit();
        }
}

$(document).ready(function(){
    $('#chk_todos').click(function(){
        if($('#chk_todos').attr("checked"))
                $('.chk').attr("checked", "checked");
        else
                $('.chk').removeAttr("checked");
    });
});
</script>

<div id="titulo"><?php echo  _translate("Proyectos")?></div>
<?php if($var->opt['msg']){?>
    <div id="error_msg"><?php echo $var->opt['msg']?>
    <?php if($var->opt['eliminar']){?>
            <a href="#" onclick="eliminar_todo();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar todo")?>" /></a>
    <?php }?>
    </div>
<?php }?>
<div id="contenedor" align="center">
<form method="GET" id="frm_proyectos" action="<?php echo  $_SERVER['_SELF']?>">

<!-- BUSCADOR -->
<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small">>> <?php echo  _translate("Mostrar/Ocultar opciones de b&uacute;squeda")?></a></i><br/>
<div id="opcionesBusqueda">
<table>
    <tr class="BusquedaTable">
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar proyectos")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Nombre')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="nombre" value="<?php  echo $var->opt['nombre']?>"/>
            </td>

            <td class="busquedaIzda">
                    <?php echo  _translate('Estado')?>
            </td>
            <td class="busquedaDcha">
                    <select name="estado">
						<?php
						$estado_seleccionado = $var->opt['estado'];?>
						<option value="0" <?php if($estado_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
						<?php foreach($var->datos['lista_estados'] as $estado){?>
						<option value="<?php  echo $estado['id']?>" <?php if($estado['id'] == $estado_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $estado['nombre']?></option>
						<?php }?>
                    </select>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
            <?php echo  _translate('Fecha inicio desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_inicio_desde" value="<?php  echo timestamp2date($var->opt['fecha_inicio_desde'])?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Fecha inicio hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_inicio_hasta" value="<?php  echo timestamp2date($var->opt['fecha_inicio_hasta'])?>"/>
            </td>
    </tr>
	<tr>
            <td class="busquedaIzda">
            <?php echo  _translate('Fecha finalizaci&oacute:n desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_finalizacion_desde" value="<?php  echo timestamp2date($var->opt['fecha_finalizacion_desde'])?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Fecha finalizaci&oacute;n hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_finalizacion_hasta" value="<?php  echo timestamp2date($var->opt['fecha_finalizacion_hasta'])?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda" <?php if(!$var->gestor->esAdministrador()) echo 'style="display:none"';?>>
                    <?php echo  _translate('Gestor asignado')?> &nbsp;
            </td>
            <td class="busquedaDcha" <?php if(!$var->gestor->esAdministrador())echo 'style="display:none"';?>>
                    <select name="gestor">
                            <?php
                            $gestor_seleccionado = $var->opt['gestor'];?>
                            <option value="0" <?php if($gestor_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Cualquiera")?></option>
                            <?php foreach($var->datos['lista_gestores'] as $gestor){?>
                            <option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $gestor['id']?></option>
                            <?php }?>
                    </select>
            </td>
			<td colspan="2">
    </tr>
    <tr >
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Paginaci&oacute;n y b&uacute;squeda")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('N&uacute;mero de proyectos por p&aacute;gina')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"/>
            </td>
            <td colspan="2" style="text-align:right;background: none;" >
                    <input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar Proyectos")?>" />
                    <input type="hidden" name="navigation" value="" />
                    <input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
                    <input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_proyectos']->num_Resultados();?>" />
                    <!-- Criterios de ordenaci&uacute;n -->
                    <input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
                    <input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
            </td>
    </tr>
</table>
</div>
<br/>
<label class="nota"><a href=<?php echo  $appDir.'/Proyectos/addProyecto.php';?>>>> <?php echo  _translate("A&ntilde;adir proyecto nueva")?> <<</a></label><br/>
<br/>
<!-- RESULTADOS -->
<div class="listado" style="width:94%;margin-left:2em;">
<label class="nota"><?php  echo $var->datos['lista_proyectos']->num_Resultados()." ".Resultados?></label>
<?php if($gestor_actual->esAdministrador()){?><input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" />
<input onclick="if(confirm('Este proceso puede tardar varios minutos. Confirme la exportacion'))window.open('exportAll.php','_blank');" type="button" value="<?php echo  _translate("Exportar todo")?>" />		
<?php }?>
<table>
    <thead>
        <tr>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <input type=checkbox id="chk_todos"/>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('id')" ><?php echo  _translate("Id")?></a>
                    <?php
                            if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='id' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('nombre')" ><?php echo  _translate("Nombre")?></a>
                    <?php
                            if($var->opt['order_by']=='nombre' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='nombre' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('estado')" ><?php echo  _translate("estado")?></a>
                    <?php
                            if($var->opt['order_by']=='estado' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='estado' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('fecha_inicio')" ><?php echo  _translate("Fecha de inicio")?></a>
                    <?php
                            if($var->opt['order_by']=='fecha_inicio' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='fecha_inicio' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
			<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('fecha_fin')" ><?php echo  _translate("Fecha de finalizaci&oacute;")?></a>
                    <?php
                            if($var->opt['order_by']=='fecha_fin' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='fecha_fin' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('gestor')" ><?php echo  _translate("Gestor asignado")?></a>
                    <?php
                            if($var->opt['order_by']=='gestor' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='gestor' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php $fila_par=true;
    ?>
    <?php while($proyecto = $var->datos['lista_proyectos']->siguiente() ){
        $estado = $proyecto->get_Estado();
        $resaltado = "";
        if($estado['id'] == 2)
                $resaltado = 'style="font-weight:bold;"';
        ?>
        <tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>

            <td style="text-align:center;width:5%;">
                    <input class="chk" type=checkbox name="seleccionados[]" <?php if(is_array($var->opt['seleccionados']) && in_array($proyecto->get_Id(),$var->opt['seleccionados'])) echo "checked";?> value="<?php echo $proyecto->get_Id(); ?>" />
            </td>
            <td style="text-align:center;width:5%;">
                    <a href="<?php echo  $appDir.'/Proyectos/showProyecto.php?id='.$proyecto->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $proyecto->get_Id()?>&nbsp;&nbsp;</a>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $proyecto->get_Nombre()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo  $estado['nombre'];?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo timestamp2date($proyecto->get_Fecha_Inicio())?>
            </td>
			<td style="text-align:center;width:5%;">
                    <?php  echo timestamp2date($proyecto->get_Fecha_Fin())?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $proyecto->get_Id_Usuario()?>
            </td>
        </tr>
    <?php
    }?>
        <tr><td></td>
            <td>
                    <?php echo  $var->datos['lista_proyectos']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
            </td>
            <td colspan="15">
                    <div style="display:inline;position:absolute;">
                    <?php if($var->datos['page']>1){?>
                            <a href="javaScript:repagina('Inicio')" title="<?php echo  _translate("Ir a la Primera")?>"><<</a> &nbsp;
                            <a href="javaScript:repagina('Anterior')" title="<?php echo  _translate("Ir a la Anterior")?>"><</a> &nbsp;
                    <?php }?>
                            <?php echo  "P&aacute;gina ";echo  @($var->datos['page']/$var->datos['paso'])+1 ." de ".$var->datos['lastPage']?> &nbsp;
                    <?php if((@($var->datos['page']/$var->datos['paso'])+1) < $var->datos['lastPage']){?>
                            <a href="javaScript:repagina('Siguiente')" title="<?php echo  _translate("Ir a la Siguiente")?>">></a> &nbsp;
                            <a href="javaScript:repagina('Fin')" title="<?php echo  _translate("Ir a la &Uacute;ltima")?>">>></a>
                    <?php }?>
                    </div>
                    <div style="display:inline;float:right;">
                            Ir a p&aacute;gina:
                            <input type="text" name="numpag" id="numpag" value="" size="4" onkeypress="return EvaluateText('%f', this, event);">
                            <input type="button" value="Ir" onclick="javascript:irpag('numpag');">&nbsp;
                    </div>
            </td>
        </tr>
            <?php if($gestor_actual->esAdministrador()){?>
            <tr>
                    <td colspan="16" style="text-align: right;">
                            <a href="#" onclick="eliminar();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar seleccionados")?>" /></a>
                            <input type="hidden" id="eliminar" name="eliminar" value="0"/>
                            <input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
                            <input type="hidden" id="asignar_gestor" name="asignar_gestor" value="0"/>
                            <input type="hidden" id="agregar_grupos" name="agregar_grupos" value="0"/>
                            <input id="mostrarGestores" type="button" value="<?php echo  _translate("Agregar gestores")?>" />
                            <input id="mostrarGrupos" type="button" value="<?php echo  _translate("Agregar grupo")?>" />
                    </td>
            </tr>
            <?php }?>
    </tbody>
</table>
<!-- <input type="hidden" name="id_usuario" id="id_usuario" value="<?php  echo $var->opt['id_usuario']?>" /> -->
</div>
<div id="gestores" style="display:none">
<table>
    <tr class="BusquedaTable">
            <td class="ListaTitulo">
                    <?php echo  _translate("Seleccione el gestor a asignar a los proyectos")?>
            </td>
    </tr>
    <?php foreach($var->datos['lista_gestores'] as $gestor){?>
    <tr>
            <td class="busquedaIzda">
				<select name="gestor_asignar">
					<?php
					$gestor_seleccionado = $var->opt['gestor_asignar'];?>
					<option value="0" <?php if($gestor_seleccionado == 0) echo  "selected:\"selected\"";?>><?php echo  _translate("Ninguno")?></option>
					<?php foreach($var->datos['lista_gestores'] as $gestor){?>
					<option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  "selected:\"selected\"";?>><?php  echo $gestor['id']?></option>
					<?php }?>
				</select>                    
            </td>
    </tr>
    <?php }?>
    <tr>
            <td class="busquedaIzda" style="text-align: right;background:none">
                    <input type="button" onclick="parent.tb_remove();" value="Cancelar" />
                    <input type="button" onclick="parent.asignar_gestor();" value="Agregar" />
            </td>
    </tr>
</table>
</div>		
</form>
</div>
<br />
<br />
<?php 
include($appRoot.'/include/html/bottomMenu.php');
include ($appRoot.'/include/html/footer.php');
?>
<?php }

// ----- ¡¡VAMONOS QUE NOS VAMOS A EXPORTAR!! ----- //
else{ 

header("Content-type: application/vnd.ms-excel;charset=latin");
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
    <thead>
            <tr>

                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Id")?>
                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  utf8_decode("Nombre")?>
                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Estado")?>
                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Fecha de inicio")?>
                    </th>
					<th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Fecha de finalizacion")?>
                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Gestor asignado")?>
                    </th>
            </tr>
    </thead>
    <tbody>
    <?php $fila_par=true;
    ?>
    <?php while($proyecto = $var->datos['lista_proyectos']->siguiente() ){
            $estado = $proyecto->get_Estado();
            $resaltado = "";
            if($estado['id'] == 2)
                    $resaltado = 'style="font-weight:bold;"';
            ?>
            <tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>


                    <td style="text-align:center;width:5%;">
                            <?php  echo $proyecto->get_Id()?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($proyecto->get_Nombre())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo  utf8_decode($estado['nombre']);?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo timestamp2date($proyecto->get_Fecha_Inicio())?>
                    </td>
					<td style="text-align:center;width:5%;">
                            <?php  echo timestamp2date($proyecto->get_Fecha_Fin())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($proyecto->get_Id_Usuario())?>
                    </td>
            </tr>
    <?php
    }?>

    </tbody>
</table>
<?php }?>

