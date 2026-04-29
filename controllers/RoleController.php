<?php
/**
 * Role Controller - RESTful API endpoints
 */

require_once __DIR__ . '/../models/Role.php';

class RoleController {
    private $role;

    public function __construct() {
        $this->role = new Role();
    }

    public function getAll() {
        $result = $this->role->getAll();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    }

    public function getById($id) {
        $result = $this->role->getById($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Role not found'], JSON_PRETTY_PRINT);
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['role']) || empty(trim($input['role']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'role is required'], JSON_PRETTY_PRINT);
                return;
            }

            if ($this->role->create(['role' => trim($input['role'])])) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Role created successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create role'], JSON_PRETTY_PRINT);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['role']) || empty(trim($input['role']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'role is required'], JSON_PRETTY_PRINT);
                return;
            }

            if ($this->role->update($id, ['role' => trim($input['role'])])) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Role updated successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Role not found or failed to update'], JSON_PRETTY_PRINT);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($this->role->delete($id)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Role deleted successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Role not found'], JSON_PRETTY_PRINT);
            }
        }
    }
}
?>
