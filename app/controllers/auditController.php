<?php

require_once "app/models/Auditorias.php";
class AuditController
{


    private $auditModel;

    public function __construct()
    {

        $this->auditModel = new Auditorias();
    }

    public function index()
    {
        require "app/views/auditorias.php";
    }

    public function fetchAllAudits()
    {
        $res = $this->auditModel->getAuditorias();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }
}


?>