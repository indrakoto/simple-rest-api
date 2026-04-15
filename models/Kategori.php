<?php
/**
 * Kategori Model - OOP CRUD operations
 */

require_once __DIR__ . '/../config/Database.php';

class Kategori {
    private $db;
    private $table = 'kategori';
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    // GET all categories
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // GET category by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // POST - Create new category
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nama_kategori) VALUES (:nama_kategori)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_kategori', $data['nama_kategori']);
        return $stmt->execute();
    }
    
    // PUT - Update category
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nama_kategori = :nama_kategori WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_kategori', $data['nama_kategori']);
        return $stmt->execute();
    }
    
    // DELETE category
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
