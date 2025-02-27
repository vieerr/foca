<?php
class Model
{
    private static $conn = null;

    public static function getConn()
    {
        if (self::$conn === null) {
            $host = "localhost";
            $user = "root";
            $pass = "Negra123%";
            $dbname = "economiaf";

            self::$conn = new mysqli($host, $user, $pass, $dbname);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }
}
