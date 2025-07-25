<?php
// index.php - Main entry point for the Practical Training Requests System

// Start session
session_start();

// Autoload classes (if using Composer or custom autoloader)
require_once __DIR__ . '/config/autoload.php';

// Load configuration
require_once __DIR__ . '/config/database.php';

// Basic routing logic
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/app/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
            exit;
        }
    }
}
// If not found, show 404
http_response_code(404);
echo '404 Not Found'; 