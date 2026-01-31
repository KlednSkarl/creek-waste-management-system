<?php

class Database
{
    private string $host = "localhost";
    private string $db_name = "creek_water_management";
    private string $username = "root";
    private string $password = "";
    private string $charset = "utf8mb4";

    public ?PDO $conn = null;

    public function connect(): ?PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->conn;
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }
}