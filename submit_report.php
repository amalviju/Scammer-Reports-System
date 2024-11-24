<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO scammer_reports (scammer_name, phone_number, email, website, scam_type, description, evidence) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['scammer_name'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['website'],
            $_POST['scam_type'],
            $_POST['description'],
            $_POST['evidence']
        ]);

        header('Location: index.php?success=1');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 