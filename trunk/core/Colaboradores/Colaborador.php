<?php
/**
 * Clase que gestiona los Colaboradores.
 */
include_once('../../html/Common/php/utils/utils.php');
class Colaborador{

	/**
	 * Identificador del Colaborador. Coincide con el id de la BBDD.
	 * @var integer
	 */
	private $id;

	/**
	 * RazÃ³n social del Colaborador.
	 * @var string
	 */
	private $razon_social;

	/**
	 * Grupo de empresas al que pertenece el colaborador.
	 * @var array indexado por id y nombre
	 */
	private $grupo_empresas;

	/**
	 * NIF del Colaborador.
	 * @var string
	 */
	private $NIF;

	/**
	 * Domicilio del Colaborador.
	 * @var string
	 */
	private $domicilio;

	/**
	 * Localidad del Colaborador.
	 * @var string
	 */
	private $localidad;

	/**
	 * Provincia del Colaborador.
	 * @var string
	 */
	private $provincia;

	/**
	 * CP.
	 * @var integer
	 */
	private $CP;

	/**
	 * cc_pago_comisiones
	 * @var integer
	 */
	private $cc_pago_comisiones;
	private $comision;
	private $comision_por_renovacion;

	/**
	 * Contactos del colaborador.
	 * @var array de ids de contactos
	 */
	private $contactos;
	/*
	 * MÃ©todos de la Clase.
	 ***********************/

	/**
	 * Constructor de la clase Colaborador.
	 *
	 * Si recibe un identificador vÃ¡lido, se carga el Colaborador de la BBDD mediante el mÃ©todo cargar(), en caso contrario crea un objeto
	 * vacÃ­o, permitiendo insertar un Colaborador nuevo mediante el mÃ©todo crear().
	 * @see cargar()
	 * @see crear()
	 *
	 * @param integer $id_colaborador Id del Colaborador. Cuando estÃ¡ definido, se carga de la BBDD.
	 */
	public function __construct($id=null){
		if($id && is_numeric($id)){
			$this->id = $id;
			$this->cargar();
		}
	}

	/**
	 * Carga todos los datos para el Colaborador en la BBDD.
	 *
	 * Este mÃ©todo es invocado cuando se le pasa un id de Colaborador vÃ¡lido al constructor, y a partir
	 * del mismo se cargan todos sus datos de la BBDD.
	 */
	private function cargar(){
		if($this->id){
			$query = "SELECT colaboradores.*
					FROM colaboradores
					WHERE colaboradores.id = '$this->id'";
			////FB::info($query,'Colaborador->cargar: QUERY');
			if(!($result = mysql_query($query)))
				throw new Exception("Error al cargar el Colaborador de la BBDD");
			else if(mysql_num_rows($result) == 0)
				throw new Exception("No se ha encontrado el Colaborador en la BBDD");

			$row = mysql_fetch_array($result);

			$this->CP = $row['CP'];
			$this->cc_pago_comisiones = $row['cc_pago_comisiones'];
			$this->comision = $row['comision'];
			$this->comision_por_renovacion = $row['comision_por_renovacion'];
			$this->domicilio = $row['domicilio'];
							
			$this->localidad = $row['localidad'];
			$this->provincia = $row['provincia'];
			$this->NIF = $row['NIF'];
				
			$this->razon_social = $row['razon_social'];
			
			$this->cargar_Contactos();
		}
	}


	/**
	 * Carga la lista de contactos asociados al colaborador.
	 */
	private function cargar_Contactos(){
		$query = "SELECT fk_contacto
					FROM colaboradores_rel_contactos
					WHERE fk_colaborador = '$this->id' AND fk_contacto <> '0'";

		$result = mysql_query($query);

		$this->contactos = array();
		while($row = mysql_fetch_array($result))
		$this->contactos[] = $row['fk_contacto'];
	}

	/*
	 * MÃ©todos observadores.
	 ***********************/

	/**
	 * Devuelve la lista de contactos
	 * @return array $contactos
	 */
	public function get_Contactos(){
		return $this->contactos;
	}

	/**
	 * Devuelve el CP
	 * @return int $CP
	 */
	public function get_CP(){
		return $this->CP;
	}

	/**
	 * Devuelve los comision
	 * @return int $comision
	 */
	public function get_Comision(){
		return $this->comision;
	}
	public function get_Comision_Por_Renovacion(){
		return $this->comision_por_renovacion;
	}
	
	public function get_CC_Pago_Comisiones(){
		return $this->cc_pago_comisiones;
	}

	/**
	 * Devuelve el domicilio
	 * @return string $domicilio
	 */
	public function get_Domicilio(){
		return $this->domicilio;
	}

