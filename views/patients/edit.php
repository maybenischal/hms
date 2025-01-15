<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

use App\Repository\PatientRepository;

$pageTitle = "Edit Patient";
include __DIR__ . '/../../views/layout/header.php';

$patientId = $_GET['id'] ?? null;
if (!$patientId) {
    header('Location: /patients');
    exit;
}

$patientRepository = new PatientRepository($db);
$patient = $patientRepository->findById($patientId);

if (!$patient) {
    $_SESSION['error'] = "Patient not found";
    header('Location: /patients');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $patientData = [
            'id' => $patientId,
            'name' => $_POST['name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address']
        ];

        if ($patientRepository->updatePatient($patientData)) {
            $_SESSION['success'] = "Patient updated successfully";
            header('Location: /patients');
            exit;
        }
        throw new Exception("Failed to update patient");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container mx-auto">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Patient</h1>

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
                       type="text" id="name" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                    Date of Birth
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">
                    Gender
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="gender" name="gender" required>
                    <option value="M" <?php echo $patient['gender'] === 'M' ? 'selected' : ''; ?>>Male</option>
                    <option value="F" <?php echo $patient['gender'] === 'F' ? 'selected' : ''; ?>>Female</option>
                    <option value="O" <?php echo $patient['gender'] === 'O' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                    Phone Number
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                    Address
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          id="address" name="address" rows="3" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                    Update Patient
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