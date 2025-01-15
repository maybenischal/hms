<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $patientId = $_POST['patient_id'] ?? null;
        $reportType = $_POST['report_type'] ?? null;
        $reportContent = $_POST['report_content'] ?? null;

        if (!$patientId || !$reportType || !$reportContent) {
            throw new Exception('Missing required fields');
        }

        $employeeRepository = new App\Repository\EmployeeRepository($db);
        $employee = $employeeRepository->findByUserId($_SESSION['user']['id']);

        $reportRepository = new App\Repository\ReportRepository($db);
        $reportRepository->createReport([
            'patient_id' => $patientId,
            'report_type' => $reportType,
            'report_content' => $reportContent,
            'created_by' => $employee['id']
        ]);

        header('Location: /patients/view?id=' . $patientId);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients/view?id=' . $patientId);
        exit;
    }
} 