	/**
	 * Devuelve el id
	 * @return int $id
	 */
	public function get_Id(){
		return $this->id;
	}

	/**
	 * Devuelve la localidad
	 * @return string $localidad
	 */
	public function get_Localidad(){
		return $this->localidad;
	}

	public function get_Provincia(){
		return $this->provincia;
	}

	/**
	 * Devuelve el NIF/CIF
	 * @return string $NIF
	 */
	public function get_NIF(){
		return $this->NIF;
	}
	/**
	 * Devuelve la razÃ³n social
	 * @return string $razon_social
	 */
	public function get_Razon_Social(){
		return $this->razon_social;
	}

	/**
	 * Devuelve la lista de contactos asociados al colaborador.
	 *
	 * A partir del array de ids de Contactos almacenado en la variable local $contactos, crea un nuevo array
	 * de objetos Contacto, que serÃ¡ el devuelto por el mÃ©todo.
	 *
	 * @return array $array_Contactos Cada elemento es una instancia de la clase Contacto;
	 */
	public function get_Lista_Contactos(){
		$array_Contactos = array();
		foreach($this->contactos as $id_Contacto)
		array_push($array_Contactos, new Contacto($id_Contacto));

		return $array_Contactos;
	}

	
	/*
	 * MÃ©todos Modificadores. 
	 *
	 ************************/

	/**
	 * Crea un nuevo Colaborador en la BBDD a partir de un array indexado con todos los campos.
	 *
	 * Comprueba la coherencia de dichos datos, elevando excepciones en caso de errores o de la ausencia
	 * de campos obligatorios. Una vez comprobados todos los campos, se asignan los valores a los atributos
	 * de la clase y se llama al mÃ©todo privado guardar(), que devolverÃ¡ el id asignado por el gestor de BBDD,
	 * que a su vez serÃ¡ el devuelto por Ã©ste mÃ©todo.
	 * El array pasado debe ser un array indexado con los nombres de los atributos de la clase.
	 *
	 * @see guardar()
	 * @param array $datos Array indexado con todos los atributos para un nuevo Colaborador.
	 * @return integer $id_colaborador Id del nuevo Colaborador.
	 */
	public function crear($datos){
		//FB::info($datos,'Colaborador crear: datos recibidos');
		/*
		 * Datos imprescindibles para crear un colaborador nuevo:
		 * 		razon social
		 * 		tipo
		 * 		domicilio
		 * 		localidad
		 * 		provincia
		 * 		cp
		 * 		sector
		 * 		gestor
		 * 		telefono
		 *
		 * Datos a los que hay que asignarle un valor por defecto:
		 * 		grupo empresas -> id=0
		 *
		 */
		$validar = new Validador();
		$ListaColaboradores = new ListaColaboradores();

		
			
		//Comprobando los datos "imprescindibles":
		$errores = '';
		if($datos['razon_social'] == '' || ! isset($datos['razon_social']))
			$errores .= "<br/>Colaborador: La raz&oacute;n social es obligatoria.";
		if($datos['localidad'] == '' || ! isset($datos['localidad']))
			$errores .= "<br/>Colaborador: La localidad es obligatoria.";
		if($datos['CP'] == '' || ! isset($datos['CP']))
			$errores .= "<br/>Colaborador: El CP es obligatorio.";
		//if($datos['provincia'] == '' || ! isset($datos['provincia']))
		//	$errores .= "<br/>Colaborador: La provincia es obligatoria.";
			
		if($errores != '') throw new Exception($errores);

		//Si todo ha ido bien:
		return $this->guardar($datos);
	}
	
