<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FOCA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.15.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-base-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="card bg-base-200 shadow-lg w-96">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-4">Login</h2>
                <form method="POST">
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
</html>
