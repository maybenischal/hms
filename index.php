<?php
$request = $_SERVER['REQUEST_URI'];
$viewDir = 'views/';  // Correct relative path

switch ($request) {
    case '':
    case '/':
        require __DIR__ . '/' . $viewDir . 'register/register-form.php';  // Correct path to register.php
        break;

    case '/login':
        require __DIR__ . '/' . $viewDir . 'login.php';  // Correct path to users.php
        break;

    case '/contact':
        require __DIR__ . '/' . $viewDir . 'contact.php';  // Correct path to contact.php
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/' . $viewDir . '404.php';  // Correct path to 404.php
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log'); // Redirect logs to a file
error_reporting(E_ALL);
error_log("Log test: Server-side logging enabled.");

?>
