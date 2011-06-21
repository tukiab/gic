-- acciones de trabajo
ALTER TABLE acciones_de_trabajo
	ADD nombre_tipo_accion varchar(45) NOT NULL AFTER fk_tipo_accion,
	ADD razon_social_cliente varchar(400) NOT NULL AFTER fk_cliente;
UPDATE acciones_de_trabajo SET nombre_tipo_accion= (SELECT nombre FROM acciones_tipos WHERE id = acciones_de_trabajo.fk_tipo_accion),
 razon_social_cliente=(SELECT razon_social FROM clientes WHERE clientes.id = acciones_de_trabajo.fk_cliente) ;

-- clientes
ALTER TABLE clientes
	ADD nombre_tipo_cliente VARCHAR(45) NOT NULL AFTER fk_tipo_cliente,
	ADD nombre_grupo_empresas VARCHAR(45) NOT NULL AFTER fk_grupo_empresas;
UPDATE clientes SET nombre_tipo_cliente=(SELECT nombre FROM clientes_tipos WHERE clientes_tipos.id=clientes.fk_tipo_cliente),
	nombre_grupo_empresas=(SELECT nombre FROM grupos_empresas WHERE grupos_empresas.id = clientes.fk_grupo_empresas);

