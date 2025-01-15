<?php
session_start();
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $patientId = $_POST['patient_id'] ?? null;
        $doctorId = $_POST['doctor_id'] ?? null;

        if (!$patientId || !$doctorId) {
            throw new Exception('Missing required fields');
        }

        $employeeRepository = new App\Repository\EmployeeRepository($db);
        $employee = $employeeRepository->findByUserId($_SESSION['user']['id']);

        $db->query(
            "INSERT INTO doctor_assignments (patient_id, doctor_id, assigned_by) VALUES (?, ?, ?)",
            [$patientId, $doctorId, $employee['id']]
        );

        header('Location: /patients/view?id=' . $patientId);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients/view?id=' . $patientId);
        exit;
    }
} 