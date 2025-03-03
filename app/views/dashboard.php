<?php
// VALIDATE WITH AUTH ROLES
// if (!isset($_SESSION["user_id"])) {
//     // Redirect to login if not logged in
//     header("Location: /login");
//     exit();
// }

$username = $_SESSION["username"] ?? "Guest";
// $role = $_SESSION["role"] ?? "User";
$role = "Admin";
?>

<div class="bg-base-100 w-full ">
    <div class="flex min-h-screen">
        <div class=" p-8 bg-base-100 w-full">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            <!-- Display User Session Data -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <p class="text-lg py-5">Bienvenido, <span class="font-bold text-primary"><?= htmlspecialchars(
                        $username
                    ) ?></span>!</p>
                    <p class="text-sm text-gray-500">Rol: <span class="font-bold"><?= htmlspecialchars(
                        $role
                    ) ?></span></p>
                </div>
                <p id="now-date" class="text-sm text-gray-500"></p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Income Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title ">Total de ingresos registrados</h2>
                        <p id="income-num" class=" text-success text-2xl font-bold"></p>
                        <!-- <p class="text-sm text-gray-500">+5% desde el mes pasado</p> -->
                    </div>
                </div>
                <!-- Expenses Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title ">Total de ingresos registrados</h2>
                        <p class="text-2xl font-bold text-error" id="expense-num">$100</p>
                        <!-- <p class="text-sm text-gray-500">-2% desde el mes pasado</p> -->
                    </div>
                </div>
                <!-- Total Income Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title ">Total de Ingresos</h2>
                        <p class="text-2xl font-bold text-success" id="income-total"></p>
                        <p class="text-sm text-gray-500">Todos los tiempos</p>
                    </div>
                </div>
                <!-- Total Expenses Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title ">Total de Gastos</h2>
                        <p class="text-2xl font-bold text-error" id="expense-total"></p>
                        <p class="text-sm text-gray-500">Todos los tiempos</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Income vs Expenses Chart -->
                <div class="bg-base-200 rounded-lg col-span-2 h-96 p-12 pt-0 m-0">
                    <h2 class="card-title">Ingresos vs Gastos</h2>
                    <canvas id="incomeExpensesChart" class="w-14 h-28"></canvas>

                </div>

                <!-- Category Breakdown -->
                <div class="bg-base-200 rounded-lg h-96 p-12 pt-0 m-0">
                    <h3 class="text-lg font-bold mb-4">Ingresos por categorías</h3>
                    <canvas id="income-category" class="w-14 h-28"></canvas>
                </div>
                <!-- Category Breakdown -->
                <div class="bg-base-200 rounded-lg h-96 p-12 pt-0 m-0">
                    <h3 class="text-lg font-bold mb-4">Egresos por categorías</h3>
                    <canvas id="expense-category" class="w-14 h-28"></canvas>
                </div>
            </div>

            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">Actividad Reciente</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="recent-regs" >
                                <tr>
                                    <td><span class="badge badge-success">Ingreso</span></td>
                                    <td>Sueldo Octubre</td>
                                    <td class="">+$2,500.00</td>
                                    <td>2023-month-income</ text-success td>
                                    <td><span class="badge badge-success">Confirmado</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-error">Gasto</span></td>
                                    <td>Supermercado</td>
                                    <td class="text-error">-$150.00</td>
                                    <td>2023-10-05</td>
                                    <td><span class="badge badge-success">Confirmado</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>