	/**
	 * MÃ©todo privado que lanza las consultas necesarias para insertar en la BBDD los datos de un 
	 * colaborador, una vez filtrados y validados.
	 *
	 * @param array $datos Array indexado por nombre con los datos de un colaborador.
	 * @return integer $id Identificador asignado por el gestor de BBDD.
	 */
	private function guardar($datos){
	
		//$datos = delTildesArray($datos);
		/*$coincidencias = $this->buscar_coincidencias($datos['telefono'], $datos['razon_social']);
		if($coincidencias != '' && ! $datos['continuar'])
			return($coincidencias);*/
		
		$s_into.="";
		$s_values.="";
		if(isset($datos['NIF']) && $datos['NIF'] != ''){
			$s_into.=",NIF";
			$s_values.=",'".mysql_real_escape_string(trim($datos['NIF']))."'";
		}
		if(isset($datos['comision_por_renovacion']) && $datos['comision_por_renovacion'] != ''){
			$s_into.=",comision_por_renovacion";
			$s_values.=",'".trim($datos['comision_por_renovacion'])."'";
		}
		if(isset($datos['cc_pago_comisiones']) && $datos['cc_pago_comisiones'] != ''){
			$s_into.=",cc_pago_comisiones";
			$s_values.=",'".trim($datos['cc_pago_comisiones'])."'";
		}
		if(isset($datos['comision']) && $datos['comision'] != ''){
			$s_into.=",comision";
			$s_values.=",'".trim($datos['comision'])."'";
		}
		if(isset($datos['provincia']) && $datos['provincia'] != ''){
			$s_into.=",provincia";
			$s_values.=",'".mysql_real_escape_string(trim($datos['provincia']))."'";
		}
		if(isset($datos['domicilio']) && $datos['domicilio'] != ''){
			$s_into.=",domicilio";
			$s_values.=",'".mysql_real_escape_string(trim($datos['domicilio']))."'";
		}
	/*	if(isset($datos['CP']) && $datos['CP'] != ''){
			$s_into.=",CP";
			$s_values.=",'".trim($datos['CP'])."'";
		}*/
		$query = "
			INSERT INTO colaboradores (razon_social,localidad, CP					
									$s_into
								)VALUES(
									'".mysql_real_escape_string(trim($datos['razon_social']))."',									
									'".mysql_real_escape_string(trim($datos['localidad']))."',									
									'".trim($datos['CP'])."'
									$s_values
								);
		";									
									if(!mysql_query($query))
										throw new Exception("Error al crear el Colaborador.  <br/>".$query);
									$this->id = mysql_insert_id();

																			
		if(isset($datos['contactos'])){
			$this->add_Contactos($datos['contactos']);
		}
		if(isset($datos['contacto_nombre'])){
			$id_contacto = $this->crear_Contacto($datos);
			//Lo relacionamos y salimos
			$this->relacionar_Contacto($id_contacto);
		}
									return $this->id;
	}
	
	/**
	 * Devuelve un STRING con coincidencias encontradas
	 * @param unknown_type $telefono
	 * @param unknown_type $razon_social
	 */
	private function buscar_coincidencias($telefono, $razon_social){
		$coincidencias = '';
		
		$coincidencias_telefono = $this->coincidencias_Telefono($telefono);
		if(!empty($coincidencias_telefono))
			$coincidencias .= '<br/>Coincidencias por tel&eacute;fono: ';
		foreach($coincidencias_telefono as $colaborador)
			$coincidencias .= '<br/>'.$colaborador['razon_social'].' del gestor '.$colaborador['gestor'];
			
		$coincidencias_razon_social = $this->coincidencias_Razon_social($razon_social);
		if(!empty($coincidencias_razon_social))
			$coincidencias .= '<br/>Coincidencias por raz&oacute;n social:';
		foreach($coincidencias_razon_social as $colaborador)
			$coincidencias .= '<br/>'.$colaborador['razon_social'].' del gestor '.$colaborador['gestor'];
		
		return $coincidencias;
	}
	
	/**
	 * Devuelve un ARRAY con las razones sociales de los colaboradores que tienen el teléfono
	 * @param unknown_type $telefono
	 */
	private function coincidencias_Telefono($telefono){
		$coincidencias = array();
		$query = "SELECT razon_social, fk_usuario as gestor 
					FROM colaboradores
						INNER JOIN colaboradores_rel_usuarios ON colaboradores.id = colaboradores_rel_usuarios.fk_colaborador AND colaboradores_rel_usuarios.ha_insertado = '1'
					WHERE telefono = '$telefono';";
		$rs = mysql_query($query);
		if(mysql_num_rows($rs) > 0){
			while($row = mysql_fetch_array($rs))
				$coincidencias[] = $row;
		}			
		return $coincidencias;
	}
	/**
	 * Devuelve un ARRAY con las razones sociales de los colaboradores que tienen alguna coincidencia con la razon social pasada
	 * @param unknown_type $razon_social
	 */
	private function coincidencias_Razon_Social($razon_social){
		
		$filtro = '';
		$esp_duplicados = eregi_replace("[[:space:]]+"," ",$razon_social);
			$tmp = explode(" ", $esp_duplicados);
			$filtro.= " AND ( 0 ";
			foreach($tmp as $palabro){
					$filtro.= " OR razon_social LIKE '% $palabro %' ";
			}
			$filtro.= " )";
		
		
		$coincidencias = array();
		$query = "SELECT razon_social, fk_usuario as gestor
					FROM colaboradores
						INNER JOIN colaboradores_rel_usuarios ON colaboradores.id = colaboradores_rel_usuarios.fk_colaborador AND colaboradores_rel_usuarios.ha_insertado = '1'
					WHERE 1 $filtro";
		//FB::error($query);
		$rs = mysql_query($query);
		if(mysql_num_rows($rs) > 0){
			while($row = mysql_fetch_array($rs))
				$coincidencias[] = $row;
		}			
		return $coincidencias;
	}
	
