<?php
/**
 * Tasks management
 */
class Task{

	/**
	 * Id
	 * @var integer
	 */
	private $id;

	/**
	 * Name
	 * @var string
	 */
	private $name;

	/**
	 * Description
	 * @var string
	 */
	private $description;

	/**
	 * Order
	 * @var integer
	 */
	private $order;

	/**
	 * Is it done?
	 * @var integer
	 */
	private $done;

	/**
	 * Date in timestamp
	 * @var integer
	 */
	private $date;

	/**
	 * List "owner" of the task
	 * @var integer
	 */
	private $list_id;

	/**
	 * Task father of the task
	 * @var integer
	 */
	private $task_id;

	/**
	 * Child-Tasks of the task
	 * @var <array> of arrays, each one indexed with Task fields (id, name, description, order, date, fk_list, fk_task)
	 */
	private $tasks;

	/**
	 * Construct
	 *
	 * Load the Task from the database throw its id {@link load()}. If the id is null create an empty Object
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
	 * Load the Task data from de DB
	 */
	private function load(){
		try{
			if($this->id){
				$query = "SELECT *
							FROM tasks
							WHERE id = '$this->id'; ";
				
				if(!($result = mysql_query($query))){
					throw new Exception("Cannot load the Task");
				}
				else if(mysql_num_rows($result) == 0){
					throw new Exception("There is no Task");
				}

				$row = mysql_fetch_array($result);

				$this->name = $row['name'];
				$this->description = $row['description'];
				$this->order = $row['order'];
				$this->date = $row['date'];
				$this->list_id = $row['fk_list'];
				$this->task_id = $row['fk_task'];
				$this->done = $row['done'];

				$this->load_tasks();
			}
		}catch(Exception $e){}
	}

	/**
	 * Load the child-tasks of the Task
	 */
	private function load_tasks(){
		$query = "SELECT * FROM tasks WHERE fk_task='$this->id' ORDER BY tasks.order DESC;";

		if(!($result = mysql_query($query))){
			throw new Exception("Cannot load the tasks child of the task");
		}

		while($row=  mysql_fetch_array($result)){
			$this->tasks[$row['id']] = $row;
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
	 * Get description
	 *
	 * @return string $description
	 */
	public function get_description(){
		return $this->description;
	}

	/**
	 * Get the order
	 *
	 * @return integer $order
	 */
	public function get_order(){
		return $this->order;
	}

	/**
	 * Get the date
	 *
	 * @return integer $date
	 */
	public function get_date(){
		return $this->date;
	}

	/**
	 * Indicates if the task is done
	 * @return integer
	 */
	public function get_done(){
		return $this->done;
	}

	/**
	 * Get the list_id
	 * @return <integer>
	 */
	public function get_list_id(){
		return $this->list_id;
	}

	/**
	 * Get the task_id
	 * @return <integer>
	 */
	public function get_task_id(){
		return $this->task_id;
	}

	/**
	 * Get the tasks 
	 * @return <array> of arrays, each one indexed with de list fields (id, name, description, date, order, fk_list, fk_task)
	 */
	public function get_tasks(){
		return $this->tasks;
	}
        
	/**
	 * Change name
	 * @param <string> $name
	 */
	public function set_name($name){
		if($name != '' && $name != $this->name){
			$query = "UPDATE tasks SET name='$name' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al cambiar el nombre");
			$this->name = $name;
		}
	}

	/**
	 * Change description
	 * @param <string> $description
	 */
	public function set_description($description){
		if($description != '' && $description != $this->description){
			$query = "UPDATE tasks SET description='$description' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al cambiar la descripci&oacute;n");
			$this->description = $description;
		}
	}

