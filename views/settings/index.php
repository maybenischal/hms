<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../auth.php';
requireAuth();

$pageTitle = "Settings";
include __DIR__ . '/../../views/layout/header.php';
?>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Settings</h1>
    
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Profile Settings -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Profile Settings</h2>
            <form action="/settings/profile" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="text" name="name" id="name" value="<?php echo htmlspecialchars($_SESSION['user']['user_name'] ?? ''); ?>">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>">
                </div>
                
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Update Profile
                </button>
            </form>
        </div>

        <!-- Password Change -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Change Password</h2>
            <form action="/settings/password" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">
                        Current Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="password" name="current_password" id="current_password">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">
                        New Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="password" name="new_password" id="new_password">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                        Confirm New Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="password" name="confirm_password" id="confirm_password">
                </div>
                
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Change Password
                </button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layout/footer.php'; ?> 