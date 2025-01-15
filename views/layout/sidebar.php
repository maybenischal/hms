<aside class="bg-gray-800 text-white w-64 min-h-screen p-4">
    <nav>
        <div class="mb-8">
            <h1 class="text-2xl font-bold">HMS</h1>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="/dashboard" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo isCurrentPage('/dashboard') ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
            </li>
            
            <li>
                <a href="/patients" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo isCurrentPage('/patients') ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-users mr-2"></i>Patients
                </a>
            </li>
            
            <li>
                <a href="/appointments" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo isCurrentPage('/appointments') ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-calendar-alt mr-2"></i>Appointments
                </a>
            </li>
            
            <li>
                <a href="/settings" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo isCurrentPage('/settings') ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-cog mr-2"></i>Settings
                </a>
            </li>
            
            <li>
                <a href="/logout" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </li>
        </ul>
    </nav>
</aside> 