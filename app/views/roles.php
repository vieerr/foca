<main class="bg-base-100 p-4">
    <h1 class="text-3xl font-bold mb-6">Administrar Roles</h1>
    <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6 col-span-2">
        <section class="flex justify-between w-full mb-3">
            <span class="text-xl font-bold mb-4 w-auto">Roles registrados</span>
            <button id="register-role-btn" class="btn btn-primary">
                <p class="hidden lg:inline-block">Agregar</p>
                <i class="fa-regular fa-plus"></i>
            </button>
            <!--MODAL FORM-->
            <dialog id="modalRol" class="modal">
                <div class="modal-box">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <!--Form-->
                    <div class="role-form">
                        <h2 id="role-form-title" class="text-xl font-bold mb-4"></h2>
                        <form id="register-role-form" method="POST">
                            <label class="block text-sm font-medium text-gray-700" for="nombre_rol">Nombre del Rol:</label>
                            <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text"
                                name="nombre_rol" id="nombre_rol" required>
                            <label class="block text-sm font-medium text-gray-700 mt-3"
                                for="descripcion_rol">Descripción:</label>
                            <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-lg text-xs bg-white"
                                type="text" name="descripcion_rol" id="descripcion_rol" required></textarea>
                            <fieldset class="border border-gray-300 p-4 rounded-md flex justify-center mt-3">
                                <legend class="px-2 text-lg font-semibold text-center">Permisos</legend>
                                <div class="flex justify-center">
                                    <div id="permisos" class="grid grid-cols-1 md:grid-cols-2 gap-2 gap-x-6"></div>
                                </div>
                            </fieldset>
                            <button id="role-form-btn" type="submit" class="btn btn-primary mt-4 w-full"></button>
                        </form>
                    </div>
                </div>
            </dialog>
        </section>
        <!--Table Section-->
        <section class="overflow-x-auto">
            <table id="roles-table" class="min-w-full bg-base-100">
                <thead>
                    <tr class="text-center text-sm font-medium text-gray-700">
                        <th class="px-6 py-3 border-b border-gray-200">ID</th>
                        <th class="px-6 py-3 border-b border-gray-200">Nombre</th>
                        <th class="px-6 py-3 border-b border-gray-200">Estado</th>
                        <th class="px-6 py-3 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody id="roles-table-body"></tbody>
            </table>
        </section>
    </div>
</main>