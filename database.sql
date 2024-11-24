CREATE DATABASE scammer_reports;

USE scammer_reports;

CREATE TABLE admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE scammer_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    scammer_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20),
    email VARCHAR(100),
    website VARCHAR(255),
    scam_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    evidence TEXT,
    status ENUM('pending', 'verified', 'false_report') DEFAULT 'pending',
    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 