# Documentación del Esquema RC5

Este documento describe cada una de las tablas definidas en el esquema **RC5** de la base de datos, detallando su propósito, estructura y cómo utilizarlas dentro de la aplicación.

---

## 1. Tabla `Roles`

**Descripción:**  
La tabla `Roles` almacena la información relacionada con los distintos roles que pueden tener los usuarios. Cada rol define un conjunto de permisos y establece el nivel de acceso o responsabilidad dentro del sistema.

**Estructura:**
- **id_rol:** Identificador único del rol (clave primaria, autoincremental).
- **nombre_rol:** Nombre del rol. Debe ser único.
- **descripcion_rol:** Breve descripción del rol (opcional).
- **estado_rol:** Estado del rol, que puede ser `activo` o `inactivo` (por defecto, `activo`).

**Uso:**
- **Asignación de Roles:** Asigna un rol específico a cada usuario para definir sus permisos.
- **Gestión de Accesos:** Permite filtrar y gestionar roles activos o inactivos según las necesidades del sistema.
- **Relación con Permisos:** Se utiliza en conjunto con la tabla `Autorizaciones` para vincular permisos a cada rol.

---

## 2. Tabla `Usuarios`

**Descripción:**  
La tabla `Usuarios` contiene la información personal y de autenticación de cada usuario del sistema.

**Estructura:**
- **id_usuario:** Identificador único del usuario (clave primaria, autoincremental).
- **nombre_usuario:** Nombre del usuario.
- **apellido_usuario:** Apellido del usuario.
- **username_usuario:** Nombre de usuario para el login. Debe ser único.
- **claveHash_usuario:** Contraseña almacenada en formato hash para mayor seguridad.
- **id_rol:** Identificador del rol asignado. Es una clave foránea que referencia la tabla `Roles`.
- **estado_usuario:** Estado del usuario, ya sea `activo` o `inactivo` (por defecto, `activo`).

**Uso:**
- **Autenticación:** Se utiliza para el login y la gestión de sesiones de usuario.
- **Control de Acceso:** A través del campo `id_rol`, se determina el nivel de permisos del usuario.
- **Gestión de Usuarios:** Permite actualizar datos, activar o desactivar cuentas según sea necesario.

---

## 3. Tabla `Permisos`

**Descripción:**  
La tabla `Permisos` define los permisos o privilegios específicos que se pueden asignar a los roles dentro del sistema.

**Estructura:**
- **id_permiso:** Identificador único del permiso (clave primaria, autoincremental).
- **nombre_permiso:** Nombre del permiso. Es único.

**Uso:**
- **Definición de Funcionalidades:** Especifica las acciones o funciones que se pueden controlar (como acceso a secciones, acciones CRUD, etc.).
- **Asignación a Roles:** Se relaciona con la tabla `Autorizaciones` para determinar qué permisos posee cada rol.

---

## 4. Tabla `Categorias`

**Descripción:**  
La tabla `Categorias` se utiliza para clasificar los registros (transacciones, eventos financieros, etc.) en categorías de `ingreso` o `egreso`.

**Estructura:**
- **id_categoria:** Identificador único de la categoría (clave primaria, autoincremental).
- **nombre_categoria:** Nombre descriptivo de la categoría.
- **tipo_categoria:** Tipo de la categoría, que puede ser `ingreso` o `egreso`.
- **qr_categoria:** Campo opcional para almacenar una referencia a un código QR asociado a la categoría.

**Uso:**
- **Clasificación:** Permite categorizar los registros para facilitar el análisis y la generación de reportes.
- **Filtrado:** Facilita la consulta de registros según su tipo (por ejemplo, para separar ingresos de egresos).

---

## 5. Tabla `Registros`

**Descripción:**  
La tabla `Registros` almacena los datos de cada transacción o registro financiero. Se utiliza para llevar un control detallado de las operaciones realizadas.

**Estructura:**
- **id_registro:** Identificador único del registro (clave primaria, autoincremental).
- **nombre_registro:** Nombre o descripción breve del registro (opcional).
- **tipo_registro:** Medio de transacción, pudiendo ser `tarjeta`, `efectivo` o `transferencia`.
- **metodo_registro:** Método adicional para especificar detalles del registro (opcional).
- **fecha_registro:** Fecha y hora en que se realizó la transacción.
- **valor_registro:** Valor monetario asociado a la transacción.
- **estado_registro:** Estado del registro, ya sea `activo` o `inactivo` (por defecto, `activo`).
- **id_usuario:** Identificador del usuario que realizó la transacción (clave foránea que referencia `Usuarios`).
- **id_categoria:** Identificador de la categoría asignada a la transacción (clave foránea que referencia `Categorias`).

