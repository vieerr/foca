<?php
session_start();

$request = $_SERVER["REQUEST_URI"];
$basePath = "/foca/public";
$request = str_replace($basePath, "", $request);

switch ($request) {
    case "/":
    case "/login":
        require "../app/controllers/AuthController.php";
        $controller = new AuthController();
        $controller->login();
        break;
    case "/dashboard":
        require "../app/controllers/DashboardController.php";
        $controller = new DashboardController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
?>
