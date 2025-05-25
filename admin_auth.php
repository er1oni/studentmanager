<?php
include 'auth_check.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    echo "Access denied. Admins only.";
    exit;
}
?>
