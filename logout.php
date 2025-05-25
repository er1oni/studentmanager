<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Logged Out - Student Manager</title>
    <link rel="stylesheet" href="assets/styles.css" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 1rem;
        }
        p {
            margin-bottom: 1.5rem;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
        }
        a:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>👋 You have been logged out</h2>
    <p>Thank you for using the Student Course Manager.</p>
    <a href="login.php">🔐 Login Again</a>
</div>
</body>
</html>

