<?php
require_once __DIR__ . '/../../bootstrap.php';
use App\Repository\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userRepository = new UserRepository($db);
    $user = $userRepository->authenticate($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: /dashboard');
        exit;
    } else {
        $error = "Invalid email or password";
    }
} 