-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.3


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema agesene
--

CREATE DATABASE IF NOT EXISTS agesene;
USE agesene;

--
-- Definition of table `agesene`.`acciones_de_trabajo`
--

DROP TABLE IF EXISTS `agesene`.`acciones_de_trabajo`;
CREATE TABLE  `agesene`.`acciones_de_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_tipo_accion` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha` int(11) DEFAULT NULL,
  `fecha_siguiente_accion` int(11) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`acciones_de_trabajo`
--

/*!40000 ALTER TABLE `acciones_de_trabajo` DISABLE KEYS */;
LOCK TABLES `acciones_de_trabajo` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `acciones_de_trabajo` ENABLE KEYS */;


--
-- Definition of table `agesene`.`acciones_tipos`
--

DROP TABLE IF EXISTS `agesene`.`acciones_tipos`;
CREATE TABLE  `agesene`.`acciones_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`acciones_tipos`
--

/*!40000 ALTER TABLE `acciones_tipos` DISABLE KEYS */;
LOCK TABLES `acciones_tipos` WRITE;
INSERT INTO `agesene`.`acciones_tipos` VALUES  (1,'Prospección'),
 (2,'Visita'),
 (3,'Llamada de contacto'),
 (4,'Llamada de seguimiento'),
 (5,'Entrega oferta'),
 (6,'FALLIDA');
UNLOCK TABLES;
/*!40000 ALTER TABLE `acciones_tipos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`alumnos`
--

DROP TABLE IF EXISTS `agesene`.`alumnos`;
CREATE TABLE  `agesene`.`alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`alumnos`
--

/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
LOCK TABLES `alumnos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`atajos`
--

DROP TABLE IF EXISTS `agesene`.`atajos`;
CREATE TABLE  `agesene`.`atajos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `agesene`.`atajos`
--

/*!40000 ALTER TABLE `atajos` DISABLE KEYS */;
LOCK TABLES `atajos` WRITE;
INSERT INTO `agesene`.`atajos` VALUES  (1,'Atajos','Editar atajos','/Usuarios/AtajosUsuario.php');
UNLOCK TABLES;
/*!40000 ALTER TABLE `atajos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`clientes`
--

DROP TABLE IF EXISTS `agesene`.`clientes`;
CREATE TABLE  `agesene`.`clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(400) NOT NULL,
  `fk_tipo_cliente` int(11) NOT NULL,
  `NIF` varchar(9) DEFAULT NULL,
  `domicilio` varchar(400) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `numero_empleados` int(11) DEFAULT NULL,
  `web` varchar(450) DEFAULT NULL,
  `sector` varchar(450) DEFAULT NULL,
  `SPA_actual` varchar(450) DEFAULT NULL,
  `fecha_renovacion` int(11) DEFAULT NULL,
  `norma_implantada` varchar(45) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `fk_grupo_empresas` int(11) DEFAULT '1',
  `provincia` varchar(15) NOT NULL,
  `FAX` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`clientes`
--

/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
LOCK TABLES `clientes` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;


--
-- Definition of table `agesene`.`clientes_rel_contactos`
--

DROP TABLE IF EXISTS `agesene`.`clientes_rel_contactos`;
CREATE TABLE  `agesene`.`clientes_rel_contactos` (
  `fk_cliente` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_cliente`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`clientes_rel_contactos`
--

/*!40000 ALTER TABLE `clientes_rel_contactos` DISABLE KEYS */;
LOCK TABLES `clientes_rel_contactos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `clientes_rel_contactos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`clientes_rel_usuarios`
--

