<?php
/**
 * Users Controller - RESTful API endpoints
 */

require_once __DIR__ . '/../models/Users.php';
require_once __DIR__ . '/../models/Role.php';

class UsersController {
    private $users;
    private $role;

    public function __construct() {
        $this->users = new Users();
        $this->role = new Role();
    }

    public function getAll() {
        $result = $this->users->getAll();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    }

    public function getById($id) {
        $result = $this->users->getById($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'User not found'], JSON_PRETTY_PRINT);
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            $requiredFields = ['nama', 'username', 'email', 'password'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty(trim((string) $input[$field]))) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => $field . ' is required'], JSON_PRETTY_PRINT);
                    return;
                }
            }

            $roleId = isset($input['role_id']) && $input['role_id'] !== '' ? (int) $input['role_id'] : null;
            if ($roleId !== null && !$this->role->existsById($roleId)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'role_id is invalid'], JSON_PRETTY_PRINT);
                return;
            }

            $isActive = isset($input['is_active']) ? (int) $input['is_active'] : 0;
            $today = date('Y-m-d');

            $payload = [
                'nama' => trim($input['nama']),
                'username' => trim($input['username']),
                'email' => trim($input['email']),
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'role_id' => $roleId,
                'is_active' => $isActive,
                'created_at' => $today,
                'updated_at' => $today
            ];

            if ($this->users->create($payload)) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'User created successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create user'], JSON_PRETTY_PRINT);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);

            $requiredFields = ['nama', 'username', 'email'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty(trim((string) $input[$field]))) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => $field . ' is required'], JSON_PRETTY_PRINT);
                    return;
                }
            }

            $existing = $this->users->getById($id);
            if (!$existing) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'User not found'], JSON_PRETTY_PRINT);
                return;
            }

            $roleId = isset($input['role_id']) && $input['role_id'] !== '' ? (int) $input['role_id'] : null;
            if ($roleId !== null && !$this->role->existsById($roleId)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'role_id is invalid'], JSON_PRETTY_PRINT);
                return;
            }

            $isActive = isset($input['is_active']) ? (int) $input['is_active'] : (int) $existing['is_active'];

            $payload = [
                'nama' => trim($input['nama']),
                'username' => trim($input['username']),
                'email' => trim($input['email']),
                'role_id' => $roleId,
                'is_active' => $isActive,
                'updated_at' => date('Y-m-d')
            ];

            if (isset($input['password']) && !empty(trim((string) $input['password']))) {
                $payload['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
            }

            if ($this->users->update($id, $payload)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to update user'], JSON_PRETTY_PRINT);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $existing = $this->users->getById($id);
            if (!$existing) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'User not found'], JSON_PRETTY_PRINT);
                return;
            }

            if ($this->users->delete($id)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user'], JSON_PRETTY_PRINT);
            }
        }
    }
}
?>
