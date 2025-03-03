<?php
require_once "app/controllers/sessionController.php";
require_once "app/controllers/userController.php";
require_once "app/controllers/dashboardController.php";
require_once "app/controllers/profileController.php";
require_once "app/controllers/incomeController.php";
require_once "app/controllers/rolController.php";
require_once "app/controllers/expenseController.php";
require_once "app/controllers/reportController.php";
require_once "app/controllers/auditController.php";
require_once "app/controllers/permitController.php";
require_once "app/controllers/regController.php";

$incomeController = new IncomeController();
$regController = new RegController();
$profileController = new ProfileController();
$sessionController = new SessionController();
$userController = new UsuarioController();
$dashboardController = new DashboardController();
$rolController = new RolController();
$expenseController = new ExpenseController();
$reportController = new ReportController();
$auditController = new AuditController();
$permitController = new PermitController();