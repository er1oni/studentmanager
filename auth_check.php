<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['user_id']) && $current_page !== 'login.php' && $current_page !== 'register.php') {
    header("Location: login.php");
    exit;
}
?>
