<?php
// Start the session
session_start();
// Check if the user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 1) {
    // Redirect to login or show an error
    // header("Location: /login");
    exit();
}

$query = "SELECT u.id_usuario, u.nombre_usuario, u.apellido_usuario, u.username_usuario, u.estado_usuario, r.nombre_rol
           FROM Usuarios u
           JOIN Roles r ON u.id_rol = r.id_rol";

// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-base-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Administrar Usuarios</h1>

    <!-- Register New User Form -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-bold mb-4">Registrar un nuevo usuario</h2>
        <form id="register-user-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="rol" name="rol" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                        <!-- Add more roles as needed -->
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Agregar</button>
        </form>
    </div>

    <!-- Registered Users Table -->
    <div class="bg-base-200 p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Usuarios registrados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-base-100">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Apellido</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Nombre de usuario</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Rol</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Estado</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body"</tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(() => {
    // Handle user registration form submission
    $("#register-user-form").on("submit", function (e) {
        e.preventDefault();

        const formData = {
            nombre: $("#nombre").val(),
            apellido: $("#apellido").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            rol: $("#rol").val(),
        };

        // Send AJAX request to register user
        $.ajax({
            url: "app/controllers/register_user.php", // Adjust the path as needed
            method: "POST",
            data: formData,
            success: function (response) {
                alert("Usuario registrado correctamente.");
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert("Error al registrar el usuario.");
            },
        });
    });

    // Handle edit user button click
    $(".edit-user").on("click", function () {
        const userId = $(this).data("id");
        // Fetch user data and populate the form for editing
        // Example: Open a modal or redirect to an edit page
        alert(`Edit user with ID: ${userId}`);
    });

    // Handle toggle status button click
    $(".toggle-status").on("click", function () {
        const userId = $(this).data("id");
        const newStatus = $(this).data("status") === "activo" ? "inactivo" : "activo";

        // Send AJAX request to update user status
        $.ajax({
            url: "app/controllers/update_user_status.php", // Adjust the path as needed
            method: "POST",
            data: { id: userId, status: newStatus },
            success: function (response) {
                alert("Estado actualizado correctamente.");
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert("Error al actualizar el estado.");
            },
        });
    });
});
</script>
