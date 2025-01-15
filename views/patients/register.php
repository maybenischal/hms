<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

$pageTitle = "Register Patient";
include __DIR__ . '/../../views/layout/header.php';

use App\Repository\PatientRepository;
use App\Repository\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $userRepository = new UserRepository($db);
        $patientRepository = new PatientRepository($db);

        // First create user account
        $userData = [
            'user_name' => strtolower(str_replace(' ', '.', $_POST['name'])),
            'email' => $_POST['email'],
            'password' => password_hash('patient123', PASSWORD_DEFAULT),
            'user_type' => 'EXTERNAL'
        ];

        $userId = $userRepository->createUser($userData);

        if ($userId) {
            // Then create patient record
            $patientData = [
                'user_id' => $userId,
                'name' => $_POST['name'],
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'blood_group' => $_POST['blood_group'],
                'age' => $_POST['age'],
                'height' => $_POST['height'],
                'weight' => $_POST['weight']
            ];

            $patientId = $patientRepository->createPatient($patientData);

            if ($patientId) {
                $_SESSION['success'] = "Patient registered successfully";
                header('Location: /patients');
                exit;
            }
        }
        throw new Exception("Failed to register patient");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container mx-auto">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Register New Patient</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Full Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       type="text" id="name" name="name" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       type="email" id="email" name="email" required>
            </div>

            <!-- Add all other required fields -->
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                    Register Patient
                </button>
                <a href="/patients" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../views/layout/footer.php'; ?> 