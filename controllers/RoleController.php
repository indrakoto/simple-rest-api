<?php

require_once __DIR__ . '/../models/Role.php';

class RoleController {
    private $role;

    public function __construct() {
        $this->role = new Role();
    }

    private function input() {
        $json = json_decode(file_get_contents('php://input'), true);
        if (is_array($json)) return $json;

        if (!empty($_POST)) return $_POST;

        parse_str(file_get_contents('php://input'), $parsed);
        return $parsed ?: [];
    }

    // GET /role
    public function index() {
        $data = $this->role->getAll();
        echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
    }

    // GET /role/{id}
    public function show($id) {
        $data = $this->role->getById($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Role not found'], JSON_PRETTY_PRINT);
        }
    }

    // POST /role
    public function store() {
        $input = $this->input();

        if (empty(trim($input['role'] ?? ''))) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'role is required'], JSON_PRETTY_PRINT);
            return;
        }

        $payload = [
            'role' => trim($input['role'])
        ];

        if ($this->role->create($payload)) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Role created'], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create role'], JSON_PRETTY_PRINT);
        }
    }

    // PUT /role/{id}
    public function update($id) {
        $input = $this->input();

        if (empty(trim($input['role'] ?? ''))) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'role is required'], JSON_PRETTY_PRINT);
            return;
        }

        $payload = [
            'role' => trim($input['role'])
        ];

        if ($this->role->update($id, $payload)) {
            echo json_encode(['status' => 'success', 'message' => 'Role updated'], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Role not found or failed to update'], JSON_PRETTY_PRINT);
        }
    }

    // DELETE /role/{id}
    public function destroy($id) {
        if ($this->role->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Role deleted'], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Role not found'], JSON_PRETTY_PRINT);
        }
    }
}
