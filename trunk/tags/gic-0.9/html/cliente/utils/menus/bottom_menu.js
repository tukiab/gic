

function showHidUp(id_div){
	var visible = $("#"+id_div).css("display");
	if(visible == 'none'){
		$("#"+id_div).show("fast");
	}else{
		$("#"+id_div).slideUp("fast");
		$("#"+id_div).css("overflow","visible");
	}
}