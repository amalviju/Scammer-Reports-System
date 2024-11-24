<?php
session_start();
include '../config/db.php';

$success_message = '';
$report_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    try {
        $new_status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE scammer_reports SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $report_id]);
        $success_message = 'Status updated successfully';
    } catch(PDOException $e) {
        $error_message = "Error updating status: " . $e->getMessage();
    }
}

// Fetch report details
$stmt = $pdo->prepare("SELECT * FROM scammer_reports WHERE id = ?");
$stmt->execute([$report_id]);
$report = $stmt->fetch();

if (!$report) {
    header('Location: dashboard.php');
    exit();
}

include 'includes/header.php';
?>

<div class="space-y-6">
    <!-- Back Navigation -->
    <div class="flex items-center justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Report Details #<?php echo $report['id']; ?>
            </h2>
        </div>
        <div class="flex md:ml-4">
            <a href="dashboard.php" 
               class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <?php if ($success_message): ?>
    <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    <?php echo htmlspecialchars($success_message); ?>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Report Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-6">
                        <!-- Scammer Information -->
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                <i class="fas fa-user-circle mr-2"></i>Scammer Information
                            </h3>
                            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <!-- Name -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-user mr-2"></i>Name
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($report['scammer_name']); ?>
                                    </dd>
                                </div>

                                <!-- Phone Number -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-phone mr-2"></i>Phone Number
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php echo $report['phone_number'] ? htmlspecialchars($report['phone_number']) : 'Not provided'; ?>
                                    </dd>
                                </div>

                                <!-- Email -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-envelope mr-2"></i>Email
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php echo $report['email'] ? htmlspecialchars($report['email']) : 'Not provided'; ?>
                                    </dd>
                                </div>

                                <!-- Website -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-globe mr-2"></i>Website
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php if($report['website']): ?>
                                            <a href="<?php echo htmlspecialchars($report['website']); ?>" 
                                               target="_blank" 
                                               class="text-indigo-600 hover:text-indigo-900">
                                                <?php echo htmlspecialchars($report['website']); ?>
                                            </a>
                                        <?php else: ?>
                                            Not provided
                                        <?php endif; ?>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Scam Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Scam Details
                            </h3>
                            <dl class="space-y-4">
                                <!-- Scam Type -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-tag mr-2"></i>Scam Type
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($report['scam_type']); ?>
                                    </dd>
                                </div>

                                <!-- Description -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-align-left mr-2"></i>Description
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                        <?php echo htmlspecialchars($report['description']); ?>
                                    </dd>
                                </div>

                                <!-- Evidence -->
                                <?php if($report['evidence']): ?>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-file-alt mr-2"></i>Evidence
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                        <?php echo htmlspecialchars($report['evidence']); ?>
                                    </dd>
                                </div>
                                <?php endif; ?>

                                <!-- Reporter Information -->
                                <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                    <dt class="text-sm font-medium text-gray-500">
                                        <i class="fas fa-user-shield mr-2"></i>Reporter Information
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div>
                                            <span class="font-medium">Name:</span> 
                                            <?php echo isset($report['reporter_name']) && $report['reporter_name'] 
                                                ? htmlspecialchars($report['reporter_name']) 
                                                : 'Anonymous'; ?>
                                        </div>
                                        <div>
                                            <span class="font-medium">Email:</span> 
                                            <?php echo isset($report['reporter_email']) && $report['reporter_email'] 
                                                ? htmlspecialchars($report['reporter_email']) 
                                                : 'Not provided'; ?>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Management Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                        <i class="fas fa-tasks mr-2"></i>Report Status
                    </h3>
                    
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Status</label>
                            <select name="status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="pending" <?php echo $report['status'] === 'pending' ? 'selected' : ''; ?>>
                                    <i class="fas fa-clock"></i> Pending Review
                                </option>
                                <option value="verified" <?php echo $report['status'] === 'verified' ? 'selected' : ''; ?>>
                                    <i class="fas fa-check"></i> Verified Scam
                                </option>
                                <option value="false_report" <?php echo $report['status'] === 'false_report' ? 'selected' : ''; ?>>
                                    <i class="fas fa-times"></i> False Report
                                </option>
                            </select>
                        </div>

                        <button type="submit" 
                                name="update_status"
                                class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>Update Status
                        </button>
                    </form>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span><i class="fas fa-calendar mr-2"></i>Reported On:</span>
                            <span><?php echo date('F j, Y', strtotime($report['reported_at'])); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mt-2">
                            <span><i class="fas fa-clock mr-2"></i>Last Updated:</span>
                            <span><?php echo date('F j, Y', strtotime($report['updated_at'] ?? $report['reported_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
