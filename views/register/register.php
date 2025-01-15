<?php
require_once "../../bootstrap.php";
use App\models\User;
use App\models\UserType;

$nameError = $emailError = $passwordError = $confirmPasswordError = "";
$name = $email = $password = $confirmPassword = "";


// Server-side validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isValid = true;
    error_log("Registration request", 0);
    error_log("$_POST contents: " . print_r($_POST, true));

    // If validation passed, you can process the registration (e.g., save to DB)
    if ($isValid) {
        $userName = htmlspecialchars($_POST['username']);
        // Hash the password before saving it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a new User object
        $user = new User();
        $user->setUsername($userName);
        $user->setPassword($hashedPassword);
        $user->setUserType(UserType::EXTERNAL);

        error_log("User information : ". print_r($user, true));

        // Persist the user object to the database using Doctrine
        try {
            echo "we are inside here";
            // Save user to the database
            $entityManager->persist($user);
            $entityManager->flush();


            error_log("Before persisting user: " . print_r($user, true));

            $entityManager->persist($user);
            $entityManager->flush();

            error_log("User created successfully: " . $email);

            // Redirect to dashboard
            header("Location: ./../dashboard.php");

            $formSubmitted = true;
        } catch (Exception $e) {
            $formError = "Error: " . $e->getMessage();
            error_log("Exception: " . $e->getMessage());
        }

        error_log("log");

        // Redirect to the dashboard after successful registration
        header("Location: /dashboard.php"); // Change to your actual dashboard page URL
        exit; // Make sure the script stops after redirect

    }
}
?>