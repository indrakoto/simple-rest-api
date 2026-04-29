<?php
/**
 * Kategori Controller - RESTful API endpoints
 */

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {
    private $kategori;
    
    public function __construct() {
        $this->kategori = new Kategori();
    }

    private function getInputData() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (is_array($input)) {
            return $input;
        }

        if (!empty($_POST)) {
            return $_POST;
        }

        parse_str(file_get_contents('php://input'), $parsedInput);
        if (is_array($parsedInput) && !empty($parsedInput)) {
            return $parsedInput;
        }

        return [];
    }
    
    public function getAll() {
        $result = $this->kategori->getAll();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    }
    
    public function getById($id) {
        $result = $this->kategori->getById($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Kategori not found'], JSON_PRETTY_PRINT);
        }
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = $this->getInputData();
            if (!isset($input['nama_kategori']) || empty(trim((string) $input['nama_kategori']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'nama_kategori is required'], JSON_PRETTY_PRINT);
                return;
            }
            
            if ($this->kategori->create(['nama_kategori' => trim((string) $input['nama_kategori'])])) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Kategori created successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create kategori'], JSON_PRETTY_PRINT);
            }
        }
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = $this->getInputData();
            if (!isset($input['nama_kategori']) || empty(trim((string) $input['nama_kategori']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'nama_kategori is required'], JSON_PRETTY_PRINT);
                return;
            }
            
            if ($this->kategori->update($id, ['nama_kategori' => trim((string) $input['nama_kategori'])])) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Kategori updated successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Kategori not found or failed to update'], JSON_PRETTY_PRINT);
            }
        }
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($this->kategori->delete($id)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Kategori deleted successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Kategori not found'], JSON_PRETTY_PRINT);
            }
        }
    }
}
?>
