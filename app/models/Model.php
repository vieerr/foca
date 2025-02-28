<?php
class Model
{
    private static $conn = null;

    public static function getConn()
    {
        if (self::$conn === null) {
            $host = "localhost";
            $user = "admin";
            $pass = "admin";
            $dbname = "economiaf";

            self::$conn = new mysqli($host, $user, $pass, $dbname);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }

    /**
     * Generic method to execute a SELECT query.
     *
     * @param string $table The table name.
     * @param array $columns The columns to select (default is all columns).
     * @param array $conditions The WHERE conditions (optional).
     * @return array The result set as an associative array.
     */
    public static function select($table, $columns = ["*"], $conditions = [])
    {
        $conn = self::getConn();

        $columns = implode(", ", $columns);
        $sql = "SELECT $columns FROM $table";

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = '$value'";
            }
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Generic method to execute an INSERT query.
     *
     * @param string $table The table name.
     * @param array $data The data to insert (column => value).
     * @return int The ID of the inserted row.
     */
    public static function insert($table, $data)
    {
        $conn = self::getConn();

        $columns = implode(", ", array_keys($data));
        $values = implode("', '", array_values($data));
        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

        if (!$conn->query($sql)) {
            die("Insert failed: " . $conn->error);
        }

        return $conn->insert_id;
    }

    /**
     * Generic method to execute an UPDATE query.
     *
     * @param string $table The table name.
     * @param array $data The data to update (column => value).
     * @param array $conditions The WHERE conditions.
     * @return bool True on success, false on failure.
     */
    public static function update($table, $data, $conditions)
    {
        $conn = self::getConn();

        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(", ", $set);

        $where = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $where = implode(" AND ", $where);

        $sql = "UPDATE $table SET $set WHERE $where";

        return $conn->query($sql);
    }

    /**
     * Generic method to execute a DELETE query.
     *
     * @param string $table The table name.
     * @param array $conditions The WHERE conditions.
     * @return bool True on success, false on failure.
     */
    public static function delete($table, $conditions)
    {
        $conn = self::getConn();

        $where = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $where = implode(" AND ", $where);

        $sql = "DELETE FROM $table WHERE $where";

        return $conn->query($sql);
    }
}
