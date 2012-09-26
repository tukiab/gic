-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db8.1and1.es
-- Generation Time: Nov 19, 2010 at 09:19 PM
-- Server version: 5.0.91
-- PHP Version: 5.2.6-1+lenny9
-- 
-- Database: `db346184166`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `acciones_de_trabajo`
-- 
use agesene;
CREATE TABLE `acciones_de_trabajo` (
  `id` int(11) NOT NULL auto_increment,
  `fk_tipo_accion` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha` int(11) default NULL,
  `fecha_siguiente_accion` int(11) default NULL,
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

-- 
-- Dumping data for table `acciones_de_trabajo`
-- 

INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (2, 1, 245, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (3, 1, 245, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (4, 1, 245, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (5, 1, 246, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (6, 1, 246, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (7, 1, 246, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (8, 1, 247, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (9, 1, 247, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (10, 1, 247, 'jose.sanchez', 1289257200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (11, 1, 122, 'admin', 1289343600, NULL, '- Acción realizada:\r\nEsther Martin le visitó con su anterior empresa. Después de tener casi cerrado el acuerdo, no firmaron\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (12, 1, 136, 'admin', 1289343600, NULL, '- Acción realizada:\r\nParece que están en Mazagón. Esther la visitó cuendo estaba con José Luis, pero no firmaron nada\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (13, 1, 139, 'jose.sanchez', 1289343600, NULL, '- Acción realizada:\r\nEmpresa autobuses, clientes de Jose Luis. Se estan certificando en 13816. Información facilitada por Esther\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (14, 1, 159, 'jose.sanchez', 1289343600, NULL, '- Acción realizada:\r\nOJO: empresa con problemas económicos. Han dejado tirados a la empresa Frescortés sin entregarles la depuradora una vez pagada.\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (15, 1, 193, 'jose.sanchez', 1289343600, 1292194800, '- Acción realizada:\r\nvisitado por Esther y Álvaro. Interesados en temas de formación\r\n\r\n\r\n- Siguiente acción a realizar:\r\nSeguimiento');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (16, 5, 210, 'jose.sanchez', 1289343600, 1292367600, '- Acción realizada:\r\nVisitada por Esther\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (17, 5, 212, 'jose.sanchez', 1289343600, 1294182000, '- Acción realizada:\r\nVisitada por Esther\r\n\r\n\r\n- Siguiente acción a realizar:\r\nSeguimiento');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (18, 1, 215, 'jose.sanchez', 1289343600, NULL, '- Acción realizada:\r\ncliente jose Luis, el gerente es amigo suyo\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (19, 8, 249, 'esther.martin', 1289430000, 1294614000, '- Acción realizada:\r\n\r\nVISITA. NO ESTÁN INTERESADOS EN IMPLANTAR NADA. DICE QUE LA CALIDAD LA LLEVAN ELLOS. TIENEN SU SISTEMA PROPIO. DE TODAS FORMAS COMENTARA CON GERENCIA Y SI LES INTERESA NOS LLAMARÁ\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR EN ENERO');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (20, 8, 250, 'esther.martin', 1289430000, 1289862000, '- Acción realizada:\r\nVISITA INFORMACIÓN DEJADO CATALOGO DE DOROS. EL GERENTE ESTA EN LA FERIA INTERNACIONAL DE BARCELONA. SON CONCESIONARIO YAMAHA Y JEANNEAU.\r\n\r\n\r\n- Siguiente acción a realizar: \r\nLLAMAR LA SEMANA PRÓXIMA PARA SABER INTERES. GRAN CONCESIONARIO DE YATES...');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (21, 8, 251, 'esther.martin', 1289343600, NULL, '- Acción realizada:\r\nVISITA INFORMACIÓN. NO ESTAN CERTIFICADOS EN 14001. DICE QUE REPSOL LES ACTUALIZA TODO Y CUANDO NECESITAN ALGO LOS LLAMAN Y SE LO GESTIONAN.\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (22, 8, 252, 'esther.martin', 1289343600, NULL, '- Acción realizada:\r\nVISITA. INSTALADORES DE GAS. SON SERVICIO OFICIAL DE GAS. DICE QUE NO ESTAN OBLIGADOS A TENER NINGUNA CERTIFICACIÓN POR LEY. LE HABLAMOS DE MEDIOAMBIENTE.\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (23, 8, 252, 'esther.martin', 1289343600, NULL, '- Acción realizada:DICE QUE MIENTRAS NO LE OBLIGIEN POR LEY NO HACE NADA. LE HABLAMOS DE MEDIOAMBIENTE. DICE QUE SI LE OBLIGAN NOS LLAMARÁ.\r\n\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (24, 8, 253, 'esther.martin', 1289430000, 1290380400, '- Acción realizada:\r\nVISITADA, LA PERSONA DE CONTACTO (ISABEL) ESTA DE BAJA. PUEDEN ESTAR INTERESADOS EN 9001+14001.\r\n\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR PARA VOLVER A VISITAR');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (25, 8, 254, 'esther.martin', 1289430000, 1289775600, '- Acción realizada:\r\nESTAN CERTIFICADOS EN LA 9001 CON BUREAU. LICITAN CON LA ADMINISTRACION, POR ESO SE CERTIFICARON. PUEDE INTERESARLES LA 14001. PREFIERE HABLAR DE ELLO TRANQUILAMENTE, LE LLEGA UN TRAILER Y NO PUEDE SEGUIR ATENDIENDONOS. \r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR LA SEMANA PRÓXIMA PARA QUEDAR, COMENTAR SUBVENCIONES Y TOMAR DATOS PARA PRESUPUESTO');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (26, 8, 255, 'esther.martin', 1289430000, 1289775600, '- Acción realizada:\r\n ES UN OBRADOR DE PASTELERÍA. HACEN PRODUCTOS TÍPICOS DE HUELVA (HORNAZOS, BIZCOCHOS, PESTIÑOS, ETC). SU PRINCIPAL CLIENTE ES EL JAMÓN Y OTROS SUPER MAS PEQUEÑOS, COMERCIOS, ETC. ELABORAR PPTO DE 22000 Y 14001. USAN LOS CREDITOS PERO DICE QUE LOS MALGASTAN POR NO PERDERLOS PQ SON MUY PESADAS LAS EMPRESAS DE FORMACIÓN.\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR PARA LLEVAR PPTO');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (27, 8, 256, 'esther.martin', 1289430000, 1289775600, '- Acción realizada:\r\nNO HA IDO A TRABAJAR HOY ROCIO, QUE ES LA PERSONA QUE LO LLEVA (ESTA ENFERMA). SON PROVEEDORES DE PEQUEÑOS COMERCIOS, PANADERIA. NOS ATIENDE EL JEFE (CREO QUE ERA EL DUEÑO) PERO NOS DICE QUE MEJOR HABLEMOS CON LA NIÑA\r\n\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR PARA VISITAR CUANDO ESTE ROCIO');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (28, 7, 257, 'esther.martin', 1289343600, NULL, '- Acción realizada:\r\nRECOGEMOS DOCUMENTACIÓN PARA ENTREGAR EN IDEA. UNA VEZ ENTREGADA LES DEVOLVEMOS LOS ORIGINALES\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (29, 7, 258, 'esther.martin', 1289170800, NULL, '- Acción realizada:\r\n\r\nVISITA DE SEGUIMIENTO. SU PRINCIPAL CLIENTE ES RAFAEL MORALES Y HA DECLARADO SUSPENSIÓN DE PAGO, LES DEBEN MUCHO DINERO. SIGUEN QUERIENDO CERTIFICARSE PERO VAN A VER COMO EVOLUCIONA TODO. SEGURAMENTE EL AÑO PRÓXIMO.  \r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (30, 7, 259, 'esther.martin', 1289430000, 1292194800, '- Acción realizada:\r\nESTAN MUY INTERESADOS EN LA 22000+14001, PERO NO QUIEREN METERSE AHORA MISMO PORQUE ACABAN DE TERMINAR UNA GRAN INVERSIÓN PARA ACONDICIONARLO TODO Y CUMPLIR CON SANIDAD. EN UNOS MESES QUIEREN EMPEZAR POR LO QUE PIDEN QUE MANTENGAMOS EL CONTACTO.\r\n\r\n- Siguiente acción a realizar:\r\n\r\nSEGUIMIENTO MENSUAL. LLAMAR EN ENERO');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (31, 5, 260, 'esther.martin', 1289257200, 1289862000, '- Acción realizada:\r\n\r\nLLEVADO PRESUPUESTO, LE PARECE INTERESANTE. LO MIRARA TRANQUILAMENTE\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR LA SEMANA PRÓXIMA');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (32, 5, 261, 'esther.martin', 1289257200, 1289775600, '- Acción realizada:\r\n\r\nLLEVAMOS OFERTA PERO EL HIJO SE HA IDO ENFERMO Y EL PADRE (DUEÑO) PREFIERE QUE LO VEAMOS CON SU HIJO.\r\n\r\n- Siguiente acción a realizar:\r\n\r\nLLAMAR LA SEMANA PRÓXIMA');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (33, 1, 125, 'jose.sanchez', 1289862000, 1297810800, '- Acción realizada:\r\nContacto telefónico con José Trigueros. Muy receptivo, pero ahora no tienen actividad. Cuando tengan carga de trabajo puede que este asunto les interese. Llamar en 2-3 meses\r\n\r\n\r\n- Siguiente acción a realizar:\r\nLlamar');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (34, 6, 126, 'jose.sanchez', 1289862000, 1289862000, '- Acción realizada:\r\n\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (35, 1, 130, 'jose.sanchez', 1289862000, 1290466800, '- Acción realizada:\r\nHe hablado con recepción. Emilio está de baja.\r\n\r\n\r\n- Siguiente acción a realizar:\r\nLlamr semana siguiente');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (36, 1, 131, 'jose.sanchez', 1289862000, NULL, '- Acción realizada:\r\nLa central está en Sevilla\r\n\r\n\r\n- Siguiente acción a realizar:');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (37, 1, 132, 'jose.sanchez', 1289862000, 1290034800, '- Acción realizada:\r\nHe hablado con un empleado. La gerencia se encuentra en La Palma del Condado.\r\n\r\n\r\n- Siguiente acción a realizar:\r\nLlamar al gerente: Pedro');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (38, 1, 126, 'jose.sanchez', 1289862000, 1290034800, '- Acción realizada:\r\nHe hablado con recepción. El hotel no pertenece a ninguna cadena. El gerente viene de tarde en tarde y prefieren que se le envíe información por mail.\r\n\r\n\r\n- Siguiente acción a realizar:\r\nEnviar mail informativo');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (39, 1, 262, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (40, 1, 262, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (41, 1, 262, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (42, 1, 263, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (43, 1, 263, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (44, 1, 263, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (45, 1, 264, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (46, 1, 264, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (47, 1, 264, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (48, 1, 265, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (49, 1, 265, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (50, 1, 265, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (51, 1, 266, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (52, 1, 266, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (53, 1, 266, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (54, 1, 267, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (55, 1, 267, 'jose.sanchez', 1290121200, NULL, 'abc');
INSERT INTO `acciones_de_trabajo` (`id`, `fk_tipo_accion`, `fk_cliente`, `fk_usuario`, `fecha`, `fecha_siguiente_accion`, `descripcion`) VALUES (56, 1, 267, 'jose.sanchez', 1290121200, NULL, 'abc');

-- --------------------------------------------------------

-- 
-- Table structure for table `acciones_tipos`
-- 

CREATE TABLE `acciones_tipos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `acciones_tipos`
-- 

INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (1, 'Llamada Prospección');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (3, 'Llamada de contacto');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (4, 'Llamada de seguimiento');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (5, 'Entrega oferta');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (6, 'FALLIDA');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (7, 'Visita Seguimiento');
INSERT INTO `acciones_tipos` (`id`, `nombre`) VALUES (8, 'Primera Visita');

-- --------------------------------------------------------

-- 
-- Table structure for table `alumnos`
-- 

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `alumnos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `atajos`
-- 

CREATE TABLE `atajos` (
  `id` int(5) NOT NULL auto_increment,
  `nombre` varchar(15) collate utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) collate utf8_spanish_ci NOT NULL,
  `url` varchar(250) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `atajos`
-- 

INSERT INTO `atajos` (`id`, `nombre`, `descripcion`, `url`) VALUES (1, 'Atajos', 'Editar atajos', '/Usuarios/AtajosUsuario.php');

-- --------------------------------------------------------

-- 
-- Table structure for table `clientes`
-- 

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL auto_increment,
  `razon_social` varchar(400) NOT NULL,
  `fk_tipo_cliente` int(11) NOT NULL,
  `NIF` varchar(9) default NULL,
  `domicilio` varchar(400) default NULL,
  `localidad` varchar(45) default NULL,
  `CP` int(11) default NULL,
  `numero_empleados` int(11) default NULL,
  `web` varchar(450) default NULL,
  `sector` varchar(450) default NULL,
  `SPA_actual` varchar(450) default NULL,
  `fecha_renovacion` int(11) default NULL,
  `norma_implantada` varchar(45) default NULL,
  `creditos` int(11) default NULL,
  `fk_grupo_empresas` int(11) default '1',
  `provincia` varchar(15) NOT NULL,
  `FAX` int(11) default NULL,
  `telefono` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=268 DEFAULT CHARSET=utf8 AUTO_INCREMENT=268 ;

-- 
-- Dumping data for table `clientes`
-- 

INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (1, 'TABERNA CARMELO, S.L.', 2, 'B21254339', 'C/ ORILLA, S/N', 'PUNTA UMBRIA', 21100, 5, NULL, 'TURISMO', NULL, NULL, NULL, 420, 1, 'HUELVA', NULL, 959315153);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (122, 'FRUTAS BORJA, S. L.', 1, NULL, 'PARAJE LA PEQUEÑA HOLANDA', 'Almonte', 21730, NULL, 'www.frutasborja.es', 'Alimentación', NULL, NULL, 'GLOBAL GAP', NULL, 3, 'Huelva', NULL, 609667056);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (123, 'GARME FORESTAL S.L.', 1, NULL, 'ROSALÍA DE CASTRO 34', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 635429546);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (124, 'APICOLA DOÑANA, S. L.', 1, NULL, 'PARQUE INDUSTRIAL EL TOMILLAR PARC- 63-64 NAVE 4', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 660536836);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (125, 'ALMODECON SL', 1, NULL, 'CL FLORENTINO PEREZ EMBID 14', 'Almonte', 21730, 17, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 679461455);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (126, 'BARNETHOTELES SL (Hotel Carabela)', 1, NULL, 'SR H PARCELA 59 60 MATALASCAÑAS', 'Almonte', 21730, 79, NULL, 'Hosteleria', NULL, NULL, NULL, NULL, 1, 'Huelva', 959448125, 959448001);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (127, 'RESTING DONANA TOUR SOCIEDAD LIMITADA.', 1, NULL, 'HOTEL FLAMERO MATALASCANAS', 'Almonte', 21730, 1, NULL, 'Hosteleria', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 902505100);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (128, 'DUNAS DE DOÑANA GOLF RESORT SL', 1, NULL, 'SECT JAGUARZO 0 BAJO', 'Almonte', 21730, 30, NULL, 'Hosteleria', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 902505200);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (129, 'DUNAS 2000 SL', 1, NULL, 'CL ANTONIO MACHADO 15', 'Almonte', 21730, 16, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 954570889);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (130, 'HORTIFRUT ESPANA SOUTHERN SUN SL', 1, NULL, 'CR DEL ROCIO', 'Almonte', 21730, 23, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959443884, 959027420);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (131, 'HIELO ALBAIDA', 1, NULL, 'c/ Amante Laffon nº 20', 'Sevilla', 41000, NULL, 'www.hielosalbaida.es', 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Sevilla', NULL, 954355505);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (132, 'TU RUEDA SOCIEDAD LIMITADA', 1, NULL, 'ZO SEC. E 1 (MATALASCAÑAS)', 'Almonte', 21730, 3, NULL, 'Talleres', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959127159);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (133, 'ATLANTIC DONANA PROMOCION Y GESTIONES INMOBILIARIAS S.A.', 1, NULL, 'CL MUNDO NUEVO, 16', 'Almonte', 21730, 2, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959356250);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (134, 'EL FLAMENCO HOTEL SA', 1, NULL, 'RDA MAESTRO ALONSO 1', 'Almonte', 21730, 47, NULL, 'Hosteleria', NULL, NULL, NULL, NULL, 1, 'Huelva', 959448586, 959371282);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (135, 'DISTRIBUCIONES PLAYA SL', 1, NULL, 'ZO SEC. S 0 PARC.19-27 (MATALASC', 'Almonte', 21730, 19, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959440651, 959376758);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (136, 'HIPERJARDÍN', 1, NULL, 'Polígono Los Pinos, 48 , ALMONTE (HUELVA)', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959377860);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (137, 'CENTRO DE REUNION LAS MARISMAS S.L.', 1, NULL, 'AV RAFAEL ALBERTI, 15', 'Almonte', 21730, 18, NULL, 'Hosteleria', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406018);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (138, 'LA TIENDA DE GARCIA SL.', 1, NULL, 'CR DEL ROCIO KM 234', 'Almonte', 21730, 7, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407537, 959406090);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (139, 'HORNO BLANCA PALOMA S.L.', 1, NULL, 'CL SANTIAGO, 15', 'Almonte', 21730, 17, NULL, 'Alimentación+Empresa Autobuses', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451564, 959406097);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (140, 'Agroalimentaria Virgen del Rocío', 1, NULL, 'AVDA. DE LOS CABEZUDOS, Nº 1', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959406146);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (141, 'CONFITERÍA PASTELERÍA HIERRO', 1, NULL, 'VENIDA DE LA VIRGEN 20 (ROCÍO -MATALASCAÑAS)', 'Almonte', 21730, NULL, 'www.confiteriahierro.com', 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406192);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (142, 'GALLESA 2000 SL', 1, NULL, 'CL PQUE 0 PARQUE INDUSTRIAL E', 'Almonte', 21730, 11, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406214);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (143, 'MANUELA RAMOS MUÑOZ', 1, NULL, 'Infanta María Luisa, 26', 'Almonte', 21730, NULL, NULL, 'Piensos', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406228);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (144, 'GABRIEL RAMOS E HIJOS SOCIEDAD LIMITADA', 1, NULL, 'CR EL ROCIO 172', 'Almonte', 21730, 13, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406337);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (145, 'CONSTRUCCIONES ROCIERA S.L.', 1, NULL, 'CL FERIA, 100', 'Almonte', 21730, 6, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406373);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (146, 'LAUREANO VAZQUEZ RAMIREZ SL', 1, NULL, 'CM LLANOS 1', 'Almonte', 21730, 9, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406422);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (147, 'CRISTALERIA DIAZ Y DIAZ S.L.', 1, NULL, 'CL SANTA ANA, 135', 'Almonte', 21730, 12, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959406456, 959406456);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (148, 'AUTO ROMAN, S.L.', 1, NULL, 'CR DEL ROCIO, 95', 'Almonte', 21730, 8, NULL, 'Talleres', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406726);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (149, 'CONSTRUCTORA Y SERVICIOS IGUBAMON SL', 1, NULL, 'CL ANTONIO MACHADO 8 1º', 'Almonte', 21730, 8, NULL, 'Ingenierías', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406755);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (150, 'FONTARIEGOS ALMONTE SL', 1, NULL, 'CR DEL ROCIO, 170', 'Almonte', 21730, 3, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959406812, 959406812);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (151, 'PINTURAS ALMONTE SL', 1, NULL, 'CL EL POCITO 1', 'Almonte', 21730, 94, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959406847);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (152, 'MOVIMIENTOS DE SUELOS Y CONSTRUCCION SOCIEDAD LIMITADA.', 1, NULL, 'CL LA DEHESA', 'Almonte', 21730, 39, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451535, 959406858);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (153, 'ALGAIDA PRODUCTORES', 1, NULL, 'PARCELA Nº 56 POLIGONO INDUSTRIAL MATALAGRANA', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959406944);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (154, 'OBRAS DOÑANA ALMONTE SL', 1, NULL, 'CL ALGAIDA 26', 'Almonte', 21730, 18, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407010);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (155, 'CONSTRUCCIONES LOS JOVENES S.L.', 1, NULL, 'CL RAMON Y CAJAL, 44', 'Almonte', 21730, 5, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 952585461, 959407011);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (156, 'CARPINTERIA MATIAS SL', 1, NULL, 'CL PICASSO 17', 'Almonte', 21730, 15, NULL, 'Industria de la madera y del corcho', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407117);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (157, 'CONSTRUCCIONES BELLA MARTINEZ SL', 1, NULL, 'CM DE LOS LLANOS, 48', 'Almonte', 21730, 2, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407146);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (158, 'SABORES DEL SUR SL', 1, NULL, 'PZ ESPAÑA, 12', 'Almonte', 21730, 0, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407299, 959407299);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (159, 'DOÑANA FORESTAL SERVICIOS SL', 1, NULL, 'PG EL TOMILLAR 0 NAVE 40.', 'Almonte', 21730, 21, NULL, 'Construcción', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959407336);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (161, 'MANUFRAN S.L.', 1, NULL, 'CL LA PALMOSA, 27', 'Almonte', 21730, 8, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407453, 959407453);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (162, 'EMPRESA DE TRANSFORMACION AGRARIA S.A.', 1, NULL, 'La Verdeja, 2', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407525);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (163, 'HIERROS ROCIO SL', 1, NULL, 'CR EL ROCIO 151', 'Almonte', 21730, 10, NULL, 'Fabricación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407644);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (164, 'MIGUEL ANGEL GALAN PEREZ ESTRUCTURAS SL', 1, NULL, 'CR DEL ROCIO 131', 'Almonte', 21730, 20, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407781);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (165, 'TALLER MECANICO ALMOTOR S.L.', 1, NULL, 'AV DE LOS CABEZUDOS, 29', 'Almonte', 21730, 7, NULL, 'Talleres', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407842, 959407842);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (166, 'SEGUROS Y TELEFONIA JUAN FCO ESPINA SL.', 1, NULL, 'CL PADRE JOSE ANTONIO RODRIGUEZ BEJERANO, 4', 'Almonte', 21730, 3, NULL, 'Asesorías', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407869, 959407869);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (167, 'LA JACA DE DOÑANA SL', 1, NULL, 'PG MATALAGRANA 0 PARCELA 102-105.', 'Almonte', 21730, 14, NULL, 'Industria textil', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407918);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (168, 'CERRAJERIA DOÑANA SL', 1, NULL, 'CR DEL ROCIO 95', 'Almonte', 21730, 0, NULL, 'Fabricación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959407960);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (169, 'SUPERMERCADOS NUESTRA SEÑORA DEL ROCIO SLL', 1, NULL, 'CL EL ROCIO 0 PL. DEL COMERCIO.', 'Almonte', 21730, 7, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959410801);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (170, 'BOSTON BAGUETERIA S.L.', 1, NULL, 'PZ PUEBLO - MATALASCANAS', 'Almonte', 21730, 6, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959430285);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (171, 'LOPIG JOSPH SL.', 1, NULL, 'URB PLAYA DE MATALASCANAS. EDIF EL QUIJOTE L', 'Almonte', 21730, 5, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959430394);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (172, 'CASA MIGUEL RESTAURACION S.L.', 1, NULL, 'MATALASCANAS. CR MATALASCANAS-EL ROCIO', 'Almonte', 21730, 6, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959430500);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (173, 'BAMAR 2000 SA', 1, NULL, 'CL MATALASCAÑAS SECTOR D 2 FASE. EDIF HOTEL COT', 'Almonte', 21730, 76, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', 959440202, 959440017);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (174, 'SUPER ENGRACIA SOCIEDAD LIMITADA.', 1, NULL, 'LG SECTOR INGLESILLO', 'Almonte', 21730, 1, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440040);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (175, 'ASESORAMIENTO E INTERMEDIACION TURISTICA SL', 1, NULL, 'SEC. M 73', 'Almonte', 21730, 13, NULL, 'Agencias viaje', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440044);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (176, 'PEDRO JOSE RAMOS ESPINOSA (Carnicerías)', 1, NULL, 'C. Com. Caño Guerrero, LOCAL 5-7-8', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440128);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (177, 'CONSTRUCCIONES DURVI S.L.', 1, NULL, 'CL COTOMAR IV, 4', 'Almonte', 21730, 3, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440176);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (178, 'FUNDOVEL SA', 1, NULL, 'SECT M 1', 'Almonte', 21730, 75, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', 959440720, 959440206);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (179, 'HOSTELERIA BAR EL PATO, S.L.', 1, NULL, 'PG MATALASCANAS SECTOR N, 50', 'Almonte', 21730, 4, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440440);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (180, 'INMOBILIARIA LINCES DE DONANA S.L.', 1, NULL, 'UR PLAYA DE MATALASCANAS.PARCELA 2', 'Almonte', 21730, 4, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959440069, 959440660);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (181, 'COMERCIAL MARVAZ MATALASCAÑAS SOCIEDAD LIMITADA', 1, NULL, 'ZO SEC. S 0 PARC.29 (MATALASCAÑA', 'Almonte', 21730, 5, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959440845);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (182, 'EXCLUSIVAS DONANA S.L.', 1, NULL, 'LG CAMPO DE GOLF(SECTOR J)', 'Almonte', 21730, 14, NULL, 'Actividades deportivas', NULL, NULL, NULL, NULL, 1, 'Huelva', 959440069, 959441810);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (184, 'CORDINATOR S L', 1, NULL, 'CL REYNOLDS, 45', 'Almonte', 21730, 3, NULL, 'Abogados', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442035);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (185, 'ARANDANOS DEL ROCIO S.L.', 1, NULL, 'CR DEL ROCIO', 'Almonte', 21730, 12, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442137);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (186, 'ATLANTIC BLUE SL', 1, NULL, 'CR DEL ROCIO 130', 'Almonte', 21730, 253, NULL, 'I+D', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442137);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (187, 'NUESTRA SEÑORA DEL ROCIO (Panaderías)', 1, NULL, 'Baltasar Tercero, 8', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442208);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (188, 'DITTMEYER AGRICOLA Y CIA. AYA DEL MARQUESADO S.C.', 1, NULL, 'Ctra. Matalascañas, KM 31''9', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442257);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (189, 'PUNTO 2000 S.C.A.', 1, NULL, 'Ctra. Almonte-Matalascañas, 22.5 KM', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442262);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (190, 'FLOPORAN, S.C.A.', 1, NULL, 'LG PLAN ALMONTE MARISMA SUBSECTOR 2 16 LOTE, 2', 'Almonte', 21730, 91, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', 959442286, 959442286);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (191, 'TORUÑO DEL ROCIO SL', 1, NULL, 'PZ EL ACEBUCHAL 22 Y 23 EL ROCIO', 'Almonte', 21730, 17, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959442422);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (192, 'AIRES DE DONANA SOCIEDAD LIMITADA.', 1, NULL, 'AV CANALIEGA, 1', 'Almonte', 21730, 5, NULL, 'Hostelería', NULL, NULL, NULL, NULL, 1, 'Huelva', 959442719, 959442719);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (193, 'S.A.T. LOS MIMBRALES N. 9492', 1, NULL, NULL, 'Almonte', 21730, NULL, 'www.satmimbrales.com', 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959443863);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (194, 'BOUTIQUE EL SANCHO (Panaderías)', 1, NULL, 'Sec. Cerceta (Fase I), S/N-BL 3', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448048);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (195, 'PARQUE DUNAR DE DONANA S.L.', 1, NULL, 'LG PARQUE DUNAR DONANA', 'Almonte', 21730, 5, NULL, 'Cultura', NULL, NULL, NULL, NULL, 1, 'Huelva', 959448061, 959448086);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (196, 'PESCADOS ELABORADOS DE HUELVA SL', 1, NULL, 'CEREZO 25', 'Almonte', 21730, 0, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448414);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (197, 'TRANSPORTES RAMIREZ MENDOZA S.L.', 1, NULL, 'CL BLAS INFANTE, 9', 'Almonte', 21730, 6, NULL, 'Transporte', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448527);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (198, 'ZAMPABOLLOS SL', 1, NULL, 'PLG MATALAGRANA 0 PARCELAS 90-91.', 'Almonte', 21730, 18, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448606);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (199, 'MANUEL PEREZ MATEOS (Carnicerías)', 1, NULL, 'Av. las Adelfas, S/N ', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448686);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (200, 'PANADERIA LA SOLUCION', 1, NULL, 'Av. Pintor Rafael, 37', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959448791);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (201, 'INSTALACIONES Y MONTAJES ELECTRICOS ROCIO SL', 1, NULL, 'CL SEVILLA 7', 'Almonte', 21730, 17, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450001);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (202, 'HERMACABA SL', 1, NULL, 'PZ FUENTE DE LAS DAMAS 1', 'Almonte', 21730, 23, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450022);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (203, 'VITAFRESH SL', 1, NULL, 'CTRA. ALMONTE A EL ROCIO, KM. 9,500', 'Almonte', 21730, 53, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', 959451212, 959450126);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (205, 'LA RIBERA DE MATALASCAÑAS S.L.', 1, NULL, 'Carretera del Rocío, 25 - bajo', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450199);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (206, 'TELECABLE ALMONTE, S.L.', 1, NULL, 'CL LA MARMOLEJA, 22', 'Almonte', 21730, 8, NULL, 'Cultura', NULL, NULL, NULL, NULL, 1, 'Huelva', 959450218, 959450218);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (207, 'EXPLOTACIONES FORESTALES LOS OJUELOS SL', 1, NULL, 'CR EL ROCIO 228', 'Almonte', 21730, 45, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450227);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (208, 'ROCIOFRUT (Mayorista Furtas y Hortalizas)', 1, NULL, 'Ctra. el Rocío, 103', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450244);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (209, 'SVZ ESPAÑA, SA', 1, NULL, 'CTRA ALMONTE-EL ROCIO, KM 9, POL. IND. MATALAGRANA', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959450288);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (210, 'ESTACION DE SERVICIO PUERTA DOÑANA SL', 1, NULL, 'CR ROCIO 30', 'Almonte', 21730, 7, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450331);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (211, 'ASESORIA BLANCO SL', 1, NULL, 'CL CONCEPCION, 22', 'Almonte', 21730, 4, NULL, 'Abogados', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451879, 959450426);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (212, 'ES ALMONTE S.L.', 1, NULL, 'CR DEL ROCIO, 114', 'Almonte', 21730, 16, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959450035, 959450445);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (213, 'NEUMATICOS LARA SLL.', 1, NULL, 'PG POLIGONO INDUSTRIAL TOMILLAR, 22', 'Almonte', 21730, 3, NULL, 'Talleres', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450496);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (214, 'CAUCHOS SAN DIEGO SL', 1, NULL, 'AV DE LA JUVENTUD 7', 'Almonte', 21730, 30, NULL, 'Fabricación', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407112, 959450537);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (215, 'AGROBIONEST SL', 1, NULL, 'PG DE ALMONTE 0 CRTA. DEL ROCI.', 'Almonte', 21730, 42, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450656);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (216, 'BIONEST', 1, NULL, 'P. I. MATALGRANA CRT. ALMONTE- EL ROCIO, KM 9', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959450656);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (217, 'APROVECHAMIENTOS INDUSTRIALES DOÑANA SL', 1, NULL, 'CL ALTOZANO 8', 'Almonte', 21730, 20, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450691);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (218, 'PESCADERIA ALMONTE S.L.', 1, NULL, 'CL CONCEPCION ARENAL, 7', 'Almonte', 21730, 4, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450706);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (219, 'INSTALACIONES Y MONTAJES ELECTRICOS DEL SUR SL', 1, NULL, 'CR DEL ROCIO 126 128', 'Almonte', 21730, 15, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407178, 959450713);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (220, 'GASOCENTRO ALMONTE SL', 1, NULL, 'CR DEL ROCIO 14 1º', 'Almonte', 21730, 4, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450768);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (221, 'HORNO MARTIN NARANJO, S.L.', 1, NULL, 'AV DE LA CONSTITUCION, 50', 'Almonte', 21730, 11, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450851);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (222, 'CRISTALERIA ESPINA S.L.', 1, NULL, 'CL LA PARRILLA, 12', 'Almonte', 21730, 4, NULL, 'Fabricación', NULL, NULL, NULL, NULL, 1, 'Huelva', 959450879, 959450879);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (223, 'ARIDOS EL OJILLO S.L.', 1, NULL, 'CL LA ROCINA, 4', 'Almonte', 21730, 9, NULL, 'Industria extractiva', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451366, 959450911);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (224, 'AGROFORESTAL DOÑANA SL', 1, NULL, 'Ctra. el Rocío, KM 1', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959450964);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (226, 'FLOR DE DOÑANA, S.L.', 1, NULL, 'POL. IND. EL TOMILLAR NAVE 54', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959451002);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (227, '75 MECANICA', 1, NULL, 'Pol. Ind. El Tomillar, 27', 'Almonte', 21730, NULL, NULL, 'Maquinaria para jardineria', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451042);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (228, 'NUBLAN DE SERVICIOS SL', 1, NULL, 'CR ROCIO 1', 'Almonte', 21730, 9, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451101);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (229, 'CITRICOLA CONDADO, S.C. A.', 1, NULL, 'CRTA. ALMONTE - ROCIO, KM 9,5', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959451205);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (230, 'UCYMAX SL', 1, NULL, 'CR DEL ROCIO 450 BAJO.', 'Almonte', 21730, 23, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451298);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (231, 'SUREXPORT, S.C. A.', 1, NULL, 'P I MATALAGRANA, SN. CTRA ALMONTE-EL ROCIO', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959451550);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (232, 'ROALMAJO SL', 1, NULL, 'CR DEL ROCIO 190', 'Almonte', 21730, 1, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451808);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (233, 'CASA ROLDAN SL', 1, NULL, 'CR DEL ROCIO, 88', 'Almonte', 21730, 9, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451873, 959451825);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (234, 'AGROECOLOGIA DOÑANA SL', 1, NULL, 'CR EL ROCIO 95', 'Almonte', 21730, 42, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959407871, 959451827);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (235, 'DIAZ VIEJO CONSTRUCCIONES SLL', 1, NULL, 'CL LA FLAMENCA 14', 'Almonte', 21730, 33, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451833);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (236, 'ELECTRODOMESTICOS REALES SL.', 1, NULL, 'CR DEL ROCIO, 33', 'Almonte', 21730, 7, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', 959451889, 959451889);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (237, 'SOLUCIONES METALICAS BRICOLUZ SLL.', 1, NULL, 'PG INDUSTRIAL TOMILLAR - 52 PAR, 36', 'Almonte', 21730, 6, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451899);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (238, 'FERRALLAS ALMONTE SL', 1, NULL, 'CL POCITO 32 1 A.', 'Almonte', 21730, 40, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959451961);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (239, 'CAÑO GUAPERAL SL', 1, NULL, 'CL JUAN RAMON JIMENEZ 51', 'Almonte', 21730, 49, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959505022);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (240, 'DOÑANA FRESA SCA', 1, NULL, 'CTRA ALMONTE-HINOJOS SN', 'Almonte', 21730, NULL, NULL, 'Alimentación', NULL, NULL, NULL, NULL, 3, 'Huelva', NULL, 959506220);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (241, 'CRICABA E HIJOS SOCIEDAD LIMITADA', 1, NULL, 'CL REGAJO DE LAS PENILLAS 10', 'Almonte', 21730, 2, NULL, 'Construcción', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959507000);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (242, 'PALET Y MADERA ALMONTE SL', 1, NULL, 'CL ROCIANA 15', 'Almonte', 21730, 12, NULL, 'Comercio', NULL, NULL, NULL, NULL, 1, 'Huelva', NULL, 959508446);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (245, 'PURICON, S.C.A.', 1, 'B21485255', 'AVD. ANDALUCIA, S/N', 'Aguadulce', 41550, 10, 'www.pepe1.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000000, 954816604);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (246, 'SIERRA DEL AGUILA S. L.', 1, 'B21485255', 'CRT. GILENA AGUADULCE KM 1,6', 'Aguadulce', 41550, 15, 'www.pepe2.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000001, 955826288);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (247, 'SUROLIVA, SDAD. COOP. AND.', 1, 'B21485255', 'PROLONGACION CALLE SANTA ANA, S/N', 'Aguadulce', 41550, 20, 'www.pepe3.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000002, 954816204);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (248, 'CLORESUR, S.L.', 2, 'B21269980', 'PI TARTESSOS, C/B 40-41', 'HUELVA', 21007, 7, NULL, 'FABRICACION LEJIA', NULL, NULL, '9001+14001', 570, 5, 'HUELVA', NULL, 959367721);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (249, 'EXPROMAR, S.A.', 1, NULL, 'ALONSO DE OJEDA, S/N', 'HUELVA', 21002, NULL, NULL, 'ALIMENTACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959244999);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (250, 'NAUTICA AVANTE', 1, NULL, 'ALONSO DE OJEDA, 17', 'HUELVA', 21002, NULL, NULL, 'NAUTICO', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959541306);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (251, 'ANDALUZA DISTRIBUIDORA DE ACEITES, S.A.', 1, NULL, 'POLIGONO PESQUERO NORTE', 'HUELVA', 21002, NULL, NULL, 'DISTRIBUIDOR LUBRICANTES', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959283130);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (252, 'TODO GAS HUELVA, S.L.', 1, NULL, 'POLIGONO PESQUERO NORTE, S/N', 'HUELVA', 21002, NULL, NULL, 'INSTALADORES', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959282667);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (253, 'LOGISTICA PEÑALUZ, S.L.', 1, NULL, 'POLIGONO PESQUERO NORTE', 'HUELVA', 21002, NULL, NULL, 'TRANSPORTE', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959263104);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (254, 'ANTONETE, S.A.', 1, NULL, 'POLIGONO PESQUERO NORTE', 'HUELVA', 21002, NULL, NULL, 'ALIMENTACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959243443);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (255, 'PRODUCTOS NORA DE ALVARADO, S.L.', 1, 'B21225289', 'P.I. LAS YUCAS, S/N', 'HUELVA', 21002, 6, NULL, 'ALIMENTACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959154421);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (256, 'PANADERIA NUESTRA SEÑORA DE LA CINTA', 1, NULL, 'PI LAS YUCAS, NAVES 2-4', 'HUELVA', 21002, NULL, NULL, 'ALIMENTACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959150488);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (257, 'QUALIA SOLUTIONS', 2, NULL, NULL, 'HUELVA', 21002, NULL, NULL, 'CONSULTORIA FORMACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959280209);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (258, 'MAKINSUR, S.L.', 1, 'B21470810', 'P.I. TARTESSOS, C/C. 11', 'HUELVA', 21007, 3, NULL, 'ALQUILER MAQUINARIA', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959367681);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (259, 'LA FLOR DE LA CANELA, S.L.', 1, 'B21135827', 'C/GIBRALEON,61', 'AYAMONTE', 21400, NULL, NULL, 'ALIMENTACION', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959471298);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (260, 'NAUTICAS PUNTA UMBRIA, S.A.', 1, NULL, 'C/VARADERO, 2.', 'PUNTA UMBRIA', 21120, 5, NULL, 'NAUTICO', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959310700);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (261, 'MARINA UMBRIA', 1, NULL, 'AVDA VARADERO, S/N', 'PUNTA UMBRIA', 21120, NULL, NULL, 'NAUTICO', NULL, NULL, NULL, NULL, 1, 'HUELVA', NULL, 959315590);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (262, 'PURICON, S.C.A.', 1, 'B21485255', 'AVD. ANDALUCIA, S/N', 'Aguadulce', 41550, 10, 'www.pepe1.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000000, 954816604);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (263, 'SIERRA DEL AGUILA S. L.', 1, 'B21485255', 'CRT. GILENA AGUADULCE KM 1,6', 'Aguadulce', 41550, 15, 'www.pepe2.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000001, 955826288);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (264, 'SUROLIVA, SDAD. COOP. AND.', 1, 'B21485255', 'PROLONGACION CALLE SANTA ANA, S/N', 'Aguadulce', 41550, 20, 'www.pepe3.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000002, 954816204);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (265, 'PURICON, S.C.A.', 1, 'B21485255', 'AVD. ANDALUCIA, S/N', 'Aguadulce', 41550, 10, 'www.pepe1.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000000, 954816604);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (266, 'SIERRA DEL AGUILA S. L.', 1, 'B21485255', 'CRT. GILENA AGUADULCE KM 1,6', 'Aguadulce', 41550, 15, 'www.pepe2.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000001, 955826288);
INSERT INTO `clientes` (`id`, `razon_social`, `fk_tipo_cliente`, `NIF`, `domicilio`, `localidad`, `CP`, `numero_empleados`, `web`, `sector`, `SPA_actual`, `fecha_renovacion`, `norma_implantada`, `creditos`, `fk_grupo_empresas`, `provincia`, `FAX`, `telefono`) VALUES (267, 'SUROLIVA, SDAD. COOP. AND.', 1, 'B21485255', 'PROLONGACION CALLE SANTA ANA, S/N', 'Aguadulce', 41550, 20, 'www.pepe3.es', 'Agroalimentario', 'Antea', 1289343600, 'iso 9001', 3405, 1, 'Sevilla', 955000002, 954816204);

-- --------------------------------------------------------

-- 
-- Table structure for table `clientes_rel_contactos`
-- 

CREATE TABLE `clientes_rel_contactos` (
  `fk_cliente` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY  (`fk_cliente`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `clientes_rel_contactos`
-- 

INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (1, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (1, 1);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (2, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (3, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (4, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (5, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (6, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (7, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (8, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (9, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (10, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (11, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (12, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (13, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (14, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (15, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (16, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (17, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (18, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (19, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (20, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (21, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (22, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (23, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (24, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (25, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (26, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (27, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (28, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (29, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (30, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (31, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (32, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (33, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (34, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (35, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (36, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (37, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (38, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (39, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (40, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (41, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (42, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (43, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (44, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (45, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (46, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (47, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (48, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (49, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (50, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (51, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (52, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (53, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (54, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (55, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (56, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (57, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (58, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (59, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (60, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (61, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (62, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (63, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (64, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (65, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (66, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (67, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (68, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (69, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (70, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (71, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (72, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (73, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (74, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (75, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (76, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (77, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (78, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (79, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (80, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (81, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (82, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (83, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (84, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (85, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (86, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (87, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (88, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (89, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (90, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (91, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (92, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (93, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (94, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (95, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (96, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (97, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (98, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (99, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (100, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (101, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (102, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (103, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (104, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (105, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (106, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (107, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (108, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (109, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (110, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (111, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (112, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (113, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (114, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (115, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (116, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (117, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (118, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (119, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (120, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (121, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (122, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (123, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (124, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (125, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (125, 19);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (126, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (126, 22);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (127, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (128, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (129, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (130, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (130, 20);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (131, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (132, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (132, 21);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (133, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (134, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (135, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (136, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (137, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (138, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (139, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (140, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (141, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (142, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (143, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (144, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (145, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (146, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (147, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (148, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (149, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (150, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (151, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (152, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (153, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (154, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (155, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (156, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (157, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (158, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (159, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (161, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (162, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (163, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (164, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (165, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (166, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (167, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (168, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (169, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (170, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (171, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (172, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (173, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (174, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (175, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (176, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (177, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (178, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (179, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (180, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (181, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (182, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (184, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (185, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (186, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (187, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (188, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (189, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (190, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (191, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (192, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (193, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (194, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (195, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (196, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (197, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (198, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (199, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (200, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (201, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (202, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (203, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (205, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (206, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (207, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (208, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (209, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (210, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (211, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (212, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (213, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (214, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (215, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (216, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (217, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (218, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (219, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (220, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (221, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (222, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (223, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (224, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (226, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (227, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (228, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (229, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (230, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (231, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (232, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (233, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (234, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (235, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (236, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (237, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (238, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (239, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (240, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (241, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (242, 0);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (245, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (246, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (247, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (248, 5);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (249, 6);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (250, 7);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (251, 8);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (252, 9);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (253, 10);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (254, 11);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (255, 12);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (256, 13);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (257, 14);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (258, 15);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (259, 16);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (260, 17);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (261, 18);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (262, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (263, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (264, 3);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (265, 2);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (266, 4);
INSERT INTO `clientes_rel_contactos` (`fk_cliente`, `fk_contacto`) VALUES (267, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `clientes_rel_usuarios`
-- 

CREATE TABLE `clientes_rel_usuarios` (
  `fk_cliente` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `ha_insertado` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fk_cliente`,`fk_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `clientes_rel_usuarios`
-- 

INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (2, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (3, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (4, 'admin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (4, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (5, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (6, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (7, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (8, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (9, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (10, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (11, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (12, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (13, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (14, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (15, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (16, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (17, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (18, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (19, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (20, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (21, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (22, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (23, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (24, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (25, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (26, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (27, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (28, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (29, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (30, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (31, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (32, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (33, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (34, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (35, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (36, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (37, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (38, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (39, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (40, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (41, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (42, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (43, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (44, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (45, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (46, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (47, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (48, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (49, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (50, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (51, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (52, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (53, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (54, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (55, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (56, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (57, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (58, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (59, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (60, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (61, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (62, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (63, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (64, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (65, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (66, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (67, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (68, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (69, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (70, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (71, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (72, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (73, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (74, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (75, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (76, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (77, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (78, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (79, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (80, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (81, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (82, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (83, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (84, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (85, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (86, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (87, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (88, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (89, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (90, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (91, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (92, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (93, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (94, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (95, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (96, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (97, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (98, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (99, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (100, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (101, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (102, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (103, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (104, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (105, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (106, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (107, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (108, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (109, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (110, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (111, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (112, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (113, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (114, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (115, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (116, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (117, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (118, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (119, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (120, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (121, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (122, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (123, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (124, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (125, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (126, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (127, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (128, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (129, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (130, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (131, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (132, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (133, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (134, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (135, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (136, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (137, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (138, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (139, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (140, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (141, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (142, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (143, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (144, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (145, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (146, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (147, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (148, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (149, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (150, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (151, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (152, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (153, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (154, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (155, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (156, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (157, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (158, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (159, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (161, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (162, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (163, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (164, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (165, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (166, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (167, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (168, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (169, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (170, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (171, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (172, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (173, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (174, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (175, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (176, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (177, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (178, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (179, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (180, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (181, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (182, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (184, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (185, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (186, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (187, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (188, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (189, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (190, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (191, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (192, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (193, 'esther.martin', 0);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (193, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (194, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (195, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (196, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (197, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (198, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (199, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (200, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (201, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (202, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (203, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (205, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (206, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (207, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (208, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (209, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (210, 'esther.martin', 0);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (210, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (211, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (212, 'esther.martin', 0);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (212, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (213, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (214, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (215, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (216, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (217, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (218, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (219, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (220, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (221, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (222, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (223, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (224, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (226, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (227, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (228, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (229, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (230, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (231, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (232, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (233, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (234, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (235, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (236, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (237, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (238, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (239, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (240, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (241, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (242, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (245, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (246, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (247, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (248, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (249, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (250, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (251, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (252, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (253, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (254, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (255, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (256, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (257, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (258, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (259, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (260, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (261, 'esther.martin', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (262, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (263, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (264, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (265, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (266, 'jose.sanchez', 1);
INSERT INTO `clientes_rel_usuarios` (`fk_cliente`, `fk_usuario`, `ha_insertado`) VALUES (267, 'jose.sanchez', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `clientes_tipos`
-- 

CREATE TABLE `clientes_tipos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `clientes_tipos`
-- 

INSERT INTO `clientes_tipos` (`id`, `nombre`) VALUES (1, 'Potencial');
INSERT INTO `clientes_tipos` (`id`, `nombre`) VALUES (2, 'Cliente');

-- --------------------------------------------------------

-- 
-- Table structure for table `colaboradores`
-- 

CREATE TABLE `colaboradores` (
  `id` int(11) NOT NULL auto_increment,
  `razon_social` varchar(100) default NULL,
  `NIF` varchar(9) default NULL,
  `domicilio` varchar(100) default NULL,
  `localidad` varchar(45) default NULL,
  `provincia` varchar(45) default NULL,
  `CP` int(11) default NULL,
  `cc_pago_comisiones` varchar(45) default NULL,
  `comision` int(11) default NULL,
  `comision_por_renovacion` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `colaboradores`
-- 

INSERT INTO `colaboradores` (`id`, `razon_social`, `NIF`, `domicilio`, `localidad`, `provincia`, `CP`, `cc_pago_comisiones`, `comision`, `comision_por_renovacion`) VALUES (1, 'Ninguno', '', '', '', '', 0, '0', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `colaboradores_rel_contactos`
-- 

CREATE TABLE `colaboradores_rel_contactos` (
  `fk_colaborador` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY  (`fk_colaborador`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `colaboradores_rel_contactos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `contactos`
-- 

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(150) default NULL,
  `telefono` int(11) default NULL,
  `fax` int(11) default NULL,
  `movil` int(11) default NULL,
  `email` varchar(450) default NULL,
  `cargo` varchar(450) default NULL,
  `comision` int(11) default NULL,
  `comision_por_renovacion` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- 
-- Dumping data for table `contactos`
-- 

INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (1, 'CARMELO', NULL, NULL, NULL, NULL, 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (2, 'Pepe', 955000000, NULL, NULL, 'pepe1@hotmail.es', 'Gerente', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (3, 'Pepe', 955000002, NULL, NULL, 'pepe3@hotmail.es', 'Gerente', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (4, 'Pepe', 955000001, NULL, NULL, 'pepe2@hotmail.es', 'Gerente', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (5, 'JUAN JESUS VAZQUEZ NAVARRO', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (6, 'MARIO', NULL, NULL, NULL, NULL, 'ADMINISTRACION', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (7, 'VICENTE ACUÑA', NULL, NULL, NULL, NULL, 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (8, 'MIGUEL A MOLINA', 670644424, NULL, NULL, 'MOLINAH@ADASALUB.E.TELEFONICA.NET', NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (9, 'PACO', 959246558, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (10, 'ISABEL RODRIGUEZ', 620015727, NULL, NULL, 'ISABEL#BGSTRANS.COM', 'ADMINISTRACION', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (11, 'MANUEL ANTONETE', NULL, NULL, NULL, NULL, 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (12, 'MANUEL', NULL, NULL, NULL, NULL, 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (13, 'ROCIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (14, 'GERARDO JIMENEZ BOIXO', NULL, NULL, NULL, NULL, 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (15, 'INMACULADA', 637753238, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (16, 'ALEJANDRO', NULL, NULL, NULL, NULL, 'ADMINISTRACION', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (17, 'CRISANTO DIAZ', NULL, NULL, NULL, 'NAUTICASPUNTAUMBRIA@HOTMAIL.COM', 'GERENTE', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (18, 'JOSE LUIS BOZA', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (19, 'José Trigueros', NULL, NULL, NULL, NULL, 'Gerente (son dos gerentes)', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (20, 'Emilio Zarza', NULL, NULL, NULL, NULL, 'Rpble. Calidad', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (21, 'Pedro', 696422800, NULL, NULL, NULL, 'Gerente', NULL, NULL);
INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `fax`, `movil`, `email`, `cargo`, `comision`, `comision_por_renovacion`) VALUES (22, 'genérico', NULL, NULL, NULL, 'reserva@hotelcarabela.com', NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `facturas`
-- 

CREATE TABLE `facturas` (
  `id` int(10) unsigned NOT NULL auto_increment,
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
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `facturas`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `facturas_estados`
-- 

CREATE TABLE `facturas_estados` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `facturas_estados`
-- 

INSERT INTO `facturas_estados` (`id`, `nombre`) VALUES (1, 'Anulado');
INSERT INTO `facturas_estados` (`id`, `nombre`) VALUES (2, 'Pagado');
INSERT INTO `facturas_estados` (`id`, `nombre`) VALUES (3, 'Pendiente');

-- --------------------------------------------------------

-- 
-- Table structure for table `formas_de_pago`
-- 

CREATE TABLE `formas_de_pago` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `formas_de_pago`
-- 

INSERT INTO `formas_de_pago` (`id`, `nombre`) VALUES (1, 'pagaré');

-- --------------------------------------------------------

-- 
-- Table structure for table `grupos_empresas`
-- 

CREATE TABLE `grupos_empresas` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `grupos_empresas`
-- 

INSERT INTO `grupos_empresas` (`id`, `nombre`) VALUES (1, 'Ninguno');
INSERT INTO `grupos_empresas` (`id`, `nombre`) VALUES (3, 'RIA');
INSERT INTO `grupos_empresas` (`id`, `nombre`) VALUES (4, 'Restauracion');
INSERT INTO `grupos_empresas` (`id`, `nombre`) VALUES (5, 'QUIMICA');

-- --------------------------------------------------------

-- 
-- Table structure for table `ofertas`
-- 

CREATE TABLE `ofertas` (
  `codigo` varchar(10) default NULL,
  `nombre_oferta` varchar(450) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fk_estado_oferta` int(11) default NULL,
  `fk_tipo_producto` int(11) default NULL,
  `fk_proveedor` varchar(45) default NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_colaborador` int(11) default NULL,
  `fecha` int(11) NOT NULL,
  `importe` float default NULL,
  `probabilidad_contratacion` int(11) default NULL,
  `fecha_definicion` int(11) default NULL,
  `es_oportunidad_de_negocio` tinyint(1) default '0',
  `aceptado` tinyint(1) default '0',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `ofertas`
-- 

INSERT INTO `ofertas` (`codigo`, `nombre_oferta`, `fk_usuario`, `fk_estado_oferta`, `fk_tipo_producto`, `fk_proveedor`, `fk_cliente`, `fk_colaborador`, `fecha`, `importe`, `probabilidad_contratacion`, `fecha_definicion`, `es_oportunidad_de_negocio`, `aceptado`, `id`) VALUES ('4/2010', 'qwd', 'esther.martin', 2, 1, '0', 1, 1, 1288911600, 234, 1, 1288911600, 0, 1, 4);
INSERT INTO `ofertas` (`codigo`, `nombre_oferta`, `fk_usuario`, `fk_estado_oferta`, `fk_tipo_producto`, `fk_proveedor`, `fk_cliente`, `fk_colaborador`, `fecha`, `importe`, `probabilidad_contratacion`, `fecha_definicion`, `es_oportunidad_de_negocio`, `aceptado`, `id`) VALUES ('6/2010', 'wdcedsc', 'esther.martin', 2, 1, '0', 1, 1, 1288911600, 234, 1, 1288911600, 0, 1, 6);
INSERT INTO `ofertas` (`codigo`, `nombre_oferta`, `fk_usuario`, `fk_estado_oferta`, `fk_tipo_producto`, `fk_proveedor`, `fk_cliente`, `fk_colaborador`, `fecha`, `importe`, `probabilidad_contratacion`, `fecha_definicion`, `es_oportunidad_de_negocio`, `aceptado`, `id`) VALUES ('7/2010', 'asdasd', 'admin', 2, 1, '0', 1, 1, 1289084400, 345, 1, 1289430000, 0, 1, 7);
INSERT INTO `ofertas` (`codigo`, `nombre_oferta`, `fk_usuario`, `fk_estado_oferta`, `fk_tipo_producto`, `fk_proveedor`, `fk_cliente`, `fk_colaborador`, `fecha`, `importe`, `probabilidad_contratacion`, `fecha_definicion`, `es_oportunidad_de_negocio`, `aceptado`, `id`) VALUES ('190/2010', 'ISO 22000', 'esther.martin', 1, 8, '0', 255, 1, 1289862000, 5000, 2, 1290466800, 0, 0, 8);
INSERT INTO `ofertas` (`codigo`, `nombre_oferta`, `fk_usuario`, `fk_estado_oferta`, `fk_tipo_producto`, `fk_proveedor`, `fk_cliente`, `fk_colaborador`, `fecha`, `importe`, `probabilidad_contratacion`, `fecha_definicion`, `es_oportunidad_de_negocio`, `aceptado`, `id`) VALUES ('191/2010', '22000+14', 'esther.martin', 1, 8, '0', 255, 1, 1289862000, 7200, 1, 1290553200, 0, 0, 9);

-- --------------------------------------------------------

-- 
-- Table structure for table `ofertas_codigos_patch`
-- 

CREATE TABLE `ofertas_codigos_patch` (
  `id` int(11) NOT NULL auto_increment,
  `year` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `de_oportunidad` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `ofertas_codigos_patch`
-- 

INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (1, 2010, 1, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (2, 2010, 2, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (3, 2010, 3, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (4, 2010, 4, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (5, 2010, 5, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (6, 2010, 6, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (7, 2010, 7, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (8, 2010, 189, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (9, 2010, 190, 0);
INSERT INTO `ofertas_codigos_patch` (`id`, `year`, `numero`, `de_oportunidad`) VALUES (10, 2010, 191, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `ofertas_estados`
-- 

CREATE TABLE `ofertas_estados` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `ofertas_estados`
-- 

INSERT INTO `ofertas_estados` (`id`, `nombre`) VALUES (1, 'Pendiente');
INSERT INTO `ofertas_estados` (`id`, `nombre`) VALUES (2, 'Aceptado');
INSERT INTO `ofertas_estados` (`id`, `nombre`) VALUES (3, 'Anulado');
INSERT INTO `ofertas_estados` (`id`, `nombre`) VALUES (4, 'Rechazada');

-- --------------------------------------------------------

-- 
-- Table structure for table `ofertas_probabilidades`
-- 

CREATE TABLE `ofertas_probabilidades` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ofertas_probabilidades`
-- 

INSERT INTO `ofertas_probabilidades` (`id`, `nombre`) VALUES (1, 'baja');
INSERT INTO `ofertas_probabilidades` (`id`, `nombre`) VALUES (2, 'media');
INSERT INTO `ofertas_probabilidades` (`id`, `nombre`) VALUES (3, 'alta');

-- --------------------------------------------------------

-- 
-- Table structure for table `permisos_usuarios_perfiles`
-- 

CREATE TABLE `permisos_usuarios_perfiles` (
  `fk_perfil` int(11) NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  `lectura` tinyint(1) NOT NULL default '0',
  `escritura` tinyint(1) NOT NULL default '0',
  `administracion` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fk_perfil`,`fk_proceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `permisos_usuarios_perfiles`
-- 

INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES (1, 1, 1, 0, 0);
INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES (2, 1, 1, 0, 0);
INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES (3, 1, 1, 0, 0);
INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES (4, 1, 1, 0, 0);
INSERT INTO `permisos_usuarios_perfiles` (`fk_perfil`, `fk_proceso`, `lectura`, `escritura`, `administracion`) VALUES (5, 1, 1, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `plazos_estados`
-- 

CREATE TABLE `plazos_estados` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `plazos_estados`
-- 

INSERT INTO `plazos_estados` (`id`, `nombre`) VALUES (1, 'Pendiente');
INSERT INTO `plazos_estados` (`id`, `nombre`) VALUES (2, 'Aceptado');

-- --------------------------------------------------------

-- 
-- Table structure for table `procesos`
-- 

CREATE TABLE `procesos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(170) NOT NULL,
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `procesos`
-- 

INSERT INTO `procesos` (`id`, `nombre`, `descripcion`) VALUES (1, 'Proceso genérico', 'Proceso por defecto');

-- --------------------------------------------------------

-- 
-- Table structure for table `productos`
-- 

CREATE TABLE `productos` (
  `id` int(11) NOT NULL auto_increment,
  `fk_tipo_producto` int(11) NOT NULL,
  `denominacion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `productos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `productos_tipos`
-- 

CREATE TABLE `productos_tipos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `productos_tipos`
-- 

INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (1, 'Formación');
INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (2, 'SPA');
INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (3, 'LOPD');
INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (6, '9001');
INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (7, 'ISO9001');
INSERT INTO `productos_tipos` (`id`, `nombre`) VALUES (8, 'ISO 22000');

-- --------------------------------------------------------

-- 
-- Table structure for table `proveedores`
-- 

CREATE TABLE `proveedores` (
  `NIF` varchar(9) NOT NULL,
  `razon_social` varchar(100) default NULL,
  `localidad` varchar(45) default NULL,
  `CP` int(11) default NULL,
  `web` varchar(450) default NULL,
  `provincia` varchar(450) default NULL,
  `domicilio` varchar(450) default NULL,
  PRIMARY KEY  (`NIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `proveedores`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `proveedores_rel_contactos`
-- 

CREATE TABLE `proveedores_rel_contactos` (
  `fk_proveedor` varchar(45) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY  (`fk_proveedor`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `proveedores_rel_contactos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `scripts`
-- 

CREATE TABLE `scripts` (
  `id` int(3) NOT NULL auto_increment,
  `ruta` varchar(250) collate utf8_spanish_ci NOT NULL,
  `menu` varchar(25) collate utf8_spanish_ci NOT NULL default 'inicio',
  `descripcion` varchar(250) collate utf8_spanish_ci NOT NULL,
  `fk_proceso` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ruta` (`ruta`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=44 ;

-- 
-- Dumping data for table `scripts`
-- 

INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (1, '/index.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (3, '/Autentificacion/Logout.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (4, '/Usuarios/infoUsuario.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (5, '/Usuarios/AtajosUsuario.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (6, '/Clientes/searchClientes.php', 'clientes', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (8, '/Usuario/controlTareas.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (9, '/Clientes/addCliente.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (10, '/Clientes/showCliente.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (11, '/Clientes/editCliente.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (12, '/Clientes/busquedaHistorial.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (13, '/Clientes/editContactos.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (14, '/Clientes/addClientes.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (15, '/Clientes/addGestores.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (16, '/Llamadas/incidenciasCliente.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (17, '/Clientes/addAccion.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (18, '/Clientes/addOferta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (19, '/Clientes/showOferta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (20, '/Clientes/showAccion.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (21, '/Ofertas/searchOfertas.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (22, '/Ventas/searchVentas.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (23, '/Acciones/searchAcciones.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (24, '/Acciones/reportsAcciones.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (25, '/Ofertas/reportsOfertas.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (26, '/Colaboradores/searchColaboradores.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (27, '/Colaboradores/addColaborador.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (28, '/Proveedores/searchProveedores.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (29, '/Proveedores/addProveedor.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (30, '/Administracion/gestionUsuarios.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (31, '/Administracion/gestionGrupos.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (32, '/Administracion/gestionTiposProducto.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (33, '/Administracion/gestionTiposAccion.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (34, '/Administracion/gestionTiposFormasDePago.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (35, '/Administracion/gestionTiposComision.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (36, '/Facturas/searchFacturas.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (37, '/Acciones/addAccion.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (38, '/Acciones/showAccion.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (39, '/Ofertas/addOferta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (40, '/Ofertas/showOferta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (41, '/Ofertas/editOferta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (42, '/Ventas/addVenta.php', 'inicio', '', 1);
INSERT INTO `scripts` (`id`, `ruta`, `menu`, `descripcion`, `fk_proceso`) VALUES (43, '/Ventas/showVenta.php', 'inicio', '', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `tipos_comision`
-- 

CREATE TABLE `tipos_comision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tipos_comision`
-- 

INSERT INTO `tipos_comision` (`id`, `nombre`) VALUES (1, 'tipo1');

-- --------------------------------------------------------

-- 
-- Table structure for table `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id` varchar(15) NOT NULL,
  `nombre` varchar(45) default NULL,
  `password` varchar(450) default NULL,
  `fk_perfil` int(11) default NULL,
  `apellidos` varchar(100) default NULL,
  `email` varchar(450) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `usuarios`
-- 

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `fk_perfil`, `apellidos`, `email`) VALUES ('admin', 'admin', 'admin', 5, 'admin', 'doros@doros.es');
INSERT INTO `usuarios` (`id`, `nombre`, `password`, `fk_perfil`, `apellidos`, `email`) VALUES ('alvaro.giles', 'Álvaro', 'agiles', 4, 'Giles', 'alvaro.giles@doros.es');
INSERT INTO `usuarios` (`id`, `nombre`, `password`, `fk_perfil`, `apellidos`, `email`) VALUES ('esther.martin', 'Esther', 'emartin', 1, 'Martin', 'esther.martin@doros.es');
INSERT INTO `usuarios` (`id`, `nombre`, `password`, `fk_perfil`, `apellidos`, `email`) VALUES ('jose.sanchez', 'José', 'jsanchez', 4, 'Sánchez', 'jose.sanchez@doros.es');

-- --------------------------------------------------------

-- 
-- Table structure for table `usuarios_objetivos`
-- 

CREATE TABLE `usuarios_objetivos` (
  `fk_usuario` varchar(15) NOT NULL,
  `mes` int(11) NOT NULL,
  `objetivo` varchar(45) NOT NULL,
  PRIMARY KEY  (`fk_usuario`,`mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `usuarios_objetivos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `usuarios_perfiles`
-- 

CREATE TABLE `usuarios_perfiles` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `usuarios_perfiles`
-- 

INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (1, 'Comercial');
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (2, 'Televendedor');
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (3, 'Técnico');
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (4, 'Gerente');
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (5, 'Administrador');

-- --------------------------------------------------------

-- 
-- Table structure for table `usuarios_rel_atajos`
-- 

CREATE TABLE `usuarios_rel_atajos` (
  `fk_usuario` varchar(15) collate utf8_spanish_ci NOT NULL,
  `fk_atajo` int(5) NOT NULL,
  PRIMARY KEY  (`fk_usuario`,`fk_atajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- 
-- Dumping data for table `usuarios_rel_atajos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `ventas`
-- 

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL auto_increment,
  `fk_oferta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_aceptado` int(11) default NULL,
  `fecha_asignacion_tecnico` int(11) NOT NULL,
  `formacion_bonificada` tinyint(1) default NULL,
  `fecha_entrada_vigor` int(11) default NULL,
  `fk_forma_pago` int(11) NOT NULL,
  `fk_tipo_comision` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `ventas`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `ventas_plazos`
-- 

CREATE TABLE `ventas_plazos` (
  `id` int(11) NOT NULL auto_increment,
  `fecha` int(11) NOT NULL,
  `fk_venta` int(11) NOT NULL,
  `fk_estado` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `ventas_plazos`
-- 

INSERT INTO `ventas_plazos` (`id`, `fecha`, `fk_venta`, `fk_estado`) VALUES (1, 1288911600, 1, 1);
INSERT INTO `ventas_plazos` (`id`, `fecha`, `fk_venta`, `fk_estado`) VALUES (2, 1288911600, 2, 1);
INSERT INTO `ventas_plazos` (`id`, `fecha`, `fk_venta`, `fk_estado`) VALUES (3, 1289516400, 3, 1);
INSERT INTO `ventas_plazos` (`id`, `fecha`, `fk_venta`, `fk_estado`) VALUES (4, 1289343600, 4, 1);

