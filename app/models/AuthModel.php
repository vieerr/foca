<?php
require_once "Model.php";
class Autorizacion extends Model
{
    public static $table = "Autorizaciones";
    private $conn;

    public function __construct()
    {
        $this->conn = self::getConn();
    }

    // Devuelve un array con los nombres de los permisos del rol
    public function getPermissionsByRole($id_rol)
    {
        $stmt = $this->conn->prepare("SELECT p.nombre_permiso
                                      FROM Autorizaciones a
                                      JOIN Permisos p ON a.id_permiso = p.id_permiso
                                      WHERE a.id_rol = ?");

        $stmt->bind_param("i", $id_rol);
        $stmt->execute();

        $result = $stmt->get_result();
        $permissions = [];
        while ($row = $result->fetch_assoc()) {
            $permissions[] = $row["nombre_permiso"];
        }

        $stmt->close();
        return $permissions;
    }

    public function createAutoriza($id_rol, $id_permiso)
    {
        return self::insert(self::$table, [
            "id_rol" => $id_rol,
            "id_permiso" => $id_permiso
        ]);
    }
}
