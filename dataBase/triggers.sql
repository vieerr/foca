-------------------------------------------------------
-- Triggers para Roles
-------------------------------------------------------
DELIMITER $$
-- Trigger para INSERT en la tabla Roles
CREATE TRIGGER `Roles_Auditoria_Insert` AFTER INSERT ON `Roles`
FOR EACH ROW
BEGIN
  INSERT INTO `RC5`.`Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('INSERT', 'Roles', NEW.id_rol, @usuario_activo, NOW(), CONCAT('Nuevo rol creado: ', NEW.nombre_rol));
END$$

-- Trigger para UPDATE en la tabla Roles
CREATE TRIGGER `Roles_Auditoria_Update` AFTER UPDATE ON `Roles`
FOR EACH ROW
BEGIN
  INSERT INTO `RC5`.`Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('UPDATE', 'Roles', NEW.id_rol, @usuario_activo, NOW(), CONCAT('Rol actualizado: ', NEW.nombre_rol));
END$$
DELIMITER ;

-------------------------------------------------------
-- Triggers para Registros
-------------------------------------------------------
DELIMITER $$
-- Trigger para INSERT en la tabla Registros
CREATE TRIGGER `Registros_Auditoria_Insert` AFTER INSERT ON `Registros`
FOR EACH ROW
BEGIN
  INSERT INTO `RC5`.`Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('INSERT', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Nuevo registro creado: ', NEW.id_registro));
END$$

-- Trigger combinado para UPDATE en la tabla Registros
CREATE TRIGGER `Registros_Auditoria_Update` AFTER UPDATE ON `Registros`
FOR EACH ROW
BEGIN
  -- Se registra la actualización general del registro
  INSERT INTO `RC5`.`Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('UPDATE', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Registro actualizado: ', NEW.nombre_registro));
  
  -- Si el estado cambió, se registra el cambio de estado
  IF OLD.estado_registro != NEW.estado_registro THEN  
    INSERT INTO `RC5`.`Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('UPDATE', 'Registros', NEW.id_registro, @usuario_activo, NOW(), CONCAT('Estado del registro actualizado: ', NEW.estado_registro));
  END IF;
END$$
DELIMITER ;

-------------------------------------------------------
-- Triggers para Usuarios
-------------------------------------------------------
DELIMITER $$
-- Trigger para INSERT en la tabla Usuarios
CREATE TRIGGER `Usuarios_Auditoria_Insert` AFTER INSERT ON `Usuarios`
FOR EACH ROW
BEGIN
  INSERT INTO `RC5`.`Auditoria` 
    (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
  VALUES 
    ('INSERT', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), 
     CONCAT('Nuevo usuario creado: ', NEW.nombre_usuario, ' ', NEW.apellido_usuario));
END$$

-- Trigger para UPDATE en la clave foránea id_rol en Usuarios
CREATE TRIGGER `Usuarios_Auditoria_Update_Rol` AFTER UPDATE ON `Usuarios`
FOR EACH ROW
BEGIN
  IF OLD.id_rol != NEW.id_rol THEN
    INSERT INTO `RC5`.`Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('UPDATE', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), 'Cambio de rol');
  END IF;
END$$

-- Trigger para UPDATE en el campo estado_usuario en Usuarios
CREATE TRIGGER `Usuarios_Auditoria_Update_Estado` AFTER UPDATE ON `Usuarios`
FOR EACH ROW
BEGIN
  IF OLD.estado_usuario != NEW.estado_usuario THEN
    INSERT INTO `RC5`.`Auditoria` 
      (accion, tabla_afectada, id_registro_afectado, id_usuario, fecha_hora, detalles)
    VALUES 
      ('UPDATE', 'Usuarios', NEW.id_usuario, @usuario_activo, NOW(), CONCAT('Estado actualizado: ', NEW.estado_usuario));
  END IF;
END$$
DELIMITER ;
