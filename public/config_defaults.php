<?php
/**
 * Default Configuration Values for PHP Timeclock
 * This file provides default values for all configuration variables.
 * Include this file BEFORE config.inc.php so user settings override defaults.
 */

// ================== PHP 8 POLYFILLS ==================
// Polyfills for deprecated functions removed in PHP 7.0+

// NOTE: MySQL compatibility shim is handled in config.inc.php using PDO
// require_once dirname(__DIR__) . '/src/mysql_shim.php';

if (!function_exists('eregi')) {
    /**
     * Case-insensitive regex match (DEPRECATED - use preg_match with 'i' flag)
     */
    function eregi($pattern, $string, &$regs = null) {
        $pattern = '/' . str_replace('/', '\\/', $pattern) . '/i';
        if (func_num_args() >= 3) {
            $result = preg_match($pattern, $string, $regs);
            return $result;
        }
        return preg_match($pattern, $string);
    }
}

if (!function_exists('ereg')) {
    /**
     * Case-sensitive regex match (DEPRECATED - use preg_match)
     */
    function ereg($pattern, $string, &$regs = null) {
        $pattern = '/' . str_replace('/', '\\/', $pattern) . '/';
        if (func_num_args() >= 3) {
            $result = preg_match($pattern, $string, $regs);
            return $result;
        }
        return preg_match($pattern, $string);
    }
}

if (!function_exists('ereg_replace')) {
    /**
     * Case-sensitive regex replace (DEPRECATED - use preg_replace)
     */
    function ereg_replace($pattern, $replacement, $string) {
        $pattern = '/' . str_replace('/', '\\/', $pattern) . '/';
        return preg_replace($pattern, $replacement, $string);
    }
}

if (!function_exists('eregi_replace')) {
    /**
     * Case-insensitive regex replace (DEPRECATED - use preg_replace with 'i' flag)
     */
    function eregi_replace($pattern, $replacement, $string) {
        $pattern = '/' . str_replace('/', '\\/', $pattern) . '/i';
        return preg_replace($pattern, $replacement, $string);
    }
}

if (!function_exists('split')) {
    /**
     * Split string by regex (DEPRECATED - use preg_split)
     */
    function split($pattern, $string, $limit = -1) {
        $pattern = '/' . str_replace('/', '\\/', $pattern) . '/';
        return preg_split($pattern, $string, $limit);
    }
}

// ================== REPORTS SETTINGS ==================
// Round time for reports (0 = no rounding, 15 = 15 min, 30 = 30 min, 60 = 1 hour)
$round_time = isset($round_time) ? $round_time : '0';

// Paginate Hours Worked report (yes/no)
$paginate = isset($paginate) ? $paginate : 'yes';

// Show punch-in/out details on reports (yes/no)
$show_details = isset($show_details) ? $show_details : 'yes';

// Report time range defaults
$report_start_time = isset($report_start_time) ? $report_start_time : '00:00';
$report_end_time = isset($report_end_time) ? $report_end_time : '23:59';

// Username dropdown style (yes = single dropdown, no = triple dropdown with office/group)
$username_dropdown_only = isset($username_dropdown_only) ? $username_dropdown_only : 'no';

// Display user or displayname in reports (user/display)
$user_or_display = isset($user_or_display) ? $user_or_display : 'user';

// Display IP addresses in reports (yes/no)
$display_ip = isset($display_ip) ? $display_ip : 'yes';

// Export reports to CSV (yes/no)
$export_csv = isset($export_csv) ? $export_csv : 'no';

// ================== WEATHER SETTINGS ==================
// METAR station code (e.g., KJFK for JFK Airport)
$metar = isset($metar) ? $metar : '';

// City name for weather display
$city = isset($city) ? $city : '';

// ================== DATE LINK ==================
$date_link = isset($date_link) ? $date_link : 'http://www.historychannel.com/tdih';

// NOTE: Database connection is handled in config.inc.php using PDO Database class

// Include helper functions (only if not already loaded by config.inc.php)
if (!function_exists('secsToHours')) {
    // Auto-detect path for both local and iPage structures
    $possiblePaths = [
        dirname(__DIR__) . '/src/functions.php',   // Local: public/../src/
        __DIR__ . '/src/functions.php',            // Flat: Timeclock/src/
    ];
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }
}

?>
