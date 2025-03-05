<div class="bg-base-100 p-8 flex flex-col">
  <!-- Report Configuration Section -->
  <div class="mb-6 shadow-lg p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Generador de Reportes</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!-- Report Type Selection -->
      <div class="form-control">
        <label class="label">
          <span class="label-text">Tipo de Reporte</span>
        </label>
        <select id="report-type" class="select select-bordered">
          <option value="">Reporte Completo</option>
          <option value="ingreso">Solo Ingresos</option>
          <option value="egreso">Solo Gastos</option>
        </select>
      </div>

      <!-- Date Range -->
      <div class="form-control">
        <label class="label">
          <span class="label-text">Rango de Fechas</span>
        </label>
        <div class="flex gap-2">
          <input type="date" class="input input-bordered w-full" />
          <input type="date" class="input input-bordered w-full" />
        </div>
      </div>

      <!-- Quick Filters -->
      <div class="form-control">
        <label class="label">
          <span class="label-text">Filtros Rápidos</span>
        </label>
        <div class="flex flex-wrap gap-2">
          <button class="btn btn-xs">Este Mes</button>
          <button class="btn btn-xs">Últimos 7 días</button>
          <button class="btn btn-xs">Trimestre Actual</button>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <!-- <div class="mt-4 collapse collapse-arrow">
      <input type="checkbox" />
      <div class="collapse-title text-sm font-medium">
        Filtros Avanzados
      </div>
      <div class="collapse-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Categoría</span>
            </label>
            <select class="select select-bordered" multiple>
              <option>Todas</option>
              <option>Sueldo</option>
              <option>Comida</option>
              <option>Transporte</option>
              <option>Servicios</option>
            </select>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Monto</span>
            </label>
            <div class="flex gap-2">
              <input type="number" placeholder="Mínimo" class="input input-bordered w-full" />
              <input type="number" placeholder="Máximo" class="input input-bordered w-full" />
            </div>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Estado</span>
            </label>
            <select class="select select-bordered">
              <option>Todos</option>
              <option>Activo</option>
              <option>Pendiente</option>
              <option>Cancelado</option>
            </select>
          </div>
        </div>
      </div>
    </div> -->
  </div>

  <!-- Report Actions -->
  <div class="flex justify-end gap-4 mb-6">
    <button class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
      </svg>
      Exportar PDF
    </button>
    <button class="btn btn-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
      </svg>
      Exportar CSV
    </button>
  </div>

  <!-- Visualizations -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Income vs Expenses Chart -->
    <div class="bg-base-200 p-4 rounded-lg">
      <h3 class="text-lg font-bold mb-4">Resumen General</h3>
      <canvas id="summaryChart" class="w-full h-32"></canvas>
    </div>

    <!-- Category Breakdown -->
    <div class="bg-base-200 px-32 rounded-lg">
      <h3 class="text-lg font-bold mb-4">Distribución por Categoría</h3>
      <canvas id="categoryChart" class="w-1/2 h-32"></canvas>
    </div>
  </div>

  <!-- Data Table -->
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Fecha</th>
          <th>Categoría</th>
          <th>Monto</th>
          <th>Método de Pago</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody id="report-table">
        <!-- Sample Data -->
        <tr class="hover">
          <td><span class="badge badge-success">Ingreso</span></td>
          <td>2023-10-01</td>
          <td>Sueldo Octubre</td>
          <td>Sueldo</td>
          <td class="text-success">+$2,500.00</td>
          <td>Transferencia</td>
          <td><span class="badge badge-success">Confirmado</span></td>
        </tr>
        <tr class="hover">
          <td><span class="badge badge-error">Gasto</span></td>
          <td>2023-10-05</td>
          <td>Supermercado</td>
          <td>Comida</td>
          <td class="text-error">-$150.00</td>
          <td>Tarjeta</td>
          <td><span class="badge badge-success">Confirmado</span></td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center mt-6">
    <div class="btn-group">
      <button class="btn btn-sm">«</button>
      <button class="btn btn-sm btn-active">1</button>
      <button class="btn btn-sm">2</button>
      <button class="btn btn-sm">3</button>
      <button class="btn btn-sm">»</button>
    </div>
  </div>
</div>