<?php 
include ('../appRoot.php');

include ($appRoot.'/Common/php/utils/params.php');

class InsertarClientes{
	
	public $opt = array();
	
	public $arrayClientes = array(); 
	
	private $arrayClientesInsertados = array();	
	/**
	 * Constructor
	 * 
	 * Recibe los datos del formulario, incluyendo el archivo, y actualiza las incidencias dadas 
	 * en el archivo mediante sus identificadores, asignando previamente valores a los atributos.
	 * 
	 * @param $opciones
	 * @param $opt_archivo
	 * 
	 */
	public function InsertarClientes($opciones, $opt_archivo){
		global $permisos;
		set_time_limit(0);

		@(isset($opt_archivo['archivo'])?$this->opt['archivo']=$opt_archivo['archivo']:null);
		
		//creamos nuestro array con los ids de incidencias
		try{
			$filename = $this->opt['archivo']['tmp_name'];
			$this->arrayClientes = $this->crearArrayClientes($filename);
		
			$arrayClientesInsertados = array();
			foreach($this->arrayClientes as $arrayCliente){				
				$this->insertar_Cliente($arrayCliente);					
			}
		}catch (Exception $e){
			$this->opt['msgs'] = $this->opt['msgs'].'<br/>- '.$e->getMessage();	
		}		
	}
	
	private function crearArrayClientes($filename){
		
		if($filename == '' || $filename == null)
			throw new Exception('Debe cargar un archivo.php');
				
		$file = file($filename);
		$lines = count($file);
		$array_clientes = array(); //array con cada línea del archivo
		
		for ($line=0; $line<=$lines-1; $line++){ //no llegamos a la última línea porque interpreta la última línea en blanco
			$consalto .= $file[$line];
			//$array_clientes= explode(":::", $file[$line]);
		}
		$sinsalto =  eregi_replace("[\n|\r|\n\r]", ' ', $consalto);
		
		$array_clientes= explode(":::", $sinsalto);
		return $array_clientes;	
	}
	 
	
	private function insertar_Cliente($array_cliente){
		try{
			
			$cliente = new Cliente();
			$datos_cliente = explode(";",$array_cliente);
			
			if(@in_array($this->arrayClientesInsertados, $datos_cliente[0])){
				$this->actualizar_Cliente($arrayCliente);
			}else{
				$this->arrayClientesInsertados[] = $datos_cliente[0];
			
				//datos propios del cliente:
				$datos['razon_social'] = utf8_encode($datos_cliente[0]);
				//FB::info($datos['razon_social']);
				$datos['domicilio'] = utf8_encode($datos_cliente[4]);
				$datos['localidad'] = utf8_encode($datos_cliente[5]);
				$datos['provincia'] = utf8_encode(trim($datos_cliente[6]));
				$datos['sector'] = utf8_encode($datos_cliente[16]);
				$datos['SPA_actual'] = utf8_encode($datos_cliente[17]);			
				$datos['CP'] = utf8_encode($datos_cliente[7]);

                                $listaClientes = new ListaClientes();
                                $datos['tipo_cliente'] = 1; //Por defecto potencial
                                foreach($listaClientes->lista_Tipos(array('nombre' => $datos_cliente[1])) as $tipo)
                                    $datos['tipo_cliente'] = $tipo['id'];

                                if(!is_numeric($datos_cliente[2])){
                                    $listaGrupos = new ListaGruposEmpresas();
                                    $listaGrupos->buscar(array('nombre'=>$datos_cliente[2]));
                                    if(!$grupo = $listaGrupos->siguiente()){
                                        throw new Exception("No existe el grupo de empresas");
                                    }
                                    $datos['grupo_empresas'] = $grupo->get_Id();
                                }
				$datos['telefono'] = str_replace("-","",str_replace(" ","",$datos_cliente[10]));
				$datos['NIF'] = $datos_cliente[3];
				$datos['numero_empleados'] = $datos_cliente[14];
				$datos['web'] = $datos_cliente[15];
				$datos['fecha_renovacion'] = date2timestamp($datos_cliente[18]);
				$datos['FAX'] = str_replace("-","",str_replace(" ","",$datos_cliente[12]));
				$datos['creditos'] = $datos_cliente[20];
				$datos['norma_implantada'] = utf8_encode($datos_cliente[19]);
				
				//gestor
				$datos_gestor['id'] = $datos_cliente[21];
				$lista_usuarios = new ListaUsuarios();
				$lista_usuarios->buscar($datos_gestor);
				if(!$gestor = $lista_usuarios->siguiente())
                                    throw new Exception("No existe el gestor");
				
				//FB::error($gestor," gestor de ".$datos['razon_social']);
				
				$datos['gestor']=$gestor->get_Id();
				$datos['continuar'] = true;
				$cliente->crear($datos);
	
				if($cliente->get_Id()){
				//datos de contacto
				$datos_contacto['email'] = $datos_cliente[13];
				$datos_contacto['nombre'] = utf8_encode($datos_cliente[8]);
				$datos_contacto['cargo'] = utf8_encode($datos_cliente[9]);			
				$datos_contacto['telefono'] = str_replace("-","",str_replace(" ","",$datos_cliente[11]));
	
				if($datos['nombre']=='')
				$cliente->add_Contacto($datos_contacto);			
	
				//oportunidades de negocio --> insertar como si fueran acciones de trabajo con fecha actual
				$accion = new Accion();
				
				$fecha_actual = fechaActualTimeStamp();
				$datos_accion['descripcion'] = utf8_encode($datos_cliente[23]);
				$datos_accion['tipo_accion'] = 1;
				$datos_accion['cliente'] = $cliente->get_Id();
				$datos_accion['usuario'] = $gestor->get_Id();
				$datos_accion['fecha'] = $fecha_actual;			
				if($datos_accion['descripcion'] != '')
					$cliente->add_Accion($datos_accion);			
	
				$datos_accion['descripcion'] = utf8_encode($datos_cliente[24]);
				if($datos_accion['descripcion'] != '')			
					$cliente->add_Accion($datos_accion);
	
				//acciones de trabajo
				$array_fecha = explode('/',$datos_cliente[25]);
				$str_fecha = $array_fecha[2].'/'.$array_fecha[1].'/'.$array_fecha[0]; 
				$fecha = strtotime($str_fecha);
				$datos_accion['fecha'] = $fecha;
				if($fecha == '')
					$datos_accion['fecha'] = $fecha_actual;
				$datos_accion['descripcion'] = utf8_encode($datos_cliente[26]);
				if($datos_accion['descripcion'] != '')
					$cliente->add_Accion($datos_accion);
					
				}
			}
			
		}catch(Exception $e){
			$this->opt['msgs'] = $this->opt['msgs'].'<br/>- '.$e->getMessage().' en '.$datos['razon_social'];
		}		
	}
	
