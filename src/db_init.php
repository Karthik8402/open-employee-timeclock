<?php
/**
 * Database Connection Initialization
 * 
 * This file establishes the database connection using the mysql_shim functions.
 * Include this file AFTER config.inc.php has loaded the database credentials.
 */

// Only connect if not already connected and credentials exist
if (!isset($GLOBALS['__mysql_shim_link']) || $GLOBALS['__mysql_shim_link'] === null) {
    
    // Check if database credentials are available
    if (isset($db_hostname) && isset($db_username) && isset($db_password) && isset($db_name)) {
        
        // Establish connection using the shim wrapper
        $db = @mysql_connect($db_hostname, $db_username, $db_password);
        
        if (!$db) {
            // Show helpful error message
            $error = mysqli_connect_error();
            die("Error: Could not connect to the database server ($db_hostname). " . 
                "Please check your config.inc.php settings.<br>Error: " . htmlspecialchars($error));
        }
        
        // Select the database
        if (!@mysql_select_db($db_name, $db)) {
            die("Error: Could not select database '$db_name'. " .
                "Please verify the database exists and the user has access.");
        }
        
        // Set charset for proper encoding
        if (function_exists('mysqli_set_charset') && $GLOBALS['__mysql_shim_link']) {
            mysqli_set_charset($GLOBALS['__mysql_shim_link'], 'utf8mb4');
        }
        
    } else {
        // Credentials not loaded yet - this is normal during initial include
        // Connection will happen when credentials are available
    }
}
?>
