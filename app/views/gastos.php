<div class="bg-base-100 p-8 flex flex-col">


  <!-- Form Section -->
  <div class="shadow-lg p-6 rounded-lg mb-8">
    <h2 class="text-xl font-bold mb-4">Registrar un nuevo gasto</h2>
    <form id="register-expense-form">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 ">
        <label class="input">
          <span class="label">Nombre</span>
          <input type="text" class="input input-bordered w-full" placeholder="Nombre del gasto" />
        </label>
        <label class="select">
          <span class="label">Categoría</span>
          <select class="select select-bordered w-full">
            <option disabled selected>Seleccionar categoría</option>
            <option>Comida</option>
            <option>Transporte</option>
            <option>Servicios</option>
            <option>Entretenimiento</option>
            <option>Salud</option>
            <option>Educación</option>
            <option>Vestimenta</option>
            <option>Mascota</option>
            <option>Vivienda</option>
            <option>Vehículo</option>
            <option>Financiero</option>

            <option>Otros</option>
          </select>
        </label>
        <label class="input w-full" style="width: fit-content">
          <span class="label">Fecha en la que se realizó</span>
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
            <option>Comida</option>
            <option>Transporte</option>
            <option>Servicios</option>
            <option>Entretenimiento</option>
            <option>Salud</option>
            <option>Educación</option>
            <option>Vestimenta</option>
            <option>Mascota</option>
            <option>Vivienda</option>
            <option>Vehículo</option>
            <option>Financiero</option>

            <option>Otros</option>
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
          <option>Pendiente</option>
        </select>
      </label>
      <label class="input " style="width: fit-content" >
        <span class="label">Fecha en la que se realizó</span>
        <input type="date"  />
      </label>
      <label class="input w-fit" >
        <span class="label">Fecha de Registro</span>
        <input type="date" />
      </label>
    </div>
  </div>
  <!-- Table Section -->
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Valor</th>
          <th>Método de Pago</th>
          <th>Fecha en la que se realizó</th>
          <th>Fecha de Registro</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Hardcoded Data -->
        <tr>
          <td>1</td>
          <td>Cena en restaurante</td>
          <td>Comida</td>
          <td>$50.00</td>
          <td>Tarjeta</td>
          <td>2023-10-01</td>
          <td>2023-10-02</td>
          <td><span class="badge badge-success">Activo</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Eliminar</button>
            <button class="btn btn-xs btn-warning ml-2">QR</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Transporte público</td>
          <td>Transporte</td>
          <td>$10.00</td>
          <td>Efectivo</td>
          <td>2023-10-05</td>
          <td>2023-10-06</td>
          <td><span class="badge badge-warning">Pendiente</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Eliminar</button>
            <button class="btn btn-xs btn-warning ml-2">QR</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>Pago de luz</td>
          <td>Servicios</td>
          <td>$120.00</td>
          <td>Transferencia</td>
          <td>2023-10-10</td>
          <td>2023-10-11</td>
          <td><span class="badge badge-success">Activo</span></td>
          <td>
            <button class="btn btn-xs btn-info">Editar</button>
            <button class="btn btn-xs btn-error ml-2">Eliminar</button>
            <button class="btn btn-xs btn-warning ml-2">QR</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

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
