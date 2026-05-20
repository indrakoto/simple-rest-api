<?php

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {
    private $kategori;

    public function __construct() {
        $this->kategori = new Kategori();
    }

    private function input() {
        $json = json_decode(file_get_contents('php://input'), true);
        if (is_array($json)) return $json;

        if (!empty($_POST)) return $_POST;

        parse_str(file_get_contents('php://input'), $parsed);
        return $parsed ?: [];
    }

    // GET /kategori
    public function index() {
        $data = $this->kategori->getAll();
        echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
    }

    // GET /kategori/{id}
    public function show($id) {
        $data = $this->kategori->getById($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Kategori not found'], JSON_PRETTY_PRINT);
        }
    }

    // POST /kategori
    public function store() {
        $input = $this->input();

        if (empty($input['nama_kategori'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'nama_kategori is required']);
            return;
        }

        $ok = $this->kategori->create([
            'nama_kategori' => trim($input['nama_kategori'])
        ]);

        if ($ok) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Kategori created']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create kategori']);
        }
    }

    // PUT /kategori/{id}
    public function update($id) {
        $input = $this->input();

        if (empty($input['nama_kategori'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'nama_kategori is required']);
            return;
        }

        $ok = $this->kategori->update($id, [
            'nama_kategori' => trim($input['nama_kategori'])
        ]);

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori updated']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Kategori not found']);
        }
    }

    // DELETE /kategori/{id}
    public function destroy($id) {
        $ok = $this->kategori->delete($id);

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Kategori not found']);
        }
    }
}
