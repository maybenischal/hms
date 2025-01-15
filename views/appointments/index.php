<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

$pageTitle = "Appointments";
include __DIR__ . '/../../views/layout/header.php';
?>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Appointments</h1>
    
    <!-- Add appointment button -->
    <div class="mb-6">
        <a href="/appointments/create" 
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            New Appointment
        </a>
    </div>

    <!-- Appointments list will go here -->
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <p class="text-gray-600">No appointments found.</p>
    </div>
</div>

<?php include __DIR__ . '/../../views/layout/footer.php'; ?> 