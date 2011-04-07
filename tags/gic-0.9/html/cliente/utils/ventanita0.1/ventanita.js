//Variable compartida por todas las instancias de la clase
zIndex = 100;

/*
 *	Clase para crear ventanas
 */
function Ventanita(titulo, url, ancho, alto){
	//Valores por defecto para los parámetros opcionales
	(ancho==null)?ancho='400':null;
	(alto==null)?alto='100':null;
	
	//Variables de la clase
	var uid;			//ID único para cada ventanita
	var cabecera;		//Capa de la cabecera de la ventana
	var redim;			//Capas para el redimensionado
	var conten;			//Capa para el contenido de la ventana
	var titulo = titulo;//Título de la ventana
	
	var ancho = ancho;
	var alto = alto;
	
	//TODO: Hacer la posición de la ventana fija (en medio de la pantalla) e independiente del scroll
	//***********************************************************************************************
	var pos_x;
	var pos_y;
	
	var temp;		//Variable auxiliar para guardar el código html del 
					//contenido durante el redimensionado

	//Función que devuelve un ID único para cada ventana de la página.
		var calcularUID = function(){
			var uid = Math.round(Math.random()*1000);
			if(document.getElementById(uid) == null)
				return uid;
			else
				return calcularUID(); 		
		}
	uid = calcularUID();
	
	//Creamos la capa principal de la ventana. Aquí le definimos el tamaño:
	var windoze = $("<div id=\""+uid+"\" style=\"width:"+ancho+"px;height:"+alto+"px;top:100px;left:150px;\"></div>");

	/*
	 *	Definiendo métodos para los eventos (minimizar, maximizar, cerrar y restaurar):
	 */
			var minimizar = function(){
				guardarEstado();
				
				windoze.css({left: '', top: '', bottom: "0", right: "0", width: "0", height: "0"});
				borrarEventos();
				borrarEfectos();
				
				cabecera.remove();
				cabecera = cabecera_minimizada();
				cabecera.appendTo(windoze);

				$("#minimizar"+uid).bind("click", {}, restaurarEstado);
			}
			var maximizar = function(){
				guardarEstado();
	
				windoze.css({bottom:"0", right: "0", top: "0", left: "0", width: "auto", height: "auto"});
				borrarEventos();
				borrarEfectos();

				cabecera.remove();
				cabecera = cabecera_maximizada();
				cabecera.appendTo(windoze);
				
				$("#maximizar"+uid).bind("click", {}, restaurarEstado);
				$("#cerrar"+uid).bind("click", {}, cerrar);
			}
			var cerrar = function(){
				//	windoze.fadeOut("slow", function(){windoze.remove();});	
				conten.html("");
				windoze.Shrink(200, function(){windoze.remove();});
			}
			var restaurarEstado = function(){
				windoze.css({top: pos_y, left: pos_x, width: ancho, height: alto});
	
				cabecera.remove();
				cabecera = crearCabecera();
				cabecera.appendTo(windoze);

				inicializarEventos();
				inicializarEfectos();
			}
			
			//Método auxiliar para guardar el estado de la ventana (posición y tamaño)
			var guardarEstado = function(){
				ancho = windoze.css("width");
				alto = windoze.css("height");
				pos_x = windoze.css("left");
				pos_y = windoze.css("top");
			}

			//Vacía la ventana durante el redimensionado (mejora el rendimiento)
			var estado_inicio_redimensionado = function(){
				windoze.css("z-index", ++zIndex);
				conten.css("visibility", "hidden");
			}
			//Vuelve a mostrar el contenido cuando termina el redimensionado
			var estado_fin_redimensionado = function(){
				conten.css("visibility", "visible");
			}
												
		//Inicialización de los eventos
			var inicializarEventos = function(){
				borrarEventos();
	
				$("#minimizar"+uid).bind("click", {}, minimizar);
				$("#maximizar"+uid).bind("click", {}, maximizar);
				$("#cerrar"+uid).bind("click", {}, cerrar);
				cabecera.bind("click", function(){ windoze.css("z-index", ++zIndex)});
			}
			var borrarEventos = function(){
	
				$("#minimizar"+uid).unbind();		
				$("#maximizar"+uid).unbind();
				$("#cerrar"+uid).unbind();	
			}
			var inicializarEfectos = function(){
				//Efecto de Arrastrar
				windoze.Draggable({
						handle: 	"#cabecera"+uid,
						zIndex: 	zIndex,
						autoSize:	false,
						opacity:	0.3,
						containment:	'document',
						frameClass:		"arrastrando",
						onStart:	function(){ windoze.css("z-index", zIndex++) }
				});
				//Efecto de redimensionado
				windoze.Resizable({
					onStart:	estado_inicio_redimensionado,
					onStop:		estado_fin_redimensionado,
					handlers: {
												//Capas para el redimensionado hacia:
						se: '#resizeBR'+uid,	//	Abajo-Derecha
						e: '#resizeRight'+uid,	//	Derecha
						s: '#resizeBottom'+uid	//	Abajo
					}
				});
			}
			var borrarEfectos = function(){
				windoze.DraggableDestroy();
				windoze.ResizableDestroy();	
			 }
		
		//Métodos para definir las capas de la ventana (cabecera, redimensionado y contenido)
			var crearCabecera = function(){
				var html = "<div id=\"cabecera"+uid+"\" class=\"cabecera\">"+titulo;
						html += "<div id=\"cerrar"+uid+"\" class=\"v_boton\" style=\"right:0;\">X</div>";
						html += "<div id=\"maximizar"+uid+"\" class=\"v_boton\" style=\"right:1.1em;\">&#91;&#93;</div>";
						html += "<div id=\"minimizar"+uid+"\" class=\"v_boton\" style=\"right:2.2em;\">&#95;</div>";
					html += "</div>";
				return $(html);
			}
			var cabecera_minimizada = function(){
				var html = "<div id=\"cabecera"+uid+"\" class=\"cabecera\">"+titulo;
						html += "<div id=\"minimizar"+uid+"\" class=\"v_boton\" style=\"right:0;\">&#164;</div>";
					html += "</div>";
				return $(html);
			}
			var cabecera_maximizada = function(){
				var html = "<div id=\"cabecera"+uid+"\" class=\"cabecera\">"+titulo;
						html += "<div id=\"cerrar"+uid+"\" class=\"v_boton\" style=\"right:0;\">X</div>";
						html += "<div id=\"maximizar"+uid+"\" class=\"v_boton\" style=\"right:1.1em;\">&#164;</div>";
					html += "</div>";
				return $(html);
			}
			var crearCapasRedimensionado = function(){
				var html = "<div>";
						html += "<div id=\"resizeBottom"+uid+"\" class=\"redim_Abajo\"></div>";
						html += "<div id=\"resizeRight"+uid+"\" class=\"redim_Derecha\"></div>";
						html += "<div id=\"resizeBR"+uid+"\" class=\"redim_AD\"></div>";
					html += "</div>";
				return $(html);
			}
			var crearContenido = function(url){
				var contenido = $("<div id=\""+uid+"\" class=\"contenido\"></div>");
				var iframe = $("<iframe id=\"subcontenido"+uid+"\"></iframe>");
				
				iframe.attr({src: url, width: "100%", height: "100%", scrolling: "auto"});
				iframe.appendTo(contenido);
				
				return contenido;
			}
	
	//Construyendo la ventanita
		cabecera = crearCabecera();
		redim	 = crearCapasRedimensionado();
		conten	 = crearContenido(url);
		
		cabecera.appendTo(windoze);
		redim.appendTo(windoze);
		conten.appendTo(windoze);
		
		windoze.addClass("ventanita");
	
	//Incluyendo la ventanita en la página:
		windoze.appendTo("body");
	
	//Asignando efectos y eventos:
		//Arrastrado y redimensionado
		inicializarEfectos();
		//Eventos para minimizar, maximizar y cerrar la ventana:
		inicializarEventos();
}

