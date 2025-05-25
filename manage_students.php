<?php
session_start();
include 'db.php';
include 'header.php';

// Restrict access to admins only (assuming role = 1 means admin)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: list_students.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $course    = $conn->real_escape_string($_POST['course']);

    // Insert student without email column
    $conn->query("INSERT INTO students (full_name, course) VALUES ('$full_name', '$course')");
    
    header("Location: list_students.php");
    exit;
}
?>

<div class="container" style="max-width: 600px; margin: 2rem auto;">
    <h2>➕ Add New Student</h2>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <input type="text" name="course" placeholder="Course" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <button type="submit" style="padding: 10px 20px; background-color: #2980b9; color: white; border: none; border-radius: 5px;">Add Student</button>
    </form>
    <a href="list_students.php" style="display: inline-block; margin-top: 1rem;">⬅ Back to Student List</a>
</div>

<?php include 'footer.php'; ?>
