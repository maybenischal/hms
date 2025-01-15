<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'] ?? null;
        $patientId = $_POST['patient_id'] ?? null;

        if (!$id || !$patientId) {
            throw new Exception('Missing required fields');
        }

        $repository = new App\Repository\ReportRepository($db);
        if ($repository->deleteReport($id, $patientId)) {
            $_SESSION['success'] = 'Report deleted successfully';
        } else {
            throw new Exception('Failed to delete report');
        }

        header('Location: /patients/view?id=' . $patientId);
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients/view?id=' . $patientId);
        exit;
    }
} 