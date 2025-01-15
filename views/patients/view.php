<?php
session_start();
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

use App\Repository\PatientRepository;
use App\Repository\EmployeeRepository;
use App\Repository\ReportRepository;
use App\Repository\MedicineScheduleRepository;
use App\Repository\MedicineRepository;

$patientId = $_GET['id'] ?? null;
if (!$patientId) {
    header('Location: /patients');
    exit;
}

$patientRepository = new PatientRepository($db);
$employeeRepository = new EmployeeRepository($db);
$reportRepository = new ReportRepository($db);
$medicineScheduleRepository = new MedicineScheduleRepository($db);
$medicineRepository = new MedicineRepository($db);
$medicines = $medicineRepository->findAll();

$patient = $patientRepository->getPatientDetails($patientId);

if (!$patient) {
    $_SESSION['error'] = "Patient not found";
    header('Location: /patients');
    exit;
}

$doctors = $employeeRepository->getDoctors();
$reports = $reportRepository->getPatientReports($patientId);
$schedules = $medicineScheduleRepository->getPatientSchedules($patientId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <?php require __DIR__ . '/../components/sidebar.php'; ?>

        <div class="flex-1 p-8">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Patient Details</h1>
                    <div class="space-x-2">
                        <button onclick="showModal('assignDoctor')" 
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Assign Doctor
                        </button>
                        <button onclick="showModal('addReport')"
                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Add Report
                        </button>
                        <button onclick="showModal('addMedicine')"
                                class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                            Add Medicine
                        </button>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="bg-white rounded-lg shadow mb-6 p-6">
                    <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Name</p>
                            <p class="font-medium"><?= htmlspecialchars($patient['user_name']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Age</p>
                            <p class="font-medium"><?= htmlspecialchars($patient['age']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Blood Group</p>
                            <p class="font-medium"><?= htmlspecialchars($patient['blood_group']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Address</p>
                            <p class="font-medium"><?= htmlspecialchars($patient['address']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Assigned Doctors -->
                <div class="bg-white rounded-lg shadow mb-6 p-6">
                    <h2 class="text-xl font-semibold mb-4">Assigned Doctors</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (empty($patient['doctors'])): ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No doctors assigned yet</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($patient['doctors'] as $doctor): ?>
                                    <tr>
                                        <td class="px-6 py-4"><?= htmlspecialchars($doctor['name']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($doctor['assigned_date']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($doctor['status']) ?></td>
                                        <td class="px-6 py-4">
                                            <form action="/index.php?route=delete-assignment" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to remove this doctor?');">
                                                <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
                                                <input type="hidden" name="patient_id" value="<?= $patientId ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reports -->
                <div class="bg-white rounded-lg shadow mb-6 p-6">
                    <h2 class="text-xl font-semibold mb-4">Medical Reports</h2>
                    <div class="space-y-4">
                        <?php foreach ($reports as $report): ?>
                        <div class="border rounded p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium"><?= htmlspecialchars($report['report_type']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($report['created_at']) ?></p>
                                </div>
                                <form action="/index.php?route=delete-report" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    <input type="hidden" name="id" value="<?= $report['id'] ?>">
                                    <input type="hidden" name="patient_id" value="<?= $patientId ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <p class="mt-2"><?= nl2br(htmlspecialchars($report['report_content'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Medicine Schedule -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Medicine Schedule</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosage</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frequency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td class="px-6 py-4"><?= htmlspecialchars($schedule['medicine_name']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($schedule['dosage']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($schedule['frequency']) ?></td>
                                    <td class="px-6 py-4">
                                        <?= htmlspecialchars($schedule['start_date']) ?> - 
                                        <?= htmlspecialchars($schedule['end_date'] ?? 'Ongoing') ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="/index.php?route=delete-schedule" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                            <input type="hidden" name="id" value="<?= $schedule['id'] ?>">
                                            <input type="hidden" name="patient_id" value="<?= $patientId ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <?php include __DIR__ . '/../components/modals/assign-doctor.php'; ?>
    <?php include __DIR__ . '/../components/modals/add-report.php'; ?>
    <?php include __DIR__ . '/../components/modals/add-medicine.php'; ?>

    <script>
        function showModal(modalId) {
            document.getElementById(modalId + 'Modal').classList.remove('hidden');
        }

        function hideModal(modalId) {
            document.getElementById(modalId + 'Modal').classList.add('hidden');
        }
    </script>

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
</body>
</html> 