DROP TABLE IF EXISTS `agesene`.`clientes_rel_usuarios`;
CREATE TABLE  `agesene`.`clientes_rel_usuarios` (
  `fk_cliente` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `ha_insertado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_cliente`,`fk_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`clientes_rel_usuarios`
--

/*!40000 ALTER TABLE `clientes_rel_usuarios` DISABLE KEYS */;
LOCK TABLES `clientes_rel_usuarios` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `clientes_rel_usuarios` ENABLE KEYS */;


--
-- Definition of table `agesene`.`clientes_tipos`
--

DROP TABLE IF EXISTS `agesene`.`clientes_tipos`;
CREATE TABLE  `agesene`.`clientes_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`clientes_tipos`
--

/*!40000 ALTER TABLE `clientes_tipos` DISABLE KEYS */;
LOCK TABLES `clientes_tipos` WRITE;
INSERT INTO `agesene`.`clientes_tipos` VALUES  (1,'Potencial'),
 (2,'Cliente');
UNLOCK TABLES;
/*!40000 ALTER TABLE `clientes_tipos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`colaboradores`
--

DROP TABLE IF EXISTS `agesene`.`colaboradores`;
CREATE TABLE  `agesene`.`colaboradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) DEFAULT NULL,
  `NIF` varchar(9) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `cc_pago_comisiones` varchar(45) DEFAULT NULL,
  `comision` int(11) DEFAULT NULL,
  `comision_por_renovacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`colaboradores`
--

/*!40000 ALTER TABLE `colaboradores` DISABLE KEYS */;
LOCK TABLES `colaboradores` WRITE;
INSERT INTO `agesene`.`colaboradores` VALUES  (1,'Ninguno','','','','',0,0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `colaboradores` ENABLE KEYS */;


--
-- Definition of table `agesene`.`colaboradores_rel_contactos`
--

DROP TABLE IF EXISTS `agesene`.`colaboradores_rel_contactos`;
CREATE TABLE  `agesene`.`colaboradores_rel_contactos` (
  `fk_colaborador` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_colaborador`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`colaboradores_rel_contactos`
--

/*!40000 ALTER TABLE `colaboradores_rel_contactos` DISABLE KEYS */;
LOCK TABLES `colaboradores_rel_contactos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `colaboradores_rel_contactos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`contactos`
--

DROP TABLE IF EXISTS `agesene`.`contactos`;
CREATE TABLE  `agesene`.`contactos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `fax` int(11) DEFAULT NULL,
  `movil` int(11) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `cargo` varchar(450) DEFAULT NULL,
  `comision` int(11) DEFAULT NULL,
  `comision_por_renovacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`contactos`
--

/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
LOCK TABLES `contactos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`facturas`
--

DROP TABLE IF EXISTS `agesene`.`facturas`;
CREATE TABLE  `agesene`.`facturas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_facturacion` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_venta` int(11) NOT NULL,
  `fk_estado_factura` int(11) NOT NULL,
  `base_imponible` float NOT NULL,
  `IVA` int(11) NOT NULL,
  `fecha_pago` int(11) NOT NULL,
  `cantidad_pagada` int(11) NOT NULL,
  `numero` int(10) unsigned NOT NULL,
  `year` int(10) unsigned NOT NULL,
  `numero_factura` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`facturas`
--

/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
LOCK TABLES `facturas` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;


--
-- Definition of table `agesene`.`facturas_estados`
--

DROP TABLE IF EXISTS `agesene`.`facturas_estados`;
CREATE TABLE  `agesene`.`facturas_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`facturas_estados`
--

/*!40000 ALTER TABLE `facturas_estados` DISABLE KEYS */;
LOCK TABLES `facturas_estados` WRITE;
INSERT INTO `agesene`.`facturas_estados` VALUES  (1,'Anulado'),
 (2,'Pagado'),
 (3,'Pendiente');
UNLOCK TABLES;
/*!40000 ALTER TABLE `facturas_estados` ENABLE KEYS */;


--
-- Definition of table `agesene`.`formas_de_pago`
--

DROP TABLE IF EXISTS `agesene`.`formas_de_pago`;
CREATE TABLE  `agesene`.`formas_de_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`formas_de_pago`
--

/*!40000 ALTER TABLE `formas_de_pago` DISABLE KEYS */;
LOCK TABLES `formas_de_pago` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `formas_de_pago` ENABLE KEYS */;


--
-- Definition of table `agesene`.`grupos_empresas`
--

DROP TABLE IF EXISTS `agesene`.`grupos_empresas`;
CREATE TABLE  `agesene`.`grupos_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`grupos_empresas`
--

/*!40000 ALTER TABLE `grupos_empresas` DISABLE KEYS */;
LOCK TABLES `grupos_empresas` WRITE;
INSERT INTO `agesene`.`grupos_empresas` VALUES  (1,'Ninguno');
UNLOCK TABLES;
/*!40000 ALTER TABLE `grupos_empresas` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ofertas`
--

DROP TABLE IF EXISTS `agesene`.`ofertas`;
CREATE TABLE  `agesene`.`ofertas` (
  `codigo` varchar(10) DEFAULT NULL,
  `nombre_oferta` varchar(450) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fk_estado_oferta` int(11) DEFAULT NULL,
  `fk_tipo_producto` int(11) DEFAULT NULL,
  `fk_proveedor` varchar(45) DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_colaborador` int(11) DEFAULT NULL,
  `fecha` int(11) NOT NULL,
  `importe` float DEFAULT NULL,
  `probabilidad_contratacion` int(11) DEFAULT NULL,
  `fecha_definicion` int(11) DEFAULT NULL,
  `es_oportunidad_de_negocio` tinyint(1) DEFAULT '0',
  `aceptado` tinyint(1) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ofertas`
--

/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
LOCK TABLES `ofertas` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ofertas_codigos_patch`
--

DROP TABLE IF EXISTS `agesene`.`ofertas_codigos_patch`;
CREATE TABLE  `agesene`.`ofertas_codigos_patch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `de_oportunidad` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ofertas_codigos_patch`
--

/*!40000 ALTER TABLE `ofertas_codigos_patch` DISABLE KEYS */;
LOCK TABLES `ofertas_codigos_patch` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ofertas_codigos_patch` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ofertas_estados`
--

DROP TABLE IF EXISTS `agesene`.`ofertas_estados`;
CREATE TABLE  `agesene`.`ofertas_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ofertas_estados`
--

/*!40000 ALTER TABLE `ofertas_estados` DISABLE KEYS */;
LOCK TABLES `ofertas_estados` WRITE;
INSERT INTO `agesene`.`ofertas_estados` VALUES  (1,'Pendiente'),
 (2,'Aceptado'),
 (3,'Anulado'),
 (4,'Rechazada');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ofertas_estados` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ofertas_probabilidades`
--

DROP TABLE IF EXISTS `agesene`.`ofertas_probabilidades`;
CREATE TABLE  `agesene`.`ofertas_probabilidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ofertas_probabilidades`
--

/*!40000 ALTER TABLE `ofertas_probabilidades` DISABLE KEYS */;
LOCK TABLES `ofertas_probabilidades` WRITE;
INSERT INTO `agesene`.`ofertas_probabilidades` VALUES  (1,'baja'),
 (2,'media'),
 (3,'alta');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ofertas_probabilidades` ENABLE KEYS */;


--
-- Definition of table `agesene`.`permisos_usuarios_perfiles`
--

DROP TABLE IF EXISTS `agesene`.`permisos_usuarios_perfiles`;
CREATE TABLE  `agesene`.`permisos_usuarios_perfiles` (
  `fk_perfil` int(11) NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  `lectura` tinyint(1) NOT NULL DEFAULT '0',
  `escritura` tinyint(1) NOT NULL DEFAULT '0',
  `administracion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_perfil`,`fk_proceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`permisos_usuarios_perfiles`
--

/*!40000 ALTER TABLE `permisos_usuarios_perfiles` DISABLE KEYS */;
LOCK TABLES `permisos_usuarios_perfiles` WRITE;
INSERT INTO `agesene`.`permisos_usuarios_perfiles` VALUES  (1,1,1,0,0),
 (2,1,1,0,0),
 (3,1,1,0,0),
 (4,1,1,0,0),
 (5,1,1,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `permisos_usuarios_perfiles` ENABLE KEYS */;


--
-- Definition of table `agesene`.`plazos_estados`
--

DROP TABLE IF EXISTS `agesene`.`plazos_estados`;
CREATE TABLE  `agesene`.`plazos_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`plazos_estados`
--

/*!40000 ALTER TABLE `plazos_estados` DISABLE KEYS */;
LOCK TABLES `plazos_estados` WRITE;
INSERT INTO `agesene`.`plazos_estados` VALUES  (1,'Pendiente'),
 (2,'Aceptado');
UNLOCK TABLES;
/*!40000 ALTER TABLE `plazos_estados` ENABLE KEYS */;


--
-- Definition of table `agesene`.`procesos`
--

DROP TABLE IF EXISTS `agesene`.`procesos`;
CREATE TABLE  `agesene`.`procesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(170) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`procesos`
--

/*!40000 ALTER TABLE `procesos` DISABLE KEYS */;
LOCK TABLES `procesos` WRITE;
INSERT INTO `agesene`.`procesos` VALUES  (1,'Proceso genérico','Proceso por defecto');
UNLOCK TABLES;
/*!40000 ALTER TABLE `procesos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`productos`
--

DROP TABLE IF EXISTS `agesene`.`productos`;
CREATE TABLE  `agesene`.`productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_tipo_producto` int(11) NOT NULL,
  `denominacion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`productos`
--

/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
LOCK TABLES `productos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`productos_tipos`
--

DROP TABLE IF EXISTS `agesene`.`productos_tipos`;
CREATE TABLE  `agesene`.`productos_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`productos_tipos`
--

/*!40000 ALTER TABLE `productos_tipos` DISABLE KEYS */;
LOCK TABLES `productos_tipos` WRITE;
INSERT INTO `agesene`.`productos_tipos` VALUES  (1,'Formación'),
 (2,'SPA'),
 (3,'LOPD'),
 (4,'Servicios puntuales'),
 (5,'Vigilancia Salud');
UNLOCK TABLES;
/*!40000 ALTER TABLE `productos_tipos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`proveedores`
--

DROP TABLE IF EXISTS `agesene`.`proveedores`;
CREATE TABLE  `agesene`.`proveedores` (
  `NIF` varchar(9) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `web` varchar(450) DEFAULT NULL,
  `provincia` varchar(450) DEFAULT NULL,
  `domicilio` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`NIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`proveedores`
--

/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
LOCK TABLES `proveedores` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;


--
-- Definition of table `agesene`.`proveedores_rel_contactos`
--

DROP TABLE IF EXISTS `agesene`.`proveedores_rel_contactos`;
CREATE TABLE  `agesene`.`proveedores_rel_contactos` (
  `fk_proveedor` varchar(45) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_proveedor`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`proveedores_rel_contactos`
--

/*!40000 ALTER TABLE `proveedores_rel_contactos` DISABLE KEYS */;
LOCK TABLES `proveedores_rel_contactos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `proveedores_rel_contactos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`scripts`
--

DROP TABLE IF EXISTS `agesene`.`scripts`;
CREATE TABLE  `agesene`.`scripts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `menu` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'inicio',
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ruta` (`ruta`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `agesene`.`scripts`
--

/*!40000 ALTER TABLE `scripts` DISABLE KEYS */;
LOCK TABLES `scripts` WRITE;
INSERT INTO `agesene`.`scripts` VALUES  (1,'/index.php','inicio','',1),
 (3,'/Autentificacion/Logout.php','inicio','',1),
 (4,'/Usuarios/infoUsuario.php','inicio','',1),
 (5,'/Usuarios/AtajosUsuario.php','inicio','',1),
 (6,'/Clientes/searchClientes.php','clientes','',1),
 (8,'/Usuario/controlTareas.php','inicio','',1),
 (9,'/Clientes/addCliente.php','inicio','',1),
 (10,'/Clientes/showCliente.php','inicio','',1),
 (11,'/Clientes/editCliente.php','inicio','',1),
 (12,'/Clientes/busquedaHistorial.php','inicio','',1),
 (13,'/Clientes/editContactos.php','inicio','',1),
 (14,'/Clientes/addClientes.php','inicio','',1),
 (15,'/Clientes/addGestores.php','inicio','',1),
 (16,'/Llamadas/incidenciasCliente.php','inicio','',1),
 (17,'/Clientes/addAccion.php','inicio','',1),
 (18,'/Clientes/addOferta.php','inicio','',1),
 (19,'/Clientes/showOferta.php','inicio','',1),
 (20,'/Clientes/showAccion.php','inicio','',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `scripts` ENABLE KEYS */;


--
-- Definition of table `agesene`.`tipos_comision`
--

DROP TABLE IF EXISTS `agesene`.`tipos_comision`;
CREATE TABLE  `agesene`.`tipos_comision` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agesene`.`tipos_comision`
--

/*!40000 ALTER TABLE `tipos_comision` DISABLE KEYS */;
LOCK TABLES `tipos_comision` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipos_comision` ENABLE KEYS */;


--
-- Definition of table `agesene`.`usuarios`
--

DROP TABLE IF EXISTS `agesene`.`usuarios`;
CREATE TABLE  `agesene`.`usuarios` (
  `id` varchar(15) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `password` varchar(450) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `fk_perfil` int(11) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
LOCK TABLES `usuarios` WRITE;
INSERT INTO `agesene`.`usuarios` VALUES  ('admin','admin','admin','admin',5,'admin');
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;


--
-- Definition of table `agesene`.`usuarios_objetivos`
--

DROP TABLE IF EXISTS `agesene`.`usuarios_objetivos`;
CREATE TABLE  `agesene`.`usuarios_objetivos` (
  `fk_usuario` varchar(15) NOT NULL,
  `mes` int(11) NOT NULL,
  `objetivo` varchar(45) NOT NULL,
  PRIMARY KEY (`fk_usuario`,`mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`usuarios_objetivos`
--

/*!40000 ALTER TABLE `usuarios_objetivos` DISABLE KEYS */;
LOCK TABLES `usuarios_objetivos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_objetivos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`usuarios_perfiles`
--

DROP TABLE IF EXISTS `agesene`.`usuarios_perfiles`;
CREATE TABLE  `agesene`.`usuarios_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`usuarios_perfiles`
--

/*!40000 ALTER TABLE `usuarios_perfiles` DISABLE KEYS */;
LOCK TABLES `usuarios_perfiles` WRITE;
INSERT INTO `agesene`.`usuarios_perfiles` VALUES  (1,'Comercial'),
 (2,'Televendedor'),
 (3,'Técnico'),
 (4,'Gerente'),
 (5,'Administrador');
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_perfiles` ENABLE KEYS */;


--
-- Definition of table `agesene`.`usuarios_rel_atajos`
--

DROP TABLE IF EXISTS `agesene`.`usuarios_rel_atajos`;
CREATE TABLE  `agesene`.`usuarios_rel_atajos` (
  `fk_usuario` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fk_atajo` int(5) NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_atajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `agesene`.`usuarios_rel_atajos`
--

/*!40000 ALTER TABLE `usuarios_rel_atajos` DISABLE KEYS */;
LOCK TABLES `usuarios_rel_atajos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_rel_atajos` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ventas`
--

DROP TABLE IF EXISTS `agesene`.`ventas`;
CREATE TABLE  `agesene`.`ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_oferta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_aceptado` int(11) DEFAULT NULL,
  `fecha_asignacion_tecnico` int(11) NOT NULL,
  `formacion_bonificada` tinyint(1) DEFAULT NULL,
  `fecha_entrada_vigor` int(11) DEFAULT NULL,
  `fk_forma_pago` int(11) NOT NULL,
  `fk_tipo_comision` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ventas`
--

/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
LOCK TABLES `ventas` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;


--
-- Definition of table `agesene`.`ventas_plazos`
--

DROP TABLE IF EXISTS `agesene`.`ventas_plazos`;
CREATE TABLE  `agesene`.`ventas_plazos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` int(11) NOT NULL,
  `fk_venta` int(11) NOT NULL,
  `fk_estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agesene`.`ventas_plazos`
--

/*!40000 ALTER TABLE `ventas_plazos` DISABLE KEYS */;
LOCK TABLES `ventas_plazos` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ventas_plazos` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
