<?php
require_once "app/models/RolModel.php";
require_once "app/models/PermisoModel.php";
require_once "app/models/AuthModel.php";

class RolController
{
    private $rolModel;
    private $permisoModel;

    public function __construct()
    {
        $this->rolModel = new Rol();
        $this->permisoModel = new Permiso();
    }
    public function fetchRoles()
    {
        $roles = $this->rolModel->getRoles();
        header("Content-Type: application/json");
        echo json_encode($roles);

        exit();
    }

    public function fetchRole()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);

        $role = $this->rolModel->getRole($data["id_rol"])[0];
        header("Content-Type: application/json");
        echo json_encode($role);
    }

    public function fetchRoleName($roleId)
    {
        $role = $this->rolModel->getRoleName($roleId)[0]["nombre_rol"];
        return $role;
    }


    public function index()
    {
        require "app/views/roles.php";
    }

    public function crearRol()
    {
        header('Content-Type: application/json');
        $nombre_rol = trim($_POST['nombre_rol']);
        $descripcion_rol = trim($_POST['descripcion_rol']);
        $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];
        $result = $this->rolModel->createRol($nombre_rol, $descripcion_rol);

        if ($result) {
            // Obtener el ID del nuevo rol
            $idNuevo = $this->rolModel->getId($nombre_rol);

            if ($idNuevo) {
                // Asociar los permisos seleccionados
                $autoriza = new Autorizacion();
                foreach ($permisos as $permiso) {
                    $autoriza->createAutoriza($idNuevo, $permiso);
                }
                echo json_encode(['success' => true, 'message' => 'Rol creado exitosamente.']);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al obtener el ID del nuevo rol.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el rol.']);
            exit();
        }
    }



    public function editRol()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);


        $id = $data['id_rol'] ?? null;
        if (!$id) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "ID is required"]);
            exit();
        }
        $permisos = $data["permisos"] ?? [];
        $allowedFields = [
            "descripcion_rol" => "descripcion_rol",
            // "permisos" => "permisos",
            "estado_rol" => "estado_rol",
            "nombre_rol" => "nombre_rol",
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


        $res = $this->rolModel->updateRol($id, $fields);

        if ($res) {
            // Obtener el ID del nuevo rol
            $idNuevo = $this->rolModel->getId($data['nombre_rol']);

            if ($idNuevo) {
                // Asociar los permisos seleccionados
                $autoriza = new Autorizacion();
                $autoriza->deleteAutoriza($idNuevo);
                foreach ($permisos as $permiso) {
                    $autoriza->createAutoriza($idNuevo, $permiso);
                }
                echo json_encode(['success' => true, 'message' => 'Rol creado exitosamente.']);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al obtener el ID del nuevo rol.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el rol.']);
            exit();
        }
    }


}

?>