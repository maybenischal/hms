<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            let name = document.forms["registrationForm"]["name"].value;
            let email = document.forms["registrationForm"]["email"].value;
            let password = document.forms["registrationForm"]["password"].value;
            let confirmPassword = document.forms["registrationForm"]["confirm_password"].value;
            let isValid = true;

            if (name == "") {
                alert("Name is required.");
                isValid = false;
            }

            if (email == "") {
                alert("Email is required.");
                isValid = false;
            }

            if (password == "") {
                alert("Password is required.");
                isValid = false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters.");
                isValid = false;
            }

            if (confirmPassword == "") {
                alert("Please confirm your password.");
                isValid = false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>Registration Form</h2>

    <!-- Registration Form -->
    <form name="registrationForm" action="/views/register/register.php" method="POST" onsubmit="return validateForm()">
        <div class="input-group">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
            <span class="error"><?= $nameError ?? '' ?></span>
        </div>

        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" name="username" id="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
            <span class="error"><?= $emailError ?? '' ?></span>
        </div>

        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <span class="error"><?= $passwordError ?? '' ?></span>
        </div>

        <div class="input-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <span class="error"><?= $confirmPasswordError ?? '' ?></span>
        </div>

        <button type="submit" class="submit-btn">Register</button>
    </form>

    <div class="redirect">
        <p>Already have an account? <a href="/login">Login</a></p>
    </div>
</div>

</body>
</html>
