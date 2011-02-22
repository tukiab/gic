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