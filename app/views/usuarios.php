<div class="bg-base-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Administrar Usuarios</h1>

    <!-- Register New User Form -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-bold mb-4">Registrar un nuevo usuario</h2>
        <form id="register-user-form" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="rol" name="rol" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Agregar</button>
        </form>
    </div>

    <!-- Registered Users Table -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Usuarios registrados</h2>
        <div class="overflow-x-auto">
            <table id="users-table" class="min-w-full bg-base-100">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Apellido</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Nombre de usuario</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Rol</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Estado</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body"</tbody>
            </table>
        </div>
    </div>
</div>
