<!-- file to add cdn n show errors to current file -->

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "app/controllers/sessionController.php";
?>

<script src="assets/tailwind.js"></script>
<link href="assets/daisyui.css" rel="stylesheet">
<!-- jQuery -->
<script src="assets/jquery.js"></script>
<script src="assets/chart.js.js"></script>