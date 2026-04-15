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
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/controllers/KategoriController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

// Remove base path if any
$basePath = '/simple_api'; // Adjust if needed
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
$requestUri = trim($requestUri, '/');

$controller = new KategoriController();
$pathParts = explode('/', $requestUri);
$resource = $pathParts[0] ?? '';
$id = $pathParts[1] ?? null;

try {
    switch ($resource) {
        case 'kategori':
            if ($id === null) {
                // /kategori
                if ($requestMethod === 'GET') {
                    $controller->getAll();
                } elseif ($requestMethod === 'POST') {
                    $controller->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                // /kategori/{id}
                if ($requestMethod === 'GET') {
                    $controller->getById($id);
                } elseif ($requestMethod === 'PUT') {
                    $controller->update($id);
                } elseif ($requestMethod === 'DELETE') {
                    $controller->delete($id);
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
