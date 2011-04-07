<?php  include ('../appRoot.php');
require ($appRoot.'/Autentificacion/Usuarios.php');

//Funciones auxiliares:
include ($appRoot.'/Utils/lang.php');
include ($appRoot.'/Utils/utils.php');
//include ($appRoot.'/cliente/utils/thickbox.php');

//Opciones
include ('_searchClientes.php');

//Instanciamso la clase busqueda de clientes.
$var = new BusquedaClientes($_GET);

if(!$var->opt['exportar']){
include ($appRoot.'/include/html/header.php');
include ($appRoot.'/include/html/mainMenu.php');

?>
<?php if($permisos->lectura){?>
<!-- Funciones varias para mejorar la interfaz -->
<script language="JavaScript" type="text/javascript">
<!--
$(function(){
        $("#mostrarBusqueda").click(function(event) {
                event.preventDefault();
                $("#opcionesBusqueda").slideToggle();
        });
});

$(function(){
        $("#mostrarGestores").click(function(event) {
                event.preventDefault();
                $("#gestores").slideToggle();
        });
});

$(function(){
        $("#mostrarGrupos").click(function(event) {
                event.preventDefault();
                $("#grupos").slideToggle();
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
                $('#frm_clientes').submit();
        }
}
function eliminar_todo(){
        if(confirm('Confirmar borrado')){
                $('#eliminar').val(1);
                $('#borrado_total').val(1);
                $('#frm_clientes').submit();
        }
}
function agregar_gestores(){
        $('#agregar_gestores').val(1);
        $('#frm_clientes').submit();
}
function agregar_grupos(){
        $('#agregar_grupos').val(1);
        $('#frm_clientes').submit();
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

<div id="titulo"><?php echo  _translate("Empresas")?></div>
<?php if($var->opt['msg']){?>
    <div id="error_msg"><?php echo $var->opt['msg']?>
    <?php if($var->opt['eliminar']){?>
            <a href="#" onclick="eliminar_todo();"><input class="borrar" type="button" value="<?php echo  _translate("Borrar todo")?>" /></a>
    <?php }?>
    </div>
<?php }?>
<div id="contenedor" align="center">
<form method="GET" id="frm_clientes" action="<?php echo  $_SERVER['_SELF']?>">
<!-- BUSCADOR -->
<i><a href="#" id="mostrarBusqueda" style="font-size:xx-small">>> <?php echo  _translate("Mostrar/Ocultar opciones de b&uacute;squeda")?></a></i><br/>
<div id="opcionesBusqueda">
<table>
    <tr class="BusquedaTable">
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar empresas")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Raz&oacute;n social')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="razon_social" value="<?php  echo $var->opt['razon_social']?>"/>
            </td>

            <td class="busquedaIzda">
                    <?php echo  _translate('Tipo')?>
            </td>
            <td class="busquedaDcha">
                    <select name="tipo_cliente">
                    <?php
                    $tipo_cliente_seleccionado = $var->opt['tipo_cliente'];?>
                    <option value="0" <?php if($tipo_cliente_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
                    <?php foreach($var->datos['lista_tipos_clientes'] as $tipo){?>
                    <option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $tipo_cliente_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
                    <?php }?>
                    </select>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Tel&eacute;fono')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="4" name="telefono1" value="<?php echo  $array_tel[0];?>" />&#8212;
                    <input type="text" size="4"  name="telefono2" value="<?php echo  $array_tel[1];?>" />&#8212;
                    <input  type="text" size="4"  name="telefono3" value="<?php echo  $array_tel[2];?>" />
            </td>

            <td class="busquedaIzda">
                    <?php echo  _translate('FAX')?>
            </td>
            <td class="busquedaDcha">
                    <input size="4" type="text"  name="FAX1" value="<?php echo  $array_tel[0];?>" />&#8212;
                    <input size="4" type="text"  name="FAX2" value="<?php echo  $array_tel[1];?>" />&#8212;
                    <input size="4" type="text"  name="FAX3" value="<?php echo  $array_tel[2];?>" />
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Grupo')?>
            </td>
            <td class="busquedaDcha">
                    <select name="grupo_empresas">
                    <?php
                    $grupo_empresas_seleccionado = $var->opt['grupo_empresas'];?>
                    <option value="0" <?php if($grupo_empresas_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
                    <?php foreach($var->datos['lista_grupos_empresas'] as $tipo){?>
                    <option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $grupo_empresas_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
                    <?php }?>
                    </select>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('CIF/NIF')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="NIF" value="<?php  echo $var->opt['NIF']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Domicilio')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="domicilio" value="<?php  echo $var->opt['domicilio']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Localidad')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="localidad" value="<?php  echo $var->opt['localidad']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('N&uacute;mero empleados desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="numero_empleados_min" value="<?php  echo $var->opt['numero_empleados_min']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('N&uacute;mero empleados hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="numero_empleados_max" value="<?php  echo $var->opt['numero_empleados_max']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('CP')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="CP" value="<?php  echo $var->opt['CP']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Sector')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="sector" value="<?php  echo $var->opt['sector']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
            <?php echo  _translate('Fecha renovaci&oacute;n desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_renovacion_desde" value="<?php  echo timestamp2date($var->opt['fecha_renovacion_desde'])?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Fecha renovaci&oacute;n hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" class="fecha" size="12" name="fecha_renovacion_hasta" value="<?php  echo timestamp2date($var->opt['fecha_renovacion_hasta'])?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('SPA Actual')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="SPA_actual" value="<?php  echo $var->opt['SPA_actual']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Norma implantada')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="norma_implantada" value="<?php  echo $var->opt['norma_implantada']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Cr&eacute;ditos desde')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="creditos_desde" value="<?php  echo $var->opt['creditos_desde']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Cr&eacute;ditos hasta')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="creditos_hasta" value="<?php  echo $var->opt['creditos_hasta']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Web')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="web" value="<?php  echo $var->opt['web']?>"/>
            </td>

            <td class="busquedaIzda" <?php $perfil = $var->gestor->get_Perfil(); if(!$permisos->administracion && !esPerfilTecnico($perfil['id'])) echo 'style="display:none"';?>>
                    <?php echo  _translate('Gestor')?> &nbsp;
            </td>
            <td class="busquedaDcha" <?php if(!$permisos->administracion && !esPerfilTecnico($perfil['id'])) echo 'style="display:none"';?>>
                    <select name="gestor">
                            <?php
                            $gestor_seleccionado = $var->opt['gestor'];?>
                            <option value="0" <?php if($gestor_seleccionado == 0) echo  'selected="selected"';?>><?php echo  _translate("Cualquiera")?></option>
                            <?php foreach($var->datos['lista_gestores'] as $gestor){?>
                            <option value="<?php  echo $gestor['id']?>" <?php if($gestor['id'] == $gestor_seleccionado) echo  'selected="selected"';?>><?php  echo $gestor['id']?></option>
                            <?php }?>
                    </select>
            </td>

    </tr>
    <tr >
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar empresas por propiedades de los contactos")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Nombre contacto')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="nombre_contacto" value="<?php  echo $var->opt['contacto']['nombre']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Tel&eacute;fono contacto')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="telefono_contacto" value="<?php  echo $var->opt['contacto']['telefono']?>"/>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Email contacto')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="email_contacto" value="<?php  echo $var->opt['contacto']['email']?>"/>
            </td>
            <td class="busquedaIzda">
                    <?php echo  _translate('Cargo contacto')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="cargo_contacto" value="<?php  echo $var->opt['contacto']['cargo']?>"/>
            </td>
    </tr>

    <tr >
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Filtrar empresas por acciones de trabajo")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('Acciones de trabajo futuras')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <select name="acciones_de_trabajo_futuras" >
                    <?php $acciones_seleccionadas = $var->opt['acciones']['acciones_de_trabajo_futuras'];?>
                    <option value="0">Indiferente</option>
                    <option value="1" <?php if($acciones_seleccionadas == 1) echo "selected=\"selected\""?>>Con acciones de trabajo futuras</option>
                    <option value="2" <?php if($acciones_seleccionadas == 2) echo "selected=\"selected\""?>>Sin acciones de trabajo futuras</option>
                    </select>
            </td>
    </tr>
    <tr >
            <td colspan="4" class="ListaTitulo">
                    <div style="float:left"><?php echo  _translate("Paginaci&oacute;n y b&uacute;squeda")?></div>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <?php echo  _translate('N&uacute;mero de empresas por p&aacute;gina')?> &nbsp;
            </td>
            <td class="busquedaDcha">
                    <input type="text" size="15"name="paso" value="<?php  echo $var->datos['paso']?>"/>
            </td>
            <td colspan="2" style="text-align:right;background: none;" >
                    <input type="submit" id="mostrar" name="mostrar" value="<?php echo  _translate("Buscar Empresas")?>" />
                    <input type="hidden" name="navigation" value="" />
                    <input type="hidden" name="page" value="<?php echo  $var->datos['page']?>" />
                    <input type="hidden" name="total" id="total" value="<?php  echo  $var->datos['lista_clientes']->num_Resultados();?>" />
                    <!-- Criterios de ordenaci&uacute;n -->
                    <input type="hidden" id="order_by" name="order_by" value="<?php echo  $var->opt['order_by']?>" />
                    <input type="hidden" id="order_by_asc_desc" name="order_by_asc_desc" value="<?php echo  $var->opt['order_by_asc_desc']?>" />
            </td>
    </tr>
</table>
</div>
<br/>
<label class="nota"><a href=<?php echo  $appDir.'/Clientes/addCliente.php';?>>>> <?php echo  _translate("A&ntilde;adir empresa nueva")?> <<</a></label><br/>
<br/>
<!-- RESULTADOS -->
<div class="listado" style="width:94%;margin-left:2em;">
<label class="nota"><?php  echo $var->datos['lista_clientes']->num_Resultados()." ".Resultados?></label>
<?php if($permisos->administracion){//if($gestor_actual->esAdministrador()){?>
<input type="submit" id="exportar" name="exportar" value="<?php echo  _translate("Exportar")?>" />
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
                    <a href="#" onClick="javascript:orderBy('razon_social')" ><?php echo  _translate("Raz&oacute;n social")?></a>
                    <?php
                            if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='razon_social' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('tipo')" ><?php echo  _translate("Tipo")?></a>
                    <?php
                            if($var->opt['order_by']=='tipo' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='tipo' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('grupo_empresas')" ><?php echo  _translate("Grupo de empresas")?></a>
                    <?php
                            if($var->opt['order_by']=='grupo_empresas' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='grupo_empresas' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('localidad')" ><?php echo  _translate("Localidad")?></a>
                    <?php
                            if($var->opt['order_by']=='localidad' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='localidad' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('CP')" ><?php echo  _translate("CP")?></a>
                    <?php
                            if($var->opt['order_by']=='CP' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='CP' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('web')" ><?php echo  _translate("Web")?></a>
                    <?php
                            if($var->opt['order_by']=='web' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='web' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('sector')" ><?php echo  _translate("Sector")?></a>
                    <?php
                            if($var->opt['order_by']=='sector' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='sector' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('numero_de_empleados')" ><?php echo  _translate("N&uacute;mero de empleados")?></a>
                    <?php
                            if($var->opt['order_by']=='numero_de_empleados' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='numero_de_empleados' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('SPA_actual')" ><?php echo  _translate("SPA actual")?></a>
                    <?php
                            if($var->opt['order_by']=='SPA_actual' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='SPA_actual' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                    <a href="#" onClick="javascript:orderBy('fecha_renovacion')" ><?php echo  _translate("Fecha de renovaci&oacute;n")?></a>
                    <?php
                            if($var->opt['order_by']=='fecha_renovacion' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='fecha_renovacion' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('domicilio')" ><?php echo  _translate("Domicilio")?></a>
                    <?php
                            if($var->opt['order_by']=='domicilio' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='domicilio' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('telefono')" ><?php echo  _translate("Tel&eacute;fono")?></a>
                    <?php
                            if($var->opt['order_by']=='telefono' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='telefono' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('ultima_accion')" ><?php echo  _translate("Fecha &uacute;ltima acci&oacute;n")?></a>
                    <?php
                            if($var->opt['order_by']=='ultima_accion' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='ultima_accion' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
            <th style="text-align: center;font-size: x-small;font-weight: normal">
                    <a href="#" onClick="javascript:orderBy('contactos')" ><?php echo  _translate("Contactos")?></a>
                    <?php
                            if($var->opt['order_by']=='contactos' && $var->opt['order_by_asc_desc']=='ASC')
                                    echo  "&uarr;";
                            else if($var->opt['order_by']=='contactos' && $var->opt['order_by_asc_desc']=='DESC')
                                    echo  "&darr;";
                    ?>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php $fila_par=true;
    ?>
    <?php while($cliente = $var->datos['lista_clientes']->siguiente() ){
        $tipo = $cliente->get_Tipo_Cliente();
        $resaltado = "";
        if($tipo['id'] == 2)
                $resaltado = 'style="font-weight:bold;"';
        ?>
        <tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>

            <td style="text-align:center;width:5%;">
                    <input class="chk" type=checkbox name="seleccionados[]" <?php if(is_array($var->opt['seleccionados']) && in_array($cliente->get_Id(),$var->opt['seleccionados'])) echo "checked";?> value="<?php echo $cliente->get_Id(); ?>" />
            </td>
            <td style="text-align:center;width:5%;">
                    <a href="<?php echo  $appDir.'/Clientes/showCliente.php?id='.$cliente->get_Id(); ?>">&nbsp;&nbsp;<?php  echo $cliente->get_Id()?>&nbsp;&nbsp;</a>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_Razon_Social()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo  $tipo['nombre'];?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  $grupo = $cliente->get_Grupo_Empresas(); echo  $grupo['nombre'];?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_Localidad()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_CP()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php echo web($cliente->get_Web());?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_Sector()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_Numero_Empleados()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_SPA_Actual()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo timestamp2date($cliente->get_Fecha_Renovacion())?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_domicilio()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo $cliente->get_Telefono()?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  echo timestamp2date($cliente->get_Fecha_Ultima_Accion($var->gestor->get_Id()))?>
            </td>
            <td style="text-align:center;width:5%;">
                    <?php  foreach($cliente->get_Lista_Contactos() as $contacto) echo $contacto->get_Nombre()."<br/>"?>
            </td>
        </tr>
    <?php
    }?>
        <tr><td></td>
            <td>
                    <?php echo  $var->datos['lista_clientes']->num_Resultados()?>&nbsp;<?php echo  _translate("Resultados")?>
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
            <?php if($permisos->administracion){//if($gestor_actual->esAdministrador()){?>
            <tr>
                    <td colspan="16" style="text-align: right;">
                            <input type="hidden" id="eliminar" name="eliminar" value="0"/>
                            <input type="hidden" id="borrado_total" name="borrado_total" value="0"/>
                            <input type="hidden" id="agregar_gestores" name="agregar_gestores" value="0"/>
                            <input type="hidden" id="agregar_grupos" name="agregar_grupos" value="0"/>
                            <?php if($permisos->administracion  && $var->gestor->esAdministradorTotal()){?>
								<a href="#" onclick="eliminar();">
									<input class="borrar" type="button" value="<?php echo  _translate("Borrar seleccionados")?>" />
								</a>
							<?php } if($permisos->administracion){?>
								<input id="mostrarGestores" type="button" value="<?php echo  _translate("Agregar gestores")?>" />
								<input id="mostrarGrupos" type="button" value="<?php echo  _translate("Agregar grupo")?>" />
							<?php }?>
                    </td>
            </tr>
            <?php }?>
    </tbody>
</table>
</div>
<div id="gestores" style="display:none">
<table>
    <tr class="BusquedaTable">
            <td class="ListaTitulo">
                    <?php echo  _translate("Seleccione los gestores a agregar a las empresas")?>
            </td>
    </tr>
    <?php foreach($var->datos['lista_gestores'] as $gestor){?>
    <tr>
            <td class="busquedaIzda">
                    <input style="float:left;" type="checkbox" name="gestores_seleccionados[]" <?php if(is_array($var->opt['gestores_seleccionados']) && in_array($gestor['id'],$var->opt['gestores_seleccionados'])) echo "checked";?> value="<?php echo $gestor['id']; ?>" />
                    <label style="float:left;margin-left:15px;"><?php echo $gestor['id'];?></label>
            </td>
    </tr>
    <?php }?>
    <tr>
            <td class="busquedaIzda" style="text-align: right;background:none">
                    <input type="button" onclick="parent.tb_remove();" value="Cancelar" />
                    <input type="button" onclick="parent.agregar_gestores();" value="Agregar" />
            </td>
    </tr>
</table>
</div>
<div id="grupos" style="display:none">
<table>
    <tr class="BusquedaTable">
            <td class="ListaTitulo">
                    <?php echo  _translate("Seleccione el grupo a agregar a las empresas")?>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda">
                    <select name="grupo_seleccionado">
                            <?php
                            $grupo_empresas_seleccionado = $var->opt['grupo_seleccionado'];?>
                            <?php foreach($var->datos['lista_grupos_empresas'] as $tipo){?>
                            <option value="<?php  echo $tipo['id']?>" <?php if($tipo['id'] == $grupo_empresas_seleccionado) echo  'selected="selected"';?>><?php  echo $tipo['nombre']?></option>
                            <?php }?>
                    </select>
            </td>
    </tr>
    <tr>
            <td class="busquedaIzda" style="text-align: right;background:none">
                    <input type="button" onclick="parent.tb_remove();" value="Cancelar" />
                    <input type="button" onclick="parent.agregar_grupos();" value="Agregar" />
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
                            <?php echo  utf8_decode("Razon social")?>

                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Tipo")?>

                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Grupo de empresas")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Localidad")?>

                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("CP")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Web")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Sector")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  utf8_decode("Numero de empleados")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("SPA Actual")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal" nowrap>
                            <?php echo  _translate("Fecha de renovacion")?>

                    </th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Domicilio")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  utf8_decode("Telefono")?></th>
                    <th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Contactos")?></th>
                    <!--<th style="text-align: center;font-size: x-small;font-weight: normal"><?php echo  _translate("Operaciones")?></th>-->
            </tr>
    </thead>
    <tbody>
    <?php $fila_par=true;
    ?>
    <?php while($cliente = $var->datos['lista_clientes']->siguiente() ){
            $tipo = $cliente->get_Tipo_Cliente();
            $resaltado = "";
            if($tipo['id'] == 2)
                    $resaltado = 'style="font-weight:bold;"';
            ?>
            <tr <?php echo  ($fila_par)?"par":"impar";$fila_par=(!$fila_par);?> <?php  echo $resaltado?>>


                    <td style="text-align:center;width:5%;">
                            <?php  echo $cliente->get_Id()?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($cliente->get_Razon_Social())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo  utf8_decode($tipo['nombre']);?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  $grupo = $cliente->get_Grupo_Empresas(); echo  utf8_decode($grupo['nombre']);?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($cliente->get_Localidad())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo $cliente->get_CP()?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php echo $cliente->get_Web();?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($cliente->get_Sector());?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo $cliente->get_Numero_Empleados()?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($cliente->get_SPA_Actual())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo timestamp2date($cliente->get_Fecha_Renovacion())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo utf8_decode($cliente->get_domicilio())?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  echo $cliente->get_Telefono()?>
                    </td>
                    <td style="text-align:center;width:5%;">
                            <?php  foreach($cliente->get_Lista_Contactos() as $contacto) echo utf8_decode($contacto->get_Nombre())."<br/>"?>
                    </td>
            </tr>
    <?php
    }?>

    </tbody>
</table>
<?php }?>
<?php }else{
	echo _translate("No tiene suficientes permisos");
}?>