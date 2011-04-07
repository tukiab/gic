<?php include('appRoot.php');
include($appRoot.'/Usuarios/datos/Atajos.php');

/**
 * Clase AtajosUsuarios
 * 
 * Consta de un único método, que es el constructor.
 * Funcionalidad:
 * 	Pasados como parametros el array opciones y el id de un usuario, devuelve la lista de todos los
 * 	atajos dispobles, los atajos que posee el usuario actual y además se encarga de gurdar y eliminar los
 * 	atajos que el usuario desee.
 * 
 * @name AtajosUsuarios
 *
 */
class AtajosUsuarios{
	
	public $listadoAtajosDisponibles= array();
	public $listadoAtajosUsuarios=array();
	public $msg;
	public $idUsuario;
	
	private $DB_atajos;
	
	/**
	 * Constructor
	 * 
	 * @param $opciones :
	 * 			Array de opciones, que contendra los siguientes valores
	 * 			int $opciones['accion'], en caso de ser 1, se ejecutara la accion de borrarAtajos y guardar los nuevos.
	 * 			String $opciones['datos'], cadena de IdAtajos, separadas por coma.
	 * @param $idUsuario :
	 * 			es el correspondiente a $_SESSION['usuario_login']
	 * 
	 */
	
	public function __construct($opciones,$idUsuario){
		
		
		$this->DB_atajos = new Atajos();
				
		if($opciones['accion']){
			try {
				
				$this->DB_atajos->borrarTodosAtajosUsuario($idUsuario);
				
				$listaId= explode(",",$opciones['datos']);
				
				foreach($listaId as $key => $valor)
				{
					$this->DB_atajos->addAtajosUsuario($idUsuario,$valor);
				}
			
			}
			catch(Exception $e){
				$this->msg=$e->getMessage();
			}
		}
			
		$this->listadoAtajosDisponibles=$this->DB_atajos->getListaAtajosDisponibles();
		$this->listadoAtajosUsuarios=$this->DB_atajos->getListaAtajosUsuario($idUsuario);
	}
}
?>