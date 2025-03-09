<?php

session_start();
require_once "app/controllers/sessionController.php";

SessionController::isAuth() ? null : header( "Location: index.php");

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

            <ul id="sidebar-togle" class="list-none space-y-2 m-0 p-0">
                <li class="flex justify-end mb-4">
                    <span class="rounded-md p-2 flex items-center gap-3">
                        <img class="h-13" src="assets/images/logo_inline.png">
                    </span>
                    <button id="toggle-btn" class="m-auto p-2 border-none rounded-md bg-none cursor-pointer hover:bg-base-300">
                        <i id="toggle-icon" class="fa-solid fa-angles-left transition-transform duration-150 ease-in-out"></i>
                    </button>
                </li>
            </ul>
            <ul id="sidebar-links"></ul>
        </nav>

        <!-- Main Content -->
        <main id="main-content" class="main-content w-full p-8 bg-base-100">
            <!-- Content will be loaded here dynamically -->
        </main>
    <!-- <script src="assets/js/auth.js">
    </script> -->
</body>

</html>