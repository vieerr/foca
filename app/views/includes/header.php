<?php
function isLoggedIn()
{
    return true;
    // return isset($_SESSION["user_id"]);
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Finance App</title>
    <!-- Tailwind CSS + DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.15.0/dist/full.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4 text-white">
        <div class="container mx-auto">
            <a href="index.php" class="text-xl font-bold">Family Finance App</a>
            <div class="float-right">
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php" class="mr-4">Dashboard</a>
                    <a href="logout.php" class="bg-red-500 px-4 py-2 rounded">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="bg-green-500 px-4 py-2 rounded">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
