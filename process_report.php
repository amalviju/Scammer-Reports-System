<?php
session_start();
include 'config/db.php';

try {
    // Validate and sanitize input
    $scammer_name = trim($_POST['scammer_name'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $scam_type = trim($_POST['scam_type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $evidence = trim($_POST['evidence'] ?? '');
    $reporter_name = trim($_POST['reporter_name'] ?? '');
    $reporter_email = trim($_POST['reporter_email'] ?? '');

    // Validate required fields
    if (empty($scammer_name) || empty($scam_type) || empty($description)) {
        throw new Exception('Please fill in all required fields.');
    }

    // Insert the report
    $stmt = $pdo->prepare("
        INSERT INTO scammer_reports (
            scammer_name, 
            phone_number, 
            email, 
            website, 
            scam_type, 
            description, 
            evidence, 
            reporter_name, 
            reporter_email, 
            status, 
            reported_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");

    $stmt->execute([
        $scammer_name,
        $phone_number,
        $email,
        $website,
        $scam_type,
        $description,
        $evidence,
        $reporter_name,
        $reporter_email
    ]);

    // Set success message
    $_SESSION['success_message'] = "Thank you! Your report has been submitted successfully.";
    header('Location: thank_you.php');
    exit();

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: index.php');
    exit();
}
?> 