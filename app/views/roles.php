<div>
    <h1>Administrar Roles</h1>
    <br>
    <h2>Registrar nuevo Rol</h2>
    <form id="register-rol-form" method="POST">
        <label for="nombre_rol">Nombre del Rol:</label>
        <input type="text" name="nombre_rol" id="nombre_rol" required><br><br>
        <label for="descripcion_rol">Descripción:</label>
        <input type="text" name="descripcion_rol" id="descripcion_rol" required><br><br>
        <p>
            <label for="permisos">Permisos</label>
        </p>
        <div id="permisos"></div>
        <button type="submit" class="btn btn-primary mt-4">Agregar</button>
    </form>
</div>