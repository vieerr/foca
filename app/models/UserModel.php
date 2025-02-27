<?php
require_once "Model.php";
class Usuario extends Model
{
    private $conn;

    public function __construct()
    {
        $this->conn = self::getConn();
    }

    public function createUser(
        $nombre_usuario,
        $apellido_usuario,
        $username_usuario,
        $password_plain,
        $id_rol
    ) {
        $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
        $estado_usuario = "activo";
        $stmt = $this->conn->prepare(
            "INSERT INTO Usuarios (nombre_usuario, apellido_usuario, username_usuario, claveHash_usuario, id_rol, estado_usuario) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssssis",
            $nombre_usuario,
            $apellido_usuario,
            $username_usuario,
            $password_hash,
            $id_rol,
            $estado_usuario
        );

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Usuarios WHERE username_usuario = ? AND estado_usuario = 'activo' LIMIT 1"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        return $user;
    }

    public function fetchAllUsers()
    {
        $query = "SELECT u.id_usuario, u.nombre_usuario, u.apellido_usuario, u.username_usuario, u.estado_usuario, r.nombre_rol
                      FROM Usuarios u
                      JOIN Roles r ON u.id_rol = r.id_rol";
        $result = $this->conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error fetching users: " . $this->conn->error);
        }
    }
}
