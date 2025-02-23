<?php
include "config/includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOCA</title>
</head>
<body class="bg-base-100">
    <!-- App Container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-base-200 text-base-content w-64 p-6 shadow-lg">
            <!-- App Name -->
            <div class="flex items-center mb-8">
                <div class="text-2xl font-bold text-primary">FOCA</div>
            </div>

            <!-- Sidebar Links -->
            <ul class="space-y-2">
                <li>
                    <a href="#" data-route="dashboard" class="load-content flex items-center p-2 rounded-lg hover:bg-base-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" data-route="reports" class="load-content flex items-center p-2 rounded-lg hover:bg-base-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        Reports
                    </a>
                </li>
                <li>
                    <a href="#" data-route="profile" class="load-content flex items-center p-2 rounded-lg hover:bg-base-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Profile
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="main-content flex-1 p-8 bg-base-100">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>
    <script src="assets/js/sidebar.js">
    </script>
</body>
</html>
