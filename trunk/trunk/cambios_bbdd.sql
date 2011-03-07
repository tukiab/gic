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
  `localidad` varchar(45) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `provincia` varchar(15) NOT NULL,
  `direccion` varchar(400) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `clientes_sedes_rel_contactos` (
  `fk_clientes_sede` int(11) NOT NULL,
  `fk_contacto` int(11) NOT NULL,
  PRIMARY KEY (`fk_clientes_sede`,`fk_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Perfiles
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (NULL, 'Director Técnico');
INSERT INTO `usuarios_perfiles` (`id`, `nombre`) VALUES (NULL, 'Director Comercial');

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
  `fk_usuario` int(11) NOT NULL,
  `fk_tipo_comision` int(10) NOT NULL,
  `comision` float NOT NULL,
  PRIMARY KEY (`fk_usuario`,`fk_tipo_comision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `usuarios_rel_objetivos_mensuales` (
  `fk_usuario` int(11) NOT NULL,
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
  `fk_usuario` int(11) NOT NULL,
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