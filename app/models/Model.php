<?php
class Model
{
    public $conn;
    public function __construct()
    {
        $this->conn = $this->getConn();
    }

    private function getConn()
    {
        $host = "localhost";
        $user = "admin";
        $pass = "admin";
        $dbname = "foca";

        $conn = new mysqli($host, $user, $pass, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>
