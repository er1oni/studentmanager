<?php
session_start();
include 'db.php';
include 'header.php';

// Only allow admins (role == 1)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: list_students.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $status = $conn->real_escape_string($_POST['status']); // e.g. pass/fail

    $sql = "INSERT INTO students (name, subject, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $subject, $status);
    $stmt->execute();
    $stmt->close();

    header("Location: list_students.php");
    exit;
}
?>

<div class="container" style="max-width: 600px; margin: 2rem auto;">
    <h2>➕ Add New Student</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <input type="text" name="subject" placeholder="Subject" required style="width: 100%; padding: 8px; margin: 8px 0;">
        <select name="status" required style="width: 100%; padding: 8px; margin: 8px 0;">
            <option value="">Select Status</option>
            <option value="pass">Pass</option>
            <option value="fail">Fail</option>
        </select>
        <button type="submit" style="padding: 10px 20px; background-color: #2980b9; color: white; border: none; border-radius: 5px;">Add Student</button>
    </form>
    <a href="list_students.php" style="display: inline-block; margin-top: 1rem;">⬅ Back to Student List</a>
</div>

<?php include 'footer.php'; ?>
