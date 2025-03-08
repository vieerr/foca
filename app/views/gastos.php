<main class="bg-base-100 p-4">
  <h1 class="text-3xl font-bold mb-6">Administrar Gastos</h1>
  <div class="bg-base-200 p-4 rounded-lg shadow-lg mb-6 col-span-2">
    <section class="flex justify-between w-full mb-3">
      <span class="text-xl font-bold mb-4 w-auto">Filtros de Búsqueda</span>
      <button id="register-expense-btn" class="btn btn-primary">
        <p class="hidden lg:inline-block">Agregar</p>
        <i class="fa-regular fa-plus"></i>
      </button>
      <dialog id="qr_modal" class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold" id="qr-title"></h3>
          <img src="assets/qrs/Alimentacion.png" alt="qr" class="mx-auto" id="qr-img" />
          <div class="modal-action">
            <form method="dialog">
              <button class="btn">Cerrar</button>
            </form>
          </div>
        </div>
      </dialog>


      <!--MODAL FORM-->
      <dialog id="modalGasto" class="modal">
        <div class="modal-box">
          <form id="close-modal" method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <!--Form-->
          <h2 id="expense-form-title" class="text-xl font-bold mb-4"></h2>
          <form id="register-expense-form" class="w-full flex flex-col gap-2">
            <label class="input min-w-full" for="nombre_registro">
              <span class="label">Descripción</span>
              <input type="text" class="outline-none" placeholder="Breve descripción del gasto" name="nombre_registro"
                id="nombre_registro" />
            </label>
            <label class="select min-w-full" for="nombre_categoria">
              <span class="label font-medium">Categoría</span>
              <select class="select" name="nombre_categoria" id="nombre_categoria"></select>
            </label>
            <label class="input min-w-full" for="fecha_accion">
              <span class="label font-medium">Fecha de pago</span>
              <input type="date" name="fecha_accion" id="fecha_accion" required />
            </label>
            <label class="select min-w-full" for="metodo_registro">
              <span class="label font-medium">Método de pago</span>
              <select class="select" name="metodo_registro" id="metodo_registro">
                <option value="" selected>Seleccionar método</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
              </select>
            </label>
            <label class="input min-w-full" for="valor_registro">
              <span class="label font-medium">Valor</span>
              <input type="number" step="0.01" min="0.15" class="outline-none" placeholder="$500.00"
                name="valor_registro" id="valor_registro" required />
            </label>
            <button id="expense-form-btn" type="submit" class="btn btn-primary mt-4 w-full"></button>
          </form>
        </div>
      </dialog>
    </section>

    <!-- Filters Section-->
    <section class="mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label class="select" for="filtro_nombre_categoria">
          <span class="label font-medium">Categoría</span>
          <select class="select" name="nombre_categoria" id="filtro_nombre_categoria"></select>
        </label>
        <label class="select" for="filtro_metodo_registro">
          <span class="label font-medium">Método de Pago</span>
          <select class="select" name="metodo_registro" id="filtro_metodo_registro">
            <option value="" selected>Seleccionar método</option>
            <option value="Transferencia">Transferencia</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
          </select>
        </label>
        <label class="select" for="filtro_estado_registro">
          <span class="label font-medium">Estado</span>
          <select class="select" name="filtro_estado_registro" id="filtro_estado_registro">
            <option value="" selected>Seleccionar estado</option>
            <option value="activo">Activo</option>
            <option value="anulado">Anulado</option>
          </select>
        </label>
        <label class="input" for="fecha-inicial">
          <span class="label font-medium">Desde</span>
          <input type="date" name="fecha-inicial" id="fecha-inicial" />
        </label>
        <label class="input" for="fecha-final">
          <span class="label font-medium">Hasta</span>
          <input type="date" name="fecha-final" id="fecha-final" />
        </label>
      </div>
    </section>


    <!--Table Section-->
    <section class="overflow-x-auto">
      <table id="gastos-table" class="table w-full bg-base-100">
        <thead>
          <tr class="text-center text-sm font-medium text-gray-700">
            <th class="px-6 py-3 border-b border-gray-200">ID</th>
            <th class="px-6 py-3 border-b border-gray-200">Descripción</th>
            <th class="px-6 py-3 border-b border-gray-200">Categoría</th>
            <th class="px-6 py-3 border-b border-gray-200">Valor</th>
            <th class="px-6 py-3 border-b border-gray-200">Método de Pago</th>
            <th class="px-6 py-3 border-b border-gray-200">Fecha de Pago</th>
            <th class="px-6 py-3 border-b border-gray-200">Fecha de Registro</th>
            <th class="px-6 py-3 border-b border-gray-200">Estado</th>
            <th class="px-6 py-3 border-b border-gray-200">Acciones</th>
          </tr>
        </thead>
        <tbody id="gastos-table-body">
        </tbody>
      </table>
    </section>

    <!-- Pagination Section -->
    <div class="flex justify-center mt-6">
      <div class="btn-group">
        <button class="btn btn-sm">«</button>
        <button class="btn btn-sm btn-active">1</button>
        <button class="btn btn-sm">2</button>
        <button class="btn btn-sm">3</button>
        <button class="btn btn-sm">4</button>
        <button class="btn btn-sm">»</button>
      </div>
    </div>
  </div>
</main>