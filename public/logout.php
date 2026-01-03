<?php
// Use shared session initialization for iPage compatibility
include __DIR__ . '/session_init.php';

if (isset($_SESSION['valid_user'])) {unset($_SESSION['valid_user']);}
if (isset($_SESSION['valid_reports_user'])) {unset($_SESSION['valid_reports_user']);}
if (isset($_SESSION['time_admin_valid_user'])) {unset($_SESSION['time_admin_valid_user']);}

session_destroy();

echo "<script type='text/javascript' language='javascript'> window.location.href = 'index.php';</script>";
?>  
