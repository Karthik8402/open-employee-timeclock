<?php
// session_init.php - Shared session initialization for iPage compatibility
// Include this BEFORE session_start() in any file that uses sessions

// Fix session for shared hosting (iPage)
// Uses a local sessions folder to avoid permission issues with system session dir
$sessionPath = __DIR__ . '/sessions';

// Create sessions directory if it doesn't exist
if (!is_dir($sessionPath)) {
    @mkdir($sessionPath, 0755, true);
    
    // Also create .htaccess to protect session files
    $htaccess = $sessionPath . '/.htaccess';
    if (!file_exists($htaccess)) {
        @file_put_contents($htaccess, "Deny from all\n");
    }
}

// Set custom session path if writable
if (is_writable($sessionPath)) {
    session_save_path($sessionPath);
}

// Start the session
@session_start();
