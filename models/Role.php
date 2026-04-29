<?php
/**
 * Role Model - OOP CRUD operations
 */

require_once __DIR__ . '/../config/Database.php';

class Role {
    private $db;
    private $table = 'role';

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (role) VALUES (:role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function existsById($id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
