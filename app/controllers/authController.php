<?php
require_once "app/models/AuthModel.php";

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new Autorizacion();
    }

    public function fetchRolPerms()
    {

        $id = $_SESSION["role"] ?? null;
        if (!$id) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "ID is required"]);
            exit();
        }

        $res = $this->authModel->get_rol_perms($id);
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }

}

?>