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
    <script src="../../assets/js/sidebar.js"></script>
</head>
<body>
    <nav class="bg-blue-500 p-4 text-white">
        <div class="sidebar bg-blue-500 text-white p-4">
            <ul>
                <li><a href="#" data-route="dashboard" class="load-content">Dashboard</a></li>
                <li><a href="#" data-route="reports" class="load-content">Reports</a></li>
                <li><a href="#" data-route="profile" class="load-content">Profile</a></li>
            </ul>
        </div>
    </nav>
    <!-- Main Content -->
    <div id="main-content" class="main-content p-4">
        <!-- Content will be loaded here dynamically -->
    </div>
</body>
