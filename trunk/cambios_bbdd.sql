-- leer acciones de trabajo
ALTER TABLE `acciones_de_trabajo` ADD `leida` INT( 1 ) NOT NULL DEFAULT '0';

-- leer ofertas/oportunidades
ALTER TABLE `ofertas` ADD `leida` INT( 1 ) NOT NULL DEFAULT '0';

-- nuevos campos en la tabla clientes
ALTER TABLE `clientes` ADD `observaciones` LONGTEXT NULL DEFAULT NULL ,
ADD `actividad` LONGTEXT NULL DEFAULT NULL ;

-- VENTAS
-- nuevos campos de fecha
ALTER TABLE `ventas` ADD `fecha_toma_contacto` INT( 11 ) NOT NULL DEFAULT '0' AFTER `fecha_entrada_vigor` ,
ADD `fecha_inicio` INT( 11 ) NOT NULL DEFAULT '0' AFTER `fecha_toma_contacto` ,
ADD `fecha_estimada_formacion` INT( 11 ) NOT NULL DEFAULT '0' AFTER `fecha_inicio` ,
ADD `fecha_pago_inicial` INT( 11 ) NOT NULL DEFAULT '0' AFTER `fecha_estimada_formacion` ;

ALTER TABLE `ventas` ADD `forcem` LONGTEXT NULL ,
ADD `plazo_ejecucion` LONGTEXT NULL ,
ADD `cuenta_cargo` VARCHAR( 23 ) NULL ,
ADD `observaciones_forma_pago` LONGTEXT NULL ,
ADD `nombre_certificadora` VARCHAR( 500 ) NULL ,
ADD `otros_proyectos` LONGTEXT NULL ,
ADD `observaciones` LONGTEXT NULL ;

ALTER TABLE `ventas` ADD `precio_consultoria` float NOT NULL DEFAULT '0',
ADD `precio_formacion` float NOT NULL DEFAULT '0',
ADD `pago_inicial` float NOT NULL DEFAULT '0',
ADD `pago_mensual` float NOT NULL DEFAULT '0',
ADD `numero_pagos_mensuales` INT( 3 ) NOT NULL DEFAULT '0';

ALTER TABLE `ventas` ADD `subvenciones` TINYINT( 1 ) NOT NULL DEFAULT '0',
ADD `certificacion` TINYINT( 1 ) NOT NULL DEFAULT '0',
ADD `presupuesto_aceptado_certificadora` TINYINT( 1 ) NOT NULL DEFAULT '0';

-- SEDES de los clientes (empresas)
CREATE TABLE IF NOT EXISTS `clientes_sedes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `localidad` varchar(45) NOT NULL,
  `CP` int(11) DEFAULT NULL,
  `provincia` varchar(15) DEFAULT NULL,
  `direccion` varchar(400) DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL,
  `es_sede_principal` TINYINT( 1 ) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `clientes_sedes_rel_contactos` (
  `fk_clientes_sede` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_clientes_sede`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Hay que introducir las sedes principales de los clientes que ya existen:
INSERT INTO `clientes_sedes` (`localidad`, `CP`, `provincia`, `direccion`, `fk_cliente`)
	SELECT clientes.localidad, clientes.CP, clientes.provincia, clientes.domicilio, clientes.id
		FROM clientes;
-- y todas son principales:
UPDATE `clientes_sedes` SET `es_sede_principal`= '1';

-- Perfiles
INSERT INTO `usuarios_perfiles` (`nombre`) VALUES ('Director Técnico');
INSERT INTO `usuarios_perfiles` (`nombre`) VALUES ('Director Comercial');

