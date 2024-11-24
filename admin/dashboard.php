<?php
session_start();
include '../config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM scammer_reports ORDER BY reported_at DESC");
$reports = $stmt->fetchAll();
?>

<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Reports -->
        <div class="bg-white overflow-hidden rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Total Reports</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900"><?php echo count($reports); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white overflow-hidden rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Pending</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900">
                            <?php echo count(array_filter($reports, fn($r) => $r['status'] === 'pending')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verified Reports -->
        <div class="bg-white overflow-hidden rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Verified</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900">
                            <?php echo count(array_filter($reports, fn($r) => $r['status'] === 'verified')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- False Reports -->
        <div class="bg-white overflow-hidden rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <i class="fas fa-times-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 truncate">False Reports</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900">
                            <?php echo count(array_filter($reports, fn($r) => $r['status'] === 'false_report')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Reports</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Scammer Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($reports as $report): ?>
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($report['scammer_name']); ?></div>
                            <div class="text-sm text-gray-500">
                                <?php if($report['email']): ?>
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-1"></i>
                                        <?php echo htmlspecialchars($report['email']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($report['phone_number']): ?>
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-1"></i>
                                        <?php echo htmlspecialchars($report['phone_number']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($report['scam_type']); ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php echo $report['status'] === 'verified' ? 'bg-green-100 text-green-800' : 
                                    ($report['status'] === 'false_report' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                <?php echo ucfirst($report['status']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo date('M j, Y', strtotime($report['reported_at'])); ?>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="view_report.php?id=<?php echo $report['id']; ?>" 
                               class="text-indigo-600 hover:text-indigo-900">View Details</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
