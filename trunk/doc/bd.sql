-- MySQL dump 10.13  Distrib 5.1.63, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: agesene
-- ------------------------------------------------------
-- Server version	5.1.63-0ubuntu0.11.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acciones_de_trabajo`
--

DROP TABLE IF EXISTS `acciones_de_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acciones_de_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_tipo_accion` int(11) NOT NULL,
  `nombre_tipo_accion` varchar(45) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `razon_social_cliente` varchar(400) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha` int(11) DEFAULT NULL,
  `fecha_siguiente_accion` int(11) DEFAULT NULL,
  `descripcion` text,
  `leida` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_tipo_accion` (`fk_tipo_accion`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_usuario` (`fk_usuario`),
  CONSTRAINT `acciones_de_trabajo_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `acciones_de_trabajo_tipo_accion` FOREIGN KEY (`fk_tipo_accion`) REFERENCES `acciones_tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `acciones_de_trabajo_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acciones_de_trabajo`
--

LOCK TABLES `acciones_de_trabajo` WRITE;
/*!40000 ALTER TABLE `acciones_de_trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `acciones_de_trabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acciones_tipos`
--

DROP TABLE IF EXISTS `acciones_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acciones_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acciones_tipos`
--

LOCK TABLES `acciones_tipos` WRITE;
/*!40000 ALTER TABLE `acciones_tipos` DISABLE KEYS */;
INSERT INTO `acciones_tipos` VALUES (1,'Prospección'),(2,'Visita'),(3,'Llamada de contacto'),(4,'Llamada de seguimiento'),(5,'Entrega oferta'),(6,'FALLIDA');
/*!40000 ALTER TABLE `acciones_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(400) NOT NULL,
  `fk_tipo_cliente` int(11) NOT NULL,
  `nombre_tipo_cliente` varchar(45) NOT NULL,
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
  `nombre_grupo_empresas` varchar(45) NOT NULL,
  `provincia` varchar(15) NOT NULL,
  `FAX` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `observaciones` longtext,
  `actividad` longtext,
  `cliente_principal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_tipo_cliente` (`fk_tipo_cliente`),
  CONSTRAINT `clientes_tipo_cliente` FOREIGN KEY (`fk_tipo_cliente`) REFERENCES `clientes_tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_rel_contactos`
--

DROP TABLE IF EXISTS `clientes_rel_contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_rel_contactos` (
  `fk_cliente` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_cliente`,`fk_contacto`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_contacto` (`fk_contacto`),
  CONSTRAINT `clientes_rel_contactos_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clientes_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_rel_contactos`
--

LOCK TABLES `clientes_rel_contactos` WRITE;
/*!40000 ALTER TABLE `clientes_rel_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_rel_contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_rel_usuarios`
--

DROP TABLE IF EXISTS `clientes_rel_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_rel_usuarios` (
  `fk_cliente` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `ha_insertado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_cliente`,`fk_usuario`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_usuario` (`fk_usuario`),
  CONSTRAINT `clientes_rel_usuarios_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clientes_rel_usuarios_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_rel_usuarios`
--

LOCK TABLES `clientes_rel_usuarios` WRITE;
/*!40000 ALTER TABLE `clientes_rel_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_rel_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_sedes`
--

DROP TABLE IF EXISTS `clientes_sedes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_sedes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `localidad` varchar(45) NOT NULL,
  `CP` int(11) DEFAULT NULL,
  `provincia` varchar(15) DEFAULT NULL,
  `direccion` varchar(400) DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL,
  `es_sede_principal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente` (`fk_cliente`),
  CONSTRAINT `clientes_sedes_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_sedes`
--

LOCK TABLES `clientes_sedes` WRITE;
/*!40000 ALTER TABLE `clientes_sedes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_sedes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_sedes_rel_contactos`
--

DROP TABLE IF EXISTS `clientes_sedes_rel_contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_sedes_rel_contactos` (
  `fk_clientes_sede` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_clientes_sede`,`fk_contacto`),
  KEY `fk_clientes_sede` (`fk_clientes_sede`),
  KEY `fk_contacto` (`fk_contacto`),
  CONSTRAINT `clientes_sedes_rel_contactos_cliente` FOREIGN KEY (`fk_clientes_sede`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clientes_sedes_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_sedes_rel_contactos`
--

LOCK TABLES `clientes_sedes_rel_contactos` WRITE;
/*!40000 ALTER TABLE `clientes_sedes_rel_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_sedes_rel_contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_tipos`
--

DROP TABLE IF EXISTS `clientes_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_tipos`
--

LOCK TABLES `clientes_tipos` WRITE;
/*!40000 ALTER TABLE `clientes_tipos` DISABLE KEYS */;
INSERT INTO `clientes_tipos` VALUES (1,'Potencial'),(2,'Cliente');
/*!40000 ALTER TABLE `clientes_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaboradores`
--

DROP TABLE IF EXISTS `colaboradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colaboradores` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaboradores`
--

LOCK TABLES `colaboradores` WRITE;
/*!40000 ALTER TABLE `colaboradores` DISABLE KEYS */;
INSERT INTO `colaboradores` VALUES (1,'Ninguno','','','','',0,'0',0,0);
/*!40000 ALTER TABLE `colaboradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaboradores_rel_contactos`
--

DROP TABLE IF EXISTS `colaboradores_rel_contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colaboradores_rel_contactos` (
  `fk_colaborador` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_colaborador`,`fk_contacto`),
  KEY `fk_colaborador` (`fk_colaborador`),
  KEY `fk_contacto` (`fk_contacto`),
  CONSTRAINT `colaboradores_rel_contactos_colaborador` FOREIGN KEY (`fk_colaborador`) REFERENCES `colaboradores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `colaboradores_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaboradores_rel_contactos`
--

LOCK TABLES `colaboradores_rel_contactos` WRITE;
/*!40000 ALTER TABLE `colaboradores_rel_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `colaboradores_rel_contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facturas` (
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
  PRIMARY KEY (`id`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_venta` (`fk_venta`),
  KEY `fk_estado_factura` (`fk_estado_factura`),
  CONSTRAINT `facturas_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `facturas_venta` FOREIGN KEY (`fk_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `facturas_estado_factura` FOREIGN KEY (`fk_estado_factura`) REFERENCES `facturas_estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas_estados`
--

DROP TABLE IF EXISTS `facturas_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facturas_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas_estados`
--

LOCK TABLES `facturas_estados` WRITE;
/*!40000 ALTER TABLE `facturas_estados` DISABLE KEYS */;
INSERT INTO `facturas_estados` VALUES (1,'Anulado'),(2,'Pagado'),(3,'Pendiente');
/*!40000 ALTER TABLE `facturas_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formas_de_pago`
--

DROP TABLE IF EXISTS `formas_de_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formas_de_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formas_de_pago`
--

LOCK TABLES `formas_de_pago` WRITE;
/*!40000 ALTER TABLE `formas_de_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `formas_de_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_empresas`
--

DROP TABLE IF EXISTS `grupos_empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_empresas`
--

LOCK TABLES `grupos_empresas` WRITE;
/*!40000 ALTER TABLE `grupos_empresas` DISABLE KEYS */;
INSERT INTO `grupos_empresas` VALUES (1,'Ninguno');
/*!40000 ALTER TABLE `grupos_empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `codigo` varchar(10) DEFAULT NULL,
  `nombre_oferta` varchar(450) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fk_estado_oferta` int(11) DEFAULT NULL,
  `nombre_estado_oferta` varchar(45) NOT NULL,
  `fk_tipo_producto` int(11) DEFAULT NULL,
  `nombre_tipo_producto` varchar(45) NOT NULL,
  `fk_proveedor` int(11) DEFAULT NULL,
  `razon_social_proveedor` varchar(100) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `razon_social_cliente` varchar(400) NOT NULL,
  `fk_colaborador` int(11) DEFAULT NULL,
  `razon_social_colaborador` varchar(100) NOT NULL,
  `fecha` int(11) NOT NULL,
  `importe` float DEFAULT NULL,
  `probabilidad_contratacion` int(11) DEFAULT NULL,
  `nombre_probabilidad` varchar(45) NOT NULL,
  `fecha_definicion` int(11) DEFAULT NULL,
  `es_oportunidad_de_negocio` tinyint(1) DEFAULT '0',
  `aceptado` tinyint(1) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leida` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_estado_oferta` (`fk_estado_oferta`),
  KEY `fk_tipo_producto` (`fk_tipo_producto`),
  KEY `fk_proveedor` (`fk_proveedor`),
  KEY `fk_colaborador` (`fk_colaborador`),
  CONSTRAINT `ofertas_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertas_colaborador` FOREIGN KEY (`fk_colaborador`) REFERENCES `colaboradores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertas_estado_oferta` FOREIGN KEY (`fk_estado_oferta`) REFERENCES `ofertas_estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertas_proveedor` FOREIGN KEY (`fk_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertas_tipo_producto` FOREIGN KEY (`fk_tipo_producto`) REFERENCES `productos_tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas_codigos_patch`
--

DROP TABLE IF EXISTS `ofertas_codigos_patch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas_codigos_patch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `de_oportunidad` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas_codigos_patch`
--

LOCK TABLES `ofertas_codigos_patch` WRITE;
/*!40000 ALTER TABLE `ofertas_codigos_patch` DISABLE KEYS */;
/*!40000 ALTER TABLE `ofertas_codigos_patch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas_estados`
--

DROP TABLE IF EXISTS `ofertas_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas_estados`
--

LOCK TABLES `ofertas_estados` WRITE;
/*!40000 ALTER TABLE `ofertas_estados` DISABLE KEYS */;
INSERT INTO `ofertas_estados` VALUES (1,'Pendiente'),(2,'Aceptado'),(3,'Anulado'),(4,'Rechazada');
/*!40000 ALTER TABLE `ofertas_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas_probabilidades`
--

DROP TABLE IF EXISTS `ofertas_probabilidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas_probabilidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas_probabilidades`
--

LOCK TABLES `ofertas_probabilidades` WRITE;
/*!40000 ALTER TABLE `ofertas_probabilidades` DISABLE KEYS */;
INSERT INTO `ofertas_probabilidades` VALUES (1,'baja'),(2,'media'),(3,'alta');
/*!40000 ALTER TABLE `ofertas_probabilidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas_ult`
--

DROP TABLE IF EXISTS `ofertas_ult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas_ult` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `st` int(1) NOT NULL,
  `dt` int(11) NOT NULL,
  `ps` text COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas_ult`
--

LOCK TABLES `ofertas_ult` WRITE;
/*!40000 ALTER TABLE `ofertas_ult` DISABLE KEYS */;
INSERT INTO `ofertas_ult` VALUES (1,0,1314655200,'8870b4ccb33733ad3ed0b9c564bdba98');
/*!40000 ALTER TABLE `ofertas_ult` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos_usuarios_perfiles`
--

DROP TABLE IF EXISTS `permisos_usuarios_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos_usuarios_perfiles` (
  `fk_perfil` int(11) NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  `lectura` tinyint(1) NOT NULL DEFAULT '0',
  `escritura` tinyint(1) NOT NULL DEFAULT '0',
  `administracion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fk_perfil`,`fk_proceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos_usuarios_perfiles`
--

LOCK TABLES `permisos_usuarios_perfiles` WRITE;
/*!40000 ALTER TABLE `permisos_usuarios_perfiles` DISABLE KEYS */;
INSERT INTO `permisos_usuarios_perfiles` VALUES (1,1,1,0,0),(1,2,0,0,0),(1,3,1,1,0),(1,4,0,0,0),(2,1,1,0,0),(2,2,0,0,0),(2,3,1,1,0),(2,4,0,0,0),(3,1,1,0,0),(3,2,0,0,0),(3,3,1,0,0),(3,4,1,1,0),(4,1,1,0,0),(4,2,1,1,0),(4,3,1,1,1),(4,4,1,1,1),(5,1,1,1,1),(5,2,1,1,1),(5,3,1,1,1),(5,4,1,1,1),(6,1,1,0,0),(6,2,0,0,0),(6,3,1,0,0),(6,4,1,1,1),(7,1,1,0,0),(7,2,0,0,0),(7,3,1,1,1),(7,4,1,0,0);
/*!40000 ALTER TABLE `permisos_usuarios_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plazos_estados`
--

DROP TABLE IF EXISTS `plazos_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plazos_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plazos_estados`
--

LOCK TABLES `plazos_estados` WRITE;
/*!40000 ALTER TABLE `plazos_estados` DISABLE KEYS */;
INSERT INTO `plazos_estados` VALUES (1,'Pendiente'),(2,'Aceptado');
/*!40000 ALTER TABLE `plazos_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procesos`
--

DROP TABLE IF EXISTS `procesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(170) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procesos`
--

LOCK TABLES `procesos` WRITE;
/*!40000 ALTER TABLE `procesos` DISABLE KEYS */;
INSERT INTO `procesos` VALUES (1,'Proceso genérico','Proceso por defecto'),(2,'AdministraciÃ³n','AdministraciÃ³n de la aplicaciÃ³n'),(3,'GestiÃ³n comercial','GestiÃ³n comercial'),(4,'GestiÃ³n tÃ©cnica','GestiÃ³n tÃ©cnica');
/*!40000 ALTER TABLE `procesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_tipo_producto` int(11) NOT NULL,
  `denominacion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_tipos`
--

DROP TABLE IF EXISTS `productos_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_tipos`
--

LOCK TABLES `productos_tipos` WRITE;
/*!40000 ALTER TABLE `productos_tipos` DISABLE KEYS */;
INSERT INTO `productos_tipos` VALUES (1,'Formación'),(2,'SPA'),(3,'LOPD'),(4,'Servicios puntuales'),(5,'Vigilancia Salud');
/*!40000 ALTER TABLE `productos_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NIF` varchar(9) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `web` varchar(450) DEFAULT NULL,
  `provincia` varchar(450) DEFAULT NULL,
  `domicilio` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'','Ninguno',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores_rel_contactos`
--

DROP TABLE IF EXISTS `proveedores_rel_contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores_rel_contactos` (
  `fk_proveedor` int(11) NOT NULL DEFAULT '0',
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_proveedor`,`fk_contacto`),
  KEY `fk_proveedor` (`fk_proveedor`),
  KEY `fk_contacto` (`fk_contacto`),
  CONSTRAINT `proveedores_rel_contactos_proveedor` FOREIGN KEY (`fk_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proveedores_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores_rel_contactos`
--

LOCK TABLES `proveedores_rel_contactos` WRITE;
/*!40000 ALTER TABLE `proveedores_rel_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedores_rel_contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) NOT NULL,
  `fk_venta` int(11) DEFAULT NULL,
  `precio_consultoria_venta` float DEFAULT NULL,
  `precio_formacion_venta` float DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL,
  `razon_social_cliente` varchar(400) NOT NULL,
  `fk_estado` int(3) NOT NULL,
  `nombre_estado` varchar(45) NOT NULL,
  `horas_documentacion` float DEFAULT NULL,
  `horas_auditoria_interna` float DEFAULT NULL,
  `horas_desplazamiento_auditoria_interna` float DEFAULT NULL,
  `horas_auditoria_externa` float DEFAULT NULL,
  `horas_desplazamiento_auditoria_externa` float DEFAULT NULL,
  `fecha_inicio` int(11) DEFAULT NULL,
  `fecha_fin` int(11) DEFAULT NULL,
  `observaciones` text,
  `fk_usuario` varchar(15) DEFAULT NULL,
  `es_plantilla` tinyint(1) NOT NULL DEFAULT '0',
  `importe` float DEFAULT '0',
  `cerrar` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_estado` (`fk_estado`),
  KEY `fk_venta` (`fk_venta`),
  CONSTRAINT `proyectos_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyectos_estado` FOREIGN KEY (`fk_estado`) REFERENCES `proyectos_estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyectos_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyectos_venta` FOREIGN KEY (`fk_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos_estados`
--

DROP TABLE IF EXISTS `proyectos_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos_estados` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos_estados`
--

LOCK TABLES `proyectos_estados` WRITE;
/*!40000 ALTER TABLE `proyectos_estados` DISABLE KEYS */;
INSERT INTO `proyectos_estados` VALUES (1,'Pendiente de definiciÃ³n'),(2,'Pendiente de asignaciÃ³n'),(3,'Pendiente de planificaciÃ³n'),(4,'En curso'),(5,'Fuera de plazo'),(6,'Cerrado');
/*!40000 ALTER TABLE `proyectos_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos_rel_sedes`
--

DROP TABLE IF EXISTS `proyectos_rel_sedes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos_rel_sedes` (
  `fk_proyecto` int(11) NOT NULL,
  `fk_sede` int(11) NOT NULL,
  `horas_desplazamiento` float DEFAULT NULL,
  `numero_visitas` int(11) DEFAULT NULL,
  `horas_cada_visita` float DEFAULT NULL,
  `gastos_incurridos` float DEFAULT NULL,
  PRIMARY KEY (`fk_proyecto`,`fk_sede`),
  KEY `fk_proyecto` (`fk_proyecto`),
  KEY `fk_sede` (`fk_sede`),
  CONSTRAINT `proyectos_rel_sedes_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyectos_rel_sedes_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos_rel_sedes`
--

LOCK TABLES `proyectos_rel_sedes` WRITE;
/*!40000 ALTER TABLE `proyectos_rel_sedes` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectos_rel_sedes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scripts`
--

DROP TABLE IF EXISTS `scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scripts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `menu` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'inicio',
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ruta` (`ruta`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scripts`
--

LOCK TABLES `scripts` WRITE;
/*!40000 ALTER TABLE `scripts` DISABLE KEYS */;
INSERT INTO `scripts` VALUES (1,'/index.php','inicio','',1),(3,'/Autentificacion/Logout.php','inicio','',1),(4,'/Usuarios/infoUsuario.php','inicio','',1),(5,'/Usuarios/AtajosUsuario.php','inicio','',1),(6,'/Clientes/searchClientes.php','clientes','',3),(8,'/Usuario/controlTareas.php','inicio','',1),(9,'/Clientes/addCliente.php','inicio','',3),(10,'/Clientes/showCliente.php','inicio','',3),(11,'/Clientes/editCliente.php','inicio','',3),(12,'/Clientes/busquedaHistorial.php','inicio','',3),(13,'/Clientes/editContactos.php','inicio','',3),(14,'/Clientes/addClientes.php','inicio','',3),(15,'/Clientes/addGestores.php','inicio','',3),(16,'/Llamadas/incidenciasCliente.php','inicio','',3),(17,'/Clientes/addAccion.php','inicio','',3),(18,'/Clientes/addOferta.php','inicio','',3),(19,'/Clientes/showOferta.php','inicio','',3),(20,'/Clientes/showAccion.php','inicio','',3),(21,'/Ofertas/searchOfertas.php','inicio','',3),(22,'/Ventas/searchVentas.php','inicio','',3),(23,'/Acciones/searchAcciones.php','inicio','',3),(24,'/Acciones/reportsAcciones.php','inicio','',3),(25,'/Ofertas/reportsOfertas.php','inicio','',3),(26,'/Colaboradores/searchColaboradores.php','inicio','',3),(27,'/Colaboradores/addColaborador.php','inicio','',3),(28,'/Proveedores/searchProveedores.php','inicio','',3),(29,'/Proveedores/addProveedor.php','inicio','',3),(30,'/Administracion/gestionUsuarios.php','inicio','',2),(31,'/Administracion/gestionGrupos.php','inicio','',2),(32,'/Administracion/gestionTiposProducto.php','inicio','',2),(33,'/Administracion/gestionTiposAccion.php','inicio','',2),(34,'/Administracion/gestionTiposFormasDePago.php','inicio','',2),(35,'/Administracion/gestionTiposComision.php','inicio','',2),(36,'/Facturas/searchFacturas.php','inicio','',3),(37,'/Colaboradores/editColaborador.php','inicio','',3),(38,'/Ofertas/addOferta.php','inicio','',3),(39,'/Ofertas/showOferta.php','inicio','',3),(40,'/Ventas/addVenta.php','inicio','',3),(41,'/Ventas/showVenta.php','inicio','',3),(42,'/Ofertas/editOferta.php','inicio','',3),(43,'/Clientes/exportAll.php','inicio','',3),(44,'/Facturas/addFactura.php','inicio','',3),(45,'/Facturas/showFactura.php','inicio','',3),(46,'/Facturas/editFactura.php','inicio','',3),(47,'/Facturas/imprimirFacturaPDF.php','inicio','',3),(48,'/Proyectos/searchProyectos.php','inicio','',4),(49,'/Administracion/miEmpresa.php','inicio','',2),(50,'/Proyectos/showProyecto.php','inicio','',4),(51,'/Proyectos/editProyecto.php','inicio','',4),(52,'/Tareas/addTarea.php','inicio','',4),(53,'/Proyectos/definirProyecto.php','inicio','',4),(54,'/Proyectos/addProyecto.php','inicio','',4),(55,'/Acciones/addAccion.php','inicio','',3),(56,'/Ventas/reportsVentas.php','inicio','',3),(57,'/Administracion/editUsuario.php','inicio','',2),(58,'/Planificacion/','inicio','',4),(59,'/Planificacion/index.php','inicio','',4),(60,'/Clientes/rel_Sedes_Contactos.php','inicio','',3),(61,'/Proveedores/editProveedor.php','inicio','',3),(62,'/Proveedores/editContactos.php','inicio','',3),(63,'/Proveedores/showProveedor.php','inicio','',3);
/*!40000 ALTER TABLE `scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas_tecnicas`
--

DROP TABLE IF EXISTS `tareas_tecnicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tareas_tecnicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_proyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(500) NOT NULL,
  `fk_sede` int(11) NOT NULL,
  `localidad_sede` varchar(45) NOT NULL,
  `fk_tipo` int(3) NOT NULL,
  `nombre_tipo` varchar(45) NOT NULL,
  `fecha` int(11) NOT NULL,
  `horas_desplazamiento` float DEFAULT NULL,
  `horas_visita` float DEFAULT NULL,
  `horas_despacho` float DEFAULT NULL,
  `horas_auditoria_interna` float DEFAULT NULL,
  `observaciones` text,
  `fk_usuario` varchar(15) DEFAULT NULL,
  `incentivable` tinyint(1) NOT NULL DEFAULT '0',
  `importe` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_proyecto` (`fk_proyecto`),
  KEY `fk_sede` (`fk_sede`),
  KEY `fk_tipo` (`fk_tipo`),
  KEY `fk_usuario` (`fk_usuario`),
  CONSTRAINT `tareas_tecnicas_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tareas_tecnicas_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tareas_tecnicas_tipo` FOREIGN KEY (`fk_tipo`) REFERENCES `tareas_tecnicas_tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tareas_tecnicas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas_tecnicas`
--

LOCK TABLES `tareas_tecnicas` WRITE;
/*!40000 ALTER TABLE `tareas_tecnicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tareas_tecnicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas_tecnicas_tipos`
--

DROP TABLE IF EXISTS `tareas_tecnicas_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tareas_tecnicas_tipos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas_tecnicas_tipos`
--

LOCK TABLES `tareas_tecnicas_tipos` WRITE;
/*!40000 ALTER TABLE `tareas_tecnicas_tipos` DISABLE KEYS */;
INSERT INTO `tareas_tecnicas_tipos` VALUES (1,'Visita de seguimiento'),(2,'Horas documentaciÃ³n'),(3,'Visita de auditorÃ­a interna'),(4,'Visita de auditorÃ­a externa');
/*!40000 ALTER TABLE `tareas_tecnicas_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `fk_list` int(11) NOT NULL,
  `fk_task` int(11) DEFAULT '0',
  `description` text COLLATE utf8_spanish_ci,
  `date` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_list` (`fk_list`),
  KEY `fk_task` (`fk_task`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`fk_list`) REFERENCES `tasks_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`fk_task`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks_lists`
--

DROP TABLE IF EXISTS `tasks_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fk_user` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_lists`
--

LOCK TABLES `tasks_lists` WRITE;
/*!40000 ALTER TABLE `tasks_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_comision`
--

DROP TABLE IF EXISTS `tipos_comision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_comision` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_comision`
--

LOCK TABLES `tipos_comision` WRITE;
/*!40000 ALTER TABLE `tipos_comision` DISABLE KEYS */;
INSERT INTO `tipos_comision` VALUES (1,'ConsultorÃ­a objetivable'),(2,'ConsultorÃ­a NO objetivable'),(3,'FormaciÃ³n objetivable'),(4,'FormaciÃ³ NO objetivable'),(5,'LOPD'),(6,'Otras');
/*!40000 ALTER TABLE `tipos_comision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` varchar(15) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `password` varchar(450) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `fk_perfil` int(11) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perfil` (`fk_perfil`),
  CONSTRAINT `usuarios_perfil` FOREIGN KEY (`fk_perfil`) REFERENCES `usuarios_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('admin','admin','admin','admin',5,'admin');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_departamentos`
--

DROP TABLE IF EXISTS `usuarios_departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_departamentos`
--

LOCK TABLES `usuarios_departamentos` WRITE;
/*!40000 ALTER TABLE `usuarios_departamentos` DISABLE KEYS */;
INSERT INTO `usuarios_departamentos` VALUES (1,'Comercial'),(2,'TÃ©cnico'),(3,'GestiÃ³n'),(4,'AdministraciÃ³n');
/*!40000 ALTER TABLE `usuarios_departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_departamentos_rel_objetivos_mensuales`
--

DROP TABLE IF EXISTS `usuarios_departamentos_rel_objetivos_mensuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_departamentos_rel_objetivos_mensuales` (
  `fk_departamento` int(11) NOT NULL,
  `fk_objetivo` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_objetivo`),
  KEY `fk_departamento` (`fk_departamento`),
  KEY `fk_objetivo` (`fk_objetivo`),
  CONSTRAINT `usuarios_departamentos_rel_objetivos_mensuales_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_departamentos_rel_objetivos_mensuales_objetivo` FOREIGN KEY (`fk_objetivo`) REFERENCES `usuarios_objetivos_mensuales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_departamentos_rel_objetivos_mensuales`
--

LOCK TABLES `usuarios_departamentos_rel_objetivos_mensuales` WRITE;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_objetivos_mensuales` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_objetivos_mensuales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_departamentos_rel_penalizaciones`
--

DROP TABLE IF EXISTS `usuarios_departamentos_rel_penalizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_departamentos_rel_penalizaciones` (
  `fk_departamento` int(11) NOT NULL,
  `fk_penalizacion` int(10) NOT NULL,
  `penalizacion` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_penalizacion`),
  KEY `fk_departamento` (`fk_departamento`),
  KEY `fk_penalizacion` (`fk_penalizacion`),
  CONSTRAINT `usuarios_departamentos_rel_penalizaciones_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_departamentos_rel_penalizaciones_penalizacion` FOREIGN KEY (`fk_penalizacion`) REFERENCES `usuarios_penalizaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_departamentos_rel_penalizaciones`
--

LOCK TABLES `usuarios_departamentos_rel_penalizaciones` WRITE;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_penalizaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_penalizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_departamentos_rel_tipos_comision`
--

DROP TABLE IF EXISTS `usuarios_departamentos_rel_tipos_comision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_departamentos_rel_tipos_comision` (
  `fk_departamento` int(11) NOT NULL,
  `fk_tipo_comision` int(11) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_departamento`,`fk_tipo_comision`),
  KEY `fk_departamento` (`fk_departamento`),
  KEY `fk_tipo_comision` (`fk_tipo_comision`),
  CONSTRAINT `usuarios_departamentos_rel_tipos_comision_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_departamentos_rel_tipos_comision_tipo_comision` FOREIGN KEY (`fk_tipo_comision`) REFERENCES `tipos_comision` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_departamentos_rel_tipos_comision`
--

LOCK TABLES `usuarios_departamentos_rel_tipos_comision` WRITE;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_tipos_comision` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_departamentos_rel_tipos_comision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_objetivos_mensuales`
--

DROP TABLE IF EXISTS `usuarios_objetivos_mensuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_objetivos_mensuales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_objetivos_mensuales`
--

LOCK TABLES `usuarios_objetivos_mensuales` WRITE;
/*!40000 ALTER TABLE `usuarios_objetivos_mensuales` DISABLE KEYS */;
INSERT INTO `usuarios_objetivos_mensuales` VALUES (1,'Enero'),(2,'Febrero'),(3,'Marzo'),(4,'Abril'),(5,'Mayo'),(6,'Junio'),(7,'Julio'),(8,'Agosto'),(9,'Septiembre'),(10,'Octubre'),(11,'Noviembre'),(12,'Diciembre');
/*!40000 ALTER TABLE `usuarios_objetivos_mensuales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_penalizaciones`
--

DROP TABLE IF EXISTS `usuarios_penalizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_penalizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_penalizaciones`
--

LOCK TABLES `usuarios_penalizaciones` WRITE;
/*!40000 ALTER TABLE `usuarios_penalizaciones` DISABLE KEYS */;
INSERT INTO `usuarios_penalizaciones` VALUES (1,'Menos del 50%'),(2,'51%-75%'),(3,'76%-100%'),(4,'101%-120%'),(5,'121%-150%'),(6,'MÃ¡s del 150%');
/*!40000 ALTER TABLE `usuarios_penalizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_perfiles`
--

DROP TABLE IF EXISTS `usuarios_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `es_director_departamento` tinyint(1) NOT NULL DEFAULT '0',
  `fk_departamento` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_perfiles`
--

LOCK TABLES `usuarios_perfiles` WRITE;
/*!40000 ALTER TABLE `usuarios_perfiles` DISABLE KEYS */;
INSERT INTO `usuarios_perfiles` VALUES (1,'Comercial',0,1),(2,'Televendedor',0,1),(3,'Técnico',0,2),(4,'Gerente',0,3),(5,'Administrador',0,4),(6,'Director TÃ©cnico',1,2),(7,'Director Comercial',1,1);
/*!40000 ALTER TABLE `usuarios_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_rel_objetivos_mensuales`
--

DROP TABLE IF EXISTS `usuarios_rel_objetivos_mensuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_rel_objetivos_mensuales` (
  `fk_usuario` varchar(15) NOT NULL,
  `fk_objetivo` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_objetivo`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_objetivo` (`fk_objetivo`),
  CONSTRAINT `usuarios_rel_objetivos_mensuales_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_rel_objetivos_mensuales_objetivo` FOREIGN KEY (`fk_objetivo`) REFERENCES `usuarios_objetivos_mensuales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_rel_objetivos_mensuales`
--

LOCK TABLES `usuarios_rel_objetivos_mensuales` WRITE;
/*!40000 ALTER TABLE `usuarios_rel_objetivos_mensuales` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_rel_objetivos_mensuales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_rel_penalizaciones`
--

DROP TABLE IF EXISTS `usuarios_rel_penalizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_rel_penalizaciones` (
  `fk_usuario` varchar(15) NOT NULL,
  `fk_penalizacion` int(10) NOT NULL,
  `penalizacion` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_penalizacion`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_penalizacion` (`fk_penalizacion`),
  CONSTRAINT `usuarios_rel_penalizaciones_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_rel_penalizaciones_penalizacion` FOREIGN KEY (`fk_penalizacion`) REFERENCES `usuarios_penalizaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_rel_penalizaciones`
--

LOCK TABLES `usuarios_rel_penalizaciones` WRITE;
/*!40000 ALTER TABLE `usuarios_rel_penalizaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_rel_penalizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_rel_tipos_comision`
--

DROP TABLE IF EXISTS `usuarios_rel_tipos_comision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_rel_tipos_comision` (
  `fk_usuario` varchar(15) NOT NULL,
  `fk_tipo_comision` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_tipo_comision`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_tipo_comision` (`fk_tipo_comision`),
  CONSTRAINT `usuarios_rel_tipos_comision_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_rel_tipos_comision_tipo_comision` FOREIGN KEY (`fk_tipo_comision`) REFERENCES `tipos_comision` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_rel_tipos_comision`
--

LOCK TABLES `usuarios_rel_tipos_comision` WRITE;
/*!40000 ALTER TABLE `usuarios_rel_tipos_comision` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_rel_tipos_comision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_oferta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_aceptado` int(11) DEFAULT NULL,
  `fecha_asignacion_tecnico` int(11) DEFAULT NULL,
  `formacion_bonificada` tinyint(1) DEFAULT NULL,
  `fecha_entrada_vigor` int(11) DEFAULT NULL,
  `fecha_toma_contacto` int(11) NOT NULL DEFAULT '0',
  `fecha_inicio` int(11) NOT NULL DEFAULT '0',
  `fecha_estimada_formacion` int(11) NOT NULL DEFAULT '0',
  `fecha_pago_inicial` int(11) NOT NULL DEFAULT '0',
  `fk_forma_pago` int(11) NOT NULL,
  `fk_tipo_comision` int(11) NOT NULL,
  `forcem` longtext,
  `plazo_ejecucion` longtext,
  `cuenta_cargo` varchar(23) DEFAULT NULL,
  `observaciones_forma_pago` longtext,
  `nombre_certificadora` varchar(500) DEFAULT NULL,
  `otros_proyectos` longtext,
  `observaciones` longtext,
  `precio_consultoria` float NOT NULL DEFAULT '0',
  `precio_formacion` float NOT NULL DEFAULT '0',
  `pago_inicial` float NOT NULL DEFAULT '0',
  `pago_mensual` float NOT NULL DEFAULT '0',
  `numero_pagos_mensuales` int(3) NOT NULL DEFAULT '0',
  `subvenciones` tinyint(1) NOT NULL DEFAULT '0',
  `certificacion` tinyint(1) NOT NULL DEFAULT '0',
  `presupuesto_aceptado_certificadora` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_oferta` (`fk_oferta`),
  CONSTRAINT `ventas_oferta` FOREIGN KEY (`fk_oferta`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas_plazos`
--

DROP TABLE IF EXISTS `ventas_plazos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas_plazos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` int(11) NOT NULL,
  `fk_venta` int(11) NOT NULL,
  `fk_estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas_plazos`
--

LOCK TABLES `ventas_plazos` WRITE;
/*!40000 ALTER TABLE `ventas_plazos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas_plazos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitas`
--

DROP TABLE IF EXISTS `visitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_proyecto` int(11) NOT NULL,
  `fecha` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `fk_usuario` varchar(15) DEFAULT NULL,
  `es_visita_interna` tinyint(1) NOT NULL,
  `fk_sede` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proyecto` (`fk_proyecto`),
  KEY `fk_usuario` (`fk_usuario`),
  KEY `fk_sede` (`fk_sede`),
  CONSTRAINT `visitas_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visitas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visitas_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitas`
--

LOCK TABLES `visitas` WRITE;
/*!40000 ALTER TABLE `visitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `visitas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-26 12:29:52
