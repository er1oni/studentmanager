<?php
session_start();
include 'db.php';

// Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'] ?? 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Student Manager</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 20px 40px;
        }
        .header h1 {
            margin: 0;
        }
        .nav {
            background: #34495e;
            padding: 10px 40px;
        }
        .nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 40px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .logout {
            float: right;
            margin-left: 20px;
            color: #ecf0f1;
            font-size: 14px;
        }
        .logout:hover {
            text-decoration: underline;
        } */
    </style>
</head>
<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <div style="float:right; margin-top:-30px;">
        Logged in as <strong><?= htmlspecialchars($username) ?></strong> (admin)
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="nav">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_students.php">Manage Students</a>
    <a href="manage_courses.php">Manage Courses</a>
    <a href="manage_users.php">Manage Users</a>
</div>

<div class="container">
    <div class="card">
        <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
        <p>As an administrator, you have full access to manage students, courses, and users in the system.</p>
    </div>

    <div class="card">
        <h3>Quick Actions</h3>
        <ul>
            <li><a href="manage_students.php">➤ View & Edit Students</a></li>
            <li><a href="manage_courses.php">➤ Manage Courses</a></li>
            <li><a href="manage_users.php">➤ Manage Users</a></li>
        </ul>
    </div>
</div>

</body>
</html>
