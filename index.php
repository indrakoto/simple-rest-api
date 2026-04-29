<?php
/**
 * RESTful API Router - Kategori CRUD
 * Native PHP OOP Implementation
 * 
 * Endpoints:
 * GET    /kategori           - List all categories
 * GET    /kategori/{id}      - Get category by ID  
 * POST   /kategori           - Create new category
 * PUT    /kategori/{id}      - Update category
 * DELETE /kategori/{id}      - Delete category
 */

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

// Remove base path if any
$basePath = '/simple_api'; // Adjust if needed
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
$requestUri = trim($requestUri, '/');

if ($requestUri === '') {
    header('Content-Type: text/html; charset=UTF-8');
    http_response_code(200);
    echo "<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Halaman Webservice</title>
</head>
<body>
    <h1>Selamat Datang di Halaman Webservice.</h1>
</body>
</html>";
    exit();
}

// API response content type
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight OPTIONS request
if ($requestMethod === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/controllers/KategoriController.php';
require_once __DIR__ . '/controllers/RoleController.php';
require_once __DIR__ . '/controllers/UsersController.php';

$kategoriController = new KategoriController();
$roleController = new RoleController();
$usersController = new UsersController();

$pathParts = explode('/', $requestUri);
$resource = $pathParts[0] ?? '';
$id = $pathParts[1] ?? null;

try {
    switch ($resource) {
        case 'kategori':
            if ($id === null) {
                // /kategori
                if ($requestMethod === 'GET') {
                    $kategoriController->getAll();
                } elseif ($requestMethod === 'POST') {
                    $kategoriController->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                // /kategori/{id}
                if ($requestMethod === 'GET') {
                    $kategoriController->getById($id);
                } elseif ($requestMethod === 'PUT') {
                    $kategoriController->update($id);
                } elseif ($requestMethod === 'DELETE') {
                    $kategoriController->delete($id);
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            }
            break;

        case 'role':
            if ($id === null) {
                if ($requestMethod === 'GET') {
                    $roleController->getAll();
                } elseif ($requestMethod === 'POST') {
                    $roleController->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                if ($requestMethod === 'GET') {
                    $roleController->getById($id);
                } elseif ($requestMethod === 'PUT') {
                    $roleController->update($id);
                } elseif ($requestMethod === 'DELETE') {
                    $roleController->delete($id);
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            }
            break;

        case 'users':
            if ($id === null) {
                if ($requestMethod === 'GET') {
                    $usersController->getAll();
                } elseif ($requestMethod === 'POST') {
                    $usersController->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                if ($requestMethod === 'GET') {
                    $usersController->getById($id);
                } elseif ($requestMethod === 'PUT') {
                    $usersController->update($id);
                } elseif ($requestMethod === 'DELETE') {
                    $usersController->delete($id);
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint not found'], JSON_PRETTY_PRINT);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_PRETTY_PRINT);
}
?>
