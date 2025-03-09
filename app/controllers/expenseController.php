<?php

include_once "app/models/RegistroModel.php";
class ExpenseController
{
    private $regModel;
    public function __construct()
    {
        $this->regModel = new Registro();
    }
    public function index()
    {
        require "app/views/gastos.php";
    }

    public function fetchAllExpense()
    {
        $res = $this->regModel->getAllExpenses();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }

    public function createExpense()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);
        $fecha_registro = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $fields = [
            "id_categoria" => $data["nombre_categoria"],
            "id_usuario"=> $_SESSION["user_id"],
            "fecha_accion" => $data["fecha_accion"],
            "metodo_registro" => $data["metodo_registro"],
            "valor_registro" => $data["valor_registro"],
            "nombre_registro"=> $data["nombre_registro"],
            "tipo_registro" => "egreso",
            "fecha_registro"=> $fecha_registro->format('Y-m-d H:i:s'),
            "estado_registro" => "activo",
        ];


        $res = $this->regModel->createReg($fields);


        if ($res) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "success", "message" => "Record added successfully"]);
        } else {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "Failed to update record"]);
        }
        exit();
    }

    public function getOneExpense()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);
        $res = $this->regModel->findOne($data["id_registro"]);
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }


}
?>