<?php
require_once "Model.php";

class Usuario extends Model
{
    protected static $table = "usuarios"; // Define the table name

    public function createUser(
        $nombre_usuario,
        $apellido_usuario,
        $username_usuario,
        $password_plain,
        $id_rol
    ) {
        $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
        $estado_usuario = "activo";

        $data = [
            "nombre_usuario" => $nombre_usuario,
            "apellido_usuario" => $apellido_usuario,
            "username_usuario" => $username_usuario,
            "claveHash_usuario" => $password_hash,
            "id_rol" => $id_rol,
            "estado_usuario" => $estado_usuario,
        ];

        return self::insert(self::$table, $data); // Use the generic insert method
    }

    public function getUserByUsername($username)
    {
        $conditions = [
            "username_usuario" => $username,
            "estado_usuario" => "activo",
        ];

        $result = self::select(self::$table, ["*"], $conditions); // Use the generic select method with a limit
        return !empty($result) ? $result[0] : null; // Return the first row or null
    }

    public function getInfoUsers()
    {
        $query = "SELECT id_usuario, nombre_usuario, apellido_usuario, username_usuario, nombre_rol
                  FROM usuarios u
                  JOIN roles r ON u.id_rol = r.id_rol";

        $conn = self::getConn();
        $result = $conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error fetching users: " . $conn->error);
        }
    }

    public function editUser($id, $fields)
    {
        return self::update(table: self::$table, data: $fields, conditions: ["id_usuario" => $id]);
    }


    public function fetchAllUsers()
    {
        $query = "SELECT u.id_usuario, u.nombre_usuario, u.apellido_usuario, u.username_usuario, u.estado_usuario, r.nombre_rol
                  FROM usuarios u
                  JOIN roles r ON u.id_rol = r.id_rol";

        $conn = self::getConn();
        $result = $conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error fetching users: " . $conn->error);
        }
    }
}
