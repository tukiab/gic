$(document).ready(function(){       
	popUpCal.regional['es'] = {clearText: 'Limpiar', closeText: 'Cerrar',
    prevText: '&lt;Ant', nextText: 'Sig&gt;', currentText: 'Hoy',
    dayNames: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']};
    popUpCal.setDefaults(popUpCal.regional['es']);
    popUpCal.setDefaults({autoPopUp: 'both', buttonImageOnly: true,
    buttonImage: img_cal, buttonText: 'Calendar'});  
    $('.fecha').calendar();
});		
