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

}

?>