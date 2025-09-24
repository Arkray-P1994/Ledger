<?php

namespace Src\Config;

use mysqli;
use mysqli_sql_exception;

class Database
{
    private $host = "localhost";
    private $db_name = "todo";
    private $username = "root";
    private $password = "";
    private $port = 3306;
    public $conn;

    public function connect()
    {
        try {
            // Enable mysqli exception mode
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db_name,
                $this->port
            );

            // Set charset
            $this->conn->set_charset("utf8");

            return $this->conn;
        } catch (mysqli_sql_exception $e) {
            // More detailed error information
            $error_message = "Database connection failed: ";

            switch ($e->getCode()) {
                case 2002:
                    $error_message .= "MySQL server is not running. Please start MySQL in XAMPP Control Panel.";
                    break;
                case 1045:
                    $error_message .= "Access denied. Check username and password.";
                    break;
                case 1049:
                    $error_message .= "Database '{$this->db_name}' does not exist.";
                    break;
                default:
                    $error_message .= $e->getMessage();
            }

            http_response_code(500);
            die(json_encode([
                "error" => $error_message,
                "code" => $e->getCode(),
                "troubleshooting" => [
                    "1. Make sure XAMPP MySQL service is running",
                    "2. Check if port 3306 is available",
                    "3. Verify database 'todo' exists",
                    "4. Check MySQL credentials"
                ]
            ]));
        }
    }
}
