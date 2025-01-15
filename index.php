<?php
session_start();
$request = $_SERVER['REQUEST_URI'];
$viewDir = 'views/';

// Check for route parameter first
if (isset($_GET['route'])) {
    $route = $_GET['route'];
    switch ($route) {
        case 'assign-doctor':
            require __DIR__ . '/api/assign-doctor.php';
            exit;
        case 'add-report':
            require __DIR__ . '/api/add-report.php';
            exit;
        case 'add-medicine-schedule':
            require __DIR__ . '/api/add-medicine-schedule.php';
            exit;
        case 'delete-assignment':
            require __DIR__ . '/api/delete-assignment.php';
            exit;
        case 'delete-report':
            require __DIR__ . '/api/delete-report.php';
            exit;
        case 'delete-schedule':
            require __DIR__ . '/api/delete-schedule.php';
            exit;
        case 'delete-patient':
            require __DIR__ . '/api/delete-patient.php';
            exit;
    }
}

// Remove query parameters and trailing slashes for path routing
$path = rtrim(parse_url($request, PHP_URL_PATH), '/');

// Define routes
$routes = [
    '/' => 'views/dashboard.php',
    '/login' => 'views/login.php',
    '/logout' => 'views/logout.php',
    '/dashboard' => 'views/dashboard.php',
    '/patients' => 'views/patients/index.php',
    '/patients/register' => 'views/patients/register.php',
    '/patients/view' => 'views/patients/view.php',
    '/patients/edit' => 'views/patients/edit.php',
    '/settings' => 'views/settings/index.php',
    '/appointments' => 'views/appointments/index.php',
    '/register' => 'views/register/register-form.php'
];

// Get the current URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route to correct script
if (array_key_exists($uri, $routes)) {
    require_once __DIR__ . '/' . $routes[$uri];
} else {
    // Handle 404
    http_response_code(404);
    require_once __DIR__ . '/views/404.php';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log'); // Redirect logs to a file
error_reporting(E_ALL);
error_log("Log test: Server-side logging enabled.");

?>
