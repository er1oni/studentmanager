<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'init.php';         // starts session safely
include 'auth_check.php';   // checks if logged in (except on login.php)
include 'db.php';           // your DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Course Manager</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f7f9fc;
    }

    .navbar {
      background-color: #2c3e50;
      color: white;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 0.5rem 1rem;
    }

    .navbar .logo {
      font-weight: bold;
      font-size: 1.5rem;
    }

    .nav-links {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      padding: 0.5rem 0.75rem;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    .nav-links a:hover {
      background-color: #34495e;
    }

    .user-info {
      font-size: 0.9rem;
      margin-top: 0.5rem;
      text-align: right;
    }

    .user-info a {
      color: #ecf0f1;
      text-decoration: none;
      margin-left: 10px;
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }
      .user-info {
        width: 100%;
        text-align: left;
      }
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="logo">🎓 Student Course Manager</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="list_students.php">Students</a>
    <a href="list_courses.php">Courses</a>
    <a href="enroll_student.php">Enroll</a>
  </div>
  <div class="user-info">
    <?php if (isset($_SESSION['username'])): ?>
      Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | 
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a> | 
      <a href="register.php">Register</a>
    <?php endif; ?>
  </div>
</header>




  <main style="padding: 20px; max-width: 900px; margin: auto;">
