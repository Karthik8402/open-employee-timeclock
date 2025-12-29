<?php
/**
 * PHP Timeclock Configuration File
 * 
 * Copy this file to config.inc.php and update with your database credentials.
 * 
 * IMPORTANT: This application has been updated for PHP 8.x compatibility.
 * The mysql_* functions are shimmed to use mysqli_* under the hood.
 */

// Include default values and PHP 8 polyfills FIRST
include 'config_defaults.php';

// ================== DATABASE SETTINGS ==================
// Update these with your actual database credentials
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "timeclock";
$db_prefix = "";  // Table prefix, usually empty

// ================== APPLICATION SETTINGS ==================
$app_name = "PHP Timeclock";
$app_version = "1.5.0";
$title = "PHP Timeclock";

// Logo image path (relative to public folder)
$logo = "images/logos/phptimeclock.png";

// Email for footer (set to "none" to disable)
$email = "none";

// Page refresh rate in seconds (set to "none" to disable)
$refresh = "none";

// ================== TIME SETTINGS ==================
$timefmt = "g:i a";      // Time format (e.g., "5:30 pm")
$datefmt = "m/d/Y";      // Date format (e.g., "12/29/2025")

// Timezone settings (only one should be "yes")
$use_client_tz = "no";   // Use client browser timezone
$use_server_tz = "yes";  // Use server timezone

// ================== DISPLAY SETTINGS ==================
$show_display_name = "no";     // Use display names instead of full names
$display_current_users = "yes"; // Show only today's punches
$display_office = "all";        // Filter by office (or "all")
$display_group = "all";         // Filter by group (or "all")
$display_office_name = "yes";   // Show office column
$display_group_name = "yes";    // Show group column
$display_weather = "no";        // Show weather widget

// Row colors for alternating display
$color1 = "#f0f0f0";
$color2 = "#e0e0e0";

// ================== SECURITY SETTINGS ==================
$use_passwd = "no";             // Require passwords for punch in/out
$use_reports_password = "no";   // Require password for reports
$restrict_ips = "no";           // Restrict access by IP
$allowed_networks = array();    // Allowed IP ranges (if restrict_ips = "yes")
$ip_logging = "yes";            // Log IP addresses

// ================== LINKS ==================
$links = "none";         // Set to "none" to disable custom links
$display_links = array(); // Array of link display names

// ================== INITIALIZE DATABASE CONNECTION ==================
// This MUST be called after database credentials are set above
__timeclock_init_db();

?>
