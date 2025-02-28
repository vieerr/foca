<div class="bg-base-100 p-8 flex flex-col">
  <!-- Form Section -->
  <div class="shadow-lg p-6 rounded-lg mb-8">
    <h2 class="text-xl font-bold mb-4">Registrar un nuevo ingreso</h2>
    <form id="register-user-form">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="select">
          <span class="label">Categoría</span>
          <select class="select select-bordered w-full">
            <option disabled selected>Seleccionar categoría</option>
            <option>Sueldo</option>
            <option>Alquiler/renta</option>
            <option>Venta</option>
            <option>Regalo</option>
            <option>Pensiones</option>
          </select>
        </label>
        <label class="input">
          <span class="label">Fecha de obtención</span>
          <input type="date" class="input input-bordered w-full" />
        </label>
        <label class="select">
          <span class="label">Método de pago</span>
          <select class="select select-bordered w-full">
            <option disabled selected>Seleccionar método</option>
            <option>Transferencia</option>
            <option>Efectivo</option>
            <option>Tarjeta</option>
          </select>
        </label>
        <label class="input">
          <span class="label">Valor</span>
          <input type="number" step="0.01" class="input input-bordered w-full" placeholder="$500" />
        </label>
      </div>
      <button type="submit" class="btn btn-primary mt-4">Agregar</button>
    </form>
  </div>
  <!-- Filters Section -->
  <div class="mb-6">
    <h2 class="text-xl font-bold mb-4">Filtros de Búsqueda</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <label class="input">
        <span class="label">ID</span>
        <input type="text" placeholder="Buscar por ID" class="input input-bordered w-full" />
      </label>
      <label class="select">
        <span class="label">Categoría</span>
        <select class="select select-bordered w-full">
          <option disabled selected>Seleccionar categoría</option>
          <option>Sueldo</option>
          <option>Alquiler/renta</option>
          <option>Venta</option>
          <option>Regalo</option>
          <option>Pensiones</option>
        </select>
      </label>
      <label class="select">
        <span class="label">Método de Pago</span>
        <select class="select select-bordered w-full">
          <option disabled selected>Seleccionar método</option>
          <option>Transferencia</option>
          <option>Efectivo</option>
          <option>Tarjeta</option>
        </select>
      </label>
      <label class="select">
        <span class="label">Estado</span>
        <select class="select select-bordered w-full">
          <option disabled selected>Seleccionar estado</option>
          <option>Activo</option>
          <option>Inactivo</option>
        </select>
      </label>
      <label class="input">
        <span class="label">Fecha de Obtención</span>
        <input type="date" class="input input-bordered w-full" />
      </label>
      <label class="input">
        <span class="label">Fecha de Registro</span>
        <input type="date" class="input input-bordered w-full" />
      </label>
    </div>
  </div>
  <!-- Table Section -->
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th>Categoría</th>
          <th>Valor</th>
          <th>Método de Pago</th>
          <th>Fecha de Obtención</th>
          <th>Fecha de Registro</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Hardcoded Data -->
        <tr>
          <td>1</td>
          <td>Sueldo</td>
          <td>$1500.00</td>
          <td>Transferencia</td>
          <td>2023-10-01</td>
          <td>2023-10-02</td>
          <td><span class="badge badge-success">Activo</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Anular</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Alquiler/renta</td>
          <td>$800.00</td>
          <td>Efectivo</td>
          <td>2023-10-05</td>
          <td>2023-10-06</td>
          <td><span class="badge badge-error">Anulado</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Anular</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>Venta</td>
          <td>$1200.00</td>
          <td>Tarjeta</td>
          <td>2023-10-10</td>
          <td>2023-10-11</td>
          <td><span class="badge badge-success">Activo</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Anular</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
