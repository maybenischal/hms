<?php
require_once __DIR__ . '/../../bootstrap.php';
use App\Repository\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => trim($_POST['password'] ?? '')
    ];

    if (empty($userData['email']) || empty($userData['password'])) {
        $error = "Email and password are required";
    } else {
        $userRepository = new UserRepository($db);
        if ($userRepository->createUser($userData)) {
            header('Location: /login');
            exit;
        } else {
            $error = "Registration failed. Email might already exist.";
        }
    }
}

require __DIR__ . '/register-form.php';