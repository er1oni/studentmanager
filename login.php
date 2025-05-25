<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = "⚠️ Please enter both username and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];  // Keep the role exactly as in DB

                header("Location: index.php");
                exit;
            } else {
                $message = "❌ Invalid password.";
            }
        } else {
            $message = "❌ User not found.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Student Manager</title>
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
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 1rem;
            text-align: center;
        }
        .message {
            background: #ffe0e0;
            padding: 10px;
            border-radius: 6px;
            color: #c00;
            margin-bottom: 1rem;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #34495e;
        }
        p {
            margin-top: 1rem;
            text-align: center;
        }
        a {
            color: #2c3e50;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔐 Login</h2>
    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <label>Username:
            <input type="text" name="username" required autocomplete="username" autofocus />
        </label>
        <label>Password:
            <input type="password" name="password" required autocomplete="current-password" />
        </label>
        <button type="submit">Login</button>
    </form>
    <p><a href="register.php">Don't have an account? Register here</a></p>
</div>
</body>
</html>
