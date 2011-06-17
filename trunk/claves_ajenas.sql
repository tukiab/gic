DROP TABLE alumnos;
-- claves ajenas

--acciones de trabajo
ALTER TABLE  `acciones_de_trabajo` ADD INDEX (  `fk_tipo_accion` );
ALTER TABLE  `acciones_de_trabajo` ADD INDEX (`fk_cliente`);
ALTER TABLE  `acciones_de_trabajo` ADD INDEX (`fk_usuario`);

ALTER TABLE `acciones_de_trabajo`
  ADD CONSTRAINT `acciones_de_trabajo_tipo_accion` FOREIGN KEY (`fk_tipo_accion`) REFERENCES `acciones_tipos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `acciones_de_trabajo_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `acciones_de_trabajo_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--clientes
ALTER TABLE `clientes` ADD INDEX (  `fk_tipo_cliente` );
ALTER TABLE `clientes` ADD CONSTRAINT `clientes_tipo_cliente` FOREIGN KEY (`fk_tipo_cliente`) REFERENCES `clientes_tipos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--clientes_rel_contactos
DELETE FROM clientes_rel_contactos WHERE fk_contacto=0;
ALTER TABLE `clientes_rel_contactos` ADD INDEX (  `fk_cliente` );
ALTER TABLE `clientes_rel_contactos` ADD INDEX (  `fk_contacto` );

ALTER TABLE `clientes_rel_contactos`
  ADD CONSTRAINT `clientes_rel_contactos_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--clientes_rel_usuarios
ALTER TABLE `clientes_rel_usuarios` ADD INDEX (  `fk_cliente` );
ALTER TABLE `clientes_rel_usuarios` ADD INDEX (  `fk_usuario` );

ALTER TABLE `clientes_rel_usuarios`
  ADD CONSTRAINT `clientes_rel_usuarios_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_rel_usuarios_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--clientes_rel_usuarios
ALTER TABLE `clientes_rel_usuarios` ADD INDEX (  `fk_cliente` );
ALTER TABLE `clientes_rel_usuarios` ADD INDEX (  `fk_usuario` );

ALTER TABLE `clientes_rel_usuarios`
  ADD CONSTRAINT `clientes_rel_usuarios_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_rel_usuarios_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--clientes_sedes
DELETE FROM `clientes_sedes` WHERE clientes_sedes.fk_cliente NOT IN (select id FROM clientes);
ALTER TABLE `clientes_sedes` ADD INDEX (  `fk_cliente` );
ALTER TABLE `clientes_sedes`
  ADD CONSTRAINT `clientes_sedes_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--clientes_sedes_rel_contactos
ALTER TABLE `clientes_sedes_rel_contactos` ADD INDEX (  `fk_clientes_sede` );
ALTER TABLE `clientes_sedes_rel_contactos` ADD INDEX (  `fk_contacto` );

