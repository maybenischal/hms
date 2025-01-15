<?php
session_start();

// Simulated user authentication (replace with real logic)
if ($_POST['username'] === 'admin' && $_POST['password'] === 'password123') {
    $_SESSION['user'] = ['username' => 'admin'];
    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid credentials. Please try again.";
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
