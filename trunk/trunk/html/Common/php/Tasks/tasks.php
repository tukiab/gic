<?php
	
	include('_tasks.php');	
	$controller = new TasksController($_POST);	
?>
	<style type="text/css">
		@import '<?echo $appDir?>/Common/css/tasks_css/style.css';
	</style>
	
	<script type="text/javascript" src="<?php echo $appDir; ?>/Common/js/tasks_js/common.js"></script>
	<script type="text/javascript" src="<?php echo $appDir; ?>/Common/js/tasks_js/tasks.js"></script>
	<script type="text/javascript" src="<?php echo $appDir; ?>/Common/js/tasks_js/lists.js"></script>

<div id="tasks-lists-container">
		<div id="tasks-top" class="tasks-bar">
			<span>Mis tareas:</span> <span id="title-tasks"><?php echo $controller->list->get_name();?></span>
			<a class="shoow img" classe="tasks-hide" title="mostrar tareas"></a>
		</div>
		<div id="tasks-lists" class="tasks-hide hiding"></div>
		<div id="tasks-bottom" class="tasks-bar tasks-hide hiding">
			<a class="img" id="today-tasks" title="tareas que vencen hoy" onclick="Lists.load_today()"></a>
			<a class="shoow img" id="open-lists" classe="lists" title="gesti&oacute;n de listas"></a>
			<ul class="lists hiding" id="lists"></ul>
		</div>
</div>
