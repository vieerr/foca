<?php

$username = $_SESSION["username"];
$name = $_SESSION["name"];
$last_name = $_SESSION["last_name"];
$role = $_SESSION["role_name"];
?>

<div class="bg-base-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Perfil</h1>

    <!-- User Information Section -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-lg font-bold">Bienvenido, <span class="text-primary"><?= htmlspecialchars(
                    $username
                ) ?></span></p>
                <span class="font-bold text-sm py-3 text-gray-400"><?= htmlspecialchars(
                    $role
                ) ?></span>
            </div>
            <p id="now-date" class="text-sm text-gray-500"></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-700">Nombre: <span class="font-bold"><?= htmlspecialchars(
                    $name . " " . $last_name
                ) ?></span></p>
            </div>
        </div>
    </div>

    <!-- Change Password Section -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg w-full  md:w-1/3">
        <h2 class="text-xl font-bold mb-4">Cambiar contraseña</h2>
        <form id="change-password-form">
            <div class="mb-4 w-full">
                <label for="new-password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                <input type="password" id="new-password" name="new-password" class="w-full py-2 px-3 rounded-lg border-2 border-[#e0e0e0] bg-base-100 mb-3" required>
            </div>
            <div class="mb-4 w-full">
                <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password" class="w-full py-2 px-3 rounded-lg border-2 border-[#e0e0e0] bg-base-100 mb-3" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>