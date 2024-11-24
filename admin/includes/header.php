<?php
if(!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Scammer Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <nav class="bg-white border-b">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
                            <span class="ml-2 text-xl font-semibold text-gray-900">Scammer Reports</span>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="dashboard.php" 
                               class="<?php echo $current_page === 'dashboard' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                            <a href="manage_admins.php" 
                               class="<?php echo $current_page === 'manage_admins' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-users-cog mr-2"></i> Manage Admins
                            </a>
                            <a href="settings.php" 
                               class="<?php echo $current_page === 'settings' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <a href="logout.php" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" @click="mobileMenu = !mobileMenu" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile menu -->
            <div x-show="mobileMenu" class="sm:hidden" x-data="{ mobileMenu: false }">
                <div class="space-y-1 pb-3 pt-2">
                    <a href="dashboard.php" class="<?php echo $current_page === 'dashboard' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700'; ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="manage_admins.php" class="<?php echo $current_page === 'manage_admins' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700'; ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium">
                        <i class="fas fa-users-cog mr-2"></i> Manage Admins
                    </a>
                    <a href="settings.php" class="<?php echo $current_page === 'settings' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700'; ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="logout.php" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block border-l-4 py-2 pl-3 pr-4 text-base font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
</body>
</html>
