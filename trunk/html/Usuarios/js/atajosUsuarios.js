var arrayAtajosDisponibles= new Array();
var arrayAtajosUsuario= new Array();

$(document).ready(function() {
		
	$('#listaAtajosDisponibles li').each(function recorrer(){
		arrayAtajosDisponibles.push(this);
		})	
	$('#listaAtajosUsuario li').each(function recorrer(){
		arrayAtajosUsuario.push(this);		
		})
		
	$('#listaAtajosUsuario').Sortable(
	{
		accept : 'sortableitem',
		opacity: 	0.5,
		fit :	true,
		axis:	'vertically'
	})
	
});




function add(id,descripcion){
	
	var existe=false;
	
	$.each(arrayAtajosUsuario, function (indice,actual){
		if(actual.id==id)
				existe=true;
	});

	if(!existe){
		nuevo = $("<li id=\""+id+"\" style=\"list-style-type:none\">"+descripcion+"&nbsp;&nbsp;</li>");
		nuevo.id = id;
		//	nuevo=document.createElement('li');
		//	nuevo.id=id;
		//	nuevo.title=descripcion;
		//	nuevo.setAttribute('style','list-style-type:none');
		//	textnode=document.createTextNode(nuevo.title);
		
		a=$("<a href=\"JavaScript:del('"+id+"')\" style=\"font-size:xx-small\" >&#91;x&#93;</a>");
		//	a=document.createElement('a');
		//	a.setAttribute('href','JavaScript: del('+id+')');
		//	a.setAttribute('style', 'font-size:xx-small');
		//	text_a=document.createTextNode('[x]');
		
		a.appendTo(nuevo);
		//	a.appendChild(text_a);
		//	nuevo.appendChild(textnode);
		//	nuevo.appendChild(a);
		//	text_a.appendChild(a);
		
		arrayAtajosUsuario.push(nuevo);
		$('#listaAtajosUsuario').append(nuevo);
		$('#listaAtajosUsuario').SortableAddItem(document.getElementById(id));
	}
	else {
		alert("Ya tienes ese atajo en tu lista");
	}
	
}

function del(id)
{
	arrayAtajosUsuario=$.grep(arrayAtajosUsuario, function sacar(actual,indice){
		return actual.id!=id;
	});
	elem = $("#"+id);
	$("#listaAtajosUsuario #"+id).remove();
}

function guardar()
{
	var cadena= new String();
	arrayAtajosUsuario= new Array();
	$('#listaAtajosUsuario li').each(function recorrer(){
		arrayAtajosUsuario.push(this.id);
	});
	
	cadena=arrayAtajosUsuario.join(',');
	document.getElementById('datos').value=cadena;
	
	document.getElementById('accion').value=1;
	document.forms[0].submit();
}
