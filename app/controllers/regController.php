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
        $res = $this->regModel->getAll();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }
    public function fetchAllRegsWithCats()
    {
        $res = $this->regModel->getAllWithCats();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }

}
?>