	private function actualizar_Cliente($array_cliente){
		try{
			$cliente = new Cliente();
			$datos_cliente = explode(";",$array_cliente);
			//datos propios del cliente:
			$datos['razon_social'] = $datos_cliente[0];
			
			$listaClientes = new ListaClientes();
			$listaClientes->buscar($datos);
			
			$cliente = $listaClientes->siguiente();
			$datos['telefono'] = str_replace("-","",str_replace(" ","",$datos_cliente[10]));//quitamos espacios en blanco y guiones
			$datos['NIF'] = $datos_cliente[3];
			$datos['numero_empleados'] = $datos_cliente[14];
			$datos['web'] = $datos_cliente[15];
			$datos['fecha_renovacion'] = date2timestamp($datos_cliente[18]);
			$datos['FAX'] = str_replace("-","",str_replace(" ","",$datos_cliente[12]));//quitamos espacios en blanco y guiones
			$datos['creditos'] = $datos_cliente[20];
			$datos['norma_implantada'] = $datos_cliente[19];
			
			//gestor
			$datos_gestor['id'] = $datos_cliente[21];
			$lista_usuarios = new ListaUsuarios();
			$lista_usuarios->buscar($datos_gestor);
			$gestor = $lista_usuarios->siguiente();
			
			//datos de contacto
			$datos_contacto['email'] = $datos_cliente[13];
			$datos_contacto['nombre'] = $datos_cliente[8];
			$datos_contacto['cargo'] = $datos_cliente[9];			
			$datos_contacto['telefono'] = str_replace("-","",str_replace(" ","",$datos_cliente[11]));//quitamos espacios en blanco y guiones

			$cliente->add_Contacto($datos_contacto);			

			//oportunidades de negocio --> insertar como si fueran acciones de trabajo con fecha actual
			$accion = new Accion();
			
			$fecha_actual = fechaActualTimeStamp();
			$datos_accion['descripcion'] = $datos_cliente[23];
			$datos_accion['tipo_accion'] = 1;
			$datos_accion['cliente'] = $cliente->get_Id();
			$datos_accion['usuario'] = $gestor->get_Id();
			$datos_accion['fecha'] = $fecha_actual;			
			if($datos_accion['descripcion'] != '')
				$cliente->add_Accion($datos_accion);			

			$datos_accion['descripcion'] = $datos_cliente[24];
			if($datos_accion['descripcion'] != '')			
				$cliente->add_Accion($datos_accion);

			//acciones de trabajo
			$array_fecha = explode('/',$datos_cliente[25]);
			$str_fecha = $array_fecha[2].'/'.$array_fecha[1].'/'.$array_fecha[0]; 
			$fecha = strtotime($str_fecha);
			$datos_accion['fecha'] = $fecha;
			if($fecha == '')
				$datos_accion['fecha'] = $fecha_actual;
			$datos_accion['descripcion'] = $datos_cliente[26];
			if($datos_accion['descripcion'] != '')
				$cliente->add_Accion($datos_accion);
			
		}catch(Exception $e){
			$this->opt['msgs'] = $this->opt['msgs'].'<br/>- '.$e->getMessage().' en '.$datos['razon_social'];
		}		
	}
	
}

?>
