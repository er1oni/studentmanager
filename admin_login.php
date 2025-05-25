<?php
session_start();

// DB connection - update with your credentials
$servername = "localhost";
$username_db = "root";
$password_db = "";  // your DB password
$dbname = "studentmanager"; // your database name

$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_input = trim($_POST['username'] ?? '');
    $password_input = $_POST['password'] ?? '';

    if ($username_input === '' || $password_input === '') {
        $error = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Assuming role = 1 means admin
            if (password_verify($password_input, $user['password'])) {
                if ((int)$user['role'] === 1) {
                    // Set session variables for logged in admin
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    header("Location: index.php"); // redirect to admin dashboard or main page
                    exit;
                } else {
                    $error = "Access denied: You are not an admin.";
                }
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Login</title>
<style>
  body { font-family: Arial, sans-serif; background: #f0f0f0; }
  .login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  input[type=text], input[type=password] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  button {
    width: 100%;
    background-color: #2c3e50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
  }
  button:hover {
    background-color: #34495e;
  }
  .error {
    color: red;
    margin-bottom: 10px;
    text-align: center;
  }
  h2 {
    text-align: center;
    margin-bottom: 20px;
  }
</style>
</head>
<body>

<div class="login-container">
  <h2>Admin Login</h2>
  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required autofocus />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
