<?php
$servername = "localhost";
$username_db = "root";      // your DB username
$password_db = "";          // your DB password
$dbname = "studentmanager"; // your DB name

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = 'erjon';
$password_plain = 'erjon';
$role = 1; // admin role

// Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "User 'erjon' already exists.";
} else {
    $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Admin user 'erjon' created successfully!";
    } else {
        echo "Error creating user: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