**Uso:**
- **Registro de Operaciones:** Guarda cada transacción o movimiento financiero para su posterior consulta.
- **Reportes Financieros:** Permite generar informes y análisis de ingresos y egresos, utilizando filtros por fecha, usuario o categoría.
- **Integridad:** Mantiene la relación con las tablas `Usuarios` y `Categorias` para asegurar la consistencia de los datos.

---

## 6. Tabla `Autorizaciones`

**Descripción:**  
La tabla `Autorizaciones` es una tabla intermedia que establece una relación many-to-many entre `Roles` y `Permisos`. Define qué permisos tiene asignado cada rol.

**Estructura:**
- **id_rol:** Identificador del rol (clave foránea que referencia la tabla `Roles`).
- **id_permiso:** Identificador del permiso (clave foránea que referencia la tabla `Permisos`).

**Uso:**
- **Control de Acceso:** Permite asignar y gestionar los permisos que cada rol posee.
- **Seguridad:** Facilita la configuración de accesos a diferentes partes de la aplicación en función del rol del usuario.
- **Consultas:** Se pueden realizar JOINs para determinar rápidamente qué permisos tiene un rol específico.

---

## 7. Tabla `Auditoria`

**Descripción:**  
La tabla `Auditoria` se utiliza para registrar todas las acciones importantes que se realizan en la base de datos. Esto es esencial para llevar un seguimiento de las operaciones y detectar posibles actividades inusuales.

**Estructura:**
- **id_auditoria:** Identificador único del registro de auditoría (clave primaria, autoincremental).
- **accion:** Acción realizada (por ejemplo, `INSERT`, `UPDATE`, `DELETE`).
- **tabla_afectada:** Nombre de la tabla en la que se realizó la acción.
- **id_registro_afectado:** Identificador del registro afectado (si aplica).
- **id_usuario:** Identificador del usuario que realizó la acción (clave foránea que referencia `Usuarios`).
- **fecha_hora:** Fecha y hora en que se realizó la acción.
- **detalles:** Información adicional que puede incluir cambios realizados (opcional).

**Uso:**
- **Seguimiento de Cambios:** Monitorea y audita las operaciones en la base de datos para fines de seguridad y cumplimiento.
- **Resolución de Problemas:** Ayuda a identificar errores o comportamientos anómalos en el sistema.
- **Historial de Acciones:** Permite generar reportes sobre las actividades realizadas por los usuarios.

---

## Consideraciones Generales

- **Relaciones e Integridad Referencial:**  
  - La tabla `Usuarios` se relaciona con `Roles` mediante el campo `id_rol`.  
  - `Registros` se vincula tanto con `Usuarios` (a través de `id_usuario`) como con `Categorias` (a través de `id_categoria`).  
  - La tabla `Autorizaciones` conecta `Roles` y `Permisos` para establecer los permisos de cada rol.  
  - `Auditoria` registra las acciones de los usuarios y hace referencia a `Usuarios` para identificar al responsable.

- **Uso en Aplicaciones:**  
  Este esquema es útil en aplicaciones que requieren control de acceso basado en roles, gestión de transacciones financieras y auditoría de acciones. Se recomienda utilizar consultas JOIN para obtener información combinada de varias tablas y aplicar filtros basados en los estados (`activo`/`inactivo`) para optimizar la gestión y seguridad de los datos.

## Triggers para Roles

### Roles_Auditoria_Insert

- **Evento:** AFTER INSERT en la tabla `Roles`
- **Función:**  
  Registra en la tabla `Auditoria` la creación de un nuevo rol.
- **Acciones realizadas:**  
  - Se inserta un registro en `Auditoria` con:
    - **accion:** `'INSERT'`
    - **tabla_afectada:** `'Roles'`
    - **id_registro_afectado:** `NEW.id_rol`
    - **id_usuario:** Utiliza la variable `@usuario_activo` (representa el usuario que realizó la acción)
    - **fecha_hora:** Fecha y hora actual (`NOW()`)
    - **detalles:** Concatenación del mensaje `"Nuevo rol creado: "` con `NEW.nombre_rol`

---

### Roles_Auditoria_Update

- **Evento:** AFTER UPDATE en la tabla `Roles`
- **Función:**  
  Audita la actualización de un rol.
- **Acciones realizadas:**  
  - Se inserta un registro en `Auditoria` con:
    - **accion:** `'UPDATE'`
    - **tabla_afectada:** `'Roles'`
    - **id_registro_afectado:** `NEW.id_rol`
    - **id_usuario:** `@usuario_activo`
    - **fecha_hora:** Fecha y hora actual
    - **detalles:** Mensaje concatenado `"Rol actualizado: "` y el nuevo valor de `NEW.nombre_rol`

---

## Triggers para Registros

### Registros_Auditoria_Insert

- **Evento:** AFTER INSERT en la tabla `Registros`
- **Función:**  
  Registra la inserción de un nuevo registro o transacción.
