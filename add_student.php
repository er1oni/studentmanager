<?php
include 'init.php';       // starts session safely
include 'auth_check.php'; // checks if logged in (except on login.php)
include 'db.php';

// Restrict access to admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect non-admin users to students list or show an error
    header("Location: list_students.php");
    exit;
}

include 'header.php'; // header and navbar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email     = $conn->real_escape_string($_POST['email']);
    $course    = $conn->real_escape_string($_POST['course']);

    $conn->query("INSERT INTO students (full_name, email, course) VALUES ('$full_name', '$email', '$course')");
    header("Location: list_students.php");
    exit;
}
?>

<div class="container" style="max-width: 600px; margin: 2rem auto;">
    <h2>➕ Add New Student</h2>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <input type="text" name="course" placeholder="Course" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <button type="submit" style="padding: 10px 20px; background-color: #2980b9; color: white; border: none; border-radius: 5px;">Add Student</button>
    </form>
    <a href="list_students.php" class="back-link" style="display: inline-block; margin-top: 1rem;">⬅ Back to Student List</a>
</div>

<?php include 'footer.php'; ?>

