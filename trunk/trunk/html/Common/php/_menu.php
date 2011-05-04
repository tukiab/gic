<?php 	include ('appRoot.php');


//Definiendo la clase
class MainMenu{
	
	public $menus = array();
	
	/**
	 * Constructor
	 */	
	public function MainMenu($user){
		if(isset($user))
			$codeButtons = $this->getUserMenu($user);
		else
			$codeButtons = $this->getPublicMenu($user);
	}
	
	public function getUserMenu($user){
		global $appDir;
		global $permisos;

		$usuario = New Usuario($user);
		$perfil_usuario = $usuario->get_Perfil();
		
		$this->menus[0]= new Menu("$appDir/index.php", "Inicio", "inicio");
		
		$this->menus[1][0]= new Menu("#", "Empresas +", "clientes");
			$this->menus[1][1]= new Menu("$appDir/Clientes/searchClientes.php", "B&uacute;squeda");
			$this->menus[1][2]= new Menu("$appDir/Clientes/addCliente.php", "Nueva");

		$this->menus[2]= new Menu("$appDir/Ofertas/searchOfertas.php", "Ofertas/O-N", "ofertas");
			//$this->menus[2][1]= new Menu("$appDir/Ofertas/searchOfertas.php", "B&uacute;squeda");

		$this->menus[3]= new Menu("$appDir/Ventas/searchVentas.php", "Ventas", "ventas");
		
		$this->menus[4]= new Menu("$appDir/Acciones/searchAcciones.php", "Acciones de trabajo", "acciones");
		$this->menus[5]= new Menu("$appDir/Tareas/searchTareas.php", "Tareas t&eacute;cnicas", "tareas");

		$this->menus[6][0]= new Menu("#", "Proyectos", "proyectos");
			$this->menus[6][1]= new Menu("$appDir/Proyectos/searchProyectos.php", "B&uacute;squeda");
			if($perfil_usuario['id'] == 5 || $perfil_usuario['id'] == 6){ //administrador y director técnico
				$this->menus[6][2]= new Menu("$appDir/Proyectos/addProyecto.php", "Crear directamente");
			}
			
		if($perfil_usuario['id'] == 5 || $perfil_usuario['id'] == 4){
		
			$this->menus[7][0]= new Menu("#", "Informes +", "informes");
				$this->menus[7][1] = new Menu("$appDir/Acciones/reportsAcciones.php", "Acciones", "acciones");
				$this->menus[7][2] = new Menu("$appDir/Ofertas/reportsOfertas.php", "Ofertas", "ofertas");
				$this->menus[7][3] = new Menu("$appDir/Ventas/reportsVentas.php", "Ventas", "ventas");
				$this->menus[7][5] = new Menu("$appDir/Ventas/informeComercial.php", "Comercial", "comercial");
				$this->menus[7][6] = new Menu("$appDir/Ventas/informeComisiones.php", "Comisiones", "comisiones");
				$this->menus[7][7] = new Menu("$appDir/Proyectos/searchProyectos.php?informe=resumen", "Proyectos", "proyectos");
				$this->menus[7][8] = new Menu("$appDir/Planificacion/", "Planificacion", "planificacion");
				$this->menus[7][9] = new Menu("$appDir/Proyectos/informeTecnico.php", "Tecnico", "tecnico");
				$this->menus[7][10] = new Menu("$appDir/Proyectos/informeTecnicoMensual.php", "Tecnico mensual", "tecnico");
				
			$this->menus[8][0]= new Menu("#", "Colaboradores +", "colaboradores");
				$this->menus[8][1]= new Menu("$appDir/Colaboradores/searchColaboradores.php", "Listado");
				$this->menus[8][2]= new Menu("$appDir/Colaboradores/addColaborador.php", "Nuevo");

			$this->menus[9][0]= new Menu("#", "Proveedores +", "proveedores");
				$this->menus[9][1]= new Menu("$appDir/Proveedores/searchProveedores.php", "B&uacute;squeda");
				$this->menus[9][2]= new Menu("$appDir/Proveedores/addProveedor.php", "Nuevo");
				
			$this->menus[10][0]= new Menu("#", "Administraci&oacute;n +", "usuarios");
				$this->menus[10][1]= new Menu("$appDir/Administracion/miEmpresa.php", "Administracion");
				$this->menus[10][2]= new Menu("$appDir/Administracion/gestionUsuarios.php", "Usuarios");
				$this->menus[10][3]= new Menu("$appDir/Administracion/gestionGrupos.php", "Grupos de empresas");
				$this->menus[10][4]= new Menu("$appDir/Administracion/gestionTiposProducto.php", "Tipos de producto");
				$this->menus[10][5]= new Menu("$appDir/Administracion/gestionTiposAccion.php", "Tipos de accion");
				$this->menus[10][6]= new Menu("$appDir/Administracion/gestionTiposFormasDePago.php", "Tipos de formas de pago");
				//$this->menus[9][7]= new Menu("$appDir/Administracion/gestionTiposComision.php", "Tipos de comisi&oacute;n");
			
		}else if($perfil_usuario['id'] == 3 || $perfil_usuario['id'] == 6){//los técnicos tienen que ver el informe de planificación
			$this->menus[8][0]= new Menu("#", "Informes +", "informes");
			$this->menus[8][1] = new Menu("$appDir/Planificacion/", "Planificacion", "planificacion");
			$this->menus[8][3] = new Menu("$appDir/Proyectos/informeTecnico.php", "Tecnico", "tecnico");
			$this->menus[8][4] = new Menu("$appDir/Proyectos/informeTecnicoMensual.php", "Tecnico mensual", "tecnico");
		}
		
	//	$this->menus[11] = new Menu("$appDir/Facturas/searchFacturas.php", "Facturas", "facturas");
		
				
	}
	
	public function getPublicMenu(){
		global $appDir;
		$this->menus[0]= new Menu("$appDir/index.php", "Login");		
	}
	
	
	
}

class Menu{
	
	public $url;
	public $tag;
	public $dir;
	
	public function Menu($url, $tag, $dir=null){
		$this->url = $url;
		$this->tag = $tag;	
		$this->dir=$dir;
	}
}
?>
