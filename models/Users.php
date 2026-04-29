<?php
/**
 * Users Model - OOP CRUD operations
 */

require_once __DIR__ . '/../config/Database.php';

class Users {
    private $db;
    private $table = 'users';

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT u.id, u.nama, u.username, u.email, u.role_id, u.is_active, u.created_at, u.updated_at, r.role 
                  FROM " . $this->table . " u
                  LEFT JOIN role r ON u.role_id = r.id
                  ORDER BY u.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT u.id, u.nama, u.username, u.email, u.role_id, u.is_active, u.created_at, u.updated_at, r.role 
                  FROM " . $this->table . " u
                  LEFT JOIN role r ON u.role_id = r.id
                  WHERE u.id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nama, username, email, password, role_id, is_active, created_at, updated_at)
                  VALUES (:nama, :username, :email, :password, :role_id, :is_active, :created_at, :updated_at)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role_id', $data['role_id']);
        $stmt->bindParam(':is_active', $data['is_active']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET nama = :nama,
                      username = :username,
                      email = :email,
                      role_id = :role_id,
                      is_active = :is_active,
                      updated_at = :updated_at";

        if (isset($data['password']) && !empty($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role_id', $data['role_id']);
        $stmt->bindParam(':is_active', $data['is_active']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        if (isset($data['password']) && !empty($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
