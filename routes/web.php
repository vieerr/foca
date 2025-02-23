<?php
require "../app/controllers/AuthController.php";
require "../app/controllers/DashboardController.php";

$router = new Router();

// Define routes
$router->add("GET", "/", "AuthController@login");
$router->add("POST", "/login", "AuthController@handleLogin");
$router->add("GET", "/dashboard", "DashboardController@index");
$router->add("POST", "/add-transaction", "DashboardController@addTransaction");

// Dispatch the request
$router->dispatch($_SERVER["REQUEST_URI"]);
?>
