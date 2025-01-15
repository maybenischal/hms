<?php
function isAuthenticated(): bool {
    return isset($_SESSION['user']);
}

function requireAuth(): void {
    if (!isAuthenticated()) {
        header("Location: register.php");
        exit;
    }
}
