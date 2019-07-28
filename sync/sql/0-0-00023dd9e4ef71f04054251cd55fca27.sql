TRUNCATE sync_up;

INSERT INTO `sync_up` (`id`, `tabla`, `edo`, `td`) VALUES
('', 'alter_materiaprima_reporte', 0, 1),
('', 'alter_opciones', 0, 1),
('', 'alter_producto_reporte', 0, 1),
('', 'categorias', 0, 1),
('', 'config_master', 0, 1),
('', 'config_root', 0, 1),
('', 'control_cocina', 0, 1),

('', 'control_panel_mostrar', 0, 1),
('', 'corte_diario', 0, 1),
('', 'facturar_cai', 0, 1),
('', 'facturar_impresora', 0, 1),
('', 'facturar_rtn', 0, 1),
('', 'facturar_rtn_cliente', 0, 1),
('', 'facturar_ticket', 0, 1),
('', 'facturar_users', 0, 1),

('', 'gastos', 1, 1),
('', 'gastos_images', 0, 1),
('', 'images', 0, 1),
('', 'mesa', 1, 1),
('', 'mesa_nombre', 1, 1),
('', 'opciones', 0, 1),
('', 'opciones_asig', 0, 1),
('', 'opciones_name', 0, 1),
('', 'opciones_ticket', 0, 1),

('', 'precios', 0, 1),
('', 'producto', 0, 1),
('', 'productos_venta_especial', 0, 1),
('', 'pro_asignado', 0, 1),
('', 'pro_bruto', 0, 1),
('', 'pro_dependiente', 0, 1),
('', 'pro_historial_addpro', 0, 1),
('', 'pro_historial_averias', 0, 1),
('', 'pro_registro_averia', 0, 1),
('', 'pro_registro_up', 0, 1),
('', 'pro_unidades_medida', 0, 1),

('', 'sync', 0, 1),
('', 'sync_status', 0, 1),
('', 'sync_up', 0, 1),
('', 'ticket', 1, 1),
('', 'ticket_num', 1, 1),
('', 'ticket_propina', 0, 1);

UPDATE `sync_up` SET `td`= (SELECT td FROM config_root WHERE id=1) WHERE td = 1;
