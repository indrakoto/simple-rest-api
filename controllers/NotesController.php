<?php

require_once __DIR__ . '/../models/Notes.php';
require_once __DIR__ . '/../models/Users.php';

class NotesController {
    private $notes;
    private $users;

    public function __construct() {
        $this->notes = new Notes();
        $this->users = new Users();
    }

    private function input() {
        $json = json_decode(file_get_contents('php://input'), true);
        if (is_array($json)) return $json;

        if (!empty($_POST)) return $_POST;

        parse_str(file_get_contents('php://input'), $parsed);
        return $parsed ?: [];
    }

    // GET /notes
    public function index() {
        $data = $this->notes->getAll();
        echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
    }

    // GET /notes/{id}
    public function show($id) {
        $data = $this->notes->getById($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Note not found'], JSON_PRETTY_PRINT);
        }
    }

    // POST /notes
    public function store() {
        $input = $this->input();

        $required = ['user_id', 'judul', 'isi'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        // Validasi user_id
        if (!$this->users->getById($input['user_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'user_id is invalid']);
            return;
        }

        $today = date('Y-m-d');

        $payload = [
            'user_id' => (int)$input['user_id'],
            'judul' => trim($input['judul']),
            'isi' => trim($input['isi']),
            'created_at' => $today,
            'updated_at' => $today
        ];

        if ($this->notes->create($payload)) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Note created']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create note']);
        }
    }

    // PUT /notes/{id}
    public function update($id) {
        $input = $this->input();

        $existing = $this->notes->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Note not found']);
            return;
        }

        $required = ['judul', 'isi'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        $payload = [
            'judul' => trim($input['judul']),
            'isi' => trim($input['isi']),
            'updated_at' => date('Y-m-d')
        ];

        if ($this->notes->update($id, $payload)) {
            echo json_encode(['status' => 'success', 'message' => 'Note updated']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update note']);
        }
    }

    // DELETE /notes/{id}
    public function destroy($id) {
        if ($this->notes->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Note deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Note not found']);
        }
    }
}
?>