	/**
	 * Change order
	 * @param <integer> $order
	 */
	public function set_order($order){
		if($order != '' && $order != $this->order){ 
			$query = "UPDATE tasks SET tasks.order='$order' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al cambiar el orden");
			$this->order = $order;
		}
	}

	/**
	 * Change date
	 * @param <integer> $date
	 */
	public function set_date($date){
		if($date != '' && $date != $this->date){
			$query = "UPDATE tasks SET date='$date' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al cambiar la fecha");
			$this->date = $date;
		}
	}

	/**
	 * Change task_id
	 * @param <integer> $task_id
	 */
	public function set_task_id($task_id){
		
		$Task = new Task($task_id);
		if($task->get_list_id() != $this->list_id)
			throw new Exception('No se puede cambiar las tareas de listas');

		if($task_id != '' && $task_id != $this->task_id){
			$query = "UPDATE tasks SET fk_task='$task_id' WHERE id='$this->id';";
			if(!mysql_query($query))
				throw new Exception("Error al mover la tarea");
			$this->task_id = $task_id;
		}
	}

	/**
	 * Mark the task as done
	 */
	public function done(){
		if(!$this->done){
			$query = "UPDATE tasks SET done='1' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error en el marcado de la tarea");
			$this->done = 1;
		}

		//mark as done all the tasks-child
		if($this->tasks)
		foreach($this->tasks as $array_task){
			$task = new Task($array_task['id']);
			$task->done();
		}
	}

	/**
	 * Mark the task as undone
	 */
	public function undone(){
		if($this->done){
			$query = "UPDATE tasks SET done='0' WHERE id='$this->id' ";
			if(!mysql_query($query))
				throw new Exception("Error en el marcado de la tarea");
			$this->done = 0;
		}

		//mark as done all the tasks-child
		if($this->tasks)
		foreach($this->tasks as $array_task){
			$task = new Task($array_task['id']);
			$task->undone();
		}
	}

	/**
	 * Change the status of the task (done/undone)
	 */
	public function change_mark(){
		if($this->done)
			$this->undone();
		else
			$this->done();
	}

	/**
	 * Create a new Task
	 * @param <array> $data
	 * @return <integer> $id new id in the DB
	 */
	public function create($data){

		$errors = '';
		if($data['name'] == '' || ! isset($data['name'])){
			$errors .= "El nombre es obligatorio";
		}
		if($data['list_id'] == '' || ! isset($data['list_id'])){
			$errors .= "La lista padre es obligatoria";
		}

		if($errors != '') {
			throw new Exception($errors);
		}

		$this->name = mysql_real_escape_string(trim($data['name']));
		$this->list_id = $data['list_id'];

		$this->task_id = 'NULL';
		if(isset($data['task_id'])){
			$Task = new Task ($data['task_id']);
			$this->task_id = $data['task_id'];
			$this->list_id = $Task->get_list_id();
		}

		$this->description = (isset($data['description']))?mysql_real_escape_string(trim($data['description'])):null;
		$this->date = (isset($data['date']))?trim($data['date']):null;

		$this->order = $this->get_next_order();

		$this->save();

		return $this->id;
	}

	/**
	 * Get the order to the new Task
	 * @return <integer> $order
	 */
	private function get_next_order(){
		$filter = "tasks.fk_list = '$this->list_id'";
		/*if($this->task_id){
			$filter = "fk_task = '$this->task_id'";
		}*/

		$query = " SELECT tasks.order FROM tasks WHERE $filter ORDER BY tasks.order DESC LIMIT 1 "; 
		if(!($result = mysql_query($query))){
			return 1;
		}

		if(mysql_num_rows($result) == 0){			
			return 1;
		}

		$row = mysql_fetch_array($result);
		return $row['order']+1;
	}

	/**
	 * Saving the Task in the DB
	 */
	private function save(){

		$fields = "";
		$values = "";

		if($this->description){
			$fields .= ", `description`";
			$values .= ", '$this->description'";
		}
		if($this->date){
			$fields .= ", `date`";
			$values .= ", '$this->date'";
		}

		$query = "INSERT INTO tasks (`name`, `fk_list`, `fk_task`, `order` $fields)
							VALUES (
									'$this->name',
									'$this->list_id',
									$this->task_id,
									'$this->order'
									$values
									);";
		
		if(!mysql_query($query))
			throw new Exception("Error al crear la tarea "); 

		$this->id = mysql_insert_id();
	}

	/**
	 * Creates a new child-task
	 * @param <array> $data
	 */
	public function add_task($data){
		$task = new Task();
		$data['list_id'] = $this->list_id;
		$data['task_id'] = $this->id;

		$task->create($data);
		$this->load_tasks();

		return $task;
	}

	/**
	 * Delete the task
	 */
	public function delete(){
		$query = " DELETE from tasks WHERE id = '$this->id'";
		if(!mysql_query($query))
			throw new Exception('Error al eliminar la tarea');

		//Reorder the (father) list
		$list = new TasksList($this->list_id);
		$tasks = $list->get_order_tasks();
		for($position = $this->order+1; $position <= count($tasks)+1; $position++){
			$t = $tasks[$position];
			$task = new Task($t['id']);

			$task->set_order($position-1);
		}
	}
}
?>