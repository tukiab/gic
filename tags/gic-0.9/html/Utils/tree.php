<?php
/**
 * Clase que implementa la estructura del arbol
 * 
 * En el constructor, se le debe pasar el nombre de la clase nodo, y un objeto
 * de la clase de acceso a datos que debe tener los siguientes métodos: 
 * 		setNode($node);
 * 		addNode($node);
 * 		delNode($id);
 * 		getTreeData();
 * 
 * La clase nodo, como mínimo debe tener los atributos: 
 * 		id
 * 		id_padre
 * 
 * Además, debe constar de un constructor vacío y un método setData que reciba
 * como parámetro un array con los datos que contendrá el nodo.
 * 
 * 
 */
 class Tree{
 	
 	var $lista = array();	//Implementación del árbol mediante una lista de nodos
 	var $data_object = null;	//Clase de acceso al árbol en la BD
 	
 	/**
 	 * Constructor
 	 */
 	function Tree($class_node_name, $data_object){
 		//Obtenemos los datos del árbol
 		$this->data_object = $data_object;
 		
 		//Cargamos el árbol de la BD a partir del objeto 'data_object'
 		$data = $this->data_object->getTreeData();
 		foreach($data as $row){
 			$node = null;
 			eval("\$node = new $class_node_name();");
 			$node->setData($row);
 			$id = $node->id;
 			$father = $node->id_padre;
 			
 			$this->lista[$id] = $node;
  		}
 	}
 	
 	/**
 	 * Devuelve el 'id' del padre de '$node'
 	 */
 	function getFather($id){
 		
 		if(@(isset($this->lista[$this->lista[$id]->id_padre])))
 			return $this->lista[$this->lista[$id]->id_padre];
 		else
 			return false;
 	}
 	
 	/**
 	 * Devuelve una lista con los 'id' de los hijos de '$node'
 	 */
 	function getChildrens($id){
 		$ret_list=array();
 		
 		foreach($this->lista as $new_node){
 			if($new_node->id_padre == $id)
 				array_push($ret_list, $new_node);
 		}
 		return $ret_list;
 	}
 	
 	/*
 	 * Devuelve el número de hijos del nodo con id = $id
 	 */
 	function getNumHijos($id){
 		return count($this->getChildrens($id));
 	}
 	
 	/**
 	 * Devuelve una lista con los 'id' del camino desde la raíz al nodo con identificador $idNodo
 	 */
 	
 	
 	function getWayToNode($idNodo){
 		$way = array();
 		$id_padre = $idNodo;
 		
 		while($id_padre != 0){
 			$node = $this->getNode($id_padre);
 			array_push($way, $id_padre);
 			$id_padre = $node->id_padre;
 		}
 		array_push($way, $id_padre);
 		
 		return array_reverse($way);
 		
 	}
 	
 	/**
 	 * Devuelve el objeto 'Nodo' con id '$id'
 	 */
 	function getNode($id){
 		if(@(isset($this->lista[$id])))
 			return $this->lista[$id];
 		else
 			return null;
 	}
 	
 	/**
 	 * Actualiza la información de un nodo (si existe)
 	 */
 	function setNode($node){
 		if(isset($this->lista[$node->id])){
 			$this->data_object->setNode($node);
 		}
 	}
 	
 	/**
 	 * Añade un nuevo nodo al árbol
 	 */
 	function addNode($node){
 		$id = $node->id;
 		$father = $node->id_padre;
 			
 		$this->lista[$id] = $node;
 		return $this->data_object->addNode($node);
 	}
 	
 	/**
 	 * Elimina el nodo '$id' del árbol, y devuelve la lista de nodos que colgaban de él
 	 */
 	function delNode($id){
 		$lista=array();
 		$node=$this->getNode($id);
 		
 		//Obtenemos la lista de nodos del subárbol
 		$this->depth($node, $lista);
 		
 		//Recorremos la lista eliminando los nodos
 		foreach($lista as $node){
 			unset($this->lista[$node->id]);
 			$this->data_object->delNode($node->id);
 		}
 	}
 	
 	/**
 	 * Mueve el nodo '$id_origen' a '$id_destino'
 	 */
	function moveNode($id_origen, $id_destino){
		
		if(!$this->isHangingOf($id_destino, $id_origen)){
	 		$lista=array();
	 		$hijo=$this->getNode($id_origen);
	 		
	 		$hijo->id_padre = $id_destino;
	 		
	 		$this->data_object->setNode($hijo);
		}
		else
			throw new Exception('No se puede mover un nodo a otro que cuelga de él');
 	}
 	
 	/**
 	 * Comprueba si el nodo con identificador $id_inferior cuelga directa o recursivamente
 	 * del nodo con identificador $id_superior
 	 */
 	function isHangingOf($id_inferior, $id_superior){
 		
 		if($id_inferior!=0 && $id_superior!=0){
	 		$nodo_inferior = $this->getNode($id_inferior);
	 		if($this->isChildOf($id_inferior, $id_superior) || $this->isHangingOf($nodo_inferior->id_padre, $id_superior))
	 			return true;
 		}
 		
 		return false;
 	}
 	
 	/*
 	 * Comprueba si un nodo con $id_hijo es hijo directo de un nodo con $id_padre
 	 */
 	function isChildOf($id_hijo, $id_padre){
 		$nodo_hijo = $this->getNode($id_hijo);
 		
 		if($nodo_hijo->id_padre == $id_padre)	
 			return true;
 		
 		return false;
 	}
 	
 	/*
 	 * Comprueba si un nodo con $id_padre es padre directo de un nodo con $id_hijo
 	 */
 	function isFatherOf($id_padre, $id_hijo){
 		$nodo_hijo = $this->getNode($id_hijo);
 		
 		if($nodo_hijo->id_padre == $id_padre)		
 			return true;
 		
 		return false;
 	}
 	
 	/**
 	 * Devuelve un array ordenado según el recorrido en profundidad del sub-árbol
 	 * a partir de $node (siendo $node un id válido ó un nodo)
 	 */
 	function depth( $node, &$lista){
 		if(isset($this->lista[$node->id]))
 			$id=$node->id;
 		else if(isset($this->lista[$node])){
 			$id=$node;
 			$node = $this->getNode($id);
 		}
 		else if($node == 0){
 			$id=0;
 			$childrens=$this->getChildrens($id);
	 		foreach($childrens as $child){
	 			if(isset($this->lista[$child->id])){
					$this->depth($child, $lista);
	 			}
	 		}
	 		return;
 		}
 
 		if(isset($id)){
			array_push($lista, $node);
	 		$childrens=$this->getChildrens($id);
	 		foreach($childrens as $child){
	 			if(isset($this->lista[$child->id])){
					$this->depth($child, $lista);
	 			}
	 		}
 		}
 	}
 	/*
 	 * Este metodo, recibe como parametro de entrada $node, que es un objeto nodo ó un id y de entrada/salida $lista, que es un array.
 	 * Devuelve el listado de todos los nodos padres de un nodo.
 	 */
 	function reverse_depth($node, &$lista){
 		if(@isset($this->lista[$node]))
 			$node = $this->getNode($node);
 		
 		while($node->id!=0){
 			
 			array_push($lista,$node);
 			$node=$this->getNode($node->id_padre);
 					
 		}
 	}
 	
 	
   	
 }
?>
