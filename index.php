<?php
include "config/includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - FOCA</title>
</head>
<body class="bg-base-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="card bg-base-200 shadow-lg w-96">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-4">Login</h2>

                <form id="loginForm" method="post" action="app/controllers/auth.php">
                    <div class="form-control">
                        <label class="label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="input input-bordered" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- <script src="assets/js/login.js" ></script> -->
</html>
