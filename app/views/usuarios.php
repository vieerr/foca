<main class="bg-base-100 p-4">
    <h1 class="text-3xl font-bold mb-6">Administrador de Usuarios</h1>
    <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6 col-span-2">
        <section class="flex justify-between w-full mb-3">
            <span class="text-xl font-bold mb-4 w-auto">Usuarios registrados</span>
            <button id="register-user-btn" class="btn btn-primary">
                <p class="hidden lg:inline-block">Agregar</p>
                <i class="fa-regular fa-plus"></i>
            </button>
            <!--MODAL FORM-->
            <dialog id="modalUsuario" class="modal">
                <div class="modal-box">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <!-- Form -->
                    <div class="user-form">
                        <h2 id="user-form-title" class="text-xl font-bold mb-4"></h2>
                        <form id="register-user-form" method="POST">
                          <label class="block text-sm font-medium text-gray-700 mt-3" for="nombre">Nombre:</label>
                          <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="nombre" id="nombre" required>
                          <label class="block text-sm font-medium text-gray-700 mt-3" for="apellido">Apellido:</label>
                          <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="apellido" id="apellido" required>
                          <label class="block text-sm font-medium text-gray-700 mt-3" for="username">Nombre de usuario:</label>
                          <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="username" id="username" required>
                          <label class="block text-sm font-medium text-gray-700 mt-3"
                              for="password">Contraseña:</label>
                          <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="password" name="password" id="password" required>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mt-3" for="rol">Rol:</label>
                              <select id="rol" name="rol" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required></select>
                          </div>
                          <button id="user-form-btn" type="submit" class="btn btn-primary mt-4 w-full"></button>
                        </form>
                    </div>
                </div>
            </dialog>
        </section>

        <!--Table Section-->
        <section class="overflow-x-auto">
            <table id="usuarios-table" class="min-w-full bg-base-100">
                <thead>
                    <tr class="text-center text-sm font-medium text-gray-700">
                        <th class="px-6 py-3 border-b border-gray-200">ID</th>
                        <th class="px-6 py-3 border-b border-gray-200">Nombre</th>
                        <th class="px-6 py-3 border-b border-gray-200">Apellido</th>
                        <th class="px-6 py-3 border-b border-gray-200">Nombre Usuario</th>
                        <th class="px-6 py-3 border-b border-gray-200">Rol</th>
                        <th class="px-6 py-3 border-b border-gray-200">Estado</th>
                        <th class="px-6 py-3 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body"></tbody>
            </table>
        </section>
    </div>
</main>