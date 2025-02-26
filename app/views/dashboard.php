<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to login if not logged in
    header("Location: /login");
    exit();
}

// Access session data
$username = $_SESSION["username"] ?? "Guest";
// $role = $_SESSION["role"] ?? "User";
$role = "Admin";
?>

<div class="bg-base-100">
    <div class="flex min-h-screen">

        <!-- Main Content -->
        <div class="main-content flex-1 p-8 bg-base-100">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            <!-- Display User Session Data -->
            <div class="mb-6 flex justify-between">
                <div>
                <p class="text-lg py-5">Bienvenido, <span class="font-bold text-primary"><?= htmlspecialchars(
                    $username
                ) ?></span>!</p>
                <p class="text-sm text-gray-500">Rol: <span class="font-bold"><?= htmlspecialchars(
                    $role
                ) ?></span></p>
                </div>

                <p id="now-date" ></p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Income Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-success">Cantidad de ingresos registrados</h2>
                        <p class="text-2xl font-bold">$2,000</p>
                    </div>
                </div>
                <!-- Expenses Card -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-error">Cantidad de gastos registrados</h2>
                        <p class="text-2xl font-bold">$100</p>
                    </div>
                </div>
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-success">Total de ingresos registrados en esta cuenta</h2>
                        <p class="text-2xl font-bold">$100</p>
                    </div>
                </div>                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-error">Total de gastos registrados en esta cuenta</h2>
                        <p class="text-2xl font-bold">$100</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(() => {
  $("now-date").html(`<p> ${new Date()}</p>`);
});
</script>
