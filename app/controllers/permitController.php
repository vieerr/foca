<?php
require_once "app/models/PermisoModel.php";

class PermitController
{
    private $permisoModel;

    public function __construct()
    {
        $this->permisoModel = new Permiso();
    }

    public function fetchPermisos()
    {
        $roles = $this->permisoModel->get_permiso();
        header("Content-Type: application/json");
        echo json_encode($roles);
        exit();
    }

}

?>