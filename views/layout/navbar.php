<nav class="bg-white shadow-lg">
    <div class="px-8 mx-auto w-full">
        <div class="flex justify-between h-16">
            <!-- Left side -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <h1 class="text-xl font-bold text-gray-800"><?php echo $pageTitle ?? 'HMS'; ?></h1>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center">
                <!-- Notifications -->
                <button class="p-2 text-gray-600 hover:text-gray-800 rounded-full hover:bg-gray-100 focus:outline-none">
                    <i class="fas fa-bell"></i>
                </button>

                <!-- User Menu -->
                <div class="ml-4 relative flex items-center">
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-700">
                                <?php echo htmlspecialchars($_SESSION['user']['user_name'] ?? ''); ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?php 
                                    $userType = $_SESSION['user']['user_type'] ?? 'EXTERNAL';
                                    echo $userType === 'INTERNAL' ? 'Doctor' : 'Staff'; 
                                ?>
                            </div>
                        </div>
                        <div class="relative">
                            <button class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <img class="h-9 w-9 rounded-full border-2 border-gray-200" 
                                     src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['user_name'] ?? 'U'); ?>&background=random" 
                                     alt="User profile">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 