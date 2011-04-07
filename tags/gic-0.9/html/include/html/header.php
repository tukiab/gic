<?php include ('appRoot.php');
	//Funciones auxiliares:
	include ($appRoot.'/Utils/lang.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<title>GIC</title>
	<style type="text/css">
		@import '<?php echo  $appDir?>/Themes/estilo.css';
		@import '<?php echo  $appDir?>/Themes/jquery-calendar.css';
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<script language="JavaScript" type="text/javascript">
		var img_cal='<?php echo  $appDir."/Graficas/img/calendar.gif";?>';
	</script>	
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/cliente/utils/jQuery/jQuery.js';?>" > </script>
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/cliente/utils/interface_1.2/interface.js';?>" > </script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/cliente/utils/jQuery/calendario/jquery-calendar.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/cliente/utils/jQuery/calendario/calend_esp.js' ?>"></script>
	
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/cliente/utils/sortable/common.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/cliente/utils/sortable/css.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/cliente/utils/sortable/standardista-table-sorting.js' ?>"></script>
	
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/cliente/utils/menus/bottom_menu.js';?>" > </script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('a.show').click(function(event){
				event.preventDefault();
				var clase = $(this).attr('clase');
				$('.'+clase).each(function(){
					$(this).toggle();
				});
			});
			$('a.show').attr('title','mostrar/ocultar');
			$(document).ready(function(){
				$('#chk_todos').click(function(){
					if($('#chk_todos').attr("checked"))
						$('.chk').attr("checked", "checked");
					else
						$('.chk').removeAttr("checked");
				});
			});
		});
	</script>
</head>

<body>
