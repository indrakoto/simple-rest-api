<?php
/**
 * Notes Model - CRUD operations
 */

require_once __DIR__ . '/../config/Database.php';

class Notes {
    private $db;
    private $table = 'notes';

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    // GET all notes (nanti bisa difilter user_id)
    public function getAll() {
        $query = "SELECT n.*, u.nama AS nama_user
                  FROM {$this->table} n
                  LEFT JOIN users u ON n.user_id = u.id
                  ORDER BY n.id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET notes by ID
    public function getById($id) {
        $query = "SELECT n.*, u.nama AS nama_user
                  FROM {$this->table} n
                  LEFT JOIN users u ON n.user_id = u.id
                  WHERE n.id = :id LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // GET notes by user_id
    public function getByUser($user_id) {
        $query = "SELECT * FROM {$this->table}
                  WHERE user_id = :user_id
                  ORDER BY id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // POST - Create note
    public function create($data) {
        $query = "INSERT INTO {$this->table}
                  (user_id, judul, isi, created_at, updated_at)
                  VALUES (:user_id, :judul, :isi, :created_at, :updated_at)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':isi', $data['isi']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    // PUT - Update note
    public function update($id, $data) {
        $query = "UPDATE {$this->table}
                  SET judul = :judul,
                      isi = :isi,
                      updated_at = :updated_at
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':isi', $data['isi']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    // DELETE note
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
?>
