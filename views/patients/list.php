<?php
session_start();
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

use App\Repository\PatientRepository;

$patientRepository = new PatientRepository($db);
$patients = $patientRepository->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List - HMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <?php include __DIR__ . '/../components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 p-8 sm:ml-64">
            <div class="container mx-auto">
                <!-- Alert Messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($_SESSION['error']) ?></span>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($_SESSION['success']) ?></span>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <!-- Header -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">Patients List</h1>
                        <a href="/patients/register" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Register New Patient
                        </a>
                    </div>
                </div>

                <!-- Patients Table -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Age
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Blood Group
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Admitted Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (empty($patients)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No patients found
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($patients as $patient): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?= htmlspecialchars($patient['user_name']) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <?= htmlspecialchars($patient['age']) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <?= htmlspecialchars($patient['blood_group'] ?? 'N/A') ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <?= htmlspecialchars(date('Y-m-d', strtotime($patient['admitted_date']))) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex space-x-3">
                                                    <a href="/patients/view?id=<?= $patient['id'] ?>" 
                                                       class="text-blue-600 hover:text-blue-900">
                                                        View
                                                    </a>
                                                    <form action="/index.php?route=delete-patient" 
                                                          method="POST" 
                                                          class="inline-block"
                                                          onsubmit="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
                                                        <input type="hidden" name="id" value="<?= $patient['id'] ?>">
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 