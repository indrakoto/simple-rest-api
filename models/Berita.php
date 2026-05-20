<?php
/**
 * Berita Model - CRUD operations
 */

require_once __DIR__ . '/../config/Database.php';

class Berita {
    private $db;
    private $table = 'berita';

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    // GET all berita
    public function getAll() {
        $query = "SELECT b.*, k.nama_kategori 
                  FROM {$this->table} b
                  LEFT JOIN kategori k ON b.kategori_id = k.id
                  ORDER BY b.id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET berita by ID
    public function getById($id) {
        $query = "SELECT b.*, k.nama_kategori 
                  FROM {$this->table} b
                  LEFT JOIN kategori k ON b.kategori_id = k.id
                  WHERE b.id = :id LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // POST - Create berita
    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  (kategori_id, judul, isi, gambar, created_at, updated_at)
                  VALUES (:kategori_id, :judul, :isi, :gambar, :created_at, :updated_at)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':kategori_id', $data['kategori_id']);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':isi', $data['isi']);
        $stmt->bindParam(':gambar', $data['gambar']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    // PUT - Update berita
    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET kategori_id = :kategori_id,
                      judul = :judul,
                      isi = :isi,
                      gambar = :gambar,
                      updated_at = :updated_at
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':kategori_id', $data['kategori_id']);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':isi', $data['isi']);
        $stmt->bindParam(':gambar', $data['gambar']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    // DELETE berita
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
?>
