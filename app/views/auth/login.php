<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.15.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Login</h1>
        <form method="POST" action="/login">
            <input type="text" name="username" placeholder="Username" class="input input-bordered w-full mb-2">
            <input type="password" name="password" placeholder="Password" class="input input-bordered w-full mb-2">
            <button type="submit" class="btn btn-primary w-full">Login</button>
        </form>
    </div>
</body>
</html>
