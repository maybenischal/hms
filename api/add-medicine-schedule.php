<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $patientId = $_POST['patient_id'] ?? null;
        $medicineId = $_POST['medicine_id'] ?? null;
        $dosage = $_POST['dosage'] ?? null;
        $frequency = $_POST['frequency'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? '';

        if (!$patientId || !$medicineId || !$dosage || !$frequency || !$startDate) {
            throw new Exception('Missing required fields');
        }

        $employeeRepository = new App\Repository\EmployeeRepository($db);
        $employee = $employeeRepository->findByUserId($_SESSION['user']['id']);

        $db->query(
            "INSERT INTO medicine_schedule (patient_id, medicine_id, dosage, frequency, start_date, end_date, created_by) 
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$patientId, $medicineId, $dosage, $frequency, $startDate, $endDate ?: null, $employee['id']]
        );

        header('Location: /patients/view?id=' . $patientId);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients/view?id=' . $patientId);
        exit;
    }
} 