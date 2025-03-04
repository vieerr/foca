<?php

include_once "app/controllers/categoryController.php";
include_once "app/models/RegistroModel.php";
class RegController
{
    private $regModel;
    private $categoryController;
    public function __construct()
    {
        $this->categoryController = new CategoryController();
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


    public function updateReg()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);
    
        
        $id = $data['id_registro'] ?? null;
        if (!$id) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "ID is required"]);
            exit();
        }
    
        
        $allowedFields = [
            "id_categoria" => "nombre_categoria",
            "fecha_accion" => "fecha_accion",
            "metodo_registro" => "metodo_registro",
            "valor_registro" => "valor_registro",
            "estado_registro" => "estado_registro",
        ];
    
        
        $fields = [];
        foreach ($allowedFields as $dbField => $requestField) {
            if (isset($data[$requestField])) {
                $fields[$dbField] = $data[$requestField];
            }
        }
    
        
        if (empty($fields)) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "No fields provided to update"]);
            exit();
        }
    
        
        $res = $this->regModel->editReg($id, $fields);
    
        
        if ($res) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
        } else {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "Failed to update record"]);
        }
        exit();
    }

}
?>