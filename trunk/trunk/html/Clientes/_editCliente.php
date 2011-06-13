<?php
include ('../appRoot.php');

//Validación de datos
include_once($appRoot."/Common/php/validar.php");

class EditCliente{
	
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
	 * Instancia de la clase Cliente.
	 *
	 * @var object
	 */
	public $Cliente;
	
	/**
	 * Para obtener los listados de atributos seleccionables.
	 *
	 * @var object
	 */
	private $ListaClientes;
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
		////FB::log($opciones, '_editar_datos_cliente.php -> opciones');
		$this->gestor = new Usuario($_SESSION['usuario_login']);
		//Obtenemos las opciones pasadas al script
		if(!$opciones['id'] || !is_numeric($opciones['id']))
			exit("No se ha definido un ID de Cliente v�lido.php");

		$this->Cliente = new Cliente($opciones['id']);
		$this->ListaClientes = new ListaClientes();
		
		if($opciones['id_gestor'])
			$this->addGestor($opciones['id_gestor']);
		
		if($opciones['guardar'] || $opciones['eliminar'])
			$this->EditarDatosCliente($opciones);

		$this->Cliente = new Cliente($opciones['id']);
		$this->obtenerDatos();
	}
		
	/**
	 * Modifica los datos referentes a la cliente, haciendo uso de la interfaz de dicha clase.
	 *
	 * @param array $opciones Array $_GET
	 */
	public function EditarDatosCliente($opciones){
		////FB::log($opciones, "Opciones:EditarDatosCliente");
		
		//Por si eliminamos un contacto
		$datos_contactos = $this->get_Opciones_Contactos($opciones);

		$datos_sedes = $this->get_Opciones_Sedes($opciones);
		
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
									$this->Cliente->add_Contacto($array_contacto);
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
				case 'sedes':
					try{
						foreach($datos_sedes as $array_sede){

							$id_sede = $array_sede['id'];
							$Sede = new Sede($id_sede);

							if($id_sede == 'n')
								//Creamos el sede
								$this->Cliente->crear_Sede ($array_sede);
							else{
								//Actualizamos el sede
								if($Sede->get_Localidad() != $array_sede['localidad']){
									$Sede->set_Localidad($array_sede['localidad']);
								}
								if($Sede->get_Provincia() != $array_sede['provincia']){
									$Sede->set_Provincia($array_sede['provincia']);
								}
								if($Sede->get_Direccion() != $array_sede['direccion']){
									$Sede->set_Direccion($array_sede['direccion']);
								}
								if($Sede->get_CP() != $array_sede['CP']){
									$Sede->set_CP($array_sede['CP']);
								}
							}
						}
						$this->msg .= "Guardado";
					}catch (Exception $e){
						$this->msg .= "Error: ".$e->getMessage();
						$this->opt['sede_error'] = $array_sede;
					}
					break;
				case 'cliente':
						//Obtener los datos de la cliente y enviarlos a la BD
						$datos_cliente = $this->get_Opciones_Cliente($opciones);
				
						$this->Cliente = new Cliente($datos_cliente['id']);
						try{
							if($this->Cliente->get_Razon_Social() != $datos_cliente['razon_social'])
								$this->Cliente->set_Razon_Social($datos_cliente['razon_social']);								
							
							$tipo_cliente = $this->Cliente->get_Tipo_Cliente();
							if($tipo_cliente['id'] != $datos_cliente['tipo_cliente'])
								$this->Cliente->set_Tipo($datos_cliente['tipo_cliente']);
							
							if($this->Cliente->get_Localidad() != $datos_cliente['localidad'])
								$this->Cliente->set_Localidad($datos_cliente['localidad']);

							if($this->Cliente->get_Domicilio() != $datos_cliente['domicilio'])
								$this->Cliente->set_Domicilio($datos_cliente['domicilio']);

							if($this->Cliente->get_Provincia() != $datos_cliente['provincia'])
								$this->Cliente->set_Provincia($datos_cliente['provincia']);
								
							$grupo_cliente = $this->Cliente->get_Grupo_Empresas();
							if($grupo_cliente['id'] != $datos_cliente['grupo_empresas'])
								$this->Cliente->set_Grupo_Empresas($datos_cliente['grupo_empresas']);
								
							if($this->Cliente->get_NIF() != $datos_cliente['NIF'])
								$this->Cliente->set_NIF($datos_cliente['NIF']);
								
							if($this->Cliente->get_CP() != $datos_cliente['CP'])
								$this->Cliente->set_CP($datos_cliente['CP']);
								
							if($this->Cliente->get_Numero_Empleados() != $datos_cliente['numero_empleados'] || $datos_cliente['numero_empleados'] == '')
								$this->Cliente->set_Numero_Empleados($datos_cliente['numero_empleados']);								
							
							if($this->Cliente->get_Web() != $datos_cliente['web'])
								$this->Cliente->set_Web($datos_cliente['web']);
							
							if($this->Cliente->get_Telefono() != $datos_cliente['telefono'])
								$this->Cliente->set_Telefono($datos_cliente['telefono']);

							if($this->Cliente->get_FAX() != $datos_cliente['FAX'])
								$this->Cliente->set_FAX($datos_cliente['FAX']);								
							if($this->Cliente->get_Sector() != $datos_cliente['sector'])
								$this->Cliente->set_Sector($datos_cliente['sector']);
								
							if($this->Cliente->get_SPA_Actual() != $datos_cliente['SPA_actual'])
								$this->Cliente->set_SPA_Actual($datos_cliente['SPA_actual']);
								
							if($this->Cliente->get_Fecha_Renovacion() != $datos_cliente['fecha_renovacion'])
								$this->Cliente->set_Fecha_Renovacion($datos_cliente['fecha_renovacion']);
								
							if($this->Cliente->get_Norma_Implantada() != $datos_cliente['norma_implantada'])
								$this->Cliente->set_Norma_Implantada($datos_cliente['norma_implantada']);
								
							if($this->Cliente->get_Creditos() != $datos_cliente['creditos'])
								$this->Cliente->set_Creditos($datos_cliente['creditos']);

							
							$this->Cliente->set_Observaciones($datos_cliente['observaciones']);
							$this->Cliente->set_Actividad($datos_cliente['actividad']);
								
							$this->msg = "Guardado";
						}catch(Exception $e){
							$this->msg= $e->getMessage();
						}
										
					break;
			}

		}	
		else if($opciones['eliminar']){
			try{
				switch($opciones['edit']){
					case 'contacto':
						$this->Cliente->del_Contacto($opciones['eliminar']);
					break;
					case 'sedes':
						$Sede = new Sede($opciones['eliminar']);
						$Sede->del_Sede();
					break;
				}
			}catch(Exception $e){
				$this->msg = $e->getMessage();
			}
		}
			
		
	}
	
	public function obtenerDatos(){
		//Obteniendo datos para los atributos seleccionables de una lista en la página
		$this->datos['lista_tipos_cliente'] = $this->ListaClientes->lista_Tipos();
		$this->datos['lista_grupos_empresas'] = $this->ListaClientes->lista_Grupos_Empresas();
		$this->datos['lista_contactos'] = $this->Cliente->get_Lista_Contactos();
		$this->datos['lista_sedes'] = $this->Cliente->get_Lista_Sedes();
		
		$lista_usuarios = new ListaUsuarios();
		$todos_usuarios = $lista_usuarios->buscar();
		$this->datos['lista_gestores'] = $lista_usuarios;
	}
	
	private function get_Opciones_Cliente($opciones){
		$opt = array();
		$opt['id'] = $opciones['id'];
		$opt['razon_social'] = $opciones['razon_social'];
		$opt['tipo_cliente'] = trim($opciones['tipo_cliente']);
		
		$opt['telefono'] = trim($opciones['telefono']);
		$opt['FAX'] = trim($opciones['FAX']);
		
		$opt['grupo_empresas'] = trim($opciones['grupo_empresas']);
		$opt['NIF'] = trim($opciones['NIF']);
		$opt['domicilio'] = trim($opciones['domicilio']);
		$opt['localidad'] = trim($opciones['localidad']);
		$opt['provincia'] = trim($opciones['provincia']);
		$opt['CP'] = trim($opciones['CP']);
		$opt['numero_empleados'] = trim($opciones['numero_empleados']);
		$opt['web'] = trim($opciones['web']);
		$opt['sector'] = trim($opciones['sector']);
		
		$opt['SPA_actual'] = $opciones['SPA_actual'];
		$opt['fecha_renovacion'] = date2timestamp(trim($opciones['fecha_renovacion']));
		$opt['norma_implantada'] = trim($opciones['norma_implantada']);
		$opt['creditos'] = trim($opciones['creditos']);

		$opt['observaciones'] = trim($opciones['observaciones']);
		$opt['sedes'] = trim($opciones['sedes']);
		$opt['actividad'] = trim($opciones['actividad']);
		
		return $opt;
	}
	
	private function get_Opciones_Contactos($opciones){
		$opt = array();	
		$i='n';
		if(isset($opciones["n_nombre"])){
			$opt[$i]['id'] = 'n';
			$opt[$i]['id_cliente'] = $this->Cliente->get_Id();
			$opt[$i]['telefono'] = trim($opciones["n_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["n_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["n_cargo"]);
			$opt[$i]['email'] = trim($opciones["n_email"]);
		}
		
		$i=0;
		while(!empty($opciones["$i"."_nombre"])){
			$opt[$i]['id'] = $opciones["$i"."_id"];
			$opt[$i]['id_cliente'] = $this->Cliente->get_Id();
			$opt[$i]['telefono'] = trim($opciones["$i"."_telefono"]);
			$opt[$i]['nombre'] = trim($opciones["$i"."_nombre"]);
			$opt[$i]['cargo'] = trim($opciones["$i"."_cargo"]);
			$opt[$i]['email'] = trim($opciones["$i"."_email"]);
			$i++;
		}
		return $opt;
	}

	private function get_Opciones_Sedes($opciones){
		$opt = array();
		$i='n';
		if($opciones["n_localidad"] || $opciones["n_provincia"] || $opciones["n_direccion"] || $opciones["n_CP"]){
			$opt[$i]['id'] = 'n';
			$opt[$i]['id_cliente'] = $this->Cliente->get_Id();
			$opt[$i]['localidad'] = trim($opciones["n_localidad"]);
			$opt[$i]['provincia'] = trim($opciones["n_provincia"]);
			$opt[$i]['direccion'] = trim($opciones["n_direccion"]);
			$opt[$i]['CP'] = trim($opciones["n_CP"]);
		}

		$i=0;
		while(!empty($opciones["$i"."_localidad"])){
			$opt[$i]['id'] = $opciones["$i"."_id"];
			$opt[$i]['id_cliente'] = $this->Cliente->get_Id();
			$opt[$i]['localidad'] = trim($opciones["$i"."_localidad"]);
			$opt[$i]['provincia'] = trim($opciones["$i"."_provincia"]);
			$opt[$i]['direccion'] = trim($opciones["$i"."_direccion"]);
			$opt[$i]['CP'] = trim($opciones["$i"."_CP"]);
			$i++;
		}
		return $opt;
	}
	
	private function addGestor($id_gestor){
		$this->Cliente->add_Gestor($id_gestor);
		$this->msg = "Gestor añadido";		
	}
	
}




?>
