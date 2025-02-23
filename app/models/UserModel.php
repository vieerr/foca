
<?php
require_once "Model.php";

class UserModel extends Model
{
    // missing role param
    public function createUser($username, $password)
    {
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        return $this->conn->query($query);
    }

    public function findByUsername($username)
    {
        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM Usuarios WHERE username_usuario = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Handle prepare error
            die("Prepare failed: " . $this->conn->error);
        }

        // Bind the username parameter
        $stmt->bind_param("s", $username);

        // Execute the query
        if (!$stmt->execute()) {
            // Handle execute error
            die("Execute failed: " . $stmt->error);
        }

        // Get the result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the first row as an associative array
            return $result->fetch_assoc();
        } else {
            // No rows found
            return null;
        }
    }

    public function findById($id_username)
    {
        $query = "SELECT * FROM users WHERE id_username = $id_username";
        $res = $this->conn->query($query);
        return $res->fetch_assoc();
    }
}


?>
