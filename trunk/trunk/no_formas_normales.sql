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

-- ofertas
ALTER TABLE ofertas
	ADD nombre_estado_oferta varchar(45) NOT NULl after fk_estado_oferta,
	ADD nombre_tipo_producto varchar(45) NOT NULl after fk_tipo_producto,
	ADD razon_social_proveedor varchar(100) NOT NULl after fk_proveedor,
	ADD razon_social_cliente varchar(400) NOT NULl after fk_cliente,
	ADD nombre_probabilidad varchar(45) NOT NULl after probabilidad_contratacion,
	ADD razon_social_colaborador varchar(100) NOT NULl after fk_colaborador;
UPDATE ofertas SET
	nombre_estado_oferta= (SELECT nombre FROM ofertas_estados WHERE id=ofertas.fk_estado_oferta),
	nombre_tipo_producto=(SELECT nombre FROM productos_tipos WHERE id=ofertas.fk_tipo_producto),
	razon_social_proveedor=(SELECT razon_social FROM proveedores WHERE id=ofertas.fk_proveedor),
	nombre_probabilidad=(SELECT nombre FROM ofertas_probabilidades WHERE id=ofertas.probabilidad_contratacion),
	razon_social_cliente=(SELECT razon_social FROM clientes WHERE id=ofertas.fk_cliente),
	razon_social_colaborador=(SELECT razon_social FROM colaboradores WHERE id=ofertas.fk_colaborador);

--tareas_tecnicas
ALTER TABLE tareas_tecnicas
	ADD nombre_proyecto VARCHAR(500) NOT NULL AFTER fk_proyecto,
	ADD localidad_sede VARCHAR(45) NOT NULL AFTER fk_sede,
	ADD nombre_tipo VARCHAR(45) NOT NULL AFTER fk_tipo;
UPDATE tareas_tecnicas SET nombre_proyecto=(SELECT nombre FROM proyectos WHERE proyectos.id=tareas_tecnicas.fk_proyecto),
localidad_sede=(SELECT localidad FROM clientes_sedes WHERE clientes_sedes.id = tareas_tecnicas.fk_sede),
nombre_tipo=(SELECT nombre FROM tareas_tecnicas_tipos WHERE tareas_tecnicas_tipos.id=tareas_tecnicas.fk_tipo);

--proyectos
ALTER TABLE proyectos
	ADD razon_social_cliente VARCHAR(400) NOT NULL AFTER fk_cliente,
	ADD nombre_estado VARCHAR(45) NOT NULL AFTER fk_estado,
	ADD precio_consultoria_venta FLOAT NULL AFTER fk_venta,
	ADD precio_formacion_venta FLOAT NULL AFTER precio_consultoria_venta;
UPDATE proyectos SET razon_social_cliente=(SELECT razon_social FROM clientes WHERE clientes.id = proyectos.fk_cliente),
nombre_estado=(SELECT nombre FROM proyectos_estados WHERE proyectos_estados.id=proyectos.fk_estado),
precio_consultoria_venta=(SELECT precio_consultoria FROM ventas WHERE ventas.id=proyectos.fk_venta),
precio_formacion_venta=(SELECT precio_formacion FROM ventas WHERE ventas.id=proyectos.fk_venta);