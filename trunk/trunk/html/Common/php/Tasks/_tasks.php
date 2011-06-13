<?php
/* 
 * Controller for view tasks.php
 */
class TasksController{

	public $options;
	public $user;
	public $ListaTasksLists;
	public $list;
	public $ListaTasks;

	public function  __construct($options) {

		try{
			$this->ListaTasksLists = new ListaTasksLists();
			$this->ListaTasks = new ListaTasks();
			
			$this->get_options($options);
			$this->get_data();

			switch($this->options['action']){
				case 'create':
					$this->create_task();
					break;

				case 'create_list':
					$this->create_list();
					break;

				case 'remove':
					$this->remove_task();
					break;

				case 'remove_list':
					$this->remove_list();
					break;
				
				case 'change_mark':
					$task = new Task($this->options['task_id']);
					$task->change_mark();
					break;

				case 'update':
					$this->update_task();
					break;

				case 'update_list':
					$this->update_list();
					break;

				case 'load_today':
					$this->load_today();
					break;

				case 'reorder':
					$this->reorder();
					break;

				default:
					break;
			}
		}catch(Exception $e){
			$this->options['error'] = $e->getMessage();
		}

	}

	private function get_options($options){
		$this->options['user_id'] = $_SESSION['usuario_login'];
		$this->user = new Usuario($this->options['user_id']);

		(isset($options['action']))?$this->options['action']=$options['action']:null;

		(isset($options['list-name']))?$this->options['list-name']=$options['list-name']:null;
		(isset($options['task-name']))?$this->options['task-name']=$options['task-name']:null;
		(isset($options['date']))?$this->options['date']=Fechas::date2timestamp($options['date']):null;
		(isset($options['description']))?$this->options['description']=$options['description']:null;

		(isset($options['task_id']))?$this->options['task_id']=$options['task_id']:null;
		(isset($options['today']))?$this->options['today']=$options['today']:null;
		(isset($options['new_order']))?$this->options['new_order']=$options['new_order']:null;

		$this->options['list_id']=(isset($options['list_id']))?$options['list_id']:$this->default_list();
		$this->list = new TasksList($this->options['list_id']);
	}

	private function get_data(){		
		$filters['user_id'] = $this->user->get_id();
		$this->ListaTasksLists->buscar($filters);
	}

	private function default_list(){
		$filters['user_id'] = $this->user->get_id();
		$filters['default'] = true;
		$this->ListaTasksLists->buscar($filters);

		$list = $this->ListaTasksLists->siguiente();
		return $list->get_id();
	}

	private function create_task(){
		$array_new_task = array('name' => $this->options['task-name'],
								'description' => $this->options['description'],
								'date' => $this->options['date']);

		$this->list->add_task($array_new_task);
		$this->options['ok'] = 'task created';
		$this->options['list_id'] = $this->list->get_id();
	}

	private function create_list(){
		$this->user->add_list($this->options['list-name']);
	}

	private function update_task(){
		$task = new Task($this->options['task_id']);
		$task->set_description($this->options['description']);
		$task->set_name($this->options['task-name']);
		$task->set_date($this->options['date']);
		$this->options['list_id'] = $task->get_list_id();
	}

	private function update_list(){
		$list = new TasksList($this->options['list_id']);
		$list->set_name($this->options['list-name']);
	}

	private function remove_task(){
		$task = new Task($this->options['task_id']);
		$this->options['list_id'] = $task->get_list_id();
		$task->delete();
		$this->options['msg'] = 'task deleted';
	}

	private function remove_list(){
		$list = new TasksList($this->options['list_id']);
		$list->delete();
		$this->options['msg'] = 'list deleted';
	}

	private function load_today(){
		$filters['today'] = true;
		$filters['user_id'] = $this->user->get_id();
		$this->ListaTasks->buscar($filters);
	}

	private function reorder(){
		$task = new Task($this->options['task_id']);
		$list = new TasksList($task->get_list_id());

		$list->set_order($task->get_id(), $this->options['new_order']);
	}
}
?>