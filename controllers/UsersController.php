<?php

require_once __DIR__ . '/../models/Users.php';
require_once __DIR__ . '/../models/Role.php';

class UsersController {
    private $users;
    private $role;

    public function __construct() {
        $this->users = new Users();
        $this->role = new Role();
    }

    private function input() {
        $json = json_decode(file_get_contents('php://input'), true);
        if (is_array($json)) return $json;
        if (!empty($_POST)) return $_POST;

        parse_str(file_get_contents('php://input'), $parsed);
        return $parsed ?: [];
    }

    // GET /users
    public function index() {
        $data = $this->users->getAll();
        echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
    }

    // GET /users/{id}
    public function show($id) {
        $data = $this->users->getById($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'User not found'], JSON_PRETTY_PRINT);
        }
    }

    // POST /users
    public function store() {
        $input = $this->input();

        $required = ['nama', 'username', 'email', 'password'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        $roleId = isset($input['role_id']) ? (int)$input['role_id'] : null;
        if ($roleId && !$this->role->existsById($roleId)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'role_id is invalid']);
            return;
        }

        $today = date('Y-m-d');

        $payload = [
            'nama' => trim($input['nama']),
            'username' => trim($input['username']),
            'email' => trim($input['email']),
            'password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'role_id' => $roleId,
            'is_active' => (int)($input['is_active'] ?? 0),
            'created_at' => $today,
            'updated_at' => $today
        ];

        if ($this->users->create($payload)) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'User created']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create user']);
        }
    }

    // PUT /users/{id}
    public function update($id) {
        $input = $this->input();

        $existing = $this->users->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        $required = ['nama', 'username', 'email'];
        foreach ($required as $field) {
            if (empty(trim($input[$field] ?? ''))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                return;
            }
        }

        $roleId = isset($input['role_id']) ? (int)$input['role_id'] : null;
        if ($roleId && !$this->role->existsById($roleId)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'role_id is invalid']);
            return;
        }

        $payload = [
            'nama' => trim($input['nama']),
            'username' => trim($input['username']),
            'email' => trim($input['email']),
            'role_id' => $roleId,
            'is_active' => (int)($input['is_active'] ?? $existing['is_active']),
            'updated_at' => date('Y-m-d')
        ];

        if (!empty(trim($input['password'] ?? ''))) {
            $payload['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        if ($this->users->update($id, $payload)) {
            echo json_encode(['status' => 'success', 'message' => 'User updated']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
        }
    }

    // DELETE /users/{id}
    public function destroy($id) {
        $existing = $this->users->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        if ($this->users->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
        }
    }

    // POST /users/login
    public function login() {
        $input = $this->input();

        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if ($email === '' || $password === '') {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
            return;
        }

        $user = $this->users->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

            if ($user['is_active'] == 0) {
                http_response_code(403);
                echo json_encode(['status' => 'error', 'message' => 'Account is inactive']);
                return;
            }

            unset($user['password']);

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => $user
            ], JSON_PRETTY_PRINT);

        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    }
}