	public function get_DisableEdit(){
		$disable = array();
		$usuario = new Usuario($_SESSION['usuario_login']);
		if(!$usuario->esAdministrador()){ 
			//FB::error($this,'entro');
			if($this->razon_social != '')
				$disable['razon_social'] = 'readonly="readonly"'; 
			if($this->NIF != '')
				$disable['NIF'] = 'readonly="readonly"';
			if($this->domicilio != '')
				$disable['domicilio'] = 'readonly="readonly"';
			if($this->localidad != '')
				$disable['localidad'] = 'readonly="readonly"';
			if($this->provincia != '')
				$disable['provincia'] = 'readonly="readonly"';
			if($this->comision_por_renovacion != '')
				$disable['comision_por_renovacion'] = 'readonly="readonly"';
			if($this->cc_pago_comisiones != '')
				$disable['cc_pago_comisiones'] = 'readonly="readonly"';
			if($this->CP != '')
				$disable['CP'] = 'readonly="readonly"';
			if($this->comision != '')
				$disable['comision'] = 'readonly="readonly"';
			
		}
		//FB::error($disable);
		return $disable;
	}
	/**
	 * Crea un contacto nuevo indicado en la creaciÃ³n del Colaborador
	 * @param $datos
	 * @return unknown_type
	 */
	public function crear_Contacto($datos){
		$Contacto = new Contacto();
		$datos_contacto = array('nombre'=>$datos['contacto_nombre'],'telefono'=>$datos['contacto_telefono'],'email'=>$datos['contacto_email'],'cargo'=>$datos['contacto_cargo']);
		$id_contacto = $Contacto->crear($datos_contacto);

		return $id_contacto;

	}

	public function add_Contactos($array_datos_contactos){
		foreach($array_datos_contactos as $datos_contacto){
			$this->add_Contacto($datos_contacto);
		}
	}

	public function add_Contacto($datos){
		$id_contacto = $this->existe_Contacto($datos);
		if(!$id_contacto){
			$contacto = new Contacto();
			$contacto->crear($datos);
			$id_contacto = $contacto->get_Id();
		}
		$this->relacionar_Contacto($id_contacto);
	}

	private function existe_Contacto($datos){
		$query = "SELECT id FROM contactos WHERE nombre = '".$datos['nombre']."' AND telefono = '".$datos['telefono']."'; ";
		$rs = mysql_query($query);
		$row = mysql_fetch_array($rs);

		if(mysql_num_rows($rs) > 0)
		return $row['id'];
		return false;
	}
	
	public function del_Contacto($id_contacto){
		$query = "DELETE FROM colaboradores_rel_contactos WHERE fk_contacto = '$id_contacto' AND fk_colaborador = '$this->id'; ";
		mysql_query($query);
		
		$query = "DELETE FROM contactos WHERE id = '$id_contacto'; ";
		mysql_query($query);
	}
	
	public function del_Colaborador(){
            if($this->id != 1){
		$query = "DELETE FROM colaboradores WHERE id = '$this->id'; ";
		mysql_query($query);
            }
		
	}
	public function relacionar_Contacto($id_contacto){
		$query = "INSERT INTO colaboradores_rel_contactos (fk_colaborador, fk_contacto) VALUES ('$this->id','$id_contacto')";
		$rs = mysql_query($query);
	}

	

