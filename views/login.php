<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';

use App\Repository\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        try {
            $userRepository = new UserRepository($db);
            $user = $userRepository->authenticate($email, $password);
            
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['user_type'];
                
                error_log("Login successful for user: " . $email);
                header('Location: /dashboard');
                exit;
            } else {
                error_log("Login failed for user: " . $email);
                $error = "Invalid email or password";
            }
        } catch (\Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $error = "An error occurred during login";
        }
    }
}

$pageTitle = "Login";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospital Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="email" name="email" type="email" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="password" name="password" type="password" required>
                </div>

                <div>
                    <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Login
                    </button>
                </div>

                <div class="text-center text-sm">
                    <a href="/register" class="text-blue-500 hover:text-blue-700">
                        Don't have an account? Register
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
