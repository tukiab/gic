<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/include/validar.php");

class EditColaborador{
	
	/**
	 * Array que contendrá las opciones pasadas al constructor para que sean
	 * accesibles desde fuera de la clase.
	 *
	 * @var mixed
	 */
	public $opt = array();

	/**
	 * Array que contendrá los datos de la BBDD necesarios para mostrar opciones
	 * en la interfaz.
	 *
	 * @var mixed
	 */
	public $datos = array();

	/**
	 * Instancia de la clase Colaborador.
	 *
	 * @var object
	 */
	public $Colaborador;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaColaboradores;
	public $gestor;	
	/**
	 * Constructor.
	 * 
	 * Si viene definida la variable 'guardar', llama al método {@link guardar()}.
	 * 
	 * @see guardar()
	 * @param array $opciones Array de opciones pasadas a la página.
	 */
	
	public function __construct($opciones){
		//Debugging..
		//FB::log($opciones, '_editar_datos_colaborador.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['id'] || !is_numeric($opciones['id']))
			exit("No se ha definido un ID de Colaborador válido.php");

		$this->Colaborador = new Colaborador($opciones['id']);
		$this->ListaColaboradores = new ListaColaboradores();
		
		if($opciones['id_gestor'])
			$this->addGestor($opciones['id_gestor']);
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosColaborador($opciones);

		$this->Colaborador = new Colaborador($opciones['id']);
		$this->obtenerDatos();
	}
		
	/**
	 * Modifica los datos referentes a la colaborador, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosColaborador($opciones){
		//FB::log($opciones, "Opciones:EditarDatosColaborador");
		
		//Por si eliminamos un contacto
		$datos_contactos = $this->get_Opciones_Contactos($opciones);
		
		//Si se ha pulsado en guardar, comprobamos qué se va a guardar...
		if($opciones['guardar']){
			switch($opciones['edit']){
				case 'contactos':
						//Enviar los datos de los contactos a la BD.
						try{
							
							foreach($datos_contactos as $array_contacto){
								
								$id_contacto = $array_contacto['id'];
								$Contacto = new Contacto($id_contacto);
								
								if($id_contacto == 'n')
									//Creamos el contacto
									$this->Colaborador->add_Contacto($array_contacto);
								else{
									//Actualizamos el contacto
									if($Contacto->get_Nombre() != $array_contacto['nombre']){
										$Contacto->set_Nombre($array_contacto['nombre']);
									}
									if($Contacto->get_Telefono() != $array_contacto['telefono']){
										$Contacto->set_Telefono($array_contacto['telefono']);
									}										
									if($Contacto->get_Cargo() != $array_contacto['cargo']){
										$Contacto->set_Cargo($array_contacto['cargo']);
									}
									if($Contacto->get_Email() != $array_contacto['email']){
										$Contacto->set_Email($array_contacto['email']);
									}		
								}
							}
							$this->msg .= "Guardado";
						}catch (Exception $e){
							$this->msg .= "Error: ".$e->getMessage();
							$this->opt['contacto_error'] = $array_contacto;
						}
					break;
				case 'colaborador':
						//Obtener los datos de la colaborador y enviarlos a la BD
						$datos_colaborador = $this->get_Opciones_Colaborador($opciones);
				
						$this->Colaborador = new Colaborador($datos_colaborador['id']);
						try{
							if($this->Colaborador->get_Razon_Social() != $datos_colaborador['razon_social'])
								$this->Colaborador->set_Razon_Social($datos_colaborador['razon_social']);												
							if($this->Colaborador->get_Localidad() != $datos_colaborador['localidad'])
								$this->Colaborador->set_Localidad($datos_colaborador['localidad']);
                                                        if($this->Colaborador->get_Provincia() != $datos_colaborador['provincia'])
								$this->Colaborador->set_Provincia($datos_colaborador['provincia']);

							if($this->Colaborador->get_Domicilio() != $datos_colaborador['domicilio'])
								$this->Colaborador->set_Domicilio($datos_colaborador['domicilio']);

							if($this->Colaborador->get_Comision() != $datos_colaborador['comision'])
								$this->Colaborador->set_Comision($datos_colaborador['comision']);

							if($this->Colaborador->get_Comision_Por_Renovacion() != $datos_colaborador['comision_por_renovacion'])
								$this->Colaborador->set_Comision_Por_Renovacion($datos_colaborador['comision_por_renovacion']);
							if($this->Colaborador->get_CC_Pago_Comisiones() != $datos_colaborador['cc_pago_comisiones'])
								$this->Colaborador->set_CC_Pago_Comisiones($datos_colaborador['cc_pago_comisiones']);
								
							
							if($this->Colaborador->get_NIF() != $datos_colaborador['NIF'])
								$this->Colaborador->set_NIF($datos_colaborador['NIF']);
								
							if($this->Colaborador->get_CP() != $datos_colaborador['CP'])
								$this->Colaborador->set_CP($datos_colaborador['CP']);
								
								
							$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				$this->Colaborador->del_Contacto($opciones['eliminar']);
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		//Obteniendo datos para los atributos seleccionables de una lista en la página
		$this->datos['lista_contactos'] = $this->Colaborador->get_Lista_Contactos();
		$lista_usuarios = new ListaUsuarios();
		$todos_usuarios = $lista_usuarios->buscar();
		$this->datos['lista_gestores'] = $lista_usuarios;
	}
	
	private function get_Opciones_Colaborador($opciones){
		$opt = array();
		$opt['id'] = $opciones['id'];
		$opt['razon_social'] = $opciones['razon_social'];
				
		$opt['comision'] = trim($opciones['comision']);
		$opt['comision_por_renovacion'] = trim($opciones['comision_por_renovacion']);
		
		$opt['cc_pago_comisiones'] = trim($opciones['cc_pago_comisiones']);
		$opt['NIF'] = trim($opciones['NIF']);
		$opt['domicilio'] = trim($opciones['domicilio']);
		$opt['localidad'] = trim($opciones['localidad']);
		$opt['provincia'] = trim($opciones['provincia']);
		$opt['CP'] = trim($opciones['CP']);
		
		
		return $opt;
	}
	
	private function get_Opciones_Contactos($opciones){
		$opt = array();	
		$i='n';
		if(isset($opciones["n_nombre"])){
			$opt[$i]['id'] = 'n';
			$opt[$i]['id_colaborador'] = $this->Colaborador->get_Id();
			$opt[$i]['telefono'] = trim($opciones["n_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["n_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["n_cargo"]);
			$opt[$i]['email'] = trim($opciones["n_email"]);
		}
		
		$i=0;
		while(!empty($opciones["$i"."_nombre"])){
			$opt[$i]['id'] = $opciones["$i"."_id"];
			$opt[$i]['id_colaborador'] = $this->Colaborador->get_Id();
			$opt[$i]['telefono'] = trim($opciones["$i"."_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["$i"."_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["$i"."_cargo"]);
			$opt[$i]['email'] = trim($opciones["$i"."_email"]);
			$i++;
		}
		return $opt;
	}
	
	private function addGestor($id_gestor){
		$this->Colaborador->add_Gestor($id_gestor);
		$this->msg = "Gestor añadido";		
	}
	
}




?>