- **Acciones realizadas:**  
  - Se inserta un registro en `Auditoria` con:
    - **accion:** `'INSERT'`
    - **tabla_afectada:** `'Registros'`
    - **id_registro_afectado:** `NEW.id_registro`
    - **id_usuario:** `@usuario_activo`
    - **fecha_hora:** Fecha y hora actual
    - **detalles:** Mensaje que indica `"Nuevo registro creado: "` concatenado con `NEW.id_registro`

---

### Registros_Auditoria_Update

- **Evento:** AFTER UPDATE en la tabla `Registros`
- **Función:**  
  Audita las actualizaciones realizadas sobre un registro, registrando tanto la modificación general como cambios específicos en el estado.
- **Acciones realizadas:**
  - **Actualización General:**
    - Inserta un registro en `Auditoria` con:
      - **accion:** `'UPDATE'`
      - **tabla_afectada:** `'Registros'`
      - **id_registro_afectado:** `NEW.id_registro`
      - **id_usuario:** `@usuario_activo`
      - **fecha_hora:** Fecha y hora actual
      - **detalles:** Mensaje `"Registro actualizado: "` concatenado con `NEW.nombre_registro`
  - **Actualización del Estado:**
    - Verifica si `OLD.estado_registro` es distinto a `NEW.estado_registro`.  
    - Si hay cambio, se inserta otro registro en `Auditoria` con:
      - **accion:** `'UPDATE'`
      - **tabla_afectada:** `'Registros'`
      - **id_registro_afectado:** `NEW.id_registro`
      - **id_usuario:** `@usuario_activo`
      - **fecha_hora:** Fecha y hora actual
      - **detalles:** Mensaje `"Estado del registro actualizado: "` concatenado con el nuevo estado (`NEW.estado_registro`)

---

## Triggers para Usuarios

### Usuarios_Auditoria_Insert

- **Evento:** AFTER INSERT en la tabla `Usuarios`
- **Función:**  
  Registra la creación de un nuevo usuario.
- **Acciones realizadas:**  
  - Se inserta un registro en `Auditoria` con:
    - **accion:** `'INSERT'`
    - **tabla_afectada:** `'Usuarios'`
    - **id_registro_afectado:** `NEW.id_usuario`
    - **id_usuario:** `@usuario_activo`
    - **fecha_hora:** Fecha y hora actual
    - **detalles:** Mensaje que concatena `"Nuevo usuario creado: "` con `NEW.nombre_usuario` y `NEW.apellido_usuario`

---

### Usuarios_Auditoria_Update_Rol

- **Evento:** AFTER UPDATE en la tabla `Usuarios`
- **Función:**  
  Audita el cambio en el rol de un usuario cuando se actualiza el campo `id_rol`.
- **Acciones realizadas:**  
  - Comprueba si el valor anterior (`OLD.id_rol`) es diferente del nuevo (`NEW.id_rol`).
  - Si se detecta un cambio, se inserta un registro en `Auditoria` con:
    - **accion:** `'UPDATE'`
    - **tabla_afectada:** `'Usuarios'`
    - **id_registro_afectado:** `NEW.id_usuario`
    - **id_usuario:** `@usuario_activo`
    - **fecha_hora:** Fecha y hora actual
    - **detalles:** Mensaje fijo `"Cambio de rol"`

---

### Usuarios_Auditoria_Update_Estado

- **Evento:** AFTER UPDATE en la tabla `Usuarios`
- **Función:**  
  Audita los cambios en el estado de un usuario.
- **Acciones realizadas:**  
  - Verifica si `OLD.estado_usuario` es distinto a `NEW.estado_usuario`.
  - Si se detecta el cambio, se inserta un registro en `Auditoria` con:
    - **accion:** `'UPDATE'`
    - **tabla_afectada:** `'Usuarios'`
    - **id_registro_afectado:** `NEW.id_usuario`
    - **id_usuario:** `@usuario_activo`
    - **fecha_hora:** Fecha y hora actual
    - **detalles:** Mensaje que concatena `"Estado actualizado: "` con `NEW.estado_usuario`

---

## Consideraciones Generales

- **Uso de la Variable `@usuario_activo`:**  
  Todos los triggers utilizan la variable `@usuario_activo` para identificar al usuario que ejecutó la acción. Es esencial que esta variable se defina correctamente en la sesión para garantizar la precisión en la auditoría.

- **Auditoría Centralizada:**  
  La estrategia de auditar todas las operaciones críticas en la tabla `Auditoria` permite:
  - Un seguimiento detallado de las acciones sobre los datos.
  - Una herramienta de diagnóstico para identificar cambios no autorizados o errores.
  - Facilitar el cumplimiento de normativas y políticas de seguridad.
---
