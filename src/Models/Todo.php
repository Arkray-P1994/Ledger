<?php

namespace Src\Models;

class Todo
{
    private $conn;
    private $table = "todo";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $sql = "SELECT id, name, status FROM " . $this->table;
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    /**
     * Create a new todo
     * @param string $name
     * @param string|null $status
     * @return int|false inserted id on success, false on failure
     */
    public function create(string $name, ?string $status = null)
    {
        $sql = "INSERT INTO {$this->table} (name, status) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        // Bind parameters (s = string, allow null for status)
        $stmt->bind_param("ss", $name, $status);

        if ($stmt->execute()) {
            $insertId = $stmt->insert_id;
            $stmt->close();
            return $insertId;
        } else {
            $stmt->close();
            return false;
        }
    }
}
