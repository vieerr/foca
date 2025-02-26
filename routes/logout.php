<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "../app/controllers/auth.php";
$con = new AuthController();
$con->logout();

?>
