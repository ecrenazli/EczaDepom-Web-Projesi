<?php
// KRİTER 86: Sunucu tarafında OOP (Class, Object)
class Database {
    private $host = "localhost";
    private $db_name = "eczadepom";
    private $username = "root";
    private $password = "";
    public $conn;

    public function baglantiGetir() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
        return $this->conn;
    }
}
$db = new Database();
$pdo = $db->baglantiGetir();
?>