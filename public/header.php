<?php 
// header.php

// Note: functions.php and database connection are already handled in config.inc.php (Shim)

ob_start();
echo "<html>\n";

// grab the connecting ip address. //

$connecting_ip = get_ipaddress();

if (empty($connecting_ip)) {
    return FALSE;
}

// determine if connecting ip address is allowed to connect to PHP Timeclock //

if ($restrict_ips == "yes") {
    for ($x=0; $x<count($allowed_networks); $x++) {
        $is_allowed = ip_range($allowed_networks[$x], $connecting_ip);
        if (!empty($is_allowed)) {
            $allowed = TRUE;
        }
    }
    if (!isset($allowed)) {
        echo "You are not authorized to view this page."; exit;
    }
}

// Check for correct db version
global $db;
$table = "dbversion";
// Using the shimmed mysql_query for now, or direct PDO. 
// Since we have the shim in config.inc.php, this legacy code *should* work if we fix the query string syntax if needed.
// But better to verify via shim.

$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
@$rows = mysql_num_rows($result);

if ($rows == "1") {
    $dbexists = "1";
} else {
    $dbexists = "0";
}

$db_version_result = mysql_query("select * from ".$db_prefix."dbversion");
while (@$row = mysql_fetch_array($db_version_result)) {
    @$my_dbversion = "".$row["dbversion"]."";
}


// include css and timezone offset//

if (($use_client_tz == "yes") && ($use_server_tz == "yes")) {
    $use_client_tz = '$use_client_tz';
    $use_server_tz = '$use_server_tz';
    echo "Please reconfigure your config.inc.php file, you cannot have both $use_client_tz AND $use_server_tz set to 'yes'"; exit;
}

echo "<head>\n";
if ($use_client_tz == "yes") {
    if (!isset($_COOKIE['tzoffset'])) {
        include 'tzoffset.php';
        echo "<meta http-equiv='refresh' content='0;URL=timeclock.php'>\n";
    }
}

echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />
<link rel='stylesheet' type='text/css' media='print' href='css/print.css' />
<link rel='shortcut icon' href='images/favicon.ico' type='image/x-icon'>
<link rel='icon' href='images/favicon.ico' type='image/x-icon'>
</head>\n";

// set refresh rate for each page //  

if ($refresh != "none") {
    echo "<meta http-equiv='refresh' content=\"$refresh;URL=timeclock.php\">\n";
    echo "<script language=\"javascript\" src=\"js/pnguin_timeclock.js\"></script>\n";
    echo "</head>\n";
}

if ($use_client_tz == "yes") {
    if (isset($_COOKIE['tzoffset'])) {
        $tzo = $_COOKIE['tzoffset'];
        settype($tzo, "integer");
        $tzo = $tzo * 60;
    }
} 
elseif ($use_server_tz == "yes") {
    $tzo = date('Z');
} else {
    $tzo = "1";
}
?>
<body>
