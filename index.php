<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Scammer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                <i class="fas fa-shield-alt text-indigo-600 mr-2"></i>
                Report a Scammer
            </h1>
            <p class="text-lg text-gray-600">
                Help protect others by reporting scam activities. Your report can make a difference.
            </p>
        </div>

        <!-- Main Form -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg">
                <form action="process_report.php" method="POST" class="space-y-8 p-8">
                    <!-- Scammer Information Section -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <i class="fas fa-user-circle text-indigo-600 mr-2"></i>
                                Scammer Information
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Provide as much information as you have about the scammer.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="scammer_name" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user text-gray-400 mr-1"></i> Scammer's Name*
                                </label>
                                <input type="text" name="scammer_name" id="scammer_name" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-phone text-gray-400 mr-1"></i> Phone Number
                                </label>
                                <input type="tel" name="phone_number" id="phone_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-envelope text-gray-400 mr-1"></i> Email Address
                                </label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-globe text-gray-400 mr-1"></i> Website
                                </label>
                                <input type="url" name="website" id="website"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="https://">
                            </div>
                        </div>
                    </div>

                    <!-- Scam Details Section -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <i class="fas fa-exclamation-triangle text-indigo-600 mr-2"></i>
                                Scam Details
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Tell us about the scam attempt or incident.
                            </p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="scam_type" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-tag text-gray-400 mr-1"></i> Type of Scam*
                                </label>
                                <select name="scam_type" id="scam_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select a scam type</option>
                                    <?php
                                    include 'config/db.php';
                                    $stmt = $pdo->query("SELECT name FROM scam_types ORDER BY name");
                                    while ($row = $stmt->fetch()) {
                                        echo "<option value='" . htmlspecialchars($row['name']) . "'>" . 
                                             htmlspecialchars($row['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-align-left text-gray-400 mr-1"></i> Description of the Scam*
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Please provide details about what happened..."></textarea>
                            </div>

                            <div>
                                <label for="evidence" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-file-alt text-gray-400 mr-1"></i> Evidence or Additional Information
                                </label>
                                <textarea name="evidence" id="evidence" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Any screenshots, messages, or other evidence (optional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Reporter Information Section -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <i class="fas fa-user-shield text-indigo-600 mr-2"></i>
                                Your Information (Optional)
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Your information will be kept confidential.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="reporter_name" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user text-gray-400 mr-1"></i> Your Name
                                </label>
                                <input type="text" name="reporter_name" id="reporter_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="reporter_email" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-envelope text-gray-400 mr-1"></i> Your Email
                                </label>
                                <input type="email" name="reporter_email" id="reporter_email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Fields marked with * are required</p>
                <p class="mt-2">
                    <i class="fas fa-lock mr-1"></i>
                    Your report will be reviewed by our team and appropriate action will be taken.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
