<?php
$currentPath = $_SERVER['REQUEST_URI'];
$isActive = function($path) use ($currentPath) {
    return strpos($currentPath, $path) === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white';
};
?>

<aside class="fixed inset-y-0 left-0 bg-gray-800 w-64 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-gray-900">
            <span class="text-white text-xl font-bold">HMS</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-2">
            <a href="/dashboard" 
               class="flex items-center px-4 py-2 text-sm font-medium rounded-md <?= $isActive('/dashboard') ?>">
                <i class="fas fa-home w-6"></i>
                Dashboard
            </a>

            <a href="/patients" 
               class="flex items-center px-4 py-2 text-sm font-medium rounded-md <?= $isActive('/patients') ?>">
                <i class="fas fa-users w-6"></i>
                Patients
            </a>

            <a href="/appointments" 
               class="flex items-center px-4 py-2 text-sm font-medium rounded-md <?= $isActive('/appointments') ?>">
                <i class="fas fa-calendar-alt w-6"></i>
                Appointments
            </a>

            <?php if ($_SESSION['user']['user_type'] === 'INTERNAL'): ?>
            <a href="/reports" 
               class="flex items-center px-4 py-2 text-sm font-medium rounded-md <?= $isActive('/reports') ?>">
                <i class="fas fa-chart-bar w-6"></i>
                Reports
            </a>
            <?php endif; ?>
        </nav>

        <!-- User Menu -->
        <div class="border-t border-gray-700 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">
                        <?= htmlspecialchars($_SESSION['user']['user_name']) ?>
                    </p>
                    <a href="/logout" class="text-xs font-medium text-gray-300 hover:text-white">
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside> 