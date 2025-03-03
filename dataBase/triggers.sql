
DELIMITER $$

CREATE TRIGGER `Roles_Auditoria_Insert` AFTER INSERT ON `Roles`
FOR EACH ROW
BEGIN
  INSERT INTO `Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('Crear', 'Roles', NEW.id_rol, @usuario_activo, NOW(), CONCAT('Nuevo rol creado: ', NEW.nombre_rol));
END$$

CREATE TRIGGER `Roles_Auditoria_Update` AFTER UPDATE ON `Roles`
FOR EACH ROW
BEGIN
  INSERT INTO `Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('Actualizar', 'Roles', NEW.id_rol, @usuario_activo, NOW(), CONCAT('Rol actualizado: ', NEW.nombre_rol));
END$$

-- Triggers para Registros
CREATE TRIGGER `Registros_Auditoria_Insert` AFTER INSERT ON `Registros`
FOR EACH ROW
BEGIN
  INSERT INTO `Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('Crear', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Nuevo registro creado: ', NEW.id_registro));
END$$

CREATE TRIGGER `Registros_Auditoria_Update` AFTER UPDATE ON `Registros`
FOR EACH ROW
BEGIN
  INSERT INTO `Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('Actualizar', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Registro actualizado: ', NEW.nombre_registro));
  
  IF OLD.estado_registro != NEW.estado_registro THEN  
    INSERT INTO `Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('Actualizar', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Estado del registro actualizado: ', NEW.estado_registro));
  END IF;
END$$

-- Triggers para Usuarios
CREATE TRIGGER `Usuarios_Auditoria_Insert` AFTER INSERT ON `Usuarios`
FOR EACH ROW
BEGIN
  INSERT INTO `Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('Crear', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), 
     CONCAT('Nuevo usuario creado: ', NEW.nombre_usuario, ' ', NEW.apellido_usuario));
END$$

CREATE TRIGGER `Usuarios_Auditoria_Update_Rol` AFTER UPDATE ON `Usuarios`
FOR EACH ROW
BEGIN
  IF OLD.id_rol != NEW.id_rol THEN
    INSERT INTO `Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('Actualizar', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), 'Cambio de rol');
  END IF;
END$$

CREATE TRIGGER `Usuarios_Auditoria_Update_Estado` AFTER UPDATE ON `Usuarios`
FOR EACH ROW
BEGIN
  IF OLD.estado_usuario != NEW.estado_usuario THEN
    INSERT INTO `Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('Actualizar', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), CONCAT('Estado actualizado: ', NEW.estado_usuario));
  END IF;
END$$

DELIMITER ;