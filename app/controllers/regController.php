<?php

include_once "app/models/RegistroModel.php";
class RegController
{
    private $regModel;
    public function __construct()
    {
        $this->regModel = new Registro();
    }

    public function fetchAllRegs()
    {
        $regs = $this->regModel->getAll();
        header("Content-Type: application/json");
        echo json_encode($regs);
        exit();
    }


}
?>