ALTER TABLE `clientes_sedes_rel_contactos`
  ADD CONSTRAINT `clientes_sedes_rel_contactos_cliente` FOREIGN KEY (`fk_clientes_sede`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_sedes_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--colaboradores_rel_contactos
ALTER TABLE `colaboradores_rel_contactos` ADD INDEX (  `fk_colaborador` );
ALTER TABLE `colaboradores_rel_contactos` ADD INDEX (  `fk_contacto` );
ALTER TABLE `colaboradores_rel_contactos`
  ADD CONSTRAINT `colaboradores_rel_contactos_colaborador` FOREIGN KEY (`fk_colaborador`) REFERENCES `colaboradores` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `colaboradores_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE

--facturas
ALTER TABLE `facturas` ADD INDEX (  `fk_cliente` );
ALTER TABLE `facturas` ADD INDEX (  `fk_venta` );
ALTER TABLE `facturas` ADD INDEX (  `fk_estado_factura` );

ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `facturas_venta` FOREIGN KEY (`fk_venta`) REFERENCES `ventas` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `facturas_estado_factura` FOREIGN KEY (`fk_estado_factura`) REFERENCES `facturas_estados` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--ofertas
ALTER TABLE  `proveedores` DROP PRIMARY KEY;
ALTER TABLE  `proveedores` ADD  `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE  `ofertas` CHANGE  `fk_proveedor`  `fk_proveedor` INT( 11 ) NULL DEFAULT NULL;
INSERT INTO  `proveedores` (`id`, `NIF`, `razon_social`, `localidad`, `CP`, `web`, `provincia`, `domicilio`) VALUES ('1', '', 'Ninguno', NULL, NULL, NULL, NULL, NULL);
UPDATE `ofertas` SET fk_proveedor = '1' WHERE fk_proveedor = '0';



ALTER TABLE `ofertas` ADD INDEX (  `fk_cliente` );
ALTER TABLE `ofertas` ADD INDEX (  `fk_usuario` );
ALTER TABLE `ofertas` ADD INDEX (  `fk_estado_oferta` );
ALTER TABLE `ofertas` ADD INDEX (  `fk_tipo_producto` );
ALTER TABLE `ofertas` ADD INDEX (  `fk_proveedor` );
ALTER TABLE `ofertas` ADD INDEX (  `fk_colaborador` );



ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_estado_oferta` FOREIGN KEY (`fk_estado_oferta`) REFERENCES `ofertas_estados` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_tipo_producto` FOREIGN KEY (`fk_tipo_producto`) REFERENCES `productos_tipos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_proveedor` FOREIGN KEY (`fk_proveedor`) REFERENCES `proveedores` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_colaborador` FOREIGN KEY (`fk_colaborador`) REFERENCES `colaboradores` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,

--proveedores_rel_contactos
ALTER TABLE  `proveedores_rel_contactos` CHANGE  `fk_proveedor`  `fk_proveedor` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `proveedores_rel_contactos` ADD INDEX (  `fk_proveedor` );
ALTER TABLE `proveedores_rel_contactos` ADD INDEX (  `fk_contacto` );

ALTER TABLE `proveedores_rel_contactos`
  ADD CONSTRAINT `proveedores_rel_contactos_proveedor` FOREIGN KEY (`fk_proveedor`) REFERENCES `proveedores` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `proveedores_rel_contactos_contacto` FOREIGN KEY (`fk_contacto`) REFERENCES `contactos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--proyectos
update proyectos set fk_venta=NUlL where fk_venta=0;

ALTER TABLE `proyectos` ADD INDEX (  `fk_cliente` );
ALTER TABLE `proyectos` ADD INDEX (  `fk_usuario` );
ALTER TABLE `proyectos` ADD INDEX (  `fk_estado` );
ALTER TABLE `proyectos` ADD INDEX (  `fk_venta` );

ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_cliente` FOREIGN KEY (`fk_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `proyectos_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `proyectos_estado` FOREIGN KEY (`fk_estado`) REFERENCES `proyectos_estados` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `proyectos_venta` FOREIGN KEY (`fk_venta`) REFERENCES `ventas` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--proyectos_rel_sedes
ALTER TABLE `proyectos_rel_sedes` ADD INDEX (  `fk_proyecto` );
ALTER TABLE `proyectos_rel_sedes` ADD INDEX (  `fk_sede` );

ALTER TABLE`proyectos_rel_sedes`
  ADD CONSTRAINT`proyectos_rel_sedes_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT`proyectos_rel_sedes_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--tareas_tecnicas
ALTER TABLE `tareas_tecnicas` ADD INDEX (  `fk_proyecto` );
ALTER TABLE `tareas_tecnicas` ADD INDEX (  `fk_sede` );
ALTER TABLE `tareas_tecnicas` ADD INDEX (  `fk_tipo` );
ALTER TABLE `tareas_tecnicas` ADD INDEX (  `fk_usuario` );

ALTER TABLE `tareas_tecnicas`
  ADD CONSTRAINT `tareas_tecnicas_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_tecnicas_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_tecnicas_tipo` FOREIGN KEY (`fk_tipo`) REFERENCES `tareas_tecnicas_tipos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_tecnicas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--usuarios
ALTER TABLE `usuarios` ADD INDEX (`fk_perfil`);
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_perfil` FOREIGN KEY (`fk_perfil`) REFERENCES `usuarios_perfiles` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--usuarios_departamentos_rel_objetivos_mensuales
ALTER TABLE `usuarios_departamentos_rel_objetivos_mensuales` ADD INDEX (  `fk_departamento` );
ALTER TABLE `usuarios_departamentos_rel_objetivos_mensuales` ADD INDEX (  `fk_objetivo` );

ALTER TABLE `usuarios_departamentos_rel_objetivos_mensuales`
  ADD CONSTRAINT `usuarios_departamentos_rel_objetivos_mensuales_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_departamentos_rel_objetivos_mensuales_objetivo` FOREIGN KEY (`fk_objetivo`) REFERENCES `usuarios_objetivos_mensuales` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--usuarios_departamentos_rel_penalizaciones
ALTER TABLE `usuarios_departamentos_rel_penalizaciones` ADD INDEX (  `fk_departamento` );
ALTER TABLE `usuarios_departamentos_rel_penalizaciones` ADD INDEX (  `fk_penalizacion` );

ALTER TABLE `usuarios_departamentos_rel_penalizaciones`
  ADD CONSTRAINT `usuarios_departamentos_rel_penalizaciones_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_departamentos_rel_penalizaciones_penalizacion` FOREIGN KEY (`fk_penalizacion`) REFERENCES `usuarios_penalizaciones` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


--usuarios_departamentos_rel_tipos_comision
ALTER TABLE  `tipos_comision` CHANGE  `id`  `id` INT( 10 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios_departamentos_rel_tipos_comision` ADD INDEX (  `fk_departamento` );
ALTER TABLE `usuarios_departamentos_rel_tipos_comision` ADD INDEX (  `fk_tipo_comision` );

ALTER TABLE `usuarios_departamentos_rel_tipos_comision`
  ADD CONSTRAINT `usuarios_departamentos_rel_tipos_comision_departamento` FOREIGN KEY (`fk_departamento`) REFERENCES `usuarios_departamentos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_departamentos_rel_tipos_comision_tipo_comision` FOREIGN KEY (`fk_tipo_comision`) REFERENCES `tipos_comision` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

-- atajos
drop table atajos;
drop table usuarios_rel_atajos;

-- usuarios_rel_objetivos_mensuales
ALTER TABLE `usuarios_rel_objetivos_mensuales` ADD INDEX (  `fk_usuario` );
ALTER TABLE `usuarios_rel_objetivos_mensuales` ADD INDEX (  `fk_objetivo` );

ALTER TABLE `usuarios_rel_objetivos_mensuales`
  ADD CONSTRAINT `usuarios_rel_objetivos_mensuales_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_rel_objetivos_mensuales_objetivo` FOREIGN KEY (`fk_objetivo`) REFERENCES `usuarios_objetivos_mensuales` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

-- usuarios_rel_penalizaciones
ALTER TABLE `usuarios_rel_penalizaciones` ADD INDEX (  `fk_usuario` );
ALTER TABLE `usuarios_rel_penalizaciones` ADD INDEX (  `fk_penalizacion` );

ALTER TABLE `usuarios_rel_penalizaciones`
  ADD CONSTRAINT `usuarios_rel_penalizaciones_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_rel_penalizaciones_penalizacion` FOREIGN KEY (`fk_penalizacion`) REFERENCES `usuarios_penalizaciones` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

-- usuarios_rel_tipos_comision
ALTER TABLE `usuarios_rel_tipos_comision` ADD INDEX (  `fk_usuario` );
ALTER TABLE `usuarios_rel_tipos_comision` ADD INDEX (  `fk_tipo_comision` );

ALTER TABLE `usuarios_rel_tipos_comision`
  ADD CONSTRAINT `usuarios_rel_tipos_comision_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_rel_tipos_comision_tipo_comision` FOREIGN KEY (`fk_tipo_comision`) REFERENCES `tipos_comision` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--ventas
ALTER TABLE `ventas` ADD INDEX (`fk_oferta`);

ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_oferta` FOREIGN KEY (`fk_oferta`) REFERENCES `ofertas` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--visitas
ALTER TABLE `visitas` ADD INDEX (`fk_proyecto`);
ALTER TABLE `visitas` ADD INDEX (`fk_usuario`);
ALTER TABLE `visitas` ADD INDEX (`fk_sede`);

ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_proyecto` FOREIGN KEY (`fk_proyecto`) REFERENCES `proyectos` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `visitas_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `visitas_sede` FOREIGN KEY (`fk_sede`) REFERENCES `clientes_sedes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;