<?php
function requireAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user']) && isset($_SESSION['user_id']);
}

function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}
