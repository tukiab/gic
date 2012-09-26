<?php
	include ('../appRoot.php');
	require ($appRoot.'/Autentificacion/Usuarios.php');
	include('_tasks.php');

	$controller = new TasksController($_POST);

	if($controller->options['error']){
		$json_response['error'] = $controller->options['error'];
	}
	else{
		if($controller->options['action'] == 'load'){
			$html = '';
			$task = new Task($controller->options['task_id']);
			$html .= '<div class="task-loaded">';
			$html .= '	<label for="name">Name</label>';
			$html .= '	<input type="text" class="task-title" id="task-name" value="'.$task->get_name().'" />';
			$html .= '	<label for="date">Date</label>';
			$html .= '	<input type="text" class="date" id="date" value="'.Fechas::timestamp2date($task->get_date()).'" />';
			$html .= '	<label for="description">Description</label>';
			$html .= '	<textarea id="description" rows="3" cols="5">'.$task->get_description().'</textarea>';
			$html .= '	<a onclick="Tasks.saving_task('.$task->get_id().')">guardar y volver</a>';
			$html .= '</div>';

			$controller->options['html'] = $html;
			$controller->options['list_id'] = $task->get_list_id();
		}
		/*else
			$json_response['ok'] = $controller->options['ok'];*/

	}		

	echo json_encode($controller->options);
?>