	/**
	 * Modifica el nombre del Colaborador.
	 *
	 * @param int $CP nuevo CP
	 */
	public function set_CP($CP){
		$Validar = new Validador();

		if($this->id && $Validar->CP($CP)){

			$query = "UPDATE colaboradores SET CP='".trim($CP)."' WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el CP en la BBDD.");

			$this->CP = $CP;
		}else
		throw new Exception("CP incorrecto.");
	}

	/**
	 * Modifica los comision
	 *
	 * @param int $comision
	 */
	public function set_Comision($comision){

		if($this->id && (is_numeric($comision) || $comision=='' )){
			if($comision!='')
				$query = "UPDATE colaboradores SET comision='".trim($comision)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE colaboradores SET comision=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la comision en la BBDD.");

			$this->comision = $comision;
		}else
		throw new Exception("Comision incorrecta.");
	}

	public function set_Comision_Por_Renovacion($comision_por_renovacion){

		if($this->id && (is_numeric($comision_por_renovacion) || $comision_por_renovacion=='' )){
			if($comision_por_renovacion!='')
				$query = "UPDATE colaboradores SET comision_por_renovacion='".trim($comision_por_renovacion)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE colaboradores SET comision_por_renovacion=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar la comision por renovacion en la BBDD.");

			$this->comision_por_renovacion = $comision_por_renovacion;
		}else
		throw new Exception("Comision incorrecta.");
	}
	
	public function set_CC_Pago_Comisiones($cc_pago_comisiones){

		if($this->id && (is_numeric($cc_pago_comisiones) || $cc_pago_comisiones=='' )){
			if($cc_pago_comisiones!='')
				$query = "UPDATE colaboradores SET cc_pago_comisiones='".trim($cc_pago_comisiones)."' WHERE id='$this->id' ";
			else
				$query = "UPDATE colaboradores SET cc_pago_comisiones=null WHERE id='$this->id' ";
			if(!mysql_query($query))
			throw new Exception("Error al actualizar el cc_pago_comisiones en la BBDD.");

			$this->comision = $comision;
		}else
		throw new Exception("CC Pago comisiones incorrecto.");
	}

	/**
	 * Modifica el domicilio del Colaborador.
	 *
	 * Si el domicilio es igual que el actual, no lanza la consulta, y si viene vacÃ­a se eleva una excepciÃ³n.
	 *
	 * @param string $domicilio Nuevo domicilio.
	 */
	public function set_Domicilio($domicilio){
		$Validar = new Validador();
		if($this->id && strcmp($this->domicilio, $domicilio) != 0){
			if($Validar->cadena($domicilio)){
				$query = "UPDATE colaboradores SET domicilio='".mysql_real_escape_string($domicilio)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el domicilio en la BBDD.");
					
				$this->domicilio = $domicilio;
			}else
			throw new Exception("Domicilio incorrecto.");
		}
	}

	/**
	 * Modifica la localidad del Colaborador.
	 *
	 * Si la localidad es igual que la actual, no lanza la consulta, y si viene vacÃ­a se eleva una excepciÃ³n.
	 *
	 * @param string $localidad Nueva localidad.
	 */
	public function set_Localidad($localidad){
		$Validar = new Validador();
		if($this->id && strcmp($this->localidad, $localidad) != 0){
			if($Validar->cadena($localidad)){
				$query = "UPDATE colaboradores SET localidad='".mysql_real_escape_string($localidad)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la localidad en la BBDD.");
					
				$this->localidad = $localidad;
			}else
			throw new Exception("Localidad incorrecta.");
		}
	}

	public function set_Provincia($provincia){
		$Validar = new Validador();
		if($this->id && strcmp($this->provincia, $provincia) != 0){
			if($Validar->cadena($provincia)){
				$query = "UPDATE colaboradores SET provincia='".mysql_real_escape_string($provincia)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la provincia en la BBDD.");
					
				$this->provincia = $provincia;
			}else
			throw new Exception("Provincia incorrecta.");
		}
	}

	
	/**
	 * Modifica la razon social del Colaborador.
	 *
	 * Si la razon social es igual que la actual, no lanza la consulta, y si viene vacÃ­a se eleva una excepciÃ³n.
	 *
	 * @param string $razon_social Nueva razon social.
	 */
	public function set_Razon_Social($razon_social){
		$Validar = new Validador();
		if($this->id && strcmp($this->razon_social, $razon_social) != 0){
			if($Validar->cadena($razon_social)){
				$query = "UPDATE colaboradores SET razon_social='".mysql_real_escape_string($razon_social)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar la raz&oacute;n social en la BBDD.");
					
				$this->razon_social = $razon_social;
			}else
			throw new Exception("Raz&oacute;n social incorrecta.");
		}
	}

	
	/**
	 * Modifica la NIF del Colaborador.
	 *
	 * Si la NIF es igual que la actual, no lanza la consulta, y si viene vacÃ­a se eleva una excepciÃ³n.
	 *
	 * @param string $NIF Nueva NIF.
	 */
	public function set_NIF($NIF){
		$Validar = new Validador();
		if($this->id && strcmp($this->NIF, $NIF) != 0){
			if($Validar->nif_cif($NIF)){
				$query = "UPDATE colaboradores SET NIF='".mysql_real_escape_string($NIF)."' WHERE id='$this->id' ";
				if(!mysql_query($query))
				throw new Exception("Error al actualizar el NIF/CIF en la BBDD.");
					
				$this->NIF = $NIF;
			}else
			throw new Exception("NIF/CIF incorrecto.");
		}
	}


}
?>
