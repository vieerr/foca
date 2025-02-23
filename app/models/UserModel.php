require_once 'Model.php';

<?php class UserModel extends Model
{
    // missing role param
    public function createUser($username, $password)
    {
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        return $this->conn->query($query);
    }

    public function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = $username";
        $res = $this->conn->query($query);
        return $res->fetch_assoc();
    }

    public function findById($id_username)
    {
        $query = "SELECT * FROM users WHERE id_username = $id_username";
        $res = $this->conn->query($query);
        return $res->fetch_assoc();
    }
}
?>
