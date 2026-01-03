<?php
// Enable error reporting - REMOVE IN PRODUCTION
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use shared session initialization for iPage compatibility
include __DIR__ . '/session_init.php';

include 'config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Reports Login</title>\n";

$self = $_SERVER['PHP_SELF'];

if (isset($_POST['login_userid']) && (isset($_POST['login_password']))) {
    $login_userid = mysql_real_escape_string($_POST['login_userid']);
    $login_password = $_POST['login_password']; // Don't hash yet - compare with password_verify

    $query = "select empfullname, employee_passwd, reports from ".$db_prefix."employees
              where empfullname = '".$login_userid."'";
    $result = mysql_query($query);

    while ($row=mysql_fetch_array($result)) {

        $reports_username = "".$row['empfullname']."";
        $reports_password = "".$row['employee_passwd']."";
        $reports_auth = "".$row['reports']."";
    }  

    // Use password_verify for modern hashes, fall back to crypt for legacy
    $password_valid = false;
    if (isset($reports_password)) {
        if (strpos($reports_password, '$2y$') === 0) {
            // Modern bcrypt hash
            $password_valid = password_verify($login_password, $reports_password);
        } else {
            // Legacy crypt hash
            $password_valid = (crypt($login_password, 'xy') === $reports_password);
        }
    }

    if (($login_userid == @$reports_username) && $password_valid && ($reports_auth == "1")) {
        $_SESSION['valid_reports_user'] = $login_userid;
    }

}

if (isset($_SESSION['valid_reports_user'])) {
    echo "<script type='text/javascript' language='javascript'> window.location.href = 'reports/index.php';</script>";
    exit;

} else {

    // build form

    echo "<form name='auth' method='post' action='$self'>\n";
    echo "<table align=center width=210 border=0 cellpadding=7 cellspacing=1>\n";
    echo "  <tr class=right_main_text><td colspan=2 height=35 align=center valign=top class=title_underline>PHP Timeclock Reports Login</td></tr>\n";
    echo "  <tr class=right_main_text><td align=left>Username:</td><td align=right><input type='text' name='login_userid'></td></tr>\n";
    echo "  <tr class=right_main_text><td align=left>Password:</td><td align=right><input type='password' name='login_password'></td></tr>\n";
    echo "  <tr class=right_main_text><td align=center colspan=2><input type='submit' onClick='admin.php' value='Log In'></td></tr>\n";

    if (isset($login_userid)) {
        echo "  <tr class=right_main_text><td align=center colspan=2>Could not log you in. Either your username or password is incorrect.</td></tr>\n";
    }
    echo "</table>\n";
    echo "</form>\n";
    echo "<script language=\"javascript\">document.forms['auth'].login_userid.focus();</script>\n";
}

echo "</body>\n";
echo "</html>\n";
?>
