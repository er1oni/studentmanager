<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// ✅ FIXED: Correct role check (admin role = 1)
if (!isset($_SESSION['role']) || (int)$_SESSION['role'] !== 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name']);
        $subject = trim($_POST['subject']);
        $status = $_POST['status'];

        if ($name && $subject && in_array($status, ['pass', 'fail'])) {
            $stmt = $conn->prepare("INSERT INTO students (name, subject, status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $subject, $status);
            $stmt->execute();
            $stmt->close();
        }
    }

    if ($action === 'edit') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $subject = trim($_POST['subject']);
        $status = $_POST['status'];

        if ($id > 0 && $name && $subject && in_array($status, ['pass', 'fail'])) {
            $stmt = $conn->prepare("UPDATE students SET name = ?, subject = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $subject, $status, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: manage_students.php");
    exit;
}

$students = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0; padding: 20px;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #2c3e50;
        }
        nav a.logout {
            float: right;
            color: red;
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
            margin-top: 0;
        }
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        form input[type=text], form select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        form button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #2c3e50;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }
        form button:hover {
            background-color: #34495e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        tr:nth-child(even){
            background-color: #f9f9f9;
        }
        .actions button {
            margin-right: 5px;
            background-color: #e74c3c;
            border: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions button.edit-btn {
            background-color: #2980b9;
        }
        .actions button:hover {
            opacity: 0.9;
        }
        form.inline {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        form.inline input[type=text], form.inline select {
            width: auto;
            flex: 1;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="manage_students.php">Manage Students</a>
    <a href="manage_courses.php">Manage Courses</a>
    <a href="logout.php" class="logout">Logout</a>
</nav>

<div class="container">
    <h2>Add New Student</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add" />
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required />
        
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" required />
        
        <label for="status">Status</label>
        <select name="status" id="status" required>
            <option value="pass">Pass</option>
            <option value="fail">Fail</option>
        </select>
        
        <button type="submit">Add Student</button>
    </form>

    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($student = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $student['id'] ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['subject']) ?></td>
                    <td><?= htmlspecialchars($student['status']) ?></td>
                    <td class="actions">
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="id" value="<?= $student['id'] ?>" />
                            <button type="submit" onclick="return confirm('Delete this student?');">Delete</button>
                        </form>
                        <button class="edit-btn" onclick="showEditForm(<?= $student['id'] ?>)">Edit</button>
                    </td>
                </tr>
                <tr id="edit-row-<?= $student['id'] ?>" style="display:none;">
                    <td colspan="5">
                        <form method="POST" class="inline">
                            <input type="hidden" name="action" value="edit" />
                            <input type="hidden" name="id" value="<?= $student['id'] ?>" />
                            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required />
                            <input type="text" name="subject" value="<?= htmlspecialchars($student['subject']) ?>" required />
                            <select name="status" required>
                                <option value="pass" <?= $student['status'] === 'pass' ? 'selected' : '' ?>>Pass</option>
                                <option value="fail" <?= $student['status'] === 'fail' ? 'selected' : '' ?>>Fail</option>
                            </select>
                            <button type="submit">Save</button>
                            <button type="button" onclick="hideEditForm(<?= $student['id'] ?>)">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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
