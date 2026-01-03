<?php
// config/database.php - Database Configuration
// This file contains your database credentials - DO NOT commit to version control!
// Supports both local (XAMPP) and remote (iPage) servers with automatic detection

// Detect if running on localhost - improved for iPage compatibility
$serverName = $_SERVER['SERVER_NAME'] ?? '';
$serverAddr = $_SERVER['SERVER_ADDR'] ?? '';
$remoteAddr = $_SERVER['REMOTE_ADDR'] ?? '';

// Check for local development environment
$isLocal = in_array($serverName, ['localhost', '127.0.0.1', '']) 
           || in_array($serverAddr, ['127.0.0.1', '::1'])
           || $remoteAddr === '127.0.0.1'
           || strpos($serverName, '.local') !== false;

// Force remote if on enviroapps.com domain
if (strpos($serverName, 'enviroapps.com') !== false) {
    $isLocal = false;
}

if ($isLocal) {
    // Local XAMPP Configuration
    return [
        'host' => 'localhost',
        'dbname' => 'eatime',                   // Your local database name
        'user' => 'root',                       // XAMPP default username
        'pass' => '',                           // XAMPP default password (empty)
        'charset' => 'utf8mb4',
        'prefix' => '',
        'app_name' => 'PHP Timeclock',
        'app_version' => '1.5.0'
    ];
} else {
    // Remote iPage Configuration
    return [
        'host' => 'your_remote_host',           // e.g., enviroap.com
        'dbname' => 'your_remote_database',     // Your remote database name
        'user' => 'your_remote_username',       // Your remote database username
        'pass' => 'your_remote_password',       // Your remote database password
        'charset' => 'utf8mb4',
        'prefix' => '',
        'app_name' => 'PHP Timeclock',
        'app_version' => '1.5.0'
    ];
}
