<?php
/**
 * TasksLists management
 */
class TasksList{
	
	/**
	 * Id
	 * @var integer
	 */
	private $id;

	/**
	 * User owner of the list
	 * @var integer
	 */
	private $user_id;

	/**
	 * Tasks of the list
	 * @var <array> of arrays, each one indexed with de list fields (id, name, description, date, order, fk_list, fk_task, done)
	 */
	private $tasks;
	private $order_tasks;

	/**
	 * Name of the list
	 * @var string
	 */
	private $name;

	/**
	 * Default list of the user?
	 * @var integer-boolean
	 */
	private $default;
	/**
	 * Construct
	 *
	 * Load the tasksList from the database throw its id {@link load()}. If the id is null create an empty Object
	 * @see load()
	 *
	 * @param integer $id
	 */
	public function __construct($id=null){
		if($id){
			$this->id = $id;
			$this->load();
		}
	}

	/**
	 * Load the tasksList data from de DB
	 */
	private function load(){
		try{
			if($this->id){
				$query = "SELECT *
							FROM tasks_lists
							WHERE id = '$this->id'; ";
				
				if(!($result = mysql_query($query))){
					throw new Exception("No se puede cargar la lista");
				}
				else if(mysql_num_rows($result) == 0){
					throw new Exception("No existe la lista");
				}

				$row = mysql_fetch_array($result);

				$this->name = $row['name'];
				$this->user_id = $row['fk_user'];
				$this->default = $row['default'];

				$this->load_tasks();
				
			}
		}catch(Exception $e){}
	}

	/**
	 * Load the tasks of the tasksList (only first level)
	 */
	private function load_tasks(){
		$query = "SELECT * FROM tasks WHERE fk_list='$this->id' AND fk_task IS NULL ORDER BY tasks.order DESC;";

		if(!($result = mysql_query($query))){
			throw new Exception("No se pueden cargar las tareas de la lista");
		}

		while($row=  mysql_fetch_array($result)){
			$this->tasks[$row['id']] = $row;
			$this->order_tasks[$row['order']] = $row;
		}
	}

	/**
	 * Get the id
	 *
	 * @return integer $id 
	 */
	public function get_id(){
		return $this->id;
	}

	/**
	 * Get the name
	 *
	 * @return string $name
	 */
	public function get_name(){
		return $this->name;
	}

	/**
	 * Get the user_id
	 * @return <string>
	 */
	public function get_user_id(){
		return $this->user_id;
	}

	/**
	 * Get the tasks 
	 * @return <array> of arrays, each one indexed with de list fields (id, name, description, date, order, fk_list, fk_task, done)
	 */
	public function get_tasks(){
		return $this->tasks;
	}

	public function get_order_tasks(){
		return $this->order_tasks;
	}

    public function is_default(){
		return $this->default;
	}
	
	/**
	 * Change name
	 * @param <string> $name
	 */
	public function set_name($name){
		if(!$this->default)
		if($name != '' && $name != $this->name){
			$query = "UPDATE tasks_lists SET name='$name' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al cambiar el nombre");
			$this->name = $name;
		}
	}
	
	/**
	 * Create a new TasksList
	 * @param <array> $data
	 * @return <integer> $id new id in the DB
	 */
	public function create($data){

		$errors = '';
		if($data['name'] == '' || ! isset($data['name']))
			$errors .= "El nombre es obligatorio";
		if($data['user_id'] == '' || ! isset($data['user_id']))
			$errors .= "El usuario es obligatorio";

		if($errors != '') {
			throw new Exception($errors);
		}

		$this->name = mysql_real_escape_string(trim($data['name']));
		$this->user_id = $data['user_id'];

		$this->save();

		return $this->id;
	}

	/**
	 * Saving the tasksList in the DB
	 */
	private function save(){
		$query = "INSERT INTO tasks_lists (name, fk_user, `default`)
							VALUES (
									'$this->name',
									'$this->user_id',
									'0'
									);";
		if(!mysql_query($query))
			throw new Exception("Error al crear la lista");

		$this->id = mysql_insert_id();
	}

	/**
	 * Creates a new task for the tasksList
	 * @param <array> $data
	 */
	public function add_task($data){
		$task = new Task();
		$data['list_id'] = $this->id;
		$data['user_id'] = $this->user_id;

		$task->create($data);
		$this->load_tasks();

		return $task;
	}

	/**
	 * Remove the tasks list of the db
	 */
	public function delete(){
		if(!$this->default){
			$query = " DELETE from tasks_lists WHERE id = '$this->id'";
			if(!mysql_query($query))
				throw new Exception('Error al borrar la lista');
		}else
			throw new Exception('La lista general no se puede borrar');
	}

	/**
	 * Change the order of the tasks from a task a its new position
	 * @param integer $task_id
	 * @param integer $order
	 */
	public function set_order($task_id, $new_order){
		if($new_order <= $this->get_max_order() && $new_order >= 1){
			
			$task = $this->tasks[$task_id];
			$old_order = $task['order'];

			$Task = new Task($task_id);
			
			if($new_order < $old_order){ 
				for($order_index=$new_order; $order_index<=$old_order;$order_index++){
					$t = $this->order_tasks[$order_index];
					$id = $t['id'];
					$task = new Task($id);
					$task->set_order($order_index+1);
				}
				$Task->set_order($new_order);
			}
			else if($new_order > $old_order){
				for($order_index=$old_order+1; $order_index<=$new_order;$order_index++){
					$t = $this->order_tasks[$order_index];
					$id = $t['id'];
					$task = new Task($id);
					$task->set_order($order_index-1);
				}
				$Task->set_order($new_order);
			}
		}
	}

	private function get_max_order(){
		$task = reset($this->tasks);
		return $task['order'];
	}
}
?>