-- departamentos
CREATE TABLE IF NOT EXISTS `usuarios_departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `usuarios_departamentos` (`nombre`) VALUES
('Comercial'),
('Técnico'),
('Gestión'),
('Administración');

-- departamentos
ALTER TABLE `usuarios_perfiles` ADD `es_director_departamento` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `usuarios_perfiles` ADD `fk_departamento` INT( 11 ) NOT NULL ;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '2' WHERE `usuarios_perfiles`.`id` =3;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '2' WHERE `usuarios_perfiles`.`id` =6;
UPDATE `usuarios_perfiles` SET `es_director_departamento` = '1' WHERE `usuarios_perfiles`.`id` =6;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '1' WHERE `usuarios_perfiles`.`id` =1;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '1' WHERE `usuarios_perfiles`.`id` =2;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '1' WHERE `usuarios_perfiles`.`id` =7;
UPDATE `usuarios_perfiles` SET `es_director_departamento` = '1' WHERE `usuarios_perfiles`.`id` =7;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '3' WHERE `usuarios_perfiles`.`id` =4;
UPDATE `usuarios_perfiles` SET `fk_departamento` = '4' WHERE `usuarios_perfiles`.`id` =5;

-- objetivos mensuales
DROP TABLE `usuarios_objetivos` ;
CREATE TABLE IF NOT EXISTS `usuarios_objetivos_mensuales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `usuarios_objetivos_mensuales` (`mes`) VALUES
('Enero'),
('Febrero'),
('Marzo'),
('Abril'),
('Mayo'),
('Junio'),
('Julio'),
('Agosto'),
('Septiembre'),
('Octubre'),
('Noviembre'),
('Diciembre');

