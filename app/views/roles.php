<div class="bg-base-100 p-4">
    <h1 class="text-3xl font-bold mb-6">Administrar Roles</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- <div class="flex gap-6"> -->
        <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6 col-span-2">
            <h2 class="text-xl font-bold mb-4">Roles registrados</h2>
            <div class="overflow-x-auto">
                <table id="roles-table" class="min-w-full bg-base-100">
                    <thead>
                        <tr class="text-center text-sm font-medium text-gray-700">
                            <th class="px-6 py-3 border-b border-gray-200 ">ID</th>
                            <th class="px-6 py-3 border-b border-gray-200 ">Nombre</th>
                            <th class="px-6 py-3 border-b border-gray-200 ">Estado</th>
                            <th class="px-6 py-3 border-b border-gray-200 ">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="roles-table-body"></tbody>
                </table>
            </div>
        </div>
        <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6">
            <h2 class="text-xl font-bold mb-4">Registrar nuevo rol</h2>
            <form id="register-rol-form" method="POST">
                <label class="block text-sm font-medium text-gray-700" for="nombre_rol">Nombre del Rol:</label>
                <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="nombre_rol" id="nombre_rol" required>
                <label class="block text-sm font-medium text-gray-700 mt-3" for="descripcion_rol">Descripción:</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-lg text-xs bg-white" type="text" name="descripcion_rol" id="descripcion_rol" required></textarea>

                <h2 class="text-center text-lg font-bold my-2" for="permisos">Permisos</h2>
                <div class="flex justify-center">
                    <div id="permisos" class="grid grid-cols-1 md:grid-cols-2 gap-2 gap-x-6"></div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 w-full">Agregar</button>
            </form>
        </div>
    </div>    
</div>