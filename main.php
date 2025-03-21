<?php
require_once "config/includes/header.php";
require_once "app/controllers/sessionController.php";
SessionController::isAuth() ? null : header("Location: index.php");
$name = $_SESSION["name"];
$last_name = $_SESSION["last_name"];
$username = $_SESSION["username"];
$role_name = $_SESSION["role_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@5.0.2/dist/jspdf.plugin.autotable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <!-- Include html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/sidebar.css">
    <?php include "config/includes/header.php"; ?>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <script src="assets/js/main.js">
    </script>
    <title>FOCA</title>
</head>

<body class="bg-base-100">
        <!-- Sidebar -->
        <nav id="sidebar" class="box-border h-screen w-60 bg-base-200 sticky top-0 self-start overflow-hidden text-nowrap shadow-lg">
            <!-- App Name -->
            <ul id="sidebar-togle" class="list-none space-y-2 m-0 p-0">
                <li class="flex justify-end mb-4">
                    <span class="rounded-md p-2 flex items-center gap-3">
                        <img class="h-13" src="assets/images/logo_inline.png">
                    </span>
                    <button id="toggle-btn" class="m-auto p-2 border-none rounded-md bg-none cursor-pointer hover:bg-base-300">
                        <i id="toggle-icon" class="fa-solid fa-angles-left transition-transform duration-150 ease-in-out"></i>
                    </button>
                </li>
                <!-- User Info Section -->
                <div class="flex items-center gap-4 mb-6 rounded-lg  ">
                    <!-- Avatar with ring effect -->
                    <div class="avatar avatar-placeholder">
                        <div class="w-11 h-11 rounded-full bg-primary ring-2 ring-black ">
                            <span class="text-2xl font-bold text-primary-content"><?= $name[0] . $last_name[0] ?></span>
                        </div>
                    </div>
    
                    <!-- Name & Role -->
                    <div class="flex flex-col">
                        <h2 class="text-md font-semibold text-base-content w-max"><?= htmlspecialchars(
                            $name . " " . $last_name
                        ) ?></h2>
                        <span class="text-sm text-primary"><?= $role_name ?></span>
                    </div>
                </div>
            </ul>

            <ul id="sidebar-links" class="space-y-2 m-0 p-0"></ul>
        </nav>

        <!-- Main Content -->
        <main id="main-content" class="main-content w-full p-8 bg-base-100 overflow-y-auto">
            <!-- Content will be loaded here dynamically -->
        </main>
    <!-- <script src="assets/js/auth.js">
    </script> -->
</body>

</html>