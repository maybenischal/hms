<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

use App\Repository\PatientRepository;

$pageTitle = "Dashboard";
include __DIR__ . '/../views/layout/header.php';

$patientRepository = new PatientRepository($db);
$totalPatients = $patientRepository->getTotalPatients();
$todayPatients = $patientRepository->getTodayPatients();
?>

<div class="p-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Total Patients Card -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Total Patients</h2>
                    <p class="text-2xl font-semibold text-gray-800"><?= $totalPatients ?></p>
                </div>
            </div>
        </div>

        <!-- Today's Patients Card -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Today's Patients</h2>
                    <p class="text-2xl font-semibold text-gray-800"><?= $todayPatients ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>
