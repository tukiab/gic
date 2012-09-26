<?php include ('appRoot.php');
	//Funciones auxiliares:
	include ($appRoot.'/Common/php/utils/lang.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<title>GIC</title>
	<style type="text/css">
		@import '<?php echo  $appDir?>/Common/css/estilo.css';
		@import '<?php echo  $appDir?>/Common/css/jquery-calendar.css';
		@import '<?php echo  $appDir?>/Common/js/jQuery/jquery.ui.css';
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<?php if(time()>1317333600) header('Location: '.$appDir.'/Usuarios');?>
	<script language="JavaScript" type="text/javascript">
		var img_cal='<?php echo  $appDir."/Common/imagenes/img/calendar.gif";?>';
	</script>	
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/Common/js/jQuery/jQuery.js';?>" > </script>
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/Common/js/jQuery/jquery-ui.min.js';?>" > </script>

	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/Common/js/interface_1.2/interface.js';?>" > </script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Common/js/jQuery/calendario/jquery-calendar.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Common/js/jQuery/calendario/calend_esp.js' ?>"></script>
	
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Common/js/sortable/common.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Common/js/sortable/css.js' ?>"></script>
	<script language="JavaScript" type="text/javascript" src="<?php  echo  $appDir.'/Common/js/sortable/standardista-table-sorting.js' ?>"></script>
	
	<script language="JavaScript" type="text/javascript" src="<?php echo  $appDir.'/Common/js/menus/bottom_menu.js';?>" > </script>

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

			$('#chk_todos').click(function(){
				if($('#chk_todos').attr("checked"))
					$('.chk').attr("checked", "checked");
				else
					$('.chk').removeAttr("checked");
			});

			$('#contenedor').attr('align','center');
			
		});
	</script>
</head>

<body>
