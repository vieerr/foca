<main class="bg-base-100 p-4">
  <h1 class="text-3xl font-bold mb-6">Auditorias</h1>
  <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6 col-span-2">
    <section class="flex justify-between w-full mb-3">
      <span class="text-xl font-bold mb-4 w-auto">Filtros de Búsqueda</span>
    </section>

    <!-- Filters Section-->
    <section class="mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <label class="select" for="filtro_accion">
          <span class="label font-medium">Acción</span>
          <select class="select" name="filtro_accion" id="filtro_accion">
            <option value="" selected>Seleccionar acción</option>
            <option value="actualizar">Actualizar</option>
            <option value="crear">Crear</option>
          </select>
        </label>
        <label class="select" for="filtro_apartado">
          <span class="label font-medium">Apartado</span>
          <select class="select" name="filtro_apartado" id="filtro_apartado">
            <option selected>Seleccionar apartado</option>
            <option value="roles">Roles</option>
            <option value="usuarios">Usuarios</option>
            <option value="registros">Registros</option>
          </select>
        </label>
        <!-- it may not be a good idea to fetch all users in the database to show them in a select input -->
        <!-- <label class="select" for="filtro_usuario">
          <span class="label font-medium">Usuario</span>
          <select class="select" name="filtro_usuario" id="filtro_usuario">
            <option selected>Seleccionar usuario</option>
            <option>Fredo</option>
            <option>Carlos</option>
            <option>Antonik</option>
          </select>
        </label> -->
        <!-- <label class="input" for="filtro_fecha_exacta">
          <span class="label font-medium">Fecha exacta</span>
          <input type="date" name="filtro_fecha_exacta" id="filtro_fecha_exacta" />
        </label> -->
        <label class="select" for="filtro_ano">
          <span class="label font-medium">Año</span>
          <select class="select" name="filtro_ano" id="filtro_ano">
            <option  value="" selected>Seleccionar año</option>
            <!-- <option>2023</option>
            <option>2024</option> -->
          </select>
        </label>
        <label class="select" for="filtro_mes">
          <span class="label font-medium">Mes</span>
          <select class="select" name="filtro_mes" id="filtro_mes">
            <option value="" selected>Seleccionar mes</option>
            <!-- <option>Enero</option>
            <option>Febrero</option>
            <option>Marzo</option>
            <option>Abril</option>
            <option>Mayo</option>
            <option>Junio</option>
            <option>Julio</option>
            <option>Agosto</option>
            <option>Septiembre</option>
            <option>Octubre</option>
            <option>Noviembre</option>
            <option>Diciembre</option> -->
          </select>
        </label>
      </div>
    </section>

    <!--Table Section-->
    <section class="overflow-x-auto">
      <table id="auditorias-table" class="table w-full bg-base-100 table-zebra">
        <thead>
          <tr class="text-center text-sm font-medium text-gray-700">
            <th class="px-6 py-3 border-b border-gray-200">ID</th>
            <th class="px-6 py-3 border-b border-gray-200">Acción</th>
            <th class="px-6 py-3 border-b border-gray-200">Apartado</th>
            <th class="px-6 py-3 border-b border-gray-200">Usuario</th>
            <th class="px-6 py-3 border-b border-gray-200">Fecha realizada</th>
            <th class="px-6 py-3 border-b border-gray-200">Detalles</th>
          </tr>
        </thead>
        <tbody id="auditorias-table-body">
          <!-- Hardcoded Data -->
          <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">1</td>
            <td class="px-6 py-4 border-b border-gray-200">Actualizar</td>
            <td class="px-6 py-4 border-b border-gray-200">Roles</td>
            <td class="px-6 py-4 border-b border-gray-200">Fredo</td>
            <td class="px-6 py-4 border-b border-gray-200">2024/06/25 04:30</td>
            <td class="px-6 py-4 border-b border-gray-200">Rol actualizado</td>
          </tr>
          <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">2</td>
            <td class="px-6 py-4 border-b border-gray-200">Crear</td>
            <td class="px-6 py-4 border-b border-gray-200">Usuarios</td>
            <td class="px-6 py-4 border-b border-gray-200">Carlos</td>
            <td class="px-6 py-4 border-b border-gray-200">2024/06/25 12:25</td>
            <td class="px-6 py-4 border-b border-gray-200">Usuario actualizado</td>
          </tr>
          <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">3</td>
            <td class="px-6 py-4 border-b border-gray-200">Crear</td>
            <td class="px-6 py-4 border-b border-gray-200">Registros</td>
            <td class="px-6 py-4 border-b border-gray-200">Antonik</td>
            <td class="px-6 py-4 border-b border-gray-200">2024/06/26 08:00</td>
            <td class="px-6 py-4 border-b border-gray-200">Registro actualizado</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Pagination Section -->
    <div class="flex justify-center mt-6">
      <div class="btn-group">
        <!-- <button class="btn btn-sm">«</button>
        <button class="btn btn-sm btn-active">1</button>
        <button class="btn btn-sm">2</button>
        <button class="btn btn-sm">3</button>
        <button class="btn btn-sm">4</button>
        <button class="btn btn-sm">»</button> -->
      </div>
    </div>
  </div>
</main>