<?php
/**
 * Clase encargada de las búsquedas y listados de TasksLists.
 *
 * @package G.
 * @version 0.1
 * @author
 * Juan Ramón González Hidalgo
 *
 * María José Prieto García
 *
 * José Ignacio Ortiz de Galisteo Romero
 */
class ListaTasksLists implements IIterador{

	
	private $result;

	private $num_rows=0;
		
	public function num_Resultados(){
		return $this->num_rows;
	}

	public function inicio(){
		mysql_data_seek($this->result, 0);
	}

	public function siguiente(){
		$row = @mysql_fetch_row($this->result);
		if($row)
			$id = $row[0];
		else
			return null;
			
		return new TasksList($id);
	}

	public function buscar($filters = array()){
		$filter = "";
		if(isset($filters['user_id'])){
			$filter .= " AND tasks_lists.fk_user = '".$filters['user_id']."'";
		}
		if(isset($filters['default'])){
			$filter .= " AND tasks_lists.default = '1'";
		}
		
		$query = "SELECT SQL_CALC_FOUND_ROWS tasks_lists.id
				FROM tasks_lists
				WHERE 1
					$filter
				GROUP BY tasks_lists.id
				$limit; ";
					
		$this->result = mysql_query($query);
		
		$calc_num_rows = mysql_query("SELECT FOUND_ROWS();");
		$array_num_rows = mysql_fetch_array($calc_num_rows);
		$this->num_rows = $array_num_rows[0];
	}
}
?>