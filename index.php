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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json; charset=UTF-8');

// Ambil URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Detect base path automatically
$scriptName = dirname($_SERVER['SCRIPT_NAME']); // e.g. /simple_api
$scriptName = trim($scriptName, '/');           // simple_api

if ($scriptName !== '') {
    if (strpos($uri, $scriptName) === 0) {
        $uri = substr($uri, strlen($scriptName));
    }
}

$uri = trim($uri, '/');

// Jika root → tampilkan halaman HTML
if ($uri === '') {
    header('Content-Type: text/html; charset=UTF-8');
    echo "<h1>Selamat Datang di Halaman Webservice.</h1>";
    exit();
}

// Pecah URI
$parts = explode('/', $uri);
$resource = $parts[0] ?? null;
$id = $parts[1] ?? null;

// Nama controller otomatis
$controllerName = ucfirst($resource) . 'Controller';
$controllerFile = __DIR__ . "/controllers/$controllerName.php";

// Cek controller
if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo json_encode(['error' => 'Resource not found']);
    exit();
}

require_once $controllerFile;
$controller = new $controllerName();

// Mapping HTTP method → method controller
$methodMap = [
    'GET'    => $id ? 'show' : 'index',
    'POST'   => 'store',
    'PUT'    => 'update',
    'DELETE' => 'destroy'
];

// Endpoint khusus (misalnya /users/login)
if ($resource === 'users' && $id === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
        exit();
    }
    http_response_code(405);
    echo json_encode(['error' => 'Use POST for login']);
    exit();
}

// Cek method
$httpMethod = $_SERVER['REQUEST_METHOD'];
if (!isset($methodMap[$httpMethod])) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$method = $methodMap[$httpMethod];

// Cek apakah method ada di controller
if (!method_exists($controller, $method)) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not implemented']);
    exit();
}

// Jalankan method
try {
    $id ? $controller->$method($id) : $controller->$method();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
