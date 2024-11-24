<?php
session_start();
include '../config/db.php';

// Handle all form submissions first, before any output
$success_message = '';
$type_error = '';
$delete_error = '';

// Handle profile update
if(isset($_POST['update_profile'])) {
    $new_username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    
    if($new_username) {
        $stmt = $pdo->prepare("UPDATE admins SET username = ? WHERE id = ?");
        $stmt->execute([$new_username, $_SESSION['admin_id']]);
    }
    
    if($new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['admin_id']]);
    }
    
    $success_message = 'profile_updated';
}

// Handle scam type addition
if(isset($_POST['add_scam_type'])) {
    try {
        $type_name = trim($_POST['type_name']);
        $type_description = trim($_POST['type_description']);
        
        // Check if type already exists
        $check = $pdo->prepare("SELECT id FROM scam_types WHERE name = ?");
        $check->execute([$type_name]);
        
        if($check->rowCount() === 0) {
            $stmt = $pdo->prepare("INSERT INTO scam_types (name, description) VALUES (?, ?)");
            $stmt->execute([$type_name, $type_description]);
            $success_message = 'type_added';
        } else {
            $type_error = "This scam type already exists.";
        }
    } catch(PDOException $e) {
        $type_error = "Error adding scam type: " . $e->getMessage();
    }
}

// Handle scam type deletion
if(isset($_POST['delete_type'])) {
    try {
        $type_id = (int)$_POST['type_id'];
        $stmt = $pdo->prepare("DELETE FROM scam_types WHERE id = ?");
        $stmt->execute([$type_id]);
        $success_message = 'type_deleted';
    } catch(PDOException $e) {
        $delete_error = "Error deleting scam type: " . $e->getMessage();
    }
}

// Fetch admin details
$stmt = $pdo->prepare("SELECT username FROM admins WHERE id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();

// Fetch scam types
$stmt = $pdo->query("SELECT * FROM scam_types ORDER BY name");
$scamTypes = $stmt->fetchAll();

// Now include the header and start output
include 'includes/header.php';
?>

<div class="space-y-6">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Settings</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Profile Settings -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Profile Settings</h3>
                <?php if($success_message === 'profile_updated'): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative">
                        Profile updated successfully
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                    </div>

                    <div>
                        <button type="submit" name="update_profile"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Scam Types Management -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Scam Types Management</h3>
                
                <?php if($success_message === 'type_added'): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative">
                        New scam type added successfully
                    </div>
                <?php endif; ?>

                <?php if($success_message === 'type_deleted'): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative">
                        Scam type deleted successfully
                    </div>
                <?php endif; ?>

                <?php if(isset($type_error)): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
                        <?php echo htmlspecialchars($type_error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type Name</label>
                        <input type="text" name="type_name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="type_description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <div>
                        <button type="submit" name="add_scam_type"
                            class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Add Scam Type
                        </button>
                    </div>
                </form>

                <!-- Existing Scam Types -->
                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Existing Types</h4>
                    <div class="space-y-2">
                        <?php foreach($scamTypes as $type): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h5 class="font-medium text-gray-900"><?php echo htmlspecialchars($type['name']); ?></h5>
                                    <?php if($type['description']): ?>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($type['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="type_id" value="<?php echo $type['id']; ?>">
                                    <button type="submit" name="delete_type"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this type?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
