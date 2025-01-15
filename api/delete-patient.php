<?php
session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            throw new Exception('Missing patient ID');
        }

        // Verify patient exists before attempting deletion
        $repository = new App\Repository\PatientRepository($db);
        $patient = $repository->findById($id);
        
        if (!$patient) {
            throw new Exception('Patient not found');
        }

        if ($repository->deletePatient($id)) {
            $_SESSION['success'] = 'Patient deleted successfully';
        } else {
            throw new Exception('Failed to delete patient. Please try again.');
        }

        header('Location: /patients');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /patients');
        exit;
    }
} 