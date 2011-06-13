<?php
	include ('../appRoot.php');
	require ($appRoot.'/Autentificacion/Usuarios.php');
	include('_tasks.php');

	$controller = new TasksController($_POST);

	if($controller->options['error']){
		$json_response['error'] = $controller->options['error'];
	}
	else{
		$html = '';
		switch($controller->options['action']){
			case 'load':				
				$html .= '<ul id="tasks-list">';
				$html .= '<li id="new-task">';
				$html .= '	<a id="open-parameters" class="shoow img" classe="task-parameters"></a>';
				$html .= '	<input type="text" id="task-name" value="nueva tarea" list_id="'.$controller->list->get_id().'" />';
				$html .= '	<a class="add add-task img" title="crear tarea" list_id="'.$controller->list->get_id().'"></a>';
				$html .= '</li>';
				$html .= '<li class="task-parameters hiding" id="parameters">';
				$html .= '	<label for="date">Date</label>';
				$html .= '	<input type="text" class="date" id="date" />';
				$html .= '	<label for="description">Description</label>';
				$html .= '	<textarea id="description" rows="3" cols="5"></textarea>';
				$html .= '</li>';

				if($controller->list->get_tasks())
				foreach($controller->list->get_tasks() as $task){
					$html .= print_task($task['id']);
				}

				$html .= '</ul>';
				$controller->options['list_name'] = $controller->list->get_name();
				$controller->options['list_id'] = $controller->list->get_id();
				break;

			case 'load_lists':
				$html .= '<li id="new-list">';
				$html .= '	<input type="text" id="list-name" value="nueva lista" />';
				$html .= '	<a class="add add-list img" title="crear lista"></a>';
				$html .= '</li>';

				while($list = $controller->ListaTasksLists->siguiente()){
					$html .= '<li id="list-'.$list->get_id().'">';
					$html .= '	<a id="select-list-'.$list->get_id().'" class="img ';if($controller->options['list_id'] == $list->get_id()) $html .= 'selected'; else $html.='select'; $html .='" list_id="'.$list->get_id().'" title="abrir lista" onclick="Lists.load_list('.$list->get_id().')"></a>';
					$html .= '	<input type="text" class="list-title" style="border-width:0;" ide="'.$list->get_id().'" value="'.$list->get_name().'"'; if($list->is_default()) $html.='disabled="disabled"'; $html .=' />';
					if(!$list->is_default()) $html .= '	<a class="delete img" list_id="'.$list->get_id().'" title="eliminar"></a>';
					$html .= '</li>';
				}
				
				break;

			case 'load_today':
				$html .= '<ul id="tasks-list">';
				while($task = $controller->ListaTasks->siguiente()){
					$html .= print_task($task->get_id(), true);
				}
				$html .= '</ul>';
				break;
		}
		$controller->options['html'] = $html;
	}		

	echo json_encode($controller->options);

	function print_task($task_id, $today=false){
		$task = new Task($task_id);

		$print  = '<li task_id="'.$task_id.'">';
		$print .= '<a class="move img" title="mover"></a>';
		$print .= '	<input id="chk-'.$task->get_id().'" type="checkbox" class="check mark-task" ide="'.$task->get_id().'"'; if($task->get_done()) $print .= 'checked="ckeched"'; $print .= '/>';
		$print .= '	<input type="text" class="task-title" style="border-width:0;" value="'.$task->get_name().'" ide="'.$task_id.'" />';
		if(!$today)
			$print .= ' <span class="task-date">'.Fechas::timestamp2date($task->get_date()).'</span>';
		else{
			$list = new TasksList($task->get_list_id());
			$print .= '	<span class="task-date">'.$list->get_name().'</span>';
		}		
		if(!$today)
			$print .= '	<a class="open-task img" task_id="'.$task_id.'" title="abrir tarea"></a>';
		$print .= '<a class="delete img" task_id="'.$task->get_id().'" title="eliminar" ></a>';
		
		if($task->get_tasks()){
			$print .= '<ul id="tasks-child-"'.$task_id.'">';
				foreach($task->get_tasks() as $task_child)
					$print .= print_task($task_child['id']);
			$print .= '</ul>';
		}
		$print .= '</li>';

		return $print;
	}
?>