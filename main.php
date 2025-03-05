<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include jsPDF library -->
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@5.0.2/dist/jspdf.plugin.autotable.js"></script>
    <!-- Include PapaParse library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <!-- Include html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php include "config/includes/header.php"; ?>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <script src="assets/js/main.js">
    </script>
    <title>FOCA</title>
</head>

<body class="bg-base-100 w-screen">
    <!-- App Container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-base-200 text-base-content w-64 p-6 shadow-lg">
            <!-- App Name -->
            <div class="flex items-center mb-8 ">
                <!-- <div class="text-2xl font-bold text-primary">FOCA</div> -->
                <img class="h-14" src="assets/images/logo_inline.png">
            </div>

            <ul id="sidebar-links" class="space-y-2 m-0 p-0"></ul>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="main-content w-full p-8 bg-base-100">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>

    <!-- <script src="assets/js/auth.js">
    </script> -->
</body>

</html>