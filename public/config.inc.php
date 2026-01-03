<?php
// public/config.inc.php - BRIDGE FILE
// This file maintains compatibility with legacy code while using the new structure.

// Auto-detect directory structure (works for both local and iPage)
$baseDir = __DIR__;
if (file_exists($baseDir . '/../src/Database.php')) {
    // Local structure: public/config.inc.php with src/ beside public/
    $srcDir = $baseDir . '/../src';
    $configDir = $baseDir . '/../config';
} elseif (file_exists($baseDir . '/src/Database.php')) {
    // Flat structure: everything in same folder with src subfolder
    $srcDir = $baseDir . '/src';
    $configDir = $baseDir . '/config';
} else {
    die("Error: Cannot find src/Database.php. Please check your directory structure.");
}

require_once $srcDir . '/Database.php';
require_once $srcDir . '/functions.php';

// Initialize Database
global $db;
$db = new Database();

// Load Configuration from the new secure file
$config = require $configDir . '/database.php';

// Re-map variables expected by legacy code
$db_hostname = $config['host'];
$db_username = $config['user'];
$db_password = $config['pass'];
$db_name     = $config['dbname'];
$db_prefix   = $config['prefix'] ?? '';

// --- LEGACY SETTINGS (Shimmed) ---
$restrict_ips = "no";
$allowed_networks = [];
$disable_sysedit = "no";
$use_passwd = "yes";
$use_reports_password = "yes";
$ip_logging = "yes";
$email = "none";

// Timezone Settings (Fixed Conflict)
$use_client_tz = "yes"; 
$use_server_tz = "no"; 
$tzo = 0; 

// Date Formats
$datefmt = "n/j/Y";
$js_datefmt = "M/d/yyyy";
$tmp_datefmt = "m/d/yyyy";
$calendar_style = "amer";
$timefmt = "g:i a";

// Display Settings
$display_current_users = "no";
$show_display_name = "yes";
$display_office = "all";
$display_group = "all";
$display_office_name = "yes";
$display_group_name = "yes";
$refresh = "300";
$display_weather = "no"; 
$links = []; 
$display_links = []; 
$date_link = ""; 
$dbversion = "1.5"; 

// Branding
$app_name = $config['app_name'];
$app_version = $config['app_version'];
$title = "$app_name $app_version";
$logo = "images/logos/phptimeclock.png";

// Colors
$color1 = "#EFEFEF";
$color2 = "#FBFBFB";

// Constants (formerly in dbc.php)
if (!defined("COOKIE_TIME_OUT")) define("COOKIE_TIME_OUT", 10);
if (!defined("SALT_LENGTH")) define('SALT_LENGTH', 9);
if (!defined("ADMIN_LEVEL")) define ("ADMIN_LEVEL", 5);
if (!defined("USER_LEVEL")) define ("USER_LEVEL", 1);
if (!defined("GUEST_LEVEL")) define ("GUEST_LEVEL", 0);

// --- COMPATIBILITY FUNCTIONS ---

if (!function_exists('mysql_query')) {
    function mysql_query($query) {
        global $db;
        return $db->query($query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($stmt) {
        if ($stmt instanceof PDOStatement) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($stmt) {
        if ($stmt instanceof PDOStatement) {
            return $stmt->rowCount();
        }
        return 0;
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id() {
        global $db;
        return $db->lastInsertId();
    }
}

if (!function_exists('mysql_free_result')) {
    function mysql_free_result($stmt) {
        // PDO doesn't strictly need free_result, but we can set to null
        $stmt = null;
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($str) {
        return str_replace(["\\", "\0", "\n", "\r", "'", '"', "\x1a"], ["\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z"], $str);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error() {
        return "PDO Error (Check Logs)";
    }
}

if (!function_exists('ereg')) { 
	function ereg($pattern, $string) { 
		return preg_match('/'.preg_quote($pattern, '/').'/', $string); 
	} 
}

if (!function_exists('ereg_replace')) {
    function ereg_replace($pattern, $replacement, $string) {
        return preg_replace('/' . str_replace('/', '\\/', $pattern) . '/', $replacement, $string);
    }
}

?>