-- Comisiones
CREATE TABLE IF NOT EXISTS `usuarios_rel_tipos_comision` (
  `fk_usuario` varchar(15) NOT NULL,
  `fk_tipo_comision` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_tipo_comision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuarios_rel_objetivos_mensuales` (
  `fk_usuario` varchar(15) NOT NULL,
  `fk_objetivo` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_objetivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuarios_departamentos_rel_objetivos_mensuales` (
  `fk_departamento` int(11) NOT NULL,
  `fk_objetivo` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_objetivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- penalizaciones
CREATE TABLE IF NOT EXISTS `usuarios_penalizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `usuarios_penalizaciones` (`nombre`) VALUES
('Menos del 50%'),
('51%-75%'),
('76%-100%'),
('101%-120%'),
('121%-150%'),
('Más del 150%');

CREATE TABLE IF NOT EXISTS `usuarios_rel_penalizaciones` (
  `fk_usuario`varchar(15) NOT NULL,
  `fk_penalizacion` int(10) NOT NULL,
  `penalizacion` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_penalizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuarios_departamentos_rel_penalizaciones` (
  `fk_departamento` int(11) NOT NULL,
  `fk_penalizacion` int(10) NOT NULL,
  `penalizacion` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_penalizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuarios_departamentos_rel_tipos_comision` (
  `fk_departamento` int(11) NOT NULL,
  `fk_tipo_comision` int(11) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_tipo_comision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- tipos de venta
DELETE FROM `tipos_comision`;

INSERT INTO `tipos_comision` (`nombre`) VALUES
('Consultoría objetivable'),
('Consultoría NO objetivable'),
('Formación objetivable'),
('Formació NO objetivable'),
('LOPD'),
('Otras');

-- Cliente principal: Empresa dueña de la aplicación, es el ¿Quién soy?
ALTER TABLE `clientes` ADD `cliente_principal` TINYINT( 1 ) NOT NULL DEFAULT '0';


-- Proyectos
CREATE TABLE IF NOT EXISTS `proyectos_estados` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `proyectos_estados` (`nombre`) VALUES
('Pendiente de definición'),
('Pendiente de asignación'),
('Pendiente de planificación'),
('En curso'),
('Fuera de plazo'),
('Cerrado');

CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `fk_venta` int(11) DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_estado` int(3) NOT NULL,
  `horas_documentacion` float DEFAULT NULL,
  `horas_auditoria_interna` float DEFAULT NULL,
  `fecha_inicio` int(11) DEFAULT NULL,
  `fecha_fin` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fk_usuario` varchar(15) DEFAULT NULL,
  `es_plantilla` tinyint(1) NOT NULL DEFAULT '0',
  `importe` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `proyectos_rel_sedes` (
  `fk_proyecto` int(11) NOT NULL,
  `fk_sede` int(11) NOT NULL,
  `horas_desplazamiento` float NOT NULL,
  `numero_visitas` int(11) NOT NULL,
  `horas_cada_visita` float NOT NULL,
  `gastos_incurridos` float NOT NULL,
  PRIMARY KEY (`fk_proyecto`,`fk_sede`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- tareas técnicas
CREATE TABLE IF NOT EXISTS `tareas_tecnicas_tipos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `tareas_tecnicas_tipos` (`nombre`) VALUES
('Visita'),
('Horas documentación');

CREATE TABLE IF NOT EXISTS `tareas_tecnicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_proyecto` int(11) NOT NULL,
  `fk_sede` int(11) NOT NULL,
  `fk_tipo` int(3) NOT NULL,
  `fecha` int(11) NOT NULL,
  `horas_desplazamiento` float DEFAULT NULL,
  `horas_visita` float DEFAULT NULL,
  `horas_despacho` float DEFAULT NULL,
  `horas_auditoria_interna` float DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fk_usuario` int(11) DEFAULT NULL,
  `incentivable` tinyint(1) NOT NULL DEFAULT '0',
  `importe` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- Flag para indicar si el proyecto se puede cerrar
ALTER TABLE `proyectos` ADD `cerrar` TINYINT( 1 ) NOT NULL DEFAULT '1';


-- Planificación
CREATE TABLE IF NOT EXISTS `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_proyecto` int(11) NOT NULL,
  `fecha` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `fk_usuario` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO procesos (nombre, descripcion) VALUES
('Administración','Administración de la aplicación'),
('Gestión comercial', 'Gestión comercial'),
('Gestión técnica', 'Gestión técnica');



-- permisos
DELETE FROM `permisos_usuarios_perfiles`;
INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES
(1, 1, 1, 0, 0),
(1, 2, 0, 0, 0),
(1, 3, 1, 1, 0),
(1, 4, 0, 0, 0),
(2, 1, 1, 0, 0),
(2, 2, 0, 0, 0),
(2, 3, 1, 1, 0),
(2, 4, 0, 0, 0),
(3, 1, 1, 0, 0),
(3, 2, 0, 0, 0),
(3, 3, 1, 0, 0),
(3, 4, 1, 1, 0),
(4, 1, 1, 0, 0),
(4, 2, 1, 1, 0),
(4, 3, 1, 1, 1),
(4, 4, 1, 1, 1),
(5, 1, 1, 1, 1),
(5, 2, 1, 1, 1),
(5, 3, 1, 1, 1),
(5, 4, 1, 1, 1),
(6, 1, 1, 0, 0),
(6, 2, 0, 0, 0),
(6, 3, 1, 0, 0),
(6, 4, 1, 1, 1),
(7, 1, 1, 0, 0),
(7, 2, 0, 0, 0),
(7, 3, 1, 1, 1),
(7, 4, 1, 0, 0);

-- scripts para los permisos
DELETE FROM `scripts`;


INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES
(1, '/index.php', 'inicio', '', 1),
(3, '/Autentificacion/Logout.php', 'inicio', '', 1),
(4, '/Usuarios/infoUsuario.php', 'inicio', '', 1),
(5, '/Usuarios/AtajosUsuario.php', 'inicio', '', 1),
(6, '/Clientes/searchClientes.php', 'clientes', '', 3),
(8, '/Usuario/controlTareas.php', 'inicio', '', 1),
(9, '/Clientes/addCliente.php', 'inicio', '', 3),
(10, '/Clientes/showCliente.php', 'inicio', '', 3),
(11, '/Clientes/editCliente.php', 'inicio', '', 3),
(12, '/Clientes/busquedaHistorial.php', 'inicio', '', 3),
(13, '/Clientes/editContactos.php', 'inicio', '', 3),
(14, '/Clientes/addClientes.php', 'inicio', '', 3),
(15, '/Clientes/addGestores.php', 'inicio', '', 3),
(16, '/Llamadas/incidenciasCliente.php', 'inicio', '', 3),
(17, '/Clientes/addAccion.php', 'inicio', '', 3),
(18, '/Clientes/addOferta.php', 'inicio', '', 3),
(19, '/Clientes/showOferta.php', 'inicio', '', 3),
(20, '/Clientes/showAccion.php', 'inicio', '', 3),
(21, '/Ofertas/searchOfertas.php', 'inicio', '', 3),
(22, '/Ventas/searchVentas.php', 'inicio', '', 3),
(23, '/Acciones/searchAcciones.php', 'inicio', '', 3),
(24, '/Acciones/reportsAcciones.php', 'inicio', '', 3),
(25, '/Ofertas/reportsOfertas.php', 'inicio', '', 3),
(26, '/Colaboradores/searchColaboradores.php', 'inicio', '', 3),
(27, '/Colaboradores/addColaborador.php', 'inicio', '', 3),
(28, '/Proveedores/searchProveedores.php', 'inicio', '', 3),
(29, '/Proveedores/addProveedor.php', 'inicio', '', 3),
(30, '/Administracion/gestionUsuarios.php', 'inicio', '', 2),
(31, '/Administracion/gestionGrupos.php', 'inicio', '', 2),
(32, '/Administracion/gestionTiposProducto.php', 'inicio', '', 2),
(33, '/Administracion/gestionTiposAccion.php', 'inicio', '', 2),
(34, '/Administracion/gestionTiposFormasDePago.php', 'inicio', '', 2),
(35, '/Administracion/gestionTiposComision.php', 'inicio', '', 2),
(36, '/Facturas/searchFacturas.php', 'inicio', '', 3),
(37, '/Colaboradores/editColaborador.php', 'inicio', '', 3),
(38, '/Ofertas/addOferta.php', 'inicio', '', 3),
(39, '/Ofertas/showOferta.php', 'inicio', '', 3),
(40, '/Ventas/addVenta.php', 'inicio', '', 3),
(41, '/Ventas/showVenta.php', 'inicio', '', 3),
(42, '/Ofertas/editOferta.php', 'inicio', '', 3),
(43, '/Clientes/exportAll.php', 'inicio', '', 3),
(44, '/Facturas/addFactura.php', 'inicio', '', 3),
(45, '/Facturas/showFactura.php', 'inicio', '', 3),
(46, '/Facturas/editFactura.php', 'inicio', '', 3),
(47, '/Facturas/imprimirFacturaPDF.php', 'inicio', '', 3),
(48, '/Proyectos/searchProyectos.php', 'inicio', '', 4),
(49, '/Administracion/miEmpresa.php', 'inicio', '', 2),
(50, '/Proyectos/showProyecto.php', 'inicio', '', 4),
(51, '/Proyectos/editProyecto.php', 'inicio', '', 4),
(52, '/Tareas/addTarea.php', 'inicio', '', 4),
(53, '/Proyectos/definirProyecto.php', 'inicio', '', 4),
(54, '/Proyectos/addProyecto.php', 'inicio', '', 4),
(55, '/Acciones/addAccion.php', 'inicio', '', 3),
(56, '/Ventas/reportsVentas.php', 'inicio', '', 3),
(57, '/Administracion/editUsuario.php', 'inicio', '', 2),
(58, '/Planificacion/', 'inicio', '', 4),
(59, '/Planificacion/index.php', 'inicio', '', 4),
(60, '/Clientes/rel_Sedes_Contactos.php', 'inicio', '', 3),
(61, '/Proveedores/editProveedor.php', 'inicio', '', 3),
(62, '/Proveedores/editContactos.php', 'inicio', '', 3),
(63, '/Proveedores/showProveedor.php', 'inicio', '', 3);

ALTER TABLE `ventas` CHANGE `fecha_asignacion_tecnico` `fecha_asignacion_tecnico` INT( 11 ) NULL DEFAULT NULL ;