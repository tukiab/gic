<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/Common/php/validar.php");

class EditProveedor{
	
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
	 * Instancia de la clase Proveedor.
	 *
	 * @var object
	 */
	public $Proveedor;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaProveedores;
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
		//FB::log($opciones, '_editar_datos_proveedor.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['NIF'])
			exit("No se ha definido un CIF/NIF de Proveedor válido");

		$this->Proveedor = new Proveedor($opciones['NIF']);
		$this->ListaProveedores = new ListaProveedores();
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosProveedor($opciones);

		$this->Proveedor = new Proveedor($opciones['NIF']);
		$this->obtenerDatos();
	}
		
	/**
	 * Modifica los datos referentes a la proveedor, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosProveedor($opciones){
		//FB::log($opciones, "Opciones:EditarDatosProveedor");
		
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
									$this->Proveedor->add_Contacto($array_contacto);
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
							$this->msg = $this->msg."Guardado";
						}catch (Exception $e){
							$this->msg .= "Error: ".$e->getMessage();
							$this->opt['contacto_error'] = $array_contacto;
						}
					break;
				case 'proveedor':
						//Obtener los datos de la proveedor y enviarlos a la BD
						$datos_proveedor = $this->get_Opciones_Proveedor($opciones);
						
						$this->Proveedor = new Proveedor($datos_proveedor['NIF']);
						try{
							if($this->Proveedor->get_Razon_Social() != $datos_proveedor['razon_social'])
								$this->Proveedor->set_Razon_Social($datos_proveedor['razon_social']);					
							
							if($this->Proveedor->get_Localidad() != $datos_proveedor['localidad'])
								$this->Proveedor->set_Localidad($datos_proveedor['localidad']);
								
							if($this->Proveedor->get_Domicilio() != $datos_proveedor['domicilio'])
								$this->Proveedor->set_Domicilio($datos_proveedor['domicilio']);
								
							if($this->Proveedor->get_Provincia() != $datos_proveedor['provincia'])
								$this->Proveedor->set_Provincia($datos_proveedor['provincia']);
								
							if($this->Proveedor->get_NIF() != $datos_proveedor['NIF'])
								$this->Proveedor->set_NIF($datos_proveedor['NIF']);
							
							if($this->Proveedor->get_Web() != $datos_proveedor['web'])
								$this->Proveedor->set_Web($datos_proveedor['web']);
							
							$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				$this->Proveedor->del_Contacto($opciones['eliminar']);
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		//Obteniendo datos para los atributos seleccionables de una lista en la página
		
		$this->datos['lista_contactos'] = $this->Proveedor->get_Lista_Contactos();
		
	}
	
	private function get_Opciones_Proveedor($opciones){
		$opt = array();
		$opt['NIF'] = $opciones['NIF'];
		$opt['razon_social'] = $opciones['razon_social'];
		$opt['domicilio'] = trim($opciones['domicilio']);
		$opt['localidad'] = trim($opciones['localidad']);
		$opt['domicilio'] = trim($opciones['domicilio']);
		$opt['provincia'] = trim($opciones['provincia']);
		$opt['web'] = trim($opciones['web']);
		
		return $opt;
	}
	
	private function get_Opciones_Contactos($opciones){
		$opt = array();	
		$i='n';
		if(isset($opciones["n_nombre"])){
			$opt[$i]['id'] = 'n';
			$opt[$i]['NIF_proveedor'] = $this->Proveedor->get_NIF();
			$opt[$i]['telefono'] = trim($opciones["n_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["n_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["n_cargo"]);
			$opt[$i]['email'] = trim($opciones["n_email"]);
		}
		
		$i=0;
		while(!empty($opciones["$i"."_nombre"])){
			$opt[$i]['id'] = $opciones["$i"."_id"];
			$opt[$i]['NIF_proveedor'] = $this->Proveedor->get_NIF();
			$opt[$i]['telefono'] = trim($opciones["$i"."_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["$i"."_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["$i"."_cargo"]);
			$opt[$i]['email'] = trim($opciones["$i"."_email"]);
			$i++;
		}
		return $opt;
	}
		
}




?>
