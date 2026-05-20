<?php

require_once __DIR__ . '/../models/Berita.php';
require_once __DIR__ . '/../models/Kategori.php';

class BeritaController {
    private $berita;
    private $kategori;

    public function __construct() {
        $this->berita = new Berita();
        $this->kategori = new Kategori();
    }

    private function input() {
        $json = json_decode(file_get_contents('php://input'), true);
        if (is_array($json)) return $json;

        if (!empty($_POST)) return $_POST;

        parse_str(file_get_contents('php://input'), $parsed);
        return $parsed ?: [];
    }

    // GET /berita
    public function index() {
        $data = $this->berita->getAll();
        echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
    }

    // GET /berita/{id}
    public function show($id) {
        $data = $this->berita->getById($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Berita not found'], JSON_PRETTY_PRINT);
        }
    }

    // POST /berita
    public function store() {
        $input = $this->input();

        // Validasi
        $required = ['kategori_id', 'judul', 'isi'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        // Validasi kategori_id
        if (!$this->kategori->getById($input['kategori_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'kategori_id is invalid']);
            return;
        }

        $today = date('Y-m-d');

        $payload = [
            'kategori_id' => (int)$input['kategori_id'],
            'judul' => trim($input['judul']),
            'isi' => trim($input['isi']),
            'gambar' => $input['gambar'] ?? null,
            'created_at' => $today,
            'updated_at' => $today
        ];

        if ($this->berita->create($payload)) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Berita created']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create berita']);
        }
    }

    // PUT /berita/{id}
    public function update($id) {
        $input = $this->input();

        $existing = $this->berita->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Berita not found']);
            return;
        }

        $required = ['kategori_id', 'judul', 'isi'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        if (!$this->kategori->getById($input['kategori_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'kategori_id is invalid']);
            return;
        }

        $payload = [
            'kategori_id' => (int)$input['kategori_id'],
            'judul' => trim($input['judul']),
            'isi' => trim($input['isi']),
            'gambar' => $input['gambar'] ?? null,
            'updated_at' => date('Y-m-d')
        ];

        if ($this->berita->update($id, $payload)) {
            echo json_encode(['status' => 'success', 'message' => 'Berita updated']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update berita']);
        }
    }

    // DELETE /berita/{id}
    public function destroy($id) {
        if ($this->berita->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Berita deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Berita not found']);
        }
    }
}
?>
