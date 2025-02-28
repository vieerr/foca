
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "config/includes/header.php"; ?>
      <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <script type="module" src="https://unpkg.com/cally"></script>
    <script src="assets/js/main.js">
    </script>
    <title>FOCA</title>
</head>
<body class="bg-base-100">
    <!-- App Container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-base-200 text-base-content w-64 p-6 shadow-lg">
            <!-- App Name -->
            <div class="flex items-center mb-8 ">
                <!-- <div class="text-2xl font-bold text-primary">FOCA</div> -->
                <img class="h-14" src="assets/images/logo_inline.png" >
            </div>

            <ul id="sidebar-links" class="space-y-2 m-0 p-0"></ul>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="main-content flex-1 p-8 bg-base-100">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>

    <!-- <script src="assets/js/auth.js">
    </script> -->
</body>
</html>
