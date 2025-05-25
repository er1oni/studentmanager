<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if user is admin (role = 1)
if (!isset($_SESSION['role']) || (int)$_SESSION['role'] !== 1) {
    echo "<p>You do not have permission to access this page.</p>";
    exit;
}

include 'db.php';
include 'navbar.php';

// Fetch all students
$result = $conn->query("SELECT * FROM students");

?>

<main>
    <h2>Manage Students</h2>

    <p><a href="add_student.php">➕ Add New Student</a></p>

    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f4f4f4;">
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($student = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= (int)$student['id'] ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['subject']) ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= (int)$student['id'] ?>">Edit</a> |
                        <a href="delete_student.php?id=<?= (int)$student['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php
include 'footer.php';
$conn->close();
?>
