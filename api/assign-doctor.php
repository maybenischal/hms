<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $patientId = $_POST['patient_id'] ?? null;
        $doctorId = $_POST['doctor_id'] ?? null;

        if (!$patientId || !$doctorId) {
            throw new Exception('Missing required fields');
        }

        // Get the current employee ID
        $employeeRepository = new App\Repository\EmployeeRepository($db);
        $employee = $employeeRepository->findByUserId($_SESSION['user']['id']);
        
        if (!$employee) {
            throw new Exception('Employee record not found');
        }

        // Create the doctor assignment
        $doctorAssignmentRepository = new App\Repository\DoctorAssignmentRepository($db);
        $result = $doctorAssignmentRepository->assignDoctor([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'assigned_by' => $employee['id']
        ]);

        if (!$result) {
            throw new Exception('Failed to assign doctor');
        }

        $_SESSION['success'] = 'Doctor assigned successfully';
        header('Location: /patients/view?id=' . $patientId);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients/view?id=' . $patientId);
        exit;
    }
} 