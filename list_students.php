<?php
session_start();
include 'db.php';
include 'header.php';

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if user is admin (role = 1)
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 1;

// Fetch students from DB
$result = $conn->query("SELECT id, name, subject, status FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        tr:nth-child(even){
            background-color: #f9f9f9;
        }
        .actions button {
            margin-right: 5px;
            background-color: #3498db;
            border: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions button.delete {
            background-color: #e74c3c;
        }
        /* Add New Student button styling */
        .add-student-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .add-student-btn:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📋 Student List</h2>

    <?php if ($isAdmin): ?>
        <a href="add_student.php" class="add-student-btn">➕ Add New Student</a>
    <?php endif; ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <?php if ($isAdmin): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <?php if ($isAdmin): ?>
                            <td class="actions">
                                <form method="POST" action="manage_students.php" style="display:inline-block;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="delete" onclick="return confirm('Delete this student?');">Delete</button>
                                </form>
                                <button onclick="showEditForm(<?= $row['id'] ?>)">Edit</button>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <?php if ($isAdmin): ?>
                    <tr id="edit-row-<?= $row['id'] ?>" style="display: none;">
                        <td colspan="5">
                            <form method="POST" action="manage_students.php" style="display:flex; gap:10px; align-items:center;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                                <input type="text" name="subject" value="<?= htmlspecialchars($row['subject']) ?>" required>
                                <select name="status" required>
                                    <option value="pass" <?= $row['status'] === 'pass' ? 'selected' : '' ?>>Pass</option>
                                    <option value="fail" <?= $row['status'] === 'fail' ? 'selected' : '' ?>>Fail</option>
                                </select>
                                <button type="submit">Save</button>
                                <button type="button" onclick="hideEditForm(<?= $row['id'] ?>)">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    <?php endif; ?>

                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>
</div>

<script>
function showEditForm(id) {
    document.getElementById('edit-row-' + id).style.display = 'table-row';
}
function hideEditForm(id) {
    document.getElementById('edit-row-' + id).style.display = 'none';
}
</script>

</body>
</html>
