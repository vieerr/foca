<?php
include "config/includes/header.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - FOCA</title>
</head>

<body class="bg-base-100">
    <div class="min-h-screen flex items-center justify-center">
        <main class="bg-base-200 shadow-lg w-1/2 overflow-hidden flex rounded-2xl">
            <form id="login" method="post" action="router.php?route=login"
                class="p-5 w-full flex flex-col justify-center">
                <div class="p-3 flex justify-center items-center">
                    <img src="assets/images/logo.png" alt="logo_foca" class="">
                </div>
                <div class="form-control">
                    <label class="mb-2 text-[#333] font-medium" for="username">Usuario</label>
                    <input type="text" id="username" name="username"
                        class="w-full py-2 px-3 rounded-lg border-2 border-[#e0e0e0] bg-base-100 mb-6" required>
                </div>
                <div class="form-control">
                    <label class="mb-2 text-[#333] font-medium" for="password">Contraseña</label>
                    <input type="password" id="password" name="password"
                        class="w-full py-2 px-3 rounded-lg border-2 border-[#e0e0e0] bg-base-100" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4 w-full rounded-3xl">Ingresar</button>
            </form>
            <div class="max-lg:hidden">
                <img src="assets/images/login_img.jpg" alt="login_image">
            </div>
        </main>
    </div>
</body>

</html>