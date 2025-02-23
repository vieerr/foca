<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FOCA</title>
    <link href="./assets/daisyui.css" rel="stylesheet">
    <script src="./assets/tailwind.js"></script>
</head>
<body class="bg-base-100">
    <div class="flex min-h-screen">

        <!-- Main Content -->
        <div class="main-content flex-1 p-8 bg-base-100">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Income Card -->
                <div class="card bg-base-200 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-primary">Income</h2>
                        <p class="text-2xl font-bold">$2,000</p>
                        <p class="text-sm text-gray-500">This month</p>
                    </div>
                </div>
                <!-- Expenses Card -->
                <div class="card bg-base-200 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-secondary">Expenses</h2>
                        <p class="text-2xl font-bold">$100</p>
                        <p class="text-sm text-gray-500">This month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
